<?php
     session_start();
	 if(!isset($_SESSION['usua_codigo']))
	 {
		 header('location:index.php');
	 }
	 
	$modelo = 'Menu';
	$nombre_form = "Menu";
	$form_padre =  "sis_menu.php?comercio=";
	$titulo_form = "Modulo Menu";
	$descripcion_form = 'Modulo de Menu o Catalogo de productos y servicios.';
    $nombre_negocio = "BiciMandados Sv - Zona Administrativa";
	$titulo_form = "Conf. " . $titulo_form;
	require '../src_php/db/db_funciones.php';
	require '../src_php/db/funciones_generales.php';


	@$codigo = "";
	@$cod_comercio = '';
	@$nombre = ""; 
	@$nombre_comercioj = "";
	@$descripcion = "";
	@$imagen = "";

	$fgenerales = new funciones_generales();
	@$codigo = 0;
	
	if($fgenerales->miget('codigo') != '')
	{
		@$codigo = $fgenerales->miget('codigo');
		@$cod_comercio = $_GET['comercio'];

		$form_padre = $form_padre.$cod_comercio;
		$consulta = "select menu_codigo  codigo, menu_nombre nombre,menu_descripcion descripcion , menu_imagen imagen, come_nombre comercio from menu_menu 
					inner join come_comercio on come_codigo  = menu_comercio
					where menu_codigo = ".$codigo;

		$objeto_datos= new db_funciones(); 
		$parametros = array();
		$arreglo_datos = $objeto_datos->get_datos($consulta,$parametros);

		foreach ($arreglo_datos as $item) 
		{
			@$nombre_comercioj = $item['comercio']; 
			@$imagen = $item['imagen']; 
			@$nombre= $codigo == 0 ? '' : $item['nombre']; 
			$descripcion= $codigo == 0 ? '' : $item['descripcion']; 
		}
	}


	if(!empty($fgenerales->mipost('accion')))
	{
		@$codigo = $_POST["codigo"]; 
		@$nombre = $_POST["nombre"];
		@$cod_comercio =  $_POST["codigo_comercio"];
		$form_padre = $form_padre.$cod_comercio;
		@$descripcion = $fgenerales->mipost('descripcion');

		//guardar
		@$accion = $fgenerales->mipost('accion');
		if ($accion == "nuevo") {

			$consulta = "INSERT INTO menu_menu
						(menu_nombre, menu_descripcion, menu_comercio, menu_fecha)
						VALUES(:nombre, :descripcion, :comercio, CURRENT_TIMESTAMP);";
			$parametros = array(":nombre"=>$nombre,
								":descripcion"=>$descripcion,
								":comercio"=>$cod_comercio,
							);

			$objeto_datos = new db_funciones();
			$arreglo_datos = $objeto_datos->insert_datos($consulta, $parametros, $form_padre);
			return;
		}

		//guardar

		//editar
		if ($accion == "modificar") {
			$consulta = "UPDATE menu_menu
						SET menu_nombre=:nombre, menu_descripcion=:descripcion, menu_fecha=CURRENT_TIMESTAMP
						WHERE menu_codigo=:codigo;";
			$parametros = array(":nombre"=>$nombre,
								":descripcion"=>$descripcion,
								":codigo"=>$codigo
							);
			$objeto_datos = new db_funciones();
			$arreglo_datos = $objeto_datos->insert_datos($consulta, $parametros, $form_padre);
			return;
		}
		//editar
		//eliminar
		
		if ($accion == "eliminar") {
			$consulta = "DELETE FROM menu_menu
                        WHERE menu_codigo=:codigo;";
			$parametros = array(":codigo"=>$codigo
							);

			$objeto_datos = new db_funciones();
			$arreglo_datos = $objeto_datos->insert_datos($consulta, $parametros, $form_padre);
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
									<h4><?php echo $nombre_comercioj; ?></h4>
									<h3 class="panel-title"><?php echo $titulo_form; ?></h3>
									<p class="panel-subtitle"><?php echo $descripcion_form; ?></p>
								</div>
								<div class="panel-body no-padding">
									<div class="col-md-12">
									<form method="POST" id="formulario" action="<?php echo $_SERVER['PHP_SELF']; ?>">
									<div class="row">
									<div class="col-md-4">
													<div class="form-group">
													<label for="imagen">&nbsp;</label>
										<img src="assets/img/app/menu/min_<?php echo $imagen; ?>" class="img-fluid" alt="Sin vista miniatura de imagen">
													</div>
										</div>	

										<?php
										//public function caja_texto($id,$titulo, $placeholder, $columnas, $tipo, $habilitado, $requerido, $valor ='')
											$fgenerales->caja_texto('codigo', 'Código', 'Nuevo Código', '2', 'text','0',0,$codigo);
										?>
										<input type="hidden" name="accion" id="accion" value="">

										
										<input type="hidden" name="codigo_comercio" value="<?php echo $cod_comercio; ?>">
										
									</div>
									<div class="row">
										<?php
										////public function caja_texto($id,$titulo, $placeholder, $columnas, $tipo, $habilitado, $requerido, $valor ='')
										$fgenerales->caja_texto('nombre', 'Nombre', 'Nombre completo', '4', 'text','1','1',$nombre);
										?>
										<div class="col-md-2">
													<div class="form-group">
													
													<?php
													if($codigo> 0)
													{
														?>
														<label for="imagen">Subir Imagen</label>
														<a href="sis_imagen_comercio.php?destino=menu&codigo=<?php echo $codigo."&comercio=".$cod_comercio; ?>" target="_self" rel="noopener noreferrer"><button id="btn_regresar" type="button" class="btn btn-default btn-block"><i class="fa fa-file-image-o"></i>&nbsp;&nbsp; &nbsp; Subir imagen &nbsp;&nbsp;</button></a> 
														<?php
													}
													?>
													</div>
												</div>
									</div>
									<div class="row">
										<?php
										////public function caja_texto($id,$titulo, $placeholder, $columnas, $tipo, $habilitado, $requerido, $valor ='')
											$fgenerales->caja_texto('descripcion', 'Descripcion', 'Descripcion menu', '6', 'text','1','1',$descripcion);
										?>
									</div>
									<div class="form-row">
									<?php
										if($codigo == 0)
										{
											?>
											<button id="btn_nuevo" type="button" class="btn btn-success"><i class="fa fa-check-circle"></i> Crear <?php echo ' '.$nombre_form; ?></button>
											<a href="<?php echo $form_padre; ?>" target="_self" rel="noopener noreferrer"><button id="btn_regresar" type="button" class="btn btn-primary"><i class="fa fa-warning"></i>&nbsp;&nbsp; &nbsp; Regresar &nbsp;&nbsp;</button></a> 
											<?php
										}
										else
										{
											?>
											<button id="btn_modificar" type="button" class="btn btn-success"><i class="fa fa-edit"></i> Editar <?php echo ' '.$nombre_form; ?></button>
											<button id="btn_eliminar" type="button" class="btn btn-danger"><i class="fa fa-trash-o"></i> Borrar <?php echo ' '.$nombre_form; ?></button>
											<a href="<?php echo $form_padre; ?>" target="_self" rel="noopener noreferrer"><button id="btn_regresar" type="button" class="btn btn-primary"><i class="fa fa-warning"></i>&nbsp;&nbsp; &nbsp; Regresar &nbsp;&nbsp;</button></a> 
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
