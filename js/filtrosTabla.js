const informacion = [
    {
        nombre: "Reciclado de botellas",
        descripcion: "Hay muchas variaciones de los pasajes de Lorem Ipsum disponibles, pero la mayoría sufrió.",
        numeroSerie: "r5c7AEZ c67w6rg xeBssyV Ka8PVJ2",
        estado: "Activo",
        prioridad: "Alta"
    },
    {
        nombre: "Creación de botellas",
        descripcion: "Hay pocas variaciones de los pasajes de Lorem Ipsum disponibles, pero la mayoría sufrió.",
        numeroSerie: "mQ2f7wm 2cPG68X wkaRXbj RWrX3nF",
        estado: "Activo",
        prioridad: "Baja"
    },
    {
        nombre: "Diseñado de botellas",
        descripcion: "Creación de las variaciones de los pasajes de Lorem Ipsum disponibles, pero la mayoría sufrió.",
        numeroSerie: "3iiMRez fXr9en9 CG2X6ta gBmBuQU",
        estado: "Activo",
        prioridad: "Media"
    },
    {
        nombre: "Reciclar las botellas",
        descripcion: "Reciclado las variaciones de los pasajes de Lorem Ipsum disponibles, pero la mayoría sufrió.",
        numeroSerie: "QJBiofS 4o6Vs1f l4kJmSN mCVFBA8",
        estado: "Activo",
        prioridad: "Alta"
    },
    {
        nombre: "Diseñar las botellas",
        descripcion: "Modificación de las variaciones de los pasajes de Lorem Ipsum disponibles, pero la mayoría sufrió.",
        numeroSerie: "F1RYijI eD7hNHV 8600ohx 7wIgdfp",
        estado: "Activo",
        prioridad: "Media"
    },
    {
        nombre: "Modificación de botellas",
        descripcion: "Hay menos variaciones de los pasajes de Lorem Ipsum disponibles, pero la mayoría sufrió.",
        numeroSerie: "MZyBDPg ijEmtzs dxjKBh3 v92eM7J",
        estado: "Inactivo",
        prioridad: "Baja"
    },
    {
        nombre: "Crear las botellas",
        descripcion: "Diseñado las variaciones de los pasajes de Lorem Ipsum disponibles, pero la mayoría sufrió.",
        numeroSerie: "QqMJgOo bx5K1Ea br3i1oT H2VaniV",
        estado: "Inactivo",
        prioridad: "Baja"
    },
    {
        nombre: "Modificar las botellas",
        descripcion: "Aparecen las variaciones de los pasajes de Lorem Ipsum disponibles, pero la mayoría sufrió.",
        numeroSerie: "3YzmBEp XklHNJa 1nM3Vq5 nqzICLy",
        estado: "Inactivo",
        prioridad: "Media"
    }
];

let informacionNoBorrada = informacion;

window.addEventListener('load', function () {
    const filtrar = document.getElementById("filtrar");
    filtrar.value = "";

    filtrar.addEventListener("input", function () {
        const textoBuscado = filtrar.value;

        textoBuscado.length >= 3 ? actualizarTabla(textoBuscado) : actualizarTabla("");
    });

    actualizarTabla("");
});

/*window.onload = function () {
    
};*/

function actualizarTabla(filtros) {
    const tabla = document.getElementById("tabla");
    tabla.innerHTML = "";

    const informacionFiltrada = informacionNoBorrada.filter(function (element) {

        return (element.nombre.toLowerCase().indexOf(filtros.toLowerCase()) != -1 ||
            element.descripcion.toLowerCase().indexOf(filtros.toLowerCase()) != -1 ? true : false);
    });

    informacionFiltrada.forEach(function (element) {
        const nuevoFila = document.createElement("tr");

        const celdaAccion = document.createElement("td");
        const boton = document.createElement("input");
        boton.type = "button";
        boton.value = "X";

        boton.onclick = function (event) {
            event.target.parentElement.parentElement.remove();
            borrarInformacion(element);
        };

        celdaAccion.appendChild(boton);
        nuevoFila.appendChild(celdaAccion);

        let claves = Object.keys(element);
        for (let i = 0; i <= claves.length; i++) {
            const celda = document.createElement("td");
            celda.textContent = element[claves[i]];
            nuevoFila.appendChild(celda);
        }

        tabla.appendChild(nuevoFila);
    });
}

function borrarInformacion(borrar) {
    informacionNoBorrada = informacionNoBorrada.filter(function (element) {
        console.log(element);
        return (!(element == borrar));
    });
}