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
            <li><a href="{{ route('admin.tra-gop.getList') }}"><i class="fa fa-location-arrow"></i> Yêu cầu trả góp</a></li>
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
                    <div class="box-header">
                        <h3 class="box-title">{{ $pageTitle }}</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="datatable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Ảnh</th>
                                    <th width="25%">Sản phẩm</th>
                                    <th>Khách hàng</th>
                                    <th>Trả trước</th>
                                    <th>Số tháng trả</th>
                                    <th>Yêu cầu lúc</th>
                                    <th width="5%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $count = 0; @endphp
                                @foreach($lists as $list)
                                    @php $count++; @endphp
                                    <tr>
                                        <td>{{ $count }}</td>
                                        <td>
                                            <div class="preview-image" style="width: 60px; height: auto;">
                                                <img src="@if(!empty($list->p_image)) {{ asset('storage/app/' . $list->p_image) }} @else {{ asset('storage/app/uploads/default.png') }} @endif" alt="Image">
                                            </div>
                                        </td>
                                        <td>{{ $list->p_name}}</td>
                                        <td>
                                            <strong>Tên</strong>: {{ $list->customer_name }} <br/>
                                            <strong>CMND</strong>: {{ $list->customer_card_id }} <br/>
                                            <strong>SĐT</strong>: {{ $list->customer_phone }} <br/>
                                            <strong>Email</strong>: {{ $list->email }} <br/>
                                            <strong>Tỉnh</strong>: {{$list->province->name }} <br/>
                                            <strong>Lời nhắn</strong>: {{$list->note }} <br/>
                                        </td>
                                        <td>@if($list->percent != '') {{ $list->percent }}% @endif</td>
                                        <td>@if($list->month != '') {{ $list->month }} tháng @endif</td>
                                        <td>{{ date_vi($list->created_at) }}</td>
                                        <td>
                                            <a href="{{ route('admin.tra-gop.getDelete', [$list->id]) }}" class="btn btn-danger btn-sm" title="Xóa bỏ" onclick="return confirm('Bạn có chắn chắn muốn xóa list này. Xóa?');"><i class="fa fa-trash"></i></a>
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