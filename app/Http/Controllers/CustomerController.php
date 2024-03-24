<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Storage;

// Models
use App\Models\Customer;
use App\Models\CustomerReviews;

class CustomerController extends Controller
{
    public function getList() {
        $customers = Customer::orderBy('created_at', 'desc')->get();

        $headingTitle = heading('Danh sách khách hàng');
        $pageTitle = 'Danh sách khách hàng';

        return view('admin.pages.customer.list',
            compact('headingTitle', 'pageTitle', 'customers')
        );
    }

    public function getToggle($customerId) {
        $customer = Customer::findOrFail($customerId);
        $enabled = 0;

        if($customer->status == 0) {
            $enabled = 1;
        }

        $affected = DB::table('customer')
        ->where('id', $customer->id)
        ->update(['status' => $enabled]);

        return redirect()->route('admin.customer.getList')->with('success_msg', 'Thay đổi trạng thái thành công');
    }

    public function getReviews() {
        $cReviews = CustomerReviews::orderBy('id', 'desc')->get();

        $headingTitle = heading('Đánh giá khách hàng');
        $pageTitle = 'Đánh giá khách hàng';

        return view('admin.pages.customer.reviews.list',
            compact('headingTitle', 'pageTitle', 'cReviews')
        );
    }

    public function getAddReview() {
        $headingTitle = heading('Thêm đánh giá khách hàng');
        $pageTitle = 'Thêm đánh giá khách hàng';

        return view('admin.pages.customer.reviews.add',
            compact('headingTitle', 'pageTitle')
        );
    }

    public function postAddReview(Request $request) {
        $validated = $request->validate([
            'crName' => 'required|max:255',
        ],[
            'crName.required' => 'Tên khách hàng không được bỏ trống!',
            'crName.max' => 'Tên khách hàng không được vượt quá 255 ký tự!',
        ]);

        $file_path = '';
        if($request->hasFile('file')) {
            $file_path = Storage::putFile('uploads/reviews', $request->file('file'));
        }

        DB::table('customer_reviews')->insert([
            'cr_name'       => $request->crName,
            'cr_position'   => $request->crPosition,
            'cr_image'      => $file_path,
            'cr_text'       => $request->crText,
            'status'        => $request->crStatus,
            'created_at'    => date('Y-m-d'),
            'updated_at'    => date('Y-m-d'),
        ]);

        return redirect()->route('admin.customer.getReviews')->with('success_msg', 'Thêm đánh giá khách hàng thành công');
    }

    public function getEditReview($customerReviewId) {
        $review = CustomerReviews::findOrFail($customerReviewId);

        $headingTitle = heading('Chỉnh sửa đánh giá');
        $pageTitle = 'Chỉnh sửa đánh giá';

        return view('admin.pages.customer.reviews.edit',
            compact('headingTitle', 'pageTitle', 'review')
        );
    }

    public function postEditReview(Request $request) {
        $validated = $request->validate([
            'crName' => 'required|max:255',
        ],[
            'crName.required' => 'Tên khách hàng không được bỏ trống!',
            'crName.max' => 'Tên khách hàng không được vượt quá 255 ký tự!',
        ]);

        $review = CustomerReviews::findOrFail($request->id);

        if($request->hasFile('file')) {
            Storage::delete($review->cr_image);
            $file_path = Storage::putFile('uploads/reviews', $request->file('file'));
        } else {
            $file_path = $review->cr_image;
        }

        DB::table('customer_reviews')
        ->where('id', $request->id)
        ->update([
            'cr_name'       => $request->crName,
            'cr_position'   => $request->crPosition,
            'cr_image'      => $file_path,
            'cr_text'       => $request->crText,
            'status'        => $request->crStatus,
            'updated_at'    => date('Y-m-d'),
        ]);

        return redirect()->route('admin.customer.getReviews')->with('success_msg', 'Chỉnh sửa đánh giá khách hàng thành công');
    }

    public function getDeleteReview($customerReviewId) {
        $review = CustomerReviews::findOrFail($customerReviewId);

        if(!empty($review->cr_image)) {
            Storage::delete($review->cr_image);
        }

        $review->delete();

        return redirect()->route('admin.customer.getReviews')->with('success_msg', 'Xóa đánh giá khách hàng thành công');
    }
}
