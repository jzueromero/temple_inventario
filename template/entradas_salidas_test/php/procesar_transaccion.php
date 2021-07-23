
<?php
require_once "conexion.php";
$conexion = conexion();

@$transaccion_codigo = $_POST["transaccion_codigo"];
@$tipo = $_POST["tipo"];
@$sucursal = $_POST["sucursal"];
@$sucursal_nombre = $_POST["sucursal_nombre"];
@$concepto = $_POST["concepto"];
@$concepto_nombre = $_POST["concepto_nombre"]; 
@$comentario = $_POST["comentario"]; 

@$tipo_tran = 0;
@$operacion = " - " ;
if($tipo == "salida")
{
@$tipo_tran = 0;
@$operacion = " - " ;

}
if($tipo == "entrada")
{
@$tipo_tran = 1;
@$operacion = " + " ;

}

$flujo = 0;

$sql_maestro = "SELECT *FROM tran_transaccion WHERE tran_codigo = '" . $transaccion_codigo . "'";
$sql_detalle = "select * from trad_detalle td where td.trand_tran_codigo = " . $transaccion_codigo . ";";

$r_maestro = mysqli_query($conexion, $sql_maestro);
$r_detalle = mysqli_query($conexion, $sql_detalle);

$arreglo_maestro = mysqli_fetch_assoc($r_maestro);

///     actualiza encabezado
$sql="UPDATE tran_transaccion
SET 
tran_sucursal_codigo='$sucursal', 
tran_tipo='$tipo_tran', 
tran_estado='PROCESADO', 
tran_codigo_concepto='$concepto',
tran_nombre_concepto='$concepto_nombre',
tran_referencia=0, 
tran_comentario='$comentario', 
tran_fecha=CURRENT_TIMESTAMP
WHERE tran_codigo='$transaccion_codigo'";
$flujo=mysqli_query($conexion,$sql);
///     actualiza encabezado
$cumulo = "";
/// procesar detalle
if($flujo > 0)
{
    while ($deta = mysqli_fetch_assoc($r_detalle)){
        $sql_kardex = "INSERT INTO kardex
        (kard_tipo, kard_concepto, kard_fecha, kard_sucursal_codigo,
         kard_producto_codigo, kard_producto_nombre, kard_unidad_codigo,
          kard_unidad, kard_cantidad_unidades, kard_cantidad)
        VALUES('".strtoupper(trim($tipo))."', '".trim($concepto_nombre)."', CURRENT_TIMESTAMP, $sucursal, '".$deta['trand_producto_codigo']."', '".trim($deta['trad_producto_nombre'])."', ".$deta['trand_unidad_codigo'].", '".trim($deta['trand_unidad'])."', ".$deta['trand_unidad_cantidad'] .", ".$deta['trand_cantidad'].");";

        $total_uniades = $deta['trand_unidad_cantidad'] * $deta['trand_cantidad'];
        $sql_producto = "UPDATE prod_producto
                        SET  prod_existencia".$sucursal."= prod_existencia".$sucursal." ".$operacion.$total_uniades."
                        WHERE prod_codigo='" .$deta['trand_producto_codigo']."'";

        $resu=mysqli_query($conexion,$sql_kardex);
        $resu2=mysqli_query($conexion,$sql_producto);

        if(trim($tipo) == "salida"){
        
            descontar_vencimiento($deta['trand_producto_codigo'], $sucursal, $total_uniades);
        }

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


echo $flujo;

?>