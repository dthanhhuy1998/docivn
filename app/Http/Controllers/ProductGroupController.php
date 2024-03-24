<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use Str;

// Model
use App\Models\ProductGroup;

class ProductGroupController extends Controller
{
    public function __construct() {

    }

    public function getList() {
        $productGroups = ProductGroup::all();

        $headingTitle = heading('Nhóm hàng');
        $pageTitle = 'Nhóm hàng';

        return view('admin.pages.product_group.list',
            compact('headingTitle', 'pageTitle', 'productGroups')
        );
    }

    public function getAdd() {
        $productGroups = ProductGroup::all();

        $headingTitle = heading('Tạo nhóm hàng');
        $titlePage = 'Tạo nhóm hàng';

        return view('admin.pages.product_group.add',
            compact('headingTitle', 'titlePage', 'productGroups')
        );
    }

    public function postAdd(Request $request) {
        $validated = $request->validate([
            'categoryName'  => 'required|max:100|unique:product_group,name',
            'metaTitle'     => 'required|max:100'
        ],[
            'categoryName.required'     => 'Tên danh mục không được bỏ trống!',
            'categoryName.max'          => 'Tên danh mục tối đa 100 ký tự',
            'categoryName.unique'       => 'Tên danh mục đã được sử dụng!',
            'metaTitle.required'        => 'Meta Title không được bỏ trống!',
            'metaTitle.max'             => 'Meta Title tối đa 100 ký tự',
        ]);

        $file_path = '';
        if($request->hasFile('file')) {
            $file_path = Storage::putFile('uploads/product_group', $request->file('file'));
        }

        $productGroup                    = new ProductGroup();
        $productGroup->image             = $file_path;
        $productGroup->name              = $request->categoryName;
        $productGroup->slug              = Str::slug($request->categoryName, '-');
        $productGroup->description       = $request->description;
        $productGroup->meta_title        = $request->metaTitle;
        $productGroup->meta_description  = $request->metaDescription;
        $productGroup->meta_keyword      = $request->metaTagKeywords;
        $productGroup->parent_id         = $request->parentId;
        $productGroup->sort_order        = $request->sortOrder;
        $productGroup->status            = $request->status;
        $productGroup->save();

        return redirect()->route('admin.product.group.getList')->with('success_msg', 'Bạn đã tạo nhóm hàng thành công');
    }

    public function getEdit($categoryId) {
        $group = ProductGroup::findOrFail($categoryId);
        $categories = ProductGroup::all();

        $headingTitle = heading('Chỉnh sửa nhóm hàng');
        $pageTitle = 'Chỉnh sửa nhóm hàng';

        return view('admin.pages.product_group.edit',
            compact('headingTitle', 'pageTitle', 'group', 'categories')
        );
    }

    public function postEdit(Request $request) {
        $validated = $request->validate([
            'categoryName'  => 'required|max:100|unique:product_group,name,' . $request->id,
            'metaTitle'     => 'required|max:100'
        ],[
            'categoryName.required'     => 'Tên danh mục không được bỏ trống!',
            'categoryName.max'          => 'Tên danh mục tối đa 100 ký tự',
            'categoryName.unique'       => 'Tên danh mục đã được sử dụng!',
            'metaTitle.required'        => 'Meta Title không được bỏ trống!',
            'metaTitle.max'             => 'Meta Title tối đa 100 ký tự',
        ]);

        $productGroup = ProductGroup::findOrFail($request->id);

        if($request->hasFile('file')) {
            Storage::delete($productGroup->image);
            $file_path = Storage::putFile('uploads/product_group', $request->file('file'));
        } else {
            $file_path = $productGroup->image;
        }

        $productGroup->image             = $file_path;
        $productGroup->name              = $request->categoryName;
        $productGroup->slug              = Str::slug($request->categoryName, '-');
        $productGroup->description       = $request->description;
        $productGroup->meta_title        = $request->metaTitle;
        $productGroup->meta_description  = $request->metaDescription;
        $productGroup->meta_keyword      = $request->metaTagKeywords;
        $productGroup->parent_id         = $request->parentId;
        $productGroup->sort_order        = $request->sortOrder;
        $productGroup->status            = $request->status;
        $productGroup->save();

        return redirect()->route('admin.product.group.getList')->with('success_msg', 'Bạn đã chỉnh sửa nhóm hàng thành công');
    }

    public function getDelete($groupId) {
        // delete in product gruop table
        $group = ProductGroup::findOrFail($groupId);
        if(!empty($group->image)) {
            Storage::delete($group->image);
        }

        // delete in product to group table
        $group->products()->detach();

        $group->delete();

        return redirect()->route('admin.product.group.getList')->with('success_msg', 'Bạn đã xóa nhóm hàng thành công');
    }
}
