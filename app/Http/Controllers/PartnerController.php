<?php

namespace App\Http\Controllers;
use Storage;
use DB;

// Models
use App\Models\Partner;

use Illuminate\Http\Request;

class PartnerController extends Controller
{
    public function getList() {
        $partners = Partner::orderBy('partner_sort_order', 'asc')->get();

        $headingTitle = heading('Đối tác liên kết');
        $pageTitle = 'Đối tác liên kết';

        return view('admin.pages.partner.list',
            compact('headingTitle', 'pageTitle', 'partners')
        );
    }

    public function getAdd() {
        $headingTitle = heading('Tạo đối tác mới');
        $pageTitle = 'Tạo đối tác mới';

        return view('admin.pages.partner.add',
            compact('headingTitle', 'pageTitle')
        );
    }

    public function postAdd(Request $request) {
        $validated = $request->validate([
            'file' => 'required',
        ],[
            'file.required' => 'Vui lòng chọn ảnh!'
        ]);

        $file_path = '';
        if($request->hasFile('file')) {
            $file_path = Storage::putFile('uploads/partner', $request->file('file'));
        }

        DB::table('partner')->insert([
            'partner_image'         => $file_path,
            'partner_link'          => $request->link,
            'partner_sort_order'    => !empty($request->sortOrder) ? $request->sortOrder : 0,
            'partner_status'        => $request->status,
            'created_at'            => date('Y-m-d'),
            'updated_at'            => date('Y-m-d'),
        ]);

        return redirect()->route('admin.partner.getList')->with('success_msg', 'Tạo đối tác - khách hàng thành công');
    }

    public function getEdit($partnerId) {
        $partner = Partner::findOrFail($partnerId);

        $headingTitle = heading('Chỉnh sửa đối tác liên kết');
        $pageTitle = 'Chỉnh sửa đối tác liên kết';

        return view('admin.pages.partner.edit',
            compact('headingTitle', 'pageTitle', 'partner')
        );
    }

    public function postEdit(Request $request) {
        $partner = Partner::findOrFail($request->id);

        if($request->hasFile('file')) {
            Storage::delete($partner->partner_image);
            $file_path = Storage::putFile('uploads/partner', $request->file('file'));
        } else {
            $file_path = $partner->partner_image;
        }

        DB::table('partner')
        ->where('id', $request->id)
        ->update([
            'partner_image'       => $file_path,
            'partner_link'        => $request->link,
            'partner_sort_order'  => !empty($request->sortOrder) ? $request->sortOrder : 0,
            'partner_status'      => $request->status,
            'updated_at'        => date('Y-m-d'),
        ]);

        return redirect()->route('admin.partner.getList')->with('success_msg', 'Chỉnh sửa đối tác - khách hàng thành công');
    }

    public function getDelete($partnerId) {
        $partner = Partner::findOrFail($partnerId);

        if(!empty($partner->partner_image)) {
            Storage::delete($partner->partner_image);
        }

        $partner->delete();

        return redirect()->route('admin.partner.getList')->with('success_msg', 'Xóa đối tác - khách hàng thành công');
    }
}
