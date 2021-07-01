<?php
    session_start();
    if(!isset($_SESSION['usua_codigo']))
    {
        header('location:index.php');
    }

$modelo = 'menu o catalogos';
$nombre_form = "sis_menu";
$titulo_form = "Menus o Catalogos";
$descripcion_form = 'Aqui se catalogan o seccionan los comercios y afiliados de un comercio en especifico.';
$nombre_negocio = "BiciMandados Sv - Zona Administrativa";
@$numero_menu = 0;

@$cod_comercio = $_GET['comercio'];
@$nombre_comercio = '';
require '../src_php/db/db_funciones.php';
$consulta = "select menu_codigo  codigo, menu_nombre nombre,menu_descripcion descripcion ,come_nombre comercio, menu_imagen imagen
			,count( prod_nombre) productos
			from menu_menu 
			inner join come_comercio on come_codigo  = menu_comercio 
			left join prod_producto on prod_cod_menu = menu_codigo 
			where menu_comercio = ".@$cod_comercio." "."
			group  by menu_codigo ;";

@$consulta_comercio = "select come_nombre comercio from come_comercio
					where come_codigo = ".@$cod_comercio;			
@$consulta_cuantos_menu = "select count(menu_codigo) valor from menu_menu where menu_comercio  =".$cod_comercio;
					

$objeto_datos = new db_funciones();
$nombre_comercio = $objeto_datos->get_dato_escalar($consulta_comercio, array());
$numero_menu = $objeto_datos->get_dato_escalar($consulta_cuantos_menu,array());
$arreglo_datos = $objeto_datos->get_datos($consulta,array());

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
									
										<h3 ><?php echo $nombre_comercio;  ?></h3>

									<h3 class="panel-title"><?php echo $titulo_form; ?></h3>
									<p class="panel-subtitle"><?php echo $descripcion_form; ?></p>
								</div>
								<div class="panel-body no-padding">
									<div class="col-md-12">
									<div class="row">
										<div class="col-md-10"></div>
										<div class="col-md-2 text-right">

										<a href='<?php echo $nombre_form; ?>_crud.php?codigo=0&comercio=<?php echo $cod_comercio; ?>'>
										<p>
										<button type="button" class="btn btn-primary btn-md btn-block">Crear <?php echo $modelo; ?></button>
										</p>
										</a>
										<?php if($numero_menu > 0)
											{
												?>
												<a href='sis_producto_crud.php?producto=0&comercio=<?php echo $cod_comercio; ?>'>
												<p>
												<button type="button" class="btn btn-info btn-md btn-block">Crear Producto</button>
												</p>
										</a>
												<?php
											}
										
										?>	
										</div>

									</div>
									<div class="row">
									<table class="table table-hover table-condensed">
										<thead>
											<tr>
												<th>#</th>
												<th>Nombre</th>
                                                <th>Descripcion</th>
												<th>Precio interno</th>
												<th>Precio Publico</th>
												<th>Opciones</th>
											</tr>
										</thead>
										<tbody>
												<?php
													foreach ($arreglo_datos as $item) {
														?>
													<tr class="thead-dark bg-info">
														<td>
															<?php echo $item["codigo"]; ?>
															<img src="assets/img/app/menu/min_<?php echo $item["imagen"]; ?>" alt=" ">
														</td>

														<td>
															<?php echo $item["nombre"]; ?>
														</td>
                                                        <td colspan="3">
															<?php echo $item["descripcion"]; ?>
														</td>
                                                        <td class="bg-default">
														<a href='<?php echo $nombre_form; ?>_crud.php?codigo=<?php echo $item["codigo"]; ?>&comercio=<?php echo $cod_comercio; ?>'> <button class="bn btn-default"><i class="lnr lnr-cog"><span>&nbsp;&nbsp;Configuración&nbsp;&nbsp;</span></i></button>  </a>
                                                        <br>
                                                    </td>
													</tr>
														
													<?php
															if($item['productos'] > 0)
															{
																@$consulta_detalle_productos = "select prod_codigo codigo, prod_nombre nombre, prod_precio_interno p1, prod_imagen imagen,
																								if (prod_precio_externo is null, 0, prod_precio_externo) p2
																								from prod_producto where prod_cod_menu = ". $item["codigo"];;
																@$arreglo_detalle_productos = $objeto_datos->get_datos($consulta_detalle_productos, array());
																foreach ($arreglo_detalle_productos as $itemdetalle) {
																	?>
																	<tr class="">
																		<td class="text-right" >
																			<?php //echo $itemdetalle["codigo"]; ?>
																			<img src="assets/img/app/productos/min_<?php echo $itemdetalle["imagen"]; ?>" alt=" ">
																		</td>

																		<td colspan="2">
																			<?php echo $itemdetalle["nombre"]; ?>
																		</td>
																		<td>
																			<?php echo "Interno: $".$itemdetalle["p1"]; ?>
																		</td>
																		<td>
																			<?php echo " Publico $".$itemdetalle["p1"]; ?>
																		</td>
																		<td>

																			<a href='sis_producto_crud.php?producto=<?php echo $itemdetalle["codigo"]; ?>&comercio=<?php echo $cod_comercio; ?>'><i class="lnr lnr-coffee-cup"></i> <span>&nbsp;&nbsp;Editar&nbsp;&nbsp;</span></a>	
																			
																		</td>
																	</tr>
																	<?php
																}
															}
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
