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
        <form action="{{ route('admin.product.attribute.postEditAttribute') }}" method="post" class="row">
            @csrf
            <div class="col-md-12">
                @if(session('success_msg'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true" control-id="ControlID-6">×</button>
                    <h4><i class="icon fa fa-check"></i> Thành công</h4>
                    {{ session('success_msg') }}
                </div>
                @endif
                @if(session('warning_msg'))
                <div class="alert alert-warning alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true" control-id="ControlID-6">×</button>
                    <h4><i class="icon fa fa-exclamation"></i> Cảnh báo</h4>
                    {{ session('warning_msg') }}
                </div>
                @endif
                <div class="btn-group">
                    <a href="{{ route('admin.product.attribute.getAttribute', [$productId]) }}" class="btn btn-default btn-sm mr-1" title="Hủy bỏ"><i class="fa fa-long-arrow-left"></i> Quay lại</a>
                    <button type="submit" class="btn btn-primary btn-sm mr-1" title="Lưu lại"><i class="fa fa-save"></i> Lưu lại</button>
                </div>
            </div>
            <div class="col-md-4">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Tạo thuộc tính mới</h3>
                    </div>
                    <div class="box-body">
                        <input type="hidden" value="{{ $productId }}" name="productId">
                        <input type="hidden" value="{{ $attribute->id }}" name="attributeId">
                        <div class="form-group @error('name') has-error @enderror">
                            <label><strong class="color-red font-15">*</strong>Tên thuộc tính</label>
                            <input type="text" class="form-control" placeholder="Nhập tên thuộc tính" value="{{ $attribute->name }}" name="name">
                            @error('name')
                                <span class="help-block">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group @error('price') has-error @enderror">
                            <label><strong class="color-red font-15">*</strong>Giá</label>
                            <input type="number" class="form-control" placeholder="Nhập giá sản phẩm" value="{{ $attribute->price }}" name="price">
                            @error('price')
                                <span class="help-block">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Vị trí</label>
                            <input type="number" class="form-control" placeholder="Nhập vị trí sắp xếp" value="{{ $attribute->sort_order }}" name="sortOrder">
                        </div>
                        <div class="form-group">
                            <label>Trạng thái kho hàng</label>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="status" value="1" @if($attribute->status == 1) checked @endif>
                                    Còn hàng
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="status" value="0" @if($attribute->status == 0) checked @endif>
                                    Hết hàng
                                </label>
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
    $('#datatable').DataTable();
  })
</script>
@endsection