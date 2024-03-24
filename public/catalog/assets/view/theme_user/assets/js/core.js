
/****
 * Handle Toggle Search
 */
const handleTouchMoveSearch = function (ev) {
    if (!$(ev.target).closest('#header-search #frmSearch-result.is-show').length) {
        ev.preventDefault();
    }
}

const handleToggleSearch = function () {
    $('.frmSearch-form .frmSearch-select .frmSearch-toggle_category').click(function () {
        let wrapperSelectCategory = $(this).closest('.frmSearch-select');
        if (wrapperSelectCategory.hasClass('is-show')) {
            wrapperSelectCategory.removeClass('is-show');
        } else {
            wrapperSelectCategory.addClass('is-show');
        }
    });

    $('.frmSearch-form .frmSearch-select .frmSearch-select_dropdown a').click(function () {
        if (!$(this).hasClass('active')) {
            $('.frmSearch-form .frmSearch-select .frmSearch-select_dropdown a').removeClass('active');
            $(this).addClass('active');
            $('.frmSearch-form .frmSearch-select').removeClass('is-show');

            $('.frmSearch-form .frmSearch-select .frmSearch-toggle_category span').html($(this).html());
            $('#frmSearch-category').val($(this).attr('data-id'));
            if ($('#frmSearch .frmSearch-input').val() != '') {
                $('#frmSearch .frmSearch-input').trigger('keyup');
            }
        }
    });

    $(document).mouseup(function (e) {
        let elm = $('.frmSearch-select.is-show');
        elm.is(e.target) || 0 !== elm.has(e.target).length || (
            elm.removeClass('is-show')
        )
    });

    $(document).mouseup(function (e) {
        let elm = $('#frmSearch-result.is-show');
        elm.is(e.target) || 0 !== elm.has(e.target).length || $('#frmSearch').has(e.target).length || (
            elm.removeClass('is-show'),
                $('body').css({'overflow': 'auto', 'height': '100%'}),
                document.removeEventListener('touchmove', handleTouchMoveSearch)
        )
    })
}

/****
 * Handle Open Search
 */

/****
 * Handle Search Form
 */
const handleFrmSearchSubmit = function () {
    $('#frmSearch').submit(function (event) {
        event.preventDefault();
        let valueSearch = $('#frmSearch .frmSearch-input').val();
        let idCategory = $('#frmSearch #frmSearch-category').val();
        handleOpenPageSearch(valueSearch, idCategory);
        return false;
    });
}

/****
 *
 * Handle Toggle Floating Cart
 */
const handleTouchMoveFloatingCart = (ev) => {
    if (!$(ev.target).closest('.js-show_cart .floating-cart').length) {
        ev.preventDefault();
    }
}

const handleToggleCart = () => {
    $('.js-toggle_cart').click(function () {
        handleReRenderCart();
        $('body').addClass('js-show_cart');
        document.addEventListener('touchmove', handleTouchMoveFloatingCart, {passive: false});
    });
    $(document).on('click', '.js-close_cart', function () {
        $('body').removeClass('js-show_cart');
        document.removeEventListener('touchmove', handleTouchMoveFloatingCart);
    });
}
/****
 * Handle Favourite
 */

