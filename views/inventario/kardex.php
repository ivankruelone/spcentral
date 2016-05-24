							<div class="row-fluid">
                                <div class="span12">
                                    
                                    <?php echo MY_form_open('inventario/kardex_submit'); ?>
                                    
                                    <?php echo MY_form_input('articulo', 'articulo', 'Articulo', 'text', 'Articulo', 6); ?>
                                    
                                    <?php echo MY_form_dropdown2('Lote', 'lote', $lotes, null, 6); ?>

                                    <?php echo MY_form_datepicker('Fecha inicial', 'fecha1', 3); ?>

                                    <?php echo MY_form_datepicker('Fecha final', 'fecha2', 3); ?>

                                    <?php echo MY_form_dropdown2('Movimiento', 'subtipoMovimiento', $subtipos, null, 6); ?>

                                    <?php echo MY_form_submit(); ?>
                                    
                                    <?php echo form_close(); ?>
                                    
								</div>	
                            </div>
