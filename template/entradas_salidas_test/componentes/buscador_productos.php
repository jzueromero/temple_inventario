<?php

session_start();

  require_once '../../../src_php/db/db_funciones.php';
  
  require_once '../../../src_php/db/funciones_generales.php';

  $db_buscador = new db_funciones();
  $busca_general = new funciones_generales(); 

 


 // echo $conexion."<hr>";

  $palabra = '';

   if(isset($_GET['palabra']) && !empty($_GET['palabra'])) {
    $palabra = $_GET['palabra'];
  }
  else {
    $palabra = '';
  }


  $consulta_buscador = "select pp.prod_codigo, pp.prod_codigo_barra, 
                pp.prod_nombre, pp.prod_costo_total costo
                from prod_producto pp
                left join prov_proveedor pv on pv.prov_codigo = pp.prod_cod_proveedor 
                left join labo_laboratorio ll on ll.labo_codigo = pp.prod_cod_laboratorio 
                where 
                pp.prod_codigo_barra like '%".$palabra."%'
                or
                pp.prod_nombre like '%".$palabra."%'
                or 
                pv.prov_nombre like '%".$palabra."%'
                or 
                ll.labo_nombre like '%".$palabra."%'
                order by pp.prod_nombre
                ";

  $parametros = array();
  $arreglo_buscador = $db_buscador->get_datos($consulta_buscador, $parametros);       

?>
<div class="row">
  <div class="col-sm-12">
 <table class="table table-hover table-condensed table-bordered">
            <thead>
              <td>Codigo</td>
              <td>Producto</td>
              <td>Unidad</td>
              <td>Cantidad</td>
              <td>Agregar</td>
              <!-- 
              <td>Eliminar</td> -->
            </thead>
        <?php
            
           foreach ($arreglo_buscador as $pr) {
            
              ?>
              <tr>
                <td>
                <input type="hidden" name="producto<?php echo $pr['prod_codigo']; ?>"
                  id="producto<?php echo $pr['prod_codigo']; ?>" value="<?php echo $pr['prod_codigo']; ?>"  />
                  <input type="hidden" name="txt_costo_<?php echo $pr['prod_codigo']; ?>"
                  id="txt_costo_<?php echo $pr['prod_codigo']; ?>" value="<?php echo $pr['costo']; ?>"  />
                <?php echo $pr['prod_codigo_barra']; ?>
              </td>
                <td><?php echo $pr['prod_nombre']; ?></td>
                

                <td>

                <?php
                  $consulta_equi = "select 0 codigo, IF(pp.prod_unidad IS NULL or pp.prod_unidad = '', 
                                    'Unidad', pp.prod_unidad) as unidad, 1 cantidad, pp.prod_precio precio
                                    from prod_producto pp 
                                    where pp.prod_codigo = ".$pr['prod_codigo']."
                                    union all 
                                    select ee.equi_codigo codigo, ee.equi_nombre unidad, ee.equi_cantidad cantidad, ee.equi_precio precio
                                    from equi_equivalencia ee 
                                    inner join prod_producto pp2 on pp2.prod_codigo = ee.equi_codigo_producto 
                                    where 
                                    ee.equi_codigo_producto  = ".$pr['prod_codigo'];
                  
                  $arreglo_equi = $db_buscador->get_datos($consulta_equi, array()); 
                  ?>
                  <select
                  class="form-control"
                  onchange="<?php echo "CalcularValor('".$pr['prod_codigo']."')"; ?>" name="sel_equi<?php echo $pr['prod_codigo']; ?>" id="sel_equi<?php echo $pr['prod_codigo']; ?>" >
                  <?php
                  foreach ($arreglo_equi as $equi) {
                    ?>
                        <option
                        data-producto="<?php echo $pr['prod_codigo']; ?>"
                        data-equi="<?php echo $equi['codigo']; ?>"
                         data-precio="<?php echo $equi['precio']; ?>"
                          data-unidad="<?php echo $equi['unidad']; ?>"
                           data-cantidad="<?php echo $equi['cantidad']; ?>" >
                          <?php echo $equi['unidad']; ?>
                        </option>
                    <?php
                  }
                ?>
                  </select>

                  </button>
                </td>
                <td>
                <input type="text" class="form-control"
                  value="1" onkeyup="CalcularValor2(<?php echo $pr['prod_codigo']; ?>)"
                    name="txt_cantidad<?php echo $pr['prod_codigo']; ?>"
                    id="txt_cantidad<?php echo $pr['prod_codigo']; ?>"
                   placeholder="descr1" required="">
                   <div id="<?php echo 'div'.$pr['prod_codigo']; ?>" ></div>
                </td>
                <!-- <td>
                <input type="text" class="form-control"  readonly="" value="1"
                name="txt_total<?php //echo $pr['prod_codigo']; ?>"
                    id="txt_total<?php //echo $pr['prod_codigo']; ?>"
                   placeholder="descr1" required="">
                </td> -->
                <td>

                <button class="btn btn-info glyphicon glyphicon-plus" 
                onclick="alert('El directorio actual no puede acceder a la transaccion.')">
                    
                  <!-- COMENTAR COMENTAR -->
                  <button class="btn btn-info glyphicon glyphicon-plus" 
                onclick="NuevoProducto('<?php echo $pr['prod_codigo']; ?>')">
                  <!-- COMENTAR COMENTAR -->

                <!-- BOTONES PARA AGREGAR PRODUCTO AGREGAR PRODUCTO -->
                <!-- <button class="btn btn-info glyphicon glyphicon-plus" data-toggle="modal" 
                data-target="#modalEdicion" onclick="agregaform('<?php //echo $datos ?>')">
                     -->
                    <!-- <button class="btn btn-danger glyphicon glyphicon-remove" 
                    onclick="preguntarSiNo('<?php //echo $pr[0]; ?>')">
                    </button> -->
                </td>
              </tr>
              <?php
      }
      ?>
            
          </table>
        </div>
      </div>

     


