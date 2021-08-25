
<?php 
	require_once "conexion.php";
	$conexion=conexion();
	$id=$_POST['id'];

	$sql="DELETE from trad_detalle where trad_codigo='".$id."'";
	echo $result=mysqli_query($conexion,$sql);
 ?>