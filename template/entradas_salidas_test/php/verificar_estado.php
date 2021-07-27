<?php

    $codigo = $_POST['codigo'];

    require_once "conexion.php";
    $conexion = conexion();

    $estado ="0";

    $sql = "select trim(tt.tran_estado) estado from tran_transaccion tt where tt.tran_codigo  = '" . $codigo . "'";
    $result = mysqli_query($conexion, $sql);
    if ($row =  mysqli_fetch_assoc($result)) {
        $estado = $row['estado'];
    }

    if(trim($estado) == "ANULADO")
    {
        echo "0";
    }
    else
    {
        echo $codigo;
    }

?>