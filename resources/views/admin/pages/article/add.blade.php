@extends('admin.common.layout')

@section('title')
    {!! $headingTitle !!}
@endsection

@section('content')
   <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>{{ $titlePage }}</h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.index') }}"><i class="fa fa-th"></i> Trang chính</a></li>
            <li><a href="#"><i class="fa fa-newspaper-o"></i> Bài viết</a></li>
            <li class="active">{{ $titlePage }}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <form action="{{ route('admin.article.postAdd') }}" role="form" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="btn-group">
                        <button type="submit" class="btn btn-primary btn-sm mr-1" title="Lưu lại"><i class="fa fa-save"></i> Lưu lại</button>
                        <a href="{{ route('admin.article.getList') }}" class="btn btn-default btn-sm" title="Hủy bỏ"><i class="fa fa-undo"></i> Quay lại</a>
                    </div>
                </div>
                <div class="col-md-12">
                    @if ($errors->any())
                    <div class="alert alert-error alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true" control-id="ControlID-6">×</button>
                        <h4><i class="fa fa-times-circle"></i> Lỗi</h4>
                        Có vẻ như bạn điền chưa đầy đủ thông tin. Hãy kiểm tra lại nhé!
                    </div>
                    @endif
                </div>
                <div class="col-md-12">
                    <!-- Custom Tabs -->
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#general" data-toggle="tab">Chung</a></li>
                            <li><a href="#seo" data-toggle="tab">SEO</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="general">
                                <div class="form-group @error('title') has-error @enderror">
                                    <label><strong class="color-red font-15">*</strong> Tiêu đề bài viết</label>
                                    <input type="text" class="form-control" placeholder="Nhập tiêu đề bài viết" value="{{ old('title') }}" name="title">
                                    @error('title')
                                        <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group @error('categories') has-error @enderror">
                                    <label><strong class="color-red font-15">*</strong> Danh mục</label>
                                    <select name="categories[]" class="form-control select2" multiple="multiple" data-placeholder=" Chọn danh mục" style="width: 100%;">
                                        @foreach($categories as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('categories')
                                        <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Mô tả ngắn</label>
                                    <textarea name="summary" rows="8" class="form-control textarea" placeholder="Nhập mô tả">{{ old('summary') }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Nội dung bài viết</label>
                                    <textarea name="content" rows="8" class="form-control" id="editor1" placeholder="Nhập nội dung bài viết">{{ old('content') }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Hình ảnh</label>
                                    <div class="preview-image">
                                        <img src="{{ asset('storage/app/uploads/default.png') }}" alt="Image" id="preview">
                                    </div>
                                    <input type="file" onchange="filePreview(event)" name="file">
                                </div>
                                <div class="form-group">
                                    <label>Vị trí</label>
                                    <input type="number" class="form-control" placeholder="Vị trí" value="0" name="sortOrder">
                                </div>
                                <div class="form-group">
                                    <label>Trạng thái</label>
                                    <select name="status" class="form-control">
                                        <option value="1">Công khai</option>
                                        <option value="0">Bản nháp</option>
                                    </select>
                                </div>
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="seo">
                                <div class="form-group @error('metaTitle') has-error @enderror">
                                    <label><strong class="color-red font-15">*</strong> Thẻ tiêu đề</label>
                                    <input type="text" class="form-control" placeholder="Nhập tiêu đề" value="{{ old('metaTitle') }}" name="metaTitle">
                                    @error('metaTitle')
                                        <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Thẻ mô tả</label>
                                    <textarea class="form-control" rows="5" cols="40" name="metaDescription" placeholder="Nhập mô tả ngắn">{{ old('metaDescription') }}</textarea>
                                </div>
                                <div class="form-groupr">
                                    <label>Từ khóa</label>
                                    <textarea class="form-control" rows="5" cols="30" name="metaTagKeywords" placeholder="Nhập từ khóa tìm kiếm trên Google">{{ old('metaDescription') }}</textarea>
                                </div>
                            </div>
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div>
                    <!-- nav-tabs-custom -->
                </div>
            </div>
        </form>
    </section>
    <!-- /.content -->
@endsection

@section('script')
<!-- CK Editor -->
<script src="{{ asset('public/admin/assets/bower_components/ckeditor/ckeditor.js') }}"></script>
<script>
    $(function () {
        // Initialize Select2 Elements
        $('.select2').select2()

        // Editor
        $('.textarea').wysihtml5()
        var options = {
            filebrowserImageBrowseUrl: '{{ config("app.url") }}admin/laravel-filemanager?type=Images',
            filebrowserImageUploadUrl: '{{ config("app.url") }}admin/laravel-filemanager/upload?type=Images&_token=',
            filebrowserBrowseUrl: '{{ config("app.url") }}admin/laravel-filemanager?type=Files',
            filebrowserUploadUrl: '{{ config("app.url") }}admin/laravel-filemanager/upload?type=Files&_token='
        };
        CKEDITOR.replace('editor1', options);
    })
</script>
@endsection