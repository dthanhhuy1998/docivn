<?php

namespace App\Modules\Media\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Log;

class FilePondUploadController extends Controller
{
    private string $disk = 'local';

    private string $tmpPath = 'filepond/tmp';

    public function process(Request $request)
    {
        $uploadLength = (int) $request->header('Upload-Length');
        $uploadName = $request->header('Upload-Name');

        // Validate
        abort_if($uploadLength <= 0, 422, 'Invalid upload length');
        abort_if($uploadLength > 2000 * 1024 * 1024, 422, 'File too large');

        $transferId = (string) Str::uuid();

        $dir = "{$this->tmpPath}/{$transferId}";

        Storage::disk($this->disk)->makeDirectory($dir);

        Storage::disk($this->disk)->put("{$dir}/meta.json", json_encode([
            'transfer_id' => $transferId,
            'upload_name' => $uploadName,
            'upload_length' => $uploadLength,
            'created_at' => now()->toDateTimeString(),
            'user_id' => auth()->id(),
        ]));

        Storage::disk($this->disk)->put("{$dir}/file.part", '');

        return response($transferId, 200)
            ->header('Content-Type', 'text/plain');
    }

    public function head(string $transferId)
    {
        $this->validateTransferId($transferId);

        $path = "{$this->tmpPath}/{$transferId}/file.part";

        abort_unless(Storage::disk($this->disk)->exists($path), 404);

        $offset = Storage::disk($this->disk)->size($path);

        return response('', 200)
            ->header('Upload-Offset', $offset);
    }

    public function patch(Request $request, string $transferId)
    {
        $this->validateTransferId($transferId);

        $dir = "{$this->tmpPath}/{$transferId}";
        $partPath = "{$dir}/file.part";
        $metaPath = "{$dir}/meta.json";

        abort_unless(Storage::disk($this->disk)->exists($partPath), 404);

        $uploadName = $request->header('Upload-Name');

        if ($uploadName) {
            $uploadName = urldecode($uploadName);

            $meta = json_decode(Storage::disk($this->disk)->get($metaPath), true) ?: [];

            $meta['upload_name'] = $meta['upload_name'] ?? $uploadName;

            Storage::disk($this->disk)->put(
                $metaPath,
                json_encode($meta, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
            );
        }

        $absolutePath = Storage::disk($this->disk)->path($partPath);

        $offset = (int) $request->header('Upload-Offset');
        $uploadLength = (int) $request->header('Upload-Length');

        $currentSize = file_exists($absolutePath) ? filesize($absolutePath) : 0;

        if ($offset !== $currentSize) {
            return response('Invalid offset', 409)
                ->header('Upload-Offset', $currentSize);
        }

        $chunk = $request->getContent();

        $handle = fopen($absolutePath, 'c+b');
        fseek($handle, $offset);
        fwrite($handle, $chunk);
        fclose($handle);

        clearstatcache(true, $absolutePath);

        $newSize = filesize($absolutePath);

        if ($newSize >= $uploadLength) {
            $meta = json_decode(Storage::disk($this->disk)->get($metaPath), true) ?: [];

            $meta['completed'] = true;
            $meta['completed_at'] = now()->toDateTimeString();

            Storage::disk($this->disk)->put(
                $metaPath,
                json_encode($meta, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
            );
        }

        return response('', 204)
            ->header('Upload-Offset', $newSize);
    }

    public function revert(Request $request)
    {
        $transferId = trim($request->getContent());

        $this->validateTransferId($transferId);

        Storage::disk($this->disk)->deleteDirectory("{$this->tmpPath}/{$transferId}");

        return response('', 200);
    }

    private function validateTransferId(string $transferId): void
    {
        abort_unless(Str::isUuid($transferId), 400, 'Invalid transfer id');
    }
}
