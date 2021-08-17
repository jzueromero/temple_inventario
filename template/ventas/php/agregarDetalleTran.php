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

	$sql="INSERT INTO trad_detalle
		(trand_tran_codigo, trand_producto_codigo, trand_producto_costo,
		 trand_unidad_codigo, trand_unidad, trand_unidad_precio, 
		 trand_unidad_cantidad, trand_cantidad, trad_producto_codigo_barra, trad_producto_nombre) 
		VALUES($transaccion_codigo,$producto_codigo,$producto_costo,
		$unidad_codigo,'".$unidad."',$unidad_precio,
		$unidad_cantidad,$tran_cantidad, '".$codigo_barra."', '".$nombre_producto ."');";
	echo $result=mysqli_query($conexion,$sql);
	//echo $sql;
 ?>