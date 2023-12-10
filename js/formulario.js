window.addEventListener("load", function () {
    alertaConfirmar();
});

function alertaConfirmar() {
    const botonEnviar = document.getElementById("enviar");

    botonEnviar.addEventListener("click", function () {
        const formularioElemento = document.getElementById("formularioElemento");
        const formData = new FormData(formularioElemento);
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
                            alertaRespuesta(response2);
                        })
                        .catch(function (error) {
                            console.log("Hubo un problema con la petición Fetch:" + error.message);
                        });
                }
            });
        });
    });
}

function alertaRespuesta(response2) {
    let titulo;
    let texto;
    let icon;
    console.log(response2);
    console.log(response2.success);
    response2.success ? titulo = "¡Insertado correctamente!" : titulo = "¡Insertado incorrectamente!";
    response2.success ? texto = response2.message.slice(0, -1) + " el registro " + response2.data[0].id + "." : texto = response2.message;
    response2.success ? icon = "success" : icon = "error";
    console.log(titulo);
    Swal.fire({
        title: titulo,
        text: texto,
        icon: icon
    });
}