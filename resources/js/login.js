$(document).ready(function () {
    let user = $("#user");
    let password = $("#password");

    $("#user, #password").on("input", function () {
        if (user.val() != "") {
            user.removeClass("is-invalid");
            user.next().css("display", "none");
        }
        if (password.val() != "") {
            password.removeClass("is-invalid");
            password.next().css("display", "none");
        }
    });
});
