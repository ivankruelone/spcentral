							<div class="row-fluid">
                                <div class="span12">
                                
                                <?php
                                
                                
                                $error = $this->session->flashdata('error');
                                
                                if(strlen($error) > 0)
                                {
                                    
                                
                                ?>
                                
                                <div class="alert alert-error">
										<button type="button" class="close" data-dismiss="alert">
											<i class="icon-remove"></i>
										</button>

										<strong>
											<i class="icon-remove"></i>
											Error!
										</strong>

										<?php echo $error; ?>
										<br />
                                </div>						
                                <?php
                                
                                }
                                
                                ?>
                                
                                
                                    
                                <?php
                                
                                
                                $correcto = $this->session->flashdata('correcto');
                                
                                if(strlen($correcto) > 0)
                                {
                                    
                                
                                ?>
                                
                                <div class="alert alert-success">
										<button type="button" class="close" data-dismiss="alert">
											<i class="icon-remove"></i>
										</button>

										<strong>
											<i class="icon-ok"></i>
											Correcto!
										</strong>

										<?php echo $correcto; ?>
										<br />
                                </div>						
                                <?php
                                
                                }
                                
                                ?>

                                    <?php echo MY_form_open('administracion/change_password_submit'); ?>
                                    
                                    <?php echo MY_form_input('oldP', 'oldP', 'Password Anterior', 'password', 'Password anterior', 3); ?>

                                    <?php echo MY_form_input('password1', 'password1', 'Password Nuevo', 'password', 'Password Nuevo', 3); ?>

                                    <?php echo MY_form_input('password2', 'password2', 'Password Nuevo', 'password', 'Password Nuevo', 3); ?>

                                    <?php echo MY_form_submit(); ?>
                                    
                                    <?php echo form_close(); ?>
                                    
								</div>	
                            </div>
