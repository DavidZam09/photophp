<?php

$id = $_POST['id'];
include_once('conn.php');
// Preparar la consulta SQL y ejecutarla
$stmt = $con->query("SELECT * FROM fotos WHERE id = $id");

// Obtener los resultados de la consulta y devolverlos en formato JSON
if ($row = $stmt->fetchObject()) {
    echo json_encode(array("titulo" => $row->id_cliente, "precinto" => $row->presinto, "fecha" => $row->fecha_foto, "imagen" => $row->ruta_archivo));
} else {
    echo json_encode(array("error" => "No se encontró el artículo"));
}
