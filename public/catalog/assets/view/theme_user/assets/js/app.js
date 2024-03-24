;(function ($) {
    'use strict';
    AOS.init({once: true});

    const handleTouchMoveNavigation = function (ev) {
        if (!$(ev.target).closest('#header-navigation').length) {
            ev.preventDefault();
        }
    }
    /****
     * Handle Navigation Mobile
     */
    const handleNavigationMobile = function () {
        const elmBody = $('body'),
            elmNavigation = $('#header-navigation'),
            elmOverlay = $('#header-overlay'),
            elmToggleNavigation = $('#js-toggle_navigation');

        if (windowWidth < 992) {
            elmNavigation.find('.navigation-item .navigation-sub').map(function (index) {
                $(this).prev('.navigation-link').attr({
                    'data-bs-toggle': 'collapse',
                    'data-bs-target': "#header-sub_" + index,
                });
                $(this).attr({
                    "id": "header-sub_" + index,
                    "class": "navigation-sub collapse",
                    "data-bs-parent": "#header-navigation"
                });
            });
        }

        elmToggleNavigation.click(function () {
            if (elmBody.hasClass('navigation-show')) {
                elmBody.attr({
                    'class': '',
                    'style': ''
                });
                document.removeEventListener('touchmove', handleTouchMoveNavigation);
            } else {
                document.addEventListener('touchmove', handleTouchMoveNavigation, {passive: false});
                elmBody.attr({
                    'class': 'navigation-show',
                    'style': 'overflow-y: hidden'
                });
            }
        });

        elmOverlay.click(function () {
            elmToggleNavigation.trigger('click');
        });
    }
    /****
     * Handle Action Mobile Header
     */
    const handleSearchHeader = () => {
        const elmToggle = $('.js-toggle_search');
        elmToggle.click(function () {
            if ($(this).hasClass('is-show')) {
                $(this).removeClass('is-show');
                $('#header-search').removeClass('is-show');
                $(this).html('<i class="fal fa-search"></i>');
            } else {
                $(this).addClass('is-show');
                $('#header-search').addClass('is-show');
                $(this).html('<i class="fal fa-times"></i>');
            }
        });
    }
    /****
     * Handle Scroll Top
     */
    const handleScrollTop = function () {
        $(window).scroll(function () {
            if ($(document).scrollTop() > 500) {
                $('#return-top').addClass('is-show');
                $('#float-res a').addClass('is-show');
            } else {
                $('#return-top').removeClass('is-show');
                $('#float-res a').removeClass('is-show');
            }
        });

        $(window).scroll(function () {
            if ($(document).scrollTop() > 60) {
                $('#float-res a').addClass('is-show');
            } else {
                $('#float-res a').removeClass('is-show');
            }
        });

        $('#return-top').click(function (e) {
            e.stopPropagation();
            $('html').css('scroll-behavior', 'unset');
            $(window).scroll(function (e) {
                if ($(document).scrollTop() == 0) {
                    $('html').css('scroll-behavior', 'smooth');
                }
            });
            $("html, body").animate({
                scrollTop: 0
            }, 800);
            return false;
        });
    }
    /****
     * Handle Scroll Header
     */
    const handleHeaderScroll = function (e) {
        $(window).scroll(function (e) {
            if ($(document).scrollTop() > $('#header').innerHeight()) {
                $('#header').addClass('is-scroll').removeClass('no-scroll');
            } else {
                $('#header').removeClass('is-scroll').addClass('no-scroll');
            }
        });
    }
    /****
     * Owl Carousel
     */
    const swiperNewProduct = () => {
        var swiperNewProduct = new Swiper(".swiper-new-product", {
            loop: true,
            centeredSlides: true,
            autoplay: {
                delay: 2000,
                disableOnInteraction: false,
            },
            breakpoints: {
                320: {
                    slidesPerView: 1,
                    spaceBetween: 8,
                },
                525: {
                    slidesPerView: 2,
                    spaceBetween: 8,
                },
                991: {
                    slidesPerView: 4,
                    spaceBetween: 8,
                },
            },
        });
    }

    const swiperActivity = () => {
        var swiperActivityThumb = new Swiper(".swiper-activity-thumb", {
            breakpoints: {
                320: {
                    slidesPerView: 2.75,
                    spaceBetween: 8,
                },
                525: {
                    slidesPerView: 3.4,
                    spaceBetween: 8,
                },
                991: {
                    slidesPerView: 8,
                    spaceBetween: 8,
                },
            },
        });
        
        var swiperActivity = new Swiper(".swiper-activity", {
          loop: true,
          centeredSlides: true,
          autoplay: {
            delay: 2000,
            disableOnInteraction: false,
          },
          breakpoints: {
            640: {
              slidesPerView: 1,
              spaceBetween: 15,
            },
            768: {
              slidesPerView: 2,
              spaceBetween: 15,
            },
            1024: {
              slidesPerView: 4,
              spaceBetween: 15,
            },
          },
          navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
          },
          thumbs: {
            swiper: swiperActivityThumb,
          },
        });
    }
    
    const owlCarousel = () => {
        $('.owl-activity').owlCarousel({
            loop:true,
            autoplay:true,
            margin:10,
            nav:true,
            dots:false,
            navText : ["<img src='https://img.icons8.com/ios-filled/50/ffffff/less-than.png'/>","<img src='https://img.icons8.com/ios-filled/50/ffffff/more-than.png'/>"],
            slideSpeed: 800,
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:2
                },
                1000:{
                    items:4
                }
            }
        });
    }
    
    
    $(function () {
        handleNavigationMobile();
        handleSearchHeader();
        handleHeaderScroll();
        handleScrollTop();
        swiperActivity();
        owlCarousel();
        swiperNewProduct();
    });
})(jQuery);