<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\ImageDetail;
use Illuminate\Http\Request;
use Storage;
use DB;

class ImageController extends Controller
{
    public function index()
    {
        $images = Image::orderBy('image_priority', 'desc')->get();

        $headingTitle = heading('Danh sách album');
        $pageTitle = 'Danh sách album';

        return view('admin.pages.images.index',
            compact('headingTitle', 'pageTitle', 'images')
        );
    }

    public function create()
    {
        $headingTitle = heading('Tạo album mới');
        $pageTitle = 'Tạo album mới';

        return view('admin.pages.images.add',
            compact('headingTitle', 'pageTitle')
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'file'  => 'required',
        ],[
            'title.required'    => 'Vui lòng nhập tiêu đề!',
            'file.required'     => 'Vui lòng chọn ảnh!',
        ]);

        $file_path = '';
        if($request->hasFile('file')) {
            $file_path = Storage::putFile('uploads/images', $request->file('file'));
        }

        DB::table('images')->insert([
            'image_picture'     => $file_path,
            'image_name'         => trim($request->title),
            'image_desc'   => trim($request->description),
            'image_priority' => $request->image_priority,
            'image_status'    => $request->image_status,
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
        ]);

        return redirect()->route('admin.gallery.index')->with('success_msg', 'Tạo album thành công');
    }

    public function show(int $id)
    {
        $images = ImageDetail::where('image_id', $id)->orderBy('image_sort', 'desc')->get();

        $headingTitle = heading('Danh sách ảnh');
        $pageTitle = 'Danh sách ảnh';

        return view('admin.pages.images.detail.index',
            compact('headingTitle', 'pageTitle', 'images', 'id')
        );
    }

    public function edit(int $id)
    {
        $image = Image::findOrFail($id);

        $headingTitle = heading('Album: '.$image->title);
        $pageTitle = 'Album: '.$image->title;

        return view('admin.pages.images.edit',
            compact('headingTitle', 'pageTitle', 'image')
        );
    }

    public function update(Request $request, Image $image)
    {
        $validated = $request->validate([
            'title' => 'required',
        ],[
            'title.required'    => 'Vui lòng nhập tiêu đề!',
        ]);

        $image = Image::findOrFail($request->id);

        if($request->hasFile('file')) {
            Storage::delete($image->image_picture);
            $file_path = Storage::putFile('uploads/images', $request->file('file'));
        } else {
            $file_path = $image->image_picture;
        }

        DB::table('images')
        ->where('id', $request->id)
        ->update([
            'image_picture' => $file_path,
            'image_name'    => trim($request->title),
            'image_desc'    => trim($request->description),
            'image_priority' => $request->image_priority,
            'image_status'    => $request->image_status,
            'updated_at'    => date('Y-m-d H:i:s'),
        ]);

        return redirect()->route('admin.gallery.index')->with('success_msg', 'Chỉnh sửa ảnh thành công');
    }

    public function destroy(int $id)
    {
        $image = Image::findOrFail($id);

        if(!empty($image->image_picture)) {
            Storage::delete($image->image_picture);
        }

        $image->delete();

        return redirect()->route('admin.gallery.index')->with('success_msg', 'Xóa ảnh thành công');
    }

    public function createDetail()
    {
        $headingTitle = heading('Đăng ảnh');
        $pageTitle = 'Đăng ảnh';

        return view('admin.pages.images.detail.create',
            compact('headingTitle', 'pageTitle')
        );
    }

    public function storeDetail(Request $request)
    {
        $validated = $request->validate([
            'images' => 'required',
            'images.*'  => 'required',
        ]);
        $images = [];

        if($request->hasfile('images')) {
            foreach($request->file('images') as $file) {
                $filename = Storage::putFile('uploads/images/detail', $file);
                DB::table('image_details')->insert([
                    'image_name'    => null,
                    'image_picture' => $filename,
                    'image_sort'    => 0,
                    'image_id'      => $request->imageId,
                ]);
            }
        }

        return redirect()->route('admin.gallery.show', $request->imageId)->with('success_msg', 'Tạo album thành công');
    }

    public function destroyDetail(int $id)
    {
        $image = DB::table('image_details')->where('id', $id)->first();

        if(!empty($image->image_picture)) {
            Storage::delete($image->image_picture);
        }

        DB::table('image_details')->where('id', '=', $id)->delete();

        return redirect()->back()->with('success_msg', 'Xóa ảnh thành công');
    }
    
    public function showImageDetail($imageId, $id)
    {
        $image = ImageDetail::where('id', $id)->first();

        $headingTitle = heading('Chỉnh sửa ảnh');
        $pageTitle = 'Chỉnh sửa ảnh';

        return view('admin.pages.images.detail.edit',
            compact('headingTitle', 'pageTitle', 'image', 'imageId')
        );
    }
    
    public function updateImageDetail(Request $request)
    {
        $image = ImageDetail::findOrFail($request->id);

        if($request->hasFile('file')) {
            Storage::delete($image->image_picture);
            $file_path = Storage::putFile('uploads/images/detail', $request->file('file'));
        } else {
            $file_path = $image->image_picture;
        }

        DB::table('image_details')
        ->where('id', $request->id)
        ->update([
            'image_picture' => $file_path,
            'image_name'    => trim($request->title),
            'image_sort'    => $request->image_sort,
        ]);

        return redirect()->route('admin.gallery.show', $request->image_id)->with('success_msg', 'Chỉnh sửa ảnh thành công');
    }
}
