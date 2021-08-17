<?php 
	session_start();

	$idper=$_POST['palabra'];

	$_SESSION['consulta']=$idper;

	echo $idper;

 ?>