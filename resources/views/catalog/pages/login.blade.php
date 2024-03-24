@extends('catalog.common.layout')

@section('content')
<div class="section-main">
    <div class="section-account section-gap">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div class="bg-white account-form">
                        <div class="section-heading">
                            <div class="title">ĐĂNG NHẬP</div>
                        </div>
                        <form action="{{ route("catalog.postClientLogin") }}" id="frmLogin" class="frm-validation needs-validation" novalidate>
                            @csrf
                            <input type="hidden" name="redirect" value="@if(isset($_GET['redirect']) && $_GET['redirect'] == 'order'){{'order'}}@endif">
                           <div class="frm-validation_item">
                                <label for="frm-email" class="frm-validation_label">Email đăng nhập (*)</label>
                                <input 
                                    type="email" id="frm-email" name="userLogin"
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
                                        type="password" id="frm-matkhau" name="passwordLogin"
                                        minlength="6" maxlength="32"
                                        class="frm-validation_input form-control" required
                                        placeholder="Mật khẩu đăng nhập..."
                                    >
                                    <div class="frm-validation_valid invalid-feedback">
                                        Vui lòng nhập mật khẩu, tối thiểu 6 kí tự
                                    </div>
                                </div>
                            </div>
                            <div class="frm-validation_item frm-validation_desc d-flex flex-column-reverse flex-md-row align-items-center justify-content-between">
                                (*) là các trường bắt buộc
                                <span>
                                    Chưa có tài khoản,
                                    <a href="{{ route('catalog.getClientRegister') }}">
                                        đăng ký ngay
                                    </a>
                                </span>
                            </div>
                            <div class="frm-validation_item frm-validation_button content-center">
                                <button type="submit" class="button-theme button-theme_primary" data-title="Đăng nhập">
                                    <span>
                                        Đăng nhập
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
    const handleFrmLogin = () => {
        $('#frmLogin').submit(function (event) {
            event.preventDefault();
            let form = $(this);
            let btnSub = form.find("button[type=submit]"),
                btnSubHTML = btnSub.html();

            btnlinkload(btnSub);
            if (!form[0].checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
                form.addClass('was-validated');
                btnlinkthanhcong(btnSub, btnSubHTML);
            } else {
                $.post($(this).attr('action'), $(this).serializeArray(), function (res) {
                    if (res.status == 200) {
                        btnlinkthanhcong(btnSub, btnSubHTML);
                        btnSub.prop("disabled", true);
                        window.location.href = res.route;
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

    $(function() {
        handleFrmLogin();
    });
</script>
@endsection