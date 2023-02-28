document.getElementById("id")

function eliminar_slide(id) {
    page = 1;
    var parametros = {
        "action": "ajax",
        "page": page,
        "id": id
    };
    if (confirm('Esta acción  eliminará de forma permanente el banner \n\n Desea continuar?')) {
        $.ajax({
            url: './banner_ajax.php',
            data: parametros,
            beforeSend: function(objeto) {
                $("#loader").html("<img src='../images/giphy.gif'>");
            },
            success: function(data) {
                $(".outer_div").html(data).fadeIn('slow');
                $("#loader").html("");
            }
        })
    }
}