$(document).ready(function () {
    $(".btn-edit-ask").click(function () {
        const href = $(this).data("href");

        $.ajax({
            url: href,
            success: function (response) {
                $("#content-form-edit-question").html(response.html);
            },
            error: function (error) {
                console.log(error);
            },
        });
    });

    $(".input-question").on("input", function () {
        let isValid = true;
        const minleght = $(this).attr("minlength");
        const input = $(this);
        const erroMsg = $($(this).data("error"));
        erroMsg.removeClass("hidden");

        if ($(this).val().length < minleght) {
            $(this).addClass("is-invalid");
            erroMsg.text(
                "La pregunta debe tener al menos " +
                    minleght +
                    " caracteres. Te faltan " +
                    (minleght - $(this).val().length)
            );
            input.addClass("is-invalid");
            isValid = false;
        } else {
            erroMsg.addClass("hidden");
            input.removeClass("is-invalid");
        }
    });

    $(".btn-change-status").click(function () {
        const url = $(this).data("action");
        const status = $(this).data("value");

        $.ajax({
            url: url,
            data: {
                status: status,
            },
            success: function (response) {
                location.reload();
            },
            error: function (error) {
                console.log(error);
            },
        });
    });
});
