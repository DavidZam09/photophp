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
$fotoo = $con->query("INSERT INTO fotos(`id_cliente`,`presinto`,`fecha_foto`,`ruta_archivo`)
VALUES('" . $client . "','" . $presinto . "','" . $date . "','" . $fileName . "');");

header("Location: ../views/welcome.blade.php");

?>
