$(document).ready(function () {
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
        leafletImage(map, function (err, canvas) {
            $("#loader").addClass("hidden");

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
        const mimeString = dataURI.split(",")[0].split(":")[1].split(";")[0];
        const ab = new ArrayBuffer(byteString.length);
        const ia = new Uint8Array(ab);
        for (let i = 0; i < byteString.length; i++) {
            ia[i] = byteString.charCodeAt(i);
        }
        return new Blob([ab], { type: mimeString });
    }
});
