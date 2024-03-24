(function ($) {
    'use strict';
    let [avatarThumb, avatarPhoto] = [];
    const handleSlideProduct = function () {
        if ($('#detail-avatar_thumb').length > 0) {
            avatarThumb = new Swiper('#detail-avatar_thumb', {
                loopAdditionalSlides: 0,
                spaceBetween: 10,
                slidesPerView: 3,
                breakpoints: {
                    320: {
                        slidesPerView: 2.75,
                    },
                    525: {
                        slidesPerView: 3.4,
                    },
                    991: {
                        slidesPerView: 4,
                    },
                },
            });

            avatarPhoto = new Swiper('#detail-avatar_photo', {
                loop:true,
                autoplay: {
                    delay: 2000,
                    disableOnInteraction: false
                 },
                thumbs: {
                    swiper: avatarThumb,
                },
                slidesPerView: 1,
                navigation: {
                    nextEl: '#button-next',
                    prevEl: '#button-prev',
                }
            });
        } else {
            avatarPhoto = new Swiper('#detail-avatar_photo', {
                slidesPerView: 1,
                navigation: {
                    nextEl: '#button-next',
                    prevEl: '#button-prev',
                }
            });
        }
        handleZoomImageProduct($('#detail-avatar_photo [data-fancybox=detailGallery]'), avatarPhoto, avatarThumb);
    }

    const handleZoomImageProduct = function (elm, avatarPhoto, avatarThumb) {
        let i = 0;
        elm.click(function () {
            i = 0;
        });

        elm.fancybox({
            touch: true,
            beforeShow: function (instance, current) {
                let index = $(`[data-fancybox='detailGallery'][href='${current.src}']`).attr('data-index');
                avatarPhoto.slideTo(index - 1);
                if ($('#detail-avatar_thumb').length > 0) {
                    avatarThumb.slideTo(index - 1);
                }
            },
        });
    }

    const handleToc = () => {
        if ($('#description-content #toc').length > 0) {
            let flag = false;
            let textView = 'Xem nhanh';
            let textCollapseHide = 'Thu gọn';
            let textCollapseShow = 'Mở rộng';

            const handleTocInit = (element, returnCallBack) => {
                $('#description-content #toc').toc({
                    elementClass: element,
                    ulClass: 'nav',
                    heading: `${textView}<a href="javascript:void(0)" class="collapse-toc">[${textCollapseHide}]</a`,
                    selector: '#description-content h1, #description-content h2, #description-content h3, #description-content h4, #description-content h5,#description-content  h6',
                    indexingFormats: "11"
                });
                if (typeof returnCallBack === 'function') {
                    returnCallBack(true);
                }
            }
            handleTocInit('theme-toc', function (callBack) {
                if (callBack == true) {
                    $('#description-content #toc').attr({
                        'data-minheight': $('#description-content #toc .toc-heading').outerHeight(),
                        'data-height': $('#description-content #toc').outerHeight(),
                        'data-width': $('#description-content #toc').outerWidth()
                    });
                }
            })

            $('#description-content #toc').on('click', '.collapse-toc', function () {
                let elm = $('#description-content #toc');
                if (!flag) {
                    $('#description-content #toc').animate({
                        height: elm.attr('data-minheight'),
                        width: 200,
                    });
                    $(this).text(`[${textCollapseShow}]`);
                    flag = true;
                } else {
                    $('#description-content #toc').animate({
                        height: elm.attr('data-height'),
                        width: elm.attr('data-width'),
                    });
                    $(this).text(`[${textCollapseHide}]`);
                    flag = false;
                }
            });

            $("#description-content #toc a:not(.collapse-toc)").click(function (e) {
                $('body,html').animate({scrollTop: $($(this).attr('href')).offset().top - 10}, 400);
                return false;
            });
        }
    }

    const handleInitFancyBox = () => {
        if ($('#description-content img').length > 0) {
            $('#description-content img').each((index, elm) => {
                $(elm).wrap(`<a style="cursor: zoom-in" href="${$(elm).attr('src')}" data-caption="${$(elm).attr('alt')}" data-fancybox="images"></a>`);
            });

            $('[data-fancybox="images"]').fancybox({
                thumbs: {
                    autoStart: true,
                },
            });
        }
    }

    const handleSliderBlock = function () {
        let listSliderBlock = $('.detail-block_slider');
        listSliderBlock.each((index, sliderBlock) => {
            let sliderBlockID = '#' + $(sliderBlock).attr('id');
            new Swiper(sliderBlockID + ' .swiper', {
                spaceBetween: 15,
                speed: 1000,
                loop: !1,
                navigation: {
                    nextEl: sliderBlockID + ' .button-next',
                    prevEl: sliderBlockID + ' .button-prev',
                },
                breakpoints: {
                    320: {
                        slidesPerView: 1,
                    },
                    375: {
                        slidesPerView: 2,
                    },
                    600: {
                        slidesPerView: 2.25,
                    },
                    768: {
                        slidesPerView: 3.25,
                    },
                    992: {
                        slidesPerView: 4.25,
                    },
                    1199: {
                        slidesPerView: 5.25,
                    },
                    1499: {
                        slidesPerView: 6,
                    }
                }
            });
        });
    }

    const handleProductProperties = function () {
        $('.property-value_button').click(function () {
            let elm = $(this),
                elm_id = elm.attr('data-id'),
                elm_giacu = elm.attr('data-giacu'),
                elm_phantram = elm.attr('data-phantram'),
                elm_giahientai = elm.attr('data-giahientai'),
                elm_soluong = elm.attr('data-soluong'),
                elm_index = elm.attr('data-index');


            elm.closest('.js-wrapper_product').find('.btn-favourite').attr('data-idProperty', elm_id);
            elm.closest('.js-wrapper_product').find('.btn-add_cart').attr('data-idProperty', elm_id);
            elm.closest('.js-wrapper_product').find('.btn-add_buy').attr('data-idProperty', elm_id);

            // $('#price-current').html(elm_price);

            if (elm_giacu == '0') {
                // Chỉ áp dụng cho source này (class price-old) -> project khác thì check lại class
                $('.js-price[data-giacu]').closest('.price-old').fadeOut();
            } else {
                if ($('.js-price[data-giacu]').closest('.price-old').is(':hidden')) {
                    $('.js-price[data-giacu]').closest('.price-old').fadeIn();
                }
                $('.js-price[data-giacu]').html(elm_giacu);
                $('.js-price[data-phantram]').html(elm_phantram);
            }
            $('.js-price[data-giahientai]').html(elm_giahientai);

            $('.quantity-number').attr('data-max', elm_soluong);


            avatarPhoto.slideTo(elm_index - 1);
            if ($('#detail-avatar_thumb').length > 0) {
                avatarThumb.slideTo(elm_index - 1);
            }

            $('.property-value_button').removeClass('active');
            elm.addClass('active');
        });
    };

    const handleSliderProductViewed = function () {
        new Swiper('#slider-product_viewed .swiper', {
            spaceBetween: 15,
            speed: 1000,
            loop: !1,
            navigation: {
                nextEl: '#slider-product_viewed .button-next',
                prevEl: '#slider-product_viewed .button-prev',
            },
            breakpoints: {
                320: {
                    slidesPerView: 1,
                },
                375: {
                    slidesPerView: 2,
                },
                600: {
                    slidesPerView: 2.25,
                },
                991: {
                    slidesPerView: 3.25,
                },
                1199: {
                    slidesPerView: 4.25,
                },
                1499: {
                    slidesPerView: 5,
                }
            }
        });
    }

    const handleSliderProductRelated = function () {
        new Swiper('#slider-product_related .swiper', {
            spaceBetween: 15,
            speed: 1000,
            loop: !1,
            navigation: {
                nextEl: '#slider-product_related .button-next',
                prevEl: '#slider-product_related .button-prev',
            },
            breakpoints: {
                320: {
                    slidesPerView: 1,
                },
                375: {
                    slidesPerView: 2,
                },
                600: {
                    slidesPerView: 2.25,
                },
                991: {
                    slidesPerView: 3.25,
                },
                1199: {
                    slidesPerView: 4.25,
                },
                1499: {
                    slidesPerView: 5,
                }
            }
        });
    }

    $(function () {
        $('[data-bs-toggle="tooltip"]').tooltip();
        handleSlideProduct();
        handleToc();
        handleInitFancyBox();
        handleSliderBlock();
        handleProductProperties();
        handleSliderProductViewed();
        handleSliderProductRelated();
    });
})(jQuery);