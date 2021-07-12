<?php
session_start();
if(!isset($_SESSION['usua_codigo']))
{
	header('location:index.php');
}
require '../src_php/db/db_funciones.php';
$objeto_datos = new db_funciones();

$modelo = 'Unidades';
$nombre_form = "sis_movimiento";
$titulo_form = "Modulo unidades";
$descripcion_form = 'Configuracion de unidades para las equivalencias.';
$nombre_negocio = $objeto_datos->empresa;

@$q = "";
@$desde = "";
@$hasta = "";

if(!isset($_GET['q']) and !isset($_GET['desde']) and !isset($_GET['hasta']))
{
    $q = "";
    $fecha_hoy = $dram =  new DateTime();
    $desde  = $fecha_hoy->format('Y-m-d');
    $hasta = $desde;

    header("location:$nombre_form.php?desde=".$desde."&hasta=".$hasta."&q=$q");
}

$q = $_GET['q'];
$desde = $_GET['desde'];
$hasta = $_GET['hasta'];



$consulta = "SELECT  tran_codigo codigo, tran_codigo_temporal temporal, tran_sucursal_codigo sucursal_codigo, 
			tran_tipo tipo, tran_estado, tran_codigo_concepto, tran_nombre_concepto concepto, 
			tran_referencia, tran_comentario, tran_usuario, tran_fecha
            FROM tran_transaccion
            where 
            ( tran_nombre_concepto like '%".$q."%')
            and
            DATE(tran_fecha) >= '".$desde."' and DATE(tran_fecha) <= '".$hasta."'
            order by tran_codigo;";


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
                                    <form action="sis_movimiento.php" method="get">
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
                                        <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="busqueda">Busqueda</label>
                                            <input type="text" class="form-control" value="<?php echo $q; ?>" name="q" id="q" placeholder="Nombre cliente, proveedor, concepto">
                                        </div>
                                        </div>
                                        <div class="col-md-2">
                                        <div class="form-group">
                                        <br>
                                        <button type="submit" class="btn btn-primary btn-block">Buscar</button>
                                        </div>


                                        </div>

                                        <div class="col-md-2">
                                        </div>
									</div>
                                    </form>
									<div class="row">
									<table class="table table-hover">
										<thead>
											<tr>
												<th>#</th>
                                                <th>Tipo</th>
												<th>Sucursal</th>
												<th>Concepto</th>
                                                <th>Estado</th>
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
															<?php 

                                                            $tipo = $item["tipo"] == 0 ? "<h5><span class='label label-danger'>S A L I D A</span></h5>" : "<h5><span class='label label-success'>E N T R A D A</span></h5>" ; 
                                                            echo  $tipo; ?>
														</td>
                                                        <td>
															<?php 
                                                            $sucu = $item["sucursal_codigo"];
															if($sucu == 2 )
															{
																echo SS2_n;
															}
															if($sucu == 3 )
															{
																echo SS3_n;
															}
															if($sucu == 4 )
															{
																echo SS4_n;
															}
															if($sucu == 5 )
															{
																echo SS5_n;
															}
															else
															{
																echo SS1_n;
															}
															?>
														</td>
                                                        <td>
															<?php echo $item["concepto"]; ?>
														</td>
                                                        <td>
															<?php
                                                            $estado = "";
                                                            switch ($item["tran_estado"]) {
                                                                case '1':
                                                                    $estado = "Procesado";
                                                                    break;
                                                                case '2':
                                                                    $estado = "Anulado";
                                                                    break;
                                                                default:
                                                                    $estado = "<h4><span class='label label-warning'>Temporal</span></h4>";
                                                                    break;
                                                            }
                                                            echo $estado; ?>
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
