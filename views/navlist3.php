<?php
    $this->db->where_in('subtipoMovimiento', array(1, 2, 3, 12, 15));
    $this->db->where('tipoMovimiento', 1);
	$mnu_Query1 = $this->db->get('subtipo_movimiento');

    $this->db->where_in('subtipoMovimiento', array(4, 5, 6, 7, 8, 9, 13));
    $this->db->where('tipoMovimiento', 2);
	$mnu_Query2 = $this->db->get('subtipo_movimiento');
?>
				<ul class="nav nav-list">
					<li id="navlist-workspace">
                    
                            <?php echo anchor('workspace', '<i class="icon-home"></i><span class="menu-text"> Home </span>'); ?>

					</li>

					<li id="navlist-catalogosweb">
						<a href="#" class="dropdown-toggle">
							<i class="icon-desktop"></i>
							<span class="menu-text"> Catalogos </span>
							<b class="arrow icon-angle-down"></b>
						</a>

						<ul class="submenu">
                        

							<li id="navlist-catalogosweb-articulo">
                                <?php echo anchor('catalogosweb/articulo/0', '<i class="icon-double-angle-right"></i>Medicamento'); ?>
							</li>

							<li id="navlist-catalogosweb-articulo">
                                <?php echo anchor('catalogosweb/articulo/1', '<i class="icon-double-angle-right"></i>Material de curacion'); ?>
							</li>

							<li id="navlist-catalogosweb-proveedor">
                                <?php echo anchor('catalogosweb/proveedor', '<i class="icon-double-angle-right"></i>Proveedores'); ?>
							</li>

							<li id="navlist-catalogosweb-cliente">
                                <?php echo anchor('catalogosweb/cliente', '<i class="icon-double-angle-right"></i>Clientes'); ?>
							</li>

							<li id="navlist-catalogosweb-actualiza">
                                <?php echo anchor('catalogosweb/actualiza', '<i class="icon-double-angle-right"></i>Actualiza'); ?>
							</li>

							<li id="navlist-catalogosweb-actualizaManual">
                                <?php echo anchor('catalogosweb/actualizaManual', '<i class="icon-double-angle-right"></i>actualiza Manual'); ?>
							</li>

							<li id="navlist-catalogosweb-exportar">
                                <?php echo anchor('catalogosweb/exportar', '<i class="icon-double-angle-right"></i>Exportar Datos'); ?>
							</li>

							<li id="navlist-catalogosweb-domicilio">
                                <?php echo anchor('catalogosweb/domicilio', '<i class="icon-double-angle-right"></i>Establece el Domicilio'); ?>
							</li>

						</ul>
					</li>

					<li id="navlist-captura">
						<a href="#" class="dropdown-toggle">
							<i class="icon-desktop"></i>
							<span class="menu-text"> Captura </span>
							<b class="arrow icon-angle-down"></b>
						</a>

						<ul class="submenu">
                        

							<li id="navlist-captura-recetas">
                                <?php echo anchor('captura/recetas', '<i class="icon-double-angle-right"></i>Captura de recetas'); ?>
							</li>

							<li id="navlist-captura-rango">
                                <?php echo anchor('captura/rango', '<i class="icon-double-angle-right"></i>Definir rango'); ?>
							</li>

							<li id="navlist-captura-edicion">
                                <?php echo anchor('captura/edicion', '<i class="icon-double-angle-right"></i>Edicion de recetas'); ?>
							</li>

							<li id="navlist-recetas_periodo">
                                <?php echo anchor('reportes/recetas_periodo', '<i class="icon-double-angle-right"></i>Reporte por Periodo'); ?>
							</li>

							<li id="navlist-reportes-consumo">
                                <?php echo anchor('reportes/consumo', '<i class="icon-double-angle-right"></i>Reporte de Consumos'); ?>
							</li>

							<li id="navlist-reportes-negado">
                                <?php echo anchor('reportes/negado', '<i class="icon-double-angle-right"></i>Reporte de Negados'); ?>
							</li>

						</ul>
					</li>
                    
					<li id="navlist-entrada">
						<a href="#" class="dropdown-toggle">
							<i class="icon-desktop"></i>
							<span class="menu-text"> Entrada </span>
							<b class="arrow icon-angle-down"></b>
						</a>

						<ul class="submenu">
                        
                            <?php foreach($mnu_Query1->result() as $row){?>
                        

							<li id="navlist-entrada-<?php echo $row->subtipoMovimientoDescripcion; ?>">
                                <?php echo anchor('movimiento/index/'.$row->tipoMovimiento.'/'.$row->subtipoMovimiento, '<i class="icon-double-angle-right"></i>'.$row->subtipoMovimientoDescripcion); ?>
							</li>
                            
                            <?php
                            
                            }

                            ?>

						</ul>
					</li>

					<li id="navlist-salida">
						<a href="#" class="dropdown-toggle">
							<i class="icon-desktop"></i>
							<span class="menu-text"> Salida </span>
							<b class="arrow icon-angle-down"></b>
						</a>

						<ul class="submenu">
                        
                            <?php foreach($mnu_Query2->result() as $row){?>
                        

							<li id="navlist-salida-<?php echo $row->subtipoMovimientoDescripcion; ?>">
                                <?php echo anchor('movimiento/index/'.$row->tipoMovimiento.'/'.$row->subtipoMovimiento, '<i class="icon-double-angle-right"></i>'.$row->subtipoMovimientoDescripcion); ?>
							</li>
                            
                            <?php
                            
                            }

                            ?>

						</ul>
					</li>

                    <li id="navlist-inventario">
						<a href="#" class="dropdown-toggle">
							<i class="icon-desktop"></i>
							<span class="menu-text"> Inventario </span>
							<b class="arrow icon-angle-down"></b>
						</a>

						<ul class="submenu">
                        
							<li id="navlist-inventario-reciba">
                                <?php echo anchor('inventario/reciba', '<i class="icon-double-angle-right"></i>Reciba'); ?>
							</li>

							<li id="navlist-inventario-index">
                                <?php echo anchor('inventario/index', '<i class="icon-double-angle-right"></i>Inventario'); ?>
							</li>

							<li id="navlist-inventario-concentrado">
                                <?php echo anchor('inventario/concentrado', '<i class="icon-double-angle-right"></i>Inventario concentrado por clave'); ?>
							</li>

							<li id="navlist-inventario-caducidades">
                                <?php echo anchor('inventario/caducidades', '<i class="icon-double-angle-right"></i>Reporte de Caducidades'); ?>
							</li>

							<li id="navlist-inventario-kardex">
                                <?php echo anchor('inventario/kardex', '<i class="icon-double-angle-right"></i>Seguimiento de Productos'); ?>
							</li>

							<li id="navlist-inventario-antibioticos">
                                <?php echo anchor('inventario/antibioticos', '<i class="icon-double-angle-right"></i>Reporte de Antibi&oacute;ticos'); ?>
							</li>

						</ul>
					</li>

                    <li id="navlist-almacen">
						<a href="#" class="dropdown-toggle">
							<i class="icon-desktop"></i>
							<span class="menu-text"> Almacen </span>
							<b class="arrow icon-angle-down"></b>
						</a>

						<ul class="submenu">
                        

							<li id="navlist-almacen-area">
                                <?php echo anchor('almacen/area', '<i class="icon-double-angle-right"></i>Areas'); ?>
							</li>

						</ul>
					</li>
                        
   				</ul><!--/.nav-list-->