<?php

include('conn.php');

$client = $_POST['cliente'];
$presinto = $_POST['precinto'];
$date = $_POST['date'];
$img = $_FILES['img']['name'];
$valid = $_FILES['img'];
$temp = $_FILES['img']['tmp_name'];
$folderPath = "../img/";



if ($valid['type'] == 'image/png' || $valid['type'] == 'image/jpg' || $valid['type'] == 'image/jpeg') {

    $query = $con->query("INSERT INTO fotos(`id_cliente`,`presinto`,`fecha_foto`,`ruta_archivo`)
    VALUES('" . $client . "','" . $presinto . "','" . $date . "','" . $img . "');");

    if ($query) {
        move_uploaded_file($temp, $folderPath . '/' . $img);
        echo " Uploaded";
    } else {
        echo "Error uploading";
    }
} else {
    echo "Archivo no valido!";
}
