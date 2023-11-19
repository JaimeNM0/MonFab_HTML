window.addEventListener("load", function () {
    console.log("Holas");
    const navbar = document.getElementById("navbar");
    let url = "./nav.html";
    fetch(url)
        .then((response) => response.text())
        .then(function (response) {
            navbar.innerHTML = response;
            remarcarArchivo();
        })
        .catch(function (error) {
            console.log("Hubo un problema con la petición Fetch:" + error.message);
        });
});

const remarcarArchivo = () => {
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