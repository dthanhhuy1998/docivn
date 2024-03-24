<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleToCategory extends Model
{
    use HasFactory;

    protected $table = 'article_to_category';

    public function article() {
        return $this->belongsTo(Article::class, 'article_id', 'id');
    }

    public function category() {
        return $this->belongsTo(ArticleCategory::class, 'category_id', 'id');
    }
}
