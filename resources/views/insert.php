<?php
$imagenCodificada = file_get_contents("php://input"); 
if(strlen($imagenCodificada) <= 0) exit("No se recibió ninguna imagen");


$imagenCodificadaLimpia = str_replace("data:image/png;base64,", "", urldecode($imagenCodificada));
$imagenDecodificada = base64_decode($imagenCodificadaLimpia);

$client = $_POST['client'];
$presinto = $_POST['presinto'];
$date = $_POST['date'];

include_once "conn.php";
$sentencia = $con->prepare("INSERT INTO fotos(`id_cliente`,`presinto`,`fecha_foto`,`ruta_archivo`)
VALUES ('" . $client . "','" . $presinto . "','" . $date . "','" . $imagenCodificadaLimpia . "')");
$sentencia->execute();
$id = $conn->lastInsertId();

?>