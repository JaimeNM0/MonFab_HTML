function alertaRespuesta(response2, metodo) {
    let titulo;
    let texto;
    let icon;
    console.log(response2);
    console.log(response2.success);
    response2.success ? titulo = "¡" + metodo + " correctamente!" : titulo = "¡" + metodo + " incorrectamente!";
    if (metodo == "Borrado") {
        texto = response2.message;
    } else {
        response2.success ? texto = response2.message.slice(0, -1) + " el registro " + response2.data[0].id + "." : texto = response2.message;
    }
    response2.success ? icon = "success" : icon = "error";
    console.log(titulo);
    Swal.fire({
        title: titulo,
        text: texto,
        icon: icon
    });
}