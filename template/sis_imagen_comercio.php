<?php
    session_start();
    if(!isset($_SESSION['usua_codigo']))
    {
        header('location:index.php');
    }
    
$modelo = 'Confg. comercio';
$nombre_form = "Confg. comercio";
$form_padre =  "index.php";
$titulo_form = "Modulo comercio";
$descripcion_form = 'Modulo de comercios. Aqui se registran las empresas, emprendimientos y afiliados.';
$nombre_negocio = "BiciMandados Sv - Zona Administrativa";
$titulo_form = "Conf. " . $titulo_form;
require '../src_php/db/db_funciones.php';
require '../src_php/db/funciones_generales.php';

@$mensaje_error = '';
@$carpeta = '';
@$nombre ='';
@$raiz = $_SERVER["DOCUMENT_ROOT"].'/delivery_app/template/assets/img/app/';

####
## Eliminar una imagen
####
if(isset($_GET['destino']))
{
    $carpeta = $_GET['destino'];
    $nombre = $_GET['codigo'];
    $carpeta = $raiz.$carpeta;
    $form_padre = '';

    if($_GET['destino'] == "empresas")
    {
        $form_padre = "sis_comercio_crud.php?codigo=".$nombre;
    }
    if($_GET['destino'] == 'menu')
    {
        $form_padre = 'sis_menu_crud.php?codigo='.$nombre."&comercio=".$_GET['comercio'];
    }
    if($_GET['destino'] == 'productos')
    {
        $form_padre = 'sis_producto_crud.php?codigo='.$nombre."&comercio=".$_GET['comercio'];
    }
    
}

    

##
## RECIBIR FORMULARIO
## Aqui pueden ir los campos que uno quiera
##
##$directorio="../../template/assets/img/app"; // directorio de tu elección

if(isset($_POST['submit'])){ // comprobamos que se ha enviado el formulario
    

  // comprobar que han seleccionado una foto
  if($_FILES['foto']['name'] != ""){ // El campo foto contiene una imagen...
    $form_padre = $_POST['padre'];
    $carpeta = $_POST['destino'];
    $nombre = $_POST['codigo'];
    // Primero, hay que validar que se trata de un JPG/GIF/PNG
    $allowedExts = array("jpg", "jpeg", "gif", "png", "JPG", "GIF", "PNG");
    @$extension = strtolower(end(explode(".", $_FILES["foto"]["name"])));
    $tipo_imagen = strtolower($_FILES["foto"]["type"]);
    if ((($tipo_imagen == "image/gif")
            || ($tipo_imagen == "image/jpeg")
            || ($tipo_imagen == "image/png")
            || ($tipo_imagen == "image/pjpeg"))
            && in_array($extension, $allowedExts)) {
        // el archivo es un JPG/GIF/PNG, entonces...
        
        $extension = strtolower(end(explode('.', $_FILES['foto']['name'])));
        $foto = $nombre.".".$extension;
        //$directorio = dirname(__FILE__); // directorio de tu elección
        $directorio=$carpeta; 
        
        if(file_exists($directorio.'/'.$nombre))
        {
            unlink($directorio.'/'.$nombre);   
        }
        if(file_exists($directorio.'/'.'min_'.$nombre))
        {
            unlink($directorio.'/'.'min_'.$nombre);   
        }
        if(file_exists($directorio.'/'.'res_'.$nombre))
        {
            unlink($directorio.'/'.'res_'.$nombre);   
        }

        // almacenar imagen en el servidor
        move_uploaded_file($_FILES['foto']['tmp_name'], $directorio.'/'.$foto);
        $minFoto = 'min_'.$foto;
        $resFoto = 'res_'.$foto;
        resizeImagen($directorio.'/', $foto, 65, 65,$minFoto,$extension);
        resizeImagen($directorio.'/', $foto, 500, 500,$resFoto,$extension);
        //unlink($directorio.'/'.$foto);
        
        @$elegir_consulta = end(explode('/',$carpeta));

        if (@$elegir_consulta == "empresas") {
			$consulta = "UPDATE come_comercio
                        SET  come_imagen=:come_imagen
                        WHERE come_codigo=:codigo;";
            //$consulta;
            $parametros = array(":come_imagen"=>$foto,
                            ":codigo"=>$nombre
                            );
			$objeto_datos = new db_funciones();
			$arreglo_datos = $objeto_datos->insert_datos($consulta, $parametros, $form_padre);
			//return;
		}

        if (@$elegir_consulta == "menu") {
			$consulta = "UPDATE menu_menu
                        SET  menu_imagen=:imagen
                        WHERE menu_codigo=:codigo;";
            //$consulta;
            $parametros = array(":imagen"=>$foto,
                            ":codigo"=>$nombre
                            );
			$objeto_datos = new db_funciones();
			$arreglo_datos = $objeto_datos->insert_datos($consulta, $parametros, $form_padre);
			//return;
		}
        if (@$elegir_consulta == "productos") {
			$consulta = "UPDATE prod_producto
                        SET  prod_imagen=:imagen
                        WHERE prod_codigo=:codigo;";
            //$consulta;
            $parametros = array(":imagen"=>$foto,
                            ":codigo"=>$nombre
                            );
			$objeto_datos = new db_funciones();
			$arreglo_datos = $objeto_datos->insert_datos($consulta, $parametros, $form_padre);
			//return;
		}


    } else { // El archivo no es JPG/GIF/PNG
        $malformato = $_FILES["foto"]["type"];
        //header("Location: cargarImagen.php?error=noFormato&formato=$malformato");
        $mensaje_error = 'Solo se aceptan imagenes, favor verificar el archivo que elige tenga el formato correcto (JPG, PNG)';
        //exit;
      }
    



    } else { // El campo foto NO contiene una imagen
        $mensaje_error = 'El archivo no puede ser subido, trate con una imagen diferente';
    //exit;
}
        
} // fin del submit

