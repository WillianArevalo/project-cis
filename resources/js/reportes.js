import { showToast } from "./toast";

$(document).ready(function () {
    let imageIndex = 0;
    const $containerPreview = $("#container-preview-images");
    const $previewImages = $("#preview-images");
    const images = [];

    $("#input-images").on("change", function (e) {
        $containerPreview.removeClass("hidden");
        const files = e.target.files;
        Array.from(files).forEach((file) => {
            if (file && file.type.startsWith("image/")) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    imageIndex++;
                    const imgSrc = e.target.result;
                    images.push(file);
                    const imgPreview = `
                        <div class="relative  rounded-xl w-max" id="image-${imageIndex}">
                            <img src="${imgSrc}" alt="Imagen seleccionada" class="w-full h-40 object-cover rounded-xl">
                            <button type="button" data-id="image-${imageIndex}" class="absolute top-1 w-6 h-6 right-1 bg-red-600 text-white rounded-lg p-1 delete-image">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4 text-white" viewBox="0 0 24 24" width="24" height="24" color="#000000" fill="none">
                                    <path d="M19.0005 4.99988L5.00049 18.9999M5.00049 4.99988L19.0005 18.9999" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </button>
                        </div>`;

                    $previewImages.append(imgPreview);
                };
                reader.readAsDataURL(file);
            }
        });
        $previewImages.find("p").remove();
        $previewImages.removeClass("h-32 justify-center").addClass("h-auto");
    });

    $(document).on("click", ".delete-image", function () {
        const imageId = $(this).data("id");
        const $imageElement = $(`#${imageId}`);
        const imageIndex = $imageElement.index();
        images.splice(imageIndex, 1);
        $imageElement.remove();
        if ($previewImages.children().length === 0) {
            $containerPreview.addClass("hidden");
        }
    });

    $("#btn-add-report").on("click", function (event) {
        const $form = $("#form-report");
        const formData = new FormData($form[0]);

        if (images.length === 0) {
            $("#container-file").addClass("is-invalid");
            $("#container-error-file").removeClass("hidden").addClass("flex");
        } else {
            $("#container-file").removeClass("is-invalid");
        }

        images.forEach((image) => {
            formData.append("images[]", image);
        });

        const isValid = validateForm("#form-report");
        console.log(isValid);
        if (
            isValid ||
            images.length !== 0 ||
            $("#description").val().length > 90
        ) {
            $.ajax({
                url: $form.attr("action"),
                method: $form.attr("method"),
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    showToast(
                        "success",
                        response.message,
                        "Reporte creado correctamente"
                    );
                    setTimeout(() => {
                        window.location.href = response.redirect;
                    }, 3000);
                },
                error: function (error) {
                    console.log(error);
                },
            });
        }
    });

    $("#description").on("input", function () {
        const maxLength = 90;
        const currentLength = $(this).val().length;

        if (currentLength < maxLength) {
            const input = $(this);
            const container = $(input.data("container"));
            container.removeClass("hidden").addClass("flex");
            const erroMsg = input.closest("div").next().find(".error-msg");
            erroMsg.text(`${maxLength - currentLength} caracteres restantes`);
        } else {
            const input = $(this);
            const container = $(input.data("container"));
            container.removeClass("flex").addClass("hidden");
        }
    });

    function validateForm(formId) {
        let isValid = true;
        $(formId)
            .find("input[required], textarea[required]")
            .each(function () {
                const input = $(this);
                const container = $(input.data("container"));
                container.removeClass("hidden").addClass("flex");
                const erroMsg = input.closest("div").next().find(".error-msg");

                if (!input.val().trim()) {
                    erroMsg.text("El campo es requerido");
                    input.addClass("is-invalid");
                    isValid = false;
                } else {
                    erroMsg.hide();
                    input.removeClass("is-invalid");
                    container.removeClass("flex").addClass("hidden");
                }
            });
        return isValid;
    }
});
