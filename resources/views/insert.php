<?php

$imagenCodificada =  addslashes(file_get_contents("php://input")); 
    if(strlen($imagenCodificada)<= 0 )exit("Error");
   
$imagenDecodificada = base64_decode($imagenCodificada);


include_once "conn.php";
$fotoo = $con->query("INSERT INTO fotos(`id_cliente`,`presinto`,`fecha_foto`,`ruta_archivo`) 
VALUES('" . $client . "','" . $presinto . "','" . $date . "'," . $imagenDecodificada  . ");");


?>