<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Storage;
use Hash;
use URL;

// Models
use App\Models\Customer;
use App\Models\Province;
use App\Models\CustomerAddress;
use App\Models\Config;
use App\Models\Invoice;
use App\Models\InvoiceDetail;

class ClientController extends Controller
{
    protected $configModel = '';
    protected $invoiceModel = '';

    public function __construct() {
        $this->configModel = new Config();
        $this->invoiceModel = new Invoice();
    }

    public function index() {
        $userLogin = '';
        if(session()->has('userLogin')) {
            $userLogin = Customer::where('email', session('userLogin'))->first();
        }

        // SEO
        $headingTitle = 'Thông tin tài khoản';
        $pageTitle = 'Thông tin tài khoản';
        $description = $this->configModel->getConfig('meta_description');
        $keyword = $this->configModel->getConfig('meta_keyword');
        $logo = asset('storage/app/'.$this->configModel->getConfig('logo'));
        $this->seo_tools($headingTitle, $description, $keyword, $logo, URL::current());

        return view('catalog.pages.client.index',
            compact('headingTitle', 'pageTitle', 'userLogin')
        );
    }

    public function postEditInfo(Request $request) {
        $validated = $request->validate([
            'tentaikhoan' => 'required',
        ],[
            'sdt.required'    => 'Họ không được bỏ trống!',
        ]);

        DB::beginTransaction();
        try {
            $customer = DB::table('customer')
            ->where('id', $request->id_taikhoan)
            ->update([
                'firstname'     => trim($request->tentaikhoan),
                'telephone'     => trim($request->sdt),
                'address'       => trim($request->diachi),
                'updated_at'    => date('Y-m-d H:i:s')
            ]);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }

        return response()->json([
            'status'    => 200,
            'message'   => 'Cập nhật tài khoản thành công',
        ]);
    }

    public function getResetPassword() {
        $userLogin = '';
        if(session()->has('userLogin')) {
            $userLogin = Customer::where('email', session('userLogin'))->first();
        }

        // SEO
        $headingTitle = 'Đổi mật khẩu';
        $pageTitle = 'Đổi mật khẩu';
        $description = $this->configModel->getConfig('meta_description');
        $keyword = $this->configModel->getConfig('meta_keyword');
        $logo = asset('storage/app/'.$this->configModel->getConfig('logo'));
        $this->seo_tools($headingTitle, $description, $keyword, $logo, URL::current());

        return view('catalog.pages.client.reset-password',
            compact('headingTitle', 'pageTitle', 'userLogin')
        );
    }

    public function postResetPassword(Request $request) {
        $validated = $request->validate([
            'matkhau_old'   => 'required',
            'matkhau'       => 'required',
            'replymatkhau'  => 'required',
        ],[
            'matkhau_old.required'  => 'Vui lòng nhập mật khẩu cũ!',
            'matkhau.required'      => 'Vui lòng nhập mật khẩu mới!',
            'replymatkhau.required' => 'Vui lòng xác nhận mật khẩu mới!',
        ]);

        if(trim($request->matkhau) == trim($request->replymatkhau)) {
            $customer = Customer::findOrFail($request->id_taikhoan);
            if(Hash::check($request->matkhau_old, $customer->password)) {
                // update password
                DB::beginTransaction();
                try {
                    $customer = DB::table('customer')
                    ->where('id', $request->id_taikhoan)
                    ->update([
                        'password'      => Hash::make(trim($request->matkhau)),
                        'show_password' => trim($request->matkhau),
                        'updated_at'    => date('Y-m-d H:i:s')
                    ]);

                    DB::commit();
                } catch (Exception $e) {
                    DB::rollBack();
                    throw new Exception($e->getMessage());
                }

                // destroy session user login
                session()->forget(['userLogin']);

                // redirect to client login page
                return response()->json([
                    'status'    => 200,
                    'message'   => 'Đổi mật khẩu thành công. Vui lòng đăng nhập lại!',
                    'route'     => route('catalog.clientLogin')
                ]);
            } else {
                return response()->json([
                    'status'    => 'E0',
                    'message'   => 'Mật khẩu cũ không đúng!',
                ]);
            }
        } else {
            return response()->json([
                'status'    => 'E0',
                'message'   => 'Mật khẩu mới không giống nhau!',
            ]);
        }
    }

    public function getInvoice() {
        if(session()->exists('userLogin')) {
            $customer = DB::table('customer')->select('id')->where('email', session()->get('userLogin'))->first();
            $invoices = Invoice::select('id', 'status', 'created_at')->where('customer_id', $customer->id)->get();
            // SEO
            $headingTitle = 'Đơn hàng của tôi';
            $pageTitle = 'Đơn hàng của tôi';
            $description = $this->configModel->getConfig('meta_description');
            $keyword = $this->configModel->getConfig('meta_keyword');
            $logo = asset('storage/app/'.$this->configModel->getConfig('logo'));
            $this->seo_tools($headingTitle, $description, $keyword, $logo, URL::current());

            return view('catalog.pages.client.invoice',
                compact('headingTitle', 'pageTitle', 'invoices')
            );
        } else {
            return redirect()->route('catalog.homepage');
        }
    }

