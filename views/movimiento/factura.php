							<div class="row-fluid">
                                <div class="span12">
                                    
                                    <?php echo MY_form_open('movimiento/factura_submit', 'forma'); ?>
                                    
                                    <?php 
                                    
                                        echo MY_form_input('movimientoID', 'movimientoID', 'ID Movimiento', 'number', 'ID Movimiento', 1, true, $movimientoID, true);
                                    
                                        echo MY_form_dropdown2('Cliente', 'rfc', $clientes, null, 12); 
                                    
                                        echo MY_form_dropdown2('Contrato', 'contratoID', array('0' => 'Elige una opcion'), null, 12); 

                                    ?>

                                    
                                    <?php echo form_hidden('movimientoID', $movimientoID); ?>

                                    <?php echo form_hidden('tipoMovimiento', $tipoMovimiento); ?>

                                    <?php echo form_hidden('subtipoMovimiento', $subtipoMovimiento); ?>

                                    <?php echo MY_form_submit(); ?>
                                    
                                    <?php echo form_close(); ?>
                                    
								</div>	
                            </div>
                            
                            <div class="row-fluid">
                            
                                <div class="span12" id="vistaPrevia"></div>
                            
                            </div>
