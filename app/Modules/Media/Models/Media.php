<?php

namespace App\Modules\Media\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Media extends Model
{
    use SoftDeletes;

    protected $table = 'media';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'related_type',
        'related_id',
        'collection_name',
        'type',
        'disk',
        'directory',
        'path',
        'file_name',
        'original_name',
        'mime_type',
        'extension',
        'size',
        'hash',
        'width',
        'height',
        'duration',
        'sort_order',
        'is_primary',
        'status',
        'metadata',
        'created_by',
    ];

    protected $casts = [
        'metadata' => 'array',
        'is_primary' => 'boolean',
        'size' => 'integer',
        'width' => 'integer',
        'height' => 'integer',
        'duration' => 'integer',
        'sort_order' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function (Media $media) {
            if (empty($media->id)) {
                $media->id = (string) Str::uuid();
            }
        });
    }
}
