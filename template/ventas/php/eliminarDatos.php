
<?php 
	require_once "conexion.php";
	$conexion=conexion();
	$id=$_POST['id'];

	$sql="DELETE from ventd_detalle where ventd_codigo ='".$id."'";
	echo $result=mysqli_query($conexion,$sql);
 ?>