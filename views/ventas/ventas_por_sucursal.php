							<div class="row-fluid">
                                <div class="span12">
                                    
                                    <?php echo MY_form_open('ventas/ventas_por_sucursal__reporte_de_ventas_por_sucursal'); ?>
                                    
                                    <?php echo MY_form_datepicker('Elige la fecha inicial', 'fecha1', 3); ?>

                                    <?php echo MY_form_datepicker('Elige la fecha final', 'fecha2', 3); ?>

                                    <?php echo MY_form_submit(); ?>
                                    
                                    <?php echo form_close(); ?>
                                    
								</div>	
                            </div>
