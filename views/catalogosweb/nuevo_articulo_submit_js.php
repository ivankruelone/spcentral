<script type="text/javascript">
<!--
	$(".agrega").on('click', agrega);
    
	$(".agrega2").on('click', agrega2);

    function agrega(e)
    {
        e.preventDefault();
        var $clave = $("#clave_" + e.currentTarget.attributes.id.value).html();
        
        var $url = e.currentTarget.attributes.href.value;
        var $variables = { clave : $clave };

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

    function agrega2(e)
    {
        e.preventDefault();
        var $clave = $("#clave_" + e.currentTarget.attributes.id.value).html();
        var $origen = e.currentTarget.attributes.origen.value;
        var $url = e.currentTarget.attributes.href.value;
        var $variables = { ean : $clave, origen: $origen };

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