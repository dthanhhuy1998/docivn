<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cart;
use SEOMeta;
use DB;
use URL;
use Validator;

// Models
use App\Models\Product;
use App\Models\Attribute;
use App\Models\Province;
use App\Models\Config;

class CartController extends Controller
{
    protected $configModel = '';

    public function __construct() {
        $this->configModel = new Config();
    }

    public function getCartList() {
        $cartCount = Cart::count();
        if($cartCount > 0) {
            $cartContent = Cart::content();
            
            $cartTotal = Cart::priceTotal();
            $provinces = Province::orderBy('name', 'asc')->get();

            // SEO
            $pageTitle = 'Giỏ hàng của bạn';
            $description = $this->configModel->getConfig('meta_description');
            $keyword = $this->configModel->getConfig('meta_keyword');
            $logo = asset('storage/app/'.$this->configModel->getConfig('logo'));
            $this->seo_tools($pageTitle, $description, $keyword, $logo, URL::current());
            
            return view('catalog.pages.cart',
                compact('pageTitle', 'cartCount', 'cartContent', 'cartTotal')
            );
        } else {
            return redirect()->route('catalog.homepage');
        }
    }

    public function postCart(Request $request) {
        $data = array(
            'total'     => Cart::priceTotal(),
            'length'    => Cart::count(),
            'list'      => Cart::content()
        );

        return response()->json([
            'status'    => 200,
            'data'      => $data,
        ]);
    }

    public function addToCart(Request $request) {
        $product = Product::findOrFail($request->product_id);

        // add to cart
        Cart::add([
            'id'        => $request->product_id,
            'name'      => $product->productDescription->name,
            'qty'       => $request->quantity_add,
            'price'     => $product->price,
            'discount'  => 0,
            'weight'    => 0,
            'options'   => [
                'max_qty'           => $product->quantity,
                'original_price'    => $product->price,
                'view'              => route('catalog.product', [$product->pivot->category->slug, $product->productDescription->slug]),
                'image'             => !empty($product->image) ? asset('storage/app/'.$product->image) : asset('storage/app/uploads/default.png'),
                'attribute'         => ''
            ]
        ]);

        return response()->json([
            'status'        => 200,
            'cart_count'    => Cart::count(),
            'route'         => route('catalog.cart.getCartList')
        ]);
    }

    public function getCartDestroy() {
        Cart::destroy();
        return redirect()->back()->with('success_msg', 'Đã xóa giỏ hàng thành công');
    }

    public function getCartRemove(Request $request) {
        Cart::remove($request->product_id);
        return response()->json([
            'status'    => 200,
            'message'   => 'Xóa sản phẩm thành công',
            'count'     => Cart::count(),
            'total'     => Cart::priceTotal(),
            'route'     => route('catalog.homepage'),
            'order'     => route('catalog.cart.getOrder'),
        ]);
    }

    public function postUpdateCart(Request $request) {
        Cart::update($request->product_id, $request->quantity_add);
        // get cart
        $item = Cart::get($request->product_id);
        $dongia = $item->price*$item->qty;

        return response()->json([
            'status'    => 200,
            'message'   => 'Thành công',
            'count'     => Cart::count(),
            'total'     => Cart::priceTotal(),
            'dongia'    => number_format($dongia),
            'route'     => route('catalog.cart.getOrder')
        ]);
    }

    public function addToCartOption(Request $request) {
        $product = Product::findOrFail($request->productId);
        if(!empty($request->optionId)) {
            $option = Attribute::findOrFail($request->optionId);
            $optionName = $option->name;
            $optionPrice = $option->price;
        }

        // add to cart
        Cart::add([
            'id'        => $product->id,
            'name'      => $product->productDescription->name,
            'qty'       => $request->productQty,
            'price'     => $optionPrice,
            'weight'    => 0,
            'options'   => [
                'image' => $product->image,
                'option' => $optionName
            ]
        ]);

        return response()->json([
            'status' => 200,
            'cart_count' => Cart::count()
        ]);

        return response()->json([
            'status'    => 200,
            'message'   => 'success'
        ]);
    }

    public function getOrder() {
        $cartCount = Cart::count();
        if($cartCount > 0) {
            $cartContent = Cart::content();
            $cartTotal = Cart::priceTotal();
            $customer = NULL;
            if(session()->exists('userLogin')) {
                $customer = DB::table('customer')->select('firstname', 'email', 'telephone', 'address')
                ->where('email', session()->get('userLogin'))
                ->first();
            }

            // SEO
            $pageTitle = 'Đặt hàng';
            $description = $this->configModel->getConfig('meta_description');
            $keyword = $this->configModel->getConfig('meta_keyword');
            $logo = asset('storage/app/'.$this->configModel->getConfig('logo'));
            $this->seo_tools($pageTitle, $description, $keyword, $logo, URL::current());

            return view('catalog.pages.order',
                compact('pageTitle', 'cartCount', 'cartContent', 'cartTotal', 'customer')
            );
        } else {
            return redirect()->route('catalog.homepage');
        }
    }

    public function order(Request $request) {
        $validator = Validator::make($request->all(), [
            'sdt'               => 'required|min:10|max:12',
            'tenkhachhang'      => 'required|min:3',
            'diachi'            => 'required',
        ],[
            'sdt.required'              => 'Số điện thoại không được bỏ trống!',
            'sdt.min'                   => 'Số điện thoại không hợp lệ!',
            'sdt.max'                   => 'Số điện thoại không hợp lệ!',
            'tenkhachhang.required'     => 'Tên khách hàng không được bỏ trống!',
            'tenkhachhang.min'          => 'Tên khách hàng quá ngắn (tối thiểu từ 3 ký tự)!',
            'diachi.required'           => 'Nhập địa chỉ nhận hàng!',
        ]);
        // set customer id
        $customerId = 0;
        if(session()->exists('userLogin')) {
            $customer = DB::table('customer')->select('id')->where('email', session()->get('userLogin'))->first();
            $customerId = $customer->id;
        }
        // create a new invoice
        $invoiceId = DB::table('invoice')->insertGetId([
            'customer_id'       => $customerId,
            'customer_name'     => ($request->tenkhachhang),
            'customer_phone'    => trim($request->sdt),
            'customer_email'    => trim($request->email),
            'province_id'       => 0,
            'district_id'       => 0,
            'ward_id'           => 0,
            'address'           => trim($request->diachi),
            'payment_method'    => '',
            'note'              => ($request->ghichu),
            'status'            => 1,
            'created_at'        => date('Y-m-d H:i:s'),
            'updated_at'        => date('Y-m-d H:i:s')
        ]);

        // add cart to invoice detail
        if($invoiceId) {
            foreach(Cart::content() as $item) {
                DB::table('invoice_detail')->insert([
                    'invoice_id'        => $invoiceId,
                    'product_id'        => $item->id,
                    'product_price'     => $item->price,
                    'product_qty'       => $item->qty,
                    'options'           => json_encode($item->options)
                ]);
            }
        }
        // destroy cart
        Cart::destroy();

        return response()->json([
            'status'    => 200,
            'message'   => 'success',
            'route'     => route('catalog.homepage')
        ]);
    }
}
