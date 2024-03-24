@extends('admin.common.layout')

@section('title')
    {!! $headingTitle !!}
@endsection

@section('content')
   <!-- Content Header (Page header) -->
   <section class="content-header">
        <h1>Chỉnh sửa video</h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.index') }}"><i class="fa fa-th"></i> Trang chính</a></li>
            <li><a href="{{ route('admin.video.getList') }}"><i class="fa fa-video-camera"></i> Video</a></li>
            <li class="active">Chỉnh sửa video</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <form action="{{ route('admin.gallery.detail.update') }}" role="form" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" value="{{ $image->id }}" name="id">
            <input type="hidden" value="{{ $imageId }}" name="image_id">
            <div class="row">
                <div class="col-md-12">
                    <div class="btn-group">
                        <a href="{{ route('admin.gallery.show', $imageId) }}" class="btn btn-default btn-sm mr-1" title="Quay lại"><i class="fa fa-angle-left"></i> Quay lại</a>
                        <button type="submit" class="btn btn-primary btn-sm" title="Lưu lại"><i class="fa fa-save"></i> Lưu lại</button>
                    </div>
                </div>
                <div class="col-md-6 col-xs-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Chỉnh sửa album</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group @error('title') has-error @enderror">
                                <label>Tiêu đề</label>
                                <input type="text" class="form-control" placeholder="Nhập tiêu đề" value="{{ $image->image_name }}" name="title">
                                @error('title')<span class="help-block">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group @error('file') has-error @enderror">
                                <label>Ảnh thu nhỏ</label>
                                <div class="preview-image" style="width: 250px; height: 168px;">
                                    <img src="@if(!empty($image->image_picture)) {{ asset('storage/app/'.$image->image_picture) }} @else {{ asset('storage/app/uploads/default.png') }} @endif" alt="Avatar" id="preview">
                                </div>
                                <input type="file" onchange="filePreview(event)" class="form-control" name="file">
                                @error('file')<span class="help-block">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group">
                                <label>Thứ tự</label>
                                <input type="number" class="form-control" name="image_sort" value="{{ $image->image_sort }}"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
    <!-- /.content -->
@endsection
@section('script')
    <script>
        $(function () {
            // Editor
            $('.textarea').wysihtml5()
        })
    </script>
@endsection