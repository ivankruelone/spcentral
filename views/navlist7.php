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
                        

							<li id="navlist-catalogosweb-tipos_de_clientes">
                                <?php echo anchor('catalogosweb/tipos_de_clientes', '<i class="icon-double-angle-right"></i>Tipos de Clientes'); ?>
							</li>

							<li id="navlist-catalogosweb-clientes">
                                <?php echo anchor('catalogosweb/clientes', '<i class="icon-double-angle-right"></i>Clientes'); ?>
							</li>

							<li id="navlist-catalogosweb-clientes_de_credito_autorizados">
                                <?php echo anchor('catalogosweb/clientes_de_credito_autorizados', '<i class="icon-double-angle-right"></i>Clientes de credito autorizados'); ?>
							</li>

							<li id="navlist-catalogosweb-productos_por_secuencia">
                                <?php echo anchor('catalogosweb/productos_por_secuencia', '<i class="icon-double-angle-right"></i>Productos por secuencia'); ?>
							</li>

							<li id="navlist-catalogosweb-productos_con_precio_especial_por_secuencia">
                                <?php echo anchor('catalogosweb/productos_con_precio_especial_por_secuencia', '<i class="icon-double-angle-right"></i>Precio especial por secuencia'); ?>
							</li>

							<li id="navlist-catalogosweb-productos_por_codigo_de_barras">
                                <?php echo anchor('catalogosweb/productos_por_codigo_de_barras', '<i class="icon-double-angle-right"></i>Productos por codigo de barras'); ?>
							</li>

							<li id="navlist-catalogosweb-productos_con_precio_especial_por_barras">
                                <?php echo anchor('catalogosweb/productos_con_precio_especial_por_barras', '<i class="icon-double-angle-right"></i>Precio especial por codigo de barras'); ?>
							</li>

							<li id="navlist-catalogosweb-productos_con_comision">
                                <?php echo anchor('catalogosweb/productos_con_comision', '<i class="icon-double-angle-right"></i>Productos con comisi&oacute;n'); ?>
							</li>

							<li id="navlist-catalogosweb-descuentos_por_mayoreo">
                                <?php echo anchor('catalogosweb/descuentos_por_mayoreo', '<i class="icon-double-angle-right"></i>Descuentos por mayoreo'); ?>
							</li>

							<li id="navlist-catalogosweb-formas_de_pago">
                                <?php echo anchor('catalogosweb/formas_de_pago', '<i class="icon-double-angle-right"></i>Formas de pago'); ?>
							</li>

							<li id="navlist-catalogosweb-lineas">
                                <?php echo anchor('catalogosweb/lineas', '<i class="icon-double-angle-right"></i>Lineas'); ?>
							</li>

							<li id="navlist-catalogosweb-sublineas">
                                <?php echo anchor('catalogosweb/sublineas', '<i class="icon-double-angle-right"></i>Sublineas'); ?>
							</li>

							<li id="navlist-catalogosweb-proveedores">
                                <?php echo anchor('catalogosweb/proveedores', '<i class="icon-double-angle-right"></i>Proveedores'); ?>
							</li>

							<li id="navlist-catalogosweb-sucursales">
                                <?php echo anchor('catalogosweb/sucursales', '<i class="icon-double-angle-right"></i>Sucursales'); ?>
							</li>

							<li id="navlist-catalogosweb-usuarios">
                                <?php echo anchor('catalogosweb/usuarios', '<i class="icon-double-angle-right"></i>Usuarios'); ?>
							</li>

						</ul>
					</li>

					<li id="navlist-inventario">
						<a href="#" class="dropdown-toggle">
							<i class="icon-book"></i>
							<span class="menu-text"> Inventario </span>
							<b class="arrow icon-angle-down"></b>
						</a>

						<ul class="submenu">
                        
							<li id="navlist-inventario-por_susursal">
                                <?php echo anchor('inventario/por_sucursal', '<i class="icon-double-angle-right"></i>Por sucursal'); ?>
							</li>

							<li id="navlist-inventario-por_secuencia">
                                <?php echo anchor('inventario/por_secuencia', '<i class="icon-double-angle-right"></i>Por secuencia'); ?>
							</li>
                            
							<li id="navlist-inventario-por_codigo_de_barras">
                                <?php echo anchor('inventario/por_codigo_de_barras', '<i class="icon-double-angle-right"></i>Por codigo de barras'); ?>
							</li>

							<li id="navlist-inventario-secuencias_en_cero">
                                <?php echo anchor('inventario/secuencias_en_cero', '<i class="icon-double-angle-right"></i>Secuencias en cero'); ?>
							</li>

							<li id="navlist-inventario-negativos">
                                <?php echo anchor('inventario/negativos', '<i class="icon-double-angle-right"></i>Negativos'); ?>
							</li>

							<li id="navlist-inventario-negativos_con_codigo_de_barras">
                                <?php echo anchor('inventario/negativos_con_codigo_de_barras', '<i class="icon-double-angle-right"></i>Negativos con codigo de barras'); ?>
							</li>

							<li id="navlist-inventario-maximos">
                                <?php echo anchor('inventario/maximos', '<i class="icon-double-angle-right"></i>Negativos con codigo de barras'); ?>
							</li>

                        </ul>
                    
                    </li>
                    
                    <li id="navlist-ventas">
						<a href="#" class="dropdown-toggle">
							<i class="icon-money"></i>
							<span class="menu-text"> Ventas </span>
							<b class="arrow icon-angle-down"></b>
						</a>

						<ul class="submenu">
                        
							<li id="navlist-ventas-ventas_por_sucursal">
                                <?php echo anchor('ventas/ventas_por_sucursal', '<i class="icon-double-angle-right"></i>Ventas por sucursal'); ?>
							</li>
                            
							<li id="navlist-ventas-ventas_por_periodo">
                                <?php echo anchor('ventas/ventas_por_periodo', '<i class="icon-double-angle-right"></i>Ventas por periodo'); ?>
							</li>

                            <li id="navlist-ventas-negados_por_secuencia">
                                <?php echo anchor('ventas/negados_por_secuencia', '<i class="icon-double-angle-right"></i>Negados por Secuencia'); ?>
							</li>
                            
                            <li id="navlist-ventas-negados_por_cbarras">
                                <?php echo anchor('ventas/negados_por_cbarras', '<i class="icon-double-angle-right"></i>Negados por C. Barras'); ?>
							</li>
                            
                        </ul>
                    
                    </li>
                    
                    <li id="navlist-entradas">
						<a href="#" class="dropdown-toggle">
							<i class="icon-money"></i>
							<span class="menu-text"> Entradas </span>
							<b class="arrow icon-angle-down"></b>
						</a>

						<ul class="submenu">
                        
							<li id="navlist-entradas-entradas_por_sucursal">
                                <?php echo anchor('entradas/entradas_por_sucursal', '<i class="icon-double-angle-right"></i>Entradas por sucursal'); ?>
							</li>
                            
							<li id="navlist-entradas-traspasoss_por_sucursal">
                                <?php echo anchor('entradas/traspasos_por_sucursal', '<i class="icon-double-angle-right"></i>Traspasos por sucursal'); ?>
							</li>

                        </ul>
                    
                    </li>

                    <li id="navlist-reportes">
						<a href="#" class="dropdown-toggle">
							<i class="icon-file-alt"></i>
							<span class="menu-text"> Reportes </span>
							<b class="arrow icon-angle-down"></b>
						</a>

						<ul class="submenu">
                        
							<li id="navlist-reportes-reporte_antibioticos_por_periodo">
                                <?php echo anchor('reportes/reporte_antibioticos_por_periodo', '<i class="icon-double-angle-right"></i>Reporte de Antibioticos'); ?>
							</li>
                            
                            <li id="navlist-reportes-reporte_consultas_por_periodo">
                                <?php echo anchor('reportes/reporte_consultas_por_periodo', '<i class="icon-double-angle-right"></i>Reporte de Consultas'); ?>
							</li>
                            
                            
                        </ul>
                    
                    </li>

                        
                        
   				</ul><!--/.nav-list-->