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
            <li><a href="#"><i class="fa fa-th"></i> Bài viết</a></li>
            <li class="active">{{ $pageTitle }}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="btn-group">
                    <a href="{{ route('admin.article.getAdd') }}" class="btn btn-primary btn-sm mr-1" title="Thêm mới"><i class="fa fa-plus"></i> Thêm mới</a>
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
                    <div class="box-header">
                        <h3 class="box-title"><i class="fa fa-list"></i> {{ $pageTitle }}</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="datatable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Ảnh</th>
                                    <th>Tiêu đề</th>
                                    <th>Vị trí</th>
                                    <th>Ngày tạo</th>
                                    <th>Trạng thái</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $count = 0; @endphp
                                @foreach($articles as $item)
                                    @php $count++; @endphp
                                    <tr>
                                        <td width="5%" class="text-right">{{ $count }}</td>
                                        <td width="8%" align="center">
                                            <div class="preview-image" style="width: 60px; height: 60px;">
                                                <img src="@if(!empty($item->image)) {{ asset('storage/app/' . $item->image) }} @else {{ asset('storage/app/uploads/default.png') }} @endif" alt="Image">
                                            </div>
                                        </td>
                                        <td width="30%"><a href="{{ route('admin.article.getEdit', [$item->id]) }}">{{ $item->title }}</a></td>
                                        <td class="text-center">{{ $item->sort_order }}</td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>
                                            @if($item->status == 1)
                                                <small class="label bg-blue">Công khai</small>
                                            @else
                                                <small class="label bg-yellow">Bản nháp</small>
                                            @endif
                                        </td>
                                        <td width="10%">
                                            <a href="{{ route('admin.article.getEdit', [$item->id]) }}" class="btn btn-primary btn-sm" title="Chỉnh sửa"><i class="fa fa-edit"></i></a>
                                            <a href="{{ route('admin.article.getDelete', [$item->id]) }}" class="btn btn-danger btn-sm" title="Xóa bỏ" onclick="return confirm('Bạn có chắn chắn muốn xóa bài viết này. Xóa?');"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
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