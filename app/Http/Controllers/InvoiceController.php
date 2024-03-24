<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

// Models
use App\Models\Invoice;

class InvoiceController extends Controller
{
    protected $invoiceModel = '';

    public function __construct() {
        $this->invoiceModel = new Invoice();
    }

    public function getList() {
        $invoices = Invoice::orderBy('created_at', 'desc')->get();

        $headingTitle = heading('Danh sách đơn hàng');
        $pageTitle = 'Danh sách đơn hàng';

        return view('admin.pages.invoice.list',
            compact('headingTitle', 'pageTitle', 'invoices')
        );
    }

    public function getInvoiceDetail($invoiceId) {
        $invoice = Invoice::findOrFail($invoiceId);

        $headingTitle = heading('Thông tin đơn hàng');
        $pageTitle = 'Thông tin đơn hàng';

        return view('admin.pages.invoice.detail',
            compact('headingTitle', 'pageTitle', 'invoice')
        );
    }

    public function toggleStatus(Request $request) {
        $invoiceId = $request->invoice_id;
        $status = $request->status;
        $excute = $this->invoiceModel->toggleStatus($invoiceId, $status);

        if($excute) {
            return response()->json([
                'status'    => 200,
                'message'   => 'success',
                'route'     => route('admin.invoice.getInvoiceDetail', $invoiceId),
            ]);
        } else {
            return response()->json([
                'status'    => 'E0',
                'message'   => 'error'
            ]);
        }

    }

    public function delete($invoiceId) {
        $excute = $this->invoiceModel->destroyInvoice($invoiceId);
        if($excute) {
            return redirect()->route('admin.invoice.getList')->with('success_msg', 'Xóa đơn hàng thành công');
        }
    }
}
