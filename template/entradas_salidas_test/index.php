<?php 
  session_start();
  require_once '../../src_php/db/db_funciones.php';
  
  require_once '../../src_php/db/funciones_generales.php';

  $db_es = new db_funciones();
  $busca_es = new funciones_generales(); 

  $fecha = date('d-m-Y');
 
  /*
    $_SESSION['token_temp_entrada'] = $fdb->generar_token_transaccion($item['usua_codigo'], $item['usua_nombre'].' '.$item['usua_apellido']);
    $_SESSION['token_temp_salida'] = $fdb->generar_token_transaccion($item['usua_codigo'], $item['usua_nombre'].' '.$item['usua_apellido']);
  
  */
  @$token = $_SESSION['token_temp_entrada'];

  $db_token = new db_funciones();
  $general_token = new funciones_generales(); 

  $consulta_token = "select 
                IF(tt.tran_codigo IS NULL or tt.tran_codigo = '', 
                            '0', tt.tran_codigo) as codigo
              from tran_transaccion tt
              where tt.tran_codigo_temporal  = '".$token ."'";

  $codigo_tran = $db_token->get_dato_escalar($consulta_token, array());

  if(trim($codigo_tran) == "")
  {
    $sql_crear_tran = "INSERT INTO tran_transaccion
                    ( tran_codigo_temporal, tran_sucursal_codigo, tran_tipo, tran_estado, 
                    tran_codigo_concepto, tran_nombre_concepto, tran_referencia, tran_comentario, tran_usuario, tran_fecha)
                    VALUES(:token, 0,0,  'TEMPORAL', 0,'sin', 0, '',  ". $_SESSION['usua_codigo'] .", CURRENT_TIMESTAMP);
                    ";
                    $parametros_token = array(":token" => $token,);
    
    $crear = $db_token->insert_datos_2($sql_crear_tran, $parametros_token);                    
    $codigo_tran = $db_token->get_dato_escalar($consulta_token,array());
  }
  
  
 ?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>Ingresos y Salidas de Producto</title>
	<link rel="stylesheet" type="text/css" href="librerias/bootstrap/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="librerias/alertifyjs/css/alertify.css">
	<link rel="stylesheet" type="text/css" href="librerias/alertifyjs/css/themes/default.css">
  <link rel="stylesheet" type="text/css" href="librerias/select2/css/select2.css">

	<script src="librerias/jquery-3.2.1.min.js"></script>
  <script src="js/funciones.js"></script>
	<script src="librerias/bootstrap/js/bootstrap.js"></script>
	<script src="librerias/alertifyjs/alertify.js"></script>
  <script src="librerias/select2/js/select2.js"></script>
</head>
<body>

	<div class="container">

  <div class="row">
  <div class="form-group col-sm-1 col-md-1" >
<label >#:</label>
  <input type="text" name="txt_codigo_tran" id="txt_codigo_tran"
   class="form-control input-lg" readonly="" value="<?php echo $codigo_tran; ?>" >
</div> 
    <div class="form-group col-sm-2  col-md-2">
      <label for="sel1">Sucursal:</label>
        <select class="form-control" id="sel_sucursal">
        <option data-valor="0" >
          --Seleccione
        </option>
        <?php
            if(SS1 =="si" )
            {
              ?>
              <option data-valor="1">
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
              ?>
              <option data-valor="2">
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
              ?>
              <option data-valor="3">
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
              ?>
              <option data-valor="4">
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
              ?>
              <option data-valor="5">
              <?php
                echo SS5_n;
              ?>
              </option>
              <?php
            }
          ?>
          

        </select>
    </div> 
 

  <div class="form-group col-sm-2 col-md-2">
      <label >Tipo de Transacción:</label>
        <select class="form-control" id="sel_tipo_transaccion" >
          <option data-valor="sin" >--Seleccione</option>
          <option data-valor="entrada">Entrada</option>
          <option data-valor="salida">Salida</option>
        </select>
    </div> 

    
<!-- LISTA DE CONCEPTOS -->
<div class="form-group col-sm-2 col-md-2" id="listaConceptos"></div> 
<!-- LISTA DE  -->
<!-- COMENTARIO OPCIONAL -->
<div class="form-group col-sm-3 col-md-3" >
<label >Comentario:</label>
  <input type="text" name="txt_comentario" id="txt_comentario"
   class="form-control input-sm">
</div> 
<!-- COMENTARIO OPCIONAL -->
<!-- FECHA DE PROCESO -->
<div class="form-group col-sm-2 col-md-2" >
<label >Fecha:</label>
  <input type="text" name="txt_fecha" id="txt_fecha"
   class="form-control input-lg" readonly="" value="<?php echo $fecha; ?>" >
</div> 
<!-- FECHA DE PROCESO -->

    </div>
    <div class="row">
    <button class="btn btn-success" id="btn_procesar" >
				Procesar Transaccion
				<span class=""></span>
			</button>

			<button class="btn btn-default" >
				Regresar 
				<span class=""></span>
			</button>
			<button class="btn btn-danger" >
				Borrar Transaccion 
				<span class=""></span>
			</button>
    </div>
    <!-- <div id="buscador"></div> -->
		<div id="tabla"></div>



	</div>

  <!-- Modal buscador producto -->
