<?php
	$row = $query->row();
?>
							<div class="row-fluid">
                                <div class="span12">
                                    
                                    <?php echo MY_form_open('almacen/area_edita_submit'); ?>
                                    
                                    <?php echo MY_form_input('area', 'area', 'Area', 'text', 'Area', 6, true, $row->area); ?>

                                    <?php echo form_hidden('areaID', $row->areaID); ?>
                                    
                                    <?php echo MY_form_submit(); ?>
                                    
                                    <?php echo form_close(); ?>
                                    
								</div>	
                            </div>
