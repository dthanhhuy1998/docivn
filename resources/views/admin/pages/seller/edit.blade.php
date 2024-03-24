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
        <form action="{{ route('admin.seller.postEdit') }}" role="form" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" value="{{ $seller->id }}" name="id">
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
                                    <img src="@if(!empty($seller->Banner)) {{ asset('storage/app/'.$seller->Banner) }} @else {{ asset('storage/app/uploads/default.png') }} @endif" alt="banner" id="banner-preview">
                                </div>
                                <input type="file" onchange="imagePreview(event, 'banner-preview')" name="banner" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Cấp bậc</label>
                                <select name="level" class="form-control">
                                    <option value="Đại lý" @if($seller->CapBac == 'Đại lý') selected @endif>Đại lý</option>
                                    <option value="Đại lý cao cấp" @if($seller->CapBac == 'Đại lý cao cấp') selected @endif>Đại lý cao cấp</option>
                                    <option value="Tổng đại lý" @if($seller->CapBac == 'Tổng đại lý') selected @endif>Tổng đại lý</option>
                                    <option value="Nhà phân phối" @if($seller->CapBac == 'Nhà phân phối') selected @endif>Nhà phân phối</option>
                                    <option value="CEO" @if($seller->CapBac == 'CEO') selected @endif>CEO</option>
                                </select>
                            </div>
                            <div class="form-group @error('sellerName') has-error @enderror">
                                <label>Tên Seller</label>
                                <input type="text" class="form-control" placeholder="Nhập họ tên Seller" value="{{ $seller->TenSeller }}" name="sellerName" required>
                                @error('sellerName')<span class="help-block">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group">
                                <label>Ảnh đại diện</label>
                                <div class="preview-image" style="width: 200px; height: auto;">
                                    <img src="@if(!empty($seller->AnhDaiDien)) {{ asset('storage/app/'.$seller->AnhDaiDien) }} @else {{ asset('storage/app/uploads/default.png') }} @endif" alt="Avatar" id="avatar-preview">
                                </div>
                                <input type="file" onchange="imagePreview(event, 'avatar-preview')" name="avatar" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Facebook</label>
                                <input type="text" class="form-control" placeholder="Nhập link chia sẽ từ facebook" value="{{ $seller->LinkFacebook }}" name="facebookLink">
                            </div>
                            <div class="form-group @error('numberPhone') has-error @enderror">
                                <label>Số điện thoại</label>
                                <input type="number" class="form-control" placeholder="Nhập số điện thoại" value="{{ $seller->SoDienThoai }}" name="numberPhone" required>
                                @error('numberPhone')<span class="help-block">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group">
                                <label>Khu vực</label>
                                <input type="text" class="form-control" placeholder="Nhập địa chỉ khu vực" value="{{ $seller->KhuVuc }}" name="areaName">
                            </div>
                            <div class="form-group">
                                <label>Trực thuộc</label>
                                <input type="text" class="form-control" value="{{ $seller->TrucThuoc }}" name="ownerName">
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