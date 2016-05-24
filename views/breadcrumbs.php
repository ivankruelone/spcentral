<?php
	$controller = $this->uri->segment(1, null);
    $method = $this->uri->segment(2, null);
    
    $check_submethod = explode("__", $method);
    $count = count($check_submethod);
    
    if ( $count > 1 )
    {
        $method = $check_submethod[0];
        $submethod = $check_submethod[1];
    }
    
?>
                
				<div class="breadcrumbs" id="breadcrumbs">
					<script type="text/javascript">
						try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
					</script>

					<ul class="breadcrumb">
						<li>
							<i class="icon-home home-icon"></i>
                            
							<?php echo anchor('workspace', 'Home'); ?>

							<span class="divider">
								<i class="icon-angle-right arrow-icon"></i>
							</span>
						</li>

						<li><?php echo anchor($controller, ucfirst($controller)); ?>
                        
                            <?php if($method != null){?>
                            
							<span class="divider">
								<i class="icon-angle-right arrow-icon"></i>
							</span>
                            
                            <?php } ?>
                        
                        </li>
                        
                        <?php if($method != null){?>
                        
						<li class="active"><?php echo anchor($controller."/".$method, ucfirst(str_replace('_', ' ', $method))); ?>
                        
                            <?php if(isset($submethod) && $submethod != null){?>
                            
							<span class="divider">
								<i class="icon-angle-right arrow-icon"></i>
							</span>
                         
                            <?php } ?>
                        </li>
                        
                        <?php if(isset($submethod) && $submethod != null){?>
                        
                        <li class="active"><?php echo ucfirst(str_replace('_', ' ', $submethod)); ?></li>
                        
                        <?php } ?>
                        
                        <?php } ?>
					</ul><!--.breadcrumb-->

					</div><!--#nav-search-->
               