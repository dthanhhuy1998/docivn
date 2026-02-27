@extends('catalog.common.layout')

@section('style')
<style>
    .slider-theme.slider-hero iframe {
        min-height: 650px;
    }
    .swiper-activity-thumb {
        margin-top: 15px;
    }
    .swiper-activity-thumb .swiper-slide {
        border-radius: 6px;
        overflow: hidden;
    }
</style>
@endsection
@section('content')
<div class="section-main slide-pd-0">
    <div class="d-none d-lg-block">
        <div class="container">
            <div class="col-md-12 col-lg-12 col-xs-12">
                <div class="slider-theme slider-hero" id="slider-hero">
                    <div class="swiper">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <iframe width="560" height="315" src="https://www.youtube.com/embed/R1vCdi0YSoc" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                            </div>
                            @if(count($slides) > 0)
                                @foreach($slides as $slide)
                                    <div class="swiper-slide">
                                        <a href="@if(!empty($slide->slide_link)){{$slide->slide_link}}@else{{ '#' }}@endif" class="hero-slide">
                                            <img src="@if(!empty($slide->slide_image)) {{ asset('storage/app/'.$slide->slide_image) }} @else {{ asset('storage/app/uploads/default.png') }} @endif" class="hero-image w-100 img-fluid" alt="Slide">
                                        </a>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    {{-- <div class="slider-button button-prev button-theme button-theme_primary">
                        <span>PREVIOUS</span>
                    </div>
                    <div class="slider-button button-next button-theme button-theme_primary">
                        <span>NEXT</span>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="d-block d-sm-none">
        <div class="slider-theme slider-hero" id="slider-hero">
            <div class="swiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/R1vCdi0YSoc" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                    </div>
                    @if(count($slides) > 0)
                        @foreach($slides as $slide)
                            <div class="swiper-slide">
                                <a href="@if(!empty($slide->slide_link)){{$slide->slide_link}}@else{{ '#' }}@endif" class="hero-slide">
                                    <img src="@if(!empty($slide->slide_image)) {{ asset('storage/app/'.$slide->slide_image) }} @else {{ asset('storage/app/uploads/default.png') }} @endif" class="hero-image w-100 img-fluid" alt="Slide">
                                </a>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="slider-button button-prev button-theme button-theme_primary">
                <span>PREVIOUS</span>
            </div>
            <div class="slider-button button-next button-theme button-theme_primary">
                <span>NEXT</span>
            </div>
        </div>
    </div>
    <div class="bg-white" id="new-product">
        <div class="section-gap section-article" style="padding: 100px 0 0 0;">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-lg-12 col-xs-12 col-md-12">
                        <div class="section-heading">
                            <div class="title">Sản phẩm mới</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section-gap section-article" style="padding: 0 0 25px 0;">
            <div class="container">
                <div class="row">
                    @if(count($slideProducts) > 0)
                        <div class="col-lg-12 col-xs-12 col-md-12">
                            <div thumbsSlider="" class="swiper swiper-new-product">
                                <div class="swiper-wrapper">
                                    @foreach($slideProducts as $slide)
                                        <div class="swiper-slide">
                                            <a href="{{ $slide->slide_link }}" data-fancybox="" data-caption="{{ $slide->slide_title }}" data-fancybox-index="1">
                                                <img src="{{ asset('storage/app/'.$slide->slide_image) }}" class="w-100" alt="{{ $slide->slide_title }}">
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if(count($pCategories) > 0)
        @php $countCate = 0; @endphp
        @foreach($pCategories as $category)
            @php 
                $countCate++;
                $productToCategory = App\Models\ProductToCategory::where('category_id', $category->id)->take(4)->get();
            @endphp
            @if(count($productToCategory) > 0)
                <div class="section-category bg-white-light" style="padding-top: 20px;">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12 col-xs-12 col-md-12">
                                <div class="section-heading2">
                                    <div class="title">{{ $category->name }}</div>
                                    <div class="desc">{!! $category->description !!}</div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-xs-12 col-md-12">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-xs-12" style="padding-bottom: 35px;">
                                        <div class="bg-fixed" style="background-image: url('@if(!empty($category->image)) {{ asset('storage/app/'.$category->image) }} @else {{ asset('storage/app/uploads/default.png') }} @endif');"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-xs-12 col-md-12">
                                <div class="row" style="justify-content: center;">
                                    @foreach($productToCategory as $item)
                                        <div class="col-lg-3 col-md-3 col-xs-6 col-6">
                                            <div class="product-card card">
                                                <div class="card-header">
                                                    <a class="card-image ratio ratio-1x1" title="{{ $item->product->productDescription->name }}" href="{{ Illuminate\Support\Facades\Route::has('catalog.product') ? route('catalog.product', [$item->category->slug, $item->product->productDescription->slug]) : '#' }}">
                                                        <img src="@if(!empty($item->product->image)) {{ asset('storage/app/' . $item->product->image) }} @else {{ asset('storage/app/uploads/default.png') }} @endif" src="{{ asset('public/catalog/assets/img/lazy-load.png') }}" height="auto" width="100%" alt="{{ $item->product->productDescription->name }}">
                                                    </a>
                                                </div>
                                                <div class="card-body">
                                                    <div class="card-title">
                                                        <a title="{{ $item->product->productDescription->name }}" href="{{ Illuminate\Support\Facades\Route::has('catalog.product') ? route('catalog.product', [$item->category->slug, $item->product->productDescription->slug]) : '#' }}">{{ $item->product->productDescription->name }}</a>
                                                    </div>
                                                    <div class="card-bottom">
                                                        <div class="card-view">
                                                            <a title="Chi tiết {{ $item->product->productDescription->name }}" href="{{ Illuminate\Support\Facades\Route::has('catalog.product') ? route('catalog.product', [$item->category->slug, $item->product->productDescription->slug]) : '#' }}" class="button-theme button-theme_primary button-view"><span>Chi tiết</span></a>
                                                            <a 
                                                                href="#"
                                                                class="button-cart"
                                                                onclick="return false;"
                                                            >
                                                                <span>
                                                                    @if($item->product->price > 0)
                                                                        <strong>{{ number_format($item->product->price) }}đ</strong>
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
                            @if($category->slug != 'tester')
                                <div class="col-lg-12 col-xs-12 col-md-12 content-center mt-5">
                                    <a class="button-theme button-theme_secondary" href="{{ Illuminate\Support\Facades\Route::has('catalog.productCategory') ? route('catalog.productCategory', $category->slug) : '#' }}" title="Xem thêm về {{ $category->name }}" data-title="Xem thêm">
                                        <span>Xem thêm</span>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    @endif
    <div class="bg-activity" id="activity">
        <div class="section-gap section-article" style="padding: 100px 0 0 0;">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-xs-12 col-md-12">
                        <div class="section-heading">
                            <div class="title">HOẠT ĐỘNG CỦA CHÚNG TÔI</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section-gap section-article" style="padding: 0 0 25px 0;">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-xs-12 col-md-12">
                        <div class="section-heading">
                            <div class="title">Hình ảnh nổi bật</div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-xs-12 col-md-12">
                        @if(!empty($activityPosts))
                            <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff" class="swiper swiper-activity">
                                <div class="swiper-wrapper">
                                    @php $count = 0; @endphp
                                    @foreach($activityPosts as $post)
                                        <div class="swiper-slide">
                                            <a href="@if(!empty($post->post_image)) {{ asset('storage/app/'.$post->post_image) }} @else {{ asset('storage/app/uploads/default.png') }} @endif" data-thumb="@if(!empty($post->post_image)) {{ asset('storage/app/'.$post->post_image) }} @else {{ asset('storage/app/uploads/default.png') }} @endif" data-fancybox data-caption="{{ $post->post_title }}" data-fancybox-index="{{ $count }}">
                                                <img src="@if(!empty($post->post_image)) {{ asset('storage/app/'.$post->post_image) }} @else {{ asset('storage/app/uploads/default.png') }} @endif" class="w-100" alt="{{ $post->post_title }}">
                                            </a>
                                        </div>
                                        @php $count++; @endphp
                                    @endforeach
                                </div>
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                             </div>
                            <div thumbsSlider="" class="swiper swiper-activity-thumb">
                                <div class="swiper-wrapper">
                                    @foreach($activityPosts as $post)
                                        <div class="swiper-slide">
                                            <img src="@if(!empty($post->post_image)) {{ asset('storage/app/'.$post->post_image) }} @else {{ asset('storage/app/uploads/default.png') }} @endif" class="w-100" alt="{{ $post->post_title }}">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-xs-12 col-md-12">
                        <div class="section-heading mt-5">
                            <div class="title">Album ảnh</div>
                        </div>
                    </div>
                </div>
                @if(count($albums) > 0)
                    <div class="gallery-box">
                        <div class="row">
                            @foreach($albums as $image)
                                <div class="col-md-3 col-lg-3 col-xs-12">
                                    <a href="{{ Illuminate\Support\Facades\Route::has('catalog.gallery') ? route('catalog.gallery', $image->id) : '#' }}" class="galley-item">
                                        <div class="gallery-image">
                                            <img src="{{ asset('storage/app/'. $image->image_picture) }}" alt="{{ $image->image_name }}" class="w-100">
                                            <div class="gallery-overlay">
                                                <i class="fa fa-search"></i>
                                            </div>
                                        </div>
                                        <h2 class="gallery-title">{{ $image->image_name }}</h2>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="section-gap section-article" style="padding: 0 0 40px 0;">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-xs-12 col-md-12">
                        <div class="section-heading">
                            <div class="title">Video</div>
                        </div>
                    </div>
                    @if(count($videos) > 0)
                        <div class="col-lg-12 col-xs-12 col-md-12">
                            <div class="row">
                                <div class="col-lg-8 col-md-6 col-sm-6 col-xs-12">
                                    <div class="yt-holder" id="youtube-embed">
                                        <iframe width="560" height="315" src="https://www.youtube.com/embed/{{$lastedVideo}}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                                    <div class="playlist">
                                        <div class="playlist__header">
                                            <h2>DOCI Perfume Media Playlist</h2>
                                            <p>{{ count($videos) }} Videos</p>
                                        </div>
                                        <div class="playlist__body">
                                            <ul class="playlist__bars" id="playlist">
                                                @php $countVideo = 0; @endphp
                                                @foreach($videos as $video)
                                                    @php $countVideo++; @endphp
                                                    <li class="playlist__bars-item @if($countVideo == 1) active @endif" data-href="{{ $video->youtube }}">
                                                        <div class="playlist-thumb" style="background-image: url('@if(!empty($video->thumbnail)) {{ asset('storage/app/'.$video->thumbnail) }} @else {{ asset('storage/app/uploads/default.png') }} @endif');">
                                                            <img src="{{ asset('public/catalog/assets/public/upload/theme/logo-youtube.webp') }}" alt="logo-youtube">
                                                        </div>
                                                        <p>{{ $video->title }}</p>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="section-gap section-article bg-white-light" id="blog">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-xs-12 col-md-12 pt-5">
                    <div class="section-heading">
                        <div class="title">
                            Bài viết mới nhất						
                        </div>
                        <div class="desc">
                            Các bài viết, thông tin mới nhất từ DOCI Perfume
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-xs-12 col-md-12">
                    @if(count($articles) > 0)
                        <div class="xs-hidden">
                            <div class="row row-cols-lg-3 row-cols-1 row-cols-sm-2 g-3">
                                @foreach($articles as $article)
                                    <div class="col">
                                        <a href="{{ Illuminate\Support\Facades\Route::has('catalog.article') ? route('catalog.article', [$article->category_slug, $article->post_slug]) : '#' }}" class="article-card card">
                                            <div class="card-header">
                                                <img src="@if(!empty($article->post_image)) {{ asset('storage/app/'.$article->post_image) }} @else {{ asset('storage/app/uploads/default.png') }} @endif" height="240px" width="312px" class="mw-100 image-cover transition-default" alt="{{ $article->post_title }}">
                                            </div>
                                            <div class="card-body d-flex flex-column">
                                                <div class="card-meta"> Ngày đăng: {{ date_vi($article->post_created_at) }}</div>
                                                <h3 class="card-title">{{ $article->post_title }}</h3>
                                                <div class="card-text">
                                                    <p>{!! $article->post_summary !!}</p>
                                                </div>
                                                <div class="card-link mt-auto text-uppercase">
                                                    Xem chi tiết <i class="far fa-angle-right"></i>
                                                </div>
                                            </div>
                                        </a>							
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="slider-theme lg-hidden" id="slider-article">
							<div class="swiper swiper-initialized swiper-horizontal">
								<div class="owl-carousel owl-activity">
                                    @foreach($articles as $article)
                                        <div class="item">
                                            <a href="{{ \Illuminate\Support\Facades\Route::has('catalog.product') ? route('catalog.article', [$article->category_slug, $article->post_slug]) : '#' }}" class="article-card card">
                                                <div class="card-header">
                                                    <img src="@if(!empty($article->post_image)) {{ asset('storage/app/'.$article->post_image) }} @else {{ asset('storage/app/uploads/default.png') }} @endif" height="240px" width="312px" class="mw-100 image-cover transition-default" alt="Bí quyết chọn nước hoa phù hợp cho mọi cô gái">
                                                </div>
                                                <div class="card-body d-flex flex-column">
                                                    <div class="card-meta">
                                                        Ngày đăng:&nbsp;{{ date_vi($article->post_created_at) }}</div>
                                                    <h3 class="card-title">{{ $article->post_title }}</h3>
                                                    <div class="card-text">
                                                        <p>{!! $article->post_summary !!}</p>
                                                    </div>
                                                    <div class="card-link mt-auto text-uppercase">
                                                        Xem chi tiết <i class="far fa-angle-right"></i>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
						</div>
                    @endif
                </div>
            </div>
            <div class="col-lg-12 col-xs-12 col-md-12 content-center mt-3">
                <a  class="button-theme button-theme_secondary" href="{{ Illuminate\Support\Facades\Route::has('catalog.articles') ? route('catalog.articles') : '#' }}">
                    <span> Xem thêm </span>
                </a>
            </div>
        </div>
    </div>
    <div class="bg-activity">
        <div class="section-gap section-feedback">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-xs-12 col-md-12">
                        <div class="section-heading">
                            <div class="title">PHẢN HỒI TỪ KHÁCH HÀNG</div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-xs-12 col-md-12">
                        <div class="feedback">
                            <ul class="dots">
                                <li></li>
                                <li></li>
                                <li></li>
                            </ul>
                            <div class="feedback__col">
                                <p class="feedback__desc">Sản phẩm của DOCI rất tuyệt vời, hương rất thơm và giữ lâu lắm, giá lại phù hợp với học sinh. Sản phẩm vừa rẻ…</p>
                                <a href="#comments" class="feedback__link">
                                    <span>Xem thêm</span>
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                                <div class="feedback__user">
                                    <div class="user-avatar">
                                        <img src="{{ asset('public/catalog/assets/public/upload/feedback/D.png') }}" alt="Avatar">
                                    </div>
                                    <div class="user-info">
                                        <h4>Đăng Hoàng Khoa</h4>
                                        <p>0348 647 XXX</p>
                                    </div>
                                </div>
                            </div>
                            <div class="feedback__col">
                                <p class="feedback__desc">Công việc phải đi lại và gặp gỡ khá nhiều đối tác nên mình thường xuyên sử dụng nước hoa. DOCI cực kì ấn tượng …</p>
                                <a href="#comments" class="feedback__link">
                                    <span>Xem thêm</span>
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                                <div class="feedback__user">
                                    <div class="user-avatar">
                                        <img src="{{ asset('public/catalog/assets/public/upload/feedback/N.png') }}" alt="Avatar">
                                    </div>
                                    <div class="user-info">
                                        <h4>Nguyễn Quốc Anh</h4>
                                        <p>0792 486 XXX</p>
                                    </div>
                                </div>
                            </div>
                            <div class="feedback__col">
                                <p class="feedback__desc">Cảm ơn DOCI vì sản phẩm rất chất lượng, nước hoa rất thơm, mẫu mã đẹp và đặc biệt là mùi thơm lưu lại từ sáng đến …</p>
                                <a href="#comments" class="feedback__link">
                                    <span>Xem thêm</span>
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                                <div class="feedback__user">
                                    <div class="user-avatar">
                                        <img src="{{ asset('public/catalog/assets/public/upload/feedback/T.png') }}" alt="Avatar">
                                    </div>
                                    <div class="user-info">
                                        <h4>Trần Đình Nam</h4>
                                        <p>0784 714 XXX</p>
                                    </div>
                                </div>
                            </div>
                            <div class="feedback__col">
                                <p class="feedback__desc">Mình đã từng sử dụng nước hoa nhiều nơi. Nhưng mua ở DOCI thích nhất ở đặc điểm thơm bền, lâu, mùi chuẩn auth …</p>
                                <a href="#comments" class="feedback__link">
                                    <span>Xem thêm</span>
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                                <div class="feedback__user">
                                    <div class="user-avatar">
                                        <img src="{{ asset('public/catalog/assets/public/upload/feedback/L.png') }}" alt="Avatar">
                                    </div>
                                    <div class="user-info">
                                        <h4>Lê Huỳnh Diễm My</h4>
                                        <p>0981 090 XXX</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div  id="comments">
            <div class="section-gap section-comments" style="padding-top: 150px; padding-bottom: 10px;">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-xs-6 col-lg-12 col-xs-12 col-md-12 content-center">
                        <h2>
                            <span class="text-blue-bold content-center font-42 font-w-600">
                               <span align="center">Đóng góp ý kiến để chúng tôi được phục vụ bạn tốt hơn</span>
                            </span>
                        </h2>
                    </div>
                    <div class="col-lg-6 col-xs-6 col-lg-12 col-xs-12 col-md-12">
                        <form class="form-comments" action="{{ Illuminate\Support\Facades\Route::has('catalog.sendComment') ? route('catalog.sendComment') : '#' }}" method="POST" id="comment-form">
                            @csrf
                            <div class="form-group">
                                <label class="required">Nhập tên</label>
                                <input type="text" placeholder="Nhập tên" name="name" required>
                                <span class="error_name error"></span>
                            </div>
                            <div class="form-group">
                                <label class="required">Số điện thoại</label>
                                <input type="number" placeholder="Nhập số điện thoại" name="phone" required>
                                <span class="error_phone error"></span>
                            </div>
                            <div class="form-group">
                                <label class="required">Nội dung</label>
                                <textarea name="content" rows="5" placeholder="Nhập nội dung" required></textarea>
                                <span class="error_content error"></span>
                            </div>
                            <div class="form-action content-center">
                                <button type="submit" class="btn-send-comment">
                                    <i class="fa fa-paper-plane" aria-hidden="true"></i>
                                    <span>Gửi</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
    <div class="section-gap section-find-seller bg-white-light" id="contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-xs-6 col-lg-12 col-xs-12 col-md-12">
                    <h2>
                        <span class="text-blue-bold content-center font-40 font-w-600">
                            Tra cứu seller
                        </span>
                    </h2>
                </div>
                <div class="col-lg-6 col-xs-6 col-lg-12 col-xs-12 col-md-12">
                    <form class="find-seller-form" action="{{ Illuminate\Support\Facades\Route::has('catalog.getSeller') ? route('catalog.getSeller') : '#' }}" method="get">
                        <input type="number" placeholder="Nhập số điện thoại" class="phone-seller" required>
                        <button type="submit">Tìm</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('public/catalog/assets/view/theme_user/index/js/index.js') }}" type="text/javascript"></script>
