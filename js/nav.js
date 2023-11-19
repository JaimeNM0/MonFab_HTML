window.addEventListener("load", function () {
    const navbar = document.getElementById("navbar");
    let url = "./htmlPartes/nav.html";
    fetch(url)
        .then((response) => response.text())
        .then(function (text) {
            navbar.innerHTML = text;
            oirSonido();
            remarcarArchivoActual();
        })
        .catch(function (error) {
            console.log("Hubo un problema con la petición Fetch:" + error.message);
        });
});

function remarcarArchivoActual() {
    let rutaActual = window.location.pathname;
    let archivoActual = rutaActual.slice(rutaActual.lastIndexOf("/") + 1, rutaActual.indexOf("html") + 4);
    let enlaces = document.querySelectorAll("#listaNav a");

    enlaces.forEach(function (enlace) {
        let archivoEnlace = enlace.getAttribute("href");
        archivoActual === archivoEnlace ? enlace.style.background = "#04aa6d" : null;
    });
}

function oirSonido() {
    let sonido = document.createElement('audio');
    sonido.src = "audio/boton.mp3";
    sonido.play();
}