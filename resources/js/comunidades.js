$(document).ready(function () {
    $(".editCommunity").click(function () {
        const url = $(this).data("url");
        const form = $(this).data("form");
        $.ajax({
            url: url,
            type: "GET",
            success: function (response) {
                $("#formEditCommunity").attr("action", form);
                $("#name").val(response.name);
            },
        });
    });
});
