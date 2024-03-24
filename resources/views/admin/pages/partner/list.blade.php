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
            <li><a href="{{ route('admin.partner.getList') }}"><i class="fa fa-link"></i> Đối tác liên kết</a></li>
            <li class="active">{{ $pageTitle }}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="btn-group">
                    <a href="{{ route('admin.partner.getAdd') }}" class="btn btn-primary btn-sm mr-1" title="Tạo đối tác mới"><i class="fa fa-plus"></i> Tạo đối tác mới</a>
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
                        <table id="datatable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="5%" class="text-right">STT</th>
                                    <th width="15%" align="center">Ảnh Logo</th>
                                    <th>Đường dẫn liên kết</th>
                                    <th width="8%">Vị trí</th>
                                    <th width="10%">Trang chủ</th>
                                    <th width="10%">Ngày tạo</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $count = 0; @endphp
                                @foreach($partners as $partner)
                                    @php $count++; @endphp
                                    <tr>
                                        <td>{{ $count }}</td>
                                        <td>
                                            <div class="preview-image" style="width: 120px; height: auto;">
                                                <img src="@if(!empty($partner->partner_image)) {{ asset('storage/app/' . $partner->partner_image) }} @else {{ asset('storage/app/uploads/default.png') }} @endif" alt="Image">
                                            </div>
                                        </td>
                                        <td>{{ $partner->partner_link }}</td>
                                        <td align="center">{{ $partner->partner_sort_order }}</td>
                                        <td align="center">
                                            @if($partner->partner_status == 1)
                                                <small class="label bg-green">Hiển thị</small>
                                            @else
                                                <small class="label bg-red">Không hiển thị</small>
                                            @endif
                                        </td>
                                        <td>{{ date_vi($partner->created_at) }}</td>
                                        <td width="10%">
                                            <a href="{{ route('admin.partner.getEdit', [$partner->id]) }}" class="btn btn-primary btn-sm" title="Chỉnh sửa"><i class="fa fa-edit"></i></a>
                                            <a href="{{ route('admin.partner.getDelete', [$partner->id]) }}" class="btn btn-danger btn-sm" title="Xóa bỏ" onclick="return confirm('Bạn có chắn chắn muốn xóa đối tác - khách hàng này. Xóa?');"><i class="fa fa-trash"></i></a>
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