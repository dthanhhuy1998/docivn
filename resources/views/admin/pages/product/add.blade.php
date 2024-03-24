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
            <li><a href="{{ route('admin.product.getList') }}"><i class="fa fa-cubes"></i> Sản phẩm</a></li>
            <li class="active">{{ $pageTitle }}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <form action="{{ route('admin.product.postAdd') }}" role="form" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="btn-group">
                        <a href="{{ route('admin.product.getList') }}" class="btn btn-default btn-sm mr-1" title="Hủy bỏ"><i class="fa fa-long-arrow-left"></i> Quay lại</a>
                        <button type="submit" class="btn btn-primary btn-sm mr-1" title="Lưu lại"><i class="fa fa-save"></i> Lưu lại</button>
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
                            <li><a href="#data" data-toggle="tab">Dữ liệu</a></li>
                            <li><a href="#image" data-toggle="tab">Hình ảnh</a></li>
                            {{-- <li><a href="#links" data-toggle="tab">Liên kết</a></li> --}}
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="general">
                                <div class="form-group @error('name') has-error @enderror">
                                    <label><strong class="color-red font-15">*</strong> Tên sản phẩm</label>
                                    <input type="text" class="form-control" placeholder="Nhập tên sản phẩm" value="{{ old('name') }}" name="name">
                                    @error('name')
                                        <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Mô tả ngắn</label>
                                    <textarea name="description" rows="8" class="form-control textarea" placeholder="Nhập mô tả">{{ old('description') }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Chi tiết sản phẩm</label>
                                    <textarea name="detail" rows="8" class="form-control" id="editor1">{{ old('detail') }}</textarea>
                                </div>
                                <div class="form-group @error('metaTitle') has-error @enderror">
                                    <label><strong class="color-red font-15">*</strong> Thẻ tiêu đề</label>
                                    <input type="text" class="form-control" placeholder="Nhập thẻ tiêu đề" value="{{ old('metaTitle') }}" name="metaTitle">
                                    @error('metaTitle')
                                        <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Thẻ mô tả ngắn</label>
                                    <textarea class="form-control" rows="6" cols="40" name="metaDescription" placeholder="Nhập thẻ mô tả ngắn">{{ old('metaDescription') }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Từ khóa</label>
                                    <textarea class="form-control" rows="6" cols="40" name="metaKeywords" placeholder="Nhập từ khóa tìm kiếm trên Google">{{ old('metaKeywords') }}</textarea>
                                </div>
                                <div class="form-groupr">
                                    <label>Thẻ Tag</label>
                                    <input type="text" class="form-control" name="productTag" placeholder="VD: Tag 1, Tag 2,.." value="{{ old('productTag') }}">
                                </div>
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="data">
                                <div class="form-group  @error('sku') has-error @enderror">
                                    <label>Mã sản phẩm - SKU</label>
                                    <input type="text" class="form-control" placeholder="Nhập mã sản phẩm (Nếu để trống sẽ tự tạo mã)" value="{{ old('sku') }}" name="sku">
                                    @error('sku')
                                        <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group @error('categories') has-error @enderror">
                                    <label><strong class="color-red font-15">*</strong> Danh mục</label>
                                    <select name="categories[]" class="form-control select2" multiple="multiple" data-placeholder=" Chọn danh mục" style="width: 100%;">
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @if(count($category->subCategories) > 0)
                                                @foreach($category->subCategories as $subCategory)
                                                <option value="{{ $subCategory->id }}">{{ $category->name }} > {{ $subCategory->name }}</option>
                                                @endforeach
                                            @endif
                                        @endforeach
                                    </select>
                                    @error('categories')
                                        <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <!-- <div class="form-group">
                                    <label>Nhóm hàng</label>
                                    <select name="groups[]" class="form-control select2" multiple="multiple" data-placeholder=" Chọn nhóm hàng" style="width: 100%;">
                                        @foreach($groups as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div> -->
                                <div class="form-group">
                                    <label>Giá gốc</label>
                                    <input type="number" class="form-control" placeholder="Nhập giá gốc" value="{{ old('originalPrice') }}" name="originalPrice">
                                </div>
                                <div class="form-group">
                                    <label>Giá bán</label>
                                    <input type="number" class="form-control" placeholder="Nhập giá bán ra" value="{{ old('price') }}" name="price">
                                </div>
                                <div class="form-group">
                                    <label>Tồn kho</label>
                                    <input type="number" class="form-control" placeholder="Số lượng tồn kho" value="{{ old('quantity') }}" name="quantity">
                                </div>
                                <div class="form-group">
                                    <label>Đã bán</label>
                                    <input type="text" class="form-control" placeholder="Nhập số lượng đã bán" value="{{ old('sold') }}" name="sold">
                                </div>
                                <div class="form-group">
                                    <label>Vị trí</label>
                                    <input type="number" class="form-control" placeholder="Nhập vị trí xếp hạng" value="{{ old('sortOrder') }}" name="sortOrder">
                                </div>
                                <div class="form-group">
                                    <label>Tình trạng tồn kho</label>
                                    <select name="stockStatus" class="form-control">
                                        @foreach($status as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Nổi bật</label>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="featured" value="1" checked>
                                            Có
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="featured" value="0">
                                            Không
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Tình trạng</label>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="status" value="1" checked="">
                                            Đang bán
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="status" value="0">
                                            Ngừng bán
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Trang chủ</label>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="display" value="1" checked>
                                            Hiển thị
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="display" value="0">
                                            Ẩn
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="image">
                                <div class="form-group">
                                    <label>Ảnh thumbnail</label>
                                    <div class="preview-image">
                                        <img src="{{ asset('storage/app/uploads/default.png') }}" alt="Image" id="preview">
                                    </div>
                                    <input type="file" onchange="filePreview(event)" name="image">
                                </div>
                                <!-- <table class="table table-bordered table-striped">
                                    <tr>
                                        <th>Hình ảnh bổ sung</th>
                                        <th>Sắp xếp</th>
                                        <th width="10%"></th>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="preview-image" style="margin-bottom: 0;">
                                                <img src="{{ asset('storage/app/uploads/default.png') }}" alt="Image" id="preview">
                                            </div>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" placeholder="Nhập vị tri sắp xếp" value="0">
                                        </td>
                                        <td>
                                            <button title="Gỡ ảnh" class="btn btn-danger btn-sm"><i class="fa fa-minus-circle"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="preview-image" style="margin-bottom: 0;">
                                                <img src="{{ asset('storage/app/uploads/default.png') }}" alt="Image" id="preview">
                                            </div>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" placeholder="Nhập vị tri sắp xếp" value="0">
                                        </td>
                                        <td>
                                            <button title="Gỡ ảnh" class="btn btn-danger btn-sm"><i class="fa fa-minus-circle"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"></td>
                                        <td><button title="Thêm ảnh" class="btn btn-primary btn-sm"><i class="fa fa-plus-circle"></i></button></td>
                                    </tr>
                                </table> -->
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="links">
                                <div class="form-group">
                                    <label>Liên kết shopee</label>
                                    <input type="text" class="form-control" placeholder="Nhập đường dẫn xe" value="{{ old('shopeeLink') }}" name="shopeeLink">
                                </div>
                            </div>
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