<?php
     session_start();
	 if(!isset($_SESSION['usua_codigo']))
	 {
		 header('location:index.php');
	 }
	 
	$modelo = 'plantilla';
	$nombre_form = "plantilla";
	$form_padre =  "plantilla.php";
	$titulo_form = "Modulo Usuarios";
	$descripcion_form = 'Modulo de usuarios. En este apartado se crean los inicios de sesion para el sistema.';
    $nombre_negocio = "BiciMandados Sv - Zona Administrativa";
	$titulo_form = "Conf. " . $titulo_form;
	require '../src_php/db/db_funciones.php';
	require '../src_php/db/funciones_generales.php';


	@$codigo = "";
	@$nombre = ""; 
	@$apellido = ""; 
	@$usuario = ""; 
	@$estado = ""; 
	@$contra = ""; 
	@$contra2 = ""; 


	$fgenerales = new funciones_generales();
	@$codigo = 0;
	
	if(!empty($fgenerales->miget('codigo')))
	{
		@$codigo = $fgenerales->miget('codigo');

		$consulta = "select * from usua_usuario where usua_codigo  = ".$codigo;

		$objeto_datos= new db_funciones(); 
		$arreglo_datos = $objeto_datos->get_datos($consulta,array());

		foreach ($arreglo_datos as $item) 
		{
			@$codigo = $item['usua_codigo']; 
			@$nombre = $item['usua_nombre']; 
			@$apellido = $item['usua_apellido'];
			@$usuario = $item['usua_usuario'];
			@$estado = $item['usua_status'];

		}
	}

	if(!empty($fgenerales->mipost('accion')))
	{
		@$codigo = $_POST["codigo"]; 
		@$nombre = $_POST["nombre"]; 
		@$apellido = $_POST["apellido"]; 
		@$usuario = $_POST["usuario"]; 
		@$estado = $_POST["estado"]; 
		@$contra = $_POST["contra"]; 
		@$contra2 = $_POST["contra2"]; 


		//guardar
		@$accion = $fgenerales->mipost('accion');
		if ($accion == "nuevo") {
			$consulta = "INSERT INTO delivery_bici_2021.usua_usuario
			(usua_nombre, usua_apellido, usua_usuario, usua_contra, usua_status, usua_fecha)
			VALUES(:usua_nombre, :usua_apellido, :usua_usuario, :usua_contra, :usua_status, :usua_fecha);";
			$parametros = array(":usua_nombre"=>$nombre,
								":usua_apellido"=>$apellido,
								":usua_usuario"=>$usuario,
								":usua_contra"=>$contra,
								":usua_status"=>$estado,
								":usua_fecha"=>"CURRENT_TIMESTAMP"
							);

			$objeto_datos = new db_funciones();
			$arreglo_datos = $objeto_datos->insert_datos($consulta, $parametros, $form_padre);
			return;
		}

		//guardar

		//editar
		if ($accion == "modificar") {
			$consulta = "UPDATE usua_usuario
						SET usua_nombre=:usua_nombre, usua_apellido=:usua_apellido, usua_usuario=:usua_usuario, usua_contra=:usua_contra,
						usua_status=:usua_status, usua_fecha=CURRENT_TIMESTAMP
						WHERE usua_codigo=:codigo;";
			$parametros = array(":usua_nombre"=>$nombre,
								":usua_apellido"=>$apellido,
								":usua_usuario"=>$usuario,
								":usua_contra"=>$contra,
								":usua_status"=>$estado,
								":codigo"=>$codigo
							);
			$objeto_datos = new db_funciones();
			$arreglo_datos = $objeto_datos->insert_datos($consulta, $parametros, $form_padre);
			return;
		}
		//editar
		//eliminar
		
		if ($accion == "eliminar") {
			$consulta = "DELETE FROM delivery_bici_2021.usua_usuario WHERE usua_codigo=:codigo;";
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

var campos = ["nombre", "usuario", "contra"];


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
											$fgenerales->caja_texto('nombre', 'Nombres', 'Nombre completo', '4', 'text','1','1',$nombre);
										?>
										<?php
											$fgenerales->caja_texto('apellido', 'Apellidos', 'Apellidos completo', '4', 'text','1',0,$apellido);
										?>
									</div>
									<div class="row">
										<?php
											$fgenerales->caja_texto('usuario', 'Usuario', 'Usuario iniciar sesión', '4', 'text','1','1',$estado);

											$lista_estados = array(
												array("v"=>"1", "t"=>"Activo"),
												array("v"=>"0", "t"=>"Inactivo")
											);
											$fgenerales->lista_valores('estado','Estado', '4', $lista_estados, $estado);
										?>

									</div>
									<div class="row">
									<?php
											$fgenerales->caja_texto('contra', 'Contraseña', 'Escriba su nueva contraseña', '4', 'password','1','1','');
										?>
										<?php
											$fgenerales->caja_texto('contra2', 'Repita Contraseña', 'Contraseñas deben coincidir', '4', 'password','1','');
										?>
									</div>

									<div class="form-row">
									<?php
										if($codigo == 0)
										{
											?>
											<button id="btn_nuevo" type="button" class="btn btn-success"><i class="fa fa-check-circle"></i> Crear <?php echo ' '.$nombre_form; ?></button>
											<a href="<?php echo $form_padre; ?>" target="_self" rel="noopener noreferrer"><button id="btn_nuevo" type="button" class="btn btn-primary"><i class="fa fa-warning"></i>&nbsp;&nbsp; &nbsp; Regresar &nbsp;&nbsp;</button></a> 
											<?php
										}
										else
										{
											?>
											<button id="btn_modificar" type="button" class="btn btn-success"><i class="fa fa-edit"></i> Editar <?php echo ' '.$nombre_form; ?></button>
											<button id="btn_eliminar" type="button" class="btn btn-danger"><i class="fa fa-trash-o"></i> Borrar <?php echo ' '.$nombre_form; ?></button>
											<a href="<?php echo $form_padre; ?>" target="_self" rel="noopener noreferrer"><button id="btn_nuevo" type="button" class="btn btn-primary"><i class="fa fa-warning"></i>&nbsp;&nbsp; &nbsp; Regresar &nbsp;&nbsp;</button></a> 
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
