							<div class="row-fluid">
                                <div class="span12">
                                    
                                    <?php echo MY_form_open('catalogosweb/proveedor_nuevo_submit'); ?>
                                    
                                    <?php echo MY_form_input('rfc', 'rfc', 'Rfc', 'text', 'Rfc', 3); ?>

                                    <?php echo MY_form_input('razon', 'razon', 'Razon social', 'text', 'Razon social', 6); ?>

                                    <?php echo MY_form_input('proveedorID', 'proveedorID', 'ID Proveedor', 'number', 'ID Proveedor', 3, true, 0); ?>

                                    <?php echo MY_form_submit(); ?>
                                    
                                    <?php echo form_close(); ?>
                                    
								</div>	
                            </div>
