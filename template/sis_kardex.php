<?php
session_start();
if (!isset($_SESSION['usua_codigo'])) {
    header('location:index.php');
}
require '../src_php/db/db_funciones.php';
$objeto_datos = new db_funciones();

$modelo = 'KARDEX';
$nombre_form = "sis_kardex";
$titulo_form = "Modulo kardex";
$descripcion_form = 'Monitor de movimiento de producto - entradas y salidas.';
$nombre_negocio = $objeto_datos->empresa;

@$q = "";
@$desde = "";
@$hasta = "";

if (!isset($_GET['q']) and !isset($_GET['desde']) and !isset($_GET['hasta'])) {
    $q = "";
    $fecha_hoy = $dram =  new DateTime();
    $desde  = $fecha_hoy->format('Y-m-d');
    $hasta = $desde;

    header("location:$nombre_form.php?desde=" . $desde . "&hasta=" . $hasta ."&s=0" . "&q=$q");
}

$q = $_GET['q'];
$desde = $_GET['desde'];
$hasta = $_GET['hasta'];

$sucursal = trim($_GET['s']);

if($sucursal == 0 || $sucursal =="")
{
    $sucursal = "k.kard_sucursal_codigo";
}

    $consulta = "SELECT kard_codigo, kard_tipo, kard_concepto,
                    kard_fecha, kard_sucursal_codigo, kard_producto_codigo,
                    prod_codigo_barra,
                    kard_producto_nombre, kard_unidad_codigo, kard_unidad,
                    kard_cantidad_unidades, kard_cantidad, kard_cantidad_unidades * kard_cantidad total
                from kardex k
                inner join prod_producto on prod_codigo = k.kard_producto_codigo
                where
                    k.kard_sucursal_codigo = $sucursal
                    and
                    (prod_codigo_barra like  '%" . $q . "%'
                    or prod_nombre like '%" . $q . "%'
                    or prod_descripcion like '%" . $q . "%')
                    and
                    DATE(kard_fecha) >= '" . $desde . "' and DATE(kard_fecha) <= '" . $hasta . "'
                order by prod_nombre, prod_codigo_barra;";            


$parametros = array();
$arreglo_datos = $objeto_datos->get_datos($consulta, $parametros);

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
                            <div class="col-md-12">
                                <div class=" row">
                                    <form action="sis_kardex.php" method="get">
                                        <div class="form-group col-sm-2  col-md-2">
                                            <label for="sel1">Sucursal:</label>
                                            <select class="form-control" id="s" name="s">
                                                <option value="0">
                                                    --Seleccione
                                                </option>
                                                <?php
                                                if (SS1 == "si") {
                                                ?>
                                                    <option value="1">
                                                        <?php
                                                        echo SS1_n;
                                                        ?>
                                                    </option>
                                                <?php
                                                }
                                                ?>
                                                <?php
                                                if (SS2 == "si") {
                                                ?>
                                                    <option value="2">
                                                        <?php
                                                        echo SS2_n;
                                                        ?>
                                                    </option>
                                                <?php
                                                }
                                                ?>
                                                <?php
                                                if (SS3 == "si") {
                                                ?>
                                                    <option value="3">
                                                        <?php
                                                        echo SS3_n;
                                                        ?>
                                                    </option>
                                                <?php
                                                }
                                                ?>
                                                <?php
                                                if (SS4 == "si") {
                                                ?>
                                                    <option value="4">
                                                        <?php
                                                        echo SS4_n;
                                                        ?>
                                                    </option>
                                                <?php
                                                }
                                                ?>
                                                <?php
                                                if (SS5 == "si") {
                                                ?>
                                                    <option value="5">
                                                        <?php
                                                        echo SS5_n;
                                                        ?>
                                                    </option>
                                                <?php
                                                }
                                                ?>


                                            </select>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="desde">desde</label>
                                                <input type="date" class="form-control" value="<?php echo $desde; ?>" name="desde" id="desde" placeholder="desde">
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="hasta">hasta</label>
                                                <input type="date" class="form-control" value="<?php echo $hasta; ?>" name="hasta" id="hasta" placeholder="hasta">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="busqueda">Busqueda</label>
                                                <input type="text" class="form-control" value="<?php echo $q; ?>" name="q" id="q" placeholder="Codigo de barra o nombre de producto">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <br>
                                                <button type="submit" class="btn btn-primary btn-block">Buscar</button>
                                            </div>


                                        </div>

                                        <div class="col-md-2">
                                        </div>
                                </div>
                                </form>
                                <div class="row">
                                    <table class="table  table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Tipo</th>
                                                <th>Sucursal</th>
                                                <th>Concepto</th>
                                                <th>Fecha</th>
                                                <th>Codigo</th>
                                                <th>Producto</th>
                                                <th>Unidad</th>
                                                <th>Unidades</th>
                                                <th>Cantidad</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($arreglo_datos as $item) {
                                            ?>
                                                <tr>
                                                    <td>

                                                        <?php echo $item["kard_codigo"]; ?>
                                                    </td>

                                                    <td>
                                                        <?php

                                                        $tipo = $item["kard_tipo"] == "SALIDA" ? "<h5><span class='label label-danger'>S A L I D A</span></h5>" : "<h5><span class='label label-success'>E N T R A D A</span></h5>";
                                                        echo  $tipo; ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $sucu = $item["kard_sucursal_codigo"];
                                                        if ($sucu == 2) {
                                                            echo SS2_n;
                                                        }
                                                        if ($sucu == 3) {
                                                            echo SS3_n;
                                                        }
                                                        if ($sucu == 4) {
                                                            echo SS4_n;
                                                        }
                                                        if ($sucu == 5) {
                                                            echo SS5_n;
                                                        } else {
                                                            echo SS1_n;
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $item["kard_concepto"]; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $item["kard_fecha"]; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $item["prod_codigo_barra"]; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $item["kard_producto_nombre"]; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $item["kard_unidad"]; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $item["kard_cantidad_unidades"]; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $item["kard_cantidad"]; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $item["total"]; ?>
                                                    </td>
                                                    
                                                </tr>


                                            <?php
                                            }

                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>


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