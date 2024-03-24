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
                            <li class="breadcrumb-item active"> {{ $pageTitle }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                @if(count($prdCates) > 0)
                    <div class="col-lg-12 col-xs-12 col-md-12">
                        @foreach($prdCates as $cate)
                            @php 
                                $products = Illuminate\Support\Facades\DB::table('product_to_category as ptc')
                                ->select('prd.id as prd_id', 'prd_cate.slug as cate_slug', 'prd_desc.slug as prd_slug', 'prd_desc.name as prd_name', 'prd.image as prd_image', 'prd.price as prd_price')
                                ->whereIn('category_id', [$cate->id])
                                ->join('product as prd', 'ptc.product_id', '=', 'prd.id')
                                ->join('product_description as prd_desc', 'prd.id', '=', 'prd_desc.product_id')
                                ->join('product_category as prd_cate', 'ptc.category_id', '=', 'prd_cate.id')
                                ->take(12)
                                ->get();
                            @endphp
                            <div class="section-heading2" style="margin-bottom: 0; margin-top: 80px;">
                                <div class="title">{{ $cate->name }}</div>
                                <div class="desc">{!! $cate->description !!}</div>
                            </div>
                            @if(count($products) > 0)
                                <div class="category-inner">
                                    <div class="row">
                                        @foreach($products as $prd)
                                            <div class="col-lg-3 col-md-3 col-xs-3 col-6 mb-3">
                                                <div class="product-card card">
                                                    <div class="card-header">
                                                        <a class="card-image ratio ratio-1x1" title="{{ $prd->prd_name }}" href="{{ route('catalog.product', [$prd->cate_slug, $prd->prd_slug]) }}">
                                                            <img src="@if(!empty($prd->prd_image)) {{ asset('storage/app/'.$prd->prd_image) }} @else {{ asset('storage/app/uploads/default.png') }} @endif" height="250px" width="250px" alt="{{ $prd->prd_name }}">
                                                        </a>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="card-title">
                                                            <a title="{{ $prd->prd_name }}" href="{{ route('catalog.product', [$prd->cate_slug, $prd->prd_slug]) }}">{{ $prd->prd_name }}</a>
                                                        </div>
                                                        <div class="card-bottom">
                                                            <div class="card-view">
                                                                <a title="Chi tiết {{ $prd->prd_name }}" href="{{ route('catalog.product', [$prd->cate_slug, $prd->prd_slug]) }}" class="button-theme button-theme_primary button-view">
                                                                    <span>Chi tiết</span>
                                                                </a>
                                                                <a 
                                                                    href="{{ route('catalog.product', [$prd->cate_slug, $prd->prd_slug]) }}" 
                                                                    class="button-cart"
                                                                    onclick="return false;"
                                                                >
                                                                    <span>
                                                                        @if($prd->prd_price > 0)
                                                                            <strong>{{ number_format($prd->prd_price) }}đ</strong>
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
                            <div class="row">
                                <div class="col-lg-12 col-xs-12 col-md-12 content-center mt-5">
                                    <a class="button-theme button-theme_secondary" href="{{ route('catalog.productCategory', $cate->slug) }}" title="Xem thêm {{ $cate->name }}" data-title="Xem thêm {{ $cate->name }}">
                                        <span>Xem thêm {{ $cate->name }}</span>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection