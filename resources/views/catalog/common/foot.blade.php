
<script src="{{ asset('public/catalog/assets/view/theme_user/assets/lib/jquery/jquery.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/catalog/assets/view/theme_user/assets/lib/jquery-ui/jquery-ui.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/catalog/assets/view/theme_user/assets/lib/bootstrap5/bootstrap.bundle.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/catalog/assets/view/theme_user/assets/lib/swiper/swiper-bundle.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/catalog/assets/view/theme_user/assets/lib/owlcarousel/owl.carousel.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/catalog/assets/view/theme_user/assets/lib/fancybox/fancybox.min.js') }}" type="text/javascript"></script>
<!-- lightgallery plugins -->
<script src="{{ asset('public/catalog/assets/view/theme_user/assets/lib/lightgallery/lightgallery.umd.js') }}"></script>
<script src="{{ asset('public/catalog/assets/view/theme_user/assets/lib/lightgallery/plugins/thumbnail/lg-thumbnail.umd.js') }}"></script>
<script src="{{ asset('public/catalog/assets/view/theme_user/assets/lib/lightgallery/plugins/video/lg-video.umd.js') }}"></script>
<script src="{{ asset('public/catalog/assets/view/theme_user/assets/lib/aos/aos.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/catalog/assets/view/theme_user/assets/lib/sweetalert2/sweetalert2.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/catalog/assets/view/theme_user/assets/js/core.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/catalog/assets/view/theme_user/assets/js/toc.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/catalog/assets/view/theme_user/assets/js/wow.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/catalog/assets/lib/public/js/function.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/catalog/assets/view/theme_user/assets/js/app.js') }}" type="text/javascript"></script>
<script>
    /****
    * Handle Shopping Cart
    */

    const handleAddToCart2 = () => {
        $(document).on('click', '.add_to_cart', function(e) {
            e.preventDefault();
            let ajaxCart = '{{ Illuminate\Support\Facades\Route::has('catalog.cart.addToCart') ? route('catalog.cart.addToCart') : '#' }}';
            $.post(ajaxCart, {
                '_token': '{{ csrf_token() }}',
                'product_id': $(this).attr("data-id"),
                'quantity_add': 1,
                'property_id': 0
            }, function (result) {
                if (result.status == 200) {
                    $('.cart-number').html(result.cart_count);
                    Swal.fire({
                        icon: 'success',
                        title: result.message,
                        text: 'Sản phẩm đã thêm vào giỏ hàng!',
                        buttonsStyling: false,
                        showConfirmButton: true,
                        showCancelButton: false,
                        confirmButtonText: 'Kiểm tra giỏ hàng!',
                        customClass: {
                            confirmButton: 'btn btn-danger btn-no_effect'
                        },
                        footer: '<a class="small" style="text-decoration: underline" href="javascript:void(0)" onclick="swal.close(); return false;">Tiếp tục mua hàng</a>',
                    }).then((res) => {
                        if (res.isConfirmed) {
                            $('.js-toggle_cart').trigger('click');
                        }
                    });
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
                    title: 'Có lỗi xảy ra khi thêm giỏ hàng',
                    text: 'Vui lòng thử lại!',
                    buttonsStyling: false,
                    showConfirmButton: false,
                    showCancelButton: true,
                    cancelButtonText: 'Thử lại!',
                    customClass: {
                        cancelButton: 'btn btn-danger btn-no_effect'
                    }
                });
            });
        });
    }

    const handleQuantityProduct2 = function () {
        $(document).on('click', '.quantity2 .quantity-button', function (e) {
            e.preventDefault();
            let type = parseInt($(this).attr('data-type'));
            let numberQuantity = $(this).closest('.quantity2').find('.quantity-number');

            let maxQuantity = parseInt(numberQuantity.attr('data-max')),
                valueQuantity = parseInt(numberQuantity.val());
                
            if (!isNaN(type)) {
                if (type === 1) {
                    if (valueQuantity > maxQuantity - 1) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Số lượng cần thêm vượt quá số lượng sản phẩm trong kho!',
                            text: 'Vui lòng thử lại!',
                            buttonsStyling: false,
                            showConfirmButton: false,
                            showCancelButton: true,
                            cancelButtonText: 'Thử lại!',
                            customClass: {
                                cancelButton: 'btn btn-danger btn-no_effect'
                            }
                        }).then((res) => {
                            if (res.isDismissed) {
                                valueQuantity = maxQuantity;
                            }
                        });
                    } else {
                        valueQuantity += 1;
                    handleUpdateCart2(numberQuantity.attr('data-id'), valueQuantity, numberQuantity.attr('data-key'), numberQuantity.parent());
                    }
                } else if (type === 0) {
                    if (valueQuantity > 1)
                        valueQuantity -= 1;
                    handleUpdateCart2(numberQuantity.attr('data-id'), valueQuantity, numberQuantity.attr('data-key'), numberQuantity.parent());
                }
                numberQuantity.val(valueQuantity);
            }
        });

        $(document).on('keyup', '.quantity2 .quantity-number', function () {
            let maxQuantity = parseInt($(this).attr('data-max'));
            if (isNaN($(this).val()) || $(this).val() < 1) {
                if ($(this).closest('#floating-cart').length == 1) {
                    handleUpdateCart2($(this).attr('data-id'), 1, $(this).attr('data-key'), $(this).parent());
                }
            } else {
                if ($(this).val() > maxQuantity) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Số lượng cần thêm vượt quá số lượng sản phẩm trong kho!',
                        text: 'Vui lòng thử lại!',
                        buttonsStyling: false,
                        showConfirmButton: false,
                        showCancelButton: true,
                        cancelButtonText: 'Thử lại!',
                        customClass: {
                            cancelButton: 'btn btn-danger btn-no_effect'
                        }
                    }).then((res) => {
                        if (res.isDismissed) {
                            $(this).closest('.js-wrapper_product').find('.quantity-number').val(maxQuantity);
                            if (currentPage == 'chi-tiet-sp' && $(this).closest('#floating-cart').length == 0) {
                                btnAddToCart.attr('data-quantity', maxQuantity);
                                btnAddToBuy.attr('data-quantity', maxQuantity);
                            }
                        }
                    });
                } else {
                    $(this).closest('.js-wrapper_product').find('.quantity-number').val($(this).val());
                    handleUpdateCart2($(this).attr('data-id'), $(this).val(), $(this).attr('data-key'), $(this).parent());
                }
            }
        });
    }

    const handleUpdateCart2 = function (product_id = -1, quantity = -1, key = -1, elm = '') {
        let ajaxCart = '{{ Illuminate\Support\Facades\Route::has('catalog.cart.postUpdateCart') ? route('catalog.cart.postUpdateCart') : '#' }}';
        // Floating Cart
        let elmFloatInputQuantity = $(`#floating-cart .quantity-number[data-key=${key}]`),
            elmFloatButtonQuantity = elmFloatInputQuantity.parent().find('.quantity-button');

        elmFloatInputQuantity.addClass('disabled');
        elmFloatButtonQuantity.addClass('disabled');

        let {elmCartInputQuantity, elmCartButtonQuantity} = '';

        elmCartInputQuantity = $(`#cart-item_${key} .quantity-number[data-key=${key}]`);
        elmCartButtonQuantity = elmFloatInputQuantity.parent().find('.quantity-button');
        elmCartInputQuantity.addClass('disabled');
        elmCartButtonQuantity.addClass('disabled');
        
        $.post(ajaxCart, {
            '_token': '{{ csrf_token() }}',
            'product_id': product_id, 
            'quantity_add': quantity, 
            'key': key
        }, function (result) {
            if (result.status == 200) {
                Swal.fire({
                    icon: 'success',
                    title: result.message,
                    text: 'Cập nhật giỏ hàng thành công!',
                    buttonsStyling: false,
                    showConfirmButton: true,
                    showCancelButton: false,
                    confirmButtonText: 'Đặt hàng ngay!',
                    customClass: {
                        confirmButton: 'btn btn-danger btn-no_effect'
                    },
                    footer: '<a class="small" style="text-decoration: underline" href="javascript:void(0)" onclick="swal.close(); return false;">Tiếp tục mua hàng</a>',
                }).then((res) => {
                    if (res.isConfirmed) {
                        window.location.href = result.route;
                    }
                });
                $('#soluongCheckout').html(result.count);
                $('.totalCheckout').html(result.total);
                $('.cart-number').html(result.count);
                $('#floating-cart .cart-bottom .cart-price_value').html(result.total);
                // update data
                elmFloatInputQuantity.removeClass('disabled');
                elmFloatButtonQuantity.removeClass('disabled');
                elmCartInputQuantity.parents('.cart-quantity').next('.cart-total').html(result.dongia+'đ');
                elmCartInputQuantity.removeClass('disabled');
                elmCartButtonQuantity.removeClass('disabled');
                // Cập nhật đồng thời trang giỏ hàng và floating cart
                elmCartInputQuantity.val(quantity);
                elmFloatInputQuantity.val(quantity);
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
                }).then((res) => {
                    if (res.isDenied || res.isDismissed) {
                        location.reload();
                    }
                });
                elmFloatInputQuantity.removeClass('disabled');
                elmFloatButtonQuantity.removeClass('disabled');
                if (currentPage == 'gio-hang') {
                    elmCartInputQuantity.removeClass('disabled');
                    elmCartButtonQuantity.removeClass('disabled');
                }
            }
        }, 'JSON').fail(function () {
            Swal.fire({
                icon: 'error',
                title: 'Có lỗi xảy ra khi cập nhật giỏ hàng',
                text: 'Vui lòng thử lại!',
                buttonsStyling: false,
                showConfirmButton: false,
                showCancelButton: true,
                cancelButtonText: 'Thử lại!',
                customClass: {
                    cancelButton: 'btn btn-danger btn-no_effect'
                }
            }).then((res) => {
                if (res.isDenied || res.isDismissed) {
                    location.reload();
                }
            });
            elmFloatInputQuantity.removeClass('disabled');
            elmFloatButtonQuantity.removeClass('disabled');
            if (currentPage == 'gio-hang') {
                elmCartInputQuantity.addClass('disabled');
                elmCartButtonQuantity.addClass('disabled');
            }
        });
        return false;
    }

    const handleDeleteCart = function () {
        $(document).on('click', '.delete-cart', function () {
            let ajaxCart = '{{ Illuminate\Support\Facades\Route::has('catalog.cart.getCartRemove') ? route('catalog.cart.getCartRemove') : '#' }}';

            let buttonDelete = $(this),
                htmlButtonDelete = buttonDelete.html(),
                product_id = buttonDelete.attr('data-id'),
                product_key = buttonDelete.attr('data-key');

            buttonDelete.html('<i class="fa fa-spinner fa-spin uk-icon-spinner uk-icon-spin"></i>');
            buttonDelete.prop("disabled", true);
            $.post(ajaxCart, {
                '_token': '{{ csrf_token() }}',
                'product_id': product_id, 
                'key': product_key
            }, function (result) {
                if (result.status == 200) {
                    if (result.count == 0) {
                        Swal.fire({
                            icon: 'success',
                            title: result.message,
                            text: 'Giỏ hàng đang trống!',
                            buttonsStyling: false,
                            showConfirmButton: true,
                            showCancelButton: false,
                            confirmButtonText: 'Về trang chủ!',
                            customClass: {
                                confirmButton: 'btn btn-danger btn-no_effect'
                            },
                            footer: '<a class="small" style="text-decoration: underline" href="javascript:void(0)" onclick="swal.close(); return false;">Tiếp tục mua hàng</a>',
                        }).then((res) => {
                            if (res.isConfirmed || res.isDismissed) {
                                window.location.href = result.route;
                            }
                        });
                        $("#floating-cart .cart-list").hide();
                        $("#floating-cart .cart-bottom").hide();
                        $("#floating-cart .cart-empty").show();
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: result.message,
                            text: 'Cập nhật giỏ hàng thành công!',
                            buttonsStyling: false,
                            showConfirmButton: true,
                            showCancelButton: false,
                            confirmButtonText: 'Đặt hàng ngay!',
                            customClass: {
                                confirmButton: 'btn btn-danger btn-no_effect'
                            },
                            footer: '<a class="small" style="text-decoration: underline" href="javascript:void(0)" onclick="swal.close(); return false;">Tiếp tục mua hàng</a>',
                        }).then((res) => {
                            if (res.isConfirmed) {
                                window.location.href = result.order;
                            }
                        });
                    }

                    $('.cart-number').html(result.count);
                    $('#soluongCheckout').html(result.count);
                    $('.totalCheckout').html(result.total);
                    $('.cart-price_value').html(result.total);
                    buttonDelete.parents('.cart-item').fadeIn(function () {
                        buttonDelete.parents('.cart-item').remove();
                    });
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
                    btnlinkthanhcong(buttonDelete, htmlButtonDelete);
                }
            }, 'JSON').fail(function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Có lỗi xảy ra khi cập nhật giỏ hàng',
                    text: 'Vui lòng thử lại!',
                    buttonsStyling: false,
                    showConfirmButton: false,
                    showCancelButton: true,
                    cancelButtonText: 'Thử lại!',
                    customClass: {
                        cancelButton: 'btn btn-danger btn-no_effect'
                    }
                });
                btnlinkthanhcong(buttonDelete, htmlButtonDelete);
            });
            return false;
        });
    }

    const renderCardProduct = (elm) => {
        const {
            rowId,
            name,
            options,
            price,
            discount,
            qty,
            subtotal,
            tax,
            weight
        } = elm;

        
        return $(`<div class="cart-item" data-key="${rowId}">
            <a class="cart-item_image" href="${options.view}">
                <img src="${options.image}" alt="${name}">
            </a>
            <div class="cart-item_info">
                <a class="cart-item_title"
                    href="${name}">
                    ${name}
                </a>
                <div class="cart-price">
                    <div class="current">${tien(price.toString())}đ</div>
                </div>
                <div class="cart-quantity">
                    <div class="quantity2">
                        <span class="dec quantity-button" data-type="0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>
                        </span>
                        <input type="text" value="${qty}" name="quantity-number"
                                class="quantity-number"
                                data-idproperty="-1"
                                data-max="${options.max_qty}"
                                data-key="${rowId}"
                                data-id="${rowId}">
                        <span class="inc quantity-button" data-type="1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>
                        </span>
                    </div>
                </div>
                <div class="cart-actions">
                    <a href="${options.view}"
                        class="cart-action_item">
                        <svg width="20" height="20" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                            <path d="M0.833344 10C0.833344 10 4.16668 3.33337 10 3.33337C15.8333 3.33337 19.1667 10 19.1667 10C19.1667 10 15.8333 16.6667 10 16.6667C4.16668 16.6667 0.833344 10 0.833344 10Z"
                                    stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M10 12.5C11.3807 12.5 12.5 11.3807 12.5 10C12.5 8.61929 11.3807 7.5 10 7.5C8.61929 7.5 7.5 8.61929 7.5 10C7.5 11.3807 8.61929 12.5 10 12.5Z"
                                    stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </a>
                    <button type="button" class="delete-cart cart-action_item btn-onlyIcon"
                            data-key="${rowId}" data-id="${rowId}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24">
                            <polyline points="3 6 5 6 21 6"></polyline>
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                            <line x1="10" y1="11" x2="10" y2="17"></line>
                            <line x1="14" y1="11" x2="14" y2="17"></line>
                        </svg>
                    </button>
                </div>
            </div>
        </div>`);
    }

    const handleReRenderCart = () => {
        $.post('{{ Illuminate\Support\Facades\Route::has('catalog.cart.postCart') ? route('catalog.cart.postCart') : '#' }}', {'_token': '{{ csrf_token() }}'}, function (res) {
            if (res.status == 200) {
                if (res.data.length > 0) {
                    let data = (res.data.list);
                    $("#floating-cart .cart-list").show();
                    $("#floating-cart .cart-bottom").show();
                    $("#floating-cart .cart-empty").hide();
                    let htmlCart = '';
                    $.map(data, function (elm, idx) {
                        let htmlItem = renderCardProduct(elm)[0];
                        htmlCart += htmlItem.outerHTML;
                    });
                    $("#floating-cart .cart-price_value").html(tien(res.data.total.toString()) + 'đ');
                    $("#floating-cart .cart-list").html(htmlCart);
                } else {
                    $("#floating-cart .cart-list").hide();
                    $("#floating-cart .cart-bottom").hide();
                    $("#floating-cart .cart-empty").show();
                }
                $('.cart-number').html(res.data.length);
            } else {
                $("#floating-cart .cart-list").hide();
                $("#floating-cart .cart-bottom").hide();
                $("#floating-cart .cart-empty").show();
            }
        }, "JSON").fail(function (xhr) {
            Swal.fire({
                icon: 'error',
                title: 'Thất bại',
                text: 'Có lỗi xảy ra, vui lòng thử lại',
                buttonsStyling: false,
                showConfirmButton: false,
                showCancelButton: true,
                cancelButtonText: 'Thử lại',
                customClass: {
                    cancelButton: 'btn btn-danger'
                }
            });
            $("#floating-cart .cart-list").hide();
            $("#floating-cart .cart-bottom").hide();
            $("#floating-cart .cart-empty").show();
        });
    }

    /****
    * Handle Searching
    */
    const handleOpenPageSearch = function (valueSearch, idCategory = -1) {
        if (valueSearch == '') {
            Swal.fire({
                icon: 'error',
                title: 'Bạn chưa nhập từ khóa tìm kiếm',
                text: 'Vui lòng thử lại!',
                buttonsStyling: false,
                showConfirmButton: false,
                showCancelButton: true,
                cancelButtonText: 'Thử lại!',
                customClass: {
                    cancelButton: 'btn btn-danger btn-no_effect'
                }
            });
        } else {
            let urlOpenSearch ='{{ Illuminate\Support\Facades\Route::has('catalog.search') ? route('catalog.search') : '#' }}';
            location.href = urlOpenSearch+'?tukhoa='+valueSearch;
        }
    }

    let isSearching = false;
    const handleFrmSearchInput = function () {
        $('#frmSearch .frmSearch-input').keyup(function (event) {
            let valueSearch = $(this).val(),
                urlSearch = '{{ Illuminate\Support\Facades\Route::has('catalog.quickSearch') ? route('catalog.quickSearch') : '#' }}',
                eventKey = event.which || event.keyCode;

            if (eventKey === 13) {
                handleOpenPageSearch(valueSearch);
            }

            if (valueSearch === '') {
                $('#search-result').removeClass('show');
            } else if (!isSearching) {
                valueSearch = ChangeToSlugSearch(valueSearch);
                isSearching = true;
                $.post(urlSearch, {
                    '_token': '{{ csrf_token() }}',
                    'keySearch': valueSearch,
                }, function (result) {
                    if (result.status === 200) {
                        let productItem = '';
                        let renderProduct = '';
                        $('body').css({'overflow-y': 'hidden', 'height': '100vh'});
                        document.addEventListener('touchmove', handleTouchMoveSearch, {passive: false});

                        let heightHeader = $('#header').outerHeight() + $('#frmSearch').outerHeight(),
                            maxHeightSearchResult = `calc(100vh - ${heightHeader + 'px'})`;
                        $('#frmSearch-result').css({
                            '--max-height': maxHeightSearchResult
                        });

                        if (result.data != null) {
                            result.data.map(function (elm, idx) {
                                productItem += renderProductItemSearch(elm);
                            });

                            renderProduct = `<div class="row row-cols-md-3 row-cols-xl-4 row-cols-xxl-5 row-cols-1 row-cols-sm-2 g-3">${productItem}</div>`;
                        }


                        $('#frmSearch-result').html(renderProduct).addClass('is-show');
                        isSearching = false;
                    } else {
                        isSearching = false;
                        $('#frmSearch-result').addClass('no-result').html('<div class="text-white fw-bolder">'+result.message+'</div>');
                    }
                }, "JSON").fail(function () {
                    isSearching = false;
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
                    }).then((res) => {
                        if (res.isDismissed) {
                            $('body').css({'overflow': 'auto', 'height': '100%'});
                            $('#frmSearch-result').html('').removeClass('is-show');
                            document.removeEventListener('touchmove', handleTouchMoveSearch);
                        }
                    });
                });
            }
            return false;
        });
    };

    const renderProductItemSearch = (elm) => {
        const {
            prd_id,
            prd_image,
            prd_name,
            prd_o_price,
            prd_price,
            wishlist,
            review,
            redirect,
        } = elm;

        let hintFavourite = 'Thêm yêu thích';
        let classFavourite = '';
        if (parseInt(wishlist) == 1) {
            hintFavourite = 'Bỏ yêu thích';
            classFavourite = 'is-selected';
        }

        let priceRender = '';
        if (prd_price > 0) {
            priceRender = `<ins>${prd_price}đ</ins>`;
        } else {
            priceRender = `<ins>Liên hệ</ins>`;
        }

        // let danhmucRender = '';
        // if (typeof thongtindanhmuc != 'undefined') {
        //     danhmucRender = `<div class="card-category">
        //                                 <a href="${thongtindanhmuc.linkurl}">
        //                                     ${thongtindanhmuc.ten}
        //                                 </a>
        //                             </div>`;
        // }

        let reviewRender = '';
        if (typeof review != 'undefined') {
            let classRate = ''
            let starRender = '';
            for (star = 1; star <= 10; star++) {
                if (star == parseInt(review.value)) {
                    classRate = 'is-checked';
                } else {
                    classRate = '';
                }

                if (star % 2 == 0) {
                    starRender += `<label class="star-item ${classRate}"><i class="fas fa-star"></i></label>`;
                } else {
                    starRender += `<label class="star-item star-item_half ${classRate}"><i class="fas fa-star-half"></i></label>`;
                }
            }

            reviewRender = `<div class="card-star">
                                <span class="star is-rate">
                                    ${starRender}
                                </span>
                            </div>`;
        }

        let productItemHTML = `<div class="col">
                            <div class="product-card card">
                                <div class="card-header">
                                    <a class="card-image ratio ratio-1x1"
                                    href="${redirect}">
                                    ${prd_image}
                                        <img src="${prd_image}"
                                            height="250" width="250"
                                            alt="${prd_name}">
                                    </a>
                                    <div class="card-actions">
                                        <div class="card-action">
                                            <button type="button"
                                                    class="btn-favourite btn-onlyIcon ${classFavourite}"
                                                    data-id="${prd_id}">
                                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M17.3667 3.84172C16.941 3.41589 16.4357 3.0781 15.8795 2.84763C15.3232 2.61716 14.7271 2.49854 14.125 2.49854C13.5229 2.49854 12.9268 2.61716 12.3705 2.84763C11.8143 3.0781 11.309 3.41589 10.8833 3.84172L10 4.72506L9.11666 3.84172C8.25692 2.98198 7.09086 2.49898 5.875 2.49898C4.65914 2.49898 3.49307 2.98198 2.63333 3.84172C1.77359 4.70147 1.29059 5.86753 1.29059 7.08339C1.29059 8.29925 1.77359 9.46531 2.63333 10.3251L3.51666 11.2084L10 17.6917L16.4833 11.2084L17.3667 10.3251C17.7925 9.89943 18.1303 9.39407 18.3608 8.83785C18.5912 8.28164 18.7099 7.68546 18.7099 7.08339C18.7099 6.48132 18.5912 5.88514 18.3608 5.32893C18.1303 4.77271 17.7925 4.26735 17.3667 3.84172Z"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body pb-0">
                                    ${reviewRender}
                                    <div class="card-title">
                                        <a href="${redirect}">
                                            ${prd_name}
                                        </a>
                                    </div>
                                    <div class="card-bottom">
                                        <div class="card-price" style="color: #fff; border: none;">
                                            ${priceRender}
                                        </div>
                                        <div class="card-view">
                                            <a href="${redirect}"
                                            class="button-theme button-theme_white" data-title="Thêm vào giỏ" style="max-width: 100%;">
                                                <span>Thêm vào giỏ</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`;

        return productItemHTML;
    }
    
    $(function() {
        handleAddToCart2();
        handleQuantityProduct2();
        handleReRenderCart();
        handleDeleteCart();
    });
</script>

{!! $code_footer !!}