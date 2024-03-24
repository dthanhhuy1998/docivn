<?php

namespace App\Models;
use DB;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'invoice';

    // Relationships
    public function detail() {
        return $this->hasMany(InvoiceDetail::class, 'invoice_id', 'id');
    }

    public function province() {
        return $this->belongsTo(Province::class, 'province_id', 'matp');
    }

    public function district() {
        return $this->belongsTo(District::class, 'district_id', 'maqh');
    }

    public function ward() {
        return $this->belongsTo(Ward::class, 'ward_id', 'xaid');
    }

    public function customer() {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function getStatus() {
        return $this->belongsTo(Status::class, 'status', 'id');
    }

    // Functions
    public function toggleStatus($id, $status) {
        DB::beginTransaction();
        try {
            DB::table('invoice')
            ->where('id', $id)
            ->update(['status' => $status]);
            
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }

        return true;
    }

    public function destroyInvoice($invoiceId) {
        DB::beginTransaction();
        try {
            $excute = DB::table('invoice_detail')->where('invoice_id', $invoiceId)->delete();
            if($excute) {
                DB::table('invoice')->where('id', $invoiceId)->delete();
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }

        return true;
    }
}
