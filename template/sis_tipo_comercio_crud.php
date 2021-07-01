<?php
     session_start();
	 if(!isset($_SESSION['usua_codigo']))
	 {
		 header('location:index.php');
	 }
	 
	$modelo = 'tipo comercio';
	$nombre_form = "Tipo comercio";
	$form_padre =  "sis_tipo_comercio.php";
	$titulo_form = "Modulo tipo comercio";
	$descripcion_form = 'Modulo de tipo de comercios. Aqui se catalogan o seccionan los comercios y afiliados.';
    $nombre_negocio = "BiciMandados Sv - Zona Administrativa";
	$titulo_form = "Conf. " . $titulo_form;
	require '../src_php/db/db_funciones.php';
	require '../src_php/db/funciones_generales.php';


	@$codigo = "";
	@$nombre = ""; 

	$fgenerales = new funciones_generales();
	@$codigo = 0;
	
	if(!empty($fgenerales->miget('codigo')))
	{
		@$codigo = $fgenerales->miget('codigo');

		$consulta = "select * from tipo_come_comercio where tcome_codigo  = ".$codigo;

		$objeto_datos= new db_funciones(); 
		$parametros = array();
		$arreglo_datos = $objeto_datos->get_datos($consulta,$parametros);

		foreach ($arreglo_datos as $item) 
		{
			@$codigo = $item['tcome_codigo']; 
			@$nombre = $item['tcome_nombre']; 
		}
	}

	if(!empty($fgenerales->mipost('accion')))
	{
		@$codigo = $_POST["codigo"]; 
		@$nombre = $_POST["nombre"]; 

		//guardar
		@$accion = $fgenerales->mipost('accion');
		if ($accion == "nuevo") {

			$consulta = "INSERT INTO tipo_come_comercio
                                    (tcome_nombre, tcome_fecha)
                                    VALUES(:tcome_nombre, CURRENT_TIMESTAMP);";
			$parametros = array(":tcome_nombre"=>$nombre
							);

			$objeto_datos = new db_funciones();
			$arreglo_datos = $objeto_datos->insert_datos($consulta, $parametros, $form_padre);
			return;
		}

		//guardar

		//editar
		if ($accion == "modificar") {
			$consulta = "UPDATE tipo_come_comercio
                        SET tcome_nombre=:tcome_nombre, tcome_fecha=CURRENT_TIMESTAMP
                        WHERE tcome_codigo=:tcome_codigo;";
			$parametros = array(":tcome_nombre"=>$nombre,
								":tcome_codigo"=>$codigo
							);
			$objeto_datos = new db_funciones();
			$arreglo_datos = $objeto_datos->insert_datos($consulta, $parametros, $form_padre);
			return;
		}
		//editar
		//eliminar
		
		if ($accion == "eliminar") {
			$consulta = "DELETE FROM delivery_bici_2021.tipo_come_comercio
                        WHERE tcome_codigo=:tcome_codigo;";
			$parametros = array(":tcome_codigo"=>$codigo
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
										
									</div>
									<div class="row">
										<?php
										////public function caja_texto($id,$titulo, $placeholder, $columnas, $tipo, $habilitado, $requerido, $valor ='')
											$fgenerales->caja_texto('nombre', 'Nombre', 'Nombre tipo comercio', '4', 'text','1','1',$nombre);
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
