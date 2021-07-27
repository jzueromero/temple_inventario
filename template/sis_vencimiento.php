<?php
session_start();
if(!isset($_SESSION['usua_codigo']))
{
	header('location:index.php');
}

$formulario_acceso="Lote Vencimiento";


require '../src_php/db/db_funciones.php';
$objeto_datos = new db_funciones();

$modelo = 'Lote Vencimiento';
$nombre_form = "sis_vencimiento";
$titulo_form = "Modulo unidades";
$descripcion_form = 'Configuracion de unidades para las equivalencias.';
$nombre_negocio = $objeto_datos->empresa;

@$q = "";

if(isset($_GET['q']) and $_GET['q'] != '' )
{
    @$q = $_GET['q'];
    $consulta = "select vv.venc_codigo codigo, vv.venc_lote lote,
                    vv.venc_cantidad cantidad, vv.venc_cantidad_restante restante, 
                    venc_fecha_vencimiento vence,
                    pp.prod_codigo_barra barra, pp.prod_codigo, pp.prod_nombre, ll.labo_nombre, pp2.prov_nombre ,
                    
                    datediff(venc_fecha_vencimiento, curdate() ) restan,
                    date_add(curdate(), interval 15 day) calculo
                    , ss.sucu_codigo , ss.sucu_nombre 
                from venc_vencimiento vv 
                inner join prod_producto pp on pp.prod_codigo = vv.venc_producto_codigo 
                left join prov_proveedor pp2 on pp2.prov_codigo  = pp.prod_cod_proveedor 
                left join labo_laboratorio ll on ll.labo_codigo = pp.prod_cod_laboratorio 
                inner join sucu_sucursal ss  on ss.sucu_codigo = vv.venc_sucursal 
                where 
                vv.venc_cantidad_restante  > 0 and
                prod_codigo_barra like '%$q%'
                or prod_nombre like '%$q%'
                or prod_descripcion like '%$q%'

                order by vv.venc_fecha_vencimiento ";
            }
            else
            {
                $consulta = "select vv.venc_codigo codigo, vv.venc_lote lote,
                vv.venc_cantidad cantidad, vv.venc_cantidad_restante restante, 
                venc_fecha_vencimiento vence,
                pp.prod_codigo_barra barra, pp.prod_codigo, pp.prod_nombre, ll.labo_nombre, pp2.prov_nombre ,
                
                datediff(venc_fecha_vencimiento, curdate() ) restan,
                date_add(curdate(), interval 15 day) calculo
                , ss.sucu_codigo , ss.sucu_nombre 
            from venc_vencimiento vv 
            inner join prod_producto pp on pp.prod_codigo = vv.venc_producto_codigo 
            left join prov_proveedor pp2 on pp2.prov_codigo  = pp.prod_cod_proveedor 
            left join labo_laboratorio ll on ll.labo_codigo = pp.prod_cod_laboratorio 
            inner join sucu_sucursal ss  on ss.sucu_codigo = vv.venc_sucursal 
            where 
                vv.venc_cantidad_restante  > 0 
                order by vv.venc_fecha_vencimiento ;
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
												<th>Código</th>
												<th>Producto</th>
												<th>Lote</th>
												<th>Cantidad Lote</th>
												<th>Cantidad Restante</th>
												<th>Fecha Vencimiento</th>
												<th>Sucursal</th>

												<th></th>


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
															<?php echo $item["prod_nombre"]; ?>
														</td>
														<td>
															<?php echo $item["lote"]; ?>
														</td>
                                                        <td>
															<?php echo $item["cantidad"]; ?>
														</td>
                                                        <td>
															<?php echo $item["restante"]; ?>
														</td>
                                                        <td>
                                                        <?php
                                                            @$etiqueta = "info";
                                                            @$comentario = "";
                                                            if($item["restan"] > 15)
                                                            {
                                                                @$etiqueta = "info";
                                                                @$comentario = " Faltan: ";
                                                            }
                                                            if($item["restan"] <= 15)
                                                            {
                                                                @$etiqueta = "warning";
                                                                @$comentario = " Faltan: ";
                                                            }
                                                            if($item["restan"] < 0)
                                                            {
                                                                @$etiqueta = "danger";     
                                                                @$comentario = " Hace: ";                                                        
                                                            }
                                                            
                                                            
                                                            ?>
                                                            <span class="label label-<?php echo $etiqueta; ?>"><?php echo $item["vence"].@$comentario.$item["restan"]." dias"; ?></span>
															<?php //echo $item["vence"]; ?>
														</td>
                                                        <td>
															<?php echo $item["sucu_nombre"]; ?>
														</td>
                                                        <td>
														<a href='sis_lote.php?lote=<?php echo $item["codigo"]."&codigo_producto=".$item["prod_codigo"]; ?>'><i class="lnr lnr-cog"></i> <span>&nbsp;&nbsp;Configuración&nbsp;&nbsp;</span></a>
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
