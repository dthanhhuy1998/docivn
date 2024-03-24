<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use Str;
use DB;

// Model
use App\Models\ArticleCategory;
use App\Models\Article;
use App\Models\ArticleToCategory;

class ArticleController extends Controller
{
    public function __construct() {

    }

    public function getList() {
        $articles = Article::orderBy('created_at', 'desc')->get();

        $headingTitle = heading('Danh sách bài viết');
        $pageTitle = 'Danh sách bài viết';

        return view('admin.pages.article.list',
            compact('headingTitle', 'pageTitle', 'articles')
        );
    }

    public function getAdd() {
        $categories = ArticleCategory::all();

        $headingTitle = heading('Tạo bài viết mới');
        $titlePage = 'Tạo bài viết mới';

        return view('admin.pages.article.add',
            compact('headingTitle', 'titlePage', 'categories')
        );
    }

    public function postAdd(Request $request) {
        $validated = $request->validate([
            'title'         => 'required|max:255|unique:article,title',
            'metaTitle'     => 'required|max:100',
            'categories'    => 'required|array',
            'categories.*'  => 'required|integer',
        ],[
            'title.required'        => 'Tiêu đề bài viết không được bỏ trống!',
            'title.max'             => 'Tiêu đề bài viết tối đa 255 ký tự!',
            'title.unique'          => 'Tiêu đề bài viết đã được sử dụng!',
            'metaTitle.required'    => 'Meta Title không được bỏ trống!',
            'metaTitle.max'         => 'Meta Title tối đa 100 ký tự!',
            'categories.required'   => 'Vui lòng chọn danh mục bài viết!',
        ]);

        $file_path = '';
        if($request->hasFile('file')) {
            $file_path = Storage::putFile('uploads/article', $request->file('file'));
        }

        $article                    = new Article();
        $article->image             = $file_path;
        $article->title             = $request->title;
        $article->slug              = Str::slug($request->title, '-');
        $article->summary           = $request->summary;
        $article->content           = $request->content;
        $article->meta_title        = $request->metaTitle;
        $article->meta_description  = $request->metaDescription;
        $article->meta_keyword      = $request->metaTagKeywords;
        $article->sort_order        = $request->sortOrder;
        $article->status            = $request->status;
        $article->save();

        // save to article to category table
        if(count($request->categories)){
            $article->category()->attach($request->categories);
        }

       return redirect()->route('admin.article.getList')->with('success_msg', 'Bạn đã tạo bài viết thành công');
    }

    public function getEdit($articleId) {
        $article = Article::findOrFail($articleId);
        $categories = ArticleCategory::all();
        $articleToCategory = DB::table('article_to_category')->where('article_id', $articleId)->get();

        $categorySelected = array();
        foreach($articleToCategory as $value) {
            $categorySelected[] = $value->category_id;
        }

        $headingTitle = heading('Chỉnh sửa bài viết');
        $pageTitle = 'Chỉnh sửa bài viết';

        return view('admin.pages.article.edit',
            compact('headingTitle', 'pageTitle', 'article', 'categories', 'categorySelected')
        );
    }

    public function postEdit(Request $request) {
        $validated = $request->validate([
            'title'         => 'required|max:255|unique:article,title,' . $request->id,
            'metaTitle'     => 'required|max:100',
            'categories'    => 'required',
        ],[
            'title.required'        => 'Tiêu đề bài viết không được bỏ trống!',
            'title.max'             => 'Tiêu đề bài viết tối đa 255 ký tự',
            'title.unique'          => 'Tiêu đề bài viết đã được sử dụng!',
            'metaTitle.required'    => 'Meta Title không được bỏ trống!',
            'metaTitle.max'         => 'Meta Title tối đa 100 ký tự',
            'categories.required'   => 'Vui lòng chọn danh mục bài viết!',
        ]);

        $article = Article::findOrFail($request->id);

        if($request->hasFile('file')) {
            Storage::delete($article->image);
            $file_path = Storage::putFile('uploads/article', $request->file('file'));
        } else {
            $file_path = $article->image;
        }

        $article->image             = $file_path;
        $article->title             = $request->title;
        $article->slug              = Str::slug($request->title, '-');
        $article->summary           = $request->summary;
        $article->content           = $request->content;
        $article->meta_title        = $request->metaTitle;
        $article->meta_description  = $request->metaDescription;
        $article->meta_keyword      = $request->metaTagKeywords;
        $article->sort_order        = $request->sortOrder;
        $article->status            = $request->status;
        $article->save();

        // save to article to category table
        $article->category()->sync($request->categories);

        return redirect()->route('admin.article.getList')->with('success_msg', 'Bạn đã chỉnh sửa bài viết thành công');
    }

    public function getDelete($articleId) {
        // delete in article table
        $article = Article::findOrFail($articleId);
        if(!empty($article->image)) {
            Storage::delete($article->image);
        }

        // delete in article to category table
        $article->category()->detach();

        $article->delete();

        return redirect()->route('admin.article.getList')->with('success_msg', 'Bạn đã xóa bài viết thành công');
    }
}
