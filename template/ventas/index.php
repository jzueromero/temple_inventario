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
@$token = $_SESSION['token_temp_venta'];
@$sucursal_venta = "";

$db_token = new db_funciones();
$general_token = new funciones_generales();

$consulta_token = "select 
                    IF(vv.vent_codigo  IS NULL or vv.vent_codigo = '', 
                                '0', vv.vent_codigo) as codigo
                  from vent_venta vv 
                  where vv.vent_codigo_temporal  = '" . $token . "'
                  and 
                  vent_estado != 'PROCESADO'
                  AND vent_estado != 'COMANDA' 
                  AND vent_estado != 'ANULADO' ";

$codigo_tran = $db_token->get_dato_escalar($consulta_token, array());

$consulta_su_venta = "select  IF(ss.sucu_nombre IS NULL or ss.sucu_nombre  = '', 
  'NO SUCURSAL', ss.sucu_nombre ) as sucursal  from sucu_sucursal ss 
where ss.sucu_codigo  =" . $_SESSION['venta_sucursal'];
$s_venta = $db_token->get_dato_escalar($consulta_su_venta, array());
@$sucursal_venta = trim($s_venta) == "" ? "NO SUCURSAL" : $s_venta;


if (trim($codigo_tran) == "") {
  $sql_crear_venta = "INSERT INTO vent_venta
    ( vent_codigo_temporal, vent_serie, vent_correlativo, vent_comanda, vent_sucursal_codigo, vent_estado, vent_referencia, vent_comentario, vent_usuario, vent_fecha, vent_total, vent_fecha_anula, vent_usuario_anula)
    VALUES(  :token,               :serie,      :correlativo,    :n_comanda,    :cod_sucursal,        :estado,     0,                  '',          :usuario, CURRENT_TIMESTAMP, 0.00,     NULL,               0);
    
                    ";
  $parametros_token = array(
    ":token" => $token,
    ":token" => $token,
    ":serie" => "",
    ":correlativo" => "0",
    ":n_comanda" => "0",
    ":cod_sucursal" => $_SESSION['venta_sucursal'],
    ":estado" => "TEMPORAL",
    ":usuario" => $_SESSION['usua_codigo'],
  );

  $crear = $db_token->insert_datos_2($sql_crear_venta, $parametros_token);
  $codigo_tran = $db_token->get_dato_escalar($consulta_token, array());
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
  <script src="librerias/jquery.numeric.js"></script>
  <style>
    .modal-dialog {
      width: 90%;
      height: auto;
      padding: 0;
    }

    .modal-content {
      height: 90%;
    }
  </style>
</head>

<body>

  <div class="container">

    <div class="row">
      <div class="form-group col-sm-1 col-md-1">
        <label>#:</label>
        <input type="text" name="txt_codigo_tran" id="txt_codigo_tran" class="form-control input-lg" readonly="" value="<?php echo $codigo_tran; ?>">
      </div>
      <div class="form-group col-sm-2  col-md-2">
        <label for="sel1">Usuario:</label>
        <input type="text" name="txt_codigo_tran" id="txt_codigo_tran" class="form-control input-lg" readonly="" value="<?php echo $_SESSION['nombre_usuario']; ?>">
      </div>

      <div class="form-group col-sm-2  col-md-2">
        <label for="sel1">Sucursal:</label>
        <input type="text" name="txt_codigo_tran" id="txt_codigo_tran" class="form-control input-lg" readonly="" value="<?php echo $sucursal_venta; ?>">
        <input type="hidden" id="hdd_sucursal" value="<?php echo $_SESSION['venta_sucursal']; ?>" />
      </div>




      <!-- LISTA DE CONCEPTOS -->
      <div class="form-group col-sm-2 col-md-2" id="listaConceptos"></div>
      <!-- LISTA DE  -->
      <!-- COMENTARIO OPCIONAL -->
      <div class="form-group col-sm-3 col-md-3">
        <label>Comentario:</label>
        <input type="text" name="txt_comentario" id="txt_comentario" class="form-control input-sm">
      </div>
      <!-- COMENTARIO OPCIONAL -->
      <!-- FECHA DE PROCESO -->
      <div class="form-group col-sm-2 col-md-2">
        <label>Fecha:</label>
        <input type="text" name="txt_fecha" id="txt_fecha" class="form-control input-sm" readonly="" value="<?php echo $fecha; ?>">
      </div>
      <!-- FECHA DE PROCESO -->
      <!-- Total -->

      <!-- Total -->


    </div>
    <div class="row">
      <button class="btn btn-primary" id="btn_comanda">
        Comanda
        <span class=""></span>
      </button>
      <button class="btn btn-success" id="btn_procesar">
        Procesar Venta
        <span class=""></span>
      </button>

      <button class="btn btn-default" id="btn_regresar">
        Regresar
        <span class=""></span>
      </button>
      <button class="btn btn-danger" id="btn_borrar_productos">
        Borrar Productos
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
                <input type="text" class="form-control" id="txt_buscar" placeholder="Buscar por codigo, nombre, descripcion, proveedor">
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

  <!-- Modal para existencias en sucursales -->
  <!-- Modal para existencias en sucursales -->

  <div class="modal fade" id="modalExistencias" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">::Existencias::</h4>
        </div>
        <div class="modal-body">

          <div class="row">
            <div class="col-lg-6">
            </div><!-- /.col-lg-6 -->
          </div>
          <div class="row">
            <div id="productos_existencias" class="pre-scrollable"></div>
          </div>
        </div>
        <div class="modal-footer">

        </div>
      </div>
    </div>
  </div>

  <!-- Modal para existencias en sucursales -->
  <!-- Modal para existencias en sucursales -->


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
  $(document).ready(function() {
    var transaccion_codigo = $('#txt_codigo_tran').val();

    $('#tabla').load('componentes/tabla.php?codigo_venta=' + transaccion_codigo);
    $('#productos_encontrados').load('componentes/buscador_productos.php?palabra=');
  });
</script>

<script type="text/javascript">
  $(document).ready(function() {
    $('#guardarnuevo').click(function() {
      nombre = $('#nombre').val();
      apellido = $('#apellido').val();
      email = $('#email').val();
      telefono = $('#telefono').val();
      agregardatos(nombre, apellido, email, telefono);
    });

    $('#actualizadatos').click(function() {
      actualizaDatos();
    });

  });
</script>
<script type="text/javascript">
  function VerificaExistencia(codigo) {

    $('#productos_existencias').load('componentes/existencias_sucursales.php?codigo_producto=' + codigo);

  }

  function CalcularExistencia(posicion) {
    var ecantidad = $("#sel_existencia" + posicion + "  option:selected").attr('data-cantidad');

    if (ecantidad == 1) {
      var existencia_original = $('#existencia' + posicion).val();
      $('#txt_existencia' + posicion).val(existencia_original);
    } else {
      var existencia_original = $('#existencia' + posicion).val();
      var numero_existencia = parseInt(existencia_original / ecantidad);
      $('#txt_existencia' + posicion).val(numero_existencia);
    }

  }
</script>

<script type="text/javascript">
  $(document).ready(function() {

    $("#txt_buscar").keyup(function() {
      var busqueda = $.trim($("#txt_buscar").val());
      $('#productos_encontrados').load('componentes/buscador_productos.php?palabra=' + busqueda);
    });


  });
</script>

<script type="text/javascript">
  $(document).ready(function() {
    $('#btn_procesar').click(function() {
      guardar_documento("VENTA");
    });
  });
</script>

<script type="text/javascript">
  $(document).ready(function() {
    $('#btn_comanda').click(function() {
      var sucursal = $("#hdd_sucursal").val();
      var sucursal_nombre = $("#sel_sucursal option:selected").text();

      var tipo = $("#sel_tipo_transaccion option:selected").attr('data-valor');

      var concepto = $("#sel_concepto option:selected").attr('data-valor');
      var concepto_nombre = $("#sel_concepto option:selected").text();

      var comentario = $('#txt_comentario').val();

      var ejecutar = true;
      if (parseInt(sucursal) == 0) {
        alertify.error("ADMINISTRADOR: No tiene sucursal de venta asignado");
        ejecutar = false;
        return;
      }

      if (ejecutar == true) {
        //alert('paso');
        var transaccion_codigo = $('#txt_codigo_tran').val();
        //alert(transaccion_codigo);
        verificar_productos(transaccion_codigo);
      }

    });
  });
</script>

<script type="text/javascript">
  function guardar_documento(tipo) {

    var venta_codigo = $('#txt_codigo_tran').val();
    var comentario = $("#txt_comentario").val();
    var sucursal = $("#hdd_sucursal").val();
    var venta_efectivo = $('#efectivo').val();
    var venta_total = $('#total_venta' ).val();
    var venta_cambio = $('#cambio').val();

    var ejecutar = true;
      
    if (parseInt(sucursal) == 0) {
        alertify.error("ADMINISTRADOR: No tiene sucursal de venta asignado");
        ejecutar = false;
        return;
      }

      var n_productos =  parseInt( verificar_productos(venta_codigo));
      console.log('resultado: '+ n_productos)

      if(parseInt(n_productos) < 1 ){
        alertify.error("No se puede procesar sin productos");
        ejecutar = false;
        return;
       }
      
       if(ejecutar == true)
       {
        procesar_venta(venta_codigo, comentario, sucursal, venta_total, venta_efectivo, venta_cambio);
       }

  }
</script>


<script type="text/javascript">
  function NuevoProducto(codigo) {

    var transaccion_codigo = $('#txt_codigo_tran').val();
    var producto_codigo = $("#sel_equi" + codigo + " option:selected").attr('data-producto');
    var producto_costo = $('#txt_costo_' + codigo).val();

    var unidad_codigo = $("#sel_equi" + codigo + " option:selected").attr('data-equi');
    var unidad = $("#sel_equi" + codigo + " option:selected").attr('data-unidad');
    var unidad_precio = $("#sel_equi" + codigo + " option:selected").attr('data-precio');
    var unidad_cantidad = $("#sel_equi" + codigo + " option:selected").attr('data-cantidad');

    var tran_cantidad = $('#txt_cantidad' + codigo).val();
    var tran_total = $('#sub' + codigo).val();

    var codigo_barra = $("#sel_equi" + codigo + " option:selected").attr('data-barra');
    var nombre_producto = $("#sel_equi" + codigo + " option:selected").attr('data-nombre');

    if (parseInt(tran_cantidad) < 0 || parseFloat(tran_total) < 0 || parseInt(tran_cantidad) == 0 || parseFloat(tran_total) == 0 || tran_cantidad.trim() === "" || tran_total.trim() === "") {
      alertify.error("Digite una cantidad correcta");
      return;
    }
    //alert(codigo_barra +' - '+ nombre_producto);

    CrearDetalle(transaccion_codigo, producto_codigo, producto_costo, unidad_codigo, unidad, unidad_precio, unidad_cantidad, tran_cantidad, codigo_barra, nombre_producto, tran_total);
  }
</script>

<script type="text/javascript">
  $(document).ready(function() {
    $('#btn_regresar').click(function() {
      window.location.href = '../../template/sis_venta.php'
      return;
    });

  });
</script>