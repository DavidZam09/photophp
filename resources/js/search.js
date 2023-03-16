function mostrarModal(id) {

    $.ajax({
        url: "../models/ver.php",
        type: "POST",
        data: {
            id: id
        },
        dataType: "json",
        success: function (data) {

            $("#modal_titulo").text(data.titulo);
            $("#modal_precinto").text(data.precinto);
            $("#modal_descripcion").text(data.fecha);
            $("#modal_imagen").attr("src", '../img/' + data.imagen);

            $("#modal").modal("show");
        }
    });
}
