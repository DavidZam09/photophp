$(document).ready(function () {
    $("#formulario").submit(insertar)

    function insertar(event) {
        event.preventDefault();
        var datos = new FormData($("#formulario")[1]);
        $("#result").html("<img src='../img/giphy.gif'>")
        $.ajax(
            {
                url: '../models/archive.php',
                type: 'POST',
                data: datos,
                contenType: false,
                processData: false,
                success: function (datos) {
                    $('#results').html(datos);

                }
            }
        )
    }

})
