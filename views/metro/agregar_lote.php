							<div class="row-fluid">
                                <div class="span12">
                                    
                                    <?php echo MY_form_open('metro/agregar_lote_submit'); ?>
                                    
                                    <?php echo MY_form_input('cveArticulo', 'cveArticulo', 'Clave de articulo', 'text', 'Clave de Articulo:', 12, FALSE); ?>
                                    
                                    <?php echo MY_form_input('lote', 'lote', 'lote', 'text', 'Lote:', 4, TRUE); ?>

                                    <?php echo MY_form_datepicker('Fecha de caducidad', 'fechacaducidad', 3, TRUE); ?>
                                    
                                    <?php echo MY_form_submit(); ?>
                                    
                                    <?php echo form_close(); ?>, 
                                    
								</div>	
                            </div>
