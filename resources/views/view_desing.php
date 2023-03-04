<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_GET["ver"])) {
    /* Llamar la Cadena de Conexion*/
    include("../../conn.php");
    // escaping, additionally removing everything that could be (html/javascript-) code
    $titulo = mysqli_real_escape_string($conn, (strip_tags($_POST['ver'], ENT_QUOTES)));

    $id_banner = intval($_GET['id']);
    $sql = $con->query("SELECT * FROM fotos WHERE id = $id_banner");
    // if user has been added successfully
    if ($sql) {
        $row = $sql->fetchObject();
        $url_image = $row->ruta_archivo;
        $messages[] = "<div class='alert alert-
        <img src='../img/" . $url_image . "'>
        </div>";;
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
        <div class="modal-dialog modal-dialog-centered" >
            <button type="button" class="close">&times;</button>
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
