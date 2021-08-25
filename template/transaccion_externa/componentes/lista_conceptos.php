<?php


session_start();

require_once '../../../src_php/db/db_funciones.php';

require_once '../../../src_php/db/funciones_generales.php';

$db_concepto = new db_funciones();
$concepto_general = new funciones_generales();


$tipo = '';

if (isset($_GET['tipo']) && !empty($_GET['tipo'])) {
    $tipo = $_GET['tipo'] == "entrada" ? 1 : 0;
} else {
    $tipo = -1;
}

$consulta_conceptos = "SELECT 0 conc_codigo, '--Seleccione' conc_nombre, 'sin concepto' conc_tipo, 0 conc_estado
                        UNION ALL
                        SELECT conc_codigo, conc_nombre, conc_tipo, conc_estado
                        FROM conc_concepto
                        WHERE conc_tipo =" . $tipo;

$arreglo_concepto = $db_concepto->get_datos($consulta_conceptos, array());



?>

<label for="sel1">Concepto:</label>
<select class="form-control" id="sel_concepto">
    <?php
    foreach ($arreglo_concepto as $concepto) {
    ?>
    <option data-valor="<?php echo $concepto['conc_codigo']; ?>">
        <?php echo $concepto['conc_nombre']; ?>
    </option>
    <?php
    }
    ?>

</select>