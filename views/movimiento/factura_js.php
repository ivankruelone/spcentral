<script type="text/javascript">
<!--
	$(document).on('ready', inicio);
    
    function inicio()
    {
        getContrato();
    }
    
    $("#rfc").on('change', getContrato);
    $("#contratoID").on('change', getVistaPrevia);
    
    function getContrato()
    {
        var $rfc = $("#rfc").val();
        var $url = '<?php echo site_url('movimiento/getContratoByCliente'); ?>';;
        var $variables = { rfc : $rfc };

        var posting = $.post( $url, $variables );
        
         posting.done(function( data ) {
            
            $("#contratoID").html(data);
            getVistaPrevia();

            
         });
    }

    function getVistaPrevia()
    {
        var $contratoID = $("#contratoID").val();
        var $movimientoID = $("#movimientoID").val();
        var $url = '<?php echo site_url('movimiento/getFacturaVistaPrevia'); ?>';;
        var $variables = { contratoID: $contratoID, movimientoID: $movimientoID };

        var posting = $.post( $url, $variables );
        
         posting.done(function( data ) {
            
            $("#vistaPrevia").html(data);

            
         });
    }
    
    $("#forma").on('submit', envio);
    
    function envio(event)
    {
        if(confirm("Seguro que deseas facturar ??"))
        {
            var $movimientoID = $("#movimientoID").val();
            var $valido = $("#valido").html();
            valido = parseInt($valido);
            
            if($valido == 1)
            {
                return true;
            }else{
                alert("Hay precios en cero, debes capturar algunos.")
                event.preventDefault();
                return false;
            }
        }else{
            event.preventDefault();
        }
    }
    
-->
</script>