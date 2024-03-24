@extends('catalog.common.layout')

@section('content')
<div class="section-main">
    <div class="page-cart">
        <form action="{{ route('catalog.cart.order') }}" class="frm-cart needs-validation" novalidate id="frmPayment">
            @csrf
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="cart-from">
                            <div class="cart-from_header">
                                Thông tin đặt hàng
                                @if(!session()->exists('userLogin'))
                                    <span>
                                        Đã có tài khoản?
                                        <a href="{{ route('catalog.clientLogin') }}?redirect=order">Đăng nhập ngay</a>
                                    </span>
                                @endif
                            </div>
                            <div class="cart-from_body">
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="form-item">
                                            <label for="frm-tenkhachhang">Họ & tên (*)</label>
                                            <input type="text" id="frm-tenkhachhang" name="tenkhachhang" minlength="3"
                                                   required
                                                   class="form-control"
                                                   value="@if(session()->exists('userLogin')){{ $customer->firstname }}@endif"
                                                   placeholder="Họ & tên nhận hàng...">
                                            <div class="invalid-feedback">
                                                Vui lòng nhập họ & tên của bạn
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-item">
                                            <label for="frm-sdt">Số điện thoại (*)</label>
                                            <input type="tel" id="frm-sdt" name="sdt" maxlength="12" minlength="10" required
                                                   class="form-control"
                                                   value="@if(session()->exists('userLogin')){{ $customer->telephone }}@endif"
                                                   placeholder="Số điện thoại nhận hàng...">
                                            <div class="invalid-feedback">
                                                Vui lòng nhập số điện thoại của bạn
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-item">
                                            <label for="frm-diachi">Địa chỉ nhận hàng (*)</label>
                                            <input type="text" id="frm-diachi" name="diachi"
                                                   class="form-control"
                                                   required
                                                   value="@if(session()->exists('userLogin')){{ $customer->address }}@endif"
                                                   placeholder="Địa chỉ nhận hàng...">
                                            <div class="invalid-feedback">
                                                Vui lòng nhập địa chỉ nhận hàng của bạn
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" id="frm-email" name="email" class="form-control" value="@if(session()->exists('userLogin')){{ $customer->email }}@endif" placeholder="Email nhận hàng...">
                                    <div class="col-md-12">
                                        <div class="form-item">
                                            <label for="frm-note">Ghi chú khi giao hàng</label>
                                            <textarea id="frm-note" name="ghichu" rows="4" class="frm-validation_textarea form-control" placeholder="Nhập ghi chú khi giao hàng..."></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-desc">
                                            Vui lòng không bỏ trống các trường có dấu <b>*</b>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="cart-payments">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="cart-payment_item">
                                        <div class="cart-payment_title">
                                            Vận chuyển
                                        </div>
                                        <div class="cart-payment_list">
                                            <div class="cart-payment_list__item">
                                                <div class="content">
                                                    <span class="text">Giao hàng tận nơi</span>
                                                    <span class="value-empty">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                                stroke-width="3" stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                class="feather feather-check">
                                                            <polyline points="20 6 9 17 4 12"></polyline>
                                                        </svg>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="cart-payment_item">
                                        <div class="cart-payment_title">
                                            Hình thức thanh toán
                                        </div>
                                        <div class="cart-payment_list">
                                            <div class="cart-payment_list__item">
                                                <div class="content">
                                                    <span class="text">Thanh toán khi giao hàng</span>
                                                    <span class="value-empty">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                             viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                             stroke-width="3" stroke-linecap="round" stroke-linejoin="round"
                                                             class="feather feather-check">
                                                            <polyline points="20 6 9 17 4 12"></polyline>
                                                        </svg>
                                                    </span>
                                                </div>
                                                <div class="desc">
                                                    Bạn chỉ phải thanh toán khi nhận được hàng
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 mt-4 mt-lg-0">
                        <div class="cart-sidebar_list">
                            <div class="cart-sidebar">
                                <div class="cart-title">
                                    Danh sách sản phẩm
                                </div>
                                @if($cartCount > 0)
                                <div class="cart-products">
                                    @foreach($cartContent as $item)
                                        <div class="cart-product_item">
                                            <div class="cart-product_content">
                                                <div class="title">{{ $item->name }} <br/><span>(SL: {{ $item->qty }})</span></div>
                                                {{-- <div class="property">
                                                    Dung tích:&nbsp;<b>25ml</b>
                                                </div> --}}
                                            </div>
                                            <div class="cart-product_total">{{ number_format($item->price) }}đ</div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                            <div class="cart-sidebar">
                                <div class="cart-title">
                                    Tổng tiền
                                </div>
                                <div class="cart-list">
                                    <div class="cart-list_item">
                                        Tạm tính:&nbsp;
                                        <span class="value totalCheckout">{{ $cartTotal }}đ</span>
                                    </div>
                                    <div class="cart-list_item">
                                        Tổng tiền:&nbsp;
                                        <span class="value totalCheckout">{{ $cartTotal }}đ</span>
                                    </div>
                                </div>
                                <div class="cart-desc">
                                    Miễn phí cước vận chuyển
                                </div>
                                <div class="cart-button content-center">
                                    <input type="hidden" value="{{ $cartTotal }}" name="total" id="total">
                                    <button type="submit" id="buttonPayment" class="btn-payment button-theme button-theme_primary" data-title="Đặt hàng ngay">
                                        <span>Đặt hàng ngay</span>
                                    </button>
                                </div>
                                <div class="cart-link">
                                    <a href="{{ route('catalog.homepage') }}">Tiếp tục mua hàng</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    </div>
