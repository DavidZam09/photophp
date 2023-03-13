<?php

include('conn.php');

$client = $_POST['cliente'];
$precinte = $_POST['precinto'];
$date = $_POST['date'];
$img = $$_FILES['img'];
$folderPath = "../img/";
$fileName = $img['tmp_name'] . '.png';

if ($img['type'] == 'image/png' || $img['type'] == 'image/jpg' || $img['type'] == 'image/jpeg') {

    $query = "INSERT INTO fotos(`id_cliente`,`presinto`,`fecha_foto`,`ruta_archivo`)
    VALUES('" . $client . "','" . $precinte . "','" . $date . "','" . $fileName . "' ";
    echo "yes" . $query;
    /* if ($con->query($query)) {
        move_uploaded_file($img['name'], $folderPath);
        echo " Uploaded";
    } else {
        echo"Error uploading";
    }*/
} else {
    echo "Archivo no valido!";
}
