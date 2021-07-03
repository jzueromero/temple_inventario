<?php
    session_start();
    if(!isset($_SESSION['usua_codigo']))
    {
        header('location:index.php');
    }

    $formulario_acceso="usu_crud";



//Detalles del formulario
$modelo = 'usuario';
$nombre_form = "sis_usuario_crud.php";
$form_padre = "sis_usuario.php";
$titulo_form = "Modulo Usuarios";
$descripcion_form = 'Modulo de usuarios. En este apartado se crean los inicios de sesion para el sistema.';
//datos fijos
$nombre_negocio = "BiciMandados Sv - Zona Administrativa";
$titulo_form = "Conf. " . $titulo_form;
require '../src_php/db/db_funciones.php';
require '../src_php/db/funciones_generales.php';

$objeto_datos = new db_funciones();

@$div_popup = '';
@$titulo_popup = '';
@$form_valido = true;
@$accion = '';
@$codigo = '';
$fgenerales = new funciones_generales();
/*
JAVASCRIPT validacion
 */
//Nombre de las cajas de texto que deben estar validadas
@$campos_valida_js = "<script> var campos = [ 'usuario', 'nombre']; </script>";
/*
JAVASCRIPT validacion
 */

//Variables por cada control del formulario
@$codigo = 0;
@$nombre = "";
@$apellido = "";
@$usuario = "";
@$cajero = 0;
@$estado = "";
@$contra = "";
@$contra2 = "";
@$usuario_actual = '';

