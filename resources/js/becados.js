$(document).ready(function () {
    const previewImage = (input, img) => {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                $(img).attr("src", e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    };

    $("#photo").change(function () {
        previewImage(this, "#preview-image");
    });
});
