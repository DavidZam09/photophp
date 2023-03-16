<?php

$id = $_POST['id'];
include_once('conn.php');

$stmt = $con->query("SELECT * FROM fotos WHERE id = $id");

if ($row = $stmt->fetchObject()) {
    echo json_encode(array("titulo" => $row->cliente, "precinto" => $row->presinto, "fecha" => $row->fecha_foto, "imagen" => $row->ruta_archivo));
} else {
    echo json_encode(array("error" => "No se encontró el artículo"));
}
?>
