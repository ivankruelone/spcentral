<?php
	$row = $query->row();
?>							<div class="row-fluid">
                                <div class="span12">
                                    
                                    <?php echo MY_form_open('catalogosweb/usuario_edita_submit'); ?>
                                    
                                    <?php echo MY_form_input('clvusuario', 'clvusuario', 'Clave de usuario', 'text', 'Clave de usuario', 3, true, $row->clvusuario); ?>

                                    <?php echo MY_form_input('password', 'password', 'Password', 'password', 'Password', 3, true, $row->password); ?>

                                    <?php echo MY_form_input('nombreusuario', 'nombreusuario', 'Nombre de usuario', 'text', 'Nombre de usuario', 6, true, $row->nombreusuario); ?>

                                    <?php echo MY_form_dropdown2('Sucursal', 'clvsucursal', $sucursal, $row->clvsucursal, 12); ?>    

                                    <?php echo MY_form_dropdown2('Puesto', 'clvpuesto', $puesto, $row->clvpuesto, 12); ?>    

                                    <?php echo MY_form_dropdown2('Activo', 'estaactivo', $activo, $row->estaactivo, 12); ?>  
                                    
                                    <?php echo form_hidden('usuario', $row->usuario); ?>  

                                    <?php echo MY_form_submit(); ?>
                                    
                                    <?php echo form_close(); ?>
                                    
								</div>	
                            </div>
