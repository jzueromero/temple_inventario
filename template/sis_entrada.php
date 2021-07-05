<?php
     session_start();
	 if(!isset($_SESSION['usua_codigo']))
	 {
		 header('location:index.php');
	 }

	 @$formulario_permiso = "unidad_crud";

     require '../src_php/db/db_funciones.php';
     require '../src_php/db/funciones_generales.php';
     $fgenerales = new funciones_generales();     
     $objeto_datos= new db_funciones(); 

	$modelo = 'SALIDA DE PRODUCTO';
	$nombre_form = "SALIDA DE PRODUCTO";
	$form_donde_regresar =  "sis_unidad.php";
	$titulo_form = "Modulo unidad";
	$descripcion_form = 'Modulo unidades que se usaran en el apartado de equivalencias.';
    $nombre_negocio = $objeto_datos->empresa;
	$titulo_form = "Conf. " . $titulo_form;

	@$proveedor = 0;
	$concepto = 0;

	@$arreglo_prov = "";
    @$arreglo_concepto = "";

    $objeto_datos_load= new db_funciones();
    $sql_proveedor = "select '0' as v, '- Seleccione'  as t
                    union ALL
                    select prov_codigo as v, prov_nombre  as t from prov_proveedor";

    @$arreglo_prov= $objeto_datos_load->get_datos($sql_proveedor, array());

    $sql_concepto = "select '0' as v, '- Seleccione'  as t
                    union ALL
                    select cc.conc_codigo as v, ,cc.conc_nombre as t from conc_concepto cc 
						where conc_estado  = 1
						and cc.conc_tipo  = 1
						";

    @$arreglo_concepto= $objeto_datos_load->get_datos($sql_concepto, array());

	@$codigo = "";
	@$nombre = ""; 


	@$codigo = 0;
	@$codigo_tran = 0;
	
	if(!empty($fgenerales->miget('codigo')))
	{
		@$codigo = $fgenerales->miget('codigo');

		$consulta = "select * from unid_unidad where unid_codigo  = ".$codigo;
		$parametros = array();
		$arreglo_datos = $objeto_datos->get_datos($consulta,$parametros);

		foreach ($arreglo_datos as $item) 
		{
			@$codigo = $item['unid_codigo']; 
			@$nombre = $item['unid_nombre']; 
		}
	}

	if(!empty($fgenerales->mipost('accion')))
	{
		@$codigo = $_POST["codigo"]; 
		@$nombre = $_POST["nombre"]; 

		//guardar
		@$accion = $fgenerales->mipost('accion');
		if ($accion == "nuevo") {

			$consulta = "INSERT INTO unid_unidad
                                    (unid_nombre, unid_fecha)
                                    VALUES(:nombre, CURRENT_TIMESTAMP);";
			$parametros = array(":nombre"=>$nombre
							);

			$objeto_datos = new db_funciones();

            @$parametros_historial = array(":tabla" => 'unidad',
					":descripcion" => "crea,n: $nombre",
					":usuario" => $_SESSION['nombre_usuario'],
					":cod_usuario" => $_SESSION['usua_codigo']);
            $objeto_datos->insert_historial($parametros_historial);

			$arreglo_datos = $objeto_datos->insert_datos($consulta, $parametros, $form_donde_regresar);
			return;
		}

		//guardar

		//editar
		if ($accion == "modificar") {
			$consulta = "UPDATE unid_unidad
                        SET unid_nombre=:nombre, unid_fecha=CURRENT_TIMESTAMP
                        WHERE unid_codigo=:codigo;";
			$parametros = array(":nombre"=>$nombre,
								":codigo"=>$codigo);
			$objeto_datos = new db_funciones();

            @$parametros_historial = array(":tabla" => 'unidad',
            ":descripcion" => "modifico,n: $nombre",
            ":usuario" => $_SESSION['nombre_usuario'],
            ":cod_usuario" => $_SESSION['usua_codigo']);

            $objeto_datos->insert_historial($parametros_historial);
			$arreglo_datos = $objeto_datos->insert_datos($consulta, $parametros, $form_donde_regresar);
			return;
		}
		//editar
		//eliminar
		
		if ($accion == "eliminar") {
			$consulta = "DELETE FROM unid_unidad
                        WHERE unid_codigo=:codigo;";
			$parametros = array(":codigo"=>$codigo);

			$objeto_datos = new db_funciones();

            @$parametros_historial = array(":tabla" => 'unidad',
                                    ":descripcion" => "elimino,n: $nombre",
                                    ":usuario" => $_SESSION['nombre_usuario'],
                                    ":cod_usuario" => $_SESSION['usua_codigo']);
            $objeto_datos->insert_historial($parametros_historial);
            
			$arreglo_datos = $objeto_datos->insert_datos($consulta, $parametros, $form_donde_regresar);
			return;
		}
		//eliminar

		
	}

	
	

