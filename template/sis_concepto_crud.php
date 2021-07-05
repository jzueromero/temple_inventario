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

	$modelo = 'Concepto';
	$nombre_form = "concepto";
	$form_donde_regresar =  "sis_concepto.php";
	$titulo_form = "Modulo concepto";
	$descripcion_form = '';
    $nombre_negocio = $objeto_datos->empresa;
	$titulo_form = "Conf. " . $titulo_form;



	@$codigo = "";
	@$nombre = ""; 
	@$estado = 0;
	$tipo = 0;


	@$codigo = 0;
	
	if(!empty($fgenerales->miget('codigo')))
	{
		@$codigo = $fgenerales->miget('codigo');

		$consulta = "select * from conc_concepto where conc_codigo  = ".$codigo;
		$parametros = array();
		$arreglo_datos = $objeto_datos->get_datos($consulta,$parametros);

		foreach ($arreglo_datos as $item) 
		{
			@$codigo = $item['conc_codigo']; 
			@$nombre = $item['conc_nombre']; 
			@$tipo = $item['conc_tipo']; 
			@$estado = $item['conc_estado']; 
		}
	}

	if(!empty($fgenerales->mipost('accion')))
	{
		@$codigo = $_POST["codigo"]; 
		@$nombre = $_POST["nombre"]; 
		@$tipo = $_POST["tipo"]; 
		@$estado = $_POST["estado"]; 

		//guardar
		@$accion = $fgenerales->mipost('accion');
		if ($accion == "nuevo") {

			$consulta = "INSERT INTO conc_concepto
						( conc_nombre, conc_tipo, conc_estado)
						VALUES(:conc_nombre,:conc_tipo, :conc_estado);
						";
			$parametros = array(":conc_nombre"=>$nombre,
			":conc_tipo"=>$tipo,
			":conc_estado"=>$estado,
							);

			$objeto_datos = new db_funciones();

            @$parametros_historial = array(":tabla" => 'concepto',
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
			$consulta = "UPDATE conc_concepto
						SET conc_nombre=:conc_nombre, conc_tipo=:conc_tipo, conc_estado=:conc_estado
						WHERE conc_codigo=:conc_codigo;";
			$parametros = array(":conc_nombre"=>$nombre,
								":conc_tipo"=>$tipo,
								":conc_estado"=>$estado,
								":conc_codigo"=>$codigo,);
			$objeto_datos = new db_funciones();

            @$parametros_historial = array(":tabla" => 'concepto',
            ":descripcion" => "modifico,n: $nombre",
            ":usuario" => $_SESSION['nombre_usuario'],
            ":cod_usuario" => $_SESSION['usua_codigo']);

            $objeto_datos->insert_historial($parametros_historial);
			$arreglo_datos = $objeto_datos->insert_datos($consulta, $parametros, $form_donde_regresar);
			return;
		}
		//editar
		

		
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
									<div class="row">
										<?php
										$lista_estados = array(
											array("v"=>"1", "t"=>"Activo"),
											array("v"=>"0", "t"=>"Inactivo")
										);
										$fgenerales->lista_valores('estado','Estado', '4', $lista_estados, $estado);
										?>
										</div>
										<div class="row">
										<?php
										$lista_tipos = array(
											array("v"=>"1", "t"=>"Entrada de Producto"),
											array("v"=>"0", "t"=>"Salida de Producto")
										);
										$fgenerales->lista_valores('tipo','Tipo', '4', $lista_tipos, $tipo);
										?>
										</div>
									<div class="form-row">
									<?php
										if($codigo == 0)
										{
											?>
											<button id="btn_nuevo" type="button" class="btn btn-success"><i class="fa fa-check-circle"></i> Crear <?php echo ' '.$nombre_form; ?></button>
											<a href="<?php echo $form_donde_regresar; ?>" target="_self" rel="noopener noreferrer"><button id="btn_regresar" type="button" class="btn btn-primary"><i class="fa fa-warning"></i>&nbsp;&nbsp; &nbsp; Regresar &nbsp;&nbsp;</button></a> 
											<?php
										}
										else
										{
											?>
											<button id="btn_modificar" type="button" class="btn btn-success"><i class="fa fa-edit"></i> Editar <?php echo ' '.$nombre_form; ?></button>
											<a href="<?php echo $form_donde_regresar; ?>" target="_self" rel="noopener noreferrer"><button id="btn_regresar" type="button" class="btn btn-primary"><i class="fa fa-warning"></i>&nbsp;&nbsp; &nbsp; Regresar &nbsp;&nbsp;</button></a> 
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
