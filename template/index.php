<?php
    session_start();
    if(isset($_SESSION['usua_codigo']) )
    {
        header('location:home.php');
    }
	else
	{
		//header('location:home.php');
	}
    //header("location: ./template/");
	require '../src_php/db/db_funciones.php';
	require '../src_php/db/funciones_generales.php';


	@$codigo = "";
	@$usuario = '';
	@$contra = ""; 

	@$mostar_error = "";

	$fgenerales = new funciones_generales();
	$fdb = new db_funciones();
	@$codigo = 0;

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		if ($fgenerales->validar_requerido('usuario') == false or  $fgenerales->validar_requerido('contra') == false) {
			$mostar_error = "Debe ingresar su usuario y contraseña";
		}
		else
		{
			@$consulta = "SELECT usua_codigo, usua_nombre, usua_apellido, usua_usuario,
						 usua_contra, usua_status, usua_cajero, usua_fecha
						  FROM usua_usuario 
						  where usua_usuario  =  :usuario and usua_contra  = :contra and usua_status = 1 
						  ;";
			$usuario = $fgenerales->mipost('usuario');
			$contra = $fgenerales->mipost('contra');
			$contra = sha1($contra);
			@$parametros = array(":usuario" => $usuario,
								 ":contra" => $contra
								);
			$arreglo_datos = $fdb->get_datos($consulta,$parametros);
			if(count($arreglo_datos) == 0)
			{
				$mostar_error = 'Usuario y contraseña no coinciden.';
				//$mostar_error = "Usuario es $usuario y contraseña sha1($contra) no coinciden.";
			}
			else
			{

				

				date_default_timezone_set($fdb->get_zona_horaria());
				foreach ($arreglo_datos as $item) 
				{
					$_SESSION['usua_codigo'] = $item['usua_codigo']; 
					$_SESSION['es_cajero'] = $item['usua_cajero']; 
					$_SESSION['nombre_usuario'] = $item['usua_nombre'].' '.$item['usua_apellido']; 
					$_SESSION['token_temp_entrada'] = $fdb->generar_token_transaccion($item['usua_codigo'], $item['usua_nombre'].' '.$item['usua_apellido']);
					$_SESSION['token_temp_salida'] = $fdb->generar_token_transaccion($item['usua_codigo'], $item['usua_nombre'].' '.$item['usua_apellido']);
				}
					$_SESSION['sucursal1'] = "no";
					$_SESSION['sucursal2'] = "no";
					$_SESSION['sucursal3'] = "no";
					$_SESSION['sucursal4'] = "no";
					$_SESSION['sucursal5'] = "no";

					$_SESSION['sucursal1_nombre'] = "no";
					$_SESSION['sucursal2_nombre'] = "no";
					$_SESSION['sucursal3_nombre'] = "no";
					$_SESSION['sucursal4_nombre'] = "no";
					$_SESSION['sucursal5_nombre'] = "no";

				//$mostar_error = "Usuario es $usuario y contraseña $contra no coinciden.";
				@$consulta_sucursal = "select sucu_sucursal_codigo codigo,  ss.sucu_nombre  nombre
				from sucu_usuario su 
				inner join sucu_sucursal ss  on ss.sucu_codigo = sucu_sucursal_codigo 
				where  sucu_usuario_codigo = :codigo_usuario
				order by ss.sucu_orden 
				";
				@$parametros_sucursal = array(":codigo_usuario" => $_SESSION['usua_codigo']);
				
				$arreglo_sucursal = $fdb->get_datos($consulta_sucursal,$parametros_sucursal);

				foreach ($arreglo_sucursal as $sucursal) {
					if($sucursal['codigo'] == 1)
					{
						$_SESSION['sucursal1'] = "si";
						$_SESSION['sucursal1_nombre'] =  $sucursal['nombre']; 
					}

					if($sucursal['codigo'] == 2)
					{
						$_SESSION['sucursal2'] = "si";
						$_SESSION['sucursal2_nombre'] =  $sucursal['nombre']; 
					}

					if($sucursal['codigo'] == 3)
					{
						$_SESSION['sucursal3'] = "si";
						$_SESSION['sucursal3_nombre'] =  $sucursal['nombre']; 
					}

					if($sucursal['codigo'] == 4)
					{
						$_SESSION['sucursal4'] = "si";
						$_SESSION['sucursal4_nombre'] =  $sucursal['nombre']; 
					}

					if($sucursal['codigo'] == 5)
					{
						$_SESSION['sucursal5'] = "si";
						$_SESSION['sucursal5_nombre'] =  $sucursal['nombre']; 
					}

				}

				header('location:home.php');
			}

		}
	}

?>

<!doctype html>
<html lang="en" class="fullscreen-bg">

<head>
	<title>MiTiendita SV</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<!-- VENDOR CSS -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="assets/vendor/linearicons/style.css">
	<!-- MAIN CSS -->
	<link rel="stylesheet" href="assets/css/main.css">
	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
	<!-- ICONS -->
	<link rel="apple-touch-icon" sizes="76x76" href="assets/img/temple_light.png">
	<link rel="icon" type="image/png" sizes="96x96" href="assets/img/temple_light.png">
</head>

<body>
	<!-- WRAPPER -->
	<div id="wrapper">
		<div class="vertical-align-wrap">
			<div class="vertical-align-middle">
				<div class="auth-box ">
					<div class="left">
						<div class="content">
							<div class="header">
								<div class="logo text-center"><img src="assets/img/temple_dark.png" alt="Tercer Templo Software"></div>
								<p class="lead">Inicio de sesión</p>
							</div>
							<form class="form-auth-small" action="index.php" method="POST" autocomplete="off">
								<div class="form-group">
									<label for="signin-email" class="control-label sr-only">Email</label>
									<input type="text" class="form-control" id="usuario" name="usuario" value="" placeholder="Usuario - Solicite un usuario" required>
								</div>
								<div class="form-group">
									<label for="signin-password" class="control-label sr-only">Password</label>
									<input type="password" class="form-control" id="contra"  name="contra" value="" placeholder="Contraseña" required>
								</div>
								<div class="form-group clearfix">
									<label class="fancy-checkbox element-left">
										<!-- <input type="checkbox">
										<span>Remember me</span> -->
									</label>
								</div>
								<button type="submit" class="btn btn-primary btn-lg btn-block">LOGIN</button>
								<div class="bottom">
									<span class="label label-danger"><?php echo $mostar_error; sleep(1); ?></span>

									<!-- <span class="helper-text"><i class="fa fa-lock"></i> <a href="#">Forgot password?</a></span> -->
								</div>
							</form>
						</div>
					</div>
					<div class="right">
						<div class="overlay"></div>
						<div class="content text">
							<h1 class="heading">MiTiendita SV</h1>
							<p>Area restringida</p>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</div>
	<!-- END WRAPPER -->
</body>

</html>
