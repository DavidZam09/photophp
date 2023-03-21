$(document).ready(function () {
    $('#filtro-form').on('submit', function (event) {
        event.preventDefault();

        var filtro = $('#filtro-select').val();
        var campo = $('#campo').val();

        $.ajax({
            url: '../models/search.php',
            type: 'GET',
            data: {
                filter: filtro,
                campo: campo
            },
            success: function (response) {

                $('#result').html(response).show();
            }
        });
    });

    $('#filtro-select').change(function () {

        var filtro = $(this).val();
        var campo = $('#campo').val();

        $.ajax({
            url: '../models/search.php',
            type: 'GET',
            data: {
                filter: filtro,
                campo: campo
            },
            success: function (response) {

                $('#result').html(response).show();
            }
        });
    }
    )
});
