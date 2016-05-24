<script type="text/javascript">
<!--
	$( "input[name^='opcion_']" ).on('click', doClick);
    
    function doClick(event)
    {
        console.log(event);
        var $usuario = event.currentTarget.value;
        var $submenu = event.currentTarget.attributes.id.value;
        guarda($usuario, $submenu);
    }


    function guarda($usuario, $submenu)
    {
        var $url = '<?php echo site_url('administracion/savePermiso'); ?>';;
        var $variables = { usuario : $usuario, submenu : $submenu };

        var posting = $.post( $url, $variables );
        
         posting.done(function( data ) {
            
            
         });
    }
-->
</script>