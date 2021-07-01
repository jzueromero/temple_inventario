<?php
    session_start();
    if(!isset($_SESSION['usua_codigo']))
    {
        header('location:index.php');
    }

	$modelo = 'Confg. comercio';
	$nombre_form = "Confg. comercio";
	$form_padre =  "sis_comercio.php";
 	$titulo_form = "Modulo comercio";
	 $descripcion_form = 'Modulo de comercios. Aqui se registran las empresas, emprendimientos y afiliados.';
    $nombre_negocio = "BiciMandados Sv - Zona Administrativa";
	$titulo_form = "Conf. " . $titulo_form;
	require '../src_php/db/db_funciones.php';
	require '../src_php/db/funciones_generales.php';


    @$codigo = '';
    @$nombre = '';
    @$hora_inicio = '';
    @$hora_final = '';
    @$direccion = '';
    @$tcomercio = '';
    @$responsable = '';
    @$imagen = ''; 
    @$tcodigo = 0;
    @$telefono = ''; 


	$fgenerales = new funciones_generales();
	@$codigo = 0;
	@$arreglo_tcomercio = "";

    $objeto_datos_load= new db_funciones();
    $sql_tipo_comercio = "select '0' as v, '-Seleccione Rubro' as t 
							UNION ALL
						 select tcome_codigo as v, tcome_nombre as t from tipo_come_comercio ";
    @$arreglo_tcomercio= $objeto_datos_load->get_datos($sql_tipo_comercio, array());
	if(!empty($fgenerales->miget('codigo')))
	{
		@$codigo = $fgenerales->miget('codigo');

		$consulta = "select come_codigo  as codigo, come_nombre nombre, come_horario_apertura h_apertura, come_horario_cierre h_cierre, 
                    come_tipo_comercio tcodigo, tcome_nombre tnombre, come_telefono telefono,
                    come_direccion as direccion, come_responsable responsable, come_orden orden,
                    come_imagen imagen, come_fecha fecha
                    from come_comercio
                    left join tipo_come_comercio on tcome_codigo  = come_tipo_comercio
                    where come_codigo  = ".$codigo;

		$objeto_datos= new db_funciones(); 
		$arreglo_datos = $objeto_datos->get_datos($consulta,array());

		foreach ($arreglo_datos as $item) 
		{
			@$codigo = $item['codigo'];
            @$nombre = $item['nombre'];
            @$hora_inicio = $item['h_apertura'];
            @$hora_final = $item['h_cierre'];
            @$direccion = $item['direccion'];
            @$tcomercio = $item['tnombre'];
            @$responsable = $item['responsable'];
            @$imagen = $item['imagen'];
            @$tcodigo = $item['tcodigo'];
            @$telefono = $item['telefono']; 

		}


        
	}

	if(!empty($fgenerales->mipost('accion')))
	{
        @$codigo = $_POST["codigo"];
        @$nombre = $_POST["nombre"];
        @$hora_inicio = $_POST["hora_inicio"];
        @$hora_final = $_POST["hora_final"];
        @$direccion = $_POST["direccion"];
        @$tcomercio = $_POST["tcomercio"];
        @$tcodigo = $_POST["tcomercio"];
        @$responsable = $_POST["responsable"];
        @$imagen = $_POST["imagen"]; 
        @$telefono = $_POST["telefono"];


		//guardar
		@$accion = $fgenerales->mipost('accion');
		if ($accion == "nuevo") {
			$consulta = "INSERT INTO come_comercio
                    (come_nombre, come_horario_apertura, come_horario_cierre, come_tipo_comercio,
                     come_telefono, come_direccion, come_responsable, come_imagen, come_fecha)

                    VALUES(:come_nombre, :come_horario_apertura, :come_horario_cierre, :come_tipo_comercio,
                     :come_telefono, :come_direccion, :come_responsable, :come_imagen, CURRENT_TIMESTAMP);";
			$parametros = array(":come_nombre"=>$nombre,
								":come_horario_apertura"=>$hora_inicio,
								":come_horario_cierre"=>$hora_final,
								":come_tipo_comercio"=>$tcodigo,
								":come_telefono"=>$telefono,
                                ":come_direccion"=>$direccion,
                                ":come_responsable"=>$responsable,
                                ":come_imagen"=>$imagen
							);

            //echo $hora_final;                            
			 $objeto_datos = new db_funciones();
			 $arreglo_datos = $objeto_datos->insert_datos($consulta, $parametros, $form_padre);
			return;
		}

		//guardar

		//editar
		if ($accion == "modificar") {
			$consulta = "UPDATE come_comercio
            SET come_nombre=:come_nombre, come_horario_apertura=:come_horario_apertura, come_horario_cierre=:come_horario_cierre,
             come_tipo_comercio=:come_tipo_comercio, come_telefono=:come_telefono, come_direccion=:come_direccion,
              come_responsable=:come_responsable, come_imagen=:come_imagen, come_fecha=CURRENT_TIMESTAMP
            WHERE come_codigo=:codigo;";
			$parametros = array(":come_nombre"=>$nombre,
								":come_horario_apertura"=>$hora_inicio,
								":come_horario_cierre"=>$hora_final,
								":come_tipo_comercio"=>$tcodigo,
								":come_telefono"=>$telefono,
                                ":come_direccion"=>$direccion,
								":come_responsable"=>$responsable,
								":come_imagen"=>$imagen,
								":codigo"=>$codigo
							);
			$objeto_datos = new db_funciones();
			$arreglo_datos = $objeto_datos->insert_datos($consulta, $parametros, $form_padre);
			return;
		}
		//editar
		//eliminar
		
		if ($accion == "eliminar") {
			$consulta = "DELETE FROM delivery_bici_2021.come_comercio
            WHERE come_codigo=:codigo;";
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
										<img src="assets/img/app/empresas/min_<?php echo $imagen; ?>" class="img-fluid" alt="Sin vista miniatura de imagen">
													</div>
										</div>	

										<?php
										//public function caja_texto($id,$titulo, $placeholder, $columnas, $tipo, $habilitado, $requerido, $valor ='')
											$fgenerales->caja_texto('codigo', 'Código', 'Nuevo Código', '2', 'text','0',0,$codigo);
										?>
										
										<input type="hidden" name="accion" id="accion" value="">
										
									</div>
									<div class="row">
										<?php
										////public function caja_texto($id,$titulo, $placeholder, $columnas, $tipo, $habilitado, $requerido, $valor ='')
											$fgenerales->caja_texto('nombre', 'Nombre Comercio o Afiliado', 'Nombre de comercio', '8', 'text','1','1',$nombre);
										?>
									</div>
									<div class="row">
										<?php
											$fgenerales->caja_texto('hora_inicio', 'Hora Apertura', 'Hora Apertura', '2', 'time','1',0,$hora_inicio);
										?>
                                        <?php
											$fgenerales->caja_texto('hora_final', 'Hora Cierre', 'Hora Cierre', '2', 'time','1',0,$hora_final);

											$fgenerales->caja_texto('telefono', 'Telefono', 'Numero de contacto', '4', 'text','1','0',$telefono);
										?>
										
									</div>
									<div class="row">
										<?php
											$fgenerales->caja_texto('direccion', 'Direccion', 'Direccion', '4', 'text','1','1',$direccion);

											$fgenerales->lista_query('tcomercio','Tipo de comercios', '4', $arreglo_tcomercio,$tcodigo);

                                            
										?>

									</div>
									<div class="row">
									<?php
											$fgenerales->caja_texto('responsable', 'Responsable', 'Propietario o responsable', '4', 'text','1','1',$responsable);
										?>
										<?php
											if(@$codigo > 0)
											{
												?>
												<div class="col-md-4">
													<div class="form-group">
													<label for="imagen">Subir Imagen</label>
													<a href="sis_imagen_comercio.php?destino=empresas&codigo=<?php echo $codigo; ?>" target="_self" rel="noopener noreferrer"><button id="btn_regresar" type="button" class="btn btn-default btn-block"><i class="fa fa-file-image-o"></i>&nbsp;&nbsp; &nbsp; Subir imagen &nbsp;&nbsp;</button></a> 
													</div>
												</div>

												<?php
											}
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
