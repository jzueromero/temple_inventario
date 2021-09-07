<?php
session_start();
if (!isset($_SESSION['usua_codigo'])) {
    header('location:index.php');
}

$modelo = 'Venta';
$nombre_form = "sis_venta";
$titulo_form = "Venta";
$descripcion_form = 'Aqui se catalogan o seccionan los comercios y afiliados de un comercio en especifico.';
$nombre_negocio = "BiciMandados Sv - Zona Administrativa";
@$numero_menu = 0;

@$venta_codigo = $_GET['venta_codigo'];

$q = $_GET['q'];
$desde = $_GET['desde'];
$hasta = $_GET['hasta'];

$sucursal = trim($_GET['s']);

@$nombre_comercio = '';
require '../src_php/db/db_funciones.php';

$tran = "/*SELECT tran_codigo, tran_codigo_temporal, tran_sucursal_codigo, ss.sucu_nombre, tran_tipo, tran_estado, tran_codigo_concepto,
        trim(tran_nombre_concepto) tran_nombre_concepto, tran_referencia, tran_comentario, tran_usuario, tran_fecha,tran_usuario_anula, tran_fecha_anula,
        concat( uu.usua_nombre,' ', uu.usua_apellido) usuario,
        (select concat(uu.usua_nombre,' ', uu.usua_apellido,' ',tran_fecha_anula)
        from usua_usuario uu2 where uu2.usua_codigo = tran_usuario_anula)  as anulo
        FROM tran_transaccion
        inner join sucu_sucursal ss  on ss.sucu_codigo = tran_sucursal_codigo
        inner join usua_usuario uu  on uu.usua_codigo  = tran_usuario
                WHERE tran_codigo=*/ $venta_codigo;";

@$tran_detalle = "/*SELECT trad_codigo, trand_tran_codigo, trand_producto_codigo, trad_producto_codigo_barra,
                trad_producto_nombre, trand_producto_costo, trand_unidad_codigo, trand_unidad, trand_unidad_precio,
                trand_unidad_cantidad, trand_cantidad
                FROM trad_detalle
                WHERE trand_tran_codigo=*/ " . @$venta_codigo;

$objeto_datos = new db_funciones();

$r_tran = $objeto_datos->get_datos($tran, array());
$r_deta = $objeto_datos->get_datos($tran_detalle, array());

@$tcodigo = 0;
@$tsucursal_codigo = 0;
@$sucursal = "";
@$ttipo_codigo = 0;
@$ttipo = "";
@$tconcepto = "";
@$tcomentario = "";
@$tusuario = "";
@$tfecha = "";
@$testado = "";
@$tanulado = "";

