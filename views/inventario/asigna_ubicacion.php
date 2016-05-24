						<?php
                        
                        $row = $query->row();
                        
                        if($row->ubicacion == null)
                        {
                            $ubica = 0;
                        }else{
                            $ubica = $row->ubicacion;
                        }
	
?>
                        	<div class="row-fluid">
                                <div class="span12">
                                    
                                    <?php echo MY_form_open('inventario/asigna_ubicacion_submit'); ?>
                                    
                                    <?php echo MY_form_input('cvearticulo', 'cvearticulo', 'Clave de articulo', 'text', 'Clave de articulo', 3, true, $row->cvearticulo, true); ?>

                                    <?php echo MY_form_input('susa', 'susa', 'Susa', 'text', 'Susa', 12, true, $row->susa, true); ?>

                                    <?php echo MY_form_input('descripcion', 'descripcion', 'Descripcion', 'text', 'Descripcion', 12, true, $row->descripcion, true); ?>

                                    <?php echo MY_form_input('pres', 'pres', 'Presentacion', 'text', 'Presentacion', 12, true, $row->pres, true); ?>

                                    <?php echo MY_form_input('lote', 'lote', 'Lote', 'text', 'Lote', 3, true, $row->lote, true, '[a-zA-Z0-9&ntilde;&Ntilde;]+'); ?>

                                    <?php echo MY_form_input('caducidad', 'caducidad', 'Caducidad', 'text', 'Caducidad', 3, true, $row->caducidad, true); ?>
                                    
                                    <?php echo MY_form_input('ean', 'ean', 'EAN', 'text', 'EAN', 3, true, $row->ean, true, '[0-9]+'); ?>

                                    <?php echo MY_form_input('marca', 'marca', 'Marca', 'text', 'Marca', 3, true, $row->marca, true); ?>

                                    <?php echo MY_form_input('cantidadMaxima', 'cantidadMaxima', 'Cantidad', 'text', 'Cantidad', 3, true, $row->cantidad, true); ?>

                                    <?php echo form_hidden('origen', $origen); ?>

                                    <?php echo form_close(); ?>
                                    


                                    <?php echo MY_form_open('inventario/asigna_ubicacion_disponibles_submit/'); ?>
                                    
                                    <?php echo MY_form_dropdown2('Ubicaciones Disponibles totales', 'ubicacion', $ubicacionesDisponibles, $ubica, 12);?>

                                    <?php echo MY_form_input('cantidad', 'cantidad', 'Cantidad', 'number', 'Cantidad', 3, true, $row->cantidad, false); ?>

                                    <?php echo form_hidden('inventarioID', $row->inventarioID); ?>

                                    <?php echo form_hidden('origen', $origen); ?>

                                    <?php echo MY_form_submit(); ?>
                                    
                                    <?php echo form_close(); ?>
                                    
								</div>	
                            </div>
                            
                            <div class="row-fluid">
                                <div class="span12" id="pasillo">
                                <div id="ultima_ubicacion" class="hide">0</div>
                                <div id="ultima_asignada" class="hide">0</div>
                                <div id="ubicacionOriginal" class="hide"><?php echo $ubica; ?></div>
                                <?php
                                
                                
                                
                                $query = $this->almacen_model->getPasillos();
        
                                foreach($query->result() as $row)
                                {
                                    echo '<h3>AREA: '.$row->area.' <span style="color: blue;">PASILLO: '.$row->pasillo.'</span></h3>';
                                    echo $this->almacen_model->drawModuloInventario($row->pasilloID);
                                }
                                
                                ?>
                                </div>
                            </div>
