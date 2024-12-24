$(document).ready(function () {
    const $alert = $(".alert");

    $(".alert-close").click(function () {
        $alert.hide();
    });

    $(document).on("click", ".buttonDelete", function () {
        $(".deleteModal").removeClass("hidden").addClass("flex");
        let formId = $(this).data("form");
        $(".deleteModal .confirmDelete").attr("data-form", formId);
        $("body").addClass("overflow-hidden");
    });

    $(document).on("click", ".closeModal", function () {
        $(".deleteModal").removeClass("flex").addClass("hidden");
        $("body").removeClass("overflow-hidden");
    });

    $(document).on("click", ".confirmDelete", function () {
        let formId = $(this).data("form");
        $("#" + formId).submit();
        $("body").removeClass("overflow-hidden");
    });

    $(document).on("click", "#profile-btn", function () {
        $("#profile-dropdown").toggleClass("hidden");
    });

    $(document).on("click", function (e) {
        if (!$(e.target).closest("#profile-btn").length) {
            $("#profile-dropdown").addClass("hidden");
        }
    });

    $(document).on("click", ".toggle-password", function () {
        const input = $(this).prev();
        const eye = $(this).find("#eye-icon");
        const eyeClosed = $(this).find("#eye-closed-icon");

        if (input.attr("type") === "password") {
            input.attr("type", "text");
            eye.addClass("hidden");
            eyeClosed.removeClass("hidden");
        } else {
            input.attr("type", "password");
            eye.removeClass("hidden");
            eyeClosed.addClass("hidden");
        }
    });
});
