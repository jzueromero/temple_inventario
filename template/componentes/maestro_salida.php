<?php 
	session_start();
	require_once "../../src_php/db/db_funciones.php";
	$dbhead = new db_funciones();

    //Paso uno, verificar que no existe transaccion temporal
    @$existe_usuario = "select count(tran_codigo_temporal ) valor from tran_transaccion where tran_codigo_temporal = :token";
    $parametros = array(":token" => $_SESSION['token_temp_salida'] );
    $numero = $dbhead->get_dato_escalar($existe_usuario, $parametros);

  echo $numero;


 ?>


    <div class="row">
    <h2><span class="label label-danger">Transaccion de salida</span></h2>
    <div class="col-sm-2">
          <label>Transacción</label>
        	<input type="text" name="frm_cod_transacciond" id="frm_cod_transacciond" class="form-control input-sm">
          <label>Tipo:</label>
        	<input type="text" name="frm_cod_transaccion" id="frm_cod_transaccion" class="form-control input-sm">
          <label>Estado:</label>
        	<input type="text" name="tran_estado" id="frm_cod_estado" class="form-control input-sm">
    </div>
    <div class="col-sm-2">
    <label>Concepto</label>
        	<input type="text" name="frm_cod_transacciond" id="frm_cod_transacciond" class="form-control input-sm">
          <label>Cliente:</label>
        	<input type="text" name="frm_cod_transaccion" id="frm_cod_transaccion" class="form-control input-sm">
          <label>Referencia:</label>
        	<input type="text" name="tran_estado" id="frm_cod_estado" class="form-control input-sm">
    </div>
    <div class="col-sm-2">
    <label>fecha</label>
        	<input type="text" name="frm_cod_transacciond" id="frm_cod_transacciond" class="form-control input-sm">
          <label>Fecha:</label>
        	<input type="text" name="frm_cod_transaccion" id="frm_cod_transaccion" class="form-control input-sm">
          <label>usuario:</label>
        	<input type="text" name="tran_estado" id="frm_cod_estado" class="form-control input-sm">
    </div>
    <div class="col-sm-2">
    <label>Recibido</label>
        	<input type="text" name="frm_cod_transacciond" id="frm_cod_transacciond" class="form-control input-sm">
          <label>Cambio:</label>
        	<input type="text" name="frm_cod_transaccion" id="frm_cod_transaccion" class="form-control input-sm">
          <label>Total:</label>
        	<input type="text" name="tran_estado" id="frm_cod_estado" class="form-control input-sm">
    </div>
    <div class="col-sm-2">
    <label>Recibido</label>
        	<input type="button" name="btn_procesar" id="btn_procesar" class="form-control input-sm">
          <label>Cambio:</label>
        	<input type="button" name="btn_borrador" id="btn_borrador" class="form-control input-sm">
          <label>Total:</label>
        	<input type="button" name="btn_cancelar" id="btn_cancelar" class="form-control input-sm">
    </div>
    </div>