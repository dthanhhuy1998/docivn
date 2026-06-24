<?php

namespace App\Modules\Media\Services;

use App\Modules\Media\Repositories\MediaRepository;
use Illuminate\Database\Eloquent\Model;
use Storage;
use Str;

class MediaService 
{
    private const PRODUCT_VIDEO_COLLECTION = 'product_videos';

    public function __construct(
        private MediaRepository $mediaRepository
    ) {}

    public function uploadFilePondFiles($transferIds, $uploadPath, $disk = 'local')
    {
        if (! $transferIds) return [];
        
        $files = [];

        foreach($transferIds as $transferId) {
            abort_unless(Str::isUuid($transferId), 422, 'Invalid file');

            $tmpDir = "filepond/tmp/{$transferId}";
            $partPath = "{$tmpDir}/file.part";
            $metaPath = "{$tmpDir}/meta.json";

            abort_unless(Storage::disk($disk)->exists($partPath), 422, 'File not found');
            abort_unless(Storage::disk($disk)->exists($metaPath), 422, 'File metadata not found');

            $meta = json_decode(Storage::disk($disk)->get($metaPath), true);
            
            abort_if(empty($meta['completed']), 422, 'Upload not completed');

            $originalName = urldecode($meta['upload_name']) ?? 'file';
            $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

            $finalFileName = Str::uuid() . '.' . $extension;
            $finalPath = "{$uploadPath}/{$finalFileName}";

            $fileName = Str::uuid() . ($extension ? ".{$extension}" : '');

            $targetPath = 'uploads/' . now()->format('Y/m') . '/' . $fileName;

            $stream = fopen(Storage::disk($disk)->path($partPath), 'r');

            Storage::disk('public')->put($targetPath, $stream);

            if (is_resource($stream)) {
                fclose($stream);
            }

            Storage::disk($disk)->deleteDirectory($tmpDir);

            $files[] = $targetPath;
        }

        return $files;
    }

    public function storeProductVideosFromFilePond($transferIds, Model $product, $thumbnailTransferIds = [])
    {
        return $this->storeFilePondMedia($transferIds, $product, [
            'type' => 'video',
            'collection_name' => self::PRODUCT_VIDEO_COLLECTION,
            'directory' => 'product-videos/' . now()->format('Y/m'),
            'thumbnail_transfer_ids' => $thumbnailTransferIds,
            'thumbnail_directory' => 'product-video-thumbnails/' . now()->format('Y/m'),
        ]);
    }

    public function getProductVideos(Model $product)
    {
        return $this->mediaRepository->getByRelated($product, self::PRODUCT_VIDEO_COLLECTION, 'video');
    }

    public function deleteProductVideo(Model $product, string $mediaId): bool
    {
        $media = $this->mediaRepository->findByRelated($product, $mediaId, self::PRODUCT_VIDEO_COLLECTION, 'video');

        abort_unless($media, 404, 'Video not found');

        Storage::disk($media->disk)->delete($media->path);

        $metadata = $media->metadata ?: [];
        $thumbnail = $metadata['thumbnail'] ?? [];

        if (!empty($thumbnail['disk']) && !empty($thumbnail['path'])) {
            Storage::disk($thumbnail['disk'])->delete($thumbnail['path']);
        }

        return (bool) $this->mediaRepository->delete($media);
    }

