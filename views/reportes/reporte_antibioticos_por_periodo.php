<div class="row-fluid">
                                <div class="span12">
                                    
                                    <?php echo MY_form_open('reportes/reporte_antibioticos_por_periodo__reporte_de_antibioticos'); ?>
                                    
                                    <?php echo MY_form_datepicker('Elige la fecha inicial', 'fecha1', 3); ?>

                                    <?php echo MY_form_datepicker('Elige la fecha final', 'fecha2', 3); ?>

                                    <?php echo MY_form_submit(); ?>
                                    
                                    <?php echo form_close(); ?>
                                    
								</div>	
                            </div>