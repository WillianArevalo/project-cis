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
        const minleght = $(this).attr("minleght");
        const input = $(this);
        const container = $(input.data("container"));
        container.removeClass("hidden").addClass("flex");
        const erroMsg = input.closest("div").next().find(".error-msg");

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
        }
    });
});
