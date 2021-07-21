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

	$modelo = 'Lote';
	$nombre_form = "lote";
	$titulo_form = "Modulo Lote Vencimiento";
    $form_donde_regresar="sis_producto_crud.php?codigo=";
	$descripcion_form = 'Modulo Lote de Vencimientos.';
    $nombre_negocio = $objeto_datos->empresa;
	$titulo_form = "Conf. " . $titulo_form;



	@$venc_codigo = '';
    @$venc_lote = '';
    @$venc_producto_codigo = '';
    @$venc_cantidad = '';
    @$venc_cantidad_restante = '';
    @$venc_fecha = '';
    @$venc_fecha_vencimiento = '';
    @$venc_sucursal = ''; 

    @$venc_codigo = $fgenerales->miget('lote');
    @$venc_producto_codigo = $fgenerales->miget('codigo_producto');
	@$codigo = 0;
	
	if(!empty($fgenerales->miget('lote')))
	{



		$consulta = "SELECT venc_codigo,venc_lote,venc_producto_codigo,venc_cantidad,venc_cantidad_restante,venc_fecha,venc_fecha_vencimiento,venc_sucursal
                    FROM venc_vencimiento
                    WHERE 
                    venc_codigo= ".$venc_codigo."
                    and
                    venc_producto_codigo = ".$venc_producto_codigo;
		$parametros = array();
		$arreglo_datos = $objeto_datos->get_datos($consulta,$parametros);

		foreach ($arreglo_datos as $item) 
		{
			@$venc_codigo = $item['venc_codigo'];
            @$venc_lote = $item['venc_lote'];
            @$venc_producto_codigo = $item['venc_producto_codigo'];
            @$venc_cantidad = $item['venc_cantidad'];
            @$venc_cantidad_restante = $item['venc_cantidad_restante'];
            @$venc_fecha = $item['venc_fecha'];
            @$venc_fecha_vencimiento = $item['venc_fecha_vencimiento'];
            @$venc_sucursal = $item['venc_sucursal'];  
		}
	}

	if(!empty($fgenerales->mipost('accion')))
	{
		@$codigo = $_POST["codigo"]; 
		@$venc_codigo = $_POST["venc_codigo"];
        @$venc_lote = $_POST["venc_lote"];
        @$venc_producto_codigo = $_POST["venc_producto_codigo"];
        @$venc_cantidad = $_POST["venc_cantidad"];
        @$venc_cantidad_restante = $_POST["venc_cantidad_restante"];
        @$venc_fecha = $_POST["venc_fecha"];
        @$venc_fecha_vencimiento = $_POST["venc_fecha_vencimiento"];
        @$venc_sucursal = $_POST["venc_sucursal"]; 

		//guardar
		@$accion = $fgenerales->mipost('accion');
		if ($accion == "nuevo") {

			$consulta = "INSERT INTO venc_vencimiento
            (venc_lote, venc_producto_codigo,
             venc_cantidad, venc_cantidad_restante,
              venc_fecha,
              venc_fecha_vencimiento, venc_sucursal)
            VALUES(:venc_lote, :venc_producto_codigo,
             :venc_cantidad, :venc_cantidad_restante,
            CURRENT_TIMESTAMP,
             :venc_fecha_vencimiento, :venc_sucursal);";
			$parametros = array( ":venc_lote"=>$venc_lote,
                                ":venc_producto_codigo"=>$venc_producto_codigo,
                                ":venc_cantidad"=>$venc_cantidad,
                                ":venc_cantidad_restante"=>$venc_cantidad_restante,
                                ":venc_fecha_vencimiento"=>$venc_fecha_vencimiento,
                                ":venc_sucursal"=>$venc_sucursal,
							        );

			$objeto_datos = new db_funciones();

            @$parametros_historial = array(":tabla" => 'Lote Vencimiento',
					":descripcion" => "crea,l: $venc_lote, c: $venc_cantidad, cr: $venc_cantidad_restante, f: $venc_fecha_vencimiento, s: $venc_sucursal ",
					":usuario" => $_SESSION['nombre_usuario'],
					":cod_usuario" => $_SESSION['usua_codigo']);
            $objeto_datos->insert_historial($parametros_historial);

			$arreglo_datos = $objeto_datos->insert_datos($consulta, $parametros, $form_donde_regresar.$venc_producto_codigo);
			return;
		}

		//guardar

		//editar
		if ($accion == "modificar") {
			$consulta = "UPDATE venc_vencimiento
                                SET venc_lote=:venc_lote, venc_cantidad=:venc_cantidad, 
                                        venc_cantidad_restante=:venc_cantidad_restante,
                                         venc_fecha=CURRENT_TIMESTAMP,
                                        venc_fecha_vencimiento=:venc_fecha_vencimiento,
                                         venc_sucursal=:venc_sucursal 
                                WHERE venc_codigo=:venc_codigo;";
			$parametros = array(":venc_lote"=>$venc_lote,
                                ":venc_cantidad"=>$venc_cantidad,
                                ":venc_cantidad_restante"=>$venc_cantidad_restante,
                                ":venc_fecha_vencimiento"=>$venc_fecha_vencimiento,
                                ":venc_sucursal"=>$venc_sucursal,
                                ":venc_codigo"=>$venc_codigo,);
			$objeto_datos = new db_funciones();

            @$parametros_historial = array(":tabla" => 'lote vencimiento',
            ":descripcion" => "modifico,l: $venc_lote, c: $venc_cantidad, cr: $venc_cantidad_restante, f: $venc_fecha_vencimiento, s: $venc_sucursal ",
            ":usuario" => $_SESSION['nombre_usuario'],
            ":cod_usuario" => $_SESSION['usua_codigo']);

            $objeto_datos->insert_historial($parametros_historial);
			$arreglo_datos = $objeto_datos->insert_datos($consulta, $parametros, $form_donde_regresar.$venc_producto_codigo);
			return;
		}
		//editar
		//eliminar
		
		if ($accion == "eliminar") {
			$consulta = "DELETE FROM venc_vencimiento
                        WHERE venc_codigo=:codigo;";
			$parametros = array(":codigo"=>$venc_codigo);

			$objeto_datos = new db_funciones();

            @$parametros_historial = array(":tabla" => 'lote vencimiento',
                                    ":descripcion" => "elimino,n: $venc_lote",
                                    ":usuario" => $_SESSION['nombre_usuario'],
                                    ":cod_usuario" => $_SESSION['usua_codigo']);
            $objeto_datos->insert_historial($parametros_historial);
            
			$arreglo_datos = $objeto_datos->insert_datos($consulta, $parametros,$form_donde_regresar.$venc_producto_codigo);
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

var campos = ["venc_lote"];


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
											$fgenerales->caja_texto('venc_codigo', 'Código', 'Nuevo Código', '2', 'text','0',0,$venc_codigo);
										?>
										<input type="hidden" name="accion" id="accion" value="">

										<input type="hidden" name="venc_producto_codigo" id="venc_producto_codigo" value="<?php echo @$venc_producto_codigo;  ?>">
										
									</div>
									<div class="row">
										<?php
										////public function caja_texto($id,$titulo, $placeholder, $columnas, $tipo, $habilitado, $requerido, $valor ='')
                                        @$fgenerales->caja_texto('venc_lote', 'Lote', '', '4', 'text','1','1',$venc_lote); 
										?>
									</div>
                                    <div class="row">
										<?php
										////public function caja_texto($id,$titulo, $placeholder, $columnas, $tipo, $habilitado, $requerido, $valor ='')
                                        //@$fgenerales->caja_texto('venc_producto_codigo', 'venc_producto_codigo', 'venc_producto_codigo', '3', 'text','1','1',$venc_producto_codigo);
                                        @$fgenerales->caja_texto('venc_cantidad', 'Cantidad Unidades', '', '3', 'text','1','1',$venc_cantidad);
                                        @$fgenerales->caja_texto('venc_cantidad_restante', 'Cantidad Restante', '', '3', 'text','1','1',$venc_cantidad_restante); 
										?>
									</div>
                                    <div class="row">
										<?php
										@$fgenerales->caja_texto('venc_fecha_vencimiento', 'Fecha Vencimiento', '', '3', 'date','1','1',$venc_fecha_vencimiento);
                                       ?>
                                        <div class="form-group col-sm-3  col-md-3">
                                        <label for="sel1">Sucursal:</label>
                                          <select class="form-control" id="venc_sucursal" name="venc_sucursal" required >
                                          <!-- <option data-valor="0" >
                                            --Seleccione
                                          </option> -->
                                          <?php
                                              if(SS1 =="si" )
                                              {
                                                if($venc_sucursal == 1)
                                                {
                                                    $selecionado = " selected='selected' ";
                                                }
                                                else
                                                {
                                                    $selecionado = " ";
                                                }

                                                ?>
                                                <option data-valor="1" value="1" <?php echo  $selecionado; ?> >
                                                <?php
                                                  echo SS1_n;
                                                ?>
                                                </option>
                                                <?php
                                              }
                                            ?>
                                            <?php
                                              if(SS2 =="si" )
                                              {
                                                if($venc_sucursal == 2)
                                                {
                                                    $selecionado = " selected='selected' ";
                                                }
                                                else
                                                {
                                                    $selecionado = " ";
                                                }

                                                ?>
                                                <option data-valor="2" value="2" <?php echo  $selecionado; ?>>
                                                <?php
                                                  echo SS2_n;
                                                ?>
                                                </option>
                                                <?php
                                              }
                                            ?>
                                            <?php
                                              if(SS3 =="si" )
                                              {
                                                if($venc_sucursal == 3)
                                                {
                                                    $selecionado = " selected='selected' ";
                                                }
                                                else
                                                {
                                                    $selecionado = " ";
                                                }
                                                ?>
                                                <option data-valor="3" value="3" <?php echo  $selecionado; ?>>
                                                <?php
                                                  echo SS3_n;
                                                ?>
                                                </option>
                                                <?php
                                              }
                                            ?>
                                            <?php
                                              if(SS4 =="si" )
                                              {
                                                if($venc_sucursal == 4)
                                                {
                                                    $selecionado = " selected='selected' ";
                                                }
                                                else
                                                {
                                                    $selecionado = " ";
                                                }
                                                ?>
                                                <option data-valor="4" value="4" <?php echo  $selecionado; ?>>
                                                <?php
                                                  echo SS4_n;
                                                ?>
                                                </option>
                                                <?php
                                              }
                                            ?>
                                            <?php
                                              if(SS5 =="si" )
                                              {
                                                if($venc_sucursal == 5)
                                                {
                                                    $selecionado = " selected='selected' ";
                                                }
                                                else
                                                {
                                                    $selecionado = " ";
                                                }
                                                ?>
                                                <option data-valor="5" value="5" <?php echo  $selecionado; ?>>
                                                <?php
                                                  echo SS5_n;
                                                ?>
                                                </option>
                                                <?php
                                              }
                                            ?>
                                            
                                  
                                          </select>
                                      </div> 

									</div>
									<div class="form-row">
									<?php
										if($venc_codigo == 0)
										{
											?>
											<button id="btn_nuevo" type="button" class="btn btn-success"><i class="fa fa-check-circle"></i> Crear <?php echo ' '.$nombre_form; ?></button>
											<a href="<?php echo $form_donde_regresar.$venc_producto_codigo; ?>" target="_self" rel="noopener noreferrer"><button id="btn_regresar" type="button" class="btn btn-primary"><i class="fa fa-warning"></i>&nbsp;&nbsp; &nbsp; Regresar &nbsp;&nbsp;</button></a> 
											<?php
										}
										else
										{
											?>
											<button id="btn_modificar" type="button" class="btn btn-success"><i class="fa fa-edit"></i> Editar <?php echo ' '.$nombre_form; ?></button>
											<button id="btn_eliminar" type="button" class="btn btn-danger"><i class="fa fa-trash-o"></i> Borrar <?php echo ' '.$nombre_form; ?></button>
											<a href="<?php echo $form_donde_regresar.$venc_producto_codigo; ?>" target="_self" rel="noopener noreferrer"><button id="btn_regresar" type="button" class="btn btn-primary"><i class="fa fa-warning"></i>&nbsp;&nbsp; &nbsp; Regresar &nbsp;&nbsp;</button></a> 
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