<script>
    let renderVideo = (link) => {
        var youtubeId = link.replace("https://www.youtube.com/watch?v=", "");;
        return `
            <iframe width="560" height="315" src="https://www.youtube.com/embed/${youtubeId}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
        `;
    }

    let togglePlaylist = () => {
        $('#playlist > .playlist__bars-item').click(function() {
            // hover actrive item
            $('.playlist__bars-item').removeClass('active');
            $(this).closest('.playlist__bars-item').addClass('active');
            // render to video
            var linkYoutube = $(this).attr('data-href');
            $('#youtube-embed').html(renderVideo(linkYoutube));
        });
    }

    let sendComment = () => {
        $('#comment-form').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                dataType: 'json',
                data: $(this).serialize(),
                beforeSend: function() {
                    $('.btn-send-comment').html('<i class="fa fa-paper-plane" aria-hidden="true"></i>Đang gửi..');
                    $('.error').html('');
                },
                success: function(res) {
                    $('.btn-send-comment').html('<i class="fa fa-paper-plane" aria-hidden="true"></i> Gửi');
                    if(res.status == 200) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Thành công',
                            text: res.message,
                            buttonsStyling: false,
                            showConfirmButton: true,
                            showCancelButton: false,
                            buttonsCancelColor: 'red',
                            confirmButtonText: 'Đóng lại',
                            customClass: {
                                confirmButton: 'btn btn-danger btn-no_effect'
                            },
                        }).then((res) => {
                            if (res.isConfirmed || res.isDismissed) {
                                $('#comment-form')[0].reset();
                            }
                        });
                    }
                    
                    if(res.status == 'E1') {
                        $.map(res.message, function(value, key) {
                            $('.error_'+key).html(value);
                        });
                    }
                    
                    if(res.status == 'E0') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Có lỗi xảy ra',
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
                                $('.btn-send-comment').html('<i class="fa fa-paper-plane" aria-hidden="true"></i> Gửi');
                                $('body').css({'overflow': 'auto', 'height': '100%'});
                                $('#frmSearch-result').html('').removeClass('is-show');
                                document.removeEventListener('touchmove', handleTouchMoveSearch);
                            }
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Có lỗi xảy ra',
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
                            $('.btn-send-comment').html('<i class="fa fa-paper-plane" aria-hidden="true"></i> Gửi');
                            $('body').css({'overflow': 'auto', 'height': '100%'});
                            $('#frmSearch-result').html('').removeClass('is-show');
                            document.removeEventListener('touchmove', handleTouchMoveSearch);
                        }
                    });
                }
            });
        });
    }

    let findSeller = () => {
        $('.find-seller-form').submit(function(e) {
            e.preventDefault();
            let url = $(this).attr('action')+'?sdt='+$('.phone-seller').val();
            location.href = url;
        });
    }

    $(function() {
        if(/iPhone|iPad|iPod/i.test(navigator.userAgent) ) {
            $('.bg-fixed').addClass('ios');
        }
        $(window).scroll(function() {
            var fromtop = $(this).scrollTop();
            $(".bg-fixed-mobile").css({"background-position-y": fromtop+"px"});
        });

        sendComment();
        findSeller();
        togglePlaylist();
    });
</script>
@endsection