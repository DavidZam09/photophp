<?php
session_start();

/* Llamar la Cadena de Conexion*/
include("conn.php");
$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';
if ($action == 'ajax') {
    //Elimino producto
    if (isset($_REQUEST['id'])) {
        $id_banner = intval($_REQUEST['id']);
        if (empty($id_banner)) {
            exit("No existe el parámetro id");
        }
        if ($delete = $con->prepare("delete from fotos where id='$id_banner'")) {
            $delete->execute();
            $message = "Datos eliminados satisfactoriamente";
        } else {
            $error = "No se pudo eliminar los datos";
        }
    }

    $tables = "fotos";
    $sWhere = " ";
    $sWhere .= " ";


    $sWhere .= " order by id";
    include '../views/pagination.php';

    $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
    $per_page = 12;
    $adjacents  = 4;
    $offset = ($page - 1) * $per_page;


    include_once('conn.php');
    $count_query  = $con->prepare("SELECT count(*) AS numrows FROM $tables  $sWhere ");
    $count_query->execute();
    if ($count_query != null) {
        $row = $count_query->fetch(PDO::FETCH_OBJ);
        $row->numrows = intval($row->numrows);
        $numrows = $row->numrows;
    } else {
        echo $con . error_log(1);
    }
    $total_pages = ceil($numrows / $per_page);
    $reload = './welcome.blade.php';

    if (isset($message)) {
?>
        <div class="alert alert-success alert-dismissible fade in" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
            <strong>Aviso!</strong> <?php echo $message; ?>
        </div>

    <?php
    }
    if (isset($error)) {
    ?>
        <div class="alert alert-danger alert-dismissible fade in" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
            <strong>Error!</strong> <?php echo $error; ?>
        </div>

    <?php
    }

    if ($numrows > 0) {

    ?>

        <div class="row">
            <?php
            $query = $con->prepare("SELECT id, id_cliente, presinto, fecha_foto, ruta_archivo  FROM  $tables  $sWhere LIMIT $offset,$per_page");
            $query->execute();

            while ($row = $query->fetchObject()) {
                $id_slide = $row->id;
                $cliente = $row->id_cliente;
                $presinto = $row->presinto;
                $fecha = $row->fecha_foto;
                $url_image = $row->ruta_archivo;
            ?>
                <form action="" method="post">
                    <div class="col-sm-6 col-md-3">
                        <div class="thumbnail">
                            <input type="hidden" id="precinto" name="precinto" value="<?php echo $presinto ?>" />
                            <input type="hidden" id="url" name="url" value="<?php echo $url_image ?>" />
                            <input type="hidden" id="cliente" name="cliente" value="<?php echo $cliente ?>" />
                            <input type="hidden" id="fecha" name="fecha" value="<?php echo $fecha ?>" />
                            <input type="hidden" id="id" name="id" value="<?php echo $id_slide ?>" />

                            <?php echo "<img src='../img/" . $url_image . "'>"; ?>
                            <div class="caption" style="text-align: center;">
                                <p>Cliente: <?php echo $cliente; ?>
                                <p>
                                <p>Precinto: <?php echo $presinto; ?>
                                <p>
                                <p>Fecha: <?php echo $fecha ?></p>
                                <button type="button" class="btn btn-primary" onclick="mostrarModal(<?php echo $id_slide ?>)">
                                    <i class='glyphicon glyphicon-eye-open'></i> ver</button>
                                <button type="button" class="btn btn-danger" onclick="eliminar_slide('<?php echo $id_slide; ?>');" role="button">
                                    <i class='glyphicon glyphicon-trash'></i> Eliminar</button>
                                </p>
                            </div>
                        </div>
                    </div>
                </form>


        <?php
            }
        }
        ?>

        </div>


        <div class="table-pagination text-right">

            <?php echo paginate($reload, $page, $total_pages, $adjacents); ?>
        </div>

    <?php
}


    ?>
