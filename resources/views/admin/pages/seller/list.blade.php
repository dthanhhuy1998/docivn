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
            <li><a href="{{ route('admin.seller.getList') }}"><i class="fa fa-street-view"></i> Quản lý Seller</a></li>
            <li class="active">{{ $pageTitle }}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="btn-group">
                    <a href="{{ route('admin.seller.getAdd') }}" class="btn btn-primary btn-sm mr-1" title="Tạo Seller mới"><i class="fa fa-plus"></i> Tạo Seller mới</a>
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
                <div class="box box-primary box-solid">
                    <div class="box-header width-border">
                        <h3 class="box-title">{{ $pageTitle }}</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="datatable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>S.no</th>
                                    <th>Cấp Bậc</th>
                                    <th>Banner</th>
                                    <th>Tên Seller</th>
                                    <th>Ảnh đại diện</th>
                                    <th>Link facebook</th>
                                    <th>Số điện thoại</th>
                                    <th>Khu vực</th>
                                    <th>Trực thuộc</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($sellers) > 0)
                                    @php $count = 0; @endphp
                                    @foreach($sellers as $seller)
                                        @php $count++ @endphp
                                        <tr>
                                            <td>{{ $count }}</td>
                                            <td>{{ $seller->CapBac }}</td>
                                            <td>
                                                <div class="seller-img">
                                                    <img src="@if(!empty($seller->Banner)) {{ asset('storage/app/'.$seller->Banner) }} @else {{ asset('storage/app/uploads/default.png') }} @endif" alt="seller banner">
                                                </div>
                                            </td>
                                            <td><a href="#">{{ $seller->TenSeller }}</a></td>
                                            <td>
                                                <div class="seller-img">
                                                    <img src="@if(!empty($seller->AnhDaiDien)) {{ asset('storage/app/'.$seller->AnhDaiDien) }} @else {{ asset('storage/app/uploads/default.png') }} @endif" alt="seller avatar">
                                                </div>
                                            </td>
                                            <td><a href="{{ $seller->LinkFacebook }}" target="_blank"><small class="label bg-aqua">fb/{{ str_replace('https://www.facebook.com/', '', $seller->LinkFacebook) }}</small></a></td>
                                            <td>{{ $seller->SoDienThoai }}</td>
                                            <td>{{ $seller->KhuVuc }}</td>
                                            <td>{{ $seller->TrucThuoc }}</td>
                                            <td>
                                                <a href="{{ route('catalog.getSeller') }}?sdt={{ $seller->SoDienThoai }}" target="_blank" class="btn btn-info btn-xs" title="Xem"><i class="fa fa-search"></i></a>
                                                <a href="{{ route('admin.seller.getEdit', $seller->id) }}" class="btn btn-primary btn-xs" title="Chỉnh sửa"><i class="fa fa-edit"></i></a>
                                                <a href="{{ route('admin.seller.getDelete', $seller->id) }}" class="btn btn-danger btn-xs" title="Xóa" onclick="return confirm('Bạn có chắc chắn muốn xóa Seller này?');"><i class="fa fa-trash"></i></a>
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
  });
</script>
@endsection