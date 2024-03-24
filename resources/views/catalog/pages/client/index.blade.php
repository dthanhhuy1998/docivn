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
                                THÔNG TIN TÀI KHOẢN
                            </div>
                        </div>
                        <form action="{{ route('client.postEditInfo') }}" id="frmEditAccount" class="frm-validation needs-validation" novalidate>
                            @csrf
                            <input type="hidden" name="id_taikhoan" value="{{ $userLogin->id }}">
                            <div class="frm-validation_item">
                                <label for="frm-email" class="frm-validation_label">Email đăng nhập</label>
                                <input type="email" id="frm-email"
                                       value="{{ $userLogin->email }}"
                                       class="frm-validation_input form-control disabled" disabled
                                       placeholder="Email đăng nhập...">
                            </div>
                            <div class="frm-validation_item">
                                <label for="frm-fullname"
                                       class="frm-validation_label">Họ và tên (*)</label>
                                <input type="text" id="frm-fullname" name="tentaikhoan"
                                       class="frm-validation_input form-control" required
                                       value="{{ $userLogin->firstname }}"
                                       placeholder="Tên của bạn là...">
                                <div class="frm-validation_valid invalid-feedback">
                                    Vui lòng nhập họ tên của bạn
                                </div>
                            </div>
                            <div class="frm-validation_item">
                                <label for="frm-sdt"
                                       class="frm-validation_label">Số điện thoại (*)</label>
                                <input type="tel" id="frm-sdt" name="sdt"
                                       minlength="10"
                                       maxlength="12"
                                       class="frm-validation_input form-control" required
                                       value="{{ $userLogin->telephone }}"
                                       placeholder="Số điện thoại của bạn là...">
                                <div class="frm-validation_valid invalid-feedback">
                                    Vui lòng nhập số điện thoại của bạn
                                </div>
                            </div>
                            <div class="frm-validation_item">
                                <label for="frm-diachi"
                                       class="frm-validation_label">Địa chỉ</label>
                                <input type="text" id="frm-diachi" name="diachi"
                                       class="frm-validation_input form-control"
                                       value="{{ $userLogin->address }}"
                                       placeholder="Địa chỉ của bạn là...">
                            </div>
                            <div class="frm-validation_item frm-validation_desc d-flex flex-column-reverse flex-md-row  align-items-center justify-content-between">
                                (*) là các trường bắt buộc
                            </div>
                            <div class="frm-validation_item frm-validation_button content-center">
                                <button type="submit" class="button-theme button-theme_primary" data-title="Cập nhật tài khoản">
                                    <span>Cập nhật tài khoản</span>
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
    const handleFrmEditAccount = () => {
        $('#frmEditAccount').submit(function (event) {
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
                            title: res.message,
                            buttonsStyling: false,
                            showConfirmButton: true,
                            confirmButtonText: 'Đóng',
                            customClass: {
                                confirmButton: 'btn btn-success'
                            }
                        }).then((result) => {
                            if (result.isConfirmed || result.dismiss) {
                                location.reload();
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
        handleFrmEditAccount();
    });
</script>
@endsection