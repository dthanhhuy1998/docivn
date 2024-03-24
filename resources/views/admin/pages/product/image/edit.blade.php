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
            <li><a href="#"><i class="fa fa-cubes"></i> Sản phẩm</a></li>
            <li class="active">{{ $pageTitle }}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <form action="{{ route('admin.product.image.postEditImage') }}" role="form" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" value="{{ $productId }}" name="productId">
            <input type="hidden" value="{{ $image->id }}" name="id">
            <div class="row">
                <div class="col-md-12">
                    <div class="btn-group">
                        <a href="{{ route('admin.product.getList') }}" class="btn btn-default btn-sm mr-1" title="Hủy bỏ"><i class="fa fa-long-arrow-left"></i> Quay lại</a>
                        <button type="submit" class="btn btn-primary btn-sm mr-1" title="Lưu lại"><i class="fa fa-save"></i> Lưu lại</button>
                    </div>
                </div>
                <div class="col-md-12">
                    @if(session('success_msg'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true" control-id="ControlID-6">×</button>
                        <h4><i class="icon fa fa-check"></i> Thành công</h4>
                        {{ session('success_msg') }}
                    </div>
                    @endif
                </div>
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-edit"></i> Chỉnh sửa ảnh</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group @error('image') has-error @enderror">
                                <label><strong class="color-red font-15">*</strong> Ảnh bổ sung</label>
                                <div class="preview-image">
                                    <img src="@if(!empty($image->image)) {{ asset('storage/app/' . $image->image) }} @else {{ asset('storage/app/uploads/default.png') }} @endif" alt="Avatar" id="preview">
                                </div>
                                <input type="file" onchange="filePreview(event)" name="image">
                                @error('image')
                                    <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Sắp xếp</label>
                                <input type="number" class="form-control" placeholder="0" value="{{ $image->sort_order }}" name="sortOrder">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /. col -->
            </div>
        </form>
    </section>
    <!-- /.content -->
@endsection