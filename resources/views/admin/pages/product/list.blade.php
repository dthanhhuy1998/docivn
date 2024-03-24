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
            <li class="active">{{ $pageTitle }}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="btn-group">
                    <a href="{{ route('admin.product.getAdd') }}" class="btn btn-primary btn-sm mr-1" title="Thêm sản phẩm mới"><i class="fa fa-plus"></i> Thêm sản phẩm mới</a>
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
                @if(session('warning_msg'))
                <div class="alert alert-warning alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true" control-id="ControlID-6">×</button>
                    <h4><i class="icon fa fa-exclamation"></i> Cảnh báo</h4>
                    {{ session('warning_msg') }}
                </div>
                @endif
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-list"></i> {{ $pageTitle }}</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="datatable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Ảnh</th>
                                    <th>Mã sản phẩm</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Danh mục</th>
                                    <th>Giá</th>
                                    <th>Tồn kho</th>
                                    <th>Đã bán</th>
                                    <th width="8%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($products) > 0)
                                    @php $count = 0; @endphp
                                    @foreach($products as $product)
                                        @php $count++; @endphp
                                        <tr class="@if($product->status == 0) row-disabled @endif">
                                            <td width="5%" class="text-right">{{ $count; }}</td>
                                            <td width="10%" align="center">
                                                <div class="preview-image" style="width: 60px; height: 60px;">
                                                    <img src="@if(!empty($product->image)) {{ asset('storage/app/' . $product->image) }} @else {{ asset('storage/app/uploads/default.png') }} @endif" alt="Image">
                                                </div>
                                                <a href="{{ route('admin.product.image.getAddImage', [$product->id]) }}">Ảnh bổ sung ({{ count($product->images) }})</a>
                                            </td>
                                            <td><strong>{{ $product->sku }}</strong></td>
                                            <td width="28%"><a title="sản phẩmm trước" href="" target="_blank">{{ $product->productDescription->name }}</a></td>
                                            <td>
                                                @if(count($product->toCategory) > 0)
                                                    @foreach($product->toCategory as $category)
                                                        <small class="label bg-blue">{{ $category->name }}</small> <br/>
                                                    @endforeach
                                                @endif
                                            </td>
                                            <td class="text-right">
                                                @if($product->original_price > 0)
                                                    <span style="color: $545454; text-decoration: line-through; "> {{ number_format($product->original_price) }} vn<u>đ</u></span><br/>
                                                @endif
                                                @if($product->price > 0)
                                                    @if(count($product->attribute) > 0)
                                                        @if(DB::table('attribute')->where('product_id', $product->id)->min('price') == DB::table('attribute')->where('product_id', $product->id)->max('price'))
                                                            <span style="color: #e3503e;">{{ number_format(DB::table('attribute')->where('product_id', $product->id)->min('price')) }}vn<u>đ</u></span>
                                                        @else
                                                            <span style="color: #e3503e;">{{ number_format(DB::table('attribute')->where('product_id', $product->id)->min('price')) }}vn<u>đ</u> - {{ number_format(DB::table('attribute')->where('product_id', $product->id)->max('price')) }}vn<u>đ</u></span>
                                                        @endif
                                                    @else
                                                        <span style="color: #e3503e;">{{ number_format($product->price) }}vn<u>đ</u></span>
                                                    @endif
                                                @else
                                                    <span>Liên hệ</span>
                                                @endif
                                            </td>
                                            <td align="center">
                                                <small class="label bg-green">{{ number_format($product->quantity) }}</small>
                                            </td>
                                            <td>{{ $product->sold }}</td>
                                            <td>
                                                <!-- <a title="Phân loại sản phẩm" href="{{ route('admin.product.attribute.getAttribute', [$product->id]) }}" class="btn btn-warning btn-sm"><i class="fa fa-magic"></i></a>-->
                                                <a title="Chỉnh sửa sản phẩm" href="{{ route('admin.product.getEdit', [$product->id]) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                                <a title="Xóa sản phẩm" href="{{ route('admin.product.getDelete', [$product->id]) }}" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắn chắn muốn xóa sản phẩm này. Xóa?');"><i class="fa fa-trash"></i></a>
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
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <i class="fa fa-info-circle"></i>
                        <h3 class="box-title">Giải thích</h3>
                    </div>
                    <div class="box-body">
                        <ul>
                            <li>
                                Các ô được tô <small class="label" style="background-color: #D0D3D4; color: #252525;"> màu xám </small> là sản phẩm <strong>không hiển thị</strong> ngoài trang chủ.
                            </li>
                        </ul>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
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