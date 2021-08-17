<?php
session_start();

require_once '../../../src_php/db/db_funciones.php';

require_once '../../../src_php/db/funciones_generales.php';

$db_existencias = new db_funciones();
$concepto_general = new funciones_generales();


$codigo_producto = '';

if (isset($_GET['codigo_producto']) && !empty($_GET['codigo_producto'])) {
    $codigo_producto = $_GET['codigo_producto'];
} else {
    $codigo_producto = -1;
}

$pbarras = "";
$pnombre = "";
$punidad = "";
$pexistencia1 =0 ;
$pexistencia2 =0 ;
$pexistencia3 =0 ;
$pexistencia4 =0 ;
$pexistencia5 =0 ;

$consulta_existencias = "select pp.prod_codigo, pp.prod_codigo_barra, pp.prod_nombre,  pp.prod_unidad, 
                        pp.prod_existencia1,
                        pp.prod_existencia2, pp.prod_existencia3,
                        pp.prod_existencia4, pp.prod_existencia5
                        from prod_producto pp 
                        where 
                        pp.prod_codigo  = " . $codigo_producto;

$arreglo_existencias = $db_existencias->get_datos($consulta_existencias, array());

foreach ($arreglo_existencias as $item) 
		{
			@$pbarras = $item['prod_codigo_barra']; 
			@$pnombre = $item['prod_nombre']; 
			@$punidad = $item['prod_unidad']; 
			@$pexistencia1 = $item['prod_existencia1'] < 0 ? 0 : $item['prod_existencia1']; 
			@$pexistencia2 = $item['prod_existencia2'] < 0 ? 0 : $item['prod_existencia2'];
			@$pexistencia3 = $item['prod_existencia3'] < 0 ? 0 : $item['prod_existencia3'];
			@$pexistencia4 = $item['prod_existencia4'] < 0 ? 0 : $item['prod_existencia4'];
			@$pexistencia5 = $item['prod_existencia5'] < 0 ? 0 : $item['prod_existencia5'];
		}

?>

<table class="table table-hover table-condensed table-bordered" >
<input type="hidden" name="existencia1" id="existencia1" value="<?php echo $pexistencia1; ?>" >
<input type="hidden" name="existencia2" id="existencia2" value="<?php echo $pexistencia2; ?>" >
<input type="hidden" name="existencia3" id="existencia3" value="<?php echo $pexistencia3; ?>" >
<input type="hidden" name="existencia4" id="existencia4" value="<?php echo $pexistencia4; ?>" >
<input type="hidden" name="existencia5" id="existencia5" value="<?php echo $pexistencia5; ?>" >
    <thead>
        <td>Sucursal</td>
        <td>Unidad</td>
        <td>Existencias</td>
    </thead>

    <?php

        for ($i=1; $i <= 5 ; $i++) { 
            ?>
            <tr>
            <td>
                <?php 
                
                    switch ($i) {
                        case 1:
                            echo SS1_n;
                            break;
                        case 2:
                            echo SS2_n;
                            break; 
                        case 3:
                            echo SS3_n;
                            break; 
                        case 4:
                            echo SS4_n;
                            break; 
                        case 5:
                            echo SS5_n;
                            break;
                    
                    }
                
                ?>
            </td>
            <td>
                <?php
    $consulta_equi = "select 0 codigo, IF(pp.prod_unidad IS NULL or pp.prod_unidad = '',
                                        'Unidad', pp.prod_unidad) as unidad, 1 cantidad, pp.prod_precio precio
                                        from prod_producto pp
                                        where pp.prod_codigo = " . $codigo_producto . "
                                        union all
                                        select ee.equi_codigo codigo, ee.equi_nombre unidad, ee.equi_cantidad cantidad, ee.equi_precio precio
                                        from equi_equivalencia ee
                                        inner join prod_producto pp2 on pp2.prod_codigo = ee.equi_codigo_producto
                                        where
                                        ee.equi_codigo_producto  = " . $codigo_producto;
    
        $arreglo_equi = $db_existencias->get_datos($consulta_equi, array());
        ?>
                <select class="form-control" onchange="<?php echo "CalcularExistencia('$i')"; ?>"
                    name="sel_existencia<?php echo $i; ?>" id="sel_existencia<?php echo $i; ?>">
                    <?php
                        foreach ($arreglo_equi as $equi) {
                                ?>
                                        <option data-producto="<?php echo $codigo_producto; ?>" data-equi="<?php echo $equi['codigo']; ?>"
                                            data-precio="<?php echo $equi['precio']; ?>" data-unidad="<?php echo $equi['unidad']; ?>"
                                            data-cantidad="<?php echo $equi['cantidad']; ?>"
                                            data-barra="<?php echo $pbarras; ?>"
                                            data-nombre="<?php echo $pnombre; ?>">
    
                                            <?php echo strtoupper( $equi['unidad'] .' (* '.$equi['cantidad'].' '.$punidad.' )'); ?>
                                        </option>
                                        <?php
                        }
                            ?>
                </select>
            </td>
            <td>
            <?php
                $existencia_total = 0;
                    switch ($i) {
                        case 1:
                            $existencia_total = $pexistencia1 ;
                            break;
                        case 2:
                            $existencia_total = $pexistencia2 ;
                            break; 
                        case 3:
                            $existencia_total = $pexistencia3 ;
                            break; 
                        case 4:
                            $existencia_total = $pexistencia4 ;
                            break; 
                        case 5:
                            $existencia_total = $pexistencia5 ;
                            break;
                    
                    }
                    ?>
                    <input type="text" readonly="" id="txt_existencia<?php echo $i; ?>" value="<?php echo $existencia_total; ?>" >
                    
                    
            </td>
        </tr>
    <?php
        }

    ?>
    
    

</table>