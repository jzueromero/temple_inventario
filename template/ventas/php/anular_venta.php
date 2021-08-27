<?php
session_start();

require_once "conexion.php";
$conexion = conexion();

$codigo = $_POST['codigo'];
$comentario_recibido = $_POST['comentario'];
@$vent_codigo = $codigo;
@$vent_sucursal_codigo = 0;
@$sucu_nombre = "";
@$ttipo_codigo = 0;
@$ttipo ="";
@$tconcepto = "";
@$tcomentario = "";
@$tusuario = "";
@$tfecha = "";
//@$testado = $_POST['estado'];
@$tanulado="";
$comanda = 0; 
$correlativo = 0;

$tran = "SELECT vv.vent_codigo , vent_codigo_temporal, vent_sucursal_codigo, ss.sucu_nombre,  vent_estado,
        vv.vent_comanda comanda, vv.vent_correlativo correlativo,  
        '' tran_nombre_concepto, vent_referencia, vent_comentario, vent_usuario, vent_fecha, vent_usuario_anula, vent_fecha_anula,
        concat( uu.usua_nombre,' ', uu.usua_apellido) usuario,
        (select concat(uu.usua_nombre,' ', uu.usua_apellido,' ', vent_fecha_anula)
        from usua_usuario uu2 where uu2.usua_codigo = vent_usuario_anula)  as anulo
        FROM vent_venta vv 
        inner join sucu_sucursal ss  on ss.sucu_codigo = vent_sucursal_codigo 
        inner join usua_usuario uu  on uu.usua_codigo  = vent_usuario 
                WHERE vent_codigo=  $codigo;";

$flujo = 0;

$sql_detalle = "select * from ventd_detalle vd where vd.ventd_vent_codigo  = " . $codigo . ";";

$r_maestro = mysqli_query($conexion, $tran);
$r_detalle = mysqli_query($conexion, $sql_detalle);

while ($item =  mysqli_fetch_assoc($r_maestro)) {
    @$vent_codigo = $item['vent_codigo'];
    @$vent_sucursal_codigo = $item['vent_sucursal_codigo'];
    @$sucu_nombre = $item['sucu_nombre'];
    $comanda = $item['comanda'];
    $correlativo = $item['correlativo'] ;

    @$concepto = "POR ANULACION VENTA: # $correlativo COMANDA: # $comanda ID: # $vent_codigo" ;
    @$tcomentario = trim($item['tran_comentario']);
    @$tusuario = $item['usuario'];
    @$tfecha = $item['vent_fecha'];
    @$testado = $item['vent_estado'];
    @$tanulado = trim($item['anulo']);

}
    $kard_tipo = "ENTRADA";

    @$tipo_tran = 1;
    @$operacion = " + ";


///     actualiza encabezado
$sql="UPDATE
        vent_venta vv
        SET 
            vent_estado='ANULADO', 
            vent_fecha_anula=CURRENT_TIMESTAMP,
            vent_comentario = '$comentario_recibido',
            vent_usuario_anula= ".$_SESSION['usua_codigo']." 
        WHERE vent_codigo='$vent_codigo'";

//echo $sql.'<br><br><br>';

$flujo=mysqli_query($conexion,$sql);
   // actualiza encabezado
 if($testado != "PROCESADO")
 {
    if($flujo >= 0)
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
            VALUES('".$kard_tipo."', '"."$concepto ', CURRENT_TIMESTAMP, '$vent_sucursal_codigo',
             ".$codigo_producto.", '".$prod_nombre."', ".$uni_codigo.", '".$unidad."', ". $uni_unidades.", ".$cantidad.");";
    
            $total_uniades = $uni_unidades * $cantidad;
            $sql_producto = "UPDATE prod_producto
                            SET  prod_existencia".$vent_sucursal_codigo." = prod_existencia".$vent_sucursal_codigo." + ".$total_uniades."
                            WHERE prod_codigo = '" .$codigo_producto."'";
    
            $flujo=mysqli_query($conexion,$sql_kardex);
            $flujo=mysqli_query($conexion,$sql_producto);
    
            // echo $sql_kardex."<br ><br ><br>";
            // echo $sql_producto."<br><br>";
        }
    }
 }
$cumulo = "";
/// procesar detalle

echo $flujo;
?>