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
	$nombre_form = "produto";
	$form_donde_regresar =  "sis_producto.php";
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


	@$codigo = 0;
	
	if(!empty($fgenerales->miget('codigo')))
	{
		@$codigo = $fgenerales->miget('codigo');

		$consulta = "SELECT prod_codigo codigo, prod_codigo_barra barra, prod_nombre nombre, prod_descripcion descripcion,
                        prod_existencia existencia, prod_unidad unidad, prod_costo_compra costo_compra, prod_costo_agregado flete,
                        prod_costo_total costo_total, prod_precio precio,prod_cod_laboratorio laboratorio, prod_cod_proveedor proveedor,
                        prod_fecha fecha
                    FROM prod_producto
                    where prod_codigo =".$codigo;
		$parametros = array();
		$arreglo_datos = $objeto_datos->get_datos($consulta,$parametros);

		$consulta_equi = "SELECT equi_codigo codigo, equi_nombre nombre, equi_codigo_producto codigo_producto, 
							equi_cantidad cantidad, equi_costo costo, equi_costo_extra costo_extra, equi_precio precio,
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
		}

	}

    
    @$arreglo_prov = "";
    @$arreglo_lab = "";

    $objeto_datos_load= new db_funciones();
    $sql_proveedor = "select '0' as v, '- Seleccione'  as t
                    union ALL
                    select prov_codigo as v, prov_nombre  as t from prov_proveedor";

    @$arreglo_prov= $objeto_datos_load->get_datos($sql_proveedor, array());

    $sql_lab = "select '0' as v, '- Seleccione'  as t
                union ALL
                select labo_codigo as v, labo_nombre  as t from labo_laboratorio;";

    @$arreglo_lab= $objeto_datos_load->get_datos($sql_lab, array());

	if(!empty($fgenerales->mipost('accion')))
	{
		@$codigo = $_POST["codigo"]; 
		@$barra = $_POST["barra"];
        @$nombre = $_POST["nombre"];
        @$descripcion = $_POST["descripcion"];
        @$costo_compra = $_POST["costo_compra"];
        @$flete = $_POST["flete"];
        @$costo_total = $_POST["costo_total"];
        @$existencia = $_POST["existencia"];
        @$unidad = $_POST["unidad"];
        @$precio = $_POST["precio"];
        @$laboratorio = $_POST["laboratorio"];
        @$proveedor = $_POST["proveedor"]; 

        $costo_compra = trim($costo_compra) == '' ? 0: $costo_compra;
        $flete = trim($flete) == '' ? 0: $flete;
        $costo_total = trim($costo_total) == '' ? 0: $costo_total;
        $existencia = trim($existencia) == '' ? 0: $existencia;
        $precio = trim($precio) == '' ? 0: $precio;


        @$historial_descripcion = "c:$codigo, n: $nombre, d:$descripcion, b:$barra, c1:$costo_compra, c2:$flete, c3:$costo_total, p:$precio, e:$existencia, l:$laboratorio, p:$proveedor";

		//guardar
		@$accion = $fgenerales->mipost('accion');
		if ($accion == "nuevo") {

			$consulta = "INSERT INTO prod_producto
                        (prod_codigo_barra, prod_nombre, prod_descripcion, prod_existencia, prod_unidad, prod_costo_compra,
                         prod_costo_agregado, prod_costo_total, prod_precio, prod_cod_laboratorio, prod_cod_proveedor, prod_fecha)
                        VALUES(:barra, :nombre, :descripcion, :existencia, :unidad, :costo_compra, :flete, :costo_total, :precio, :laboratorio, :proveedor, CURRENT_TIMESTAMP);";
			$parametros = array(
                                ":barra"=>$barra,
                                ":nombre"=>$nombre,
                                ":descripcion"=>$descripcion,
                                ":existencia"=>$existencia,
                                ":unidad"=>$unidad,
                                ":costo_compra"=>$costo_compra,
                                ":flete"=>$flete,
                                ":costo_total"=>$costo_total,
                                ":precio"=>$precio,
                                ":laboratorio"=>$laboratorio,
                                ":proveedor"=>$proveedor);

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
			$consulta = "UPDATE prod_producto
                            SET prod_codigo_barra=:barra, prod_nombre=:nombre, prod_descripcion=:descripcion,
                            prod_existencia=:existencia, prod_unidad=:unidad, prod_costo_compra=:costo_compra,
                            prod_costo_agregado=:flete, prod_costo_total=:costo_total, prod_precio=:precio,
                            prod_cod_laboratorio=:laboratorio, prod_cod_proveedor=:proveedor,
                            prod_fecha=CURRENT_TIMESTAMP
                    WHERE prod_codigo= :codigo";

			$parametros = array(
                        ":barra"=>$barra,
                        ":nombre"=>$nombre,
                        ":descripcion"=>$descripcion,
                        ":existencia"=>$existencia,
                        ":unidad"=>$unidad,
                        ":costo_compra"=>$costo_compra,
                        ":flete"=>$flete,
                        ":costo_total"=>$costo_total,
                        ":precio"=>$precio,
                        ":laboratorio"=>$laboratorio,
                        ":proveedor"=>$proveedor,
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
			$consulta = "DELETE FROM prod_producto
                        WHERE prod_codigo=:codigo;";
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

									<ul class="nav nav-tabs" id="myForm">
									<li class="active"><a href="#one">General</a></li>
									<li><a href="#two">Equivalencia</a></li>
									<li><a href="#three">Vencimiento</a></li>
									</ul>

									
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
														$fgenerales->caja_texto('nombre', 'Nombre', 'Nombre producto', '4', 'text','1','1',$nombre);
														$fgenerales->caja_texto('descripcion', 'Descripcion', 'Descripcion y detalles', '5', 'text','1','1',$descripcion);
													?>
												</div>
												<div class="row">
													<?php
														//public function caja_texto($id,$titulo, $placeholder, $columnas, $tipo, $habilitado, $requerido, $valor ='')
														$fgenerales->caja_texto('costo_compra', 'Costo compra', '$ Costo de compra', '3', 'text','1','1',$costo_compra);
														$fgenerales->caja_texto('flete', 'Costo Flete', '$ Costo extra, flete', '3', 'text','1','1',$flete);
														$fgenerales->caja_texto('costo_total', 'Costo Total', '0.00', '3', 'text',0,0,$costo_total);
													?>
												</div>

												<div class="row">
													<?php
														//public function caja_texto($id,$titulo, $placeholder, $columnas, $tipo, $habilitado, $requerido, $valor ='')
														$fgenerales->caja_texto('existencia', 'Existencia', '0', '3', 'text','1','1',$existencia);
														$fgenerales->caja_texto('unidad', 'Unidad', 'Unidad, caja, litro, etc', '3', 'text','1','1',$unidad);
														$fgenerales->caja_texto('precio', 'Precio venta', '0', '3', 'text','1','1',$precio);
													?>
												</div>
												<div class="row">
													<?php

														$fgenerales->lista_query('laboratorio','Lista Laboratorios', '4', $arreglo_lab,$laboratorio);
														$fgenerales->lista_query('proveedor','Lista Proveedores', '4', $arreglo_prov,$proveedor);
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
												</div>

											</form>
										</div>
										<div class="tab-pane" id="two">
										<div class="row">
										<a href="sis_equivalencia.php?equivalencia=0&codigo_producto=<?php echo $codigo;?>"><label class="btn btn-primary bnt-block">Nueva Equivalencia</button></a>
											<table class="table table-hover">
												<thead>
													<tr>
														<th></th>
														<th>Equivalencia</th>
														<th>Unidades</th>
														<th>Precio</th>
														<th>Editar</th>
													</tr>
												</thead>
												<tbody>
														<?php
															foreach ($arreglo_equivalencias as $item_equi) {
																?>
															<tr>
																<td>
																	<?php echo $item_equi["codigo"]; ?>
																</td>

																<td>
																	<?php echo $item_equi["nombre"]; ?>
																</td>
																<td>
																	<?php echo $item_equi["cantidad"]."  ".$unidad. ""; ?>
																</td>
																<td>
																	<?php echo "$".$item_equi["precio"]; ?>
																</td>
																<td>
																<a href='<?php echo "sis_equivalencia.php"; ?>?equivalencia=<?php echo $item_equi["codigo"]."&codigo_producto=$codigo"; ?>'><i class="lnr lnr-cog"></i> <span>&nbsp;&nbsp;Configuración&nbsp;&nbsp;</span></a>
																</td>
															</tr>


															<?php
																}

																?>
												</tbody>
											</table>
										</div>
										</div>
										<div class="tab-pane" id="three">
										<button type="submit" class="btn btn-success">Submit</button>
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
