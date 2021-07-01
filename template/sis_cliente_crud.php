<?php
     session_start();
	 if(!isset($_SESSION['usua_codigo']))
	 {
		 header('location:index.php');
	 }

	 $formulario_acceso="clie_crud";

     require '../src_php/db/db_funciones.php';
     require '../src_php/db/funciones_generales.php';
     $fgenerales = new funciones_generales();     
     $objeto_datos= new db_funciones(); 

	$modelo = 'cliente';
	$nombre_form = "cliente";
	$form_donde_regresar =  "sis_cliente.php";
	$titulo_form = "Modulo $modelo";
	$descripcion_form = "$titulo_form Configuracion de clientes y destinos de producto.";
    $nombre_negocio = $objeto_datos->empresa;
	$titulo_form = "Conf. " . $titulo_form;


	@$codigo = "";
	@$nombre = ""; 
    @$pais ="";
    @$direccion = '';
    @$responsable = '';
    @$contacto = ''; 


	@$codigo = 0;
	
	if(!empty($fgenerales->miget('codigo')))
	{
		@$codigo = $fgenerales->miget('codigo');
        @$pais = $fgenerales->miget('pais');

		$consulta = "select * from clie_cliente where clie_codigo  = ".$codigo;
		$parametros = array();
		$arreglo_datos = $objeto_datos->get_datos($consulta,$parametros);

		foreach ($arreglo_datos as $item) 
		{
			@$codigo = $codigo; 
			@$nombre = $item['clie_nombre']; 
            @$pais = $item['clie_pais']; 
            @$direccion = $item['clie_direccion'];
            @$responsable = $item['clie_responsable'];
            @$contacto = $item['clie_contacto']; 
		}
	}

	if(!empty($fgenerales->mipost('accion')))
	{
		@$codigo = $_POST["codigo"]; 
		@$nombre = $_POST["nombre"]; 
        @$pais = $_POST["pais"]; 
        @$direccion = $_POST["direccion"];
        @$responsable = $_POST["responsable"];
        @$contacto = $_POST["contacto"]; 

        @$historial_descripcion = "c:$codigo, n: $nombre, p:$pais, d:$direccion, r:$responsable, c:$contacto";

		//guardar
		@$accion = $fgenerales->mipost('accion');
		if ($accion == "nuevo") {

			$consulta = "INSERT INTO clie_cliente
                        (clie_nombre, clie_direccion, clie_pais, clie_responsable, clie_contacto, clie_fecha)
                        VALUES(:nombre, :direccion, :pais, :responsable, :contacto, CURRENT_TIMESTAMP);";
			$parametros = array(":nombre"=>$nombre,
                                ":direccion"=>$direccion,
                                ":pais"=>$pais,
                                ":responsable"=>$responsable,
                                ":contacto"=>$contacto);

			$objeto_datos = new db_funciones();

            @$parametros_historial = array(":tabla" => $modelo,
					":descripcion" => "crea, $historial_descripcion",
					":usuario" => $_SESSION['nombre_usuario'],
					":cod_usuario" => $_SESSION['usua_codigo']);
            $objeto_datos->insert_historial($parametros_historial);

			$arreglo_datos = $objeto_datos->insert_datos($consulta, $parametros, $form_donde_regresar);
			return;
		}

		//guardar

		//editar
		if ($accion == "modificar") {
			$consulta = "UPDATE clie_cliente
                        SET clie_nombre=:nombre, clie_direccion=:direccion, clie_pais=:pais,
                        clie_responsable=:responsable, clie_contacto=:contacto, clie_fecha=CURRENT_TIMESTAMP
                        WHERE clie_codigo=:codigo;";
			$parametros = array(":nombre"=>$nombre,
                                ":direccion"=>$direccion,
                                ":pais"=>$pais,
                                ":responsable"=>$responsable,
                                ":contacto"=>$contacto,
                                ":codigo"=>$codigo);
			$objeto_datos = new db_funciones();

            @$parametros_historial = array(":tabla" => $modelo,
            ":descripcion" => "edita,$historial_descripcion",
            ":usuario" => $_SESSION['nombre_usuario'],
            ":cod_usuario" => $_SESSION['usua_codigo']);

            $objeto_datos->insert_historial($parametros_historial);
			$arreglo_datos = $objeto_datos->insert_datos($consulta, $parametros, $form_donde_regresar);
			return;
		}
		//editar
		//eliminar
		
		if ($accion == "eliminar") {
			$consulta = "DELETE FROM clie_cliente
                        WHERE clie_codigo=:codigo;";
			$parametros = array(":codigo"=>$codigo);

			$objeto_datos = new db_funciones();

            @$parametros_historial = array(":tabla" => $modelo,
                                    ":descripcion" => "elimina, $historial_descripcion",
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
                                            $fgenerales->caja_texto('nombre', 'Nombre', 'Nombre tipo comercio', '6', 'text','1','1',$nombre);
										?>
										<input type="hidden" name="accion" id="accion" value="">
										
									</div>
									<div class="row">
										<?php
										////public function caja_texto($id,$titulo, $placeholder, $columnas, $tipo, $habilitado, $requerido, $valor ='')
											
                                        $fgenerales->caja_texto('responsable', 'Recepcionista o encargado', 'Nombre de contacto', '4', 'text','1','1',$responsable);
                                        $fgenerales->caja_texto('contacto', 'Contacto', 'Correo o Tel', '4', 'text','1','1',$contacto);
                                            
										?>
									</div>
                                    <div class="row">
                                        <?php 
                                            $fgenerales->caja_texto('direccion', 'Direccion', 'Direccion o ubicacion', '4', 'text','1','1',$direccion);
                                            $fgenerales->caja_texto('pais', 'Pais', 'Nombre Pais', '4', 'text','1','1',$pais);
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
