<?php
    session_start();
    if(!isset($_SESSION['usua_codigo']))
    {
        header('location:index.php');
    }


$modelo = 'empresas, comercios y afiliados';
$nombre_form = "sis_comercio";
$titulo_form = "Gestion Empresas, Comercios y Afiliados";
$descripcion_form = 'Modulo para crear y administrar los comercios, emprendimientos, afiliados y demas serivios que ofrescamos';
$nombre_negocio = "BiciMandados Sv - Zona Administrativa";

require '../src_php/db/db_funciones.php';
$consulta = "select come_codigo  as codigo, come_nombre nombre, come_horario_apertura h_apertura, come_horario_cierre h_cierre, 
			come_tipo_comercio tcodigo, tcome_nombre tnombre, come_telefono telefono,
			come_direccion as direccion, come_responsable responsable, come_orden orden,
			come_imagen imagen, come_fecha fecha
			from come_comercio
			left join tipo_come_comercio on tcome_codigo  = come_tipo_comercio 
			 order by come_nombre";

$objeto_datos = new db_funciones();
$arreglo_datos = $objeto_datos->get_datos($consulta, array());

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
												<th>Empresa</th>
												<th>Direccion</th>
												<th>Responsable</th>
												<th>Telefono</th>
												<th>Tipo Comercio</th>
											</tr>
										</thead>
										<tbody>
												<?php
													foreach ($arreglo_datos as $item) {
														?>
													<tr>
														<td>
															<?php echo $item["codigo"]; ?>
															<img src="assets/img/app/empresas/min_<?php echo $item["imagen"]; ?>" alt="">
														</td>

														<td>
															<?php echo $item["nombre"]; ?>
														</td>

														<td>
															<?php echo $item["direccion"]; ?>
														</td>

														<td>
															<?php echo $item["responsable"]; ?>
														</td>

														<td>
															<?php echo $item["telefono"]; ?>
														</td>
														<td>
															<?php echo $item["tnombre"]; ?>
														</td>
														<td>
														<a href='<?php echo $nombre_form; ?>_crud.php?codigo=<?php echo $item["codigo"]; ?>'><i class="lnr lnr-cog"></i> <span>&nbsp;&nbsp;Editar Empresa&nbsp;&nbsp;</span></a>
														<br>
														<a href='sis_menu.php?comercio=<?php echo $item["codigo"]; ?>'><i class="lnr lnr-cart"></i> <span>&nbsp;&nbsp;Gestion Menu y Productos&nbsp;&nbsp;</span></a>
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
