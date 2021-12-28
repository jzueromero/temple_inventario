
<?php
session_start();
require_once "conexion.php";
$conexion = conexion();

@$ttipo ="";
@$tconcepto = "";
@$tcomentario = "";
@$tusuario = $_SESSION['usua_codigo'];
@$tfecha = "";
//@$testado = $_POST['estado'];
@$tanulado="";
$comanda = 0; 

@$codigo_venta = $_POST["venta_codigo"];
@$codigo_sucursal = $_POST["sucursal"];
@$total = $_POST["venta_total"]; 
@$efectivo = $_POST["venta_efectivo"]; 
@$cambio = $_POST["venta_cambio"];
@$comentario = $_POST["comentario"]; 

@$tipo = "SALIDA";
@$ttipo_codigo = 0;


$serie = '';
$correlativo = 0;

@$tipo_tran = 0;
@$operacion = " - " ;

$flujo = 0;

///     actualiza encabezado
$venta_update_sql="/*
        parametros obtenidos
        * */
        SET @comentario = '".trim($comentario)."';
        SET @usuario_codigo = ".$tusuario.";
        SET  @venta_codigo := ".@$codigo_venta.";
        SET @total := ". $total."; set @efectivo := ". $efectivo."; set @cambio := ".$cambio.";
        SET @caja_numero :=  vent_sucursal_codigo from vent_venta where vent_codigo = @venta_codigo;

        /*
        parametros obtenidos
        */
        select @correlativo :=  ifnull(talo_correlativo,0) + 1  from talo_talonario tt where talo_sucursal_codigo = @caja_numero;
        select @comanda :=  ifnull(talo_comanda,0) from talo_talonario tt where talo_sucursal_codigo = @caja_numero;
        select @serie :=  ifnull(talo_serie,'-')  from talo_talonario tt where talo_sucursal_codigo = @caja_numero;


        update talo_talonario 
        set
        talo_correlativo = @correlativo
        where talo_sucursal_codigo = @caja_numero;

        update vent_venta 
        set
        vent_estado = 'PROCESADO',
        vent_serie  = @serie,
        vent_correlativo = @correlativo,
        vent_comentario = @comentario,
        vent_total = @total, vent_efectivo = @efectivo, vent_cambio  = @cambio,
        vent_usuario_venta = @usuario_codigo,
        vent_fecha_venta = CURRENT_TIMESTAMP
        where vent_codigo  = @venta_codigo;	";

    //"<script> console.log(".$venta_update_sql.");</script>";

    $flujo=mysqli_query($conexion,$venta_update_sql);
///     actualiza encabezado
///
$sql_maestro = "SELECT vv.vent_codigo , vent_codigo_temporal, vent_sucursal_codigo, ss.sucu_nombre,  vent_estado,
                vv.vent_comanda comanda, vv.vent_correlativo correlativo,  
                '' tran_nombre_concepto, vent_referencia, vent_comentario, vent_usuario, vent_fecha, vent_usuario_anula, vent_fecha_anula,
                concat( uu.usua_nombre,' ', uu.usua_apellido) usuario,
                (select concat(uu.usua_nombre,' ', uu.usua_apellido,' ', vent_fecha_anula)
                from usua_usuario uu2 where uu2.usua_codigo = vent_usuario_anula)  as anulo
                FROM vent_venta vv 
                inner join sucu_sucursal ss  on ss.sucu_codigo = vent_sucursal_codigo 
                inner join usua_usuario uu  on uu.usua_codigo  = vent_usuario 
                        WHERE vent_codigo= " . $codigo_venta ;

$sql_detalle = "select * from ventd_detalle vd where vd.ventd_vent_codigo =" . $codigo_venta . ";";

$r_maestro = mysqli_query($conexion, $sql_maestro);
$r_detalle = mysqli_query($conexion, $sql_detalle);

$arreglo_maestro = mysqli_fetch_assoc($r_maestro);
///
while ($item =  mysqli_fetch_assoc($r_maestro)) {
    @$vent_codigo = $item['vent_codigo'];
    @$vent_sucursal_codigo = $item['vent_sucursal_codigo'];
    @$sucu_nombre = $item['sucu_nombre'];
    $comanda = $item['comanda'];
    $correlativo = $item['correlativo'] ;

    @$concepto = "POR VENTA: # $correlativo COMANDA: # $comanda ID: # $vent_codigo" ;
    @$tcomentario = trim($comentario);

    @$tfecha = $item['vent_fecha'];
    @$testado = $item['vent_estado'];
    @$tanulado = trim($item['anulo']);

}

