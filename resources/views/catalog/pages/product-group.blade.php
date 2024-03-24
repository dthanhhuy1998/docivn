@extends('catalog.common.layout')

@section('content')
    <!-- Banner Title -->
    <div class="banner" style="background-image: url('{{ asset('public/catalog/assets//img/bg1.jpg') }}')">
        <h1 class="banner-title">{{ $pageTitle }}</h1>
    </div>
    <!-- ./end Banner title -->
    <nav class="breadcrumb__wrap">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('catalog.homepage') }}">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="{{ route('catalog.products') }}">Sản phẩm</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $pageTitle }}</li>
            </ol>
        </div>
    </nav>
    <div class="article-wrap">
        <div class="container">
            <div class="row flex-wrap-reverse">
                <div class="col-md-3">
                    @include('catalog.common.product-sidebar-left')
                </div>
                <div class="col-md-9">
                    <div class="category-img">
                        <a href="https://jumao.thietbiyteminhphuong.com/" target="_blank">
                            <img src="{{ asset('public/catalog/assets/img/banner-jumao.jpg') }}" class="w-100" alt="Máy tạo OXY JUMAO dung tích 5L/Phút. Với tính năng thân thiện và dễ sử dụng, náy tạo oxy JUMAO thích hợp sử dụng tại gia đình và các phòng khám nhỏ">
                        </a>
                    </div>
                    <div class="productCategory">
                        <ul class="nav nav-pills control-panel mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="vertical-tab" data-bs-toggle="pill" data-bs-target="#vertical" type="button" role="tab" aria-controls="pills-home" aria-selected="true">
                                    <i class="fa fa-th"></i>
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="horizontal-tab" data-bs-toggle="pill" data-bs-target="#horizontal" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">
                                <i class="fas fa-th-list"></i>
                                </button>
                            </li>
                            <div class="option-panel">
                                <h4 class="show-text">Hiển thị {{ $groupPivot->count() }} - {{ $groupPivot->currentPage() }}/{{ $groupPivot->lastPage() }}  kết quả</h4>
                                <div class="option-show">
                                    <span>Hiển thị:</span>
                                    <select name="" id="">
                                        <option value="20">20</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                </div>
                                <div class="option-show">
                                    <span>Sắp xếp:</span>
                                    <select name="" id="">
                                        <option value="default">Mặc định</option>
                                        <option value="sort_by_name">Xếp theo tên</option>
                                        <option value="sort_by_price">Xếp theo giá</option>
                                    </select>
                                </div>
                            </div>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="vertical" role="tabpanel" aria-labelledby="vertical-tab">
                                @if(count($groupPivot) > 0)
                                <div class="product-vertical">
                                    @foreach($groupPivot as $pivot)
                                        @foreach($pivot->product as $product)
                                        <div class="productBox">
                                            @if($product->original_price > 0)
                                                <span class="badge badge-sale">Giảm {{ round(discountPercent($product->original_price, $product->price)) }}%</span>
                                            @endif
                                            <div class="productBox__image">
                                                <img alt="{{ $product->productDescription->name }}" class="lazy" data-src="@if(!empty($product->image)) {{ asset('storage/app/' . $product->image) }} @else {{ asset('storage/app/uploads/default.png') }} @endif" src="{{ asset('public/catalog/assets/img/lazyload.jpg') }}" />
                                                <div class="img-overlay"></div>
                                                <div class="productBtn" title="{{ $product->productDescription->name }}">
                                                    <a title="Xem nhanh" href="{{ route('catalog.product', [$product->productDescription->slug]) }}" class="productBtn-btn btn-quick-view"><i class="fas fa-eye"></i></a>
                                                    @if(count($product->attribute) > 0)
                                                        <a
                                                            title="Thêm vào giỏ hàng"
                                                            href="{{ route('catalog.product', [$product->productDescription->slug]) }}"
                                                            class="productBtn-btn"
                                                        >
                                                            <i class="fas fa-shopping-basket"></i>
                                                        </a>
                                                    @else
                                                        <a
                                                            title="Thêm vào giỏ hàng"
                                                            href="#"
                                                            class="productBtn-btn btn-add-cart"
                                                            product-id="{{ $product->id }}"
                                                            product-name="{{ $product->productDescription->name }}"
                                                            product-qty="1"
                                                        >
                                                            <i class="fas fa-shopping-basket"></i>
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="productBox__content">
                                                <a title="{{ $product->productDescription->name }}" class="productBox__content-name-link" href="{{ route('catalog.product', [$product->productDescription->slug]) }}">
                                                    @if(strlen($product->productDescription->name) > 55)
                                                        {{ mb_substr($product->productDescription->name, 0, 55, 'utf-8') }}...
                                                    @else
                                                        {{ $product->productDescription->name }}
                                                    @endif
                                                </a>
                                                <div class="productBox__content-price">
                                                    @if($product->price > 0)
                                                        @if(count($product->attribute) > 0)
                                                            @if(App\Models\Attribute::where('product_id', $product->id)->min('price') == App\Models\Attribute::where('product_id', $product->id)->max('price'))
                                                                <span class="productBox__content-price-price">{{ number_format(App\Models\Attribute::where('product_id', $product->id)->min('price')) }}vn<u>đ</u></span>
                                                            @else
                                                                <span class="productBox__content-price-price">{{ number_format(App\Models\Attribute::where('product_id', $product->id)->min('price')) }}vn<u>đ</u> - {{ number_format(App\Models\Attribute::where('product_id', $product->id)->max('price')) }}vn<u>đ</u></span>
                                                            @endif
                                                        @else
                                                            @if($product->original_price > 0)
                                                                <span class="productBox__content-price-discount">{{ number_format($product->original_price) }}vn<u>đ</u></span>
                                                            @endif
                                                            <span class="productBox__content-price-price">{{ number_format($product->price) }}vn<u>đ</u></span>
                                                        @endif
                                                    @else
                                                        <span class="productBox__content-price-price">Liên hệ</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    @endforeach
                                </div>
                                @endif
                            </div>
                            <div class="tab-pane fade" id="horizontal" role="tabpanel" aria-labelledby="horizontal-tab">
                                @if(count($groupPivot) > 0)
                                <div class="product-horizal">
                                    @foreach($groupPivot as $pivot)
                                        @foreach($pivot->product as $product)
                                        <div class="productBox">
                                            @if($product->original_price > 0)
                                                <span class="badge badge-sale">Giảm {{ round(discountPercent($product->original_price, $product->price)) }}%</span>
                                            @endif
                                            <div class="productBox__image">
                                                <a title="{{ $product->productDescription->name }}" href="{{ route('catalog.product', [$product->productDescription->slug]) }}">
                                                    <img alt="{{ $product->productDescription->name }}" class="lazy" data-src="@if(!empty($product->image)) {{ asset('storage/app/' . $product->image) }} @else {{ asset('storage/app/uploads/default.png') }} @endif" src="{{ asset('public/catalog/assets/img/lazyload.jpg') }}" />
                                                </a>
                                            </div>
                                            <div class="productBox__content">
                                                <a title="{{ $product->productDescription->name }}" class="productBox__content-name-link" href="{{ route('catalog.product', [$product->productDescription->slug]) }}">
                                                    {{ $product->productDescription->name }}
                                                </a>
                                                <div class="productBox__content-price">
                                                    @if($product->price > 0)
                                                        @if(count($product->attribute) > 0)
                                                            @if(App\Models\Attribute::where('product_id', $product->id)->min('price') == App\Models\Attribute::where('product_id', $product->id)->max('price'))
                                                                <span class="productBox__content-price-price">{{ number_format(App\Models\Attribute::where('product_id', $product->id)->min('price')) }}vn<u>đ</u></span>
                                                            @else
                                                                <span class="productBox__content-price-price">{{ number_format(App\Models\Attribute::where('product_id', $product->id)->min('price')) }}vn<u>đ</u> - {{ number_format(App\Models\Attribute::where('product_id', $product->id)->max('price')) }}vn<u>đ</u></span>
                                                            @endif
                                                        @else
                                                            @if($product->original_price > 0)
                                                                <span class="productBox__content-price-discount">{{ number_format($product->original_price) }}vn<u>đ</u></span>
                                                            @endif
                                                            <span class="productBox__content-price-price">{{ number_format($product->price) }}vn<u>đ</u></span>
                                                        @endif
                                                    @else
                                                        <span class="productBox__content-price-price">Liên hệ</span>
                                                    @endif
                                                </div>
                                                @if($product->price > 0)
                                                <a
                                                    title="Thêm vào giỏ hàng"
                                                    href="{{ route('catalog.product', [$product->productDescription->slug]) }}"
                                                    class="btn btn-add-cart-list"
                                                ><i class="fas fa-shopping-basket"></i> Thêm vào giỏ hàng</a>
                                                @endif
                                            </div>
                                        </div>
                                        @endforeach
                                    @endforeach
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if($groupPivot->hasPages())
                    <nav aria-label="...">
                        <ul class="pagination">
                            <!-- Previous Page Link -->
                            @if ($groupPivot->onFirstPage())
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $groupPivot->previousPageUrl() }}" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                            @endif
                            @for ($i = 1; $i <= $groupPivot->lastPage(); $i++)
                                @if($groupPivot->currentPage() == $i)
                                <li class="page-item active" aria-current="page">
                                    <span class="page-link">{{ $i }}</span>
                                </li>
                                @else
                                    <li class="page-item"><a class="page-link" href="{{ $groupPivot->url($i) }}">{{$i }}</a></li>
                                @endif
                            @endfor
                            <!-- Next Page Link -->
                            @if ($groupPivot->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $groupPivot->nextPageUrl() }}" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <a class="page-link" href="{{ $groupPivot->nextPageUrl() }}" aria-label="Next">
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
@endsection