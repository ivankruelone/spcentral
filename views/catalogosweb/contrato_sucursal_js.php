<script type="text/javascript">
<!--
    var $rfc = $("#rfc").html();
    
    $(document).on('ready', inicio);
    
    function inicio()
    {
        showSucursales();
    }
    
	$( "#forma1" ).on('submit', envio);
    
    function envio(event){
        
        event.preventDefault();
        var $url = event.currentTarget.attributes.action.value;
        var $clvsucursal = $("#clvsucursal").val(); 
        guardaSucursal1($url, $clvsucursal);
    }

    function guardaSucursal1($url, $clvsucursal)
    {
        var $variables = { rfc : $rfc, clvsucursal : $clvsucursal };

        var posting = $.post( $url, $variables );
        
         posting.done(function( data ) {
            
            showSucursales();
            $("#clvsucursal").val('').focus();
            
         });
    }

	$( "#forma2" ).on('submit', envio2);
    
    function envio2(event){
        
        event.preventDefault();
        var $url = event.currentTarget.attributes.action.value;
        var $clvsucursal1 = $("#clvsucursal1").val(); 
        var $clvsucursal2 = $("#clvsucursal2").val(); 
        guardaSucursal2($url, $clvsucursal1, $clvsucursal2);
    }

    function guardaSucursal2($url, $clvsucursal1, $clvsucursal2)
    {
        var $variables = { rfc : $rfc, clvsucursal1 : $clvsucursal1, clvsucursal2 : $clvsucursal2 };

        var posting = $.post( $url, $variables );
        
         posting.done(function( data ) {
            
            showSucursales();
            $("#clvsucursal2").val('');
            $("#clvsucursal1").val('').focus();
            
         });
    }

    function showSucursales()
    {
        var $url = '<?php echo site_url('catalogosweb/showSucursalesCliente'); ?>';;
        var $variables = { rfc : $rfc };

        var posting = $.post( $url, $variables );
        
         posting.done(function( data ) {
            
            $("#sucursales").html(data);

            
         });
    }

-->
</script>