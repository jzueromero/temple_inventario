

<?php

@$buscar = $_GET['cp'];

require '../src_php/db/funciones_generales.php';
$fgenerales = new funciones_generales();   
require '../src_php/db/db_funciones.php';
$objeto_datos = new db_funciones();

$consulta = "SELECT prod_codigo codigo, prod_codigo_barra barra, prod_nombre nombre, prod_descripcion descripcion,
            prod_existencia existencia, prod_unidad unidad, prod_costo_compra costo_compra, prod_costo_agregado flete,
            prod_costo_total costo_total, prod_precio precio,prod_cod_laboratorio laboratorio, prod_cod_proveedor proveedor,
            prod_fecha fecha
            FROM prod_producto
            where prod_codigo_barra like '%$buscar%'
            or prod_nombre like '%$buscar%'
            or prod_descripcion like '%$buscar%'
            order by prod_nombre, prod_codigo_barra; ";

$parametros = array();
$arreglo_datos = $objeto_datos->get_datos($consulta, $parametros);            

?>

<div class="panel-body">
									<table class="table table-bordered">
									<thead>
											<tr>
                                                <th>#</th>
												<th>Cod. Barra</th>
												<th>Nombre</th>
                                                <th>Unidad</th>

                                                <th>Precio</th>
                                                <th>Cantidad</th>
                                                
												<th>Opciones</th>
											</tr>
										</thead>
										<tbody>
												<?php
													foreach ($arreglo_datos as $item) {
														?>
													<tr>
														<td>
															<?php echo $item["codigo"]; ?>
														</td>

														<td>
															<?php echo $item["barra"]; ?>
														</td>

                                                        <td>
															<?php echo $item["nombre"]; ?>
														</td>
                                                        <td>
                                                        <?php
                                                        @$arreglo_prov = array();
                                                    
                                                        $objeto_datos_load= new db_funciones();
                                                        $sql_equivalencias_precios = "	select 
                                                                        0 v, prod_unidad  t
                                                                        from prod_producto pp
                                                                        where prod_codigo = ".$item['codigo'] ."
                                                                    union ALL
                                                                        select equi_codigo v , equi_nombre t
                                                                        from equi_equivalencia ee 
                                                                        where equi_codigo_producto  = ". $item['codigo'].";";

                                                    
                                                        @$arreglo_prov= $objeto_datos_load->get_datos($sql_equivalencias_precios, array());


                                                        $fgenerales->lista_query('proveedor','', '4', $arreglo_prov,"0");
                                                        ?>
														</td>
                                                        <td>
															<?php echo $item["existencia"]; ?>
														</td>
                                                        
                                                        <td>
															<input type="text" value="1" />
														</td>
                                                       
                                                        <td>
														<a href='<?php echo $nombre_form; ?>_crud.php?codigo=<?php echo $item["codigo"]; ?>'><i class="lnr lnr-cog"></i> <span>&nbsp;&nbsp;Configuración&nbsp;&nbsp;</span></a>
														</td>
													</tr>


													<?php
                                                        }

                                                        ?>
										
										</tbody>
									</table>
								</div>