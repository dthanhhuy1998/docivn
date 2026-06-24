<?php

namespace App\Modules\Media\Repositories;

use App\Modules\Media\Models\Media;
use Illuminate\Database\Eloquent\Model;

class MediaRepository
{
    public function findById(string $id, array $columns = ['*'])
    {
        return Media::query()->select($columns)->find($id);
    }

    public function create(array $data)
    {
        return Media::create($data);
    }

    public function createMany(array $items)
    {
        $media = [];

        foreach ($items as $item) {
            $media[] = $this->create($item);
        }

        return $media;
    }

    public function getByRelated(Model $related, ?string $collectionName = null, ?string $type = null)
    {
        return Media::query()
            ->where('related_type', get_class($related))
            ->where('related_id', $related->getKey())
            ->when($collectionName, function ($query) use ($collectionName) {
                $query->where('collection_name', $collectionName);
            })
            ->when($type, function ($query) use ($type) {
                $query->where('type', $type);
            })
            ->orderBy('sort_order', 'asc')
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public function findByRelated(Model $related, string $mediaId, ?string $collectionName = null, ?string $type = null)
    {
        return Media::query()
            ->where('id', $mediaId)
            ->where('related_type', get_class($related))
            ->where('related_id', $related->getKey())
            ->when($collectionName, function ($query) use ($collectionName) {
                $query->where('collection_name', $collectionName);
            })
            ->when($type, function ($query) use ($type) {
                $query->where('type', $type);
            })
            ->first();
    }

    public function getMaxSortOrder(Model $related, ?string $collectionName = null)
    {
        return Media::query()
            ->where('related_type', get_class($related))
            ->where('related_id', $related->getKey())
            ->when($collectionName, function ($query) use ($collectionName) {
                $query->where('collection_name', $collectionName);
            })
            ->max('sort_order');
    }

    public function delete(Media $media)
    {
        return $media->delete();
    }
}
