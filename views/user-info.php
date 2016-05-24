						<li class="light-blue">
							<a data-toggle="dropdown" href="#" class="dropdown-toggle">
								<img class="nav-user-photo" src="<?php echo base_url();?>assets/avatars/<?php echo $this->session->userdata('avatar'); ?>" />
								<span class="user-info">
									<small>Bienvenido,</small>
									<?php echo $this->session->userdata('nombrecompleto'); ?>
								</span>

								<i class="icon-caret-down"></i>
							</a>

							<ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-closer">
								<li>
                                    <?php echo anchor('administracion/profile', '<i class="icon-user"></i> Perfil');?>
								</li>

								<li class="divider"></li>

								<li>
									<?php echo anchor('login/logout', '<i class="icon-off"></i>Salir del sistema'); ?>
								</li>
							</ul>
						</li>