    public function storeFilePondMedia($transferIds, Model $related, array $options = [])
    {
        if (! $transferIds) return [];

        $transferIds = is_array($transferIds) ? $transferIds : [$transferIds];
        $sourceDisk = $options['source_disk'] ?? 'local';
        $targetDisk = $options['target_disk'] ?? 'public';
        $directory = trim($options['directory'] ?? 'uploads/' . now()->format('Y/m'), '/');
        $type = $options['type'] ?? 'file';
        $collectionName = $options['collection_name'] ?? null;
        $thumbnailTransferIds = $options['thumbnail_transfer_ids'] ?? [];
        $thumbnailTransferIds = is_array($thumbnailTransferIds) ? $thumbnailTransferIds : [$thumbnailTransferIds];
        $thumbnailDirectory = trim($options['thumbnail_directory'] ?? $directory . '/thumbnails', '/');
        $sortOrder = (int) $this->mediaRepository->getMaxSortOrder($related, $collectionName) + 1;

        $mediaItems = [];

        foreach($transferIds as $index => $transferId) {
            $file = $this->moveFilePondTransfer($transferId, $directory, $sourceDisk, $targetDisk);
            $thumbnail = null;
            $thumbnailTransferId = $thumbnailTransferIds[$index] ?? null;

            if ($thumbnailTransferId) {
                $thumbnail = $this->moveFilePondTransfer($thumbnailTransferId, $thumbnailDirectory, $sourceDisk, $targetDisk);
            }

            $media = $this->mediaRepository->create([
                'related_type' => get_class($related),
                'related_id' => $related->getKey(),
                'collection_name' => $collectionName,
                'type' => $type,
                'disk' => $targetDisk,
                'directory' => $directory,
                'path' => $file['path'],
                'file_name' => $file['file_name'],
                'original_name' => $file['original_name'],
                'mime_type' => $file['mime_type'],
                'extension' => $file['extension'],
                'size' => $file['size'],
                'hash' => $file['hash'],
                'sort_order' => $sortOrder + $index,
                'is_primary' => false,
                'status' => 'ready',
                'metadata' => [
                    'transfer_id' => $transferId,
                    'upload_length' => $file['meta']['upload_length'] ?? null,
                    'uploaded_at' => $file['meta']['completed_at'] ?? null,
                    'thumbnail' => $thumbnail ? [
                        'disk' => $targetDisk,
                        'directory' => $thumbnailDirectory,
                        'path' => $thumbnail['path'],
                        'file_name' => $thumbnail['file_name'],
                        'original_name' => $thumbnail['original_name'],
                        'mime_type' => $thumbnail['mime_type'],
                        'extension' => $thumbnail['extension'],
                        'size' => $thumbnail['size'],
                    ] : null,
                ],
                'created_by' => auth()->id(),
            ]);

            $mediaItems[] = $media;
        }

        return $mediaItems;
    }

    private function moveFilePondTransfer(string $transferId, string $directory, string $sourceDisk, string $targetDisk): array
    {
        abort_unless(Str::isUuid($transferId), 422, 'Invalid file');

        $tmpDir = "filepond/tmp/{$transferId}";
        $partPath = "{$tmpDir}/file.part";
        $metaPath = "{$tmpDir}/meta.json";

        abort_unless(Storage::disk($sourceDisk)->exists($partPath), 422, 'File not found');
        abort_unless(Storage::disk($sourceDisk)->exists($metaPath), 422, 'File metadata not found');

        $meta = json_decode(Storage::disk($sourceDisk)->get($metaPath), true) ?: [];

        abort_if(empty($meta['completed']), 422, 'Upload not completed');

        $originalName = urldecode($meta['upload_name'] ?? 'file');
        $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
        $fileName = (string) Str::uuid() . ($extension ? ".{$extension}" : '');
        $targetPath = "{$directory}/{$fileName}";
        $sourcePath = Storage::disk($sourceDisk)->path($partPath);

        $stream = fopen($sourcePath, 'r');
        Storage::disk($targetDisk)->put($targetPath, $stream);

        if (is_resource($stream)) {
            fclose($stream);
        }

        $file = [
            'path' => $targetPath,
            'file_name' => $fileName,
            'original_name' => $originalName,
            'mime_type' => Storage::disk($sourceDisk)->mimeType($partPath),
            'extension' => $extension,
            'size' => Storage::disk($sourceDisk)->size($partPath),
            'hash' => hash_file('sha256', $sourcePath),
            'meta' => $meta,
        ];

        Storage::disk($sourceDisk)->deleteDirectory($tmpDir);

        return $file;
    }
}
