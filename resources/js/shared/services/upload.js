// resources/js/shared/services/upload.js

export function filePondServerConfig(options = {}) {
    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        ?.getAttribute('content');
    const baseUrl = (options.baseUrl || options.processUrl || '').replace(/\/+$/, '');

    return {
        url: baseUrl,

        process: {
            url: '',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
            }
        },

        revert: {
            url: '',
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
            },
        },

        patch: {
            url: '/',
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
            },
        },

        headers: {
            'X-CSRF-TOKEN': csrfToken,
        },
    };
}
