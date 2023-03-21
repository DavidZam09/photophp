<?php
include('conn.php');

$campo = $_GET['campo'];
$filter = $_GET['filter'];
$html = "";
$query = "";
$result = "";
if (empty($campo)) {
    $html = "No campo";
    // $query = "SELECT * FROM fotos where `cliente` LIKE '%$campo%' OR `presinto` LIKE '%$campo%' ORDER BY '%$filter%' ASC";
} else {

    if ($filter == '') {

        $query = "SELECT * FROM fotos where `cliente` LIKE '%$campo%' OR `presinto` LIKE '%$campo%' ORDER BY id  DESC";
        $result = $con->query($query);

        while ($row = $result->fetchObject()) {
            $id_slide = $row->id;
            $cliente = $row->cliente;
            $presinto = $row->presinto;
            $fecha = $row->fecha_foto;
            $url_image = $row->ruta_archivo;

            $html .= "<div class='col-sm-6 col-md-3'>";
            $html .= "<div class='thumbnail'>";
            $html .= "<img src='../img/$url_image '>";
            $html .= "<div class='caption' style='text-align: center;'>";
            $html .= "<h3>Cliente: $cliente</h3>";
            $html .= "<h4>Precinto:$presinto </h4>";
            $html .= "<p>Fecha: $fecha </p>";
            $html .= "<button type='button' class='btn btn-primary' onclick='mostrarModal($row->id)'><i class='glyphicon glyphicon-eye-open'></i> ver</button>";
            $html .= "</div>";
            $html .= "</div>";
            $html .= "</div>";
        }
    } else {
        $query = "SELECT * FROM fotos where `cliente` LIKE '%$campo%' OR `presinto` LIKE '%$campo%' ORDER BY '%$filter%' ASC";
        $result = $con->query($query);

        while ($row = $result->fetchObject()) {
            $id_slide = $row->id;
            $cliente = $row->cliente;
            $presinto = $row->presinto;
            $fecha = $row->fecha_foto;
            $url_image = $row->ruta_archivo;

            $html .= "<div class='col-sm-6 col-md-3'>";
            $html .= "<div class='thumbnail'>";
            $html .= "<img src='../img/$url_image '>";
            $html .= "<div class='caption' style='text-align: center;'>";
            $html .= "<h3>Cliente: $cliente</h3>";
            $html .= "<h4>Precinto:$presinto </h4>";
            $html .= "<p>Fecha: $fecha </p>";
            $html .= "<button type='button' class='btn btn-primary' onclick='mostrarModal($row->id)'><i class='glyphicon glyphicon-eye-open'></i> ver</button>";
            $html .= "</div>";
            $html .= "</div>";
            $html .= "</div>";
        }
    }
}

echo $html;
