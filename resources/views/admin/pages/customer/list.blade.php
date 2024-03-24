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
            <li><a href="{{ route('admin.customer.getList') }}"><i class="fa fa-users"></i> Khách hàng</a></li>
            <li class="active">{{ $pageTitle }}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
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
                        <table id="datatable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Khách hàng</th>
                                    <th>Email</th>
                                    <th>Điện thoại</th>
                                    <th>Địa chỉ</th>
                                    <th>Ngày tạo</th>
                                    <th>Trạng thái</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($customers) > 0)
                                    @php $count = 0; @endphp
                                    @foreach($customers as $customer)
                                        @php $count++; @endphp
                                        <tr>
                                            <td>{{ $count }}</td>
                                            <td>{{ $customer->lastname }} {{ $customer->firstname }}</td>
                                            <td>{{ $customer->email }}</td>
                                            <td>{{ $customer->telephone }}</td>
                                            <td>{{ $customer->address }}</td>
                                            <td>{{ datetime_vi($customer->created_at) }}</td>
                                            <td>
                                                @if($customer->status)
                                                    <span class="text-blue">Đang hoạt động</span>
                                                @else
                                                    <span class="text-red">Ngừng hoạt động</span>
                                                @endif
                                            </td>
                                            <td width="8%" align="center">
                                                @if($customer->status == 1)
                                                    <a title="Khóa tài khoản" href="{{ route('admin.customer.getToggle', [$customer->id]) }}" class="btn btn-sm btn-danger"><i class="fa fa-ban"></i></a>
                                                @else
                                                    <a title="Mở tài khoản" href="{{ route('admin.customer.getToggle', [$customer->id]) }}" class="btn btn-sm btn-success"><i class="fa fa-check"></i></a>
                                                @endif
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