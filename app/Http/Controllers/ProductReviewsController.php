<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

// Models
use App\Models\ProductReviews;

class ProductReviewsController extends Controller
{
    public function getList() {
        $pReviews = ProductReviews::orderBy('created_at', 'desc')->get();

        $headingTitle = heading('Đánh giá sản phẩm');
        $pageTitle = 'Đánh giá sản phẩm';

        return view('admin.pages.product_reviews.list',
            compact('headingTitle', 'pageTitle', 'pReviews')
        );
    }

    public function getAcceptReview($reviewId) {
        $pReview = ProductReviews::findOrFail($reviewId);
        $accept = 1;
        if($pReview->status == 1) {
            $accept = 0;
        }

        DB::table('product_reviews')->where('id', $reviewId)->update(['status' => $accept]);

        return redirect()->back()->with('success_msg', 'Thao tác thành công');
    }

    public function getDeleteReview($reviewId) {
        $pReview = ProductReviews::findOrFail($reviewId);

        $pReview->delete();

        return redirect()->back()->with('success_msg', 'Xóa đánh giá thành công');
    }
}
