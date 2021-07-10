<?php 
  session_start();
  require_once '../../src_php/db/db_funciones.php';
  
  require_once '../../src_php/db/funciones_generales.php';

  $db_es = new db_funciones();
  $busca_es = new funciones_generales(); 

 
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
   
    <div class="form-group col-sm-2  col-md-2">
      <label for="sel1">Sucursal:</label>
        <select class="form-control" id="sel1">
        <?php
            if(SS1 =="si" )
            {
              ?>
              <option>
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
              <option>
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
              <option>
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
              <option>
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
              <option>
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
      <label for="sel_tipo_transaccion">Tipo de Transacción:</label>
        <select class="form-control" id="sel_tipo_transaccion" >
          <option data-valor="sin" >--Seleccione</option>
          <option data-valor="0">Entrada</option>
          <option data-valor="1">Salida</option>
        </select>
    </div> 

    
<!-- LISTA DE CONCEPTOS -->
<div class="form-group col-sm-2 col-md-2" id="listaConceptos"></div> 
<!-- LISTA DE  -->

    </div>
    <div id="buscador"></div>
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
		$('#tabla').load('componentes/tabla.php');
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
          $('#listaConceptos').load('componentes/lista_conceptos.php?tipo='+tipo);
        });
    });
    </script>