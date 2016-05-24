<?php
	$controller = $this->uri->segment(1, null);
    $method = $this->uri->segment(2, "default");
    $tittle = str_replace('_', ' ', $method);
    $nivel = $this->session->userdata('nivel');
    $usuario = $this->session->userdata('usuario');
    
    $check_submethod = explode("__", $method);
    $count = count($check_submethod);
    
    if ( $count > 1 )
    {
        $tittle = str_replace('_', ' ', $check_submethod[1]);;
    }
    
    
    $sql_caducidad = "SELECT * FROM inventario i where datediff(caducidad, now()) < 0 and cantidad > 0;";
    $query_caducidad = $this->db->query($sql_caducidad);
    $caducidad = $query_caducidad->num_rows();
    
?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8" />
		<title><?php echo APLICACION . " - " . OFFICE; ?></title>

		<meta name="description" content="Minimal empty page" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />

		<!--basic styles-->

		<link href="<?php echo base_url();?>assets/css/uncompressed/bootstrap.css" rel="stylesheet" />
		<link href="<?php echo base_url();?>assets/css/bootstrap-responsive.min.css" rel="stylesheet" />
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/font-awesome.min.css" />

		<!--[if IE 7]>
		  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/font-awesome-ie7.min.css" />
		<![endif]-->

		<!--page specific plugin styles-->
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui-1.10.3.full.min.css" />
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/datepicker.css" />
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/daterangepicker.css" />
		<!--fonts-->

		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/ace-fonts.css" />

		<!--ace styles-->

		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/uncompressed/ace.css" />
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/ace-responsive.min.css" />
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/ace-skins.min.css" />
        
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.gritter.css" />

		<!--[if lte IE 8]>
		  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/ace-ie.min.css" />
		<![endif]-->

		<!--inline styles related to this page-->
        <script src="<?php echo base_url();?>assets/js/ace-extra.min.js"></script>
	</head>

	<body>
    
        <?php $this->load->view('navbar'); ?>


		<div class="main-container container-fluid">
			<a class="menu-toggler" id="menu-toggler" href="#">
				<span class="menu-text"></span>
			</a>

			<div class="sidebar" id="sidebar">
				<script type="text/javascript">
					try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
				</script>
            
                <?php //$this->load->view('shortcuts'); ?>
                
                <?php
                
                $this->load->view('navlist'); 
                
                ?>
                
                <div style="text-align: center;">
                    <img src="<?php echo base_url();?>assets/img/Simple_TPV_01_128x128x32.png" width="128" height="128" />
                </div>

				<div class="sidebar-collapse" id="sidebar-collapse">
					<i class="icon-double-angle-left" data-icon1="icon-double-angle-left" data-icon2="icon-double-angle-right"></i>
				</div>

				<script type="text/javascript">
					try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
				</script>
			</div>

			<div class="main-content">
            
                <?php //$this->load->view('breadcrumbs'); ?>
                
            
				<div class="page-content ">

					<div class="page-header position-relative">
						<h1>
							<?php echo ucfirst($tittle); ?>
                            
                            <?php if ( isset($subtitulo) && strlen($subtitulo) > 0 ){?>
                            
							<small>
								<i class="icon-double-angle-right"></i>
								<?php echo utf8_encode($subtitulo); ?>
							</small>
                            
                            <?php }?>
                            
						</h1>
					</div><!--/.page-header-->

					<div class="row-fluid">
                    
                        <div class="span12">
						
                        <?php $this->load->view($controller . "/" .$method); ?>
                        
                        </div>
                        
					</div><!--/.row-fluid-->
				</div><!--/.page-content-->

                <?php $this->load->view('settings'); ?>
                
			</div><!--/.main-content-->
		</div><!--/.main-container-->


		<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-small btn-inverse">
			<i class="icon-double-angle-up icon-only bigger-110"></i>
		</a>
		<!--basic scripts-->

		<!--[if !IE]>-->

		<script type="text/javascript">
			window.jQuery || document.write("<script src='<?php echo base_url();?>assets/js/jquery-2.0.3.min.js'>"+"<"+"/script>");
		</script>

		<!--<![endif]-->

		<!--[if IE]>
<script type="text/javascript">
 window.jQuery || document.write("<script src='<?php echo base_url();?>assets/js/jquery-1.10.2.min.js'>"+"<"+"/script>");
</script>
<![endif]-->

		<script type="text/javascript">
			if("ontouchend" in document) document.write("<script src='<?php echo base_url();?>assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>

		<!--page specific plugin scripts-->

		<script src="<?php echo base_url();?>assets/js/jquery.dataTables.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/jquery.dataTables.bootstrap.js"></script>

		<script src="<?php echo base_url();?>assets/js/jquery-ui-1.10.3.full.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/jquery.ui.touch-punch.min.js"></script>.

		<script src="<?php echo base_url();?>assets/js/chosen.jquery.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/fuelux/fuelux.spinner.min.js"></script>
        <script src="<?php echo base_url();?>assets/js/jquery.gritter.min.js"></script>

		<script src="<?php echo base_url();?>assets/js/date-time/bootstrap-datepicker.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/date-time/bootstrap-timepicker.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/date-time/moment.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/date-time/daterangepicker.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/date-time/locales/bootstrap-datepicker.es.js"></script>

		<script src="<?php echo base_url();?>assets/js/bootstrap-colorpicker.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/jquery.knob.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/jquery.autosize-min.js"></script>
		<script src="<?php echo base_url();?>assets/js/jquery.inputlimiter.1.3.1.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/jquery.maskedinput.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/bootstrap-tag.min.js"></script>
		<!--ace scripts-->

		<script src="<?php echo base_url();?>assets/js/ace-elements.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/ace.min.js"></script>

		<!--inline scripts related to this page-->
        <script>
        
        var $controller = '<?php echo $this->uri->segment(1, null); ?>';
        var $method = '<?php if ( $count > 1 ) { echo $check_submethod[0]; }else{ echo $this->uri->segment(2, "default"); } ?>';
        
        $( "#navlist-" + $controller ).addClass( "active" );
        $( "#navlist-" + $controller + "-" + $method ).addClass( "active" );
        
        <?php if($caducidad > 0){ ?>
        
        $.gritter.add({
            title: 'Tienes productos Caducados',
            text: 'Ver reporte aqui: <?php echo anchor('inventario/caducidades', 'Reporte de caducidades'); ?>',
            class_name: 'gritter-error gritter-left',
            time: 25000
		});
        
        <?php } ?>
        
        </script>
        
        
        <?php 
            if(isset($js)){
                
                $this->load->view($js);
                
            }
        ?>
        
	</body>
</html>
