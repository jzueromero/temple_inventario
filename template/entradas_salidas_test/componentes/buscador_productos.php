<?php
  require_once "../php/conexion.php";
  $conexion= conexion();

 // echo $conexion."<hr>";

  $palabra = '';

   if(isset($_GET['palabra']) && !empty($_GET['palabra'])) {
    $palabra = $_GET['palabra'];
  }
  else {
    $palabra = '';
  }


  $consulta = "select pp.prod_codigo, pp.prod_codigo_barra, 
                pp.prod_nombre
                from prod_producto pp
                left join prov_proveedor pv on pv.prov_codigo = pp.prod_cod_proveedor 
                left join labo_laboratorio ll on ll.labo_codigo = pp.prod_cod_laboratorio 
                where 
                pp.prod_codigo_barra like '%$palabra%'
                or
                pp.prod_nombre like '%$palabra%'
                or 
                pv.prov_nombre like '%$palabra%'
                or 
                ll.labo_nombre like '%$palabra%'";

         

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
            $resultado=mysqli_query($conexion,$consulta);
            while($ver2=mysqli_fetch_row($resultado)){ 
              ?>
              <tr>
                <td><?php echo $ver2[0]; ?></td>
                <td><?php echo $ver2[1]; ?></td>
                <td><?php echo $ver2[2]; ?></td>
                <td>
                  <button class="btn btn-warning glyphicon glyphicon-pencil" data-toggle="modal" data-target="#modalEdicion" onclick="agregaform('<?php //echo $datos ?>')">
                    
                  </button>
                </td>
                <td>
                  <button class="btn btn-danger glyphicon glyphicon-remove" 
                  onclick="preguntarSiNo('<?php echo $ver2[0]; ?>')">
                    
                  </button>
                </td>
              </tr>
              <?php
            
      }
      ?>
            
          </table>
        </div>
      </div>