foreach ($r_tran as $item) {
    @$tcodigo = $item['tran_codigo'];
    @$tsucursal_codigo = $item['tran_sucursal_codigo'];
    @$sucursal = $item['sucu_nombre'];
    @$ttipo_codigo = $item['tran_tipo'];
    @$ttipo = @$ttipo_codigo == 0 ? "SALIDA" : "ENTRADA";
    @$tconcepto = trim($item['tran_nombre_concepto']);
    @$tcomentario = trim($item['tran_comentario']);
    @$tusuario = $item['usuario'];
    @$tfecha = $item['tran_fecha'];
    @$testado = $item['tran_estado'];
    @$tanulado = trim($item['anulo']);
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
                        </div>
                        <div class="panel-body no-padding">
                            <div class="col-md-12">


                                <div class="row">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">Visor de Transacción de Inventario</div>
                                        <div class="panel-body">

                                            <div class="panel-body">
                                                <div class="row">
                                                    <input type="hidden" id="hdd_query" value="<?php echo $q; ?>">
                                                    <input type="hidden" id="hdd_desde" value="<?php echo $desde; ?>">
                                                    <input type="hidden" id="hdd_hasta" value="<?php echo $hasta; ?>">
                                                    <input type="hidden" id="hdd_susursal" value="<?php echo $sucursal; ?>">
                                                    <input type="hidden" id="hdd_codigo" value="<?php echo $venta_codigo; ?>">


                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="input-group">
                                                                <span class="input-group-addon" id="basic-addon1">Código</span>
                                                                <label class="form-control" aria-describedby="basic-addon1"><?php echo $tcodigo; ?></label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="input-group">
                                                                <span class="input-group-addon" id="basic-addon2">Sucursal</span>
                                                                <label class="form-control" aria-describedby="basic-addon2"><?php echo $sucursal; ?></label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="input-group">
                                                                <span class="input-group-addon" id="basic-addon2">Tipo</span>
                                                                <label class="form-control" aria-describedby="basic-addon2"><?php echo $ttipo; ?></label>

                                                            </div>
                                                        </div>
                                                        <hr>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="input-group">
                                                                <span class="input-group-addon" id="basic-addon2">Concepto</span>
                                                                <label class="form-control" aria-describedby="basic-addon2"><?php echo $tconcepto; ?></label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="input-group">
                                                                <span class="input-group-addon" id="basic-addon2">Comentario</span>
                                                                <input type="text" id="txt_comentario" name="txt_comentario" class="form-control" aria-describedby="basic-addon2" value="<?php echo trim($tcomentario); ?>" />
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <div class="input-group">
                                                                <span class="input-group-addon" id="basic-addon2">usuario</span>
                                                                <label class="form-control" aria-describedby="basic-addon2"><?php echo $tusuario; ?></label>

                                                            </div>
                                                        </div>
                                                        <hr>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="input-group">
                                                                <span class="input-group-addon" id="basic-addon2">Fecha</span>
                                                                <label class="form-control" aria-describedby="basic-addon2"><?php echo $tfecha; ?></label>

                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="input-group">
                                                                <span class="input-group-addon" id="basic-addon2">Estado</span>
                                                                <label class="form-control" aria-describedby="basic-addon2"><?php echo $testado; ?></label>

                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="input-group">
                                                                <span class="input-group-addon" id="basic-addon2">Anulado</span>
                                                                <label class="form-control" aria-describedby="basic-addon2"><?php echo $tanulado; ?></label>

                                                            </div>

                                                        </div>
                                                        <hr>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-8"></div>
                                                        <div class="col-md-4">
                                                            <button type="button" class="btn btn-default" id="btn_regresar">
                                                                << Regresar</button>
                                                                    <?php
                                                                    if ($testado != "ANULADO") {
                                                                    ?>
                                                                        <button type="button" class="btn btn-danger" id="btn_anular">Anular</button>

                                                                    <?php
                                                                    }

                                                                    ?>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row">
                                                        <table class="table table-hovertable table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th>Código</th>
                                                                    <th>Nombre</th>
                                                                    <th>Unidad</th>
                                                                    <th>Cantidad Unidades</th>
                                                                    <th>Cantidad</th>
                                                                    <th>Total</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                foreach ($r_deta as $item) {
                                                                ?>
                                                                    <tr>
                                                                        <td>
                                                                            <?php echo $item["trad_producto_codigo_barra"]; ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $item["trad_producto_nombre"]; ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $item["trand_unidad"]; ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $item["trand_unidad_cantidad"]; ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $item["trand_cantidad"]; ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $item["trand_unidad_cantidad"] * $item["trand_cantidad"]; ?>
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
                                    </div>

                                </div>
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

<script type="text/javascript">
    $(document).ready(function() {
        $('#btn_regresar').click(function() {
            sucursal = $('#hdd_susursal').val();
            desde = $('#hdd_desde').val();
            hasta = $('#hdd_hasta').val();
            query = $('#hdd_query').val();

            window.location.href = 'sis_movimiento.php?s=' + sucursal + '&desde=' + desde + '&hasta=' + hasta + '&q=' + query;
        });

    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#btn_anular').click(function() {
            venta_codigo = $('#hdd_codigo').val();

            anular(venta_codigo);

            //window.location.href = 'sis_movimiento.php?s=' + sucursal + '&desde=' + desde + '&hasta=' + hasta + '&q=' + query;
        });

    });
</script>


<script>
    function anularno(venta_codigo) {
        var comentario = $.trim($("#txt_comentario").val());

        alert(comentario.length);
        return;
        if (comentario.length == 0) {
            alert('Es obligatorio un comentario.');
        } else {
            cadena = "venta_codigo=" + venta_codigo;

            $.ajax({
                type: "POST",
                url: "./entradas_salidas_test/php/verificar_estado.php",
                data: cadena,
                success: function(r) {
                    if (r >= 1) {
                        anular_transaccion(venta_codigo);
                    } else {
                        alert("Esta transaccion ya fue anulada");
                    }
                }
            });
        }



    }
</script>

<script>
    function anular(venta_codigo) {
        var comentario = $.trim($("#txt_comentario").val());

        if (comentario.length < 3) {
            alert('Para anular, Es obligatorio un comentario.');
            $('#txt_comentario').focus();
        } else {

            sucursal = $('#hdd_susursal').val();
            desde = $('#hdd_desde').val();
            hasta = $('#hdd_hasta').val();
            query = $('#hdd_query').val();

            cadena = "venta_codigo=" + venta_codigo + "&comentario=" + comentario;

            $.ajax({
                type: "POST",
                url: "./entradas_salidas_test/php/anular_transaccion.php",
                data: cadena,
                success: function(r) {
                    if (r > 0) {
                        window.location.href = 'sis_movimiento.php?s=' + sucursal + '&desde=' + desde + '&hasta=' + hasta + '&q=' + query;
                    } else {
                        alert("No puede anularse.");
                    }
                }
            });
        }
    }
</script>