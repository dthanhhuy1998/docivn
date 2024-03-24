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
            <li><a href="{{ route('admin.partner.getList') }}"><i class="fa fa-link"></i> Đối tác liên kết</a></li>
            <li class="active">{{ $pageTitle }}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <form action="{{ route('admin.partner.postAdd') }}" role="form" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="btn-group">
                        <a href="{{ route('admin.partner.getList') }}" class="btn btn-default btn-sm mr-1" title="Quay lại"><i class="fa fa-angle-left"></i> Quay lại</a>
                        <button type="submit" class="btn btn-primary btn-sm" title="Lưu lại"><i class="fa fa-save"></i> Lưu lại</button>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"> {{ $pageTitle }}</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group  @error('file') has-error @enderror">
                                <label>Ảnh logo</label>
                                <div class="preview-image" style="width: 100px; height: auto;">
                                    <img src="{{ asset('storage/app/uploads/default.png') }}" alt="Avatar" id="preview">
                                </div>
                                <input type="file" onchange="filePreview(event)" name="file">
                                @error('file')
                                    <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Đường dẫn liên kết</label>
                                <input type="text" class="form-control" placeholder="Nhập đường dẫn liên kết" value="{{ old('link') }}" name="link">
                            </div>
                            <div class="form-group">
                                <label>Vị trí</label>
                                <input type="number" class="form-control" placeholder="Nhập vị trí slide hiển thị" value="{{ old('sortOrder') }}" name="sortOrder">
                            </div>
                            <div class="form-group">
                                <label>Trang chủ</label>
                                <select name="status" class="form-control">
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