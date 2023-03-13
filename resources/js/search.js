
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
        }
    });
}
