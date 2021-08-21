<?php 

	require_once "conexion.php";
	$conexion=conexion();
	@$transaccion_codigo = $_POST["transaccion_codigo"];
	@$producto_codigo = $_POST["producto_codigo"];
	@$producto_costo = $_POST["producto_costo"];
	@$unidad_codigo = $_POST["unidad_codigo"];
	@$unidad = $_POST["unidad"];
	@$unidad_precio = $_POST["unidad_precio"];
	@$unidad_cantidad = $_POST["unidad_cantidad"];
	@$tran_cantidad = $_POST["tran_cantidad"]; 
	@$codigo_barra = $_POST["tran_codigo_barra"];
	@$nombre_producto = $_POST["nombre_producto"];
	@$total = $_POST["total"];

	$sql="INSERT INTO ventd_detalle
	(ventd_vent_codigo,ventd_producto_codigo,ventd_producto_codigo_barra,ventd_producto_nombre,
	 ventd_producto_costo, ventd_producto_precio, ventd_unidad_codigo, ventd_unidad,
	  ventd_unidad_precio, ventd_unidad_cantidad, ventd_cantidad, ventd_producto_total)
	VALUES( $transaccion_codigo, $producto_codigo, '".$codigo_barra."', '".$nombre_producto ."',
	       $producto_costo,     $unidad_precio,        $unidad_codigo,       '".$unidad."'
		   , $unidad_precio,      $unidad_cantidad,     $tran_cantidad, $total);
	";
	echo $result=mysqli_query($conexion,$sql);
	//echo $sql;




 ?>