<div class="modal fade" id="modalProducto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Buscar Producto</h4>
      </div>
      <div class="modal-body">
        <caption>
        
        </caption>
        <div class="row">
           <div class="col-lg-6">
    <div class="input-group">
      <span class="input-group-btn">
        <button class="btn btn-default glyphicon glyphicon-search" type="button"></button>
      </span>
      <input type="text" class="form-control" id="txt_buscar"
       placeholder="Buscar por codigo, nombre, descripcion, proveedor">
    </div><!-- /input-group -->
  </div><!-- /.col-lg-6 -->
        </div>
        <div class="row">
         <div id="productos_encontrados" class="pre-scrollable"></div>
       </div>
      </div>
      <div class="modal-footer">
       
      </div>
    </div>
  </div>
</div>

	<!-- Modal para registros nuevos -->


<div class="modal fade" id="modalNuevo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Agrega nueva persona</h4>
      </div>
      <div class="modal-body">
        	<label>Nombre</label>
        	<input type="text" name="" id="nombre" class="form-control input-sm">
        	<label>Apellido</label>
        	<input type="text" name="" id="apellido" class="form-control input-sm">
        	<label>Email</label>
        	<input type="text" name="" id="email" class="form-control input-sm">
        	<label>telefono</label>
        	<input type="text" name="" id="telefono" class="form-control input-sm">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal" id="guardarnuevo">
        Agregar
        </button>
       
      </div>
    </div>
  </div>
</div>

<!-- Modal para edicion de datos -->

<div class="modal fade" id="modalEdicion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Actualizar datos</h4>
      </div>
      <div class="modal-body">
      		<input type="text" hidden="" id="idpersona" name="">
        	<label>Nombre</label>
        	<input type="text" name="" id="nombreu" class="form-control input-sm">
        	<label>Apellido</label>
        	<input type="text" name="" id="apellidou" class="form-control input-sm">
        	<label>Email</label>
        	<input type="text" name="" id="emailu" class="form-control input-sm">
        	<label>telefono</label>
        	<input type="text" name="" id="telefonou" class="form-control input-sm">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" id="actualizadatos" data-dismiss="modal">Actualizar</button>
        
      </div>
    </div>
  </div>
</div>

</body>
</html>

<script type="text/javascript">
	$(document).ready(function(){
    var transaccion_codigo=$('#txt_codigo_tran').val();

		$('#tabla').load('componentes/tabla.php?codigo_tran='+transaccion_codigo);
    $('#productos_encontrados').load('componentes/buscador_productos.php?palabra=');
	});
</script>

<script type="text/javascript">
    $(document).ready(function(){
        $('#guardarnuevo').click(function(){
          nombre=$('#nombre').val();
          apellido=$('#apellido').val();
          email=$('#email').val();
          telefono=$('#telefono').val();
            agregardatos(nombre,apellido,email,telefono);
        });



        $('#actualizadatos').click(function(){
          actualizaDatos();
        });

    });
</script>
<script type="text/javascript">
  
</script>

<script type="text/javascript">
    $(document).ready(function(){
     
     
      $( "#txt_buscar" ).keyup(function() {
          var busqueda = $.trim( $("#txt_buscar").val());
         $('#productos_encontrados').load('componentes/buscador_productos.php?palabra='+busqueda);
      });

        
    });
  </script>
  <script type="text/javascript">
     $(document).ready(function(){
        $('#sel_tipo_transaccion').on("change",function(){
          var tipo = $("#sel_tipo_transaccion option:selected").attr('data-valor');
          $('#listaConceptos').load('componentes/lista_conceptos.php?tipo='+ tipo);
        });
    });
    </script>

<script type="text/javascript">
    $(document).ready(function(){
        $('#btn_procesar').click(function(){
          var sucursal = $("#sel_sucursal option:selected").attr('data-valor');
          var tipo = $("#sel_tipo_transaccion option:selected").attr('data-valor');
          var concepto = $("#sel_concepto option:selected").attr('data-valor');

          var ejecutar = true;
          if(parseInt(sucursal) == 0)
          {
            alertify.error("Debe elegir una sucursal");
            ejecutar = false;
            return;
          }
          if(tipo == "sin")
          {
            alertify.error("Debe elegir un tipo Transaccion");
            ejecutar = false;
            return;
          }
          if(parseInt(concepto) == 0)
          {
            alertify.error("Debe elegir un concepto");
            ejecutar = false;
            return;
          }


          if(ejecutar == true)
          {
            alert('paso');
          }

        });
    });
</script>

<script type="text/javascript">
        
      function NuevoProducto(codigo){

            var transaccion_codigo=$('#txt_codigo_tran').val(); 
            var producto_codigo=  $("#sel_equi"+codigo+" option:selected").attr('data-producto');
            var producto_costo = $('#txt_costo_'+codigo).val();

            var unidad_codigo =  $("#sel_equi"+codigo+" option:selected").attr('data-equi');
            var unidad =  $("#sel_equi"+codigo+" option:selected").attr('data-unidad');
            var unidad_precio =  $("#sel_equi"+codigo+" option:selected").attr('data-precio');
            var unidad_cantidad=  $("#sel_equi"+codigo+" option:selected").attr('data-cantidad');

            var tran_cantidad =$('#txt_cantidad'+codigo).val(); 

            var codigo_barra =  $("#sel_equi"+codigo+" option:selected").attr('data-barra');
            var nombre_producto =  $("#sel_equi"+codigo+" option:selected").attr('data-nombre');
            //alert(codigo_barra +' - '+ nombre_producto);
          
            CrearDetalle(transaccion_codigo,producto_codigo,producto_costo,unidad_codigo,unidad,unidad_precio,unidad_cantidad,tran_cantidad,codigo_barra,nombre_producto);
          }
        
</script>