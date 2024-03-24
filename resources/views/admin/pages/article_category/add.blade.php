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
            <li><a href="#">Danh mục</a></li>
            <li class="active">{{ $titlePage }}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <form action="{{ route('admin.article.category.postAdd') }}" role="form" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="btn-group">
                        <button type="submit" class="btn btn-primary btn-sm mr-1" title="Lưu lại"><i class="fa fa-save"></i> Lưu lại</button>
                        <a href="{{ route('admin.article.category.getList') }}" class="btn btn-default btn-sm" title="Hủy bỏ"><i class="fa fa-undo"></i> Quay lại</a>
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
                                <div class="form-group @error('categoryName') has-error @enderror">
                                    <label><strong class="color-red font-15">*</strong> Tên danh mục</label>
                                    <input type="text" class="form-control" placeholder="Nhập tên danh mục" value="{{ old('categoryName') }}" name="categoryName">
                                    @error('categoryName')
                                        <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Danh mục cha</label>
                                    <select name="parentId" class="form-control">
                                        <option value="0">--- Danh mục gốc ---</option>
                                        @foreach($articleCategories as $articleCategory)
                                            <option value="{{ $articleCategory->id }}">{{ $articleCategory->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Mô tả</label>
                                    <textarea name="description" rows="8" class="form-control textarea" placeholder="Nhập mô tả">{{ old('description') }}</textarea>
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
                                        <option value="1">Hiển thị</option>
                                        <option value="0">Vô hiệu hóa</option>
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
                                    <textarea class="form-control" rows="5" cols="40" name="metaDescription" placeholder="Nhập mô tả">{{ old('metaDescription') }}</textarea>
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

<?php
    function showCategories($categories, $parent_id = 0, $char = '') {
        foreach($categories as $key => $item) {
            if($item->parent_id == $parent_id) {

                echo '<option value="'.$item->id.'">'.$item->name.'</option>';

                unset($categories[$key]);

                showCategories($categories, $item->id, $char = '--');
            }
        }
    }

?>

@section('script')
<script>
  $(function () {
    $('.textarea').wysihtml5()
  })
</script>
@endsection