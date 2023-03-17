<?php
include('conn.php');

$campo = $_POST['campo'];
$filter = $_POST['filter'];

$html = [];

$query = $con->query("SELECT * FROM fotos where `cliente` LIKE '%$campo%' OR `presinto` LIKE '%$campo%' ORDER BY '%$filter%'  DESC");
if ($query == null) {



    $html = "<div id='alert'>
                <div class='thumbnail'>
                    <img src='https://png.pngitem.com/pimgs/s/52-524972_sad-negro-signo-simbolo-carita-triste-emoticon-positive.png'>
                </div>
                <div class='caption'>
                    <label>No hay Diseños con este precinto o nombre de cliente, Intenta Buscar de Nuevo</label>
                </div>
            </div>";
} else {
    while ($row = $query->fetchObject()) {
        $id_slide = $row->id;
        $cliente = $row->cliente;
        $presinto = $row->presinto;
        $fecha = $row->fecha_foto;
        $url_image = $row->ruta_archivo;


        $html = "<div class='col-sm-6 col-md-3'>
        <div class='thumbnail'>
           <img src='../img/$url_image '>
            <div class='caption' style='text-align: center;'>
                <h3>Cliente: $cliente</h3>
                <h4>Precinto:$presinto </h4>
                <p>Fecha: $fecha </p>
                <button type='button' class='btn btn-primary' onclick='mostrarModal($row->id)'>
                    <i class='glyphicon glyphicon-eye-open'></i> ver</button>
            </div>
        </div>
    </div>";
    echo json_encode($html, JSON_UNESCAPED_UNICODE);
    }

}

