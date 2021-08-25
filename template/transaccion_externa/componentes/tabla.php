
<?php 
	session_start();
	require_once "../php/conexion.php";
	$conexion=conexion();

 ?>
<div class="row">
	<div class="col-sm-12">
	<h2>Ingresos y Salidas de Producto</h2>
		<table class="table table-hover table-condensed table-bordered">
		<caption>
			<button class="btn btn-primary" data-toggle="modal" data-target="#modalProducto">
				Agregar Producto 
				<span class="glyphicon glyphicon-plus"></span>
			</button>
		</caption>
			<tr>
				<td>Codigo</td>
				<td>Nombre</td>
				<td>Unidad</td>
				<td>Cantidad</td>
				<!-- <td>Editar</td> -->
				<td>Eliminar</td>
			</tr>

			<?php 

				
					$sql="SELECT trad_codigo codigo, trand_tran_codigo tran_codigo, trand_producto_codigo producto_codigo,
					trand_producto_costo producto_costo, trand_unidad_codigo unidad_codigo, trand_unidad unidad,
					trand_unidad_precio unidad_precio, trand_unidad_cantidad unidad_cantidad, trand_cantidad cantidad, trad_producto_codigo_barra codigo_barra,
					trad_producto_nombre producto_nombre
					FROM trad_detalle
					WHERE trand_tran_codigo =". $_GET['codigo_tran'];
				//echo $sql;
				$result=mysqli_query($conexion,$sql);
				while($ver=mysqli_fetch_assoc($result)){ 

					// $datos=$ver[0]."||".
					// 	   $ver[1]."||".
					// 	   $ver[2]."||".
					// 	   $ver[3]."||".
					// 	   $ver[4];
			 ?>

			<tr>
				<td><?php echo $ver['codigo_barra'] ?></td>
				<td><?php echo $ver['producto_nombre'] ?></td>
				<td><?php echo $ver['unidad'] ?></td>
				<td><?php echo $ver['cantidad'] ?></td>
				<!-- <td>
					<button class="btn btn-warning glyphicon glyphicon-pencil" data-toggle="modal" data-target="#modalEdicion" onclick="agregaform('<?php //echo $datos ?>')">
						
					</button>
				</td> -->
				<td>
					<button class="btn btn-danger glyphicon glyphicon-remove" 
					onclick="preguntarSiNo('<?php echo $ver['codigo'] ?>')">
						
					</button>
				</td>
			</tr>
			<?php 
		}
			 ?>
		</table>
	</div>
</div>