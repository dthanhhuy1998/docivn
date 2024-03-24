@extends('admin.common.layout')

@section('title')
    {!! $headingTitle !!}
@endsection

@section('content')
   <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>{{ $pageTitle }}</h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.index') }}"><i class="fa fa-th"></i> Trang chính</a></li>
            <li><a href="{{ route('admin.customer.getReviews') }}"><i class="fa fa-users"></i> Đánh giá khách hàng</a></li>
            <li class="active">{{ $pageTitle }}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <form action="{{ route('admin.customer.postEditReview') }}" role="form" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" value="{{ $review->id }}" name="id">
            <div class="row">
                <div class="col-md-12">
                    <div class="btn-group">
                        <a href="{{ route('admin.customer.getReviews') }}" class="btn btn-default btn-sm mr-1" title="Quay lại"><i class="fa fa-angle-left"></i> Quay lại</a>
                        <button type="submit" class="btn btn-primary btn-sm" title="Lưu lại"><i class="fa fa-save"></i> Lưu lại</button>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"> {{ $pageTitle }}</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group @error('crName') has-error @enderror">
                                <label><strong class="color-red font-15">*</strong> Tên khách hàng</label>
                                <input type="text" class="form-control" placeholder="Nhập tên khách hàng" value="{{ $review->cr_name }}" name="crName">
                                @error('crName')
                                    <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Chức vụ/Vị trí</label>
                                <input type="text" class="form-control" placeholder="Nhập chức vụ/Vị trí" value="{{ $review->cr_position }}" name="crPosition">
                            </div>
                            <div class="form-group">
                                <label>Ảnh đại diện</label>
                                <div class="preview-image">
                                    <img src="@if(!empty($review->cr_image)) {{ asset('storage/app/' . $review->cr_image) }} @else {{ asset('storage/app/uploads/default.png') }} @endif" alt="Avatar" id="preview">
                                </div>
                                <input type="file" onchange="filePreview(event)" name="file">
                            </div>
                            <div class="form-group">
                                <label>Đánh giá khách hàng</label>
                                <textarea name="crText" class="form-control" placeholder="Nhập đánh giá khách hàng" rows="4">{{ $review->cr_text }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Trang chủ</label>
                                <select name="crStatus" class="form-control">
                                    <option value="1">Hiển thị</option>
                                    <option value="0">Không hiển thị</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
    <!-- /.content -->
@endsection