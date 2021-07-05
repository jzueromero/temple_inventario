<?php
session_start();
if(!isset($_SESSION['usua_codigo']))
{
	header('location:index.php');
}
$formulario_acceso="equi_crud";


require '../src_php/db/funciones_generales.php';
require '../src_php/db/db_funciones.php';

$fgenerales = new funciones_generales();
$objeto_datos = new db_funciones();

$modelo = 'Equivalencia';
$nombre_form = "Equivalencia";
$titulo_form = "Modulo Equivalencia";
$descripcion_form = 'Configuracion de nuevos precios, costos y equivalencias.';
$nombre_negocio = $objeto_datos->empresa;

@$codigo = '';
@$nombre = '';
@$codigo_producto = '';
@$cantidad = '';
@$costo = '';
@$costo_extra = '';
@$costo_total = '';
@$precio = '';
@$fecha = ''; 

$form_donde_regresar="sis_producto_crud.php?codigo=";
@$codigo_producto = $fgenerales->miget('codigo_producto');
@$codigo  = $fgenerales->miget('equivalencia');
if(isset($_GET['equivalencia']) == '0' )
{
    
	@$nombre = '';
	@$cantidad = 0;
	@$costo = 0;
	@$costo_extra = 0;
	@$costo_total = 0;
	@$precio = 0;
}
else
{
    	$consulta_equi = "SELECT equi_codigo codigo, equi_nombre nombre, equi_codigo_producto codigo_producto, 
							equi_cantidad cantidad, equi_costo costo, equi_costo_extra costo_extra, equi_precio precio,
							equi_costo_total costo_total,  equi_fecha fecha
							FROM equi_equivalencia
							where equi_codigo_producto = :codigo
							and equi_codigo = :equi_codigo
							 order by equi_cantidad asc; ";
		$parametros_equi = array(":codigo"=>$codigo_producto,
								":equi_codigo"=>$codigo,);


		$arreglo_datos = $objeto_datos->get_datos($consulta_equi, $parametros_equi);
		foreach ($arreglo_datos as $item) 
		{
			@$nombre = $item['nombre'];
			@$cantidad = $item['cantidad'];
			@$costo = $item['costo'];
			@$costo_extra = $item['costo_extra'];
			@$costo_total  = $item['costo_total'];
			@$precio = $item['precio'];
		}
		

}

