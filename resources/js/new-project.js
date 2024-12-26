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

    $("#get-link").on("click", function () {
        if (marker) {
            const { lat, lng } = marker.getLatLng();
            const link = `https://www.openstreetmap.org/?mlat=${lat}&mlon=${lng}#map=18/${lat}/${lng}`;
            alert("Enlace de ubicación: " + link);
        } else {
            alert("Primero debes seleccionar una ubicación en el mapa");
        }
    });

    $("#capture-map").click(function () {
        html2canvas($("#map")[0]).then((canvas) => {
            canvas.toBlob((blob) => {
                const file = new File([blob], "map-cature.png", {
                    type: "image/png",
                });
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                $("#map-capture")[0].files = dataTransfer.files;
                $("#preview-map").attr("src", URL.createObjectURL(file));
            });
        });
    });
});
