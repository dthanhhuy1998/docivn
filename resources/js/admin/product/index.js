import { initFilePond } from '@/shared/components/filepond';
import { filePondServerConfig } from '@/shared/services/upload';

class ProductIndexPage {
    constructor() {
        this.appUrl = window.APP_CONFIG?.url || '';
        this.token = $('meta[name="csrf-token"]').attr('content');
        this.incompleteMessage = 'Có vẻ như bạn điền chưa đầy đủ thông tin. Hãy kiểm tra lại nhé!';

        this.init();
    }

    init() {
        this.initFormEvents();
        this.initFilePond();
        this.initProductVideoEvents();
    }

    initFormEvents() {
        $('.select2').select2();

        $('.textarea').wysihtml5();

        var ckeditorOptions = {
            filebrowserImageBrowseUrl: this.appUrl + '/admin/laravel-filemanager?type=Images',
            filebrowserImageUploadUrl: this.appUrl + '/admin/laravel-filemanager/upload?type=Images&_token=' + this.token,
            filebrowserBrowseUrl: this.appUrl + '/admin/laravel-filemanager?type=Files',
            filebrowserUploadUrl: this.appUrl + '/admin/laravel-filemanager/upload?type=Files&_token=' + this.token
        };

        ['editor1', 'editor2'].forEach((editorId) => {
            if (document.getElementById(editorId) && !CKEDITOR.instances[editorId]) {
                CKEDITOR.replace(editorId, ckeditorOptions);
            }
        });

        $('.js-product-form').on('submit', (event) => this.handleSubmit(event));
    }

    initFilePond() {
        initFilePond('#upload-video', {
            allowMultiple: true,
            acceptedFileTypes: ['video/mp4', 'video/quicktime'],
            maxFileSize: '2000MB',

            chunkUploads: true,
            chunkSize: 5 * 1024 * 1024,
            chunkForce: true,

            server: filePondServerConfig({
                processUrl: '/admin/uploads/filepond',
                patchUrl: '/admin/uploads/filepond',
                revertUrl: '/admin/uploads/filepond',
            }),
        });

        initFilePond('#upload-video-thumbnail', {
            allowMultiple: true,
            acceptedFileTypes: ['image/jpeg', 'image/png', 'image/webp'],
            maxFileSize: '10MB',
            allowImagePreview: true,
            imagePreviewHeight: 120,

            chunkUploads: true,
            chunkSize: 1024 * 1024,
            chunkForce: true,

            server: filePondServerConfig({
                processUrl: '/admin/uploads/filepond',
                patchUrl: '/admin/uploads/filepond',
                revertUrl: '/admin/uploads/filepond',
            }),
        });
    }

    initProductVideoEvents() {
        $(document).on('click', '.js-delete-product-video', (event) => this.confirmDeleteProductVideo(event));
    }

    confirmDeleteProductVideo(event) {
        event.preventDefault();

        const $button = $(event.currentTarget);

        Swal.fire({
            title: 'Xóa video sản phẩm?',
            text: 'Video sẽ bị xóa khỏi sản phẩm này.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Xóa',
            cancelButtonText: 'Hủy',
            confirmButtonColor: '#dd4b39',
            cancelButtonColor: '#777',
        }).then((result) => {
            if (!result.isConfirmed) {
                return;
            }

            this.deleteProductVideo($button);
        });
    }

    deleteProductVideo($button) {
        $button.prop('disabled', true);

        $.ajax({
            url: $button.data('delete-url'),
            method: 'DELETE',
            dataType: 'json',
            headers: {
                Accept: 'application/json',
                'X-CSRF-TOKEN': this.token,
            },
        })
        .done((response) => {
            this.showToast(response.message || 'Đã xóa video sản phẩm thành công', 'success');
            this.reloadProductVideoList();
        })
        .fail(() => {
            this.showToast('Không thể xóa video lúc này. Vui lòng thử lại.', 'error');
            $button.prop('disabled', false);
        });
    }

    reloadProductVideoList() {
        const $wrapper = $('.product-video-list-wrapper');
        const listUrl = $wrapper.data('product-video-list-url');

        if (!$wrapper.length || !listUrl) {
            return;
        }

        $wrapper.load(listUrl);
    }

    handleSubmit(event) {
        event.preventDefault();

        const form = event.currentTarget;
        const $form = $(form);
        const $submitButton = $form.find('[type="submit"]');

        this.syncEditors();
        this.clearErrors($form);

        if (!this.validateVideoUploads($form)) {
            return;
        }

        this.setSubmitting($submitButton, true);

        $.ajax({
            url: $form.attr('action'),
            method: $form.attr('method') || 'POST',
            data: new FormData(form),
            processData: false,
            contentType: false,
            dataType: 'json',
            headers: {
                Accept: 'application/json',
                'X-CSRF-TOKEN': this.token,
            },
        })
        .done((response) => {
            if (response.redirect) {
                window.location.href = response.redirect;
                return;
            }

            this.showToast(response.message || 'Lưu sản phẩm thành công.', 'success');
        })
        .fail((xhr) => {
            if (xhr.status === 422 && xhr.responseJSON?.errors) {
                this.renderErrors($form, xhr.responseJSON.errors);
                this.showToast(this.incompleteMessage, 'error');
                this.focusFirstError($form);
                return;
            }

            this.showToast('Không thể lưu sản phẩm lúc này. Vui lòng thử lại.', 'error');
        })
        .always(() => {
            this.setSubmitting($submitButton, false);
        });
    }

