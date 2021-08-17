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

	$modelo = 'Talonarios';
	$nombre_form = "talonario";
	$form_donde_regresar =  "sis_talonario.php";
	$titulo_form = "Modulo Talonarios";
	$descripcion_form = 'Modulo Talonarios y Correlativos de venta.';
    $nombre_negocio = $objeto_datos->empresa;
	$titulo_form = "Conf. " . $titulo_form;



    @$codigo1 = 0;
    @$codigo2 = 0;
    @$codigo3 = 0;
    @$codigo4 = 0;
    @$codigo5 = 0;

    @$sucursal_codigo1 = '';
    @$sucursal_codigo2 = '';
    @$sucursal_codigo3 = '';
    @$sucursal_codigo4 = '';
    @$sucursal_codigo5 = '';

    @$sucursal1 = '';
    @$sucursal2 = '';
    @$sucursal3 = '';
    @$sucursal4 = '';
    @$sucursal5 = '';

    @$serie1 = '';
    @$serie2 = '';
    @$serie3 = '';
    @$serie4 = '';
    @$serie5 = '';

    @$correlativo1 = '';
    @$correlativo2 = '';
    @$correlativo3 = '';
    @$correlativo4 = '';
    @$correlativo5 = ''; 

    @$talo1 = '';
    @$talo2 = '';
    @$talo3 = '';
    @$talo4 = '';
    @$talo5 = ''; 

//RECUPERAR SUCURSALES
		$consulta = "SELECT  talo_codigo codigo, talo_sucursal_codigo sucursal_codigo , ss.sucu_nombre sucursal, talo_serie serie,  ifnull(talo_correlativo , 0) as correlativo,
                    ifnull(talo_comanda , 0) as talo_comanda
                    FROM talo_talonario tt 
                    inner join sucu_sucursal ss on ss.sucu_codigo  = tt.talo_sucursal_codigo 
                    order by talo_sucursal_codigo ";
		$parametros = array();
		$arreglo_datos = $objeto_datos->get_datos($consulta,$parametros);

		
//RECUPERAR SUCURSALES

if ($_SERVER['REQUEST_METHOD'] == 'POST') {	
    @$codigo1 = $_POST["codigo1"];
    @$codigo2 = $_POST["codigo2"];
    @$codigo3 = $_POST["codigo3"];
    @$codigo4 = $_POST["codigo4"];
    @$codigo5 = $_POST["codigo5"];

    @$sucursal_codigo1 = $_POST["sucursal_codigo1"];
    @$sucursal_codigo2 = $_POST["sucursal_codigo2"];
    @$sucursal_codigo3 = $_POST["sucursal_codigo3"];
    @$sucursal_codigo4 = $_POST["sucursal_codigo4"];
    @$sucursal_codigo5 = $_POST["sucursal_codigo5"];

    @$sucursal1 = $_POST["sucursal1"];
    @$sucursal2 = $_POST["sucursal2"];
    @$sucursal3 = $_POST["sucursal3"];
    @$sucursal4 = $_POST["sucursal4"];
    @$sucursal5 = $_POST["sucursal5"];

    @$serie1 = $_POST["serie1"];
    @$serie2 = $_POST["serie2"];
    @$serie3 = $_POST["serie3"];
    @$serie4 = $_POST["serie4"];
    @$serie5 = $_POST["serie5"];

    @$correlativo1 = $_POST["correlativo1"];
    @$correlativo2 = $_POST["correlativo2"];
    @$correlativo3 = $_POST["correlativo3"];
    @$correlativo4 = $_POST["correlativo4"];
    @$correlativo5 = $_POST["correlativo5"]; 

    @$talo1 = $_POST["comanda1"];
    @$talo2 = $_POST["comanda2"];
    @$talo3 = $_POST["comanda3"];
    @$talo4 = $_POST["comanda4"];
    @$talo5 = $_POST["comanda5"]; 


        $consulta_upd = "";
        echo $consulta_upd;

            $consulta_upd1 = "UPDATE talo_talonario
                            SET  talo_serie= :talo_serie, talo_correlativo=:talo_correlativo, talo_comanda=:talo
                            WHERE talo_codigo=:codigo;";
            $parametros1 = array(':talo_serie'=>$serie1, ':talo_correlativo'=>$correlativo1, ':talo'=>$talo1, ':codigo'=>$codigo1);

            $consulta_upd2 = "UPDATE talo_talonario
                            SET  talo_serie= :talo_serie, talo_correlativo=:talo_correlativo, talo_comanda=:talo
                            WHERE talo_codigo=:codigo;";
            $parametros2 = array(':talo_serie'=>$serie2, ':talo_correlativo'=>$correlativo2,  ':talo'=>$talo2, ':codigo'=>$codigo2);

            $consulta_upd3 = "UPDATE talo_talonario
            SET  talo_serie= :talo_serie, talo_correlativo=:talo_correlativo, talo_comanda=:talo
            WHERE talo_codigo=:codigo;";
            $parametros3 = array(':talo_serie'=>$serie3, ':talo_correlativo'=>$correlativo3,  ':talo'=>$talo3, ':codigo'=>$codigo3);

            $consulta_upd4 = "UPDATE talo_talonario
            SET  talo_serie= :talo_serie, talo_correlativo=:talo_correlativo, talo_comanda=:talo
            WHERE talo_codigo=:codigo;";
            $parametros4 = array(':talo_serie'=>$serie4, ':talo_correlativo'=>$correlativo4, ':talo'=>$talo4,  ':codigo'=>$codigo4);

            $consulta_upd5 = "UPDATE talo_talonario
                            SET  talo_serie= :talo_serie, talo_correlativo=:talo_correlativo, talo_comanda=:talo
                            WHERE talo_codigo=:codigo;";
            $parametros5 = array(':talo_serie'=>$serie5, ':talo_correlativo'=>$correlativo5, ':talo'=>$talo5,  ':codigo'=>$codigo5);

			$objeto_datos = new db_funciones();

            @$parametros_historial = array(":tabla" => 'Talonarios',
            ":descripcion" => "modifico,n: agencias",
            ":usuario" => $_SESSION['nombre_usuario'],
            ":cod_usuario" => $_SESSION['usua_codigo']);

            $objeto_datos->insert_historial($parametros_historial);
			
            $objeto_datos->insert_datos_2($consulta_upd1, $parametros1);
            $objeto_datos->insert_datos_2($consulta_upd2, $parametros2);
            $objeto_datos->insert_datos_2($consulta_upd3, $parametros3);
            $objeto_datos->insert_datos_2($consulta_upd4, $parametros4);
            $objeto_datos->insert_datos_2($consulta_upd5, $parametros5);

		 header('location:sis_talonario.php');

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
                                        echo "<hr /><div class='row'>
                                        <h3>".$item['sucursal']."</h3>
                                        <input type='hidden' id='codigo$contador' name='codigo$contador' value='$contador' />
                                        ";
                                       
                                        @$fgenerales->caja_texto('serie'.$contador, 'Serie #'.$contador, 'serie'.$contador, '3', 'text','1','1',$item['serie']);
                                        @$fgenerales->caja_texto('correlativo'.$contador, 'Correlativo '.$contador, 'correlativo'.$contador, '3', 'text','1','1',$item['correlativo']);
                                        @$fgenerales->caja_texto('comanda'.$contador, 'Comanda '.$contador, 'comanda'.$contador, '3', 'text','1','1',$item['talo_comanda']);

                                        $contador++;
                                        echo " </div><hr />";
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
