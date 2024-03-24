<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductToGroup extends Model
{
    use HasFactory;

    protected $table = 'product_to_group';

    public function group() {
        return $this->belongsTo(ProductGroup::class, 'group_id', 'id');
    }

    public function product() {
        return $this->hasMany(Product::class, 'id', 'product_id');
    }
}
