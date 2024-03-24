<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductGroup extends Model
{
    use HasFactory;

    protected $table = 'product_group';

    public function products() {
        return $this->belongsToMany(Product::class, 'product_to_group', 'group_id', 'product_id');
    }
}
