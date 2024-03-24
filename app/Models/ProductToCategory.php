<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * cái này dùng pivot ấy
 */
class ProductToCategory extends Model
{
    use HasFactory;

    protected $table = 'product_to_category';

    public function products() {
        return $this->hasMany(Product::class, 'id', 'product_id');
    }

    public function product() {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function category() {
        return $this->belongsTo(ProductCategory::class, 'category_id', 'id');
    }
}
