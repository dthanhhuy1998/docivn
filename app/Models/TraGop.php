<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TraGop extends Model
{
    use HasFactory;

    protected $table = 'tra_gop';

    public function province() {
        return $this->belongsTo(Province::class, 'province_id', 'matp');
    }
}
