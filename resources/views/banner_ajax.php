<?php
session_start();
/* Llamar la Cadena de Conexion*/
include("conn.php");
$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';
if ($action == 'ajax') {
	//Elimino producto
	if (isset($_REQUEST['id'])) {
		$id_banner = intval($_REQUEST['id']);
		if ($delete = $con->prepare("delete from fotos where id='$id_banner'")) {
			$delete->execute();
			echo 1;
			$message = "Datos eliminados satisfactoriamente";
		} else {
			$error = "No se pudo eliminar los datos";
		}
	}


	$tables = "fotos";
	$sWhere = " ";
	$sWhere .= " ";


	$sWhere .= " order by id";
	include 'pagination.php'; //include pagination file
	//pagination variables
	$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
	$per_page = 12; //how much records you want to show
	$adjacents  = 4; //gap between pages after number of adjacents
	$offset = ($page - 1) * $per_page;

	//Count the total number of row in your table*/
	include_once('conn.php');
	$count_query  = $con->prepare("SELECT count(*) AS numrows FROM $tables  $sWhere ");
	$count_query->execute();
	if ($count_query != null) {
		$row = $count_query->fetch(PDO::FETCH_OBJ);
		$row->numrows = intval($row->numrows);
		$numrows = $row->numrows;
	} else {
		echo $con . error_log(1);
	}
	$total_pages = ceil($numrows / $per_page);
	$reload = './welcome.blade.php';
	//main query to fetch the data
	$query = $con->prepare("SELECT * FROM  $tables  $sWhere LIMIT $offset,$per_page");


	if (isset($message)) {
?>
		<div class="alert alert-success alert-dismissible fade in" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
			<strong>Aviso!</strong> <?php echo $message; ?>
		</div>

	<?php
	}
	if (isset($error)) {
	?>
		<div class="alert alert-danger alert-dismissible fade in" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
			<strong>Error!</strong> <?php echo $error; ?>
		</div>

	<?php
	}
	//loop through fetched data
	if ($numrows > 0) {
	?>

		<div class="row">
			<?php
			while ($row = $query) {
				$row = $query->fetch(PDO::FETCH_OBJ);
				$url_image = $row['ruta_archivo'];
				$cliente = $row['id_cliente'];
				$presinto = $row['presinto'];
				$fecha = $row['fecha_foto'];
				$id_slide = $row['id'];

			?>

				<div class="col-sm-6 col-md-3">
					<div class="thumbnail">
						<img src="../img/banner/<?php echo $url_image; ?>" alt="...">
						<div class="caption">
							<h3><?php echo $cliente; ?></h3>

							<p class='text-right'><a href="banneredit.php?id=<?php echo intval($id_slide); ?>" class="btn btn-info" role="button"><i class='glyphicon glyphicon-edit'></i> Editar</a> <button type="button" class="btn btn-danger" onclick="eliminar_slide('<?php echo $id_slide; ?>');" role="button"><i class='glyphicon glyphicon-trash'></i> Eliminar</button></p>
						</div>
					</div>
				</div>

			<?php
			}
			?>
		</div>

		<div class="table-pagination text-right">

			<?php echo paginate($reload, $page, $total_pages, $adjacents); ?>
		</div>
<?php
	}
}
?>