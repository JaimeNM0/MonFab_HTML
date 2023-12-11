window.addEventListener("load", function () {
    alertaConfirmar();
});

function alertaConfirmar() {
    const botonEnviar = document.getElementById("enviar");

    botonEnviar.addEventListener("click", function () {
        const formularioElemento = document.getElementById("formularioElemento");
        const formData = new FormData(formularioElemento);
        console.log("Hola" + formularioElemento);
        formularioElemento.addEventListener("submit", function (event) {
            event.preventDefault();
            Swal.fire({
                title: "¿Estas seguro de hacer eso?",
                text: "¡No podrás revertir esto!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, quiero insertar"
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('./ws/createElement2.php', {
                        method: 'POST',
                        body: formData
                    })
                        .then((response) => response.json())
                        .then(function (response2) {
                            alertaRespuesta(response2, "Insertado");
                        })
                        .catch(function (error) {
                            console.log("Hubo un problema con la petición Fetch:" + error.message);
                        });
                }
            });
        });
    });
}
