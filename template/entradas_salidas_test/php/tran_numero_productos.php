
<?php
require_once "conexion.php";
$conexion = conexion();
$id = $_POST['transaccion_codigo'];
$numero_productos = 0;

$sql = "select count(trad_codigo) numero from trad_detalle td where td.trand_tran_codigo = '" . $id . "'";
$result = mysqli_query($conexion, $sql);
if ($row =  mysqli_fetch_assoc($result)) {
    $numero_productos = $row['numero'];
}

echo $numero_productos;

?>