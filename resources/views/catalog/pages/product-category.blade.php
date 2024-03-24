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
                                <a href="{{ route('catalog.products') }}">Sản phẩm</a>
                            </li>
                            <li class="breadcrumb-item active"> {{ $pageTitle }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- <div class="section-heading d-lg-flex align-items-center justify-content-between mw-100 mx-0">
                        <div class="title mb-0">{{ $pageTitle }}</div>
                        <div class="sort w-auto flex-shrink-0">
                            <a href="{{ route('catalog.productCategory', [$category->slug]) }}?sort=postdesc" class="@if($sort == 'postdesc') active @endif">Mới nhất</a>
                            <a href="{{ route('catalog.productCategory', [$category->slug]) }}?sort=postasc" class="@if($sort == 'postasc') active @endif">Cũ Nhất</a>
                            <a href="{{ route('catalog.productCategory', [$category->slug]) }}?sort=pricedesc" class="@if($sort == 'pricedesc') active @endif">Giá cao đến thấp</a>
                            <a href="{{ route('catalog.productCategory', [$category->slug]) }}?sort=priceasc" class="@if($sort == 'priceasc') active @endif">Giá thấp đến cao</a>
                        </div>
                    </div> -->
                    @if(count($products) > 0)
                        <div class="category-inner">
                            <div class="row">
                                @foreach($products as $product)
                                    <div class="col-lg-3 col-md-3 col-xs-3 col-6">
                                        <div class="product-card card">
                                            <div class="card-header">
                                                <a class="card-image ratio ratio-1x1" title="{{ $product->product_name }}" href="{{ route('catalog.product', [$product->category_slug, $product->product_slug]) }}">
                                                    <img src="@if(!empty($product->product_image)) {{ asset('storage/app/'.$product->product_image) }} @else {{ asset('storage/app/uploads/default.png') }} @endif" height="250px" width="250px" alt="{{ $product->product_name }}">
                                                </a>
                                            </div>
                                            <div class="card-body">
                                                <div class="card-title">
                                                    <a title="{{ $product->product_name }}" href="{{ route('catalog.product', [$product->category_slug, $product->product_slug]) }}">{{ $product->product_name }}</a>
                                                </div>
                                                <div class="card-bottom">
                                                    <div class="card-view">
                                                        <a title="Chi tiết {{ $product->product_name }}" href="{{ route('catalog.product', [$product->category_slug, $product->product_slug]) }}" class="button-theme button-theme_primary button-view">
                                                            <span>Chi tiết</span>
                                                        </a>
                                                        <a 
                                                            href="#" 
                                                            class="button-cart"
                                                            onclick="return false;"
                                                        >
                                                            <span>
                                                                @if($product->product_price > 0)
                                                                    <strong>{{ number_format($product->product_price) }}đ</strong>
                                                                @else
                                                                    <ins>Liên hệ</ins>
                                                                @endif
                                                            </span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($products->hasPages())
                        <nav aria-label="..." style="margin-top: 15px;">
                            <ul class="pagination">
                                <!-- Previous Page Link -->
                                @if ($products->onFirstPage())
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $products->previousPageUrl() }}" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                @endif
                                @for ($i = 1; $i <= $products->lastPage(); $i++)
                                    @if($products->currentPage() == $i)
                                    <li class="page-item active" aria-current="page">
                                        <span class="page-link">{{ $i }}</span>
                                    </li>
                                    @else
                                        <li class="page-item"><a class="page-link" href="{{ $products->url($i) }}">{{$i }}</a></li>
                                    @endif
                                @endfor
                                <!-- Next Page Link -->
                                @if ($products->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $products->nextPageUrl() }}" aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                @else
                                    <li class="page-item disabled">
                                        <a class="page-link" href="{{ $products->nextPageUrl() }}" aria-label="Next">
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
@endsection