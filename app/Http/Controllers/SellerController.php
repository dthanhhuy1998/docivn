<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use Illuminate\Http\Request;
use DB;
use Storage;

class SellerController extends Controller
{
    public function getList() {
        $sellers = Seller::orderBy('created_at', 'desc')->get();

        $headingTitle = heading('Danh sách Seller');
        $pageTitle = 'Danh sách Seller';

        return view('admin.pages.seller.list',
            compact('headingTitle', 'pageTitle', 'sellers')
        );
    }

    public function getAdd() {
        $headingTitle = heading('Tạo Seller mới');
        $pageTitle = 'Tạo Seller mới';

        return view('admin.pages.seller.add',
            compact('headingTitle', 'pageTitle')
        );
    }

    public function postAdd(Request $request) {
        $validated = $request->validate([
            'sellerName'    => 'required',
            'numberPhone'   => 'required|unique:sellers,SoDienThoai',
        ],[
            'sellerName.required'   => 'Nhập họ tên Seller!',
            'numberPhone.required'  => 'Vui lòng nhập số điện thoại!',
            'numberPhone.unique'    => 'Số điện thoại đã tồn tại trên hệ thống!',
        ]);

        // save banner to storage
        $bannerPath = '';
        if($request->hasFile('banner')) {
            $bannerPath = Storage::putFile('uploads/seller', $request->file('banner'));
        }

        // save avatar to storage
        $avatarPath = '';
        if($request->hasFile('avatar')) {
            $avatarPath = Storage::putFile('uploads/seller', $request->file('avatar'));
        }

        DB::table('sellers')->insert([
            'CapBac'        => trim($request->level),
            'TenSeller'     => trim($request->sellerName),
            'Banner'        => $bannerPath,
            'AnhDaiDien'    => $avatarPath,
            'LinkFacebook'  => trim($request->facebookLink),
            'SoDienThoai'   => trim($request->numberPhone),
            'KhuVuc'        => trim($request->areaName),
            'TrucThuoc'     => trim($request->ownerName),
            'created_at'    => date('Y-m-d H:i:s'),
        ]);

        return redirect()->route('admin.seller.getList')->with('success_msg', 'Tạo Seller thành công');
    }

    public function getEdit($id) {
        $seller  = Seller::findOrFail($id);

        $headingTitle = heading('Chỉnh sửa seller '.$seller->TenSeller);
        $pageTitle = 'Chỉnh sửa seller '.$seller->TenSeller;

        return view('admin.pages.seller.edit',
            compact('headingTitle', 'pageTitle', 'seller')
        );
    }

    public function postEdit(Request $request) {
        $validated = $request->validate([
            'sellerName'    => 'required',
            'numberPhone'   => 'required|unique:sellers,SoDienThoai,'.$request->id,
        ],[
            'sellerName.required'   => 'Nhập họ tên Seller!',
            'numberPhone.required'  => 'Vui lòng nhập số điện thoại!',
            'numberPhone.unique'    => 'Số điện thoại đã tồn tại trên hệ thống!',
        ]);

        $seller = Seller::findOrFail($request->id);

        // update banner in storage
        $bannerPath = $seller->Banner;
        if($request->hasFile('banner')) {
            Storage::delete($seller->Banner);
            $bannerPath = Storage::putFile('uploads/seller', $request->file('banner'));
        }
        // update avatar in storage
        $avatarPath = $seller->AnhDaiDien;
        if($request->hasFile('avatar')) {
            Storage::delete($seller->AnhDaiDien);
            $avatarPath = Storage::putFile('uploads/seller', $request->file('avatar'));
        }

        DB::table('sellers')
        ->where('id', $request->id)
        ->update([
            'CapBac'        => trim($request->level),
            'TenSeller'     => trim($request->sellerName),
            'Banner'        => $bannerPath,
            'AnhDaiDien'    => $avatarPath,
            'LinkFacebook'  => trim($request->facebookLink),
            'SoDienThoai'   => trim($request->numberPhone),
            'KhuVuc'        => trim($request->areaName),
            'TrucThuoc'     => trim($request->ownerName)
        ]);

        return redirect()->route('admin.seller.getList')->with('success_msg', 'Chỉnh sửa Seller thành công');
    }
    
    public function getDelete($id) {
        $seller = Seller::findOrFail($id);

        // remove banner in storage
        if(!empty($seller->Banner)) {
            Storage::delete($seller->Banner);
        }
        // remove avatar in storage
        if(!empty($seller->AnhDaiDien)) {
            Storage::delete($seller->AnhDaiDien);
        }
        $seller->delete();

        return redirect()->route('admin.seller.getList')->with('success_msg', 'Xóa Seller thành công');
    }
}
