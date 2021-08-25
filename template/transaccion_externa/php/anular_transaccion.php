
<?php
session_start();

require_once "conexion.php";
$conexion = conexion();

$codigo = $_POST['codigo'];
$comentario_recibido = $_POST['comentario'];
@$tcodigo = $codigo;
@$tsucursal_codigo = 0;
@$sucursal = "";
@$ttipo_codigo = 0;
@$ttipo ="";
@$tconcepto = "";
@$tcomentario = "";
@$tusuario = "";
@$tfecha = "";
@$testado = "";
@$tanulado="";

$tran = "SELECT tran_codigo, tran_codigo_temporal, tran_sucursal_codigo, ss.sucu_nombre, tran_tipo, tran_estado, tran_codigo_concepto, 
        trim(tran_nombre_concepto) tran_nombre_concepto, tran_referencia, tran_comentario, tran_usuario, tran_fecha,tran_usuario_anula, tran_fecha_anula,
        concat( uu.usua_nombre,' ', uu.usua_apellido) usuario,
        (select concat(uu.usua_nombre,' ', uu.usua_apellido,' ',tran_fecha_anula)
        from usua_usuario uu2 where uu2.usua_codigo = tran_usuario_anula)  as anulo
        FROM tran_transaccion
        inner join sucu_sucursal ss  on ss.sucu_codigo = tran_sucursal_codigo 
        inner join usua_usuario uu  on uu.usua_codigo  = tran_usuario 
                WHERE tran_codigo= $codigo;";

$flujo = 0;

$sql_detalle = "SELECT * FROM trad_detalle td where td.trand_tran_codigo = " . $tcodigo . ";";

$r_maestro = mysqli_query($conexion, $tran);
$r_detalle = mysqli_query($conexion, $sql_detalle);

while ($item =  mysqli_fetch_assoc($r_maestro)) {
    @$tcodigo = $item['tran_codigo'];
    @$tsucursal_codigo = $item['tran_sucursal_codigo'];
    @$sucursal = $item['sucu_nombre'];
    @$ttipo_codigo = $item['tran_tipo'];
    @$ttipo = @$ttipo_codigo == 1 ? "SALIDA" : "ENTRADA";
    @$tconcepto = trim($item['tran_nombre_concepto']);
    @$tcomentario = trim($item['tran_comentario']);
    @$tusuario = $item['usuario'];
    @$tfecha = $item['tran_fecha'];
    @$testado = $item['tran_estado'];
    @$tanulado = trim($item['anulo']);
}

@$operacion = " - " ;

if ($ttipo == "SALIDA") {
    // $ttipo = "ENTRADA";
    @$tipo_tran = 0;
    @$operacion = " - ";
}
if ($ttipo == "ENTRADA") {
    // $ttipo = "SALIDA";
    @$tipo_tran = 1;
    @$operacion = " + ";
}

///     actualiza encabezado
$sql="UPDATE tran_transaccion
SET 
    tran_estado='ANULADO', 
    tran_fecha_anula=CURRENT_TIMESTAMP,
    tran_comentario = '$comentario_recibido',
    tran_usuario_anula= ".$_SESSION['usua_codigo']." 
WHERE tran_codigo='$tcodigo'";
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
        VALUES('".strtoupper(trim($ttipo))."', '"."POR ANULACION: # $codigo ".trim($tconcepto)."', CURRENT_TIMESTAMP, '$tsucursal_codigo', '".$deta['trand_producto_codigo']."', '".trim($deta['trad_producto_nombre'])."', ".$deta['trand_unidad_codigo'].", '".trim($deta['trand_unidad'])."', ".$deta['trand_unidad_cantidad'] .", ".$deta['trand_cantidad'].");";

        $total_uniades = $deta['trand_unidad_cantidad'] * $deta['trand_cantidad'];
        $sql_producto = "UPDATE prod_producto
                        SET  prod_existencia".$tsucursal_codigo." = prod_existencia".$tsucursal_codigo." ".$operacion.$total_uniades."
                        WHERE prod_codigo = '" .$deta['trand_producto_codigo']."'";

        $flujo=mysqli_query($conexion,$sql_kardex);
        $flujo=mysqli_query($conexion,$sql_producto);

        // echo $sql_kardex."<br ><br >";
        // echo $sql_producto."<b"
    }
}
echo $flujo;
?>