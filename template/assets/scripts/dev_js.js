var valido = false;

var btn_guardar;
var btn_modificar;
var btn_eliminar;

	function formulario_ejecuta()
	{
		

		btn_guardar = document.getElementById("btn_nuevo");
		if(btn_guardar){
			btn_guardar.addEventListener("click", nuevo, false);
			}
		

		btn_modificar = document.getElementById("btn_modificar");
		if(btn_modificar){
			btn_modificar.addEventListener("click", modificar, false);
			}
		

		btn_eliminar = document.getElementById("btn_eliminar");
		if(btn_eliminar){
			btn_eliminar.addEventListener("click", eliminar, false);
			}
		

		txt_costo_compra = document.getElementById("costo_compra");
		if(txt_costo_compra){
			txt_costo_compra.addEventListener("keyup", calc_costo_total, false);
			}

			txt_costo_flete = document.getElementById("flete");
			if(txt_costo_flete){
				txt_costo_flete.addEventListener("keyup", calc_costo_total, false);
				}
	}

function calc_costo_total()
{
	var valor_compra =  ValidarNumericoCero(document.getElementById("costo_compra").value);
	var valor_flete = ValidarNumericoCero(document.getElementById("flete").value);
	document.getElementById("costo_total").value = valor_compra + valor_flete;
}


function valida(){
	for (let index = 0; index < campos.length; index++) {
			valido = required(campos[index]);
			if(valido == false)
				break;	
		}
		return valido;
}

	function required(inputtx) 
   {
	var x = document.forms["formulario"][inputtx];
 	 if (x.value.trim() == "") {
		alert('Revise los campos obligatorios (*) ');
		x.focus();
		x.value = '';
		x.style.border="2px solid #dc3545 ";
         return false; 
      }  	
      return true; 
    }

	function nuevo()
	{
		var f = valida();
		if( f == true)
		{
			document.getElementById("accion").value = "nuevo";
			document.getElementById("formulario").submit();
		}
		
	}

	function modificar()
	{
		if(valida())
		{
			document.getElementById("accion").value = "modificar";
			document.getElementById("formulario").submit();
		}
		
	}

	function eliminar()
	{

		var res = confirm("Desea borrar este registro?!");

		if(res == true)
		{
			document.getElementById("accion").value = "eliminar";
			document.getElementById("formulario").submit();	
		}
		
	}


	function ValidarNumericoCero(ValorDecimal)
	{
		var valor = 0;
		if (isNaN(ValorDecimal) || ValorDecimal == null || ValorDecimal == '')
		{
			valor = 0;
		} else
		{
			valor = parseFloat(ValorDecimal);
		}

		return parseFloat( valor );
	}


	window.onload=formulario_ejecuta;