if(!empty($fgenerales->mipost('accion')))
		{
			@$codigo = $_POST["codigo"];
			@$nombre = $_POST["nombre"];
			@$cantidad = $_POST["cantidad"];
			@$codigo_producto = $_POST["codigo_producto"];
			@$costo = $_POST["costo_compra"];
			@$costo_extra = $_POST["flete"];
			@$costo_total = $_POST["costo_total"];
			@$precio = $_POST["precio"];
			
			$costo = trim($costo) == '' ? 0: $costo;
			$costo_extra = trim($costo_extra) == '' ? 0: $costo_extra;
			$costo_total = trim($costo_total) == '' ? 0: $costo_total;
			$precio = trim($precio) == '' ? 0: $precio;
			$cantidad = trim($cantidad) == '' ? 0: $cantidad;
	
	
			@$historial_descripcion = "c:$codigo, n: $nombre, c: $costo, cx: $costo_extra, ct: $costo_total, p: $precio, cntdad: $cantidad";

			if($_POST['actualizar_c'] == 1)
			{
				$costo_u = $costo / $cantidad;
				$costo_extra_u = $costo_extra / $cantidad;
				$costo_total_u = $costo_total / $cantidad;

				//actualiza precios
				$consulta_p_e = "UPDATE prod_producto
									SET  prod_costo_compra=:prod_costo_compra, 
									prod_costo_agregado=:prod_costo_agregado, 
									prod_costo_total=:prod_costo_total
								WHERE prod_codigo=:prod_codigo;";
				$parametros_p_e = array(":prod_costo_compra"=>$costo_u,
										":prod_costo_agregado"=>$costo_extra_u,
										":prod_costo_total"=>$costo_total_u,
										":prod_codigo"=>$codigo_producto,
									);	
				$objeto_datos->insert_datos_2($consulta_p_e,$parametros_p_e);
				


				   $consulta_equi = "SELECT equi_codigo codigo, equi_cantidad cantidad
				FROM equi_equivalencia
				where equi_codigo_producto = :codigo; ";
				$parametros_equi = array(":codigo"=>$codigo_producto);							 

				$arreglo_equivalencias = $objeto_datos->get_datos($consulta_equi, $parametros_equi);



				foreach ($arreglo_equivalencias as $equi) {
					if($equi['codigo'] != $codigo)
					{
				$consulta_e = "UPDATE equi_equivalencia
						SET 
						equi_costo= ". $equi['cantidad'] * $costo_u .",
						equi_costo_extra= ".$equi['cantidad'] * $costo_extra_u .",
						equi_costo_total=".$equi['cantidad'] * $costo_total_u ."
						WHERE equi_codigo=".$equi['codigo']."; ";
				$objeto_datos->insert_datos_2($consulta_e, array());
				}
			}
				//actualiza precios
			}



			//guardar
		@$accion = $fgenerales->mipost('accion');

			if ($accion == "nuevo") {

				$consulta = "INSERT INTO equi_equivalencia
							(equi_nombre, equi_codigo_producto, equi_cantidad, equi_costo,
							equi_costo_extra, equi_costo_total, equi_precio, equi_fecha)
							VALUES(:equi_nombre, :equi_codigo_producto, :equi_cantidad, :equi_costo,
							:equi_costo_extra, :equi_costo_total, :equi_precio, CURRENT_TIMESTAMP);";
				$parametros = array(
									":equi_nombre"=>$nombre,
									":equi_codigo_producto"=>$codigo_producto,
									":equi_cantidad"=>$cantidad,
									":equi_costo"=>$costo,
									":equi_costo_extra"=>$costo_extra,
									":equi_costo_total"=>$costo_total,
									":equi_precio"=>$precio,
									);

				$objeto_datos = new db_funciones();

				@$parametros_historial = array(":tabla" => $modelo,
						":descripcion" => "crea, $historial_descripcion",
						":usuario" => $_SESSION['nombre_usuario'],
						":cod_usuario" => $_SESSION['usua_codigo']);
				$objeto_datos->insert_historial($parametros_historial);

				///Guarda la equivalencia nueva					
				$arreglo_datos = $objeto_datos->insert_datos($consulta, $parametros, $form_donde_regresar.$codigo_producto);
				echo $consulta;
				//return;
			}
	//guardar
			//editar
		if ($accion == "modificar") {
			$consulta = "UPDATE equi_equivalencia
						SET equi_nombre=:equi_nombre,
						 equi_cantidad=:equi_cantidad, 
						equi_costo=:equi_costo, equi_costo_extra=:equi_costo_extra, 
						equi_costo_total=:equi_costo_total, equi_precio=:equi_precio, equi_fecha=CURRENT_TIMESTAMP
						WHERE 
						equi_codigo=:equi_codigo
						and 
						equi_codigo_producto=:equi_codigo_producto
						;
						";

			$parametros = array(
				":equi_nombre"=>$nombre,
				":equi_codigo_producto"=>$codigo_producto,
				":equi_codigo"=>$codigo,
				":equi_cantidad"=>$cantidad,
				":equi_costo"=>$costo,
				":equi_costo_extra"=>$costo_extra,
				":equi_costo_total"=>$costo_total,
				":equi_precio"=>$precio,
				);
			$objeto_datos = new db_funciones();

            @$parametros_historial = array(":tabla" => $modelo,
            ":descripcion" => "edita,$historial_descripcion",
            ":usuario" => $_SESSION['nombre_usuario'],
            ":cod_usuario" => $_SESSION['usua_codigo']);

            $objeto_datos->insert_historial($parametros_historial);
			$arreglo_datos = $objeto_datos->insert_datos($consulta, $parametros, $form_donde_regresar.$codigo_producto);
			return;
		}
		//editar
		//eliminar
		
		if ($accion == "eliminar") {
			$consulta = "DELETE FROM equi_equivalencia
                        WHERE equi_codigo=:codigo;";
			$parametros = array(":codigo"=>$codigo);

			$objeto_datos = new db_funciones();

            @$parametros_historial = array(":tabla" => $modelo,
                                    ":descripcion" => "elimina, $historial_descripcion",
                                    ":usuario" => $_SESSION['nombre_usuario'],
                                    ":cod_usuario" => $_SESSION['usua_codigo']);
            $objeto_datos->insert_historial($parametros_historial);
            
			$arreglo_datos = $objeto_datos->insert_datos($consulta, $parametros, $form_donde_regresar.$codigo_producto);
			return;
		}
		//eliminar

		}
		

