<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceDetail extends Model
{
    use HasFactory;

    protected $table = 'invoice_detail';

    // Relationships
    public function product() {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
