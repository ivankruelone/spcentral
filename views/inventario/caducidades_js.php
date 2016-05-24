<script type="text/javascript">
<!--
	$(document).on('ready', inicio);
    
    function inicio()
    {
        inventario();
    }
    
    $("#envio").on('click', inventario);
    
    
    function inventario()
    {
        var $url = '<?php echo site_url('inventario/inventarioByCaducidad'); ?>';
        var $variables = { caducidad : $('#caducidad').val() };
        var posting = $.post( $url, $variables );
            
             posting.done(function( data ) {
                
                $("#inventario").html(data);
                
             });
    }
    
-->
</script>