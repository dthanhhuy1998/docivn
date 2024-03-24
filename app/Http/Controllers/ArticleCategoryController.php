<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use Str;

// Model
use App\Models\ArticleCategory;

class ArticleCategoryController extends Controller
{
    public function __construct() {
    }

    public function getList() {
        $articleCategories = ArticleCategory::where('parent_id', 0)
        ->with(['subCategories' => function($query) {
            $query->orderBy('sort_order', 'asc');
        }])
        ->orderBy('sort_order', 'asc')
        ->get();

        $headingTitle = heading('Danh mục bài viết');
        $pageTitle = 'Danh mục bài viết';

        return view('admin.pages.article_category.list',
            compact('headingTitle', 'pageTitle', 'articleCategories')
        );
    }

    public function getAdd() {
        $articleCategories = ArticleCategory::where('parent_id', 0)
        ->with(['subCategories' => function($query) {
            $query->orderBy('sort_order', 'asc');
        }])
        ->orderBy('sort_order', 'asc')
        ->get();

        $headingTitle = heading('Tạo danh mục mới');
        $titlePage = 'Tạo danh mục mới';

        return view('admin.pages.article_category.add',
            compact('headingTitle', 'titlePage', 'articleCategories')
        );
    }

    public function postAdd(Request $request) {
        $validated = $request->validate([
            'categoryName'  => 'required|max:100|unique:article_category,name',
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
            $file_path = Storage::putFile('uploads/article_category', $request->file('file'));
        }

        $articleCategory                    = new ArticleCategory();
        $articleCategory->image             = $file_path;
        $articleCategory->name              = $request->categoryName;
        $articleCategory->slug              = Str::slug($request->categoryName, '-');
        $articleCategory->description       = $request->description;
        $articleCategory->meta_title        = $request->metaTitle;
        $articleCategory->meta_description  = $request->metaDescription;
        $articleCategory->meta_keyword      = $request->metaTagKeywords;
        $articleCategory->parent_id         = $request->parentId;
        $articleCategory->sort_order        = $request->sortOrder;
        $articleCategory->status            = $request->status;
        $articleCategory->save();

        return redirect()->route('admin.article.category.getList')->with('success_msg', 'Bạn đã tạo danh mục bài viết thành công');
    }

    public function getEdit($articleCategoryId) {
        $articleCategory = ArticleCategory::findOrFail($articleCategoryId);
        $articleCategories = ArticleCategory::all();

        $headingTitle = heading('Chỉnh sửa danh mục');
        $pageTitle = 'Chỉnh sửa danh mục';

        return view('admin.pages.article_category.edit',
            compact('headingTitle', 'pageTitle', 'articleCategory', 'articleCategories')
        );
    }

    public function postEdit(Request $request) {
        $validated = $request->validate([
            'categoryName'  => 'required|max:100|unique:article_category,name,' . $request->id,
            'metaTitle'     => 'required|max:100'
        ],[
            'categoryName.required'     => 'Tên danh mục không được bỏ trống!',
            'categoryName.max'          => 'Tên danh mục tối đa 100 ký tự',
            'categoryName.unique'       => 'Tên danh mục đã được sử dụng!',
            'metaTitle.required'        => 'Meta Title không được bỏ trống!',
            'metaTitle.max'             => 'Meta Title tối đa 100 ký tự',
        ]);

        $articleCategory = ArticleCategory::findOrFail($request->id);

        if($request->hasFile('file')) {
            Storage::delete($articleCategory->image);
            $file_path = Storage::putFile('uploads/article_category', $request->file('file'));
        } else {
            $file_path = $articleCategory->image;
        }

        $articleCategory->image             = $file_path;
        $articleCategory->name              = $request->categoryName;
        $articleCategory->slug              = Str::slug($request->categoryName, '-');
        $articleCategory->description       = $request->description;
        $articleCategory->meta_title        = $request->metaTitle;
        $articleCategory->meta_description  = $request->metaDescription;
        $articleCategory->meta_keyword      = $request->metaTagKeywords;
        $articleCategory->parent_id         = $request->parentId;
        $articleCategory->sort_order        = $request->sortOrder;
        $articleCategory->status            = $request->status;
        $articleCategory->save();

        return redirect()->route('admin.article.category.getList')->with('success_msg', 'Bạn đã chỉnh sửa danh mục bài viết thành công');
    }

    public function getDelete($articleCategoryId) {
        // delete in article category table
        $articleCategory = ArticleCategory::findOrFail($articleCategoryId);
        if(!empty($articleCategory->image)) {
            Storage::delete($articleCategory->image);
        }

        // delete in article to category table
        $articleCategory->article()->detach();

        // delete in article category table
        $articleCategory->delete();

        return redirect()->route('admin.article.category.getList')->with('success_msg', 'Bạn đã xóa danh mục bài viết thành công');
    }
}