@$tipo_tran = 0;
@$operacion = " - ";

$cumulo = "";
/// procesar detalle
if($flujo > 0)
{
    while ($deta = mysqli_fetch_assoc($r_detalle)){
        $codigo_producto = $deta['ventd_producto_codigo'];
        $prod_nombre = trim($deta['ventd_producto_nombre']);
        $uni_codigo = $deta['ventd_unidad_codigo'];
        $unidad = strtoupper( trim($deta['ventd_unidad']));
        $uni_unidades = $deta['ventd_unidad_cantidad'];
        $cantidad = $deta['ventd_cantidad'];

        $sql_kardex = "INSERT INTO kardex
        (kard_tipo, kard_concepto, kard_fecha, kard_sucursal_codigo,
         kard_producto_codigo, kard_producto_nombre, kard_unidad_codigo,
          kard_unidad, kard_cantidad_unidades, kard_cantidad) 
        VALUES('SALIDA', '"."$concepto ', CURRENT_TIMESTAMP, '$vent_sucursal_codigo',
         ".$codigo_producto.", '".$prod_nombre."', ".$uni_codigo.", '".$unidad."', ". $uni_unidades.", ".$cantidad.");";
       
         $total_uniades = $uni_unidades * $cantidad;
         $sql_producto = "UPDATE prod_producto
                         SET  prod_existencia".$vent_sucursal_codigo." = prod_existencia".$vent_sucursal_codigo." - ".$total_uniades."
                         WHERE prod_codigo = '" .$codigo_producto."'";

        $flujo=mysqli_query($conexion,$sql_kardex);
        $flujo=mysqli_query($conexion,$sql_producto);

        
            descontar_vencimiento($codigo_producto, $vent_sucursal_codigo, $total_uniades);
        //$cumulo = $cumulo."<hr> ** ". $sql_kardex. "<hr>**". $sql_producto." <hr>** ".$sql_detalle." <hr> <hr>**";
    }
}

function descontar_vencimiento($producto,$sucursal,$cantidad)
{
    $sql_lotes = "select venc_codigo, venc_producto_codigo, venc_cantidad_restante,  venc_fecha_vencimiento, venc_sucursal
                from venc_vencimiento 
                where 
                venc_producto_codigo = $producto
                and 
                venc_cantidad_restante  > 0
                and
                venc_sucursal = $sucursal
                order by venc_fecha_vencimiento asc ";
    $cnx_lote = conexion();

    $unidades = $cantidad;

    $r_lote = mysqli_query($cnx_lote, $sql_lotes);
    while ($lote = mysqli_fetch_assoc($r_lote)) {
        if ($unidades > 0) {
            if ($unidades > $lote['venc_cantidad_restante']) {
                $unidades_restantes = $unidades - $lote['venc_cantidad_restante'];
                $descontar = $unidades - $unidades_restantes;

                $sql_restantes = "UPDATE venc_vencimiento
                    SET venc_cantidad_restante= venc_cantidad_restante - $descontar 
                    WHERE venc_codigo=" . $lote['venc_codigo'];
                $rven = mysqli_query($cnx_lote, $sql_restantes);

                $unidades = $unidades_restantes;
            } else {
                $sql_restantes = "UPDATE venc_vencimiento
                    SET venc_cantidad_restante= venc_cantidad_restante - $unidades 
                    WHERE venc_codigo=" . $lote['venc_codigo'];
                $rven = mysqli_query($cnx_lote, $sql_restantes);

                $unidades = 0;
            }
        }
    }
}

function nombre_sucursal($codigo_sucursal)
{
    $s = ' - ';

    switch ($codigo_sucursal) {
        case 1:
            $s = SS1_n;
            break;
        case 2:
            $s = SS2_n;
            break;
        case 3:
            $s = SS3_n;
            break;
        case 4:
            $s = SS4_n;
            break;
        case 5:
            $s = SS5_n;
            break;
        
        default:
            $s = '-';
            break;
    }
    return $s;
}

echo $venta_update_sql;

?>