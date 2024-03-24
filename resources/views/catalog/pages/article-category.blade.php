@extends('catalog.common.layout')

@section('content')
<div class="section-main">
    <div class="background-light pb-5">
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
                            <li class="breadcrumb-item active">{{ $pageTitle }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-heading">
                        <h1 class="title">{{ $pageTitle }}</h1>
                    </div>
                    @if(count($articles) > 0)
                        <div class="article-inner">
                            <div class="row row-cols-lg-3 row-cols-1 row-cols-sm-2 g-3">
                                @foreach($articles as $post)
                                    <div class="col">
                                        <a href="{{ route('catalog.article', [$post->category_slug, $post->post_slug]) }}" title="{{ $post->post_title }}" class="article-card card">
                                            <div class="card-header">
                                                <img src="@if(!empty($post->post_image)) {{ asset('storage/app/'.$post->post_image) }} @else {{ asset('storage/app/uploads/default.png') }} @endif" height="240px" width="312px" class="mw-100 image-cover transition-default" alt="{{ $post->post_title }}">
                                            </div>
                                            <div class="card-body d-flex flex-column">
                                                <div class="card-meta">Ngày đăng: {{ date_vi($post->post_created_at) }}</div>
                                                <h3 class="card-title">{{ $post->post_title }}</h3>
                                                <div class="card-text">{!! $post->post_summary !!}</div>
                                                <div class="card-link mt-auto text-uppercase">
                                                    Xem chi tiết <i class="far fa-angle-right"></i>
                                                </div>
                                            </div>
                                        </a>                            
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    @if($articles->hasPages())
                        <nav aria-label="..." style="margin-top: 30px;">
                            <ul class="pagination">
                                <!-- Previous Page Link -->
                                @if ($articles->onFirstPage())
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $articles->previousPageUrl() }}" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                @endif
                                @for ($i = 1; $i <= $articles->lastPage(); $i++)
                                    @if($articles->currentPage() == $i)
                                    <li class="page-item active" aria-current="page">
                                        <span class="page-link">{{ $i }}</span>
                                    </li>
                                    @else
                                        <li class="page-item"><a class="page-link" href="{{ $articles->url($i) }}">{{$i }}</a></li>
                                    @endif
                                @endfor
                                <!-- Next Page Link -->
                                @if ($articles->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $articles->nextPageUrl() }}" aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                @else
                                    <li class="page-item disabled">
                                        <a class="page-link" href="{{ $articles->nextPageUrl() }}" aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </nav>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<div id="js-counter"></div>
@endsection