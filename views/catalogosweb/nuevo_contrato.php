							<div class="row-fluid">
                                <div class="span12">
                                    
                                    <?php echo MY_form_open('catalogosweb/nuevo_contrato_submit'); ?>
                                    
                                    <?php echo MY_form_input('numero', 'numero', 'Texto del contrato', 'text', 'Numero de contrato', 6, true); ?>

                                    <?php echo MY_form_input('denominado', 'denominado', 'Nombre corto', 'text', 'Nombre corto', 6, true); ?>

                                    <?php echo form_hidden('rfc', $rfc); ?>
                                    
                                    <?php echo MY_form_submit(); ?>
                                    
                                    <?php echo form_close(); ?>
                                    
								</div>	
                            </div>