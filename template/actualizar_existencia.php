<?php
     session_start();
	 if(!isset($_SESSION['usua_codigo']))
	 {
		 header('location:index.php');
	 }
	 $formulario_acceso="prod_crud";


     require '../src_php/db/db_funciones.php';
     require '../src_php/db/funciones_generales.php';
     $fgenerales = new funciones_generales();     
     $objeto_datos= new db_funciones(); 

	$modelo = 'producto';
	$nombre_form = "Existencias";
	$form_donde_regresar =  "sis_producto_crud.php";
	$titulo_form = "Modulo $modelo";
	$descripcion_form = "$titulo_form, costos, precios y existencias.";
    $nombre_negocio = $objeto_datos->empresa;
	$titulo_form = "Conf. " . $titulo_form;
	$arreglo_equivalencias = array();


	@$codigo = ""; 
	@$barra = "";
	@$nombre = "";
	@$descripcion = "";
	@$costo_compra = "";
	@$flete = "";
	@$costo_total = "";
	@$existencia = "";
	@$unidad = "";
	@$precio = "";
	@$laboratorio = "";
	@$proveedor = "";

	$existencia1= 0;
	$existencia2= 0;
	$existencia3= 0;
	$existencia4= 0;
	$existencia5= 0;


	@$codigo = 0;
	
	if(!empty($fgenerales->miget('codigo_producto')))
	{
		@$codigo = $fgenerales->miget('codigo_producto');

		$consulta = "SELECT prod_codigo codigo, prod_codigo_barra barra, prod_nombre nombre, prod_descripcion descripcion,
                        prod_existencia existencia, prod_unidad unidad, prod_costo_compra costo_compra, prod_costo_agregado flete,
                        prod_costo_total costo_total, prod_precio precio,prod_cod_laboratorio laboratorio, prod_cod_proveedor proveedor,
                        prod_fecha fecha, prod_existencia1 existencia1, prod_existencia2 existencia2,
						prod_existencia3 existencia3, prod_existencia4 existencia4, prod_existencia5 existencia5
                    FROM prod_producto
                    where prod_codigo =".$codigo;
		$parametros = array();
		$arreglo_datos = $objeto_datos->get_datos($consulta,$parametros);

		$consulta_equi = "SELECT equi_codigo codigo, equi_nombre nombre, equi_codigo_producto codigo_producto, 
							equi_cantidad cantidad, equi_costo costo, equi_costo_extra costo_extra, equi_costo_total costo_total, equi_precio precio,
							 equi_fecha fecha
							FROM equi_equivalencia
							where equi_codigo_producto = :codigo
							 order by equi_cantidad asc; ";
		$parametros_equi = array(":codigo"=>$codigo);							 

		$arreglo_equivalencias = $objeto_datos->get_datos($consulta_equi, $parametros_equi);

		foreach ($arreglo_datos as $item) 
		{
			@$codigo = $codigo; 
			@$barra = $item['barra'];
            @$nombre = $item['nombre'];
            @$descripcion = $item['descripcion'];
            @$costo_compra = $item['costo_compra'];
            @$flete = $item['flete'];
            @$costo_total = $item['costo_total'];
            @$existencia = $item['existencia'];
            @$unidad = $item['unidad'];
            @$precio = $item['precio'];
            @$laboratorio = $item['laboratorio'];
            @$proveedor = $item['proveedor']; 

			if(SS1 == "si")
			{
				$existencia1 =  $item['existencia1']; 
			}
			if(SS2 == "si")
			{
				$existencia2  = $item['existencia2']; 
			}
			if(SS3 == "si")
			{
				$existencia3 = $item['existencia3']; 
			}
			if(SS4 == "si")
			{
				$existencia4 = $item['existencia4']; 
			}
			if(SS5 == "si")
			{
				$existencia5 = $item['existencia5']; 
			}
		}

	}

    
    @$arreglo_prov = "";
    @$arreglo_lab = "";
