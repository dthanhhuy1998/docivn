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
        <div class="alert alert-light alert-dismissible">
            Bạn đang phân loại cho sản phẩm: <strong>{{ $product->name }}</strong>
        </div>
        <form action="{{ route('admin.product.attribute.postAddAttribute') }}" method="post" class="row">
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
                    <a href="{{ route('admin.product.getList') }}" class="btn btn-default btn-sm mr-1" title="Hủy bỏ"><i class="fa fa-long-arrow-left"></i> Quay lại</a>
                    <button type="submit" class="btn btn-primary btn-sm mr-1" title="Tạo phân loại mới"><i class="fa fa-plus"></i> Tạo phân loại mới</button>
                </div>
            </div>
            <div class="col-md-4">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Tạo phân loại mới</h3>
                    </div>
                    <div class="box-body">
                        <input type="hidden" value="{{ $productId }}" name="productId">
                        <div class="form-group @error('name') has-error @enderror">
                            <label><strong class="color-red font-15">*</strong>Tên phân loại</label>
                            <input type="text" class="form-control" placeholder="Nhập tên phân loại" value="{{ old('name') }}" name="name">
                            @error('name')
                                <span class="help-block">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group @error('price') has-error @enderror">
                            <label><strong class="color-red font-15">*</strong>Giá</label>
                            <input type="number" class="form-control" placeholder="Nhập giá sản phẩm" value="{{ old('price') }}" name="price">
                            @error('price')
                                <span class="help-block">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- <div class="form-group @error('stock') has-error @enderror">
                            <label><strong class="color-red font-15">*</strong>Kho hàng</label>
                            <input type="number" class="form-control" placeholder="Nhập số lượng sản phẩm trong kho" value="{{ old('stock') }}" name="stock">
                            @error('stock')
                                <span class="help-block">{{ $message }}</span>
                            @enderror
                        </div> -->
                        <div class="form-group">
                            <label>Vị trí</label>
                            <input type="number" class="form-control" placeholder="Nhập vị trí sắp xếp" value="0" name="sortOrder">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">{{ $pageTitle }}</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="datatable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên phân loại</th>
                                    <th>Giá</th>
                                    <!-- <th>Kho hàng</th> -->
                                    <th>Vị trí</th>
                                    <th>Kho hàng</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($attributies) > 0)
                                    @php $count = 0; @endphp
                                    @foreach($attributies as $attribute)
                                        @php $count++; @endphp
                                        <tr>
                                            <td>{{ $count }}</td>
                                            <td>{{ $attribute->name }}</td>
                                            <td><strong>{{ number_format($attribute->price) }}vnđ</strong></td>
                                            <td>{{ $attribute->sort_order }}</td>
                                            <td>
                                                @if($attribute->status == 1)
                                                    <small class="label bg-green">Còn hàng</small>
                                                @else
                                                    <small class="label bg-red">Hết hàng</small>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.product.attribute.getEditAttribute', [$productId, $attribute->id]) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                                <a href="{{ route('admin.product.attribute.getDeleteAttribute', [$attribute->id]) }}" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa thuộc tính này. Xóa?')"><i class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
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