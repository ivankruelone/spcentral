							<div class="row-fluid">
                                <div class="span12">
                                    
                                    <?php echo MY_form_open('almacen/pasillo_nuevo_submit'); ?>
                                    
                                    <?php echo MY_form_input('pasillo', 'pasillo', 'Pasillo', 'text', 'Pasillo', 6); ?>
                                    
                                    <?php echo MY_form_dropdown2('Rack', 'rackID', $racks, null, 12); ?>
                                    
                                    <?php echo MY_form_dropdown2('Tipo Pasillo', 'pasilloTipo', $tipos, null, 12); ?>
                                    
                                    <?php echo MY_form_dropdown2('Sentido', 'sentido', $sentidos, null, 12); ?>

                                    <?php echo form_hidden('areaID', $areaID); ?>

                                    <?php echo MY_form_submit(); ?>
                                    
                                    <?php echo form_close(); ?>
                                    
								</div>
                                <div id="rack">
                                
                                </div>	
                            </div>
