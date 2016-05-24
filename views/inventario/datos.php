						<?php
                        
                        $row = $query->row();
	
?>
                        	<div class="row-fluid">
                                <div class="span12">
                                    
                                    <?php echo MY_form_open('inventario/datos_submit'); ?>
                                    
                                    <?php echo MY_form_input('cvearticulo', 'cvearticulo', 'Clave de articulo', 'text', 'Clave de articulo', 3, true, $row->cvearticulo, true); ?>

                                    <?php echo MY_form_input('susa', 'susa', 'Susa', 'text', 'Susa', 12, true, $row->susa, true); ?>

                                    <?php echo MY_form_input('descripcion', 'descripcion', 'Descripcion', 'text', 'Descripcion', 12, true, $row->descripcion, true); ?>

                                    <?php echo MY_form_input('pres', 'pres', 'Presentacion', 'text', 'Presentacion', 12, true, $row->pres, true); ?>

                                    <?php echo MY_form_input('comercial', 'comercial', 'Marca comercial', 'text', 'Marca Comercial', 3, false, $row->comercial, false); ?>

                                    <?php echo MY_form_input('lote', 'lote', 'Lote', 'text', 'Lote', 3, true, $row->lote, false, '[a-zA-Z0-9&ntilde;&Ntilde;]+'); ?>

                                    <?php echo MY_form_input('caducidad', 'caducidad', 'Caducidad', 'text', 'Caducidad', 3, true, $row->caducidad); ?>
                                    
                                    <?php echo MY_form_input('ean', 'ean', 'EAN', 'text', 'EAN', 3, true, $row->ean, false, '[0-9]+'); ?>

                                    <?php echo MY_form_input('marca', 'marca', 'Marca', 'text', 'Marca', 3, true, $row->marca); ?>

                                    <?php echo form_hidden('inventarioID', $row->inventarioID); ?>

                                    <?php echo MY_form_submit(); ?>
                                    
                                    <?php echo form_close(); ?>
                                    
								</div>	
                            </div>
