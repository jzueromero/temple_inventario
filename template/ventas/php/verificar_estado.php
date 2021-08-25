<?php

    $codigo = $_POST['codigo'];

    require_once "conexion.php";
    $conexion = conexion();

    $estado ="0";

    $sql = "select trim(vv.vent_estado) estado from vent_venta vv where vv.vent_codigo  = '" . $codigo . "'";
    $result = mysqli_query($conexion, $sql);
    if ($row =  mysqli_fetch_assoc($result)) {
        $estado = $row['estado'];
    }

    echo trim($estado);

?>