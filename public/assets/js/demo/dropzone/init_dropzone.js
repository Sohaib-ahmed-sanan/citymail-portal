
let initializeDropzone = (elementSelector, inputSelector) => {
    var element = $(elementSelector),
        previewContainer = $(".dz-preview");
        element.length && (Dropzone.autoDiscover = !1, element.each((function () {
        var currentElement, isMultiple, previewElement, previousFile, dropzoneConfig;
        currentElement = $(this), isMultiple = void 0 !== currentElement.data("dropzone-multiple"), previewElement = currentElement.find(previewContainer), previousFile = void 0, dropzoneConfig = {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            url: currentElement.data("dropzone-url"),
            thumbnailWidth: null,
            thumbnailHeight: null,
            previewsContainer: previewElement.get(0),
            previewTemplate: previewElement.html(),
            maxFiles: isMultiple ? null : 1,
            acceptedFiles: isMultiple ? null : ".jpg, .jpeg, .png, .svg, .ico",
            success: function (file, result) {
                if (result.status == 1) {
                    currentElement.find("#pr_image_db").css("display", "none");
                    $(inputSelector).val(result.message);
                } else {
                    $(".dz-preview .dz-preview-img").attr({ 'src': "", 'alt': "" });
                    Notification('danger', 'Error', `${result.message}`);
                }
            },
            init: function () {
                this.on("addedfile", (function (file) {
                    !isMultiple && previousFile && this.removeFile(previousFile), previousFile = file
                }))
            }
        };
        previewElement.html(""), currentElement.dropzone(dropzoneConfig);
    })))
}

// initializeDropzone('[data-toggle="dropzone-cnic"]', '#cnic_image_hidden');
// initializeDropzone('[data-toggle="dropzone-ntn"]', '#ntn_image_hidden');
// initializeDropzone('[data-toggle="dropzone-logo"]', '#logo_image');

initializeDropzone('[data-toggle="dropzone-image-1"]', '#image_1');
initializeDropzone('[data-toggle="dropzone-image-2"]', '#image_2');
initializeDropzone('[data-toggle="dropzone-image-3"]', '#image_3');
