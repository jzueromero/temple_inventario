<?php
session_start();
if(!isset($_SESSION['usua_codigo']))
{
	header('location:index.php');
}
$formulario_acceso="prod";

require '../src_php/db/db_funciones.php';
$objeto_datos = new db_funciones();

$modelo = 'producto';
$nombre_form = "sis_producto";
$titulo_form = "Modulo Producto";
$descripcion_form = 'Configuracion de productos, costos, precios y existencias.';
$nombre_negocio = $objeto_datos->empresa;

if(isset($_GET['q']) and $_GET['q'] != '' )
{
    @$q = $_GET['q'];
    $consulta = "SELECT prod_codigo codigo, prod_codigo_barra barra, prod_nombre nombre, prod_descripcion descripcion,
                    prod_existencia existencia, prod_unidad unidad, prod_costo_compra costo_compra, prod_costo_agregado flete,
                    prod_costo_total costo_total, prod_precio precio,prod_cod_laboratorio laboratorio, prod_cod_proveedor proveedor,
                    prod_fecha fecha
                FROM prod_producto
                where prod_codigo_barra like '%$q%'
                or prod_nombre like '%$q%'
                or prod_descripcion like '%$q%'
                order by prod_nombre, prod_codigo_barra; ";
}
else
{
    $consulta = "SELECT prod_codigo codigo, prod_codigo_barra barra, prod_nombre nombre, prod_descripcion descripcion,
                        prod_existencia existencia, prod_unidad unidad, prod_costo_compra costo_compra, prod_costo_agregado flete,
                        prod_costo_total costo_total, prod_precio precio,prod_cod_laboratorio laboratorio, prod_cod_proveedor proveedor,
                        prod_fecha fecha
                FROM prod_producto
                order by prod_nombre, prod_codigo_barra;
        ";

}




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
										<div class="col-md-6 text-left">
                                        <div class="form-group text-left">
                                        <form action="sis_producto.php" method="get">
                                        <div class="col-md-9 text-left">
                                        <input class="form-control" type="text" name="q" id="q">
                                        </div>
                                        <div class="col-md-3 text-left">
                                        <span class="input-group-btn"><input type="submit" class="btn btn-primary" type="button" value="Buscar"></span>
                                        </div>
                                            
                                        </form>
                                            
                                        </div>
                                        </div>
                                        <div class="col-md-2">
                                        </div>
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
												<th>Cod. Barra</th>
												<th>Nombre</th>
                                                <th>Existencia</th>
                                                <th>Unidad</th>
                                                <th>Costo Final</th>
                                                <th>Precio</th>
                                                
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
															<?php echo $item["barra"]; ?>
														</td>

                                                        <td>
															<?php echo $item["nombre"]; ?>
														</td>
                                                        <td>
															<?php echo $item["existencia"]; ?>
														</td>
                                                        <td>
															<?php echo $item["unidad"]; ?>
														</td>
                                                        <td>
															<?php echo $item["costo_total"]; ?>
														</td>
                                                        <td>
															<?php echo $item["precio"]; ?>
														</td>
                                                       
                                                        <td>
														<a href='<?php echo $nombre_form; ?>_crud.php?codigo=<?php echo $item["codigo"]; ?>'><i class="lnr lnr-cog"></i> <span>&nbsp;&nbsp;Configuración&nbsp;&nbsp;</span></a>
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
