@extends('catalog.common.layout')

@section('content')
<div class="section-main">
    <div class="page-article background-light">
        <div class="section-breadcrumb">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('catalog.homepage') }}">Trang chủ</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('catalog.articles') }}">Bài viết</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('catalog.articleCategory', [$article->pivot->category->slug]) }}">{{ $article->pivot->category->name }}</a>
                            </li>
                            <li class="breadcrumb-item active">{{ $article->title }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="section-gap pt-0">
            <div class="container">
                <div class="row @if(count($relatedPosts) <= 0) justify-content-center @endif">
                    <div class="col-md-8 col-lg-8">
                        <div class="page-article_inner bg-white shadow-sm rounded-3 p-3">
                            <h1 class="page-article_inner__title">{{ $article->title }}</h1>
                            <div class="page-article_inner__meta">
                                <div class="page-article_inner__meta-list">
                                    <span>
                                        <i class="fas fa-calendar-alt"></i>
                                        {{ date_format(date_create($article->created_at), 'd/m/Y') }}                            
                                    </span>
                                    <span>
                                        <i class="fas fa-eye"></i>
                                        {{ number_format($article->view) }}
                                    </span>
                                </div>
                                <div class="page-article_inner__meta-social">
                                    <ul class="list-unstyled mb-0">
                                        <li class="share">
                                            Chia sẻ:
                                        </li>
                                        <li>
                                            <div class="fb-share-button" data-href="{{ route('catalog.article', [$article->pivot->category->slug, $article->slug]) }}" data-layout="button" data-size="small">
                                                <a target="_blank" href="{{ route('catalog.article', [$article->pivot->category->slug, $article->slug]) }}" class="fb-xfbml-parse-ignore">Chia sẻ</a>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="zalo-share-button" data-href="{{ route('catalog.article', [$article->pivot->category->slug, $article->slug]) }}" data-oaid="oaid code?" data-layout="1" data-color="blue" data-customize="false"></div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="page-article_inner__content">
                                <div class="summary" style="margin-bottom: 15px;">{!! $article->summary !!}</div>
                                <div class="content">{!! $article->content !!}</div>            
                            </div>
                        </div>
                    </div>
                    @if(count($relatedPosts) > 0)
                        <div class="col-md-4">
                            <div class="section-heading pt-3 mb-3 mx-0 text-start">
                                <div class="title">
                                    Bài viết liên quan
                                </div>
                            </div>
                            <aside class="article-sidebar">
                                <div class="article-sidebar_list">
                                    @foreach($relatedPosts as $post)
                                        <div class="item position-relative">
                                            <div class="item-media">
                                                <div class="ratio" style="--bs-aspect-ratio: var(--aspect-ratio-1000x556);">
                                                    <img src="@if(!empty($post->post_image)) {{ asset('storage/app/'.$post->post_image) }} @else {{ asset('storage/app/uploads/default.png') }} @endif" alt="{{ $post->post_title }}">
                                                </div>
                                            </div>
                                            <div class="item-body">
                                                <h3 class="item-title">{{ $post->post_title }}</h3>
                                                <div class="item-shortDesc">
                                                    <span>{!! $post->post_summary !!}</span>
                                                </div>
                                                <div class="item-meta text-end">
                                                    <time datetime="{{ $post->post_created_at }}">
                                                        <i class="far fa-calendar-edit"></i>
                                                        <span>{{ date_format(date_create($post->post_created_at), 'd/m/Y') }}</span>
                                                    </time>
                                                </div>
                                            </div>
                                            <a class="stretched-link" title="{{ $post->post_title }}" href="{{ route('catalog.article', [$post->category_slug, $post->post_slug]) }}"></a>
                                        </div>
                                    @endforeach
                                </div>
                            </aside>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<div id="js-counter"></div>
@endsection

@section('script')
<script src="{{ asset('public/catalog/assets/view/theme_user/baiviet/js/chitiet.js') }}" type="text/javascript"></script>
@endsection