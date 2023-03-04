<?php
session_start();

include("conn.php");
$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';
if ($action == 'ajax') {
    //ver
    if (isset($_REQUEST['id'])) {
        $id_banner = intval($_REQUEST['id']);
        if (empty($id_banner)) {
            exit("No existe el parámetro id");
        }
        if ($select = $con->prepare("select * from fotos where id='$id_banner'")) {
            $select->execute();
            $message = "Datos eliminados satisfactoriamente";
            $row = $select->fetchObject();

            $cliente = $row->id_cliente;
        } else {
            $error = "No se pudo eliminar los datos";
        }
    }
    if (isset($message)) {
?>
        <div id="myModal" class="modal">

            <div class="modal-content">
                <span class="close">&times;</span>
                <p>
                    Some text in the Modal..
                </p>
            </div>

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
}


?>
