@extends('catalog.common.layout')

@section('title')
    {!! $headingTitle !!}
@endsection

@section('content')
<div class="section-main">
    <div class="section-account section-gap">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="bg-white account-form">
                        <div class="section-heading">
                            <div class="title">
                                Đổi mật khẩu
                            </div>
                        </div>
                        <form action="{{ route('client.postResetPassword') }}" id="frmPass" class="frm-validation needs-validation" novalidate>
                            @csrf
                            <input type="hidden" name="id_taikhoan" value="{{ $userLogin->id }}">
                            <div class="frm-validation_item">
                                <label for="frm-matkhau_old" class="frm-validation_label">Mật khẩu cũ (*)</label>
                                <div class="position-relative frm-wrap_pass">
                                    <button type="button" class="btn-pass view-pass" data-id="frm-matkhau_old">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <input type="password" id="frm-matkhau_old" name="matkhau_old"
                                           minlength="6" maxlength="32"
                                           class="frm-validation_input form-control" required
                                           placeholder="Mật khẩu đăng nhập...">
                                    <div class="frm-validation_valid invalid-feedback">
                                        Vui lòng nhập mật khẩu, tối thiểu 6 kí tự
                                    </div>
                                </div>
                            </div>
                            <div class="frm-validation_item">
                                <label for="frm-matkhau" class="frm-validation_label">Mật khẩu mới (*)</label>
                                <div class="position-relative frm-wrap_pass">
                                    <button type="button" class="btn-pass view-pass" data-id="frm-matkhau">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <input type="password" id="frm-matkhau" name="matkhau"
                                           minlength="6" maxlength="32"
                                           class="frm-validation_input form-control" required
                                           placeholder="Mật khẩu đăng nhập...">
                                    <div class="frm-validation_valid invalid-feedback">
                                        Vui lòng nhập mật khẩu, tối thiểu 6 kí tự
                                    </div>
                                </div>
                            </div>
                            <div class="frm-validation_item">
                                <label for="frm-replymatkhau" class="frm-validation_label">Nhập lại mật khẩu mới(*)</label>
                                <div class="position-relative frm-wrap_pass">
                                    <button type="button" class="btn-pass view-pass" data-id="frm-replymatkhau">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <input type="password" id="frm-replymatkhau" name="replymatkhau"
                                           minlength="6" maxlength="32"
                                           class="frm-validation_input form-control" required
                                           placeholder="Nhập lại mật khẩu...">
                                    <div class="frm-validation_valid invalid-feedback">
                                        Vui lòng nhập mật khẩu, tối thiểu 6 kí tự
                                    </div>
                                </div>
                            </div>
                            <div class="frm-validation_item frm-validation_desc d-flex flex-column-reverse flex-md-row  align-items-center justify-content-between">
                                (*) là các trường bắt buộc
                            </div>
                            <div class="frm-validation_item frm-validation_button content-center">
                                <button type="submit" class="button-theme button-theme_primary" data-title="Đổi mật khẩu">
                                    <span>Đổi mật khẩu</span>
                                </button>
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
    const handleFrmPass = () => {
        $('#frmPass').submit(function (event) {
            event.preventDefault();
            let form = $(this);
            let btnSub = form.find("button[type=submit]"),
                btnSubHTML = btnSub.html();

            btnlinkload(btnSub);
            if (!form[0].checkValidity()) {
                event.stopPropagation();
                form.addClass('was-validated');
                btnlinkthanhcong(btnSub, btnSubHTML);
            } else {
                $.post($(this).attr('action'), $(this).serializeArray(), function (res) {
                    if (res.status == 200) {
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
        handleFrmPass();
    });
</script>
@endsection