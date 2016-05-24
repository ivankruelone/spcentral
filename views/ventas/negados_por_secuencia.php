							<div class="row-fluid">
                                <div class="span12">
                                    
                                    <?php echo MY_form_open('ventas/negados_por_secuencia__reporte_de_negados_por_secuencia'); ?>
                                    
                                    <?php echo MY_form_datepicker('Elige la fecha inicial', 'fecha1', 3); ?>

                                    <?php echo MY_form_datepicker('Elige la fecha final', 'fecha2', 3); ?>

                                    <?php echo MY_form_submit(); ?>
                                    
                                    <?php echo form_close(); ?>
                                    
								</div>	
                            </div>
