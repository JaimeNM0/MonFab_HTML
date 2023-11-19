window.addEventListener("load", function () {
    const navbar = document.getElementById("navbar");
    let url = "./htmlPartes/nav.html";
    fetch(url)
        .then((response) => response.text())
        .then(function (text) {
            navbar.innerHTML = text;
            remarcarArchivoActual();
        })
        .catch(function (error) {
            console.log("Hubo un problema con la petición Fetch:" + error.message);
        });
});

const remarcarArchivoActual = () => {
    var rutaActual = window.location.pathname;
    var archivoActual = rutaActual.slice(rutaActual.lastIndexOf("/") + 1, rutaActual.indexOf("html") + 4);
    var enlaces = document.querySelectorAll("#listaNav a");

    enlaces.forEach(function (enlace) {
        var archivoEnlace = enlace.getAttribute("href");
        if (archivoActual === archivoEnlace) {
            enlace.style.background = "#04aa6d";
        }
    });
}