const handleFavourite = function () {
    $(document).on('click', '.btn-favourite', function (e) {
        if (USER_ID > 1) {
            e.preventDefault();
            let btnCurrent = $(this),
                textBtnCurrent = btnCurrent.html(),
                product_id = btnCurrent.attr('data-id'),
                ajaxFavourite = URL_ROOT + 'checkout/handleFavourite';

            if (btnCurrent.hasClass('btn-onlyIcon')) {
                btnCurrent.html('<i class="fa fa-spinner fa-spin"></i>');
                btnCurrent.prop("disabled", true);
            } else {
                btnlinkload(btnCurrent);
            }

            $.post(ajaxFavourite, {
                'product_id': product_id,
                'user_id': USER_ID
            }, function (result) {
                if (result.status == 1) {
                    if (!btnCurrent.hasClass('is-selected')) {
                        btnCurrent.addClass('is-selected');
                        $(`.btn-favourite[data-id=${product_id}]`).addClass('is-selected');
                        if (!btnCurrent.hasClass('btn-onlyIcon')) {
                            textBtnCurrent = `<svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
													<g clip-path="url(#clip0_149_2043)">
														<path d="M13.0248 2.88126C12.7056 2.56189 12.3266 2.30854 11.9094 2.13569C11.4923 1.96284 11.0451 1.87387 10.5936 1.87387C10.142 1.87387 9.6949 1.96284 9.27773 2.13569C8.86057 2.30854 8.48155 2.56189 8.16233 2.88126L7.49983 3.54376L6.83733 2.88126C6.19252 2.23645 5.31798 1.87421 4.40608 1.87421C3.49418 1.87421 2.61964 2.23645 1.97483 2.88126C1.33002 3.52607 0.967773 4.40062 0.967773 5.31251C0.967773 6.22441 1.33002 7.09895 1.97483 7.74376L2.63733 8.40626L7.49983 13.2688L12.3623 8.40626L13.0248 7.74376C13.3442 7.42454 13.5976 7.04552 13.7704 6.62836C13.9433 6.2112 14.0322 5.76407 14.0322 5.31251C14.0322 4.86096 13.9433 4.41383 13.7704 3.99666C13.5976 3.5795 13.3442 3.20048 13.0248 2.88126V2.88126Z" stroke="#27272A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
													</g>
												</svg>
												Đã thêm yêu thích`;
                        }
                        btnlinkthanhcong(btnCurrent, textBtnCurrent);
                        Swal.fire({
                            icon: 'success',
                            title: result.message,
                            text: 'Sản phẩm đã thêm vào yêu thích!',
                            buttonsStyling: false,
                            showConfirmButton: true,
                            showCancelButton: false,
                            confirmButtonText: 'Xem danh sách yêu thích!',
                            customClass: {
                                confirmButton: 'btn btn-danger btn-no_effect'
                            },
                            footer: '<a class="small" style="text-decoration: underline" href="javascript:void(0)" onclick="swal.close(); return false;">Tiếp tục mua hàng</a>',
                        }).then((res) => {
                            if (res.isConfirmed) {
                                window.location.href = URL_ROOT + 'danh-sach-yeu-thich';
                            }
                        });
                    } else {
                        btnCurrent.removeClass('is-selected');
                        $(`.btn-favourite[data-id=${product_id}]`).removeClass('is-selected');
                        if (!btnCurrent.hasClass('btn-onlyIcon')) {
                            textBtnCurrent = `<svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
													<g clip-path="url(#clip0_149_2043)">
														<path d="M13.0248 2.88126C12.7056 2.56189 12.3266 2.30854 11.9094 2.13569C11.4923 1.96284 11.0451 1.87387 10.5936 1.87387C10.142 1.87387 9.6949 1.96284 9.27773 2.13569C8.86057 2.30854 8.48155 2.56189 8.16233 2.88126L7.49983 3.54376L6.83733 2.88126C6.19252 2.23645 5.31798 1.87421 4.40608 1.87421C3.49418 1.87421 2.61964 2.23645 1.97483 2.88126C1.33002 3.52607 0.967773 4.40062 0.967773 5.31251C0.967773 6.22441 1.33002 7.09895 1.97483 7.74376L2.63733 8.40626L7.49983 13.2688L12.3623 8.40626L13.0248 7.74376C13.3442 7.42454 13.5976 7.04552 13.7704 6.62836C13.9433 6.2112 14.0322 5.76407 14.0322 5.31251C14.0322 4.86096 13.9433 4.41383 13.7704 3.99666C13.5976 3.5795 13.3442 3.20048 13.0248 2.88126V2.88126Z" stroke="#27272A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
													</g>
												</svg>
												Thêm vào yêu thích`;
                        }
                        btnlinkthanhcong(btnCurrent, textBtnCurrent);
                        Swal.fire({
                            icon: 'success',
                            title: result.message,
                            text: 'Xóa sản phẩm khỏi danh sách yêu thích thành công!',
                            buttonsStyling: false,
                            showConfirmButton: true,
                            showCancelButton: false,
                            confirmButtonText: 'Xem danh sách yêu thích!',
                            customClass: {
                                confirmButton: 'btn btn-danger btn-no_effect'
                            },
                            footer: '<a class="small" style="text-decoration: underline" href="javascript:void(0)" onclick="swal.close(); return false;">Tiếp tục mua hàng</a>',
                        }).then((res) => {
                            if (res.isConfirmed) {
                                window.location.href = URL_ROOT + 'danh-sach-yeu-thich';
                            }
                        });
                    }
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
                    btnlinkthanhcong(btnCurrent, textBtnCurrent);
                }
            }, 'JSON').fail(function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Có lỗi xảy ra khi thêm vào yêu thích',
                    text: 'Vui lòng thử lại!',
                    buttonsStyling: false,
                    showConfirmButton: false,
                    showCancelButton: true,
                    cancelButtonText: 'Thử lại!',
                    customClass: {
                        cancelButton: 'btn btn-danger btn-no_effect'
                    }
                });
                btnlinkthanhcong(btnCurrent, textBtnCurrent);
            });
            return false;
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Thêm yêu thích thất bại',
                text: 'Vui lòng đăng nhập tài khoản!',
                buttonsStyling: false,
                showConfirmButton: true,
                confirmButtonText: 'Đăng nhập ngay',
                customClass: {
                    confirmButton: 'btn btn-success btn-no_effect',
                }
            }).then((res) => {
                if (res.isConfirmed) {
                    window.location.href = URL_ROOT + 'dang-nhap';
                }
            });
        }
    });
};

/****
 *
 * Handle Form Contact, Subscribe
 */

