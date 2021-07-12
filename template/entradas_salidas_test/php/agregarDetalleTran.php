<?php 

	require_once "conexion.php";
	@$transaccion_codigo = $_POST["transaccion_codigo"];
	@$producto_codigo = $_POST["producto_codigo"];
	@$producto_costo = $_POST["producto_costo"];
	@$unidad_codigo = $_POST["unidad_codigo"];
	@$unidad = $_POST["unidad"];
	@$unidad_precio = $_POST["unidad_precio"];
	@$unidad_cantidad = $_POST["unidad_cantidad"];
	@$tran_cantidad = $_POST["tran_cantidad"]; 

	$sql="INSERT into t_persona (nombre,apellido,email,telefono)
								values ('$n','$a','$e','$t')";
	echo $result=mysqli_query($conexion,$sql);

 ?>