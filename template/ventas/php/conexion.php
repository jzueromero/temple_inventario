

<?php 
		function conexion(){
			$servidor="localhost";
			$usuario="root";
			$password="rootmysql123";
			$bd="temple_inventario_07";

			$conexion=mysqli_connect($servidor,$usuario,$password,$bd);

			return $conexion;
		}

		
		
 ?>