/*
INSERT INTO equi_equivalencia
(equi_nombre, equi_codigo_producto, equi_cantidad, equi_costo, equi_costo_extra, equi_costo_total, equi_precio, equi_fecha)
VALUES('', 0, 0, 0.0000, 0.0000, 0.0000, 0, CURRENT_TIMESTAMP);
*/

?>

<!doctype html>
<html lang="es">

<head>
	<title><?php echo $titulo_form; ?></title>
	<?php
require 'nav_plantilla/nav_css.php';
?>
<script>

var campos = ["nombre"];

</script>

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
									<form method="POST" id="formulario" action="<?php echo $_SERVER['PHP_SELF']; ?>">
									<div class="row">
										<?php
										//public function caja_texto($id,$titulo, $placeholder, $columnas, $tipo, $habilitado, $requerido, $valor ='')
											$fgenerales->caja_texto('codigo', 'Código', 'Nuevo Código', '2', 'text','0',0,$codigo);
										?>
										<input type="hidden" name="accion" id="accion" value="">
										<input type="hidden" name="codigo_producto" id="codigo_producto" value="<?php echo $codigo_producto; ?>">
										
									</div>
									<div class="row">
										<?php
										////public function caja_texto($id,$titulo, $placeholder, $columnas, $tipo, $habilitado, $requerido, $valor ='')
										@$fgenerales->caja_texto('nombre', 'nombre', 'nombre', '3', 'text','1','1',$nombre);
										//@$fgenerales->caja_texto('codigo_producto', 'codigo_producto', 'codigo_producto', '3', 'text','1','1',$codigo_producto);
										
										
										@$fgenerales->caja_texto('cantidad', 'Numero Unidades', 'cantidad', '3', 'text','1','1',$cantidad);
										?>
									</div>
									<div class="row">
										<?php
										@$fgenerales->caja_texto('costo_compra', 'costo', 'costo', '3', 'text','1','1',$costo);
										@$fgenerales->caja_texto('flete', 'costo extra - Flete', 'costo_extra', '3', 'text','1','1',$costo_extra);
										@$fgenerales->caja_texto('costo_total', 'costo_total', 'costo_total', '3', 'text','0','0',$costo_total);
										?>
									</div>
									<div class="row">
									<?php
										@$fgenerales->caja_texto('precio', 'precio', 'precio', '3', 'text','1','1',$precio);
										$lista_estados = array(
											array("v"=>"0", "t"=>"No actualizar Costo"),
											array("v"=>"1", "t"=>"Actualizar Costo")
										);
										$fgenerales->lista_valores('actualizar_c','Modificar Costo', '4', $lista_estados, "0");
									?>
									</div>
									<div class="form-row">
									<?php
										if($codigo == 0)
										{
											?>
											<button id="btn_nuevo" type="button" class="btn btn-success"><i class="fa fa-check-circle"></i> Crear <?php echo ' '.$nombre_form; ?></button>
											<a href="<?php echo $form_donde_regresar.$codigo_producto; ?>" target="_self" rel="noopener noreferrer"><button id="btn_regresar" type="button" class="btn btn-primary"><i class="fa fa-warning"></i>&nbsp;&nbsp; &nbsp; Regresar &nbsp;&nbsp;</button></a> 
											<?php
										}
										else
										{
											?>
											<button id="btn_modificar" type="button" class="btn btn-success"><i class="fa fa-edit"></i> Editar <?php echo ' '.$nombre_form; ?></button>
											<button id="btn_eliminar" type="button" class="btn btn-danger"><i class="fa fa-trash-o"></i> Borrar <?php echo ' '.$nombre_form; ?></button>
											<a href="<?php echo $form_donde_regresar.$codigo_producto; ?>" target="_self" rel="noopener noreferrer"><button id="btn_regresar" type="button" class="btn btn-primary"><i class="fa fa-warning"></i>&nbsp;&nbsp; &nbsp; Regresar &nbsp;&nbsp;</button></a> 
											<?php
										}
									?>
									
									<div class="row">
										<br >
									</div>
									
									</div>


									
									</div>
									</form>
									
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