//Operaciones
//CRUD

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!empty($fgenerales->miget('codigo'))) {
        @$codigo = $fgenerales->miget('codigo');

        $consulta = "select * from usua_usuario where usua_codigo  = :codigo";
        $parametros = array(":codigo" => $codigo);

        $objeto_datos = new db_funciones();
        $arreglo_datos = $objeto_datos->get_datos($consulta, $parametros);

        $consulta_accesos = "select form_nombre from acce_acceso 
                            inner join form_formulario on form_codigo = acce_form_codigo
                            where acce_usua_codigo = :cod_usuario";
        $parametros_accesos = array(":cod_usuario" => $codigo);

        $arreglo_accesos = $objeto_datos->get_datos($consulta_accesos, $parametros_accesos);
        
        $consulta_sucursales = "select sucu_nombre from sucu_sucursal ss 
                    inner join sucu_usuario su on su.sucu_sucursal_codigo = ss.sucu_codigo 
                    where su.sucu_usuario_codigo = :cod_usuario";
        $parametros_sucur = array(":cod_usuario" => $codigo);

        $arreglo_sucu = $objeto_datos->get_datos($consulta_sucursales, $parametros_sucur);



        foreach ($arreglo_datos as $item) {
            @$codigo = $item['usua_codigo'];
            @$nombre = $item['usua_nombre'];
            @$apellido = $item['usua_apellido'];
            @$usuario = $item['usua_usuario'];
            @$estado = $item['usua_status'];
            @$cajero = $item['usua_cajero'];
            @$usuario_actual = $item['usua_usuario'];
            $descripcion_form = $descripcion_form . "<h4 ><spam class='text-primary'>Si desea conservar la misma contraseña,</spam><spam class='text-primary'>
														&nbsp;deje en blanco las cajas de contraseña</spam></h4>";                                                        

        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($fgenerales->mipost('accion'))) {
        @$codigo = $_POST["codigo"];
        @$nombre = $_POST["nombre"];
        @$apellido = $_POST["apellido"];
        @$usuario = $_POST["usuario"];
        @$estado = $_POST["estado"];
        @$cajero = $_POST['cajero'];
        @$contra = $_POST["contra"];
        @$contra2 = $_POST["contra2"];
        @$usuario_actual = $_POST["usuario_actual"];

        if ($fgenerales->validar_requerido($nombre) === false) {
            $form_valido = false;
            $titulo_popup = 'Es requisito ingresar el nombre';
        }

        if ($fgenerales->validar_requerido($usuario) === false) {
            $form_valido = false;
            $titulo_popup = 'Es requisito ingresar el usuario';
        }

        if (!$form_valido) {
            $div_popup = $fgenerales->mostrar_popup(1, $titulo_popup);

        } else {
            //guardar
            @$accion = $fgenerales->mipost('accion');
            if ($accion == "nuevo") {

                @$existe_usuario = "select count(usua_nombre) valor from usua_usuario where usua_usuario = :usuario";
                $parametros = array(":usuario" => $usuario);
                $numero = $objeto_datos->get_dato_escalar($existe_usuario, $parametros);

                if ($numero > 0) {
                    $div_popup = $fgenerales->mostrar_popup(2, 'Usuario ya existe en el sistema, el usuario debe ser unico');
                } else if ($fgenerales->validar_requerido($contra) == false) {
                    $div_popup = $fgenerales->mostrar_popup(2, 'Ingrese una contraseña');
                } else if ($contra != $contra2) {
                    $div_popup = $fgenerales->mostrar_popup(2, 'Las contraseñas no coinciden.');
                } else {

                    $consulta = "INSERT INTO usua_usuario
					(usua_nombre, usua_apellido, usua_usuario, usua_contra, usua_status, usua_cajero usua_fecha)
					VALUES(:usua_nombre, :usua_apellido, :usua_usuario, :usua_contra, :usua_status, :usua_cajero, CURRENT_TIMESTAMP);";
                    $parametros = array(":usua_nombre" => $nombre,
                        ":usua_apellido" => $apellido,
                        ":usua_usuario" => $usuario,
                        ":usua_contra" => sha1($contra),
                        ":usua_status" => $estado,
                        ":usua_cajero" => $cajero,
                    );

                    @$parametros_historial = array(":tabla" => 'usuario',
                                            ":descripcion" => "crea,n:$nombre a:$apellido,u:$usuario,$estado",
                                            ":usuario" => $_SESSION['nombre_usuario'],
                                            ":cod_usuario" => $_SESSION['usua_codigo']);
                    $objeto_datos->insert_historial($parametros_historial);
                    $arreglo_datos = $objeto_datos->insert_datos($consulta, $parametros, $form_padre);
                    return;
                }
            }
            //guardar
            //editar
            if ($accion == "modificar") {

                @$existe_usuario = "select count(usua_nombre) valor from usua_usuario where usua_usuario = :usuario and usua_codigo != :codigo";
                $parametros = array(":usuario" => $usuario,
                    ":codigo" => $codigo);
                $numero = $objeto_datos->get_dato_escalar($existe_usuario, $parametros);

                if ($numero > 0) {
                    $div_popup = $fgenerales->mostrar_popup(2, 'Ya existe una persona con este nombre de <b>usuario</b>');
                } 
                else if ($fgenerales->validar_requerido($contra) == true) {
                    if ($contra != $contra2) {
                        $div_popup = $fgenerales->mostrar_popup(2, 'Si desea cambiar la contraseña ambas deben <b>ser iguales</b>, si no desea cambiar su contraseña <b>dejelo en blanco</b>');
                    } 
                    else
                     {
                        $consulta = "UPDATE usua_usuario
									SET usua_nombre=:usua_nombre, usua_apellido=:usua_apellido, usua_usuario=:usua_usuario, usua_contra=:usua_contra,
									usua_status=:usua_status, usua_cajero=:usua_cajero, usua_fecha=CURRENT_TIMESTAMP
									WHERE usua_codigo=:codigo;";
                        $parametros = array(":usua_nombre" => $nombre,
                            ":usua_apellido" => $apellido,
                            ":usua_usuario" => $usuario,
                            ":usua_contra" => sha1($contra),
                            ":usua_status" => $estado,
                            ":usua_cajero" => $cajero,
                            ":codigo" => $codigo,
                        );
                        $objeto_datos = new db_funciones();
                        @$parametros_historial = array(":tabla" => 'usuario',
                                                ":descripcion" => "modifico,n:$nombre a:$apellido,u:$usuario,$estado",
                                                ":usuario" => $_SESSION['nombre_usuario'],
                                                ":cod_usuario" => $_SESSION['usua_codigo']);
                        $objeto_datos->insert_historial($parametros_historial);
                        $arreglo_datos = $objeto_datos->insert_datos($consulta, $parametros, $form_padre);
                        return;
                    }
                } 
                else {
                    $consulta = "UPDATE usua_usuario
									SET usua_nombre=:usua_nombre, usua_apellido=:usua_apellido, usua_usuario=:usua_usuario,
									usua_status=:usua_status, usua_cajero=:usua_cajero, usua_fecha=CURRENT_TIMESTAMP
									WHERE usua_codigo=:codigo;";
                    $parametros = array(":usua_nombre" => $nombre,
                        ":usua_apellido" => $apellido,
                        ":usua_usuario" => $usuario,
                        ":usua_status" => $estado,
                        ":usua_cajero" => $cajero,
                        ":codigo" => $codigo,
                    );
                    $objeto_datos = new db_funciones();

                    @$parametros_historial = array(":tabla" => 'usuario',
                                                ":descripcion" => "modifico,n:$nombre a:$apellido,u:$usuario,$estado",
                                                ":usuario" => $_SESSION['nombre_usuario'],
                                                ":cod_usuario" => $_SESSION['usua_codigo']);
                    $objeto_datos->insert_historial($parametros_historial);

                    $arreglo_datos = $objeto_datos->insert_datos($consulta, $parametros, $form_padre);
                    return;
                }

            }

            //editar
        }
        //eliminar
        if ($accion == "eliminar") {
            $consulta = "DELETE FROM usua_usuario WHERE usua_codigo=:codigo;";
            $parametros = array(":codigo" => $codigo,
            );

            $objeto_datos = new db_funciones();

            @$parametros_historial = array(":tabla" => 'usuario',
                                    ":descripcion" => "elimino,n:$nombre a:$apellido,u:$usuario,$estado",
                                    ":usuario" => $_SESSION['nombre_usuario'],
                                    ":cod_usuario" => $_SESSION['usua_codigo']);
            $objeto_datos->insert_historial($parametros_historial);

            $arreglo_datos = $objeto_datos->insert_datos($consulta, $parametros, $form_padre);
            return;
        }
        //eliminar

    }
}

