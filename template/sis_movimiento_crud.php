<?php
session_start();
if (!isset($_SESSION['usua_codigo'])) {
    header('location:index.php');
}

$modelo = 'menu o catalogos';
$nombre_form = "sis_menu";
$titulo_form = "Menus o Catalogos";
$descripcion_form = 'Aqui se catalogan o seccionan los comercios y afiliados de un comercio en especifico.';
$nombre_negocio = "BiciMandados Sv - Zona Administrativa";
@$numero_menu = 0;

@$codigo = $_GET['codigo'];

$q = $_GET['q'];
$desde = $_GET['desde'];
$hasta = $_GET['hasta'];

$sucursal = trim($_GET['s']);


@$nombre_comercio = '';
require '../src_php/db/db_funciones.php';

$tran = "SELECT tran_codigo, tran_codigo_temporal, tran_sucursal_codigo, tran_tipo, tran_estado, tran_codigo_concepto, 
                trim(tran_nombre_concepto), tran_referencia, tran_comentario, tran_usuario, tran_fecha,tran_usuario_anula, tran_fecha_anula 
                FROM tran_transaccion
                WHERE tran_codigo= $codigo;";

@$tran_detalle = "SELECT trad_codigo, trand_tran_codigo, trand_producto_codigo, trad_producto_codigo_barra,
                trad_producto_nombre, trand_producto_costo, trand_unidad_codigo, trand_unidad, trand_unidad_precio,
                trand_unidad_cantidad, trand_cantidad
                FROM trad_detalle
                WHERE trand_tran_codigo= " . @$codigo;

$objeto_datos = new db_funciones();

$r_tran = $objeto_datos->get_datos($tran, array());
$r_deta = $objeto_datos->get_datos($tran_detalle, array());


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
                                                    <input type="hidden" id="hdd_codigo" value="<?php echo $codigo; ?>">


                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="input-group">
                                                                <span class="input-group-addon" id="basic-addon1">Código</span>
                                                                <label class="form-control" aria-describedby="basic-addon1">Código</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="input-group">
                                                                <span class="input-group-addon" id="basic-addon2">Sucursal</span>
                                                                <label class="form-control" aria-describedby="basic-addon2">Sucursal</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="input-group">
                                                                <span class="input-group-addon" id="basic-addon2">Tipo</span>
                                                                <label class="form-control" aria-describedby="basic-addon2">Tipo</label>

                                                            </div>
                                                        </div>
                                                        <hr>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="input-group">
                                                                <span class="input-group-addon" id="basic-addon2">Concepto</span>
                                                                <label class="form-control" aria-describedby="basic-addon2">Concepto</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="input-group">
                                                                <span class="input-group-addon" id="basic-addon2">Comentario</span>
                                                                <label class="form-control" aria-describedby="basic-addon2">Comentario</label>

                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <div class="input-group">
                                                                <span class="input-group-addon" id="basic-addon2">usuario</span>
                                                                <label class="form-control" aria-describedby="basic-addon2">usuario</label>

                                                            </div>
                                                        </div>
                                                        <hr>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="input-group">
                                                                <span class="input-group-addon" id="basic-addon2">@example.com</span>
                                                                <label class="form-control" aria-describedby="basic-addon2">Fecha</label>

                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="input-group">
                                                                <span class="input-group-addon" id="basic-addon2">Estado</span>
                                                                <label class="form-control" aria-describedby="basic-addon2">Estado</label>

                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="input-group">
                                                                <span class="input-group-addon" id="basic-addon2">Anulado</span>
                                                                <label class="form-control" aria-describedby="basic-addon2">Anulado</label>

                                                            </div>

                                                        </div>
                                                        <hr>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-8"></div>
                                                        <div class="col-md-4">
                                                            <button type="button" class="btn btn-default" id="btn_regresar">
                                                                << Regresar</button>
                                                                    <button type="button" class="btn btn-danger" id="btn_anular">Anular</button>
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
            codigo = $('#hdd_codigo').val();

            anular(codigo);

            //window.location.href = 'sis_movimiento.php?s=' + sucursal + '&desde=' + desde + '&hasta=' + hasta + '&q=' + query;
        });

    });
</script>


<script>
    function anular(codigo)
{
	cadena="codigo=" + codigo;

	$.ajax({
	type:"POST",
	url:"verificar_estado",
	data:cadena,
	success:function(r){
		//alert(r);
		if(r>0){
			procesar_transaccion(transaccion_codigo,tipo,sucursal,sucursal_nombre,concepto,concepto_nombre,comentario);
		}else{
			alertify.error("No se puede procesar sin productos");
		}
	}
	});
}
</script>