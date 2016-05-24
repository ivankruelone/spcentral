						<?php
                        
                        $row = $query->row();
	
?>
                        	<div class="row-fluid">
                                <div class="span12">
                                    
                                    <?php echo MY_form_open('inventario/cantidad_submit'); ?>
                                    
                                    <?php echo MY_form_input('cvearticulo', 'cvearticulo', 'Clave de articulo', 'text', 'Clave de articulo', 3, true, $row->cvearticulo, true); ?>

                                    <?php echo MY_form_input('susa', 'susa', 'Susa', 'text', 'Susa', 12, true, $row->susa, true); ?>

                                    <?php echo MY_form_input('descripcion', 'descripcion', 'Descripcion', 'text', 'Descripcion', 12, true, $row->descripcion, true); ?>

                                    <?php echo MY_form_input('pres', 'pres', 'Presentacion', 'text', 'Presentacion', 12, true, $row->pres, true); ?>

                                    <?php echo MY_form_input('cantidad', 'cantidad', 'Cantidad', 'number', 'Cantidad', 3, true, $row->cantidad); ?>

                                    <?php echo form_hidden('inventarioID', $row->inventarioID); ?>

                                    <?php echo MY_form_submit(); ?>
                                    
                                    <?php echo form_close(); ?>
                                    
								</div>	
                            </div>
