

<?php 
		function conexion(){
			$servidor="localhost";
			$usuario="root";
			$password="rootmysql123";
			$bd="pruebas";

			$conexion=mysqli_connect($servidor,$usuario,$password,$bd);

			return $conexion;
		}

 ?>