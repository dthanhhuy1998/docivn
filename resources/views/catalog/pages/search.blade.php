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
                <div class="col-12">
                    <div class="section-heading d-lg-flex align-items-center justify-content-between mw-100 mx-0">
                        <div class="title mb-0">{{ $pageTitle }}</div>
                        <div class="sort w-auto flex-shrink-0">
                           
                        </div>
                    </div>
                    @if(count($products) > 0)
                        <div class="category-inner">
                            <div class="row row-cols-2 row-cols-md-3 row-cols-xl-4 row-cols-xxl-5 row-cols-1 row-cols-sm-2 g-3">
                                @foreach($products as $product)
                                    @php 
                                        $ptc = App\Models\ProductToCategory::select('category_id')->where('product_id', $product->product_id)->first();
                                        $category = App\Models\ProductCategory::select('slug')->where('id', $ptc->category_id)->first();
                                    @endphp
                                    <div class="col">
                                        <div class="product-card card">
                                            <div class="card-header">
                                                <a class="card-image ratio ratio-1x1" title="{{ $product->pd_name }}" href="{{ route('catalog.product', [$category->slug, $product->pd_slug]) }}">
                                                    <img src="@if(!empty($product->image)) {{ asset('storage/app/'.$product->image) }} @else {{ asset('storage/app/uploads/default.png') }} @endif" height="250px" width="250px" alt="{{ $product->pd_name }}">
                                                </a>
                                                <div class="card-actions">
                                                    <div class="card-action">
                                                        <button type="button" class="btn-favourite btn-onlyIcon">
                                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M17.3667 3.84172C16.941 3.41589 16.4357 3.0781 15.8795 2.84763C15.3232 2.61716 14.7271 2.49854 14.125 2.49854C13.5229 2.49854 12.9268 2.61716 12.3705 2.84763C11.8143 3.0781 11.309 3.41589 10.8833 3.84172L10 4.72506L9.11666 3.84172C8.25692 2.98198 7.09086 2.49898 5.875 2.49898C4.65914 2.49898 3.49307 2.98198 2.63333 3.84172C1.77359 4.70147 1.29059 5.86753 1.29059 7.08339C1.29059 8.29925 1.77359 9.46531 2.63333 10.3251L3.51666 11.2084L10 17.6917L16.4833 11.2084L17.3667 10.3251C17.7925 9.89943 18.1303 9.39407 18.3608 8.83785C18.5912 8.28164 18.7099 7.68546 18.7099 7.08339C18.7099 6.48132 18.5912 5.88514 18.3608 5.32893C18.1303 4.77271 17.7925 4.26735 17.3667 3.84172Z"
                                                                    stroke-linecap="round"
                                                                    stroke-linejoin="round"
                                                                />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="card-title">
                                                    <a title="{{ $product->pd_name }}" href="{{ route('catalog.product', [$category->slug, $product->pd_slug]) }}">{{ $product->pd_name }}</a>
                                                </div>
                                                <div class="card-bottom">
                                                    <div class="card-price">
                                                        @if($product->p_price > 0)
                                                            <ins>{{ number_format($product->p_price) }}đ</ins>
                                                        @else
                                                            <ins>Liên hệ</ins>
                                                        @endif
                                                    </div>
                                                    <div class="card-view">
                                                        <a title="{{ $product->pd_name }}" href="{{ route('catalog.product', [$category->slug, $product->pd_slug]) }}" data-title="Thêm vào giỏ" class="button-theme button-theme_primary">
                                                            <span>Thêm vào giỏ</span>
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
                                        <a class="page-link" href="{{ route('catalog.search') }}?tukhoa=@if(isset($_GET['tukhoa'])){{ $_GET['tukhoa'] }}@endif" aria-label="Previous">
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
                                        <li class="page-item"><a class="page-link" href="{{ route('catalog.search') }}?tukhoa=@if(isset($_GET['tukhoa'])){{ $_GET['tukhoa'] }}@endif&page={{$i}}">{{$i }}</a></li>
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