const handleFrmContact = function () {
    $('#contact-form').submit(function (event) {
        let elm = $(this),
            buttonSubmit = elm.find('button[type=submit]'),
            buttonSubmitText = buttonSubmit.html();
        btnlinkload(buttonSubmit);
        if (!elm[0].checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
            elm.addClass('was-validated');
            btnlinkthanhcong(buttonSubmit, buttonSubmitText);
        } else {
            $.post(URL_ROOT + 'lienhe/sendFrmContact', $(this).serialize(), function (result) {
                if (result.status == 1) {
                    Swal.fire({
                        icon: 'success',
                        title: result.title,
                        text: result.message,
                        buttonsStyling: false,
                        showConfirmButton: false,
                        showCancelButton: true,
                        confirmButtonText: 'Đóng!',
                        customClass: {
                            cancelButton: 'btn btn-success btn-no_effect'
                        }
                    });
                    btnlinkthanhcong(buttonSubmit, "Thành công");
                    buttonSubmit.prop('disabled', true);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: result.title,
                        text: result.message,
                        buttonsStyling: false,
                        showConfirmButton: false,
                        showCancelButton: true,
                        cancelButtonText: 'Thử lại!',
                        customClass: {
                            cancelButton: 'btn btn-danger btn-no_effect'
                        }
                    });
                    btnlinkthanhcong(buttonSubmit, buttonSubmitText);
                }
            }, 'JSON').fail(function () {
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
                btnlinkthanhcong(buttonSubmit, buttonSubmitText);
            });
        }
        return false;
    });
}

const handleFrmSubscribe = function () {
    $('#subscribe-form').submit(function (event) {
        let elm = $(this),
            buttonSubmit = elm.find('button[type=submit]'),
            buttonSubmitText = buttonSubmit.html();
        btnlinkload(buttonSubmit);
        if (!elm[0].checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
            elm.addClass('was-validated');
            btnlinkthanhcong(buttonSubmit, buttonSubmitText);
        } else {
            $.post(URL_ROOT + 'lienhe/sendSubscribe', $(this).serialize(), function (result) {
                if (result.status == 1) {
                    Swal.fire({
                        icon: 'success',
                        title: result.title,
                        text: result.message,
                        buttonsStyling: false,
                        showConfirmButton: false,
                        showCancelButton: true,
                        confirmButtonText: 'Đóng!',
                        customClass: {
                            cancelButton: 'btn btn-success btn-no_effect'
                        }
                    });
                    btnlinkthanhcong(buttonSubmit, "Thành công");
                    buttonSubmit.prop('disabled', true);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: result.title,
                        text: result.message,
                        buttonsStyling: false,
                        showConfirmButton: false,
                        showCancelButton: true,
                        cancelButtonText: 'Thử lại!',
                        customClass: {
                            cancelButton: 'btn btn-danger btn-no_effect'
                        }
                    });
                    btnlinkthanhcong(buttonSubmit, buttonSubmitText);
                }
            }, 'JSON').fail(function () {
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
                btnlinkthanhcong(buttonSubmit, buttonSubmitText);
            });
        }
        return false;
    });
}

/****
 *
 * Handle Form Account
 */
const handleViewPass = function () {
    $(document).on('click', '.view-pass', function () {
        let elm = $(this),
            elm_id = elm.attr('data-id');
        if (elm.hasClass('is-show')) {
            elm.html('<i class="fas fa-eye">');
            elm.removeClass('is-show');
            $('#' + elm_id).attr('type', 'password');
        } else {
            elm.html('<i class="fas fa-eye-slash">');
            elm.addClass('is-show');
            $('#' + elm_id).attr('type', 'text');
        }
    });
}

/****
 *
 * Popup Share Link Facebook
 */
const popupCenter = function (url, title, w, h, toolbar, status) {
    // Fixes dual-screen position                         Most browsers      Firefox
    var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : window.screenX;
    var dualScreenTop = window.screenTop != undefined ? window.screenTop : window.screenY;

    var width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
    var height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

    var systemZoom = width / window.screen.availWidth;
    var left = (width - w) / 2 / systemZoom + dualScreenLeft;
    var top = (height - h) / 2 / systemZoom + dualScreenTop;
    var newWindow = window.open(url, title, 'scrollbars=yes, width=' + w / systemZoom + ', height=' + h / systemZoom + ', top=' + top + ', left=' + left + ', toolbar=' + toolbar + ', status=' + status);

    // Puts focus on the newWindow
    if (window.focus) newWindow.focus();
}

$(function () {
    handleToggleSearch();
    handleFrmSearchInput();
    handleFrmSearchSubmit();
    handleToggleCart();

    handleFavourite();

    handleFrmSubscribe();
    handleViewPass();

    if (currentPage == 'lien-he') {
        handleFrmContact();
    }

    $('.share-facebook').click(function () {
        let href = $(this).data('href');
        let linkShare = "https://www.facebook.com/sharer/sharer.php?u=" + href + "&display=popup&ref=plugin&src=like&kid_directed_site=0";
        popupCenter(linkShare, 'Chia sẻ facebook', '614', '600', 0, 0);
    });
});
