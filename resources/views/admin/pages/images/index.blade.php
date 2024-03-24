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
                    <a href="{{ route('admin.gallery.create') }}" class="btn btn-primary btn-sm mr-1" title="Thêm album mới"><i class="fa fa-plus"></i> Thêm ảnh mới</a>
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
                        <h3 class="box-title">{{ $pageTitle }}</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table @if(count($images) > 0) id="datatable" @endif class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="20">STT</th>
                                    <th width="15%">Hình ảnh</th>
                                    <th width="20%">Tiêu đề</th>
                                    <th>Mô tả</th>
                                    <th>Thứ tự</th>
                                    <th>Ngày tạo</th>
                                    <th>Trạng thái</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($images) > 0)
                                    @php $count = 0; @endphp
                                    @foreach($images as $image)
                                        @php $count++; @endphp
                                        <tr>
                                            <td>{{ $count }}</td>
                                            <td>
                                                <div class="preview-image" style="width: 200px; height: auto;">
                                                    <img src="@if(!empty($image->image_picture)) {{ asset('storage/app/'.$image->image_picture) }} @else {{ asset('storage/app/uploads/default.png') }} @endif" alt="Image">
                                                </div>
                                            </td>
                                            <td>{{ $image->image_name }}</td>
                                            <td>{!! $image->image_desc !!}</td>
                                            <td>{{ $image->image_priority }}</td>
                                            <td>{{ date_format(date_create($image->created_at), 'd/m/Y H:i:s') }}</td>
                                            <td>{{ ($image->image_status) ? 'Hiển thị' : 'Không hiển thị' }}</td>
                                            <td>
                                                <a href="{{ route('admin.gallery.show', $image->id) }}" class="btn btn-primary" title="Đăng ảnh"><i class="fa fa-plus"></i></a>
                                                <a href="{{ route('admin.gallery.edit', $image->id) }}" class="btn btn-primary" title="Chỉnh sửa"><i class="fa fa-edit"></i></a>
                                                <a 
                                                    href="{{ route('admin.gallery.destroy', $image->id) }}" 
                                                    class="btn btn-danger"
                                                    onclick="return confirm('Bạn có chắc chắn muốn xóa album này?');"
                                                >
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="8" align="center"><span class="text-red">Không có album nào<span></td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
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