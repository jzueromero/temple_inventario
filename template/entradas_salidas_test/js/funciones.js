

function agregardatos(nombre,apellido,email,telefono){

	cadena="nombre=" + nombre + 
			"&apellido=" + apellido +
			"&email=" + email +
			"&telefono=" + telefono;

	$.ajax({
		type:"POST",
		url:"php/agregarDatos.php",
		data:cadena,
		success:function(r){
			if(r==1){
				$('#tabla').load('componentes/tabla.php');
				 $('#buscador').load('componentes/buscador.php');
				alertify.success("agregado con exito :)");
			}else{
				alertify.error("Fallo el servidor :(");
			}
		}
	});

}

function agregaform(datos){

	d=datos.split('||');

	$('#idpersona').val(d[0]);
	$('#nombreu').val(d[1]);
	$('#apellidou').val(d[2]);
	$('#emailu').val(d[3]);
	$('#telefonou').val(d[4]);
	
}

function actualizaDatos(){


	id=$('#idpersona').val();
	nombre=$('#nombreu').val();
	apellido=$('#apellidou').val();
	email=$('#emailu').val();
	telefono=$('#telefonou').val();

	cadena= "id=" + id +
			"&nombre=" + nombre + 
			"&apellido=" + apellido +
			"&email=" + email +
			"&telefono=" + telefono;

	$.ajax({
		type:"POST",
		url:"php/actualizaDatos.php",
		data:cadena,
		success:function(r){
			
			if(r==1){
				$('#tabla').load('componentes/tabla.php');
				alertify.success("Actualizado con exito :)");
			}else{
				alertify.error("Fallo el servidor :(");
			}
		}
	});

}

function preguntarSiNo(id){
	alertify.confirm('Eliminar Datos', '¿Esta seguro de eliminar este registro?', 
					function(){ eliminarDatos(id) }
                , function(){ alertify.error('Se cancelo')});
}

function eliminarDatos(id){

	cadena="id=" + id;

		$.ajax({
			type:"POST",
			url:"php/eliminarDatos.php",
			data:cadena,
			success:function(r){
				if(r==1){
					$('#tabla').load('componentes/tabla.php');
					alertify.success("Eliminado con exito!");
				}else{
					alertify.error("Fallo el servidor :(");
				}
			}
		});
}

function CalcularValor(valor)
{
	var codigo_producto = $("#sel_equi"+valor+" option:selected").attr('data-producto');
	var cantidad_equi =  $("#sel_equi"+valor+" option:selected").attr('data-cantidad');
	var cantidad_digitada = $('#txt_cantidad'+valor).val();
	$('#div'+valor).text('Numero de unidades: '+ (parseInt(cantidad_equi) * parseInt(cantidad_digitada)) );

}

function CalcularValor2(valor)
{
	var codigo_producto = $("#sel_equi"+valor+" option:selected").attr('data-producto');
	var cantidad_equi =  $("#sel_equi"+valor+" option:selected").attr('data-cantidad');
	var cantidad_digitada = $('#txt_cantidad'+valor).val();
	$('#div'+valor).text('Numero de unidades: '+ (parseInt(cantidad_equi) * parseInt(cantidad_digitada)) );

}

function CrearDetalle(transaccion_codigo,producto_codigo,producto_costo,unidad_codigo,unidad,unidad_precio,unidad_cantidad,tran_cantidad)
{
	cadena="transaccion_codigo=" + transaccion_codigo + 
			"&producto_codigo=" + producto_codigo +
			"&producto_costo=" + producto_costo +
			"&unidad_codigo=" + unidad_codigo+
			"&unidad=" + unidad +
			"&unidad_precio=" + unidad_precio +
			"&unidad_cantidad=" + unidad_cantidad +
			"&tran_cantidad=" + tran_cantidad ;

	$.ajax({
	type:"POST",
	url:"php/agregarDetalleTran.php",
	data:cadena,
	success:function(r){
		if(r==1){
			$('#tabla').load('componentes/tabla.php');
			$('#buscador').load('componentes/buscador.php');
			alertify.success("agregado con exito :)");
		}else{
			alertify.error("Fallo el servidor :(");
		}
	}
	});
}