<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use RecentlyViewed\Models\Contracts\Viewable;
use RecentlyViewed\Models\Traits\CanBeViewed;
use DB;

class Product extends Model implements Viewable
{
    use HasFactory;
    use CanBeViewed;

    protected $table = 'product';

    // Relationshops
    public function productDescription() {
        return $this->belongsTo(ProductDescription::class, 'id', 'product_id');
    }

    public function stockStatus() {
        return $this->belongsTo(ProductStatus::class, 'stock_status_id', 'id');
    }

    public function toCategory() {
        return $this->belongsToMany(ProductCategory::class, 'product_to_category', 'product_id', 'category_id');
    }

    public function toGroup() {
        return $this->belongsToMany(ProductGroup::class, 'product_to_group', 'product_id', 'group_id');
    }

    public function images() {
        return $this->hasMany(ProductImage::class, 'product_id', 'id');
    }

    public function attribute() {
        return $this->hasMany(Attribute::class, 'product_id', 'id');
    }

    public function pivot() {
        return $this->belongsTo(ProductToCategory::class, 'id', 'product_id');
    }

    // Functions
    public function getProducts($sortKey, $sortValue, $limit) {
        return DB::table('product_to_category as ptc')
        ->select('p.id as p_id', 'p.image as product_image', 'pd.name as product_name', 'pd.slug as product_slug', 'p.price as product_price', 'pc.slug as category_slug')
        ->join('product as p', 'ptc.product_id', '=', 'p.id')
        ->join('product_description as pd', 'ptc.product_id', '=', 'pd.product_id')
        ->join('product_category as pc', 'ptc.category_id', '=', 'pc.id')
        ->orderBy('p.'.$sortKey, $sortValue)
        ->paginate($limit);
    }
    
    public function getProductByCategoryId($categories, $sortKey, $sortValue, $limit) {
        return DB::table('product_to_category as ptc')
        ->select('p.id as p_id', 'p.image as product_image', 'pd.name as product_name', 'pd.slug as product_slug', 'p.price as product_price', 'pc.slug as category_slug')
        ->join('product as p', 'ptc.product_id', '=', 'p.id')
        ->join('product_description as pd', 'ptc.product_id', '=', 'pd.product_id')
        ->join('product_category as pc', 'ptc.category_id', '=', 'pc.id')
        ->whereIn('category_id', $categories)
        ->orderBy('p.'.$sortKey, $sortValue)
        ->paginate($limit);
    }

    public function getProductByCategoryIdRandom($categories, $limit) {
        return DB::table('product_to_category as ptc')
        ->select('p.image as product_image', 'pd.name as product_name', 'pd.slug as product_slug', 'p.price as product_price', 'pc.slug as category_slug')
        ->join('product as p', 'ptc.product_id', '=', 'p.id')
        ->join('product_description as pd', 'ptc.product_id', '=', 'pd.product_id')
        ->join('product_category as pc', 'ptc.category_id', '=', 'pc.id')
        ->whereIn('category_id', $categories)
        ->inRandomOrder()
        ->limit($limit)
        ->get();
    }

    public function totalSoldByProductId($pId) {
        return DB::table('invoice_detail as invd')
        ->join('invoice as inv', 'inv.id', '=', 'invd.invoice_id')
        ->where('status', 3)
        ->where('product_id', $pId)
        ->sum('product_qty');
    }
}
