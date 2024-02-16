module.exports = restar;

function restar(numRestado, numResta) {
    const resultado = numRestado - numResta;
    return resultado;
}

window.addEventListener("load", function () {
    restar(20, 7);
    traerInformacion();
});

function traerInformacion() {
    const filtros = document.getElementById("filtrar");

    filtros.addEventListener("input", function () {
        filtrar(filtros);
    });

    filtrar(filtros);
}

function filtrar(filtros) {
    let buscar;
    const textoBuscado = filtros.value;

    textoBuscado.length >= 3 ? buscar = textoBuscado : buscar = "";
    peticionBD(buscar);
}

function peticionBD(buscar) {
    fetch('./ws/getElement.php', {
        method: 'GET'
    })
        .then((response) => response.json())
        .then(function (response2) {
            if (response2.success) {
                actualizarTabla(response2.data, buscar);
            }
        })
        .catch(function (error) {
            console.log("Hubo un problema con la petición Fetch:" + error.message);
        });
}

function actualizarTabla(data, filtros) {
    const tabla = document.getElementById("tabla");
    tabla.innerHTML = "";
    console.log(data);
    let datos = data;
    if (Array.isArray(data)) {
        datos = data.filter(function (element) {
            console.log(element.nombre.toLowerCase().indexOf(filtros.toLowerCase()) != -1);
            return (element.nombre.toLowerCase().indexOf(filtros.toLowerCase()) != -1 ||
                element.descripcion.toLowerCase().indexOf(filtros.toLowerCase()) != -1 ? true : false);
        });
    }

    datos.forEach(function (element) {
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
            insertarTextoFormulario(divFormulario, text);
            rellenarDatosFormulario(registro);
            guardarFormularioModificar(registro);
            cancelarFormularioModificar(divFormulario);
        })
        .catch(function (error) {
            console.log("Hubo un problema con la petición Fetch: " + error.message);
        });
}

function insertarTextoFormulario(divFormulario, text) {
    const inicio = "<form";
    const final = "</form>";
    let form = text.slice(text.indexOf(inicio), text.indexOf(final) + final.length);
    divFormulario.innerHTML = form;
}

function rellenarDatosFormulario(registro) {
    const inputNombre = document.getElementById("nombre");
    const inputDescripcion = document.getElementById("descripcion");
    const inputNumeroSerie = document.getElementById("nserie");
    inputNombre.value = registro.nombre;
    inputDescripcion.value = registro.descripcion;
    inputNumeroSerie.value = registro.nserie;

    const inputEstado = document.getElementById("estado");
    if (registro.estado == inputEstado.value) {
        inputEstado.checked = true;
    }

    const inputPrioridadAlta = document.getElementById("prioridadAlta");
    const inputPrioridadMedia = document.getElementById("prioridadMedia");
    const inputPrioridadBaja = document.getElementById("prioridadBaja");
    if (registro.prioridad == inputPrioridadAlta.value) {
        inputPrioridadAlta.checked = true;
    }
    if (registro.prioridad == inputPrioridadMedia.value) {
        inputPrioridadMedia.checked = true;
    }
    if (registro.prioridad == inputPrioridadBaja.value) {
        inputPrioridadBaja.checked = true;
    }
}

function guardarFormularioModificar(registro) {
    const inputGuardar = document.getElementById("guardar");

    inputGuardar.addEventListener("click", function () {
        const formularioElemento = document.getElementById("formularioElemento");
        const formData = new FormData(formularioElemento);
        console.log("Hola" + formularioElemento);
        Swal.fire({
            title: "¿Estas seguro de hacer eso?",
            text: "¡No podrás revertir esto!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si, quiero modificar"
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('./ws/modifyElement.php?id=' + registro.id, {
                    method: 'POST',
                    body: formData
                })
                    .then((response) => response.json())
                    .then(function (response2) {
                        alertaRespuesta(response2, "Modificado");
                        const divFormulario = document.getElementById("formulario");
                        divFormulario.innerHTML = "";
                        traerInformacion();
                    })
                    .catch(function (error) {
                        console.log("Hubo un problema con la petición Fetch:" + error.message);
                    });
            }
        });
    });
}

function cancelarFormularioModificar(divFormulario) {
    const inputCancelar = document.getElementById("cancelar");
    inputCancelar.addEventListener("click", () => divFormulario.innerHTML = "");
}

function crearBotonBorrar(registro) {
    const botonBorrar = document.createElement("input");
    botonBorrar.type = "button";
    botonBorrar.value = "X";

    botonBorrar.addEventListener("click", function (event) {
        Swal.fire({
            title: "¿Estas seguro de hacer eso?",
            text: "¡No podrás revertir esto!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si, quiero borrarlo"
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('./ws/deleteElement.php?id=' + registro.id)
                    .then((response) => response.json())
                    .then(function (response2) {
                        alertaRespuesta(response2, "Borrado");
                        traerInformacion();
                    })
                    .catch(function (error) {
                        console.log("Hubo un problema con la petición Fetch:" + error.message);
                    });
            }
        });
        const divFormulario = document.getElementById("formulario");
        divFormulario.innerHTML = "";
    });

    return botonBorrar;
}
