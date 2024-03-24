(function ($) {
    'use strict';
    new WOW().init();
    const handleSliderHero = function () {
        new Swiper('#slider-hero .swiper', {
            speed: 1000,
            slidesPerView: 1,
            preloadImages: false,
            effect: 'slide',
            loop: false,
            navigation: {
                nextEl: '#slider-hero .button-next',
                prevEl: '#slider-hero .button-prev',
            },
        });
    }
    
    const handleSliderProductModule = function () {
        new Swiper('#slider-product_module .swiper', {
            spaceBetween: 15,
            speed: 1000,
            loop: !1,
            navigation: {
                nextEl: '#slider-product_module .button-next',
                prevEl: '#slider-product_module .button-prev',
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
                    slidesPerView: 4,
                },
            }
        });
    }

    const handleSliderCategory = function () {
        let listSliderCategory = $('.slider-product');
        listSliderCategory.each((index, sliderCategory) => {
            let sliderID = '#' + $(sliderCategory).attr('id');
            new Swiper(sliderID + ' .swiper', {
                speed: 1000,
                loop: !1,
                spaceBetween: 15,
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
                        slidesPerView: 4,
                    },
                    1400: {
                        slidesPerView: 5,
                    }
                },
                navigation: {
                    nextEl: sliderID + ' .button-next',
                    prevEl: sliderID + ' .button-prev',
                },
            });
        });
    }

    const handleSliderArticle = function () {
        new Swiper('#slider-article .swiper', {
            speed: 1000,
            spaceBetween: 20,
            preloadImages: false,
            effect: 'slide',
            navigation: {
                nextEl: '#slider-article .button-next',
                prevEl: '#slider-article .button-prev',
            },
            breakpoints: {
                320: {
                    slidesPerView: 1.4,
                },
                768: {
                    slidesPerView: 2.4,
                },
                1200: {
                    slidesPerView: 3,
                }
            }
        });
    }

    const handleCounter = () => {
        let i = 0;
        $(window).scroll(function () {
            let counterOffsetTop = $('#js-counter').offset().top - window.innerHeight;
            if (i === 0 && $(window).scrollTop() > counterOffsetTop) {
                $('.js-counter_item').each(function () {
                    let counterItem = $(this),
                        counterItemValue = counterItem.attr('data-value');
                    $({countNum: counterItem.text()}).animate(
                        {countNum: counterItemValue},
                        {
                            duration: 2000,
                            easing: 'swing',
                            step: function () {
                                counterItem.text(Math.floor(this.countNum));
                            },
                            complete: function () {
                                counterItem.html(tien(this.countNum.toString()) + '+');
                            }
                        });
                });
                i = 1;
            }
        });
    }

    $(function () {
        handleSliderHero();
        handleSliderProductModule();
        handleSliderCategory();
        handleSliderArticle();
        // handleCounter();
    });
})(jQuery);