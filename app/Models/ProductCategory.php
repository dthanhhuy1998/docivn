<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;

    protected $table = 'product_category';

    // Relationships
    public function products() {
        return $this->belongsToMany(Product::class, 'product_to_category', 'category_id', 'product_id');
    }

    public function toProductPivot() {
        return $this->hasMany(ProductToCategory::class, 'category_id', 'id');
    }

    //   get multi category level // with = đệ quy
    public function subCategories() {
        return $this->hasMany(ProductCategory::class, 'parent_id', 'id')->with('subCategories');
    }

    // Functions
    public function categories($parentId) {
        $parent = ProductCategory::select('id')->where('id', $parentId)->first();
        $child = ProductCategory::select('id')->where('parent_id', $parent->id)->get();
        // save list category to array
        $categories = array($parent->id);
        if(count($child) > 0) {
            foreach($child as $c) {
                array_push($categories, $c->id);
            }
        }
        return $categories;
    }
}
