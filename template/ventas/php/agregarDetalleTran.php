<?php 

	require_once "conexion.php";
	$conexion=conexion();
	@$ventd_vent_codigo = $_POST["transaccion_codigo"];
	@$ventd_producto_codigo = $_POST["producto_codigo"];
	@$ventd_producto_codigo_barra = $_POST["tran_codigo_barra"];

	@$ventd_producto_costo = $_POST["producto_costo"];
	@$ventd_unidad_codigo = $_POST["unidad_codigo"];
	@$ventd_unidad = $_POST["unidad"];
	@$ventd_producto_precio = $_POST["unidad_precio"];
	@$ventd_unidad_cantidad = $_POST["unidad_cantidad"];
	@$ventd_cantidad = $_POST["tran_cantidad"]; 
	@$ventd_producto_nombre = $_POST["nombre_producto"];
	@$total = $_POST["total"];

	$sql="INSERT INTO ventd_detalle
	(ventd_vent_codigo,ventd_producto_codigo,ventd_producto_codigo_barra,ventd_producto_nombre,
	 ventd_producto_costo, ventd_producto_precio, ventd_unidad_codigo, ventd_unidad,
	  ventd_unidad_precio, ventd_unidad_cantidad, ventd_cantidad, ventd_producto_total)
	VALUES( $ventd_vent_codigo, $ventd_producto_codigo, '".$ventd_producto_codigo_barra."', '".$ventd_producto_nombre ."',
	$ventd_producto_costo,$ventd_producto_precio,$ventd_unidad_codigo,'".$ventd_unidad."'
		   , $ventd_producto_precio,      $ventd_unidad_cantidad,     $ventd_cantidad, $total);
	";
	echo $result=mysqli_query($conexion,$sql);
	//echo $sql;




 ?>