@endsection
@section('script')
<script>
    const handleOrder = function () {
        $('#frmPayment').submit(function (event) {
            event.preventDefault();
            event.stopPropagation();
            let form = $(this),
                btnSubmit = $("#buttonPayment"),
                htmlBtnSubmit = btnSubmit.html();
            let ajaxForm = $(this).attr('action');
            btnlinkload(btnSubmit, "Vui lòng chờ");

            if (!form[0].checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
                form.addClass('was-validated');
                btnlinkthanhcong(btnSubmit, htmlBtnSubmit);
                $('html, body').css({'scroll-behavior': 'auto'});
                $("html, body").animate({
                    scrollTop: $('#frmPayment').offset().top - 80
                }, 800);
            } else {
                $.ajax({
                    url: ajaxForm,
                    method: 'POST',
                    dataType: 'json',
                    data: $(this).serialize(),
                    beforeSend: function() {
                        let timeout = new Array();
                        timeout[0] = setTimeout(function () {
                            btnlinkload(btnSubmit, "<span>Đang kiểm tra dữ liệu</span>");
                        }, 1000);
                        timeout[1] = setTimeout(function () {
                            btnlinkload(btnSubmit, "<span>Đang xử lý dữ liệu</span>");
                        }, 1500);
                        timeout[2] = setTimeout(function () {
                            btnlinkload(btnSubmit, "<span>Đang gửi dữ liệu</span>");
                        }, 2000);
                        timeout[3] = setTimeout(function () {
                            btnlinkload(btnSubmit, "<span>Đang tạo đơn hàng...</span>");
                        }, 2500);
                    },
                    success: function(result) {
                        setTimeout(function () {
                            if (result.status == 200) {
                                Swal.fire({
                                    icon: 'success',
                                    title: "Đặt hàng thành công",
                                    text: 'Chúng tôi sẽ liên hệ lại với bạn!',
                                    buttonsStyling: false,
                                    showConfirmButton: true,
                                    showCancelButton: false,
                                    confirmButtonText: 'Tiếp tục mua hàng!',
                                    customClass: {
                                        confirmButton: 'btn btn-danger btn-no_effect'
                                    },
                                }).then((res) => {
                                    if (res.isConfirmed || res.isDismissed) {
                                        window.location.href = result.route;
                                    }
                                });
                                btnlinkthanhcong(btnSubmit, htmlBtnSubmit);
                                btnSubmit.addClass('disabled');
                                $('.cart-number').html(0);
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: result.message,
                                    text: 'Vui lòng thử lại!',
                                    buttonsStyling: false,
                                    showConfirmButton: false,
                                    showCancelButton: true,
                                    cancelButtonText: 'Thử lại!',
                                    customClass: {
                                        cancelButton: 'btn btn-danger btn-no_effect'
                                    }
                                });
                                btnlinkthanhcong(btnSubmit, htmlBtnSubmit);
                            }
                        }, 5000);
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Có lỗi xảy ra khi đặt hàng',
                            text: 'Vui lòng thử lại!',
                            buttonsStyling: false,
                            showConfirmButton: false,
                            showCancelButton: true,
                            cancelButtonText: 'Thử lại!',
                            customClass: {
                                cancelButton: 'btn btn-danger btn-no_effect'
                            }
                        });
                        btnlinkthanhcong(btnSubmit, htmlBtnSubmit);
                    }
                });
            }
            return false;
        })
    }

    $(function() {
        handleOrder();
    });
</script>
@endsection