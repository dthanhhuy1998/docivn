<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Article extends Model
{
    use HasFactory;

    protected $table = 'article';

    protected $guard = [];

    // Relationships
    public function category() {
        return $this->belongsToMany(ArticleCategory::class, 'article_to_category', 'article_id', 'category_id');
    }

    public function pivot() {
        return $this->belongsTo(ArticleToCategory::class, 'id', 'article_id');
    }

    // Functions
    public function getArticleByCategorySlug($slug, $paginate) {
        $results = array();
        
        if(ArticleCategory::select('id')->where('slug', $slug)->exists()) {
            $activityCate = ArticleCategory::select('id')->where('slug', $slug)->first();
            $results = DB::table('article_to_category as atc')
            ->select('a.id as post_id', 'a.slug as post_slug', 'a.image as post_image', 'ac.slug as category_slug', 'a.title as post_title', 'a.created_at as post_created_at', 'a.summary as post_summary', 'a.view as post_view')
            ->where('category_id', $activityCate->id)
            ->where('a.status', 1)
            ->join('article as a', 'atc.article_id', '=', 'a.id')
            ->join('article_category as ac', 'atc.category_id', '=', 'ac.id')
            ->orderBy('a.created_at', 'desc')
            ->paginate($paginate);
        }

        return $results;
    }
}
