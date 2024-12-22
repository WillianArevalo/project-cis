$(document).ready(function () {
    FilePond.registerPlugin(FilePondPluginImagePreview);
    FilePond.registerPlugin(FilePondPluginImageValidateSize);
    FilePond.registerPlugin(FilePondPluginFileValidateSize);
    const imageReport = document.querySelector('input[id="image-report"]');
    const pond = FilePond.create(imageReport, {
        labelIdle:
            "Arrastra y suelta tus archivos o <span class='filepond--label-action'> Examinar </span>",
        imagePreviewHeight: 250,
        imagePreviewWidth: 250,
        allowImagePreview: true,
        allowMultiple: true,
        maxFiles: 10,
        minFiles: 5,
        maxFileSize: "1MB",
        minFileSize: "1KB",
        labelMaxFileSizeExceeded: "El archivo es demasiado grande",
        labelMaxFileSize: "El tamaño máximo del archivo es {filesize}",
    });
});
