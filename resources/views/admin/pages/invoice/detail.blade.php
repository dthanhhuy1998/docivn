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
            <li><a href="{{ route('admin.invoice.getList') }}"><i class="fa fa-shopping-cart"></i> Quản lý đơn hàng</a></li>
            <li class="active">{{ $pageTitle }}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <a href="{{ route('admin.invoice.getList') }}" class="btn btn-sm btn-default"><i class="fa fa-long-arrow-left"></i> Quay lại</a>
                    <a href="{{ route('admin.invoice.delete', $invoice->id) }}" onclick="return confirm('Hệ thống sẽ xóa thông tin đơn hàng vĩnh viễn. Bạn có chắn chắn muốn xóa?');" class="btn btn-sm btn-danger pull-right mb-2" style="margin-bottom: 10px;"><i class="fa fa-trash"></i> Xóa đơn hàng</a>
                </div>
            </div>
            <div class="col-md-12">
                <div class="alert alert-success alert-dismissible show_success" style="display: none;">
                    Thay đổi trạng thái thành công
                </div>
                <div class="alert alert-warning alert-dismissible show_error" style="display: none;">
                    Xảy ra lỗi trong quá trình cập nhật
                </div>
            </div>
            <div class="col-md-4">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Thông tin giao hàng</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td><strong>Khách hàng</strong></td>
                                    <td>
                                        @if($invoice->customer_id == 0)
                                            <span class="label bg-aqua">Khách vãn lai</span>
                                        @else
                                            <span class="label bg-blue">{{ $invoice->customer->firstname }} {{ $invoice->customer->lastname }}</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Thông tin nhận</strong></td>
                                    <td>
                                        <p>
                                            <span><strong>Người nhận:</strong></span>
                                            {{ $invoice->customer_name }}
                                        </p>
                                        <p>
                                            <span><strong>SĐT:</strong></span>
                                            {{ $invoice->customer_phone }}
                                        </p>
                                        <p>
                                            <span><strong>Địa chỉ:</strong></span>
                                            {{ $invoice->address }}
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Email</strong></td>
                                    <td>{{ $invoice->customer_email }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Địa chỉ giao hàng</strong></td>
                                    <td>{{ $invoice->address }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Ghi chú</strong></td>
                                    <td>{{ $invoice->note }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Tình trạng</strong></td>
                                    <td>
                                        <strong class="{{ $invoice->getStatus->style }}">{{ $invoice->getStatus->text }}</strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        
                    </div>
                    <!-- /.box-body -->
                </div>
                @if($invoice->status == 1)
                    <button type="button" data-id="{{ $invoice->id }}" data-status="2" class="btn btn-lg btn-primary toggle-status">Vận chuyển</button>
                @endif
                @if($invoice->status == 2)
                    <button type="button" data-id="{{ $invoice->id }}" data-status="3" class="btn btn-lg btn-primary toggle-status">Giao hàng thành công</button>
                @endif
                @if($invoice->status == 4)
                    <button type="button" data-id="{{ $invoice->id }}" data-status="1" class="btn btn-lg btn-primary toggle-status">Khôi phục đơn hàng</button>
                @endif
            </div>
            @if(count($invoice->detail) > 0)
                <div class="col-md-8">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Danh sách sản phẩm</h3>
                        </div>
                        <div class="box-body">
                            <table id="datatable" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Ảnh</th>
                                        <th>Tên sản phẩm</th>
                                        <th>Giá tiền</th>
                                        <th>Số lượng</th>
                                        <th>Thành tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $count = 0;
                                        $priceTotal = 0;
                                    ?>
                                    @foreach($invoice->detail as $item)
                                        <?php
                                            $count++;
                                            $priceTotal += $item->product_price * $item->product_qty;
                                        ?>
                                        <?php ?>
                                        <tr>
                                            <td>{{ $count }}</td>
                                            <td>
                                                <div class="preview-image" style="width: 60px; height: 60px;">
                                                    <img src="@if(!empty($item->product->image)) {{ asset('storage/app/'.$item->product->image) }} @else {{ asset('storage/app/uploads/default.png') }} @endif" alt="Image">
                                                </div>
                                            </td>
                                            <td>{{ $item->product->productDescription->name }}</td>
                                            <td><strong>{{ number_format($item->product_price) }}<sup>đ</sup></strong></td>
                                            <td>x{{ number_format($item->product_qty) }}</td>
                                            <td><strong>{{ number_format($item->product_price * $item->product_qty) }}<sup>đ</sup></strong></td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="5" class="text-right"><strong style="font-size: 16px; text-transform: uppercase;">Tổng cộng</strong></td>
                                        <td class="text-right"><strong class="text-red" style="font-size: 17px;">{{ number_format($priceTotal) }}<sup>đ</sup></strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            @endif
        </div>
    </section>
    <!-- /.content -->
@endsection

@section('script')
<script>
  let toggleStatus = () => {
    $(document).on('click', '.toggle-status', function() {
        if(confirm('Bạn có chắn chắn muốn đổi trạng thái đơn hàng?')) {
            var invoice_id = $(this).attr('data-id');
            var status = $(this).attr('data-status');
            var token = '{{ csrf_token() }}';
            $.ajax({
                url: '{{ route("admin.invoice.toggleStatus") }}',
                method: 'POST',
                dataType: 'json',
                data: {
                    '_token': token,
                    invoice_id: invoice_id,
                    status: status
                },
                beforeSend: function() {
                    $('.toggle-status').html('Đang xử lý...');
                },
                success: function(res) {
                    if(res.status == 200) {
                        console.log(res);
                        $('.show_success').css('display', 'block');
                        setTimeout(function(){
                            location.href = res.route;
                        }, 1000);
                    } else {
                        $('.show_error').css('display', 'block');
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert('Error: Xảy ra lỗi trong quá trình gửi dữ liệu!');
                }
            });
        }
    });
  }

  toggleStatus();
</script>
@endsection