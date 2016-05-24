<script type="text/javascript">
<!--
	$(".agrega").on('click', agrega);
    
    function agrega(e)
    {
        e.preventDefault();
        var $clave = $("#clave_" + e.currentTarget.attributes.id.value).html();
        var $url = e.currentTarget.attributes.href.value;
        var $variables = { rfc : $clave };

        var posting = $.post( $url, $variables );
        
         posting.done(function( data ) {
            
            if(data == 0)
            {
                $("#resultado").html('No se pudo agregar el cliente');
            }else{
                $("#resultado").html('Cliente agregado correctamente');
            }
            

            
         });
    }
-->
</script>