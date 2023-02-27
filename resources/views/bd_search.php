<?php

include('conn.php');

$campo = $_POST['datos'];

$query = $con->query("SELECT * FROM fotos where id_cleinte LIKE '%$campo%' OR presinto LIKE '%$campo%'");

$html = "";


while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
  
    $html .= "
    <img src='../img/" . $row['ruta_archivo'] . "'>
    <div class='caption' style='text-align: center;'>
        <h3>Cliente:" . $row['id_cliente'] . "</h3>
        <h4>Presinto:" . $row['presinto'] . "</h4>
        <p>Fecha:" . $row['fecha_foto'] . " </p>
        </div>";
}

echo json_encode($html, JSON_UNESCAPED_UNICODE);