if($_POST)
{

    $objeto_datos_load= new db_funciones();
    
	
		@$codigo = $_POST["codigo"]; 

        @$s1 = $_POST["s1"];
        @$h1 = $_POST["h1"];
        @$s2 = $_POST["s2"];
        @$h2 = $_POST["h2"];
        @$s3 = $_POST["s3"];
        @$h3 = $_POST["h3"];
        @$s4 = $_POST["s4"];
        @$h4 = $_POST["h4"];
        @$s5 = $_POST["s5"];
        @$h5 = $_POST["h5"]; 

        // echo @$s1;
        // echo @$h1;
        // echo @$s2;
        // echo @$h2;
        // echo @$s3;
        // echo @$h3;
        // echo @$s4;
        // echo @$h4;
        // echo @$s5;
        // echo @$h5; 


        @$historial_descripcion = " Ant1: $h1 Actual1: $s1 -Ant2: $h2 Actual2: $s2 -Ant3: $h3 Actual3: $s3 -Ant4: $h4 Actual4: $s4 -Ant5: $h5 Actual5: $s5 - ";

		//guardar

		//guardar

		//editar

        if(SS1 == 'si')
        { $consulta1 = 'UPDATE prod_producto
        SET prod_existencia1 = :prod_existencia1
        WHERE prod_codigo= :codigo';
        
        $parametros1 = array(
        ':codigo'=>$codigo,
        ':prod_existencia1'=>$s1);
        $objeto_datos1 = new db_funciones();
        $arreglo_datos1 = $objeto_datos->insert_datos_2($consulta1, $parametros1);

    }
        
        if(SS2 == 'si')
        { $consulta2 = 'UPDATE prod_producto
        SET prod_existencia2 = :prod_existencia2
        WHERE prod_codigo= :codigo';
        
        $parametros2 = array(
        ':codigo'=>$codigo,
        ':prod_existencia2'=>$s2);
        $objeto_datos2 = new db_funciones();
        $arreglo_datos2 = $objeto_datos->insert_datos_2($consulta2, $parametros2);    
    }
        
        
        if(SS3 == 'si')
        { $consulta3 = 'UPDATE prod_producto
        SET prod_existencia3 = :prod_existencia3
        WHERE prod_codigo= :codigo';
        
        $parametros3 = array(
        ':codigo'=>$codigo,
        ':prod_existencia3'=>$s3);
        $objeto_datos3 = new db_funciones();
        $arreglo_datos3 = $objeto_datos->insert_datos_2($consulta3, $parametros3);

    }
        
        if(SS4 == 'si')
        { $consulta4 = 'UPDATE prod_producto
        SET prod_existencia4 = :prod_existencia4
        WHERE prod_codigo= :codigo';
        
        $parametros4 = array(
        ':codigo'=>$codigo,
        ':prod_existencia4'=>$s4);
        $objeto_datos4 = new db_funciones();
        $arreglo_datos4 = $objeto_datos->insert_datos_2($consulta4, $parametros4);

    }
        
        if(SS5 == 'si')
        { $consulta5 = 'UPDATE prod_producto
        SET prod_existencia5 = :prod_existencia5
        WHERE prod_codigo= :codigo';
        
        $parametros5 = array(
        ':codigo'=>$codigo,
        ':prod_existencia5'=>$s5);
        $objeto_datos5 = new db_funciones();
        $arreglo_datos5 = $objeto_datos->insert_datos_2($consulta5, $parametros5);

    }
        

            @$parametros_historial = array(":tabla" => "actualizo existencias",
            ":descripcion" => "edita,$historial_descripcion",
            ":usuario" => $_SESSION['nombre_usuario'],
            ":cod_usuario" => $_SESSION['usua_codigo']);
            $objeto_datos->insert_historial($parametros_historial);
		header("location:sis_producto_crud.php?codigo=$codigo");	
}	

			//actualiza producto

			//$arreglo_datos = $objeto_datos->insert_datos($consulta, $parametros, $form_donde_regresar);
			//actualiza producto


		//editar
	

?>

<!doctype html>
<html lang="es">

<head>
	<title><?php echo $titulo_form;?></title>
	<?php
		require('nav_plantilla/nav_css.php');
	?>
<script>

