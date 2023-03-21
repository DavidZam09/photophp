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
    <link rel="stylesheet" href="../css/modal.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

    <title>Consultas</title>
    <style>
        #row {
            text-align: center;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>

<body>
    <?php
    include('top_menu.php'); ?>
    <div class="titulo">
        <h3> Consultar Diseños</h3>
    </div>

    <div class="container">
        <div class="row" id="row">
            <form id="filtro-form">
                <label for="campo">Buscador</label>
                <input class="form-control" type="text" name="campo" id="campo">
                <small style=" text-align: left;">Puedes buscar por Nombre de Cliente o Presinto.</small>
                <select id="filtro-select" name="filtro">
                    <option value="">Todos</option>
                    <option value="presinto">Precinto</option>
                    <option value="fecha_foto">Fecha</option>
                </select>
                <button type="submit">Filtrar</button>
            </form>

            <?php include 'pagination.php';
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
            ?>
                <div class="result" id="result"></div>
        </div>
        <div class="table-pagination text-right">
            <?php echo paginate($reload, $page, $total_pages, $adjacents); ?>
        </div>
    <?php } ?>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="../js/filterSearch.js"></script>
    <?php include("modal.php"); ?>
    <?php include("footer.php"); ?>
    <script src="../js/search.js"></script>
    <script src="../js/filterSearch.js"></script>
</body>

</html>
