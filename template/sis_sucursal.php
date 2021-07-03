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

	$modelo = 'Sucursal';
	$nombre_form = "sucursal";
	$form_donde_regresar =  "sis_sucursal.php";
	$titulo_form = "Modulo Sucursal";
	$descripcion_form = 'Modulo Sucursales o agencias.';
    $nombre_negocio = $objeto_datos->empresa;
	$titulo_form = "Conf. " . $titulo_form;



    @$nombre1 = '';
    @$nombre2 = '';
    @$nombre3 = '';
    @$nombre4 = '';
    @$nombre5 = '';

    @$desc1 = '';
    @$desc2 = '';
    @$desc3 = '';
    @$desc4 = '';
    @$desc5 = '';

    @$orden1 = '';
    @$orden2 = '';
    @$orden3 = '';
    @$orden4 = '';
    @$orden5 = ''; 

//RECUPERAR SUCURSALES
		$consulta = "SELECT  sucu_nombre nombre, ifnull(sucu_descripcion, ' - ') descr, sucu_orden orden
                         FROM sucu_sucursal
                         order by sucu_codigo;";
		$parametros = array();
		$arreglo_datos = $objeto_datos->get_datos($consulta,$parametros);

		
//RECUPERAR SUCURSALES

if ($_SERVER['REQUEST_METHOD'] == 'POST') {	
		@$codigo = $_POST["codigo"]; 
		@$nombre = $_POST["nombre"]; 

        @$nombre1 = $_POST["nombre1"];
        @$nombre2 = $_POST["nombre2"];
        @$nombre3 = $_POST["nombre3"];
        @$nombre4 = $_POST["nombre4"];
        @$nombre5 = $_POST["nombre5"];
        @$desc1 = $_POST["descr1"];
        @$desc2 = $_POST["descr2"];
        @$desc3 = $_POST["descr3"];
        @$desc4 = $_POST["descr4"];
        @$desc5 = $_POST["descr5"];
        @$orden1 = $_POST["orden1"];
        @$orden2 = $_POST["orden2"];
        @$orden3 = $_POST["orden3"];
        @$orden4 = $_POST["orden4"];
        @$orden5 = $_POST["orden5"]; 

        $consulta_upd = "";
        echo $consulta_upd;

        $consulta_upd1 = "UPDATE sucu_sucursal
            SET
            sucu_nombre=:nombre1, sucu_descripcion=:descr1, sucu_orden=:orden1
            WHERE sucu_codigo=1;";
            $parametros1 = array(':nombre1'=>$nombre1, ':descr1'=>$desc1, ':orden1'=>$orden1);


            $consulta_upd2 = "UPDATE sucu_sucursal
            SET
            sucu_nombre=:nombre2, sucu_descripcion=:descr2, sucu_orden=:orden2
            WHERE sucu_codigo=2;";
            $parametros2 = array(':nombre2'=>$nombre2, ':descr2'=>$desc2, ':orden2'=>$orden2);


            $consulta_upd3 = "UPDATE sucu_sucursal
            SET
            sucu_nombre=:nombre3, sucu_descripcion=:descr3, sucu_orden=:orden3
            WHERE sucu_codigo=3;";
            $parametros3 = array(':nombre3'=>$nombre3, ':descr3'=>$desc3, ':orden3'=>$orden3);


            $consulta_upd4 = "UPDATE sucu_sucursal
            SET
            sucu_nombre=:nombre4, sucu_descripcion=:descr4, sucu_orden=:orden4
            WHERE sucu_codigo=4;";
            $parametros4 = array(':nombre4'=>$nombre4, ':descr4'=>$desc4, ':orden4'=>$orden4);


            $consulta_upd5 = "UPDATE sucu_sucursal
            SET
            sucu_nombre=:nombre5, sucu_descripcion=:descr5, sucu_orden=:orden5
            WHERE sucu_codigo=5;";
            $parametros5 = array(':nombre5'=>$nombre5, ':descr5'=>$desc5, ':orden5'=>$orden5); 


			$objeto_datos = new db_funciones();

            @$parametros_historial = array(":tabla" => 'Sucursales',
            ":descripcion" => "modifico,n: agencias",
            ":usuario" => $_SESSION['nombre_usuario'],
            ":cod_usuario" => $_SESSION['usua_codigo']);

            $objeto_datos->insert_historial($parametros_historial);
			
            $objeto_datos->insert_datos_2($consulta_upd1, $parametros1);
            $objeto_datos->insert_datos_2($consulta_upd2, $parametros2);
            $objeto_datos->insert_datos_2($consulta_upd3, $parametros3);
            $objeto_datos->insert_datos_2($consulta_upd4, $parametros4);
            $objeto_datos->insert_datos_2($consulta_upd5, $parametros5);
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
										?>
										<input type="hidden" name="accion" id="accion" value="">
										
									</div>
									
										<?php
                                         $contador = 1;
									foreach ($arreglo_datos as $item) 
                                    {
                                        echo "<div class='row'>";
                                        @$fgenerales->caja_texto('nombre'.$contador, 'Agencia #'.$contador, 'nombre'.$contador, '3', 'text','1','1',$item['nombre']);
                                        @$fgenerales->caja_texto('descr'.$contador, 'Descripción #'.$contador, 'descr'.$contador, '3', 'text','1','1',$item['descr']);
                                        @$fgenerales->caja_texto('orden'.$contador, 'Orden '.$contador, 'orden'.$contador, '3', 'text','1','1',$item['orden']);

                                        $contador++;
                                        echo "<hr /> </div>";
                                    }

                               
										?>
									<input type="hidden" id="nombre" name="nombre" value="123456" />
									<div class="form-row">
									
											<button id="btn_nuevo" type="button" class="btn btn-success">
                                                <i class="fa fa-check-circle"></i> 
                                                Modificar <?php echo ' '.$nombre_form; ?>
                                            </button>
                                            <a href="home.php" target="_self" rel="noopener noreferrer">
                                            <button id="btn_regresar" type="button" class="btn btn-primary">
                                            <i class="fa fa-warning"></i>
                                            &nbsp;&nbsp; &nbsp; Regresar &nbsp;&nbsp;
                                            </button></a> 
								
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
