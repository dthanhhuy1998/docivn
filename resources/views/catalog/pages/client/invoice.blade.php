@extends('catalog.common.layout')

@section('title')
    {!! $headingTitle !!}
@endsection

@section('content')
<div class="section-main">
    <div class="page-order_list page-gap">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bg-white p-3 p-lg-5">
                        <div class="section-heading mb-5">
                            <div class="title">
                                Danh sách các đơn hàng đã đặt mua
                            </div>
                            <div class="line"></div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-order_list">
                                <tr>
                                    <th>Mã hóa đơn</th>
                                    <th>Tổng tiền</th>
                                    <th>Tình trạng</th>
                                    <th>Ngày tạo</th>
                                    <th width="19%"></th>
                                </tr>
                                @if(count($invoices) > 0)
                                    @foreach($invoices as $invoice)
                                        @php
                                            $details = DB::table('invoice_detail')
                                            ->select('product_qty', 'product_price')
                                            ->where('invoice_id', $invoice->id)
                                            ->get();

                                            $priceTotal = 0;
                                            foreach($details as $item) {
                                                $priceTotal += $item->product_qty*$item->product_price;
                                            }
                                        @endphp
                                        <tr>
                                            <td>HD{{ $invoice->id }}</td>
                                            <td><b>{{ number_format($priceTotal) }}đ</b></td>
                                            <td><span class='badge fw-400 {{ $invoice->getStatus->style }}' style="padding-top: 6px; padding-bottom: 4px;">{{ $invoice->getStatus->text }}</span></td>
                                            <td>{{ date_format(date_create($invoice->created_at), 'H:i:s d-m-Y') }}</td>
                                            <td style="white-space: nowrap">
                                                <a href="{{ route('client.getInvoiceDetail', $invoice->id) }}" class="btn btn-success btn-sm">
                                                    Xem hóa đơn
                                                </a>
                                                @if($invoice->status != 4)
                                                    <a href="javascript:void(0)" data-id="{{ $invoice->id }}" class="btn btn-danger btn-sm btn-huydonhang">
                                                        Hủy hóa đơn
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6">
                                            <div class="product-empty">
                                                <div class="product-empty_icon">
                                                    <img src="{{ asset('public/catalog/assets/public/upload/theme/no-product.svg') }}" alt="no-product.svg">
                                                </div>
                                                <div class="product-empty_title">
                                                    Danh sách đơn đặt hàng đang trống. <br>
                                                    <a href="{{ route('catalog.homepage') }}" class="small">Quay về trang chủ</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    const handleHuyDonHang = function () {
        $('.btn-huydonhang').click(function () {
            let btnElm = $(this),
                btnElmHTML = btnElm.html(),
                id_hoadon = btnElm.attr('data-id');

            btnElm.html('<i class="fa fa-spinner fa-spin"></i> Đang xóa..');
            btnElm.prop("disabled", true);

            $.post('{{ route("client.postCancelInvoice") }}', {
                '_token': '{{ csrf_token() }}',
                'id_hoadon': id_hoadon
            }, function (result) {
                if (result.status == 200) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Hủy đơn hàng thành công',
                        buttonsStyling: false,
                        showConfirmButton: false,
                        showCancelButton: true,
                        cancelButtonText: 'Đóng!',
                        customClass: {
                            cancelButton: 'btn btn-success'
                        }
                    });

                    btnElm.html(btnElmHTML);
                    btnElm.prop("disabled", true);
                    btnElm.fadeIn(function () {
                        btnElm.remove();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Có lỗi xảy ra',
                        text: 'Vui lòng thử lại!',
                        buttonsStyling: false,
                        showConfirmButton: false,
                        showCancelButton: true,
                        cancelButtonText: 'Thử lại!',
                        customClass: {
                            cancelButton: 'btn btn-danger btn-no_effect'
                        }
                    });
                    btnElm.html(btnElmHTML);
                    btnElm.prop("disabled", true);
                }

            }, 'JSON').fail(function (xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Có lỗi xảy ra',
                    text: 'Vui lòng thử lại!',
                    buttonsStyling: false,
                    showConfirmButton: false,
                    showCancelButton: true,
                    cancelButtonText: 'Thử lại!',
                    customClass: {
                        cancelButton: 'btn btn-danger btn-no_effect'
                    }
                });
                btnElm.html(btnElmHTML);
                btnElm.prop("disabled", true);
            });

            return false;
        });
    }

    handleHuyDonHang();
</script>
@endsection