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
        <div class="alert alert-light alert-dismissible">
            Bạn đang tạo ảnh bổ sung cho sản phẩm: <strong>{{ $product->name }}</strong>
        </div>
        <form action="{{ route('admin.product.image.postAddImage') }}" role="form" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" value="{{ $productId }}" name="id">
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
                <div class="col-md-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-plus"></i> Thêm ảnh bổ sung</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group @error('image') has-error @enderror">
                                <label><strong class="color-red font-15">*</strong> Ảnh bổ sung</label>
                                <div class="preview-image">
                                    <img src="{{ asset('storage/app/uploads/default.png') }}" alt="Avatar" id="preview">
                                </div>
                                <input type="file" onchange="filePreview(event)" name="image">
                                @error('image')
                                    <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Sắp xếp</label>
                                <input type="number" class="form-control" placeholder="0" value="{{ old('sortOrder') }}" name="sortOrder">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /. col -->
                <div class="col-md-8">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title"><i class="fa fa-list"></i> Danh sách ảnh bổ sung </h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table id="datatable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="10%">STT</th>
                                        <th>Ảnh</th>
                                        <th class="text-center">Vị trí</th>
                                        <th width="15%">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($images) > 0)
                                        @php $count = 0; @endphp
                                        @foreach($images as $item)
                                            @php $count++; @endphp
                                            <tr>
                                                <td>{{ $count }}</td>
                                                <td width="10%" align="center">
                                                    <div class="preview-image" style="width: 60px; height: 60px;">
                                                        <img src="@if(!empty($item->image)) {{ asset('storage/app/' . $item->image) }} @else {{ asset('storage/app/uploads/default.png') }} @endif" alt="Image">
                                                    </div>
                                                </td>
                                                <td class="text-center">{{ $item->sort_order }}</td>
                                                <td>
                                                    <a title="Chỉnh sửa ảnh" href="{{ route('admin.product.image.getEditImage', [$productId, $item->id]) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                                    <a title="Xóa ảnh" href="{{ route('admin.product.image.getDeleteImage', [$item->id]) }}" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắn chắn muốn xóa ảnh này. Xóa?');"><i class="fa fa-trash"></i></a>
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
                <!-- /. col -->
            </div>
        </form>
    </section>
    <!-- /.content -->
@endsection