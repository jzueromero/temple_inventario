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

	$modelo = 'ENTRADA DE PRODUCTO';
	$nombre_form = "ENTRADA DE PRODUCTO";
	$form_donde_regresar =  "sis_unidad.php";
	$titulo_form = "Modulo unidad";
	$descripcion_form = 'Modulo unidades que se usaran en el apartado de equivalencias.';
    $nombre_negocio = $objeto_datos->empresa;
	$titulo_form = "Conf. " . $titulo_form;



	@$codigo = "";
	@$nombre = ""; 


	@$codigo = 0;
	
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
											<a href="<?php echo $form_donde_regresar; ?>" target="_self" rel="noopener noreferrer"><button id="btn_regresar" type="button" class="btn btn-primary"><i class="fa fa-warning"></i>&nbsp;&nbsp; &nbsp; Regresar &nbsp;&nbsp;</button></a> 
											<?php
										}
										else
										{
											?>
											<button id="btn_modificar" type="button" class="btn btn-success"><i class="fa fa-edit"></i> Editar <?php echo ' '.$nombre_form; ?></button>
											<button id="btn_eliminar" type="button" class="btn btn-danger"><i class="fa fa-trash-o"></i> Borrar <?php echo ' '.$nombre_form; ?></button>
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