?>

<!doctype html>
<html lang="es">

<head>
	<title><?php echo $titulo_form;?></title>
	<?php
		require('nav_plantilla/nav_css.php');
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
            require('nav_plantilla/nav_top.php');
        ?>
		</nav>
		<div class="clearfix"></div>-->
		<!-- LEFT SIDEBAR -->
		<?php
            //require('nav_plantilla/menu_left.php');
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
				<div class="row">
						<div class="col-md-12">
							<!-- PANEL SCROLLING -->
								<div class="panel-heading">
									<h3 class="panel-title"><span class="label label-danger"><i class="fa fa-random"></i>&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;  SALIDA DE PRODUCTO</span></h3>
									<form method="POST" id="formulario" action="<?php echo $_SERVER['PHP_SELF']; ?>">
									<div class="row">
										<?php
										//public function caja_texto($id,$titulo, $placeholder, $columnas, $tipo, $habilitado, $requerido, $valor ='')
											$fgenerales->caja_texto('codigo', 'Código', 'Nuevo Código', '2', 'text','0',0,$codigo);
										?>
										<input type="hidden" name="accion" id="accion" value="">
										<input type="hidden" name="nombre" id="nobmre" value="123">
										
									</div>

									
									
									<div class="row">
									<?php

									$fgenerales->lista_query('concepto','Concepto', '4', $arreglo_concepto,$concepto);
									//$fgenerales->lista_query('proveedor','Lista Proveedores (opcional)', '4', $arreglo_prov,$proveedor);

									?>
									<div class="form-group col-md-4">
									<label for="Lista Proveedores (opcional)">Sucursales - Agencias</label>
									<select id="sucursal" name="sucursal" class="form-control">
										<option value="0" >- Seleccione</option>
										<?php
											if(SS1 == "si")
											{
												echo "<option value='".SS1."'>".SS1_n."</option>";
											}
											if(SS2 == "si")
											{
												echo "<option value='".SS2."'>".SS2_n."</option>";
											}
											if(SS3 == "si")
											{
												echo "<option value='".SS3."'>".SS3_n."</option>";
											}
											if(SS4 == "si")
											{
												echo "<option value='".SS4."'>".SS4_n."</option>";
											}
											if(SS5 == "si")
											{
												echo "<option value='".SS5."'>".SS5_n."</option>";
											}
										?>
								</div>
								</div>
								<div class="row">
								<div class="form-group col-md-4">
								<br>
									<input type="submit" value="Procesar" class="btn btn-success btn-block col-md4" />
									<input type="button" value="Buscar Productos" class="btn btn-primary  btn-block col-md4" onclick="alert('El formato de moneda no corresponde al solicitado. ');" />
									<a href="sis_movimiento.php"  target="_self" ><input type="button" value="Cancelar" class="btn btn-default  btn-block col-md4" />
									</a>
									</div>
									</div>
																													
									</div>
									<br />
									<div class="form-row">
									
									
									</div>
									</form>
								</div>
								
									<table class="table table-bordered">
										<thead>
											<tr>
												<th>#</th>
												<th>Código</th>
												<th>Producto</th>
												<th>Unidad</th>
												<th>Precio</th>
												<th>Cantidad</th>
												<th>Total</th>

											</tr>
										</thead>
										<tbody>
											<tr>
												<td colspan="7"">
												<?php require 'productos_precios_unidad_salida.php'; ?>
												</td>
												
											</tr>
											
										</tbody>
									</table>
								
					</div>
								<div class="panel-body no-padding">
									<div class="col-md-12">
									
									
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
				require('nav_plantilla/nav_footer.php');
			?>
		</footer>
	</div>
	<!-- END WRAPPER -->
	<!-- Javascript -->
	<?php
		require('nav_plantilla/nav_js.php');
	?>

</body>

</html>
