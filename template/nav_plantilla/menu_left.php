<?php

 $sitios_menu =  array(
                   array ("sub"=>0,
                        "archivo" => "home.php",
                        "clase" => "lnr lnr-home",
                        "titulo" => "Principal"), 

                        array( "sub"=>0,
                        "archivo" => "sis_unidad.php",
                        "clase" => "lnr lnr-file-empty",
                        "titulo" => "Unidades"), 

                        array( "sub"=>0,
                        "archivo" => "sis_laboratorio.php",
                        "clase" => "lnr lnr-file-empty",
                        "titulo" => "Laboratorios"), 

                        array( "sub"=>0,
                        "archivo" => "sis_cliente.php",
                        "clase" => "lnr lnr-file-empty",
                        "titulo" => "Clientes"),

                        array( "sub"=>0,
                        "archivo" => "sis_proveedor.php",
                        "clase" => "lnr lnr-file-empty",
                        "titulo" => "Proveedores"), 

                        array( "sub"=>0,
                        "archivo" => "sis_producto.php",
                        "clase" => "lnr lnr-file-empty",
                        "titulo" => "Productos"), 

                    array( "sub"=>0,
                    "archivo" => "sis_usuario.php",
                    "clase" => "lnr lnr-user",
                    "titulo" => "Gestión Usuarios"),

                    array( "sub"=>0,
                    "archivo" => "sis_sucursal.php",
                    "clase" => "lnr lnr-home",
                    "titulo" => "Gestión Agencias - Sucursales"),

                    array( "sub"=>1,
                    "archivo" => "platilla.php",
                    "clase" => "lnr lnr-store",
                    "titulo" => "Salidas y Entradas de inventario",
                    "titulo_sub" => "sub_plantilla",
                    "sub_menus" => array(
   
                        array( "archivo" => "sis_movimiento.php",
                                    "clase" => "lnr lnr-users",
                                    "titulo" => "Historial Movimientos de Producto"),

                                 array( "archivo" => "sis_entrada.php",
                                "clase" => "lnr lnr-cog",
                                "titulo" => "Nueva Entrada Producto"),

                                   array( "archivo" => "sis_salida.php",
                                    "clase" => "lnr lnr-cog",
                                    "titulo" => "Nueva Salida Producto")

                                                               
                                )
                    ),

                   array( "sub"=>0,
                        "archivo" => "#",
                        "clase" => "lnr lnr-file-empty",
                        "titulo" => "Plantilla publica"), 

                   array( "sub"=>0,
                         "archivo" => "#",
                         "clase" => "lnr lnr-code",
                         "titulo" => "Orden de Elementos"),    

                   array( "sub"=>0,
                        "archivo" => "#",
                        "clase" => "lnr lnr-chart-bars",
                         "titulo" => "Reportes"),      

                   array( "sub"=>0,
                        "archivo" => "#",
                        "clase" => "lnr lnr-cog",
                         "titulo" => "Orden pagina web"),

               
                );
 
 

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