<?php
session_start();
if (!isset($_SESSION['usua_codigo'])) {
    header('location:index.php');
}

$formulario_acceso = "unidad";


require '../src_php/db/db_funciones.php';
$objeto_datos = new db_funciones();

$modelo = 'Permisos';
$nombre_form = "sis_acceso";
$titulo_form = "Modulo Permisos";
$descripcion_form = 'Configuracion de permisos para <strong>' . $_GET['nombre_completo'] . '</strong>';
$nombre_negocio = $objeto_datos->empresa;

@$codigo_usuario = 0;

$consulta = "select '' as marca,  ff.form_codigo, form_nombre, ff.form_ruta, ff.form_acceso from  form_formulario ff";
$parametros = array();
$arreglo_datos = $objeto_datos->get_datos($consulta, $parametros);
 
@$codigo_usuario = $_GET['usua_codigo'];

$consulta_accesos = "select * from acce_acceso where acce_usua_codigo = :cod_usuario";
$parametros_accesos = array(":cod_usuario" => $codigo_usuario);
$arreglo_accesos = $objeto_datos->get_datos($consulta_accesos, $parametros_accesos);

foreach($arreglo_accesos as $acceso)
{
    foreach ($arreglo_datos as &$dato) {
        if($acceso['acce_form_codigo'] == $dato['form_codigo'])
        {
            $dato['marca'] = " checked ";
        }
    }
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    $codigo_usuario = $_POST['hdd_codigo_usuario'];

    ///BORRAMOS LOS PERMISOS PREVIOS
        $consulta_delete = "DELETE FROM acce_acceso
                        WHERE acce_usua_codigo=:codigo;";
			$parametros = array(":codigo"=>$codigo_usuario);

			$objeto_datos = new db_funciones();

            // $objeto_datos->insert_historial($parametros_historial);
            
			$objeto_datos->insert_datos_2($consulta_delete, $parametros);
    ///BORRAMOS LOS PERMISOS PREVIOS

    ///insertamos los datos
    foreach ($_POST['seleccionados'] as $seleccionado)
    {
        if($seleccionado != 0 )
        {
            $consulta_insert = "INSERT INTO acce_acceso
                            (acce_usua_codigo, acce_form_codigo)
                            VALUES(:acce_usua_codigo, :acce_form_codigo);";
            $parametros = array(":acce_usua_codigo"=>$codigo_usuario,
                                ":acce_form_codigo"=>$seleccionado,  );

            $objeto_datos = new db_funciones();

            $objeto_datos->insert_datos_2($consulta_insert, $parametros);
        }
    }
    header('location: sis_usuario_crud.php?codigo='.$codigo_usuario);
    ///insertamos los datos
}

?>

<!doctype html>
<html lang="es">

<head>
    <title><?php echo $titulo_form; ?></title>
    <?php
    require 'nav_plantilla/nav_css.php';
    ?>


</head>

<body>
    <!-- WRAPPER -->
    <div id="wrapper">
        <!-- NAVBAR -->
        <nav class="navbar navbar-default navbar-fixed-top">
            <?php
            require 'nav_plantilla/nav_top.php';
            ?>
        </nav>
        <div class="clearfix"></div>-->
        <!-- LEFT SIDEBAR -->
        <?php
        require 'nav_plantilla/menu_left.php';
        ?>
        <!-- END LEFT SIDEBAR -->
        <!-- MAIN -->
        <div class="main">
            <!-- MAIN CONTENT -->
            <div class="main-content">
                <div class="container-fluid">
                    <!-- Zona Formularios -->


                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?php echo $titulo_form; ?></h3>
                            <p class="panel-subtitle"><?php echo $descripcion_form; ?></p>
                        </div>
                        <div class="panel-body no-padding">
                            <form method="POST" action="sis_acceso.php">
                                <div class="col-md-12">
                                    <div class="row">
                                    <div class="col-md-4 text-left">
                                            <input type="hidden" id="hdd_codigo_usuario" name="hdd_codigo_usuario" value="<?php echo $codigo_usuario;  ?>" />
                                                    <input type="submit" class="btn btn-default btn-block">Configurar <?php echo $modelo; ?> <submit/>
                                                
                                        </div>
                                        <div class="col-md-8"></div>
                                        

                                    </div>
                                    <div class="row">

                                        <table class="table table-hover">

                                            <tbody>
                                                <?php
                                                foreach ($arreglo_datos as $item) {
                                                ?>

                                                    <div class="col-lg-6 col-md-6 col-6">
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <input type="checkbox" aria-label="..."  name="seleccionados[]" <?php echo $item["marca"]; ?> value="<?php echo $item["form_codigo"]; ?>">
                                                            </span>
                                                            <Label class="form-control" for=""><?php echo $item["form_nombre"]; ?></Label>
                                                        </div><!-- /input-group -->
                                                    </div><!-- /.col-lg-6 -->


                                                <?php
                                                }

                                                ?>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>

                    <!-- Zona Formularios -->
                </div>
            </div>
            <!-- END MAIN CONTENT -->
        </div>
        <!-- END MAIN -->
        <div class="clearfix"></div>
        <footer>
            <?php
            require 'nav_plantilla/nav_footer.php';
            ?>
        </footer>
    </div>
    <!-- END WRAPPER -->
    <!-- Javascript -->
    <?php
    require 'nav_plantilla/nav_js.php';
    ?>

</body>

</html>