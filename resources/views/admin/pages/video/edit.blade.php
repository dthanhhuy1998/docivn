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
        <form action="{{ route('admin.video.postEdit') }}" role="form" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" value="{{ $video->id }}" name="id">
            <div class="row">
                <div class="col-md-12">
                    <div class="btn-group">
                        <a href="{{ route('admin.video.getList') }}" class="btn btn-default btn-sm mr-1" title="Quay lại"><i class="fa fa-angle-left"></i> Quay lại</a>
                        <button type="submit" class="btn btn-primary btn-sm" title="Lưu lại"><i class="fa fa-save"></i> Lưu lại</button>
                    </div>
                </div>
                <div class="col-md-6 col-xs-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Video: {{ $video->title }}</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group @error('title') has-error @enderror">
                                <label>Tiêu đề</label>
                                <input type="text" class="form-control" placeholder="Nhập tiêu đề video" value="{{ $video->title }}" name="title">
                                @error('title')<span class="help-block">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group">
                                <label>Tiêu đề</label>
                                <textarea name="description" class="form-control textarea" rows="8" placeholder="Mô tả ngắn về video">{{ $video->description }}</textarea>
                            </div>
                            <div class="form-group @error('file') has-error @enderror">
                                <label>Ảnh thu nhỏ (thumbnail)</label>
                                <div class="preview-image" style="width: 250px; height: 168px;">
                                    <img src="@if(!empty($video->thumbnail)) {{ asset('storage/app/'.$video->thumbnail) }} @else {{ asset('storage/app/uploads/default.png') }} @endif" alt="Avatar" id="preview">
                                </div>
                                <input type="file" onchange="filePreview(event)" class="form-control" name="file">
                                @error('file')<span class="help-block">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group @error('link') has-error @enderror">
                                <label>Đường dẫn video</label>
                                <input type="text" class="form-control" placeholder="Đường dẫn video từ youtube (VD: https://www.youtube.com/watch?v=ushOXEf7Fzc)" value="{{ $video->youtube }}" name="link">
                                @error('link')<span class="help-block">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group">
                                <label>Trang chủ</label>
                                <select name="status" class="form-control">
                                    <option value="1" @if($video->status == 1) selected @endif>Hiển thị</option>
                                    <option value="0" @if($video->status == 0) selected @endif>Không hiển thị</option>
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
@section('script')
    <script>
        $(function () {
            // Editor
            $('.textarea').wysihtml5()
        })
    </script>
@endsection