<script type="text/javascript">
<!--
	$( "input[name^='precio_']" ).on('change', cambio);
    
    function cambio(event)
    {
        var $contratoPrecioID = event.currentTarget.attributes.id.value;
        var $precioContrato = event.currentTarget.value;
        guarda($contratoPrecioID, $precioContrato);
    }
    
    function guarda($contratoPrecioID, $precioContrato)
    {
        var $url = '<?php echo site_url('catalogosweb/saveContratoPrecio'); ?>';;
        var $variables = { contratoPrecioID : $contratoPrecioID, precioContrato : $precioContrato };

        var posting = $.post( $url, $variables );
        
         posting.done(function( data ) {
            
            if(data == 0)
            {
                $("#resultado").html('No se pudo agregar el producto');
            }else{
                $("#resultado").html('Producto agregado correctamente');
            }
            

            
         });
    }
-->
</script>