    validateVideoUploads($form) {
        const videoCount = this.getFieldValues($form, 'videos[]').length;
        const thumbnailCount = this.getFieldValues($form, 'video_thumbnails[]').length;

        if (!videoCount && !thumbnailCount) {
            return true;
        }

        let isValid = true;

        if (!videoCount) {
            this.addManualFieldError($form, 'videos[]', 'Vui lòng chọn video sản phẩm!');
            isValid = false;
        }

        if (!thumbnailCount) {
            this.addManualFieldError($form, 'video_thumbnails[]', 'Vui lòng chọn ảnh thumbnail video!');
            isValid = false;
        }

        if (videoCount && thumbnailCount && videoCount !== thumbnailCount) {
            this.addManualFieldError($form, 'video_thumbnails[]', 'Mỗi video cần có một ảnh thumbnail tương ứng!');
            isValid = false;
        }

        if (!isValid) {
            this.showToast(this.incompleteMessage, 'error');
            this.openFieldTab($form.find('[name="videos[]"]').first());
        }

        return isValid;
    }

    getFieldValues($form, fieldName) {
        return $form.find('[name="' + fieldName + '"]')
            .map((index, field) => $(field).val())
            .get()
            .filter((value) => !!value);
    }

    addManualFieldError($form, fieldName, message) {
        const $field = $form.find('[name="' + fieldName + '"]').first();
        const $formGroup = $field.closest('.form-group');

        if (!$field.length || !$formGroup.length) {
            return;
        }

        $formGroup.addClass('has-error');
        this.appendFieldError($formGroup, $field, message);
    }

    syncEditors() {
        Object.keys(CKEDITOR.instances || {}).forEach((editorId) => {
            CKEDITOR.instances[editorId].updateElement();
        });
    }

    clearErrors($form) {
        $form.find('.form-group.has-error').removeClass('has-error');
        $form.find('.js-field-error').remove();
    }

    renderErrors($form, errors) {
        let firstErrorField = null;

        Object.keys(errors).forEach((field) => {
            const message = errors[field][0];
            const $field = this.findField($form, field);

            if (!$field.length) {
                return;
            }

            const $formGroup = $field.closest('.form-group');

            if (!$formGroup.length) {
                return;
            }

            $formGroup.addClass('has-error');
            this.appendFieldError($formGroup, $field, message);

            if (!firstErrorField) {
                firstErrorField = $field;
            }
        });

        if (firstErrorField) {
            this.openFieldTab(firstErrorField);
        }
    }

    findField($form, field) {
        const normalizedName = field.replace(/\.\d+/g, '[]');
        const candidates = [
            field,
            normalizedName,
            normalizedName.replace(/\.$/, ''),
            normalizedName.includes('[]') ? normalizedName : normalizedName + '[]',
        ];

        for (const name of candidates) {
            const $field = $form.find('[name="' + name + '"]');

            if ($field.length) {
                return $field.first();
            }
        }

        return $();
    }

    appendFieldError($formGroup, $field, message) {
        const $error = $('<span/>', {
            class: 'help-block js-field-error',
            text: message,
        });

        const $select2 = $field.next('.select2-container');

        if ($select2.length) {
            $select2.after($error);
            return;
        }

        const $filePond = $formGroup.find('.filepond--root').last();

        if ($filePond.length) {
            $filePond.after($error);
            return;
        }

        $field.after($error);
    }

    openFieldTab($field) {
        const $tabPane = $field.closest('.tab-pane');

        if (!$tabPane.length) {
            return;
        }

        $('a[href="#' + $tabPane.attr('id') + '"]').tab('show');
    }

    focusFirstError($form) {
        const $firstError = $form.find('.form-group.has-error :input:visible').first();

        if ($firstError.length) {
            $firstError.focus();
        }
    }

    setSubmitting($button, isSubmitting) {
        $button.prop('disabled', isSubmitting);
    }

    showToast(message, type = 'error') {
        Swal.mixin({
            toast: true,
            position: 'top-end',
            customClass: {
                popup: 'admin-toast',
                icon: 'admin-toast__icon',
                title: 'admin-toast__title',
            },
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
        }).fire({
            icon: type,
            title: message,
        });
    }
}

$(function () {
    new ProductIndexPage();
});