?>

<!doctype html>
<html lang="es">

<head>
	<title><?php echo $titulo_form;?></title>
	<?php
		require('nav_plantilla/nav_css.php');
	?>


<?php echo $campos_valida_js; ?>



	
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
		<!--<div class="clearfix"></div>-->
		<!-- LEFT SIDEBAR -->
		<?php
            //require('nav_plantilla/menu_left.php');
			
        ?>
		<!-- END LEFT SIDEBAR -->
		<!-- MAIN -->
		<div class="main">
		<?php echo $div_popup; ?>
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
										if($codigo > 0)
										{
                                            ?>
                                    <div class='col-md-4'>
                                        <div class='form-group'>
                                            <label for='sucu'>&nbsp;</label>
                                            <a href="#sucursales" > <label for="sucursales" class="btn btn-md btn-default" >
                                        <i class="fa fa-home"></i>
                                            Sucursales, Accesos y permisos <i class="fa fa-user"></i>
                                        </label> </a>
                                        </div>
                                    </div>

										<?php
                                        }
										//public function caja_texto($id,$titulo, $placeholder, $columnas, $tipo, $habilitado, $requerido, $valor ='')
											$fgenerales->caja_texto('codigo', 'Código', 'Nuevo Código', '2', 'text','0',0,$codigo);
										?>
                                        
                                       
                                        
										<input type="hidden" name="accion" id="accion" value="">
										<input type="hidden" name="usuario_actual" id="usuario_actual" value="<?php echo $usuario; ?>">
										
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
											$fgenerales->caja_texto('usuario', 'Usuario', 'Usuario inicia sesion', '4', 'text','1',0,$usuario);
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
												array("v"=>"0", "t"=>"Normal"),
												array("v"=>"1", "t"=>"Cajero")
											);
											$fgenerales->lista_valores('cajero','Es Cajero', '4', $lista_tipos, $cajero);
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
											<button id="btn_nuevo" type="button" class="btn btn-success"><i class="fa fa-check-circle"></i> Crear <?php echo ' '.$modelo; ?></button>
											<a href="<?php echo $form_padre; ?>" target="_self" rel="noopener noreferrer"><button id="btn_regresar" type="button" class="btn btn-primary"><i class="fa fa-warning"></i>&nbsp;&nbsp; &nbsp; Regresar &nbsp;&nbsp;</button></a> 
											<?php
										}
										else
										{
											?>
											<button id="btn_modificar" type="button" class="btn btn-success"><i class="fa fa-edit"></i> Editar <?php echo ' '.$modelo; ?></button>
											<button id="btn_eliminar" type="button" class="btn btn-danger"><i class="fa fa-trash-o"></i> Borrar <?php echo ' '.$modelo; ?></button>
											<a href="<?php echo $form_padre; ?>" target="_self" rel="noopener noreferrer"><button id="btn_regresar" type="button" class="btn btn-primary"><i class="fa fa-warning"></i>&nbsp;&nbsp; &nbsp; Regresar &nbsp;&nbsp;</button></a> 
											<?php
										}
									?>
									
									<div class="form-row">
                                    <br >
                                       
										
									</div>
									
									</div>


									
									</div>
									</form>
									
                                    <?php
										if($codigo > 0)
										{
                                            ?>
                    <div class="accordion col-md-12" id="sucursales">
                            <div class="card col-md-12">
                                <div class="card-header" id="headingOne">
                                <h2 class="mb-0">
                                    <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    <i class="fa fa-home"></i> Sucursales o Agencias
                                    </button>
                                </h2>
                                </div>

                                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                <div class="card-body">
                                
                                    <!-- Detalle sucursales -->
                                    <div class="panel panel-default">
                                    <!-- Default panel contents -->
                                    <!-- List group -->
                                    <ul class="list-group">
                                    <li class="list-group-item">
                                    <a href="sis_sucursal_usuario.php?usua_codigo=<?php echo $codigo."&nombre_completo=$nombre $apellido"; ?>">
                                    <label class="btn btn-link collapsed">
                                    <i class="fa fa-home"></i>&nbsp;<i class="fa fa-edit"></i> Configurar
                                    </label>
                                </a>
                                    </li>
                                    <?php
                                        foreach ($arreglo_sucu as $acceso)
                                         {
                                             ?>
                                            <li class="list-group-item"><?php echo $acceso['sucu_nombre'] ?></li>
                                            <?php
                                        }
                                    ?>
                                    </ul>
                                </div>

                                    <!-- detalle sucrusales -->
                                </div>
                                </div>
                            </div>
                            <div class="card col-md-12">
                                <div class="card-header" id="headingTwo">
                                <h2 class="mb-0">
                                    <button class="btn btn-primary collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    <i class="fa fa-user"></i> Accesos y Permisos
                                    </button>
                                    
                                </h2>
                                </div>
                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                <div class="card-body">
                                
                                <br>
                                <div class="panel panel-default">
                                    <!-- Default panel contents -->
                                    <!-- List group -->
                                    <ul class="list-group">
                                    <li class="list-group-item">
                                    <a href="sis_acceso.php?usua_codigo=<?php echo $codigo."&nombre_completo=$nombre $apellido"; ?>">
                                        <label class="btn btn-link collapsed">
                                        <i class="fa fa-user"></i>&nbsp;<i class="fa fa-edit"></i> Configurar
                                        </label>
                                    </a>
                                    </li>
                                    <?php
                                        foreach ($arreglo_accesos as $acceso)
                                         {
                                             ?>
                                            <li class="list-group-item"><?php echo $acceso['form_nombre'] ?></li>
                                            <?php
                                        }
                                    ?>
                                    </ul>
                                </div>
                                </div>
                                </div>
                            </div>

                                            <?php
                                        }
											?>                
                            

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
