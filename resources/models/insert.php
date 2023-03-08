<?php
$img = $_POST['img'];
$client = $_POST['client'];
$presinto = $_POST['presinto'];
$date = $_POST['date'];
$folderPath = "../img/";

$image_parts = explode(";base64,", $img);
$image_type_aux = explode("image/", $image_parts[0]);
$image_type = $image_type_aux[1];

$image_base64 = base64_decode($image_parts[1]);
$fileName = uniqid() . '.png';

$file = $folderPath . $fileName;
file_put_contents($file, $image_base64);
//$imagenCodificada =  addslashes(file_get_contents("php://input"));
// if(strlen($imagenCodificada)<= 0 )exit("Error");

//$imagenDecodificada = base64_decode($imagenCodificada);

include_once "conn.php";

if ($fotoo = $con->query("INSERT INTO fotos(`id_cliente`,`presinto`,`fecha_foto`,`ruta_archivo`)
 VALUES('" . $client . "','" . $presinto . "','" . $date . "','" . $fileName . "');")) {
    echo "Datos Agregados satisfactoriamente";
} else {
    $error = "No se pudo agregar los datos";
}
if (isset($message)) {
?>
    <div class="alert alert-success alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        <strong>Aviso!</strong> <?php echo $message; ?>
    </div>

<?php
};
if (isset($error)) {
?>
    <div class="alert alert-danger alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        <strong>Error!</strong> <?php echo $error; ?>
    </div>

<?php
};

header("Location: ../views/welcome.blade.php");

?>
