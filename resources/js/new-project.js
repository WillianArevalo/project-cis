import { showToast } from "./toast";

$(document).ready(function () {
    //Specific Objectives
    let objectives = [];
    const $specificObjective = $("#specific-objective");
    const $list = $("#list-specific-objetives");
    const $listInputs = $("#list-specific-objetives-inputs");

    $("#add-objective").on("click", function () {
        const value = $specificObjective.val();
        if (value !== "") {
            $("#no-objectives").addClass("hidden");
            $specificObjective.removeClass("is-invalid");
            if (!objectives.includes(value)) {
                objectives.push(value);
                const $li = $("<li>")
                    .text(value)
                    .addClass(
                        "text-zinc-600 dark:text-zinc-200 text-sm list-disc  flex jusitfy-between w-full"
                    );
                const $btnRemove = `
                <button class="btn-remove-objective ml-auto" data-value="${value}" type="button">
                    <svg class="size-4 text-red-500"  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-x"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18 6l-12 12" /><path d="M6 6l12 12" /></svg>
                </button>`;
                $li.append($btnRemove);
                $list.append($li);
                $specificObjective.val("");
                $listInputs.append(
                    `<input type="hidden" name="specific_objectives[]" value="${value}">`
                );
            } else {
                showToast(
                    "info",
                    "Objetivo ya agregado",
                    "El objetivo ya ha sido agregado"
                );
            }
        } else {
            $specificObjective.focus();
            $specificObjective.addClass("is-invalid");
            showToast(
                "info",
                "Ingresa un valor",
                "Debes ingresar un objetivo específico"
            );
        }
    });

    $(document).on("click", ".btn-remove-objective", function () {
        const value = $(this).data("value");
        objectives = objectives.filter((objective) => objective !== value);
        $(`input[value="${value}"]`).remove();
        $(this).parent().remove();
        if (objectives.length === 0) {
            $("#no-objectives").removeClass("hidden");
        }
    });

    if ($("#map").length) {
        const map = L.map("map");

        L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
            maxZoom: 19,
        }).addTo(map);

        let marker;

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const { latitude, longitude } = position.coords;
                    map.setView([latitude, longitude], 18);

                    marker = L.marker([latitude, longitude])
                        .addTo(map)
                        .bindPopup("Tu ubicación")
                        .openPopup();
                },
                (error) => {
                    alert("No se pudo obtener tu ubicación");
                }
            );
        } else {
            alert("Tu navegador no soporta geolocalización");
        }

        $("#capture-map").on("click", function () {
            $("#loader").removeClass("hidden");
            $("body").addClass("overflow-hidden");
            leafletImage(map, function (err, canvas) {
                $("#loader").addClass("hidden");
                $("body").removeClass("overflow-hidden");
                if (err) {
                    alert("Ocurrió un error al capturar el mapa");
                    console.error(err);
                    return;
                }

                if (marker) {
                    const { lat, lng } = marker.getLatLng();
                    const link = `https://www.openstreetmap.org/?mlat=${lat}&mlon=${lng}#map=18/${lat}/${lng}`;
                    $("#location").val(link);
                } else {
                    alert("Primero debes seleccionar una ubicación en el mapa");
                }

                const imgData = canvas.toDataURL("image/png");
                const bob = dataURItoBlob(imgData);
                const file = new File([bob], "mapa.png", { type: "image/png" });

                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                document.getElementById("map-image").files = dataTransfer.files;

                const preview = $("<img>")
                    .attr("src", imgData)
                    .addClass("img-fluid rounded-xl");
                $("#preview-container").removeClass("hidden");
                $("#preview-container").html(preview);

                $("#map").addClass("hidden");
                $("#capture-map-msg").removeClass("hidden");
                $("#capture-map").addClass("hidden");
                $("#remove-map").removeClass("hidden");
            });
        });

        $("#remove-map").on("click", function () {
            $("#map").removeClass("hidden");
            $("#capture-map-msg").addClass("hidden");
            $("#capture-map").removeClass("hidden");
            $("#remove-map").addClass("hidden");
            $("#preview-container").addClass("hidden");
            $("#location").val("");
        });

        function dataURItoBlob(dataURI) {
            const byteString = atob(dataURI.split(",")[1]);
            const mimeString = dataURI
                .split(",")[0]
                .split(":")[1]
                .split(";")[0];
            const ab = new ArrayBuffer(byteString.length);
            const ia = new Uint8Array(ab);
            for (let i = 0; i < byteString.length; i++) {
                ia[i] = byteString.charCodeAt(i);
            }
            return new Blob([ab], { type: mimeString });
        }
    }

    $(document).on("change", ".input-doc", function () {
        const $file = $(this);
        const file = $file[0].files[0];

        console.log($file.data("name"), $file.data("button-remove"));

        const $fileName = $($file.data("name"));
        const $btnRemoveFile = $($file.data("button-remove"));

        if (file) {
            $fileName.text(file.name);
            if (file.size > 1024 * 1024) {
                showToast(
                    "error",
                    "Archivo muy grande",
                    "El archivo no debe superar 1MB"
                );
                $file.val("");
                $fileName.text("Formatos permitidos: .jpg, .png, .jpeg, .webp");
                return;
            }
            $btnRemoveFile.removeClass("hidden");
        }
    });

    $(document).on("click", ".remove-file", function () {
        const $btnRemoveFile = $(this);
        const $file = $($btnRemoveFile.data("input"));
        const $fileName = $($file.data("name"));
        const accept = $file.attr("accept");

        $file.val("");
        $fileName.text("Formatos permitidos: " + accept);
        $btnRemoveFile.addClass("hidden");
    });

    let scholarships = [];
    const $listScholarships = $("#list-scholarships");
    $("#btnAssigned").on("click", function () {
        $("#no-scholarships").addClass("hidden");
        const htmlClone = $("#scholarship_id_selected").clone();
        const value = $("#scholarship_id").val();
        const html = `<div class="flex justify-between items-center w-full" data-id="${value}">
                        ${htmlClone.html()}
                        <button class="btn-remove-scholarship ml-2" type="button">
                            <svg class="size-4 text-red-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-x"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18 6l-12 12" /><path d="M6 6l12 12" /></svg>
                        </button>
                    </div>`;

        if (scholarships.includes(value)) {
            showToast("warning", "Oopss!", "Becado ya agregado");
            return;
        }
        scholarships.push(value);
        $listScholarships.append(html);
        console.log(scholarships);
    });

    $(document).on("click", ".btn-remove-scholarship", function () {
        const $btn = $(this);
        const value = $btn.parent().data("id");
        scholarships = scholarships.filter(
            (scholarship) => scholarship !== value
        );
        $btn.parent().remove();
        if (scholarships.length === 0) {
            $("#no-scholarships").removeClass("hidden");
        }
    });

    $("#form-project").on("submit", function () {
        $("#scholarship_id").val(scholarships);
    });
});
