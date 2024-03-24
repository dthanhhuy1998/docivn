@extends('catalog.common.layout')

@section('content')
@php
    if(count($productDescription->product->images) > 0) {
        $images = App\Models\ProductImage::where('product_id', $productDescription->product_id)->orderBy('sort_order', 'asc')->get();
    }
@endphp
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
                            <li class="breadcrumb-item">
                                <a href="{{ route('catalog.productCategory', [$productDescription->product->pivot->category->slug]) }}">{{ $productDescription->product->pivot->category->name }}</a>
                            </li>
                            <li class="breadcrumb-item active">{{ $productDescription->name }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="js-wrapper_product">
                        <div class="row">
                            <div class="col-lg-8 col-xxl-8">
                                <div class="detail-main bg-white">
                                    <div class="row gx-0 gy-4 gx-lg-3">
                                        <div class="col-lg-6">
                                            <div class="detail-images">
                                                <div class="product-avatar_photo slider-theme">
                                                    <div class="swiper" id="detail-avatar_photo">
                                                        <div class="swiper-wrapper">
                                                            <div class="swiper-slide">
                                                                <div class="preview-avatar_photo__item">
                                                                    <a data-fancybox="detailGallery" data-index="1" href="@if(!empty( $productDescription->product->image)) {{ asset('storage/app/'.$productDescription->product->image) }} @else {{ asset('storage/app/uploads/default.png') }} @endif" title="{{ $productDescription->name }}">
                                                                        <img src="@if(!empty( $productDescription->product->image)) {{ asset('storage/app/'.$productDescription->product->image) }} @else {{ asset('storage/app/uploads/default.png') }} @endif" alt="{{ $productDescription->name }}">
                                                                        <span><i class="far fa-search-plus"></i></span>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            @if(count($productDescription->product->images) > 0)
                                                                @php $countSlide = 1; @endphp
                                                                @foreach($images as $image)
                                                                    @php $countSlide++; @endphp
                                                                    <div class="swiper-slide">
                                                                        <div class="preview-avatar_photo__item">
                                                                            <a data-fancybox="detailGallery" data-index="{{ $countSlide }}" href="@if(!empty($image->image)) {{ asset('storage/app/' . $image->image) }} @else {{ asset('storage/app/uploads/default.png') }} @endif" title="{{ $productDescription->name }}">
                                                                                <img src="@if(!empty($image->image)) {{ asset('storage/app/'.$image->image) }} @else {{ asset('storage/app/uploads/default.png') }} @endif" alt="{{ $productDescription->product->name }}">
                                                                                <span><i class="far fa-search-plus"></i></span>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div id="button-prev" class="slider-button button-prev button-theme button-theme_primary" data-title="Ảnh trước">
                                                        <span>Ảnh trước</span>
                                                    </div>
                                                    <div id="button-next"
                                                         class="slider-button button-next button-theme button-theme_primary" data-title="Ảnh kế">
                                                        <span>Ảnh kế</span>
                                                    </div>
                                                </div>
                                                <div class="product-avatar_thumb position-relative">
                                                    <div class="swiper pe-1" id="detail-avatar_thumb">
                                                        <div class="swiper-wrapper h-auto">
                                                            <div class="swiper-slide h-auto">
                                                                <div class="preview-avatar_thumb__item">
                                                                    <img src="@if(!empty( $productDescription->product->image)) {{ asset('storage/app/'.$productDescription->product->image) }} @else {{ asset('storage/app/uploads/default.png') }} @endif" alt="{{ $productDescription->name }}">
                                                                </div>
                                                            </div>
                                                            @if(count($productDescription->product->images) > 0)
                                                                @foreach($images as $image)
                                                                    <div class="swiper-slide h-auto">
                                                                        <div class="preview-avatar_thumb__item">
                                                                            <img src="@if(!empty($image->image)) {{ asset('storage/app/'.$image->image) }} @else {{ asset('storage/app/uploads/default.png') }} @endif" alt="{{ $productDescription->product->name }}">
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="detail-information">
                                                <h1 class="detail-information_title">{{ $productDescription->name }}</h1>
                                                <div class="detail-information_categories">
                                                    Đã bán:
                                                    <span>{{ $productDescription->product->sold }}</span>
                                                </div>
                                                <div class="detail-information_categories">
                                                    Danh mục:
                                                    <a href="{{ route('catalog.productCategory', [$productDescription->product->pivot->category->slug]) }}">{{ $productDescription->product->pivot->category->name }}</a>
                                                </div>
                                                <div class="detail-information_divider"></div>
                                                <div class="detail-information_price">
                                                    <div class="detail-information_price__left">
                                                        <div class="price-current">
                                                            <div class="price-value">
                                                                Giá sản phẩm:
                                                                @if($productDescription->product->price > 0)
                                                                    <span class="js-price">{{ number_format($productDescription->product->price) }}đ</span>
                                                                @else
                                                                    <span class="js-price">Liên hệ</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="detail-information_properties">
                                                    <div class="properties">
														<div class="property-item">
                                                            <div class="property-item_title">
                                                                <span class="">Dung tích</span>:
                                                            </div>
                                                            <div class="property-value">
                                                                <button class="property-value_button active" data-id="24" data-giahientai="260.000đ" data-giacu="0" data-phantram="100" data-donvitinh="" data-soluong="9999" data-index="1">
                                                                    @if($productDescription->product->pivot->category->slug == 'tester')
                                                                        <span>24 mùi</span>
                                                                    @else
                                                                        <span>25ml</span>
                                                                    @endif
                                                                </button>
                                                            </div>
                                                        </div>
													</div>
                                                </div>
                                                <div class="detail-information_stock">
                                                    Tình trạng:
                                                    <span class="is-stock" style="@if($productDescription->product->stock_status_id == 4){{ 'color: red;' }}@endif">{{ $productDescription->product->stockStatus->name }}</span>                                            
                                                </div>
                                                <div class="detail-information_divider"></div>
                                                <div class="detail-information_share">
                                                    Chia sẻ:
                                                    <div 
                                                        class="fb-share-button"
                                                        data-href="{{ route('catalog.product', [$productDescription->product->pivot->category->slug, $productDescription->slug]) }}" data-layout="button"
                                                        data-size="small"
                                                    >
                                                        <a target="_blank"
                                                           href="{{ route('catalog.product', [$productDescription->product->pivot->category->slug, $productDescription->slug]) }}"
                                                           class="fb-xfbml-parse-ignore">Chia sẻ
                                                        </a>
                                                    </div>
                                                    <div 
                                                        class="zalo-share-button" data-href="{{ route('catalog.product', [$productDescription->product->pivot->category->slug, $productDescription->slug]) }}"
                                                        data-oaid="oaid..?"
                                                        data-layout="1" data-color="blue" data-customize="false"
                                                    >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-xxl-4 mt-4 mt-lg-0">
                                <div class="description-sidebar">
                                        <div class="section-heading_highlight">
                                            <div class="text">
                                                <div class="title">
                                                    <div class="line"></div>
                                                    THÔNG TIN SẢN PHẨM                                          
                                                </div>
                                            </div>
                                        </div>
                                        <div class="font-theme pb-3">
                                            {!! $productDescription->detail !!}
                                        </div>
                                        <div class="section-heading_highlight">
                                            <div class="text">
                                                <div class="title">
                                                    <div class="line"></div>
                                                    THÔNG TIN CHI TIẾT                                            
                                                </div>
                                            </div>
                                        </div>
                                        <div class="font-theme pb-3">
                                            {!! $productDescription->description !!}
                                        </div>
                                        <div class="section-heading_highlight">
                                            <div class="text">
                                                <div class="title">
                                                    <div class="line"></div>
                                                    THÔNG TIN VÀ CHÍNH SÁCH                                            
                                                </div>
                                            </div>
                                        </div>
                                        @if(!empty($phone))
                                            {{-- <div class="description-sidebar_contact">
                                                <div class="icon">
                                                    <img src="{{ asset('public/catalog/assets/public/upload/banner/icon-phone.png') }}" alt="THÔNG TIN VÀ CHÍNH SÁCH-dociperfume.vn | Nước hoa DOCI Perfume chính hãng">
                                                </div>
                                                <div class="content">
                                                    <a href="tel:{{$phone}}">{{$phone}} </a>
                                                    <span>Gọi tư vấn: (13h - 23h)</span>
                                                </div>
                                            </div> --}}
                                        @endif
                                        <div class="description-sidebar_collapse" id="description-sidebar_collapse">
                                            <div class="collapse-item">
                                                <a href="#collapse-item_2"
                                                    data-bs-toggle="collapse"
                                                    class="collapse-item_button"
                                                    aria-expanded="true">
                                                    CAM KẾT BÁN HÀNG
                                                    <i class="fal fa-angle-down"></i>
                                                </a>
                                                <div class="collapse show" id="collapse-item_2" data-bs-parent="#description-sidebar_collapse">
                                                    <div class="collapse-item_content">
                                                        <p><meta charset="utf-8" /><img alt="" src="{{ asset('public/catalog/assets/public/upload/banner/check-circle.png') }}" style="width: 20px; height: 20px;" />&nbsp;Sản ph&acirc;̉m chính hãng</p>
                                                        <p><img alt="" src="{{ asset('public/catalog/assets/public/upload/banner/check-circle.png') }}" style="width: 20px; height: 20px;" />&nbsp;Đúng ti&ecirc;u chu&acirc;̉n</p>
                                                        <p><img alt="" src="{{ asset('public/catalog/assets/public/upload/banner/check-circle.png') }}" style="width: 20px; height: 20px;" />&nbsp;Đúng ch&acirc;́t lượng</p>
                                                        <p><img alt="" src="{{ asset('public/catalog/assets/public/upload/banner/check-circle.png') }}" style="width: 20px; height: 20px;" />&nbsp;Được bảo hành chính hãng</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <!-- <div class="product-comment" id="product-comment">
                            <div class="comment-overview">
                                <div class="section-heading_highlight section-heading_highlight__link">
                                    <div class="text">
                                        <div class="title text-uppercase">
                                            <div class="line"></div>
                                            Bình luận/ Đánh giá sản phẩm
                                        </div>
                                    </div>
                                </div>
                                <div class="comment-overview_flex">
                                    <div class="comment-overview_progress">
                                        <div class="comment-title">
                                            Đánh giá sản phẩm
                                        </div>
                                        <div class="progress-inner" id="progress-percent" style="--value: 0">
                                            <div class="progress-inner_desc">
                                                Chưa có <br> đánh giá
                                            </div>
                                        </div>
                                        <div class="comment-overview_desc">
                                            (<span id="progress-total">0</span> lượt đánh giá)
                                        </div>
                                    </div>
                                    <div class="comment-overview_timeline">
                                        <div class="timeline-item" data-key="5">
                                            <div class="timeline-item_title">Tuyệt vời</div>
                                            <div class="timeline-item_bg" style="--value: 80%"></div>
                                            <div class="timeline-item_count">(00)</div>
                                        </div>
                                    <div class="timeline-item" data-key="4">
                                        <div class="timeline-item_title">Xuất sắc</div>
                                        <div class="timeline-item_bg" style="--value: 60%"></div>
                                        <div class="timeline-item_count">(00)</div>
                                    </div>
                                    <div class="timeline-item" data-key="3">
                                        <div class="timeline-item_title">Tốt</div>
                                        <div class="timeline-item_bg" style="--value: 40%"></div>
                                        <div class="timeline-item_count">(00)</div>
                                    </div>
                                    <div class="timeline-item" data-key="2">
                                        <div class="timeline-item_title">Trung bình</div>
                                        <div class="timeline-item_bg" style="--value: 35%"></div>
                                        <div class="timeline-item_count">(00)</div>
                                    </div>
                                    <div class="timeline-item" data-key="1">
                                        <div class="timeline-item_title">Kém</div>
                                        <div class="timeline-item_bg" style="--value: 0%"></div>
                                        <div class="timeline-item_count">(00)</div>
                                    </div>
                                </div>
                                <div class="comment-overview_images" id="comment-overview_images" style="display: none">
                                    <div class="comment-title">
                                        Hình ảnh từ khách hàng
                                    </div>
                                    <div class="images-grid"></div>
                                    <div class="commtent-button">
                                        <a href="#formRating" class="button-theme button-theme_primary rounded-2 mt-4">
                                            Viết đánh giá
                                            <span></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <!-- <div class="comment-list">
                            <div class="comment-list_inner">
                                <div class="list-inner_header"
                                    id="comment-sort" style="display: none">
                                    <div class="comment-sort">
                                        <a href="javascript:void(0)" role="button" class="comment-sort_item orderAjax active">
                                            Mới nhất
                                        </a>
                                        <a href="javascript:void(0)" role="button" class="comment-sort_item orderAjax"
                                        data-type="desc">
                                            Đánh giá Cao -> Thấp
                                        </a>
                                        <a href="javascript:void(0)" role="button" class="comment-sort_item orderAjax"
                                        data-type="asc">
                                            Đánh giá Thấp ->Cao
                                        </a>
                                    </div>
                                </div>
                                <div class="list-inner_body" id="cardRenderAjax">
                                    <div class="comment-list_item"></div>
                                        <div class="section-pagination" id="comment-pagination" style="display: none">
                                        <nav>
                                            <ul class="pagination" id="ul_pagination"></ul>
                                        </nav>
                                    </div>
                                </div>
                                <div class="list-inner_footer">
                                    <div class="comment-form_wrapper">
                                        <div class="comment-form">
                                            <div class="comment-title">
                                                <div class="section-heading_highlight section-heading_highlight__link">
                                                    <div class="text">
                                                        <div class="title text-uppercase">
                                                            <div class="line"></div>
                                                            ĐỂ LẠI ĐÁNH GIÁ
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <form action="" id="formRating" class="frm-validation needs-validation" novalidate>
                                                <input type="hidden" name="danhgia_id_sanpham" id="danhgia_id_sanpham" value="6855">
                                                <div class="comment-form_item">
                                                    <div class="row g-4">
                                                        <div class="col-12">
                                                            <div class="form-item form-star">
                                                                <input type="radio" id="danhgia_rating5" value="5" name="danhgia_rating"
                                                                    class="num-rating"
                                                                    required>
                                                                <label for="danhgia_rating5"><i class="far fa-star"></i></label>
                                                                <input type="radio" id="danhgia_rating4" value="4" name="danhgia_rating"
                                                                    class="num-rating"
                                                                    required>
                                                                <label for="danhgia_rating4"><i class="far fa-star"></i></label>
                                                                <input type="radio" id="danhgia_rating3" value="3" name="danhgia_rating"
                                                                    class="num-rating"
                                                                    required>
                                                                <label for="danhgia_rating3"><i class="far fa-star"></i></label>
                                                                <input type="radio" id="danhgia_rating2" value="2" name="danhgia_rating"
                                                                    class="num-rating"
                                                                    required>
                                                                <label for="danhgia_rating2"><i class="far fa-star"></i></label>
                                                                <input type="radio" id="danhgia_rating1" value="1" name="danhgia_rating"
                                                                    class="num-rating"
                                                                    required>
                                                                <label for="danhgia_rating1"><i class="far fa-star"></i></label>
                                                                <div class="frm-validation_valid invalid-feedback">
                                                                    Vui lòng chọn mức sao
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-item">
                                                                <div class="form-item_title">
                                                                    <label for="danhgia_tieude">
                                                                        Nhập tiêu đề đánh giá (*)
                                                                    </label>
                                                                </div>
                                                                <div class="form-item_input">
                                                                    <input id="danhgia_tieude" name="danhgia_tieude" type="text"
                                                                        required
                                                                        placeholder="Nhập tiêu đề đánh giá...">
                                                                    <div class="frm-validation_valid invalid-feedback">
                                                                        Vui lòng nhập tiêu đề đánh giá
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-item">
                                                                <div class="form-item_title">
                                                                    <label for="danhgia_hoten">
                                                                        Họ và Tên (*)
                                                                    </label>
                                                                </div>
                                                                <div class="form-item_input">
                                                                    <input id="danhgia_hoten" name="danhgia_hoten" type="text" required
                                                                        value=""
                                                                        placeholder="Họ tên của bạn là...">
                                                                    <div class="frm-validation_valid invalid-feedback">
                                                                        Vui lòng nhập họ tên
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-item">
                                                                <div class="form-item_title">
                                                                    <label for="danhgia_sdt">
                                                                        Số điện thoại (*)
                                                                    </label>
                                                                </div>
                                                                <div class="form-item_input">
                                                                    <input id="danhgia_sdt" name="danhgia_sdt" type="text" required
                                                                        value="" minlength="10"
                                                                        maxlength="10"
                                                                        placeholder="Số điện thoại của bạn là......">
                                                                    <div class="frm-validation_valid invalid-feedback">
                                                                        Vui lòng nhập số điện thoại
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-item">
                                                                <div class="form-item_title">
                                                                    <label for="danhgia_noidung">
                                                                        Nội dung đánh giá
                                                                    </label>
                                                                </div>
                                                                <div class="form-item_textarea">
                                                                    <textarea name="danhgia_noidung" id="danhgia_noidung" rows="5"
                                                                    placeholder="Nhập nôi dung đánh giá ..."></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="text-center">
                                                                <button type="button" id="btnSub" data-title="Gửi đánh giá" class="button-theme button-theme_primary rounded-2">
                                                                    <span> Gửi đánh giá </span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="comment-list_sidebar">
                                        <div class="list-sidebar_inner">
                                            <div class="list-sidebar_header">
                                                <div class="comment-title">
                                                    BỘ LỌC
                                                </div>
                                                <div class="sidebar-delete">
                                                    <a href="javascript:void(0)" role="button" id="resetFilter">
                                                        Xóa bộ lọc
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="list-sidebar_body" id="cardFilterRating">
                                                <div class="comment-title">
                                                    Lọc theo Đánh giá
                                                </div>
                                                <div class="comment-filter">
                                                    <div class="comment-filter_item">
                                                        <input class="filter-input filterRating" name="filterRating[]" type="checkbox" value="5" id="filterRating_5">
                                                        <label class="filter-label" for="filterRating_5">
                                                            <span><i class="fas fa-star"></i></span>
                                                            <span><i class="fas fa-star"></i></span>
                                                            <span><i class="fas fa-star"></i></span>
                                                            <span><i class="fas fa-star"></i></span>
                                                            <span><i class="fas fa-star"></i></span>
                                                            (5 Sao)
                                                        </label>
                                                    </div>
                                                    <div class="comment-filter_item">
                                                            <input class="filter-input filterRating" name="filterRating[]" type="checkbox" value="4" id="filterRating_4">
                                                            <label class="filter-label" for="filterRating_4">
                                                                <span><i class="fas fa-star"></i></span>
                                                                <span><i class="fas fa-star"></i></span>
                                                                <span><i class="fas fa-star"></i></span>
                                                                <span><i class="fas fa-star"></i></span>
                                                                (4 Sao)
                                                            </label>
                                                        </div>
                                                    <div class="comment-filter_item">
                                                            <input class="filter-input filterRating" name="filterRating[]" type="checkbox" value="3" id="filterRating_3">
                                                            <label class="filter-label" for="filterRating_3">
                                                                <span><i class="fas fa-star"></i></span>
                                                                <span><i class="fas fa-star"></i></span>
                                                                <span><i class="fas fa-star"></i></span>
                                                                (3 Sao)
                                                            </label>
                                                        </div>
                                                    <div class="comment-filter_item">
                                                            <input class="filter-input filterRating" name="filterRating[]" type="checkbox" value="2" id="filterRating_2">
                                                            <label class="filter-label" for="filterRating_2">
                                                                <span><i class="fas fa-star"></i></span>
                                                                <span><i class="fas fa-star"></i></span>
                                                                (2 Sao)
                                                            </label>
                                                        </div>
                                                        <div class="comment-filter_item">
                                                            <input class="filter-input filterRating" name="filterRating[]" type="checkbox" value="1" id="filterRating_1">
                                                            <label class="filter-label" for="filterRating_1">
                                                                <span><i class="fas fa-star"></i></span>
                                                                (1 Sao)
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>          -->
                    </div>
                    <div class="col-12">
                        <div class="detail-block bg-transparent section-gap">
                            @if($productDescription->product->pivot->category->slug != 'tester')
                                <div class="row">
                                    <div class="col-12">
                                        <div class="section-heading">
                                            <div class="title">Sản phẩm liên quan</div>
                                        </div>
                                        @if(count($relatedProducts) > 0)
                                            <div class="row row-cols-2 row-cols-md-3 row-cols-xl-4 row-cols-xxl-5 g-3">
                                                @foreach($relatedProducts as $product)
                                                    <div class="col-md-3 col-xs-12 col-lg-3">
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
                                                                            href="{{ route('catalog.product', [$product->category_slug, $product->product_slug]) }}" 
                                                                            class="button-cart"
                                                                            onclick="return false;"
                                                                        >
                                                                            <span>
                                                                                @if($product->product_price > 0)
                                                                                    <ins>{{ number_format($product->product_price) }}đ</ins>
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
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    <div class="detail-block_divider"></div>
                    {{-- <div class="detail-block bg-transparent section-gap">
                        <div class="row">
                            <div class="col-12">
                                <div class="section-heading">
                                    <div class="title">Sản phẩm đã xem</div>
                                </div>
                                @if(count($recentlyVieweds) > 0)
                                    <div class="slider-theme" id="slider-product_viewed">
                                        <div class="swiper">
                                            <div class="swiper-wrapper h-auto">
                                                @foreach($recentlyVieweds as $product)
                                                    <div class="swiper-slide h-auto">
                                                        <div class="product-card card">
                                                            <div class="card-header">
                                                                <a class="card-image ratio ratio-1x1" title="{{ $product->productDescription->name }}" href="{{ route('catalog.product', [$product->pivot->category->slug, $product->productDescription->slug]) }}">
                                                                    <img src="@if(!empty($product->image)) {{ asset('storage/app/' . $product->image) }} @else {{ asset('storage/app/uploads/default.png') }} @endif" height="250px" width="250px" alt="{{ $product->productDescription->name }}">
                                                                </a>
                                                                <div class="card-actions">
                                                                    <div class="card-action">
                                                                        <button type="button" class="btn-favourite btn-onlyIcon " data-id="6822">
                                                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                                <path d="M17.3667 3.84172C16.941 3.41589 16.4357 3.0781 15.8795 2.84763C15.3232 2.61716 14.7271 2.49854 14.125 2.49854C13.5229 2.49854 12.9268 2.61716 12.3705 2.84763C11.8143 3.0781 11.309 3.41589 10.8833 3.84172L10 4.72506L9.11666 3.84172C8.25692 2.98198 7.09086 2.49898 5.875 2.49898C4.65914 2.49898 3.49307 2.98198 2.63333 3.84172C1.77359 4.70147 1.29059 5.86753 1.29059 7.08339C1.29059 8.29925 1.77359 9.46531 2.63333 10.3251L3.51666 11.2084L10 17.6917L16.4833 11.2084L17.3667 10.3251C17.7925 9.89943 18.1303 9.39407 18.3608 8.83785C18.5912 8.28164 18.7099 7.68546 18.7099 7.08339C18.7099 6.48132 18.5912 5.88514 18.3608 5.32893C18.1303 4.77271 17.7925 4.26735 17.3667 3.84172Z"
                                                                                    stroke-linecap="round"
                                                                                    stroke-linejoin="round"/>
                                                                            </svg>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="card-title">
                                                                    <a title="{{ $product->productDescription->name }}" href="{{ route('catalog.product', [$product->pivot->category->slug, $product->productDescription->slug]) }}">{{ $product->productDescription->name }}</a>
                                                                </div>
                                                                <div class="card-bottom">
                                                                    <div class="card-price">
                                                                        @if($product->price > 0)
                                                                            <ins>{{ number_format($product->price) }}đ</ins>
                                                                        @else
                                                                            <ins>Liên hệ</ins>
                                                                        @endif
                                                                    </div>
                                                                    <div class="card-view">
                                                                        <a title="{{ $product->productDescription->name }}" href="{{ route('catalog.product', [$product->pivot->category->slug, $product->productDescription->slug]) }}" data-title="Thêm vào giỏ" class="button-theme button-theme_primary">
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
                                        <div id="button-prev" class="slider-button button-prev button-theme button-theme_primary" data-title="Trước">
                                            <span>Trước</span>
                                        </div>
                                        <div id="button-next"
                                            class="slider-button button-next button-theme button-theme_primary" data-title="Kế tiếp">
                                            <span>Kế tiếp</span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>
    <div id="js-counter"></div>
@endsection
@section('script')
<script>
    const handleQuantityProduct = function () {
        $(document).on('click', '.quantity .quantity-button', function (e) {
            e.preventDefault();

            let type = parseInt($(this).attr('data-type'));
            let numberQuantity = $(this).closest('.quantity').find('.quantity-number'),
                btnAddToCart, btnAddToBuy;
            if ($(this).closest('#floating-cart').length == 0) {
                numberQuantity = $(this).closest('.js-wrapper_product').find('.quantity-number');
                btnAddToCart = $(this).closest('.js-wrapper_product').find('.btn-add_cart');
                btnAddToBuy = $(this).closest('.js-wrapper_product').find('.btn-add_buy');
            }
            let maxQuantity = parseInt(numberQuantity.attr('data-max')),
                valueQuantity = parseInt(numberQuantity.val());
            if (!isNaN(type)) {
                if (type === 1) {
                    if (valueQuantity > maxQuantity - 1) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Số lượng cần thêm vượt quá số lượng sản phẩm trong kho!',
                            text: 'Vui lòng thử lại!',
                            buttonsStyling: false,
                            showConfirmButton: false,
                            showCancelButton: true,
                            cancelButtonText: 'Thử lại!',
                            customClass: {
                                cancelButton: 'btn btn-danger btn-no_effect'
                            }
                        }).then((res) => {
                            if (res.isDismissed) {
                                valueQuantity = maxQuantity;
                            }
                        });
                        // here
                    } else {
                        valueQuantity += 1;
                        if (currentPage == 'gio-hang' || $(this).closest('#floating-cart').length == 1) {
                            handleUpdateCart(numberQuantity.attr('data-id'), valueQuantity, numberQuantity.attr('data-key'), numberQuantity.parent());
                        }
                    }
                } else if (type === 0) {
                    if (valueQuantity > 1)
                        valueQuantity -= 1;
                    if (currentPage == 'gio-hang' || $(this).closest('#floating-cart').length == 1) {
                        handleUpdateCart(numberQuantity.attr('data-id'), valueQuantity, numberQuantity.attr('data-key'), numberQuantity.parent());
                    }
                }
                // add quantity to  button "add to cart"
                numberQuantity.val(valueQuantity);
                if ($(this).closest('#floating-cart').length == 0) {
                    btnAddToCart.attr('data-quantity', valueQuantity);
                    btnAddToBuy.attr('data-quantity', valueQuantity);
                }
            }
        });

        $(document).on('keyup', '.quantity .quantity-number', function () {
            let maxQuantity = parseInt($(this).attr('data-max')), btnAddToCart, btnAddToBuy;
            if ( $(this).closest('#floating-cart').length == 0) {
                btnAddToCart = $(this).closest('.js-wrapper_product').find('.btn-add_cart');
                btnAddToBuy = $(this).closest('.js-wrapper_product').find('.btn-add_buy');
            }
            if (isNaN($(this).val()) || $(this).val() < 1) {
                $(this).closest('.js-wrapper_product').find('.quantity-number').val(1);
                if ($(this).closest('#floating-cart').length == 0) {
                    btnAddToCart.attr('data-quantity', 1);
                    btnAddToBuy.attr('data-quantity', 1);
                }

                // if (currentPage == 'gio-hang' || $(this).closest('#floating-cart').length == 1) {
                //     handleUpdateCart($(this).attr('data-id'), 1, $(this).attr('data-key'), $(this).parent());
                // }
            } else {
                if ($(this).val() > maxQuantity) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Số lượng cần thêm vượt quá số lượng sản phẩm trong kho!',
                        text: 'Vui lòng thử lại!',
                        buttonsStyling: false,
                        showConfirmButton: false,
                        showCancelButton: true,
                        cancelButtonText: 'Thử lại!',
                        customClass: {
                            cancelButton: 'btn btn-danger btn-no_effect'
                        }
                    }).then((res) => {
                        if (res.isDismissed) {
                            $(this).closest('.js-wrapper_product').find('.quantity-number').val(maxQuantity);
                            if (currentPage == 'chi-tiet-sp' && $(this).closest('#floating-cart').length == 0) {
                                btnAddToCart.attr('data-quantity', maxQuantity);
                                btnAddToBuy.attr('data-quantity', maxQuantity);
                            }
                        }
                    });
                } else {
                    $(this).closest('.js-wrapper_product').find('.quantity-number').val($(this).val());
                    if ($(this).closest('#floating-cart').length == 0) {
                        btnAddToCart.attr('data-quantity', $(this).val());
                        btnAddToBuy.attr('data-quantity', $(this).val());
                    }
                    // if (currentPage == 'gio-hang' || $(this).closest('#floating-cart').length == 1) {
                    //     handleUpdateCart($(this).attr('data-id'), $(this).val(), $(this).attr('data-key'), $(this).parent());
                    // }
                }
            }
        });
    }

    const handleAddToCart = function () {
        $(document).on('click', '.btn-add_cart, .btn-add_buy', function (e) {
            e.preventDefault();
            let ajaxCart = '{{ route("catalog.cart.addToCart") }}';

            let btnCurrent = $(this),
                btnType = btnCurrent.attr('data-type'),
                textBtnCurrent = btnCurrent.html(),
                idCurrent = btnCurrent.attr('data-id'),
                quantityCurrent = btnCurrent.attr('data-quantity'),
                propertyID = 0; // no attribute id

            if (btnCurrent.hasClass('btn-onlyIcon')) {
                btnCurrent.html('<i class="fa fa-spinner fa-spin"></i>');
                btnCurrent.prop("disabled", true);
            } else {
                btnlinkload(btnCurrent);
            }

            $.post(ajaxCart, {
                '_token': '{{ csrf_token() }}',
                'product_id': idCurrent,
                'quantity_add': quantityCurrent,
                'property_id': propertyID
            }, function (result) {
                if (result.status == 200) {
                    if (btnType == 0) {
                        $('.cart-number').html(result.cart_count);
                        Swal.fire({
                            icon: 'success',
                            title: result.message,
                            text: 'Sản phẩm đã thêm vào giỏ hàng!',
                            buttonsStyling: false,
                            showConfirmButton: true,
                            showCancelButton: false,
                            confirmButtonText: 'Kiểm tra giỏ hàng!',
                            customClass: {
                                confirmButton: 'btn btn-danger btn-no_effect'
                            },
                            footer: '<a class="small" style="text-decoration: underline" href="javascript:void(0)" onclick="swal.close(); return false;">Tiếp tục mua hàng</a>',
                        }).then((res) => {
                            if (res.isConfirmed) {
                                $('.js-toggle_cart').trigger('click');
                            }
                        });
                        if (btnCurrent.hasClass('btn-onlyIcon')) {
                            btnCurrent.addClass('active')
                            btnlinkthanhcong(btnCurrent, textBtnCurrent);
                        } else {
                            btnlinkthanhcong(btnCurrent, 'Thêm thành công');
                        }
                        btnCurrent.prop('disabled', true);
                        btnCurrent.addClass('disabled');

                    } else {
                        window.open(result.route, '_self');
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: result.message,
                        text: 'Vui lòng thử lại!',
                        buttonsStyling: false,
                        showConfirmButton: false,
                        showCancelButton: true,
                        cancelButtonText: 'Thử lại!',
                        customClass: {
                            cancelButton: 'btn btn-danger btn-no_effect'
                        }
                    });
                    btnlinkthanhcong(btnCurrent, textBtnCurrent);
                }
            }, 'JSON').fail(function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Có lỗi xảy ra khi thêm giỏ hàng',
                    text: 'Vui lòng thử lại!',
                    buttonsStyling: false,
                    showConfirmButton: false,
                    showCancelButton: true,
                    cancelButtonText: 'Thử lại!',
                    customClass: {
                        cancelButton: 'btn btn-danger btn-no_effect'
                    }
                });
                btnlinkthanhcong(btnCurrent, textBtnCurrent);
            });
            return false;
        });
    }

    $(function() {
        handleQuantityProduct();
        handleAddToCart();
    });
</script>
<script src="{{ asset('public/catalog/assets/view/theme_user/sanpham/js/chitiet.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/catalog/assets/view/theme_user/sanpham/js/danhgia.js') }}" type="text/javascript"></script>
@endsection