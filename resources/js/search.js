

function mostrarModal(id) {
    // Hacer petición AJAX al servidor para obtener la información del artículo con el ID indicado
    $.ajax({
        url: "../models/ver.php",
        type: "POST",
        data: {
            id: id
        },
        dataType: "json",
        success: function (data) {
            // Mostrar la información del artículo en el modal
            $("#modal_titulo").text(data.titulo);
            $("#modal_precinto").text(data.precinto);
            $("#modal_descripcion").text(data.fecha);
            $("#modal_imagen").attr("src", '../img/' + data.imagen);
            // Mostrar el modal
            $("#modal").modal("show");
        }
    });
}
