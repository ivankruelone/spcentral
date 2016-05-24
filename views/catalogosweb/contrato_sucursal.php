							<div class="row-fluid">
                                <div class="span12">
                                    
                                    <?php echo MY_form_open('catalogosweb/contrato_sucursal_submit1', 'forma1'); ?>
                                    
                                    <?php echo MY_form_input('clvsucursal', 'clvsucursal', 'Sucursal', 'text', 'Sucursal', 3, true); ?>

                                    <?php echo MY_form_submit(); ?>
                                    
                                    <?php echo form_close(); ?>
                                    
								</div>	
                            </div>

							<div class="row-fluid">
                                <div class="span12">
                                    
                                    <?php echo MY_form_open('catalogosweb/contrato_sucursal_submit2', 'forma2'); ?>
                                    
                                    <?php echo MY_form_input('clvsucursal1', 'clvsucursal1', 'Desde Sucursal', 'text', 'Desde Sucursal', 3, true); ?>

                                    <?php echo MY_form_input('clvsucursal2', 'clvsucursal2', 'Hasta Sucursal', 'text', 'Hasta Sucursal', 3, true); ?>

                                    <?php echo MY_form_submit(); ?>
                                    
                                    <?php echo form_close(); ?>
                                    
								</div>	
                            </div>

							<div class="row-fluid">
                                <div class="span12" id="sucursales">
                                
                                </div>
                            </div>
                     