import * as FilePond from 'filepond';
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
import FilePondPluginFileValidateSize from 'filepond-plugin-file-validate-size';
import FilePondPluginImagePreview from 'filepond-plugin-image-preview';

import 'filepond/dist/filepond.min.css';
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css';

FilePond.registerPlugin(
    FilePondPluginFileValidateType,
    FilePondPluginFileValidateSize,
    FilePondPluginImagePreview
);

export function initFilePond(selector, options = {}) {
    const input = document.querySelector(selector);

    if (!input) {
        console.error('FilePond: Selector ' + selector + ' not found.');
        return null;
    }

    return FilePond.create(input, {
        allowMultiple: false,
        allowReorder: false,
        allowProcess: true,

        credits: false,

        chunkUploads: true,
        chunkForce: true,
        chunkSize: 5 * 1024 * 1024,
        chunkRetryDelays: [500, 1000, 3000],
        chunkParallelUploads: 1,
        maxFileSize: '500MB',

        ...options,
    });
}
