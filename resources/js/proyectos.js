$(document).ready(function () {
    $(".btnEditProject").on("click", function () {
        const url = $(this).data("url");
        const action = $(this).data("action");
        $.ajax({
            url,
            success: function (response) {
                $("#form-edit-project").html(response.html);
            },
        });
    });

    $(".assign-button").click(function () {
        const scholarItem = $(this).closest(".scholar-item");
        scholarItem.fadeOut(300, function () {
            scholarItem.find(".assign-button").addClass("hidden");
            scholarItem.find(".unassign-button").removeClass("hidden");
            $("#assigned-scholars").append(scholarItem);
            scholarItem.fadeIn(300);
            $("#assigned-scholars .no-assigned").remove();
        });
        $("#search").val("");
        $("#scholar-list .scholar-item").show();
    });

    $(".unassign-button").click(function () {
        const scholarItem = $(this).closest(".scholar-item");
        scholarItem.fadeOut(300, function () {
            scholarItem.find(".unassign-button").addClass("hidden");
            scholarItem.find(".assign-button").removeClass("hidden");

            $("#scholar-list").append(scholarItem);
            scholarItem.fadeIn(300);
            if (
                $("#assigned-scholars").children(".scholar-item").length === 0
            ) {
                $("#assigned-scholars").append(`
                <div class="flex h-32 items-center justify-center no-assigned">
                    <p class="text-sm dark:text-zinc-200">
                        No hay becados asignados
                    </p>
                </div>
            `);
            }
        });
    });

    $("#search").on("keyup", function () {
        const value = $(this).val().toLowerCase();
        $("#scholar-list .scholar-item").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });

    $("#assign-button").on("click", function () {
        const ids = [];
        $("#scholarship-inputs").empty();
        $("#assigned-scholars .scholar-item").each(function () {
            const scholarId = $(this).data("id");
            if (scholarId) {
                ids.push(scholarId);
                $("#scholarship-inputs").append(`
                <input type="hidden" name="scholarship_id[]" value="${scholarId}">
            `);
            }
        });
        $("#assign-form").submit();
    });

    /*   // Projects
    const $file = $("#input-schedule");
    const $fileName = $("#file-name-schedule");
    const $btnRemoveFile = $("#remove-file-schedule");

    $file.on("change", function () {
        const file = this.files[0];
        const reader = new FileReader();
        $fileName.text(file.name);

        if (file.size > 1000000) {
            showToast("El archivo no puede ser mayor a 1MB", "error");
            $file.val("");
            $fileName.text("Seleccionar archivo");
        }

        $btnRemoveFile.removeClass("hidden");

        $btnRemoveFile.on("click", function () {
            $file.val("");
            $fileName.text("Formatos permitidos: .pdf, .docx");
            $btnRemoveFile.addClass("hidden");
        });
    }); */
});
