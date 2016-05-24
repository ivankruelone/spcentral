<?php
    $arr = $this->util->getMenuByUsuario();
    
?>
				<ul class="nav nav-list">
                
					<li id="navlist-workspace">
                    
                            <?php echo anchor('workspace', '<i class="icon-home"></i><span class="menu-text"> Home </span>'); ?>

					</li>
                    
                    <?php
                    
                    foreach($arr as $a){
                    
                    ?>

					<li id="navlist-<?php echo $a->controlador; ?>">
						<a href="#" class="dropdown-toggle">
							<i class="<?php echo $a->icono; ?>"></i>
							<span class="menu-text"> <?php echo $a->menu; ?> </span>
							<b class="arrow icon-angle-down"></b>
						</a>

						<ul class="submenu">
                        
                            <?php 
                            
                            foreach($a->items as $i){
                                
                            ?>
                        
							<li id="navlist-<?php echo $a->controlador; ?>-<?php echo str_replace(array(' '), array('_'), strtolower($i->submenu)); ?>">
                                <?php echo anchor($i->uri, '<i class="icon-double-angle-right"></i>' . $i->submenu); ?>
							</li>
                            
                            <?php
                            
                            }
                            
                            ?>

						</ul>
					</li>
                    
                    <?php
                    
                    }
                    
                    ?>

   				</ul><!--/.nav-list-->