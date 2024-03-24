<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use DB;

// Models
use App\Models\Slide;

class SlideController extends Controller
{
    public function getList() {
        $slides = Slide::where('slide_type', 'slide')->orderBy('slide_sort_order', 'asc')->get();

        $headingTitle = heading('Slide quảng cáo');
        $pageTitle = 'Slide quảng cáo';

        return view('admin.pages.slide.list',
            compact('headingTitle', 'pageTitle', 'slides')
        );
    }

    public function getAdd() {
        $headingTitle = heading('Tạo slide quảng cáo');
        $pageTitle = 'Tạo slide quảng cáo';

        return view('admin.pages.slide.add',
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
            $file_path = Storage::putFile('uploads/slide', $request->file('file'));
        }

        DB::table('slide')->insert([
            'slide_image'       => $file_path,
            'slide_link'        => $request->link,
            'slide_sort_order'  => !empty($request->sortOrder) ? $request->sortOrder : 0,
            'slide_status'      => $request->status,
            'slide_type'        => 'slide',
            'created_at'        => date('Y-m-d'),
            'updated_at'        => date('Y-m-d'),
        ]);

        return redirect()->route('admin.slide.getList')->with('success_msg', 'Tạo slide quảng cáo thành công');
    }

    public function getEdit($slideId) {
        $slide = Slide::findOrFail($slideId);

        $headingTitle = heading('Chỉnh sửa slide');
        $pageTitle = 'Chỉnh sửa slide';

        return view('admin.pages.slide.edit',
            compact('headingTitle', 'pageTitle', 'slide')
        );
    }

    public function postEdit(Request $request) {
        $slide = Slide::findOrFail($request->id);

        if($request->hasFile('file')) {
            Storage::delete($slide->slide_image);
            $file_path = Storage::putFile('uploads/slide', $request->file('file'));
        } else {
            $file_path = $slide->slide_image;
        }

        DB::table('slide')
        ->where('id', $request->id)
        ->update([
            'slide_image'       => $file_path,
            'slide_link'        => $request->link,
            'slide_sort_order'  => !empty($request->sortOrder) ? $request->sortOrder : 0,
            'slide_status'      => $request->status,
            'updated_at'        => date('Y-m-d'),
        ]);

        return redirect()->route('admin.slide.getList')->with('success_msg', 'Chỉnh sửa slide thành công');
    }

    public function getDelete($slideId) {
        $slide = Slide::findOrFail($slideId);

        if(!empty($slide->slide_image)) {
            Storage::delete($slide->slide_image);
        }

        $slide->delete();

        return redirect()->route('admin.slide.getList')->with('success_msg', 'Xóa slide thành công');
    }
}
