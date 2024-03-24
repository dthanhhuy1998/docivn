<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerAddress extends Model
{
    use HasFactory;

    protected $table = 'customer_address';

    public function province() {
        return $this->belongsTo(Province::class, 'province_id', 'matp');
    }

    public function district() {
        return $this->belongsTo(District::class, 'district_id', 'maqh');
    }

    public function ward() {
        return $this->belongsTo(Ward::class, 'ward_id', 'xaid');
    }
}
