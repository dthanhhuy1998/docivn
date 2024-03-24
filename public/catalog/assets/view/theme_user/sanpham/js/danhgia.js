if (currentPage == 'chi-tiet-sp') {
    ;(function ($) {
        'use strict';

        let maxfile = 10;
        let myDropzone = '';
        Dropzone.autoDiscover = false;
        $(document).ready(function () {
            // let limitFile = 10;
            $('#dZUpload').dropzone({
                url: URL_ROOT + "sanpham/uploadImage?id_sanpham=" + $("#danhgia_id_sanpham").val(),
                maxFiles: maxfile,
                thumbnailWidth: 100,
                thumbnailHeight: 100,
                addRemoveLinks: true,
                dictRemoveFile: "x",
                acceptedFiles: ".png, .jpg, .jpeg",
                maxFilesize: 5, //MB
                success: function (file, response) {
                    var kq = JSON.parse(response);
                    if (kq.status == 1) {
                        file.previewElement.querySelector("[data-dz-name]").innerHTML = kq.tenhinh;
                        file.previewElement.querySelector("[data-dz-thumbnail]").src = kq.url;
                        var html = '<input class="hidden" value="' + kq.id_hinh + '" data-img-id><input class="hidden" value="' + kq.tenhinh + '" name="hinhtmp[]">' + "<div class='divAva' title='Chọn làm hình đại diện'><input type='checkbox' name='hinhdaidien' value='" + kq.tenhinh + "' class='avatar'></div>";
                        file.previewElement.querySelector(".dz-filename").innerHTML = html + file.previewElement.querySelector(".dz-filename").innerHTML;
                    } else {
                        Swal.fire({
                            title: 'Error',
                            buttonsStyling: false,
                            text: res.message,
                            icon: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#DD6B55',
                            confirmButtonText: '',
                            closeOnConfirm: true
                        });
                    }
                },
                removedfile: function (file) {
                    let tenhinh = file.previewElement.querySelector("[data-dz-name]").innerHTML;
                    $.post(URL_ROOT + "sanpham/deleteImage", {
                        'tenhinh': tenhinh
                    }, function (o) {
                        if (o.status == 1)
                            $(document).find(file.previewElement).remove();
                        maxfile--;
                    }, 'JSON');
                },
                init: function () {
                    myDropzone = this;
                },
                maxfilesexceeded: function (file) {
                    Swal.fire({
                        title: 'Error',
                        buttonsStyling: false,
                        text: 'Upload tối đa 10 file',
                        icon: 'error',
                        showConfirmButton: false,
                        showCancelButton: true,
                        cancelButtonText: 'Close',
                        customClass: {
                            cancelButton: 'btn btn-danger btn-no_effect'
                        }
                    });
                    $(document).find(file.previewElement).remove();
                }
            });

            $(".num-rating").click(function () {
                let elm = $(this);
                let val = elm.val();
                if (elm.is(":checked")) {
                    for (let i = 1; i <= val; i++) {
                        $("#danhgia_rating" + i).prop("checked", true);
                    }
                } else {
                    for (let i = val; i <= 5; i++) {
                        $("#danhgia_rating" + i).prop("checked", false);
                    }
                }
            });

            let i = 0;
            $("#formRating").submit(function (event) {
                i++
                let elm = $(this),
                    btnSub = $("#btnSub"),
                    btnSubHTML = btnSub.html();
                if (!elm[0].checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                    elm.addClass('was-validated');
                    btnlinkthanhcong(btnSub, btnSubHTML);
                } else {
                    btnlinkload(btnSub);
                    let data = elm.serializeArray();
                    data[data.length] = {"name": 'danhgia_rating', "value": $("#formRating .num-rating:checked").val()};
                    $.post(URL_ROOT + 'sanpham/submitDanhGia', data, function (res) {
                        if (res.status == 1) {
                            elm[0].reset();
                            $(".dz-complete").remove();
                            Swal.fire({
                                title: '',
                                text: res.message,
                                icon: 'success',
                                buttonsStyling: false,
                                showCancelButton: false,
                                confirmButtonText: 'OK',
                                closeOnConfirm: true,
                                customClass: {
                                    confirmButton: 'btn btn-success'
                                }
                            });
                            let {
                                danhgia_tieude,
                                danhgia_hoten,
                                danhgia_ratingText,
                                danhgia_noidung,
                                danhgia_images,
                                danhgia_time
                            } = res.data;

                            let renderWrapperImage = '';
                            if (danhgia_images != null && danhgia_images.length > 0) {
                                danhgia_images = JSON.parse(danhgia_images);
                                myDropzone.removeAllFiles(true);
                                let renderImage = '';
                                danhgia_images.map(function (elm, index) {
                                    let style = '';
                                    let spanHTML = '';
                                    if (index >= 5) {
                                        style = 'style="display: none"';
                                    }
                                    if (index == 4 && danhgia_images.length > 5) {
                                        spanHTML = `<span>${danhgia_images.length - 5}+</span>`;
                                    }
                                    renderImage += `<div class="image" ${style}>
                                            <a href="${URL_ROOT + elm}"
                                               data-fancybox="item-content_images-temp_${i}">
                                                <img src="${URL_ROOT + elm}">
                                                ${spanHTML}
                                            </a>
                                        </div>`;
                                });
                                renderWrapperImage = `<div class="item-content_images">${renderImage}</div>`;
                            }
                            let htmlRender = `<div class="comment-item">
										<div class="comment-item_inner">
											<div class="item-user">
												<div class="item-user_avatar">
													<img src="${PATHTHEME + 'user-comment.png'}">
												</div>
												<div class="item-user_info">
													<div class="item-user_name">${danhgia_hoten}</div>
													<div class="item-user_time">${danhgia_time}</div>
												</div>
											</div>
											<div class="item-content">
												<div class="item-content_title">
													${danhgia_tieude}
												</div>
                                                <div class="item-content_desc">
                                                    ${danhgia_noidung}
                                                </div>
												${renderWrapperImage}
											</div>
											<div class="item-rating">
												<div class="item-rating_value">
													<b>${danhgia_ratingText.text1}</b>
													${danhgia_ratingText.text2}
												</div>
											</div>
										</div>
									</div>`;

                            if (parseInt(res.phantrang.totalRecord) > 5) {
                                let phantrang = phantrangajax(res.phantrang.totalpage, res.phantrang.currentpage);
                                $('#comment-pagination #ul_pagination').html(phantrang);
                                $('#comment-pagination #ul_pagination .page-item[data-page=1]').trigger('click');
                                $('#cardRenderAjax .comment-list_item').prepend(htmlRender);
                                $('#comment-sort').fadeIn();
                                $('#comment-pagination').fadeIn();
                            } else {
                                $('#cardRenderAjax .comment-list_item').prepend(htmlRender);
                                $('#comment-sort').fadeIn();
                            }

                            $('#progress-value').html(res.rate.dtb.value + '/10');
                            $('#progress-text').html(res.rate.dtb.text);
                            $('#progress-total').html(res.rate.dtb.total);
                            $('#progress-percent').css('--value', res.rate.dtb.value * 10);

                            Object.values(res.rate.detail).forEach(function (elm, index) {
                                $(`.timeline-item[data-key=${elm.num}] .timeline-item_count`).html('(' + ((elm.star < 10) ? '0' : '') + elm.star + ')');
                                $(`.timeline-item[data-key=${elm.num}] .timeline-item_bg`).css('--value', elm.percent + '%');
                            });

                            if (res.rate.image.length > 0) {
                                let imagesGridItem = '';
                                res.rate.image.map(function (elm, index) {
                                    let imagesGridItemStyle = '';
                                    let imagesGridItemSpanHTML = '';
                                    if (index >= 8) {
                                        imagesGridItemStyle = 'style="display: none"';
                                    }
                                    if (index == 7 && res.rate.image.length > 8) {
                                        imagesGridItemSpanHTML = `<span>${res.rate.image.length - 5}+</span>`;
                                    }
                                    imagesGridItem += `<div class="images-grid_item" ${imagesGridItemStyle}>
															<a href="${elm}"
															   data-fancybox="comment-images">
																<img src="${elm}">
																${imagesGridItemSpanHTML}
															</a>
														</div>`;
                                });
                                $('#comment-overview_images .images-grid').html(imagesGridItem);
                                $('#comment-overview_images').fadeIn();
                            }
                        } else {
                            Swal.fire({
                                title: 'Error',
                                buttonsStyling: false,
                                text: res.message,
                                icon: 'error',
                                showConfirmButton: false,
                                showCancelButton: true,
                                cancelButtonText: 'Thử lại!',
                                customClass: {
                                    cancelButton: 'btn btn-danger btn-no_effect'
                                }
                            });
                        }
                        btnlinkthanhcong(btnSub, 'Gửi đánh giá');
                    }, "JSON").fail(function () {
                        btnlinkthanhcong(btnSub, 'Gửi đánh giá');
                        Swal.fire({
                            title: 'Error',
                            buttonsStyling: false,
                            text: 'Error',
                            icon: 'error',
                            showConfirmButton: false,
                            showCancelButton: true,
                            cancelButtonText: 'Close',
                            customClass: {
                                cancelButton: 'btn btn-danger btn-no_effect'
                            }
                        });
                    });
                    return false;
                }
            });

            $("#resetFilter").click(function () {
                $("#cardFilterRating .filterRating").prop("checked", false);
                filterRating();
            });

            function filterRating() {
                let dataPost = {};
                dataPost.danhgia_id_sanpham = danhgia_id_sanpham;
                if ($("#cardFilterRating .filterRating:checked").length > 0) {
                    let arrRating = [];
                    $("#cardFilterRating .filterRating:checked").each(function (idx, item) {
                        arrRating.push($(item).val());
                    });
                    dataPost.danhgia_rating = arrRating;
                }

                if ($(".orderAjax.active").length > 0) {
                    dataPost.sort = $(".orderAjax.active").attr("data-type");
                }

                if ($("#ul_pagination .page-item.pageactive").attr("data-page") > 0) {
                    dataPost.page = $("#ul_pagination .page-item.pageactive").attr("data-page");
                }
                $.post(URL_ROOT + 'sanpham/filterAjaxDanhGia', dataPost, function (res) {
                    if (res.status == 1) {
                        $("#cardRenderAjax").html(res.html);
                    } else {
                        $("#cardRenderAjax").html(`<div class="product-empty">
								<div class="product-empty_icon">
									<img src="${PATHTHEME}no-product.svg" alt="">
								</div>
								<div class="product-empty_title">
									Không tìm thấy đánh giá phù hợp
								</div>
							</div>`);
                    }
                }, "JSON").fail(function () {
                    Swal.fire({
                        title: 'Error',
                        buttonsStyling: false,
                        text: 'Error',
                        icon: 'error',
                        showConfirmButton: false,
                        showCancelButton: true,
                        cancelButtonText: 'Close',
                        customClass: {
                            cancelButton: 'btn btn-danger btn-no_effect'
                        }
                    });
                });
            }

            $("#cardFilterRating .filterRating").click(function () {
                filterRating();
            });


            $(".orderAjax").click(function () {
                let elm = $(this);
                $(".orderAjax").removeClass("active");
                elm.addClass("active");
                filterRating();
            });

            $("#cardRenderAjax").on("click", "#ul_pagination .page-item", function () {
                let elm = $(this);
                $("#ul_pagination .page-item").removeClass("pageactive");
                elm.addClass("pageactive");
                filterRating();
            });

            $("#danhgia_sdt").keyup(function () {
                let val = $(this).val();
                val = val.replace(/([^0-9])/g, '');
                $(this).val(val);
            });
        });
    })(jQuery);
}