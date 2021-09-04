
<?php
require_once "conexion.php";
$conexion = conexion();

@$ttipo_codigo = 0;
@$ttipo ="";
@$tconcepto = "";
@$tcomentario = "";
@$tusuario = "";
@$tfecha = "";
//@$testado = $_POST['estado'];
@$tanulado="";
$comanda = 0; 

@$codigo_venta = $_POST["codigo_venta"];
@$comentario = $_POST["comentario"]; 
@$total = $_POST["total"]; 

$flujo = 0;

///     actualiza encabezado
$venta_update_sql="/*
                    parametros obtenidos
                    * */
                    SET @comentario = '".trim($comentario)."';
                    SET @usuario_codigo = ".$_SESSION['usua_codigo'].";

                    SET  @venta_codigo := ".@$codigo_venta.";
                    SET @total := ". $total."; 

                    SET @caja_numero := (select vent_sucursal_codigo from vent_venta where vent_codigo = @venta_codigo);
                    /*
                    parametros obtenidos
                    * */
                    SET @correlativo := (select ifnull(talo_correlativo,0)   from talo_talonario tt where talo_sucursal_codigo = @caja_numero);
                    SET @comanda := (select ifnull(talo_comanda,0) + 1 from talo_talonario tt where talo_sucursal_codigo = @caja_numero);

                    SET @serie := (select ifnull(talo_serie,'-')  from talo_talonario tt where talo_sucursal_codigo = @caja_numero);


                    update talo_talonario 
                    set
                    talo_correlativo = @correlativo
                    where talo_sucursal_codigo = @caja_numero

                    update vent_venta 
                    set
                    vent_estado = 'COMANDA',
                    vent_comanda  = @comanda,
                    vent_comentario = @comentario,
                    vent_total = @total,
                    vent_usuario_venta = @usuario_codigo,
                    vent_fecha_venta = CURRENT_TIMESTAMP
                    where vent_codigo  = @venta_codigo;	";


    $flujo=mysqli_query($conexion,$venta_update_sql);
///     actualiza encabezado
///

///

echo $flujo;

?>