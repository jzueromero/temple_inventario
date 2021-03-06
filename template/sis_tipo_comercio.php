<?php
session_start();
if(!isset($_SESSION['usua_codigo']))
{
	header('location:index.php');
}

$modelo = 'tipo comercio';
$nombre_form = "sis_tipo_comercio";
$titulo_form = "Conf. Tipos Comercios";
$descripcion_form = 'Aqui se catalogan o seccionan los comercios y afiliados.';
$nombre_negocio = "BiciMandados Sv - Zona Administrativa";

require '../src_php/db/db_funciones.php';
$consulta = "select tcome_codigo  as codigo, tcome_nombre as nombre from tipo_come_comercio order by tcome_nombre ";

$objeto_datos = new db_funciones();
$parametros = array();
$arreglo_datos = $objeto_datos->get_datos($consulta, $parametros);

?>

<!doctype html>
<html lang="es">

<head>
	<title><?php echo $titulo_form; ?></title>
	<?php
require 'nav_plantilla/nav_css.php';
?>


</head>

<body>
	<!-- WRAPPER -->
	<div id="wrapper">
		<!-- NAVBAR -->
		<nav class="navbar navbar-default navbar-fixed-top">
		<?php
require 'nav_plantilla/nav_top.php';
?>
		</nav>
		<div class="clearfix"></div>-->
		<!-- LEFT SIDEBAR -->
		<?php
require 'nav_plantilla/menu_left.php';
?>
		<!-- END LEFT SIDEBAR -->
		<!-- MAIN -->
		<div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="container-fluid">
				<!-- Zona Formularios -->


				<div class="panel">
				<div class="panel-heading">
									<h3 class="panel-title"><?php echo $titulo_form; ?></h3>
									<p class="panel-subtitle"><?php echo $descripcion_form; ?></p>
								</div>
								<div class="panel-body no-padding">
									<div class="col-md-12">
									<div class="row">
										<div class="col-md-8"></div>
										<div class="col-md-4 text-right">
										<a href='<?php echo $nombre_form; ?>_crud.php?codigo=0'>
										<p>
										<button type="button" class="btn btn-default">Crear <?php echo $modelo; ?></button>
										</p>
										</a>
										</div>

									</div>
										<div class="row">
											<table class="table table-hover">
												<thead>
													<tr>
														<th>#</th>
														<th>Nombre</th>
														<th>Opciones</th>
													</tr>
												</thead>
												<tbody>
														<?php
															foreach ($arreglo_datos as $item) {
																?>
															<tr>
																<td>
																	<?php echo $item["codigo"]; ?>
																</td>

																<td>
																	<?php echo $item["nombre"]; ?>
																</td>
																<td>
																<a href='<?php echo $nombre_form; ?>_crud.php?codigo=<?php echo $item["codigo"]; ?>'><i class="lnr lnr-cog"></i> <span>&nbsp;&nbsp;Configuraci??n&nbsp;&nbsp;</span></a>
																</td>
															</tr>


															<?php
																}

																?>
												</tbody>
											</table>
										</div>
									</div>


								</div>
							</div>

				<!-- Zona Formularios -->
				</div>
			</div>
			<!-- END MAIN CONTENT -->
		</div>
		<!-- END MAIN -->
		<div class="clearfix"></div>
		<footer>
			<?php
require 'nav_plantilla/nav_footer.php';
?>
		</footer>
	</div>
	<!-- END WRAPPER -->
	<!-- Javascript -->
	<?php
require 'nav_plantilla/nav_js.php';
?>

</body>

</html>
