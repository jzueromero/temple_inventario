<?php

$sitios_menu = array();

if($_SESSION['es_cajero'] == 1) 
{
    $sitios_menu =  array(
        array ("sub"=>0,
             "archivo" => "home.php",
             "clase" => "lnr lnr-home",
             "titulo" => "Principal"), 

         array( "sub"=>0,
         "archivo" => "sis_venta.php",
         "clase" => "lnr lnr-cart",
         "titulo" => "Ventas"),

    
     );

}
else
{
    $sitios_menu =  array(
        array ("sub"=>0,
             "archivo" => "home.php",
             "clase" => "lnr lnr-home",
             "titulo" => "Principal"), 

            

             array( "sub"=>0,
             "archivo" => "sis_concepto.php",
             "clase" => "lnr lnr-file-empty",
             "titulo" => "Conceptos"), 

             array( "sub"=>0,
             "archivo" => "sis_laboratorio.php",
             "clase" => "lnr lnr-file-empty",
             "titulo" => "Laboratorios"), 



             array( "sub"=>0,
             "archivo" => "sis_proveedor.php",
             "clase" => "lnr lnr-file-empty",
             "titulo" => "Proveedores"), 

             array( "sub"=>0,
             "archivo" => "sis_producto.php",
             "clase" => "lnr lnr-file-empty",
             "titulo" => "Productos"), 

             array( "sub"=>0,
             "archivo" => "sis_vencimiento.php",
             "clase" => "lnr lnr-file-empty",
             "titulo" => "Vencimientos"), 


         array( "sub"=>0,
         "archivo" => "sis_usuario.php",
         "clase" => "lnr lnr-user",
         "titulo" => "Gestión Usuarios"),

         array( "sub"=>0,
         "archivo" => "sis_sucursal.php",
         "clase" => "lnr lnr-home",
         "titulo" => "Gestión Agencias - Sucursales"),

         array( "sub"=>0,
         "archivo" => "sis_talonario.php",
         "clase" => "fa fa-map",
         "titulo" => "Talonarios"),

         array( "sub"=>0,
         "archivo" => "sis_kardex.php",
         "clase" => "lnr lnr-file-empty",
         "titulo" => "KARDEX"),

         array( "sub"=>0,
         "archivo" => "sis_movimiento.php",
         "clase" => "lnr lnr-store",
         "titulo" => "Salidas y Entradas de inventario"),

         array( "sub"=>0,
         "archivo" => "sis_venta.php",
         "clase" => "lnr lnr-cart",
         "titulo" => "Ventas"),

         array( "sub"=>0,
         "archivo" => "sis_envio.php",
         "clase" => "lnr lnr-rocket",
         "titulo" => "Envios Sucursales"),


    
     );

}

 /*
              array( "sub"=>0,
             "archivo" => "sis_cliente.php",
             "clase" => "lnr lnr-file-empty",
             "titulo" => "Clientes"),
 */
 

?>

<div id="sidebar-nav" class="sidebar">
			<div class="sidebar-scroll">
				<nav>
					<ul class="nav">
                    <?php
                        foreach($sitios_menu as $item=>$valor_item)
                        {
                            if($valor_item["sub"] == 0)
                            {
                                echo "<li><a href='". $valor_item["archivo"] ."' ><i class='". $valor_item["clase"] ."'></i> <span>". $valor_item["titulo"] ."</span></a></li>";
                            }
                            elseif($valor_item["sub"] == 1)
                            {
                             ?>
                             <li>
                                <a href='#subPages' data-toggle='collapse' class='collapsed'>
                                    <i class='<?php echo $valor_item["clase"]; ?>'></i>
                                    <span><?php echo $valor_item["titulo"]; ?></span> 
                                     <i class='icon-submenu lnr lnr-chevron-left'></i></a>
                                <div id='subPages' class='collapse'>
                                    <ul class='nav'>
                                   <?php
                                     foreach ($valor_item["sub_menus"] as $item_sub => $valor_sub) {
                                        echo "<li><a href='". $valor_sub["archivo"] ."' class=''>". $valor_sub["titulo"] ."</a></li>";
                                    }
                                   ?>
                                   

                                    </ul>
                                </div>
                            </li></li>
                             <?php
                               
                            }
                           
                        }
                    ?>

                       
					</ul>
				</nav>
			</div>
		</div>