$(document).ready(function () {
    var select = $(".selected");
    var items = $(".selectOptions .itemOption");

    $(select).each(function () {
        $(this).on("click", function () {
            const svg = $(this).find("svg");
            closeSelects(this, svg);

            if (svg.hasClass("is-rotated")) {
                svg.removeClass("is-rotated").addClass("not-rotated");
            } else {
                svg.removeClass("not-rotated").addClass("is-rotated");
            }

            var selectedItems = $(this).next();

            if (selectedItems) {
                selectedItems.toggleClass("hidden");
                $(this).toggleClass("active");
                //adjustDropdownPosition(selectedItems, $(this));
            }
        });
    });

    $(items).each(function () {
        $(this).on("click", function () {
            let item = $(this).html();
            let value = $(this).data("value");
            let input = $(this).data("input");
            $(this)
                .closest(".selectOptions")
                .prev(".selected")
                .find(".itemSelected")
                .html(item);
            $(input).val(value).trigger("Changed");
            $(this).parent().addClass("hidden");
            $(".arrow-down-select")
                .removeClass("is-rotated")
                .addClass("not-rotated");
        });
    });

    function closeSelects(thisSelect, svg) {
        $(".selectOptions").not($(thisSelect).next()).addClass("hidden");
        $(".arrow-down-select")
            .not(svg)
            .removeClass("is-rotated")
            .addClass("not-rotated");
    }

    function adjustDropdownPosition(dropdown, select) {
        const rect = select[0].getBoundingClientRect();
        const dropdownHeight = dropdown[0].scrollHeight;
        const viewportHeight = window.innerHeight;

        // Añade un margen inferior para asegurar que no quede pegado al borde inferior
        const marginBottom = 16; // Puedes ajustar este valor según sea necesario

        if (rect.bottom + dropdownHeight + marginBottom > viewportHeight) {
            dropdown.css({
                top: "auto",
                bottom: "100%",
                "margin-bottom": marginBottom + "px",
            });
        } else {
            dropdown.css({
                top: "100%",
                bottom: "auto",
                "margin-bottom": "0px",
            });
        }
    }

    $(document).on("click", function (e) {
        if (!$(e.target).closest(".selected").length) {
            $(".selectOptions").addClass("hidden");
            $(".selected").removeClass("active");
            $(".arrow-down-select")
                .removeClass("is-rotated")
                .addClass("not-rotated");
        }
    });
});
