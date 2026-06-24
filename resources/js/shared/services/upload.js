// resources/js/shared/services/upload.js

export function filePondServerConfig(options = {}) {
    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        ?.getAttribute('content');

    return {
        process: {
            url: options.processUrl || '',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
            }
        },

        revert: {
            url: options.revertUrl || '',
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
            },
        },

        patch: {
            url: options.patchUrl || '',
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