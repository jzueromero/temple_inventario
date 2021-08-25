<?php
session_start();
if(!isset($_SESSION['usua_codigo']))
{
	header('location:index.php');
}
require '../src_php/db/db_funciones.php';
$objeto_datos = new db_funciones();

$modelo = 'Unidades';
$nombre_form = "sis_venta";
$titulo_form = "Modulo unidades";
$descripcion_form = 'Configuracion de unidades para las equivalencias.';
$nombre_negocio = $objeto_datos->empresa;

@$q = "";
@$desde = "";
@$hasta = "";
$tipo = "";
@$total = 0.00;
if(!isset($_GET['q']) and !isset($_GET['desde']) and !isset($_GET['hasta']))
{
    $q = "";
    $fecha_hoy = $dram =  new DateTime();
    $desde  = $fecha_hoy->format('Y-m-d');
    $hasta = $desde;

    header("location:$nombre_form.php?desde=".$desde."&hasta=".$hasta ."&s=vent_estado" . "&q=$q");
}

$q = $_GET['q'];
$desde = $_GET['desde'];
$hasta = $_GET['hasta'];

$tipo = trim($_GET['s']);

if($tipo == "PROCESADO" || $tipo =="ANULADO" || $tipo =="COMANDA")
{
    $tipo = " = '".$tipo."'";
}
else if($tipo == "TODOS")
{
    $tipo = " != 'TEMPORAL'";
}
else {
    $tipo = " != 'TEMPORAL'";
}


$consulta = "SELECT vent_codigo, vent_codigo_temporal, vent_serie,
            vent_correlativo, vent_comanda, vent_sucursal_codigo,
            vent_estado, vent_referencia, vent_comentario, 
            vent_usuario, DATE(vent_fecha) vent_fecha, vent_fecha_anula, vent_usuario_anula, vent_total
            FROM vent_venta
            WHERE 
            vent_sucursal_codigo = ".$_SESSION['venta_sucursal']."
            and
            DATE(vent_fecha) >= '".$desde."' and DATE(vent_fecha) <= '".$hasta."'
            and
             trim(vent_estado) ".$tipo."
            ORDER BY vent_correlativo
            ;";
            
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
									<div class=" row">
                                    <form action="sis_venta.php" method="get">
									<div class="form-group col-sm-2  col-md-2">
                                            <label for="sel1">Tipo:</label>
                                            <select class="form-control" id="s" name="s">
                                                <option value="TODOS">-- Todos</option>
                                                <option value="COMANDA">COMANDA</option>
                                                <option value="PROCESADO">PROCESADO</option>
                                                <option value="ANULADO">ANULADO</option>
                                            </select>
                                        </div>

										<div class="col-md-2">
                                        <div class="form-group">
                                            <label for="desde">desde</label>
                                            <input type="date" class="form-control" value="<?php echo $desde; ?>" name="desde" id="desde" placeholder="desde">
                                        </div>
                                        </div>

                                        <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="hasta">hasta</label>
                                            <input type="date" class="form-control" value="<?php echo $hasta; ?>" name="hasta" id="hasta" placeholder="hasta">
                                        </div>
                                        </div>

                                        <div class="col-md-2">
                                        <div class="form-group">
                                        <br>
                                        <button type="submit" class="btn btn-primary btn-block">Buscar</button>
                                        
                                        </div>


                                        </div>

                                        <div class="col-md-2">
                                        <br >
                                        <a href="./ventas/index.php?codigo_tran=0"> 
                                            <button type="button" class="btn btn-info btn-block">NUEVA VENTA</button>
                                        </a>
                                        </div>
									</div>
                                    </form>
									<div class="row">
									<table class="table table-hover">
										<thead>
											<tr>
												<th>Fecha</th>
                                                <th>Venta</th>
                                                <th>Comanda</th>
												<th>Estado</th>
                                                <th>Total</th>
                                                <th>Opciones</th>
											</tr>
										</thead>
										<tbody>
												<?php
													foreach ($arreglo_datos as $item) {
														?>
													<tr>
														<td>

															<?php echo $item["vent_fecha"]; ?>
														</td>

														<td>
															<?php  echo $item["vent_correlativo"]; ?>
                                                            
														</td>
														<td>
															<?php  echo $item["vent_comanda"]; ?>
                                                            
														</td>
                                                        <td>
															<?php  echo $item["vent_estado"]; ?>
                                                            
														</td>
                                                        <td>
															<?php  echo "$ ".number_format((float)$item["vent_total"], 2, '.', '') ; ?>
                                                            
														</td>
                                                        
                                                        <td>
														<a href='<?php echo $nombre_form; ?>_crud.php?codigo=<?php echo $item["vent_codigo"]."&desde=".$desde."&hasta=".$hasta ."&s=0" . "&q=$q" ?>'><i class="lnr lnr-cog"></i> <span>&nbsp;&nbsp;Configuración&nbsp;&nbsp;</span></a>
														</td>
													</tr>
													<?php
													if(($item["vent_estado"]) == "PROCESADO")
													{
														$total = $total + number_format((float)$item["vent_total"], 2, '.', '');
													}
													
                                                        }
                                                        ?>
														<tr>
															<td colspan="4"></td>
															<td colspan="1">Total $<?php echo $total; ?></td>
															<td colspan="1"></td>

														</tr>
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
