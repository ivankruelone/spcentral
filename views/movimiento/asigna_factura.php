							<div class="row-fluid">
                                <div class="span12">
                                    
                                    <?php echo MY_form_open('movimiento/asigna_factura_submit'); ?>
                                    
                                    <?php 
                                    
                                        echo MY_form_input('referencia', 'referencia', 'Referencia de documento', 'text', 'Referencia de documento', 3); 
                                    
                                    ?>

                                    
                                    <?php echo form_hidden('movimientoID', $movimientoID); ?>

                                    <?php echo form_hidden('tipoMovimiento', $tipoMovimiento); ?>

                                    <?php echo form_hidden('subtipoMovimiento', $subtipoMovimiento); ?>

                                    <?php echo MY_form_submit(); ?>
                                    
                                    <?php echo form_close(); ?>
                                    
								</div>	
                            </div>
