<?php
	$row = $query->row();
?>
							<div class="row-fluid">
                                <div class="span12">
                                    
                                    <?php echo MY_form_open('almacen/pasillo_edita_submit'); ?>
                                    
                                    <?php echo MY_form_input('pasillo', 'pasillo', 'Pasillo', 'text', 'Pasillo', 6, true, $row->pasillo); ?>
                                    
                                    <?php echo MY_form_dropdown2('Rack', 'rackID', $racks, $row->rackID, 12); ?>
                                    
                                    <?php echo MY_form_dropdown2('Tipo Pasillo', 'pasilloTipo', $tipos, $row->pasilloTipo, 12); ?>
                                    
                                    <?php echo MY_form_dropdown2('Sentido', 'sentido', $sentidos, $row->sentido, 12); ?>

                                    <?php echo form_hidden('areaID', $areaID); ?>

                                    <?php echo form_hidden('pasilloID', $row->pasilloID); ?>

                                    <?php echo MY_form_submit(); ?>
                                    
                                    <?php echo form_close(); ?>
                                    
								</div>
                                <div id="rack">
                                
                                </div>	
                            </div>
