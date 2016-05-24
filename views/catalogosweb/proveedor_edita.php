						<?php
                        
                        $row = $query->row();
	
?>
                        	<div class="row-fluid">
                                <div class="span12">
                                    
                                    <?php echo MY_form_open('catalogosweb/proveedor_edita_submit'); ?>
                                    
                                    <?php echo MY_form_input('rfc', 'rfc', 'Rfc', 'text', 'Rfc', 3, true, $row->rfc); ?>

                                    <?php echo MY_form_input('razon', 'razon', 'Razon social', 'text', 'Razon social', 6, true, $row->razon); ?>
                                    
                                    <?php echo form_hidden('proveedorID', $row->proveedorID); ?>

                                    <?php echo MY_form_submit(); ?>
                                    
                                    <?php echo form_close(); ?>
                                    
								</div>	
                            </div>
