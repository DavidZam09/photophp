<?php
$title = "Galería";
include("../models/conn.php");
$active_config = "active";
$active_banner = "active";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../images/ico/favicon.ico">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="../css/app.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

    <style>
        .breadcrumb {
            margin-top: 70px;
        }

        .modal-backdrop {
            background-color: rgba(0, 0, 0, .0001) !important;
        }

        #modal {
            text-align: center;
            background-color: rgba(0, 0, 0, .0001) !important;
        }
    </style>
</head>

<body>
    <?php include("top_menu.php"); ?>

    <div class="container">

        <div class="row">

            <ol class="breadcrumb">
                <li><a href="#">Inicio</a></li>
                <li class="active">Banner</li>
            </ol>
            <div class="row">

                <div class="col-xs-12 text-right">
                    <a href='welcome.blade.php' class="btn btn-default"><span class="glyphicon glyphicon-plus"></span> Agregar Diseño</a>
                    <a href='archiveUp.php' class="btn btn-default"><span class="glyphicon glyphicon-plus"></span> Subir Diseño</a>
                </div>


            </div>

            <br>

            <div id="loader" class="text-center"> <span><img src="../img/giphy.gif"></span></div>
            <div class="outer_div"></div>
        </div>
    </div>
    <?php include("modal.php"); ?>
    <?php include("footer.php"); ?>
    <script src="../js/search.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

</body>


</html>
<script>
    $(document).ready(function() {
        load(1);
    });

    function load(page) {
        var parametros = {
            "action": "ajax",
            "page": page
        };
        $.ajax({
            url: '../models/banner_ajax.php',
            data: parametros,
            beforeSend: function(objeto) {
                $("#loader").html("<img src='../img/giphy.gif'>");
            },
            success: function(data) {
                $(".outer_div").html(data).fadeIn('slow');
                $("#loader").html("");
            }
        })
    }

    function eliminar_slide(id) {
        page = 1;
        var parametros = {
            "action": "ajax",
            "page": page,
            "id": id
        };
        if (confirm('Esta acción  eliminará de forma permanente el banner \n\n Desea continuar?')) {
            $.ajax({
                url: '../models/banner_ajax.php',
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
</script>
