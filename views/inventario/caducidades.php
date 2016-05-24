							<div class="row-fluid">
                                <div class="span12">
                                
                                <?php
                                
                                $data = array(
                                    'name' => 'envio',
                                    'id' => 'envio',
                                    'value' => 'true',
                                    'type' => 'button',
                                    'content' => 'Generar'
                                );
                                
                                ?>
                                
                                    <?php echo MY_form_dropdown2('Caducidades: ', 'caducidad', $caducidades, null, 6);?>
                                    <?php echo form_button($data);?>
                                
                                </div>
                                
                                
                            </div>
                            
                            <div class="row-fluid">
                                <div class="span12" id="inventario">
                                
                                </div>
                            </div>