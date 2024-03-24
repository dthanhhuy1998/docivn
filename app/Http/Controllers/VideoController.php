<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Storage;
use DB;

class VideoController extends Controller
{
    public function getList() 
    {
        $videos = Video::orderBy('created_at', 'desc')->get();

        $headingTitle = heading('Danh sách video');
        $pageTitle = 'Danh sách video';

        return view('admin.pages.video.list',
            compact('headingTitle', 'pageTitle', 'videos')
        );
    }

    public function getAdd() 
    {
        $headingTitle = heading('Tạo video mới');
        $pageTitle = 'Tạo video mới';

        return view('admin.pages.video.add',
            compact('headingTitle', 'pageTitle')
        );
    }

    public function postAdd(Request $request) 
    {
        $validated = $request->validate([
            'title' => 'required',
            'file'  => 'required',
            'link'  => 'required',
        ],[
            'title.required'    => 'Vui lòng nhập tiêu đề!',
            'file.required'     => 'Vui lòng chọn ảnh!',
            'link.required'     => 'Vui lòng nhập đường link!',
        ]);

        $file_path = '';
        if($request->hasFile('file')) {
            $file_path = Storage::putFile('uploads/video/thumb', $request->file('file'));
        }

        DB::table('videos')->insert([
            'thumbnail'     => $file_path,
            'title'         => trim($request->title),
            'description'   => trim($request->description),
            'youtube'       => trim($request->link),
            'status'        => trim($request->status),
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
        ]);

        return redirect()->route('admin.video.getList')->with('success_msg', 'Tạo video thành công');
    }

    public function getEdit($videoId) 
    {
        $video = Video::findOrFail($videoId);

        $headingTitle = heading('Video '.$video->title);
        $pageTitle = 'Video '.$video->title;

        return view('admin.pages.video.edit',
            compact('headingTitle', 'pageTitle', 'video')
        );
    }

    public function postEdit(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'link'  => 'required',
        ],[
            'title.required'    => 'Vui lòng nhập tiêu đề!',
            'link.required'     => 'Vui lòng nhập đường link!',
        ]);

        $video = Video::findOrFail($request->id);

        if($request->hasFile('file')) {
            Storage::delete($video->thumbnail);
            $file_path = Storage::putFile('uploads/video/thumb', $request->file('file'));
        } else {
            $file_path = $video->thumbnail;
        }

        DB::table('videos')
        ->where('id', $request->id)
        ->update([
            'thumbnail'     => $file_path,
            'title'         => trim($request->title),
            'description'   => trim($request->description),
            'youtube'       => trim($request->link),
            'status'        => trim($request->status),
            'updated_at'    => date('Y-m-d H:i:s'),
        ]);

        return redirect()->route('admin.video.getList')->with('success_msg', 'Chỉnh sửa video thành công');
    }

    public function getDelete($videoId) {
        $video = Video::findOrFail($videoId);

        if(!empty($video->thumbnail)) {
            Storage::delete($video->thumbnail);
        }

        $video->delete();

        return redirect()->route('admin.video.getList')->with('success_msg', 'Xóa video thành công');
    }
}
