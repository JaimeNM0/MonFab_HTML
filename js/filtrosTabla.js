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
        prioridad: "Indefinido"
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

window.addEventListener("load", function () {
    const filtros = filtrar();
    filtros.value = "";

    filtros.addEventListener("input", function () {
        const textoBuscado = filtros.value;

        textoBuscado.length >= 3 ? actualizarTabla(textoBuscado) : actualizarTabla("");
    });

    actualizarTabla("");
});

function filtrar() {
    const inputFiltrar = document.getElementById("filtrar");
    return inputFiltrar;
}

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
        let botonEditar = crearBotonEditar(element);
        let botonBorrar = crearBotonBorrar(element);

        celdaAccion.appendChild(botonEditar);
        celdaAccion.appendChild(botonBorrar);
        nuevoFila.appendChild(celdaAccion);

        let claves = Object.keys(element);
        for (let i = 0; i <= claves.length - 1; i++) {
            const celda = document.createElement("td");
            celda.textContent = element[claves[i]];
            nuevoFila.appendChild(celda);
        }

        tabla.appendChild(nuevoFila);
    });
}

function crearBotonEditar(registro) {
    const botonEditar = document.createElement("input");
    botonEditar.type = "button";
    botonEditar.value = "EDITAR";

    botonEditar.addEventListener("click", () => modificarInformacion(registro));

    return botonEditar;
}

function modificarInformacion(registro) {
    const divFormulario = document.getElementById("formulario");
    let url = "./htmlPartes/formularioElement.html";
    fetch(url)
        .then((response) => response.text())
        .then(function (text) {
            console.log(text);
            console.log(registro);
            divFormulario.innerHTML = text;

            rellenarDatos(registro);
            rellenarEstado(registro.estado);
            rellenarPrioridad(registro.prioridad);

            guardarModificacion(divFormulario, registro);
            cancelarModificacion(divFormulario);
        })
        .catch(function (error) {
            console.log("Hubo un problema con la petición Fetch: " + error.message);
        });
}

function rellenarDatos(registro) {
    const inputNombre = document.getElementById("nombre");
    const inputDescripcion = document.getElementById("descripcion");
    const inputNumeroSerie = document.getElementById("numeroSerie");
    inputNombre.value = registro.nombre;
    inputDescripcion.value = registro.descripcion;
    inputNumeroSerie.value = registro.numeroSerie;
}

function rellenarEstado(valorEstado) {
    const inputEstado = document.getElementById("estado");
    if (valorEstado == inputEstado.value) {
        inputEstado.checked = true;
    }
}

function rellenarPrioridad(valorPrioridad) {
    const inputPrioridadAlta = document.getElementById("prioridadAlta");
    const inputPrioridadMedia = document.getElementById("prioridadMedia");
    const inputPrioridadBaja = document.getElementById("prioridadBaja");
    valorPrioridad == inputPrioridadAlta.value ? inputPrioridadAlta.checked = true : null;
    valorPrioridad == inputPrioridadMedia.value ? inputPrioridadMedia.checked = true : null;
    valorPrioridad == inputPrioridadBaja.value ? inputPrioridadBaja.checked = true : null;
}

function guardarModificacion(divFormulario, registro) {
    const inputGuardar = document.getElementById("guardar");

    inputGuardar.addEventListener("click", function () {
        informacionNoBorrada = informacionNoBorrada.filter(function (element) {
            if (element === registro) {
                element = rellenarModificacion(element);
            }
            return element;
        });
        divFormulario.innerHTML = "";
        const filtros = filtrar();
        actualizarTabla(filtros.value);
    });
}

function rellenarModificacion(element) {
    const inputNombre = document.getElementById("nombre");
    const inputDescripcion = document.getElementById("descripcion");
    const inputNumeroSerie = document.getElementById("numeroSerie");
    const inputEstado = document.getElementById("estado");
    const inputPrioridadAlta = document.getElementById("prioridadAlta");
    const inputPrioridadMedia = document.getElementById("prioridadMedia");
    const inputPrioridadBaja = document.getElementById("prioridadBaja");

    let nombre = !(inputNombre.value == "") ? inputNombre.value : element.nombre;
    let descripcion = !(inputDescripcion.value == "") ? inputDescripcion.value : element.descripcion;
    let numeroSerie = !(inputNumeroSerie.value == "") ? inputNumeroSerie.value : element.numeroSerie;
    let estado = inputEstado.checked ? inputEstado.value : "Inactivo";

    let prioridad = "Indefinido";
    prioridad = inputPrioridadAlta.checked ? inputPrioridadAlta.value : prioridad;
    prioridad = inputPrioridadMedia.checked ? inputPrioridadMedia.value : prioridad;
    prioridad = inputPrioridadBaja.checked ? inputPrioridadBaja.value : prioridad;

    element.nombre = nombre;
    element.descripcion = descripcion;
    element.numeroSerie = numeroSerie;
    element.estado = estado;
    element.prioridad = prioridad;

    return element;
}

function cancelarModificacion(divFormulario) {
    const inputCancelar = document.getElementById("cancelar");
    
    inputCancelar.addEventListener("click", () => divFormulario.innerHTML = "");
}

function crearBotonBorrar(registro) {
    const botonBorrar = document.createElement("input");
    botonBorrar.type = "button";
    botonBorrar.value = "X";

    botonBorrar.addEventListener("click", function (event) {
        event.target.parentElement.parentElement.remove();
        borrarInformacion(registro);
    });

    return botonBorrar;
}

function borrarInformacion(registro) {
    informacionNoBorrada = informacionNoBorrada.filter(function (element) {
        console.log(element);
        return (!(element == registro));
    });
    const divFormulario = document.getElementById("formulario");
    divFormulario.innerHTML = "";
}