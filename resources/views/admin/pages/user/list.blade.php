@extends('admin.common.layout')

@section('title')
    {!! $headingTitle !!}
@endsection

@section('content')
   <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Tài khoản</h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.index') }}"><i class="fa fa-th"></i> Trang chính</a></li>
            <li class="active">Tài khoản</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="btn-group">
                    <a href="{{ route('admin.user.getAdd') }}" class="btn btn-primary btn-sm mr-1" title="Thêm mới"><i class="fa fa-plus"></i> Thêm mới</a>
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
                        <h3 class="box-title"><i class="fa fa-list"></i> {{ $actionTitle }}</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="datatable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Họ</th>
                                    <th>Tên</th>
                                    <th>Tên tài khoản</th>
                                    <th>Email</th>
                                    <th>Vai trò</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày tạo</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $count = 0; @endphp
                                @foreach($users as $user)
                                    @php $count++; @endphp
                                    <tr>
                                        <td width="5%">{{ $count }}</td>
                                        <td>{{ $user->lastname }}</td>
                                        <td>{{ $user->firstname }}</td>
                                        <td>{{ $user->username }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td><small class="label bg-blue">{{ $user->userGroup->name }}</small></td>
                                        <td>
                                            @if($user->status == 1)
                                                <small class="label bg-green">Kích hoạt</small>
                                            @else
                                                <small class="label bg-red">Vô hiệu hóa</small>
                                            @endif
                                        </td>
                                        <td>{{ datetime_vi($user->created_at) }}</td>
                                        <td width="10%">
                                            <a href="{{ route('admin.user.getResetPass', [$user->id]) }}" class="btn btn-info btn-sm" title="Đổi mật khẩu"><i class="fa fa-lock"></i></a>
                                            <a href="{{ route('admin.user.getEdit', [$user->id]) }}" class="btn btn-primary btn-sm" title="Chỉnh sửa"><i class="fa fa-edit"></i></a>
                                            <a href="{{ route('admin.user.getDelete', [$user->id]) }}" class="btn btn-danger btn-sm" title="Xóa bỏ" onclick="return confirm('Bạn có chắn chắn muốn xóa tài khoản này. Xóa?');"><i class="fa fa-trash"></i></a>
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