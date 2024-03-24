<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Models
use App\Models\TraGop;

class TraGopController extends Controller
{
    public function getList() {
        $lists = TraGop::orderBy('created_at', 'desc')->get();

        $headingTitle = heading('Danh sách yêu cầu');
        $pageTitle = 'Danh sách yêu cầu';

        return view('admin.pages.tra-gop.list',
            compact('headingTitle', 'pageTitle', 'lists')
        );
    }

    public function getDelete($traGopId) {
        $traGop = TraGop::findOrFail($traGopId);
        $traGop->delete();

        return redirect()->route('admin.tra-gop.getList')->with('success_msg', 'Xóa yêu cầu trả góp thành công');
    }
}
