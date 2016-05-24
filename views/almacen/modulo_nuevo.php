							<div class="row-fluid">
                                <div class="span12">
                                    
                                    <?php echo MY_form_open('almacen/modulo_nuevo_submit'); ?>
                                    
                                    <?php echo MY_form_input('niveles', 'niveles', 'Niveles', 'number', 'Niveles', 3, true, 5); ?>

                                    <?php echo MY_form_input('posiciones', 'posiciones', 'Posiciones', 'number', 'Posiciones', 3, true, 2); ?>

                                    <?php echo form_hidden('areaID', $areaID); ?>
                                    
                                    <?php echo form_hidden('pasilloID', $pasilloID); ?>

                                    <?php echo MY_form_submit(); ?>
                                    
                                    <?php echo form_close(); ?>
                                    
								</div>
                                
                            </div>
                            
                            <div class="row-fluid">
                                <div class="span12" id="preview">
                                    
                                </div>
                            </div>