var campos = ["nombre", "barra"];

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

									

									
									<div class="tab-content">
										<div class="tab-pane active" id="one">
											
												
                                                <form method="POST" id="formulario" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                                <div class="row">
													<?php
														//public function caja_texto($id,$titulo, $placeholder, $columnas, $tipo, $habilitado, $requerido, $valor ='')
														$fgenerales->caja_texto('codigo', 'Código', 'Nuevo Código', '4', 'text','0',0,$codigo);
														$fgenerales->caja_texto('barra', 'Código de barras', 'Código de barras o asignele ud uno unico', '5', 'text','1','1',$barra);
													?>
													<input type="hidden" name="accion" id="accion" value="">
												</div>
												<div class="row">
													<?php
														//public function caja_texto($id,$titulo, $placeholder, $columnas, $tipo, $habilitado, $requerido, $valor ='')
														$fgenerales->caja_texto('nombre', 'Nombre', 'Nombre producto', '8', 'text','1','1',$nombre);
														
													?>
												</div>
                                                <div class="row">
                                                <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Sucursal - Agencia</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    
                                                    <?php
                                                        if(SS1 =="si" )
                                                        {
                                                            ?>
                                                            <tr>
                                                            <td>

                                                            

                                                        <?php
                                                            $fgenerales->caja_texto('s1', SS1_n, 'Nombre producto', '8', 'text','1','1',$existencia1);
                                                            $fgenerales->caja_texto('h1', "", 'Nombre producto', '8', 'hidden','1','1',$existencia1);
                                                        ?>
                                                        </td>
                                                    </tr>
                                                            <?php
                                                        }
                                                    ?>
                                                    <?php
                                                        if(SS2 =="si" )
                                                        {
                                                            ?>
                                                            <tr>
                                                            <td>
                                                            <?php
                                                                $fgenerales->caja_texto('s2', SS2_n, 'Nombre producto', '8', 'text','1','1',$existencia2);
                                                                $fgenerales->caja_texto('h2', "", 'Nombre producto', '8', 'hidden','1','1',$existencia2);
                                                            ?>
                                                            
                                                            </td>
                                                            
                                                    </tr>
                                                            <?php
                                                        }
                                                    ?>
                                                            <?php
                                                        if(SS3 =="si" )
                                                        {
                                                            ?>
                                                            <tr>
                                                            <td>
                                                            <?php
                                                                $fgenerales->caja_texto('s3', SS3_n, 'Nombre producto', '8', 'text','1','1',$existencia3);
                                                                $fgenerales->caja_texto('h3', "", 'Nombre producto', '8', 'hidden','1','1',$existencia3);
                                                            ?>
                                                            </td>
                                                    </tr>
                                                            <?php
                                                        }
                                                    ?>
                                                     <?php
                                                        if(SS4 =="si" )
                                                        {
                                                            ?>
                                                            <tr>
                                                            <td>
                                                            <?php
                                                                $fgenerales->caja_texto('s4', SS4_n, 'Nombre producto', '8', 'text','1','1',$existencia4);
                                                                $fgenerales->caja_texto('h4', "", 'Nombre producto', '8', 'hidden','1','1',$existencia4);
                                                            ?>
                                                            </td>
                                                    </tr>
                                                            <?php
                                                        }
                                                    ?>
                                                    <?php
                                                        if(SS5 =="si" )
                                                        {
                                                            ?>
                                                            <tr>
                                                            <td>
                                                            <?php
                                                                $fgenerales->caja_texto('s5', SS5_n, 'Nombre producto', '8', 'text','1','1',$existencia5);
                                                                $fgenerales->caja_texto('h5', "", 'Nombre producto', '8', 'hidden','1','1',$existencia5);
                                                            ?>
                                                            </td>
                                                    </tr>
                                                            <?php
                                                        }
                                                    ?>

                                                   
                                                    <tr>
                                                    <td>
                                                    <a href="<?php echo "sis_producto_crud.php?codigo=$codigo"; ?>" 
                                                    target="_self" rel="noopener noreferrer">
                                                    &nbsp;&nbsp; &nbsp; Regresar &nbsp;&nbsp;</button>
                                                    </a>
                                                    <input type="submit" class="btn btn-primary" value="Modificar"></button>
                                                         
                                                    </td>
                                                    <td></td>
                                                    </tr>
										</tbody>
									</table>
                                                </div>
												
												

											</form>
										</div>
										
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
<script>

$('#myForm a').click(function (e) {
      e.preventDefault();
      $(this).tab('show');
    })
</script>
</body>

</html>
