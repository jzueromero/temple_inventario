
<?php
require_once "conexion.php";
$conexion = conexion();
$id = $_POST['venta_codigo'];
$numero_productos = 0;

$sql = "select count(vd.ventd_codigo) numero from ventd_detalle vd where vd.ventd_vent_codigo = '" . $id . "'";
$result = mysqli_query($conexion, $sql);
if ($row =  mysqli_fetch_assoc($result)) {
    $numero_productos = $row['numero'];
}

echo $numero_productos;

?>