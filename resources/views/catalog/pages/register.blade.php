@extends('catalog.common.layout')

@section('content')
<div class="section-main">

    <div class="section-account section-gap">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div class="bg-white account-form">
                        <div class="section-heading">
                            <div class="title">ĐĂNG KÝ TÀI KHOẢN</div>
                            <div class="alert alert-primary" role="alert">
                                Quản lý đơn hàng, chương trình ưu đãi và nhiều tiện ích khác <br/>
                                Đăng ký thành viên ngay!
                            </div>
                        </div>
                        <form action="{{ route('catalog.postClientRegister') }}" id="frmRegister" class="frm-validation needs-validation" novalidate>
                            @csrf
                            <div id="show_errors"></div>
                            <div class="frm-validation_item">
                                <label for="frm-email" class="frm-validation_label">Email đăng nhập (*)</label>
                                <input 
                                    type="email" id="frm-email" name="emaildangnhap"
                                    class="frm-validation_input form-control" required
                                    placeholder="Email đăng nhập..."
                                >
                                <div class="frm-validation_valid invalid-feedback">
                                    Vui lòng nhập đúng định dạng email: example@abc.com
                                </div>
                            </div>
                            <div class="frm-validation_item">
                                <label for="frm-matkhau" class="frm-validation_label">Mật khẩu đăng nhập (*)</label>
                                <div class="position-relative frm-wrap_pass">
                                    <button type="button" class="btn-pass view-pass" data-id="frm-matkhau">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <input 
                                        type="password" id="frm-matkhau" name="matkhau"
                                        minlength="6" maxlength="32"
                                        class="frm-validation_input form-control" required
                                        placeholder="Mật khẩu đăng nhập..."
                                    >
                                    <div class="frm-validation_valid invalid-feedback">
                                        Vui lòng nhập mật khẩu, tối thiểu 6 kí tự
                                    </div>
                                </div>
                            </div>
                            <div class="frm-validation_item">
                                <label for="frm-replymatkhau" class="frm-validation_label">Nhập lại mật khẩu (*)</label>
                                <div class="position-relative frm-wrap_pass">
                                    <button type="button" class="btn-pass view-pass" data-id="frm-replymatkhau">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <input 
                                        type="password" id="frm-replymatkhau" name="replymatkhau"
                                        minlength="6" maxlength="32"
                                        class="frm-validation_input form-control" required
                                        placeholder="Nhập lại mật khẩu..."
                                    >
                                    <div class="frm-validation_valid invalid-feedback">
                                        Vui lòng nhập mật khẩu, tối thiểu 6 kí tự
                                    </div>
                                </div>
                            </div>
                            <div class="frm-validation_item">
                                <label for="frm-fullname" class="frm-validation_label">Họ và tên (*)</label>
                                <input 
                                    type="text" id="frm-fullname" name="tentaikhoan" minlength="3"
                                    class="frm-validation_input form-control" required
                                    placeholder="Tên của bạn là..."
                                >
                                <div class="frm-validation_valid invalid-feedback">
                                    Vui lòng nhập họ tên của bạn
                                </div>
                            </div>
                            <div class="frm-validation_item">
                                <label for="frm-phone" class="frm-validation_label">Số điện thoại (*)</label>
                                <input 
                                    type="tel" id="frm-phone" name="sdt"
                                    class="frm-validation_input form-control"
                                    minlength="10" maxlength="12" required
                                    placeholder="Số điện thoại bạn là..."
                                >
                                <div class="frm-validation_valid invalid-feedback">
                                    Vui lòng nhập số điện thoại của bạn
                                </div>
                            </div>
                            <div class="frm-validation_item">
                                <label for="frm-message" class="frm-validation_label">Địa chỉ</label>
                                <input 
                                    id="frm-message" name="diachi"
                                    class="frm-validation_input form-control"
                                    placeholder="Địa chỉ của bạn là.."
                                >
                            </div>
                            <div class="frm-validation_item frm-validation_desc d-flex flex-column-reverse flex-md-row align-items-center justify-content-between">
                                (*) là các trường bắt buộc
                                <span>
                                    Đã có tài khoản,
                                    <a href="{{ route('catalog.clientLogin') }}">
                                        đăng nhập ngay
                                    </a>
                                </span>
                            </div>
                            <div class="frm-validation_item frm-validation_button content-center">
                                <button type="submit" class="button-theme button-theme_primary" data-title="Đăng ký tài khoản">
                                    <span>
                                        Đăng ký tài khoản
                                    </span>
                                </button>
                            </div>
                            <div class="frm-validation_item mt-2 text-center">
                                <a href="{{ route('catalog.homepage') }}">Quay về trang chủ</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    const handleFrmRegister = () => {
        $('#frmRegister').submit(function (event) {
            event.preventDefault();
            let form = $(this);
            let btnSub = form.find("button[type=submit]"),
                btnSubHTML = btnSub.html();

            btnlinkload(btnSub);
            if (!form[0].checkValidity()) {
                $('#show_errors').html('');
                event.stopPropagation();
                form.addClass('was-validated');
                btnlinkthanhcong(btnSub, btnSubHTML);
                $('html, body').css({'scroll-behavior': 'auto'});
                $("html, body").animate({
                    scrollTop: $('#frmRegister').offset().top - 80
                }, 800);
            } else {
                $.post($(this).attr('action'), $(this).serializeArray(), function (res) {
                    if (res.status == 200) {
                        $('#show_errors').html('');
                        Swal.fire({
                            icon: 'success',
                            title: res.title,
                            text: res.message,
                            buttonsStyling: false,
                            showConfirmButton: true,
                            confirmButtonText: 'Đóng',
                            customClass: {
                                confirmButton: 'btn btn-success'
                            }
                        }).then((result) => {
                            if (result.isConfirmed || result.dismiss) {
                                location.href = res.route;
                            }
                        });
                        btnlinkthanhcong(btnSub, btnSubHTML);
                        btnSub.prop("disabled", true);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: res.title,
                            text: res.message,
                            buttonsStyling: false,
                            showConfirmButton: false,
                            showCancelButton: true,
                            cancelButtonText: 'Thử lại',
                            customClass: {
                                cancelButton: 'btn btn-danger'
                            }
                        });
                        $('#show_errors').html(showErrors(res.errors));
                        $('html, body').css({'scroll-behavior': 'auto'});
                        $("html, body").animate({
                            scrollTop: $('#frmRegister').offset().top - 80
                        }, 800);
                        btnlinkthanhcong(btnSub, btnSubHTML);
                    }
                }, "JSON").fail(function (xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Thất bại',
                        text: 'Có lỗi xảy ra trong quá trình gửi thông tin, vui lòng thử lại',
                        buttonsStyling: false,
                        showConfirmButton: false,
                        showCancelButton: true,
                        cancelButtonText: 'Thử lại',
                        customClass: {
                            cancelButton: 'btn btn-danger'
                        }
                    });
                    btnlinkthanhcong(btnSub, btnSubHTML);
                });
            }
            return false;
        });
    }

    function showErrors(errors) {
        let message = '<div class="alert alert-danger" role="alert">';
            $.each(errors, function(i, item) {
                message += '- '+item[0]+'<br/>';
            });
        message += '</div>';
        return message;
    }

    $(function() {
        handleFrmRegister();
    });
</script>
@endsection