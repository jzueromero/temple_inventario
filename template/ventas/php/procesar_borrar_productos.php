
<?php
require_once "conexion.php";
$conexion = conexion();


@$codigo_venta = $_POST["codigo_venta"];

$flujo = 0;

///     actualiza encabezado
$borrar_detalle="/*
                    parametros obtenidos
                    * */
                    SET  @venta_codigo := ".@$codigo_venta.";
                    delete from ventd_detalle where ventd_vent_codigo = @venta_codigo; ";

    $flujo=mysqli_query($conexion,$borrar_detalle);

echo $flujo;

?>