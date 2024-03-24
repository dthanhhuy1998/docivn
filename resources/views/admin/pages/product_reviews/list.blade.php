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
                                    <th>Sản phẩm</th>
                                    <th>Đánh sao</th>
                                    <th>Tên khách hàng</th>
                                    <th>Email</th>
                                    <th>Số điện thoại</th>
                                    <th>Nội dung</th>
                                    <th>Ngày tạo</th>
                                    <th width="5%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $count = 0; @endphp
                                @foreach($pReviews as $review)
                                    @php $count++; @endphp
                                    <tr>
                                        <td>{{ $count }}</td>
                                        <td><strong>{{ $review->product->productDescription->name }}</strong></td>
                                        <td><strong>{{ $review->star }}</strong> <small class="label bg-yellow"><i class="fa fa-star"></i></small></td>
                                        <td>{{ $review->customer_name }}</td>
                                        <td>{{ $review->customer_phone }}</td>
                                        <td>{{ $review->customer_email }}</td>
                                        <td>{{ $review->text }}</td>
                                        <td>{{ date_vi($review->created_at) }}</td>
                                        <td>
                                            @if($review->status == 0)
                                                <a href="{{ route('admin.product.reviews.getAcceptReview', [$review->id]) }}" class="btn btn-success btn-xs" title="Duyệt đánh giá" onclick="return confirm('Bạn có chắn chắn muốn duyệt đánh giá này?');"><i class="fa fa-check"></i></a>
                                            @else
                                                <a href="{{ route('admin.product.reviews.getAcceptReview', [$review->id]) }}" class="btn btn-default btn-xs" title="Hủy duyệt đánh giá" onclick="return confirm('Bạn có chắn chắn muốn hủy duyệt đánh giá này?');"><i class="fa fa-check"></i></a>
                                            @endif
                                            <a href="{{ route('admin.product.reviews.getDeleteReview', [$review->id]) }}" class="btn btn-danger btn-xs" title="Xóa bỏ" onclick="return confirm('Bạn có chắn chắn muốn xóa đánh giá này?');"><i class="fa fa-trash"></i></a>
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