####
## Función para redimencionar las imágenes
## utilizando las liberías de GD de PHP
####

function resizeImagen($ruta, $nombre, $alto, $ancho,$nombreN,$extension){
    $rutaImagenOriginal = $ruta.$nombre;
    if($extension == 'GIF' || $extension == 'gif'){
    $img_original = imagecreatefromgif($rutaImagenOriginal);
    }
    if($extension == 'jpg' || $extension == 'JPG'){
    $img_original = imagecreatefromjpeg($rutaImagenOriginal);
    }
    if($extension == 'png' || $extension == 'PNG'){
    $img_original = imagecreatefrompng($rutaImagenOriginal);
    }
    $max_ancho = $ancho;
    $max_alto = $alto;
    list($ancho,$alto)=getimagesize($rutaImagenOriginal);
    $x_ratio = $max_ancho / $ancho;
    $y_ratio = $max_alto / $alto;
    if( ($ancho <= $max_ancho) && ($alto <= $max_alto) ){//Si ancho 
  	$ancho_final = $ancho;
		$alto_final = $alto;
	} elseif (($x_ratio * $alto) < $max_alto){
		$alto_final = ceil($x_ratio * $alto);
		$ancho_final = $max_ancho;
	} else{
		$ancho_final = ceil($y_ratio * $ancho);
		$alto_final = $max_alto;
	}
    $tmp=imagecreatetruecolor($ancho_final,$alto_final);
    imagecopyresampled($tmp,$img_original,0,0,0,0,$ancho_final, $alto_final,$ancho,$alto);
    imagedestroy($img_original);
    $calidad=70;
    imagejpeg($tmp,$ruta.$nombreN,$calidad);
    
}

?>
<!DOCTYPE html>
<html>
    <head>
    <title><?php echo $titulo_form;?></title>
	<?php
		require('nav_plantilla/nav_css.php');
	?>
        </style>
        
    </head>
    
    <body>
        <!-- HEADER -->


        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
        
            <header>
                <h1>Área para cargar y reducir imágenes.</h1>
                <em>Área para subir imágenes, reducirlas, hacer versiones miniatura y
                conservar la versión original. Validando que sean únicamente PNG y JPG.</em>
            </header>
            </div>
            <div class="col-md-3"></div>
        </div>



        
        <!-- SECCION -->
        <div class="col-md-3"></div>
        <div class="col-md-6">
        <section>

            <?php if(isset($_POST['submit'])) { ?>
            <!-- <div class="msg">El archivo ha sido cargado satisfactoriamente.</div> -->
            <?php } ?>
            
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>"
                  method="POST"
                  enctype="multipart/form-data">
                <fieldset>
                    <legend>Seleccionar una imagen</legend>
                    <div><input type="file" name="foto" class="form-control" /></div>
                    <div style="margin-top: 10px;"><input type="submit" name="submit" class="btn btn-default" />
                    <a href="<?php echo $_SERVER['PHP_SELF']; ?>">Reiniciar</a></div>
                    <br>
                    <div class="row">
                    <div class="col-md-8">
                    <span class="label label-danger"><?php echo $mensaje_error; ?></span>
                    </div>
            
            </div>
                    <a href="<?php echo $form_padre;?>" target="_self" rel="noopener noreferrer"><button id="btn_regresar" type="button" class="btn btn-default "><i class="fa fa-warning"></i>&nbsp;&nbsp; &nbsp; Regresar &nbsp;&nbsp;</button></a> 
                </fieldset>
                <input type="hidden" id="destino" name="destino" value="<?php echo $carpeta; ?>">
                <input type="hidden" id="codigo" name="codigo" value="<?php echo $nombre; ?>">
                <input type="hidden" id="padre" name="padre" value="<?php echo $form_padre; ?>">
            </form>
            
            <div style="margin-top: 25px; font-size: small;">
                
            </div>
            
        </section>
        </div>
        <div class="col-md-3"></div>
      
        <!-- FOOTER -->
        <footer>
        <?php
				require('nav_plantilla/nav_footer.php');
			?>
        </footer>
        
        <!-- FIN DE LA PÁGINA -->
        <!-- EOF -->
    </body>
</html>