    public function getInvoiceDetail($invoiceId) {
        if(session()->exists('userLogin')) {
            $invoice = Invoice::select('id', 'customer_name', 'customer_phone', 'customer_email', 'address', 'created_at', 'status')
            ->where('id', $invoiceId)
            ->first();
            $details = InvoiceDetail::select('product_id','product_price', 'product_qty')
            ->where('invoice_id', $invoiceId)->get();

            // SEO
            $headingTitle = 'Đơn hàng HD'.$invoice->id;
            $pageTitle = 'Đơn hàng HD'.$invoice->id;
            $description = $this->configModel->getConfig('meta_description');
            $keyword = $this->configModel->getConfig('meta_keyword');
            $favicon = asset('storage/app/'.$this->configModel->getConfig('favicon'));
            $logo = asset('storage/app/'.$this->configModel->getConfig('logo'));
            $phone = $this->configModel->getConfig('phone');
            $gmail = $this->configModel->getConfig('gmail');
            $this->seo_tools($headingTitle, $description, $keyword, $logo, URL::current());

            return view('catalog.pages.client.invoice_detail',
                compact('headingTitle', 'pageTitle', 'favicon', 'logo', 'phone', 'gmail', 'invoice', 'details')
            );
        } else {
            return redirect()->route('catalog.homepage');
        }
    }

    public function postCancelInvoice(Request $request) {
        // toggle status
        $excute = $this->invoiceModel->toggleStatus($request->id_hoadon, 4);

        if($excute) {
            return response()->json([
                'status'    => 200,
                'message'   => 'success',
            ]);
        } else {
            return response()->json([
                'status'    => 'E0',
                'message'   => 'error',
            ]);
        }
    }

    public function getAddress() {
        if(session()->has('userLogin')) {
            $userLogin = Customer::where('email', session('userLogin'))->first();
        }

        $provinces = Province::orderBy('name', 'asc')->get();

        $headingTitle = 'Địa chỉ nhận hàng';
        $pageTitle = 'Địa chỉ nhận hàng';

        return view('catalog.pages.client.address',
            compact('headingTitle', 'pageTitle', 'userLogin', 'provinces')
        );
    }

    public function addAddress(Request $request) {
        // get customer id
        $customer = Customer::where('email', session()->get('userLogin'))->first();
        // add new address
        DB::table('customer_address')->insert([
            'customer_id'       => $customer->id,
            'customer_name'     => $request->name,
            'customer_phone'    => $request->phone,
            'province_id'       => $request->province,
            'district_id'       => $request->district,
            'ward_id'           => $request->ward,
            'address'           => $request->address,
            'status'            => 1,
            'created_at'        => date('Y-m-d'),
            'updated_at'        => date('Y-m-d'),
        ]);

        return response()->json([
            'status'    => 200,
            'data'      => 'sucess'
        ]);
    }

    public function addressList(Request $request) {
        // get customer id
        $customer = Customer::where('email', session()->get('userLogin'))->first();

        $addressLists = CustomerAddress::where('customer_id', $customer->id)->get();
        $data = '';
        foreach($addressLists as $item) {
            $data .= '
            <div class="addressBox__item">
                <div class="partition"></div>
                <div class="addressBox__item-row">
                    <div class="title">Họ tên</div>
                    <div class="content">'. $item->customer_name .'</div>
                </div>
                <div class="addressBox__item-row">
                    <div class="title">Số điện thoại</div>
                    <div class="content">'. $item->customer_phone .'</div>
                </div>
                <div class="addressBox__item-row">
                    <div class="title">Địa chỉ</div>
                    <div class="content">'. $item->address .', xã '. $item->ward->name .', '. $item->district->name .', '. $item->province->name .'</div>
                </div>
                <span class="label-address active"><i class="fa fa-check"></i> Mặc định</span>
                <div class="label-group">
                    <a href="'. route('client.address.getEdit', [$item->id]) .'">Chỉnh sửa</a>
                    <a href="#" data-id="'. $item->id .'" class="delete_address">Xóa</a>
                </div>
            </div>
            ';
        }

        return response()->json([
            'status'    => 200,
            'data'      => $data
        ]);
    }

    public function deleteAddress(Request $request) {
        DB::table('customer_address')->where('id', $request->address_id)->delete();

        return response()->json([
            'status'    => 200,
            'data'      => 'success'
        ]);
    }

    public function getEdit($addressId) {
        if(session()->has('userLogin')) {
            $userLogin = Customer::where('email', session('userLogin'))->first();
        }

        $provinces = Province::orderBy('name', 'asc')->get();
        $address = CustomerAddress::findOrFail($addressId);

        $headingTitle = 'Chỉnh sửa địa chỉ nhận hàng';
        $pageTitle = 'Chỉnh sửa địa chỉ nhận hàng';

        return view('catalog.pages.client.edit-address',
            compact('headingTitle', 'pageTitle', 'userLogin', 'provinces', 'address')
        );
    }

    public function postEditAddress(Request $request) {
        DB::table('customer_address')
        ->where('id', $request->id)
        ->update([
            'customer_name'     => $request->name,
            'customer_phone'    => $request->phone,
            'province_id'       => $request->province,
            'district_id'       => $request->district,
            'ward_id'           => $request->ward,
            'address'           => $request->address,
            'updated_at'        => date('Y-m-d H:i:s')
        ]);

        return redirect()->route('client.getAddress')->with('success_msg', 'Bạn đã chỉnh sửa địa chỉ thành công');
    }
}
