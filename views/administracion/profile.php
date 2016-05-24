<?php
	$row = $query->row();
?>
							<div>
								<div id="user-profile-1" class="user-profile row-fluid">
									<div class="span3 center">
										<div>
											<span class="profile-picture" id="avatar">
												<img src="<?php echo base_url();?>assets/avatars/<?php echo $this->session->userdata('avatar'); ?>" />
											</span>

											<div class="space-4"></div>

											<div class="width-80 label label-info label-large arrowed-in arrowed-in-right">
												<div class="inline position-relative">
													<a href="#" class="user-title-label dropdown-toggle" data-toggle="dropdown">
														<i class="icon-circle light-green middle"></i>
														&nbsp;
														<span class="white middle bigger-120"><?php echo $this->session->userdata('nombrecompleto'); ?></span>
													</a>

													<ul class="align-left dropdown-menu dropdown-caret dropdown-lighter">
														<li class="nav-header"> Change Status </li>

														<li>
															<a href="#">
																<i class="icon-circle green"></i>
																&nbsp;
																<span class="green">Available</span>
															</a>
														</li>

														<li>
															<a href="#">
																<i class="icon-circle red"></i>
																&nbsp;
																<span class="red">Busy</span>
															</a>
														</li>

														<li>
															<a href="#">
																<i class="icon-circle grey"></i>
																&nbsp;
																<span class="grey">Invisible</span>
															</a>
														</li>
													</ul>
												</div>
											</div>
										</div>


										<div class="hr hr16 dotted"></div>
                                        
                                        <div>
                                        
                                        <button class="green medium" id="upload_button">Da click aqui para seleccionar un avatar desde arhivo.</button>
                                        
                                        </div>
									</div>

									<div class="span9">

										<div class="profile-user-info profile-user-info-striped">
											<div class="profile-info-row">
												<div class="profile-info-name"> Username </div>

												<div class="profile-info-value">
													<span><?php echo $this->session->userdata('clvusuario'); ?></span>
												</div>
											</div>

											<div class="profile-info-row">
												<div class="profile-info-name"> # Sucursal </div>

												<div class="profile-info-value">
													<span><?php echo $this->session->userdata('clvsucursal'); ?></span>
												</div>
											</div>

											<div class="profile-info-row">
												<div class="profile-info-name"> Sucursal </div>

												<div class="profile-info-value">
													<span><?php echo $this->session->userdata('sucursal'); ?></span>
												</div>
											</div>

											<div class="profile-info-row">
												<div class="profile-info-name"> Ultimo inicio </div>

												<div class="profile-info-value">
													<span><?php echo $row->last_login; ?></span>
												</div>
											</div>

											<div class="profile-info-row">
												<div class="profile-info-name"> Puesto </div>

												<div class="profile-info-value">
													<span><?php echo $row->puesto; ?></span>
												</div>
											</div>

											<div class="profile-info-row">
												<div class="profile-info-name"> Cambia Password </div>

												<div class="profile-info-value">
													<span><?php echo anchor('administracion/change_password', 'Click aqui'); ?></span>
												</div>
											</div>

										</div>

									</div>
								</div>
							</div>
