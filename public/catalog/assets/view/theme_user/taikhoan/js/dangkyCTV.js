if (currentPage == 'dang-ky-ctv') {
    ;(function ($) {
        'use strict';
        const handleFrmContact = () => {
            $('#formDangKyBanhang').submit(function (event) {
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
                    $.post(URL_ROOT + 'lienhe/sendFrmDangKyBanHang', $(this).serializeArray(), function (res) {
                        if (res.status == 1) {
                            Swal.fire({
                                icon: 'success',
                                title: res.title,
                                text: res.message,
                                buttonsStyling: false,
                                showConfirmButton: true,
                                confirmButtonText: `${res.button}`,
                                customClass: {
                                    confirmButton: 'btn btn-success'
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
                                cancelButtonText: `${res.button}`,
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
        $(function () {
            handleFrmContact();
        });
    })(jQuery);
}