<script type="text/javascript">
<!--
	$(document).on('ready', inicio);
    
    function inicio()
    {
        actualizaTablaProductos();
        $('#cveArticulo').focus();
    }
    
    function actualizaTablaProductos()
    {
        var $url = '<?php echo site_url('captura/actualiza_tabla_productos_rapida'); ?>';
        var $variables = {};
        var posting = $.post( $url, $variables );
            
             posting.done(function( data ) {
                
                $('#productos').html(data);
                
             });
    }
    
    $("#detalle_captura").on('submit', bloquea);
    
    function bloquea(event)
    {
        event.preventDefault();
    }
    
    $("#cveArticulo").on('change', escaner);
    
    function escaner(event)
    {
        var $ean = event.currentTarget.value;
        getArticulo($ean);
        
        $("#cveArticulo") .val('').focus();
    }
    
    function getArticulo($ean)
    {
        var $url = '<?php echo site_url('captura/buscaArticuloScaner'); ?>';
        var $variables = { ean: $ean };
        var posting = $.post( $url, $variables );
            
             posting.done(function( data ) {
                
                $res = data.split('|');
                
                if(data == '0')
                {
                    alert('No se encontro el producto, cargalo al inventario');
                }else{
                    actualizaTablaProductos();
                }
                
             });
    }
    
    $( ":button:submit" ).on('click', guarda);

    
    function guarda()
    {
        if(confirm("Seguro que deseas guardar esta receta ??"))
        {
            guadaBD();
            return true;
        }else
        {
            $("#cveArticulo") .val('').focus();
            return false;
        }
    }


    function guadaBD()
    {
        var $folioReceta = $( "input[name='folioReceta']" ).val();
        var $url = '<?php echo site_url('captura/guardaRapida'); ?>';
        var $variables = { folioReceta: $folioReceta };
        var posting = $.post( $url, $variables );
            
             posting.done(function( data ) {
                
                if(data == 1)
                {
                    window.location = "<?php echo site_url('captura/rapida');?>"
                }else{
                    alert("Algo fallo");
                }
                
             });
    }

-->
</script>