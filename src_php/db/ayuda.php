<?php

    require 'funciones_generales.php';
    $fgenareles = new funciones_generales();
	ini_set('display_errors', 'On');
 
	// Valor por defecto en PHP
	// Muestra todos los errores menos las notificaciones
	error_reporting(E_ALL ^ E_NOTICE);
 
	// Muestro todos los errores
	error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
	error_reporting(E_ALL);
	error_reporting(-1);
 
	// Muestro todos los errores, incluso los estrictos
	error_reporting(E_ALL | E_STRICT);
 
	// No muestra ningún error
	error_reporting(0);
 
	// También se puede usar la función ini_set
	ini_set('error_reporting', E_ALL);


//  if ($_SERVER['REQUEST_METHOD'] == 'POST')
//  {

//  }

$valor = $_GET['var'];
// $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : null;
//$errores = [];

 // Nombre
 if (!$fgenareles->validar_requerido($valor)) {
    $errores[] = 'El campo Nombre es obligatorio.';
}
// Edad
if (!$fgenareles->validar_entero($valor)) {
    $errores[] = 'El campo de Edad debe ser un número.';
}
// Email
if (!$fgenareles->validar_email($valor)) {
    $errores[] = 'El campo de Email tiene un formato no válido.';

}

if (!$fgenareles->validar_url($valor)) {
    $errores[] = 'El campo de URL tiene un formato no válido.';

}

if (!$fgenareles->validar_double($valor)) {
    $errores[] = 'El campo de Double tiene un formato no válido.';
}

if (!$fgenareles->validar_longitud_cadena($valor,4)) {
    $errores[] = 'La longitud debe ser minimo 4.';
}

$mensaje_popup = $fgenareles->mostrar_popup(4,"mensaje");

?>


<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="../../template/assets/vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="../../template/assets/vendor/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="../../template/assets/vendor/linearicons/style.css">
	<link rel="stylesheet" href="../../template/assets/vendor/toastr/toastr.min.css">
	<!-- MAIN CSS -->
	<link rel="stylesheet" href="../../template/assets/css/main.css">
	<!-- FOR DEMO PURPOSES ONLY. You should remove this in your project -->
	<link rel="stylesheet" href="../../template/assets/css/demo.css">
	<!-- GOOGLE FONTS -->
	<link href="https:/fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
	<!-- ICONS -->
	<link rel="apple-touch-icon" sizes="76x76" href="../../template/assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="../../template/assets/img/favicon.png">
</head>
<body>

<div class="row">
<?php
	echo 'RAMDON:' . generateRandomString();
	$dram =  new DateTime();
	echo '<hr>';
	echo 'RAMDON 2:' . $dram->format('Y-m-d H:i:s');

	echo '<hr> zona horaria';
	date_default_timezone_set('America/Los_Angeles');

$script_tz = date_default_timezone_get();

if (strcmp($script_tz, ini_get('date.timezone'))){
    echo 'La zona horaria del script difiere de la zona horaria de la configuracion ini.';
} else {
    echo 'La zona horaria del script y la zona horaria de la configuración ini coinciden.';
}
?>
</div>
    <div class="row text-left">
        
    <div class="col-md-6 col-lg-4">
            <?php echo $mensaje_popup; ?>    
        </div>
        <div class="col-md-6 col-sm-12 col-lg-8"></div>
    </div>





   <div class="row">
	   <div class="col-md-10">
       <ul>

<?php

if (isset($errores)): 

foreach ($errores as $error) {
    //echo '<li>' . $error . '</li>';
} 

endif;
?>
</ul>
<?php
//echo sha1($valor);
echo 'entities html '.htmlspecialchars($valor); 

$cadena = explode(',' , $valor);

echo '<hr>';
foreach ($cadena as $key => $value) {
    echo "@$".$value. " = ''; <br>";
}

echo '<hr>';
foreach ($cadena as $key => $value) {
    echo '@$'.$value. ' = $_POST["'.$value.'"]; <br>';
}
echo '<hr>';
foreach ($cadena as $key => $value) {
    echo "@$".$value. " = $"."item['']; <br>";
}
echo "<hr>";
foreach ($cadena as $key => $value) {
	echo "@$"."fgenerales->caja_texto('$value', '$value', '$value', '3', 'text','1','1',$".$value.");  <br>";
    
}


//echo '@$'.$valor. ' = $_POST["'.$valor.'"];';
//= $item['usua_codigo']; 

function generateRandomString($length = 20) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


?>
</div>
   </div> 
<div class="form-group">

    </div>
<form action="ayuda.php" method="get">
    <input type="text" name="var" id="var">
    <input type="submit">
</form>
<script src="../../template/assets/vendor/jquery/jquery.min.js"></script>
	<script src="../../template/assets/vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="../../template/assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	<script src="../../template/assets/vendor/toastr/toastr.min.js"></script>
	<script src="../../template/assets/scripts/klorofil-common.js"></script>
</body>
</html>