<?php
	if($query->num_rows() > 0)
    {
        $row = $query->row();
        $domicilio = $row->domicilio;
    }else{
        $domicilio = null;
    }
?>							<div class="row-fluid">
                                <div class="span12">
                                    
                                    <?php echo MY_form_open('catalogosweb/domicilio_submit'); ?>
                                    
                                    <?php echo MY_form_input('domicilio', 'domicilio', 'Domicilio', 'text', 'Domicilio', 12, true, $domicilio); ?>
                                    
                                    <?php echo form_hidden('idDomicilio', 1); ?>

                                    <?php echo MY_form_submit(); ?>
                                    
                                    <?php echo form_close(); ?>
                                    
								</div>	
                            </div>
