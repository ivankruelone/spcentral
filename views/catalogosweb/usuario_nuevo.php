							<div class="row-fluid">
                                <div class="span12">
                                    
                                    <?php echo MY_form_open('catalogosweb/usuario_nuevo_submit'); ?>
                                    
                                    <?php echo MY_form_input('clvusuario', 'clvusuario', 'Clave de usuario', 'text', 'Clave de usuario', 3); ?>

                                    <?php echo MY_form_input('password', 'password', 'Password', 'password', 'Password', 3); ?>

                                    <?php echo MY_form_input('nombreusuario', 'nombreusuario', 'Nombre de usuario', 'text', 'Nombre de usuario', 6); ?>

                                    <?php echo MY_form_dropdown2('Sucursal', 'clvsucursal', $sucursal, null, 12); ?>    

                                    <?php echo MY_form_dropdown2('Puesto', 'clvpuesto', $puesto, null, 12); ?>    

                                    <?php echo MY_form_dropdown2('Activo', 'estaactivo', $activo, 1, 12); ?>    

                                    <?php echo MY_form_submit(); ?>
                                    
                                    <?php echo form_close(); ?>
                                    
								</div>	
                            </div>
