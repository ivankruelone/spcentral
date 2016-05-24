<script src="<?php echo base_url();?>assets/js/AjaxUpload.2.0.min.js"></script>

<script type="text/javascript">
	var button = $('#upload_button'), interval;
	new AjaxUpload('#upload_button', {
        action: '<?php echo site_url();?>/administracion/upload_avatar',
		onSubmit : function(file , ext){
		if (! (ext && /^(png|jpg|gif)$/.test(ext))){
			alert('Error: Solo se permiten .jpg, .png, .gif');
			return false;
		} else {
			button.text('Subiendo el  archivo. Espere un momento por favor...');
			this.disable();
		  }
		},
		onComplete: function(file, response){
			button.text('Da click aqui para seleccionar un avatar desde arhivo.');
			this.enable();			
			$('#avatar').html(response);
		}	

	});


</script>