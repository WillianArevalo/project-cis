$(document).ready(function () {
    const newPassword = $("#new-password");
    const confirmPassword = $("#confirm-password");

    $(confirmPassword).on("input", function () {
        const container = $(confirmPassword.data("container"));
        container.removeClass("hidden").addClass("flex");
        if ($(newPassword).val() !== $(confirmPassword).val()) {
            $(confirmPassword).addClass("is-invalid");
            container.find(".error-msg").text("Las contraseñas no coinciden");
        } else {
            $(confirmPassword).removeClass("is-invalid");
            container.removeClass("flex").addClass("hidden");
        }
    });
});
