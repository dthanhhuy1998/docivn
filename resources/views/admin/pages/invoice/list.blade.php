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
                        <table id="datatable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Khách hàng</th>
                                    <th>Thông tin nhận hàng</th>
                                    <th>Email</th>
                                    <th>Số lượng</th>
                                    <th>Tổng tiền</th>
                                    <th>Ngày tạo</th>
                                    <th>Trạng thái</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $count = 0; @endphp
                                @foreach($invoices as $invoice)
                                    @php 
                                        $count++;
                                        $quantityTotal = 0;
                                        $priceTotal = 0;
                                        $details = DB::table('invoice_detail')
                                        ->select('product_qty', 'product_price')
                                        ->where('invoice_id', $invoice->id)
                                        ->get();

                                        foreach($details as $item) {
                                            $quantityTotal += $item->product_qty;
                                            $priceTotal += $item->product_qty*$item->product_price;
                                        }
                                    @endphp
                                    <tr>
                                        <td>{{ $count }}</td>
                                        <td>
                                            @if($invoice->customer_id == 0)
                                                <span class="badge bg-grey">Khách vãn lai</span>
                                            @else
                                                <span class="badge bg-blue">{{ $invoice->customer->firstname }} {{ $invoice->customer->lastname }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span><strong>Người nhận:</strong> {{ $invoice->customer_name }}</span><br/>
                                            <span><strong>Điện thoại:</strong> {{ $invoice->customer_phone }}</span><br/>
                                            <span><strong>Địa chỉ:</strong> {{ $invoice->address }}</span><br/>
                                        </td>
                                        <td>{{ $invoice->customer_email }}</td>
                                        <td><strong>{{ number_format($quantityTotal) }}</strong> sản phẩm</td>
                                        <td><strong>{{ number_format($priceTotal) }}đ</strong></td>
                                        <td>{{ datetime_vi($invoice->created_at) }}</td>
                                        <td><strong class="{{ $invoice->getStatus->style }}">{{ $invoice->getStatus->text }}</strong></td>
                                        <td align="center">
                                            <a title="Kiểm tra đơn hàng" href="{{ route('admin.invoice.getInvoiceDetail', [$invoice->id]) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
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