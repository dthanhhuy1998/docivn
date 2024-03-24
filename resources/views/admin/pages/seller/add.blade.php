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
            <li><a href="{{ route('admin.seller.getList') }}"><i class="fa fa-street-view"></i> Quản lý Seller</a></li>
            <li class="active">{{ $pageTitle }}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <form action="{{ route('admin.seller.postAdd') }}" role="form" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="btn-group">
                        <a href="{{ route('admin.seller.getList') }}" class="btn btn-default btn-sm mr-1" title="Quay lại"><i class="fa fa-angle-left"></i> Quay lại</a>
                        <button type="submit" class="btn btn-primary btn-sm" title="Lưu lại"><i class="fa fa-save"></i> Lưu lại</button>
                    </div>
                </div>
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"> {{ $pageTitle }}</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label>Banner</label>
                                <div class="banner-preview">
                                    <img src="{{ asset('storage/app/uploads/default.png') }}" alt="banner" id="banner-preview">
                                </div>
                                <input type="file" onchange="imagePreview(event, 'banner-preview')" name="banner" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Cấp bậc</label>
                                <select name="level" class="form-control">
                                    <option value="Đại lý">Đại lý</option>
                                    <option value="Đại lý cao cấp">Đại lý cao cấp</option>
                                    <option value="Tổng đại lý">Tổng đại lý</option>
                                    <option value="Nhà phân phối">Nhà phân phối</option>
                                    <option value="CEO">CEO</option>
                                </select>
                            </div>
                            <div class="form-group @error('sellerName') has-error @enderror">
                                <label>Tên Seller</label>
                                <input type="text" class="form-control" placeholder="Nhập họ tên Seller" value="{{ old('sellerName') }}" name="sellerName" required>
                                @error('sellerName')<span class="help-block">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group">
                                <label>Ảnh đại diện</label>
                                <div class="preview-image" style="width: 200px; height: auto;">
                                    <img src="{{ asset('storage/app/uploads/default.png') }}" alt="Avatar" id="avatar-preview">
                                </div>
                                <input type="file" onchange="imagePreview(event, 'avatar-preview')" name="avatar" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Facebook</label>
                                <input type="text" class="form-control" placeholder="Nhập link chia sẽ từ facebook" value="{{ old('facebookLink') }}" name="facebookLink">
                            </div>
                            <div class="form-group @error('numberPhone') has-error @enderror">
                                <label>Số điện thoại</label>
                                <input type="number" class="form-control" placeholder="Nhập số điện thoại" value="{{ old('numberPhone') }}" name="numberPhone" required>
                                @error('numberPhone')<span class="help-block">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group">
                                <label>Khu vực</label>
                                <input type="text" class="form-control" placeholder="Nhập địa chỉ khu vực" value="{{ old('areaName') }}" name="areaName">
                            </div>
                            <div class="form-group">
                                <label>Trực thuộc</label>
                                <input type="text" class="form-control" value="{{ old('ownerName') }}" name="ownerName">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3"></div>
            </div>
        </form>
    </section>
    <!-- /.content -->
@endsection