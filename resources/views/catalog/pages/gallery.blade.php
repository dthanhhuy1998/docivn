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
            @if(count($images) > 0)
                <div class="row">
                     <div class="col-lg-12 col-md-12 col-xs-12">
                          <div class="section-heading2" style="margin-top: 0;">
                            <div class="title">{{ $album->image_name }}</div>
                        </div>
                     </div>
                </div>
                <div class="row" id="animated-thumbnails-gallery">
                    @foreach($images as $image)
                        <a class="col-lg-3 col-md-3 col-xs-12 mb-3" style="border-radius: 6px; overflow: hidden; display: block;" href="{{ asset('storage/app/'.$image->image_picture) }}">
                            <img src="{{ asset('storage/app/'.$image->image_picture) }}" class="w-100" />
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    lightGallery(document.getElementById('animated-thumbnails-gallery'), {
        thumbnail: true,
    });
</script>
@endsection