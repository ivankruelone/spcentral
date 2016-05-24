<div class="row-fluid">
                                <div class="span12">
                                    
                                    <?php echo MY_form_open('reportes/reporte_consultas_por_periodo__reporte_de_consultas'); ?>
                                    
                                    <?php echo MY_form_datepicker('Elige la fecha inicial', 'fecha1', 3); ?>

                                    <?php echo MY_form_datepicker('Elige la fecha final', 'fecha2', 3); ?>
                                    
                                    <?php echo MY_form_dropdown('Elige al Medico: ', 'medico', $medicos, '', 5, "icon-briefcase"); ?>
                                    
                                    <?php echo MY_form_submit(); ?>
                                    
                                    <?php echo form_close(); ?>
                                    
								</div>	
                            </div>