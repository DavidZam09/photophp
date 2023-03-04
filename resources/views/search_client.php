<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Search</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <style>
        .titulo {
            text-align: center;
            align-items: center;
            justify-content: center;
        }

        #campo {
            height: 100%;
            width: 100%;
        }

        .img {
            text-align: center;
            justify-content: center;
            align-items: center;
        }

        #row {
            text-align: center;
            justify-content: center;
            align-items: center;
        }

        #alert {
            justify-content: center;
            align-items: center;
            display: flex;
            flex-direction: column;
        }
    </style>
    <title>Consultas</title>
</head>

<body>
    <?php
    include('top_menu.php'); ?>
    <div class="titulo">
        <h3> Consultar Diseños</h3>
    </div>
    <div class="container">
        <div class="row" id="row">
            <form action="" method="get">
                <div class="form-group">
                    <div>
                        <label for="campo">Buscador</label>
                        <input class="form-control" type="text" name="campo" id="campo">
                        <small style=" text-align: left;">Puedes buscar por Nombre de Cliente o Presinto.</small>
                    </div>
                    <br>

                    <div>
                        <input type="submit" id="boton" name="boton" value="Buscar">
                    </div>
                </div>
            </form>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
            <?php
            include 'pagination.php';
            $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
            $per_page = 12;
            $adjacents  = 4;
            $offset = ($page - 1) * $per_page;
            include_once('../models/conn.php');
            $count_query  = $con->prepare("SELECT count(*) AS numrows FROM fotos  ORDER BY id ");
            $count_query->execute();

            if ($count_query != null) {
                $row = $count_query->fetch(PDO::FETCH_OBJ);
                $row->numrows = intval($row->numrows);
                $numrows = $row->numrows;
            } else {
                echo $con . error_log(1);
            ?>
                <div id="alert">
                    <div class='thumbnail' style='align-items: center; justify-content: center; text-align: center;'>
                        <img style='align-items: center; justify-content: center; text-align: center;' src='https://png.pngitem.com/pimgs/s/52-524972_sad-negro-signo-simbolo-carita-triste-emoticon-positive.png'>
                    </div>
                    <div class='caption'>
                        <label>No hay Diseños, Intenta Buscar de Nuevo</label>
                    </div>
                </div>
                <?php
            }
            $total_pages = ceil($numrows / $per_page);
            $reload = './welcome.blade.php';

            if ($numrows > 0) {
                if (isset($_GET['boton']) && $_GET['campo'] != null) {

                    $campo = $_GET['campo'];
                    include_once('../models/conn.php');
                    $query = $con->query("SELECT * FROM fotos where `id_cliente` LIKE '%$campo%' OR `presinto` LIKE '%$campo%' ORDER BY `fecha_foto` ASC");

                    if ($query->fetch() == null) {

                ?>

                        <div id="alert">
                            <div class='thumbnail'>
                                <img src='https://png.pngitem.com/pimgs/s/52-524972_sad-negro-signo-simbolo-carita-triste-emoticon-positive.png'>
                            </div>
                            <div class='caption'>
                                <label>No hay Diseños con este precinto o nombre de cliente, Intenta Buscar de Nuevo</label>
                            </div>
                        </div>
                        <?php
                    } else {
                        $query = $con->query("SELECT * FROM fotos where `id_cliente` LIKE '%$campo%' OR `presinto` LIKE '%$campo%' ORDER BY `presinto`");
                        while ($row = $query->fetchObject()) {
                            $id_slide = $row->id;
                            $cliente = $row->id_cliente;
                            $presinto = $row->presinto;
                            $fecha = $row->fecha_foto;
                            $url_image = $row->ruta_archivo;
                        ?>

                            <div class="col-sm-6 col-md-3">
                                <div class="thumbnail">
                                    <?php echo "<img src='../img/" . $url_image . "'>"; ?>
                                    <div class="caption" style="text-align: center;">
                                        <h3>Cliente: <?php echo $cliente; ?></h3>
                                        <h4>Precinto: <?php echo $presinto; ?></h4>
                                        <p>Fecha: <?php echo $fecha ?></p>

                                        <p class='text-right'><a href="view_desing.php?id=<?php echo intval($id_slide); ?>" class="btn btn-info" role="button">
                                                <i class='glyphicon glyphicon-eye-open'></i></a>
                                        </p>
                                    </div>
                                </div>
                            </div>


                    <?php
                        }
                    }
                } else {
                    ?>

                    <div id="alert">
                        <div class='thumbnail' style='align-items: center; justify-content: center; text-align: center;'>
                            <img src='https://png.pngitem.com/pimgs/s/52-524972_sad-negro-signo-simbolo-carita-triste-emoticon-positive.png'>
                        </div>
                        <div class='caption'>
                            <label>No hay Diseños, Intenta Buscar de Nuevo</label>
                        </div>
                    </div>

                <?php
                }
            } else {
                ?>

                <div id="alert">
                    <div class='thumbnail'>
                        <img src='https://png.pngitem.com/pimgs/s/52-524972_sad-negro-signo-simbolo-carita-triste-emoticon-positive.png'>
                    </div>
                    <div class='caption'>
                        <label>No hay Diseños</label>
                        <div class="row">

                            <div class="col-xs-12 text-right">
                                <a href='welcome.blade.php' class="btn btn-default"><span class="glyphicon glyphicon-plus"></span> Agregar Diseño</a>
                            </div>

                        </div>
                    </div>
                </div>

                <?php
            }
            if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET["titulo"])) {

                include("../../conexion.php");

                $titulo = mysqli_real_escape_string($conn, (strip_tags($_POST['titulo'], ENT_QUOTES)));
                $descripcion = mysqli_real_escape_string($conn, ($_POST['descripcion']));
                $orden = intval($_POST['orden']);
                $estado = intval($_POST['estado']);
                $id_banner = intval($_POST['id_banner']);
                $sql = "UPDATE banner SET titulo='$titulo', descripcion='$descripcion', orden='$orden', estado='$estado' WHERE id='$id_banner'";
                $query = mysqli_query($conn, $sql);
                // if user has been added successfully
                if ($query) {
                    $messages[] = "Datos  han sido actualizados satisfactoriamente.";
                } else {
                    $errors[] = "Lo siento algo ha salido mal intenta nuevamente." . mysqli_error($conn);
                }

                if (isset($errors)) {

                ?>
                    <div class="alert alert-danger" role="alert">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Error!</strong>
                        <?php
                        foreach ($errors as $error) {
                            echo $error;
                        }
                        ?>
                    </div>
                <?php
                }
                if (isset($messages)) {

                ?>
                    <div class="alert alert-success" role="alert">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>¡Bien hecho!</strong>
                        <?php
                        foreach ($messages as $message) {
                            echo $message;
                        }
                        ?>
                    </div>
            <?php
                }
            }
            ?>
        </div>

        <div class="table-pagination text-right">
            <?php echo paginate($reload, $page, $total_pages, $adjacents); ?>
        </div>
    </div>
    <?php include("footer.php"); ?>


</body>

</html>
