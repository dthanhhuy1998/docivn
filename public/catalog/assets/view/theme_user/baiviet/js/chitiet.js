(function ($) {
        'use strict';
        $(function () {
            handleToc();
            handleInitFancyBox();
        });

        const handleToc = () => {
            if ($('#article-content #toc').length > 0) {
                let flag = false;
                let textView = 'Xem nhanh';
                let textCollapseHide = 'Thu gọn';
                let textCollapseShow = 'Mở rộng';

                const handleTocInit = (element, returnCallBack) => {
                    $('#article-content #toc').toc({
                        elementClass: element,
                        ulClass: 'nav',
                        heading: `${textView}<a href="javascript:void(0)" class="collapse-toc">[${textCollapseHide}]</a`,
                        selector: '#article-content h1, #article-content h2, #article-content h3, #article-content h4, #article-content h5,#article-content  h6',
                        indexingFormats: "11"
                    });
                    if (typeof returnCallBack === 'function') {
                        returnCallBack(true);
                    }
                }
                handleTocInit('theme-toc', function (callBack) {
                    if (callBack == true) {
                        $('#article-content #toc').attr({
                            'data-minheight': $('#article-content #toc .toc-heading').outerHeight(),
                            'data-height': $('#article-content #toc').outerHeight(),
                            'data-width': $('#article-content #toc').outerWidth()
                        });
                    }
                })

                $('#article-content #toc').on('click', '.collapse-toc', function () {
                    let elm = $('#article-content #toc');
                    if (!flag) {
                        $('#article-content #toc').animate({
                            height: elm.attr('data-minheight'),
                            width: 200,
                        });
                        $(this).text(`[${textCollapseShow}]`);
                        flag = true;
                    } else {
                        $('#article-content #toc').animate({
                            height: elm.attr('data-height'),
                            width: elm.attr('data-width'),
                        });
                        $(this).text(`[${textCollapseHide}]`);
                        flag = false;
                    }
                });

                $("#article-content #toc a:not(.collapse-toc)").click(function (e) {
                    $('body,html').animate({scrollTop: $($(this).attr('href')).offset().top - 10}, 400);
                    return false;
                });
            }
        }

        const handleInitFancyBox = () => {
            if ($('#article-content img').length > 0) {
                $('#article-content img').each((index, elm) => {
                    $(elm).wrap(`<a style="cursor: zoom-in" href="${$(elm).attr('src')}" data-caption="${$(elm).attr('alt')}" data-fancybox="images"></a>`);
                });

                $('[data-fancybox="images"]').fancybox({
                    thumbs: {
                        autoStart: true,
                    },
                });
            }
        }
    }
)
(jQuery);