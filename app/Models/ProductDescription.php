<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDescription extends Model
{
    use HasFactory;

    protected $table = 'product_description';

    public function product() {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function productToGroup() {
        return $this->hasMany(ProductToGroup::class, 'product_id', 'product_id');
    }
}
