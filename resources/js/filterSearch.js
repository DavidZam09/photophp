$('#filter').change(function () {

    let filter = $(this).val();

    let campo = document.getElementById('campo').value;

    console.log(filter, campo)

    if (filter == 'Filtrar') {
        filter = 'id';
    }
    else {
        filter = $(this).val();
    }
    $.ajax({
        type: "POST",
        url: "../models/search.php",
        data: {
            campo: campo,
            filter: filter
        },
        dataType: 'json',
        beforeSend: function (objeto) {
            $("#result").html("Mensaje: Cargando...");
        },
        success: function (datos) {
            $("#result").html(datos);
        }
    });
})
function getData() {
    let campo = document.getElementById('campo').value;
    $.ajax({
        url: "../models/search.php",
        data: {
            campo: campo,
            filter: 'id'
        },
        beforeSend: function (objeto) {
            $("#result").html("Mensaje: Cargando...");
        },
        success: function (datos) {
                $("#result").html(datos).fadeIn('slow');
        }
    });
}






