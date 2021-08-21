
<?php 
	session_start();
	require_once "../php/conexion.php";
	$conexion=conexion();

	@$total_venta = 0.00;
	@$recibido = 0.00;
	@$cambio = 0.00;

			
	$sql="SELECT ventd_codigo codigo, ventd_vent_codigo tran_codigo, ventd_producto_codigo producto_codigo,
	ventd_producto_codigo_barra codigo_barra, ventd_producto_nombre producto_nombre,
	ventd_producto_costo producto_costo, ventd_producto_precio producto_precio, ventd_unidad_codigo unidad_codigo, ventd_unidad unidad,
	ventd_unidad_precio unidad_precio, ventd_unidad_cantidad unidad_cantidad, ventd_cantidad cantidad, ventd_producto_total total
	FROM ventd_detalle
	where ventd_vent_codigo =". $_GET['codigo_venta'] ;
	
//echo $sql;
@$fila = "";
$result=mysqli_query($conexion,$sql);
while($ver=mysqli_fetch_assoc($result)){ 

	$fila = $fila. "
<tr>
<td>". $ver['codigo_barra'] ."</td>
<td>". $ver['producto_nombre'] ."</td>
<td>". $ver['unidad'] ."</td>
<td>". number_format((float)$ver['producto_precio'], 2, '.', '') ."</td>
<td>". $ver['cantidad']."</td>
<td>". number_format((float)$ver['total'], 2, '.', '') ."</td>

<td>
	<button class='btn btn-danger glyphicon glyphicon-remove' 
	onclick=\"preguntarSiNo('<?php echo ".$ver['codigo'] ."')\">
		
	</button>
</td>
</tr>";

$total_venta = $total_venta + number_format((float)$ver['total'], 2, '.', '');
}



 ?>
<div class="row">
	<div class="col-sm-12">
	<h2>Ingresos y Salidas de Producto</h2>
		<table class="table table-hover table-condensed table-bordered">
		<caption>
		<div class="form-group col-sm-3 col-md-3">

			<button class="btn btn-primary" data-toggle="modal" data-target="#modalProducto">
				Agregar Producto 
				<span class="glyphicon glyphicon-plus"></span>
			</button>
		</div>
		<div class="form-group-sm col-sm-3 col-md-3">

<div class="input-group">
  <span class="input-group-addon">Efectivo $</span>
  <input type="text" class="form-control decimal-2-places" aria-label="Amount (to the nearest dollar)"  id="efectivo" onkeyup="calcular_cambio()">
</div>
</div>

<div class="form-group-sm col-sm-3 col-md-3">
<div class="input-group">
  <span class="input-group-addon">Cambio $</span>
  <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)" readonly="" id="cambio" value="0.00" >
</div>
</div>

			<div class="form-group-lg col-sm-3 col-md-3">
        <div class="input-group">
          <span class="input-group-addon">Total $</span>
          <b><input type="text" class="form-control" aria-label="Amount (to the nearest dollar)" readonly="" id="total_venta" value="<?php echo $total_venta; ?>">
		  </b></div>
      </div>

      
		</caption>
			<tr>
				<td>Codigo</td>
				<td>Nombre</td>
				<td>Unidad</td>
				<td>Precio</td>
				<td>Cantidad</td>
				<td>Total</td>
				<!-- <td>Editar</td> -->
				<td>Eliminar</td>
			</tr>

			<?php
		echo $fila;
			 ?>
			 
		</table>
	</div>
</div>