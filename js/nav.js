window.addEventListener("load", function () {
    const navbar = document.getElementById("navbar");
    let url = "./htmlPartes/nav.html";
    fetch(url)
        .then((response) => response.text())
        .then(function (text) {
            insertarTextoNav(navbar, text);
            oirSonido();
            remarcarArchivoActual();
        })
        .catch(function (error) {
            console.log("Hubo un problema con la petición Fetch:" + error.message);
        });
});

function insertarTextoNav(navbar, text) {
    console.log(text);
    const inicio = "<nav id=\"listaNav\"";
    const final = "</nav>";
    let nav = text.slice(text.indexOf(inicio), text.indexOf(final) + final.length);
    navbar.innerHTML = nav;
}

function remarcarArchivoActual() {
    let rutaActual = window.location.pathname;
    let archivoActual = rutaActual.slice(rutaActual.lastIndexOf("/") + 1, rutaActual.indexOf("html") + 4);
    let enlaces = document.querySelectorAll("#listaNav a");

    enlaces.forEach(function (enlace) {
        let archivoEnlace = enlace.getAttribute("href");
        if(archivoActual === "" && archivoEnlace === "index.html") {
            enlace.style.background = "#04aa6d";
        }

        if (archivoActual === archivoEnlace) {
            enlace.style.background = "#04aa6d";
        }
    });
}

function oirSonido() {
    let sonido = document.createElement('audio');
    sonido.src = "audio/boton.mp3";
    sonido.play();
}