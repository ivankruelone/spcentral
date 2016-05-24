<script type="text/javascript">
<!--
$(document).on('ready', inicio);

function inicio(){
    
    detalle();


}
    $('#articulo').focus();
    
    $( "#articulo" ).autocomplete({
        
    source: '<?php echo site_url('movimiento/busca_articulo'); ?>',
    minLength: 2,
    select: function( event, ui ) {
        
        
        $("#articulo").val(ui.item.cvearticulo);
        $('#piezas').focus();
        return false;
        
        }
    });
    	
    $( "#articulo2" ).autocomplete({
        
    source: '<?php echo site_url('movimiento/busca_articulo'); ?>',
    minLength: 2,
    select: function( event, ui ) {
        
        
        $("#articulo2").val(ui.item.cvearticulo);
        $('#piezas').focus();
        return false;
        
        }
    });

    $('#caducidad').datepicker({
        language: "es",
        calendarWeeks: true,
        autoclose: true,
        todayHighlight: true,
        format: "yyyy-mm-dd"
        });
    
    $('#captura_form').on('submit', envio);
    
    $('#captura_form2').on('submit', envio2);
    
    function envio(event)
    {
        event.preventDefault();
        
        $articulo = $('#articulo').val();
        $piezas = $('#piezas').val();
        $lote = $('#lote').val().toUpperCase();
        $caducidad = $('#caducidad').val();
        $ean = $('#ean').val();
        $marca = $('#marca').val().toUpperCase();
        $costo = $('#costo').val();
        $movimientoID = $('#movimientoID').html();
        $ubicacion = $('#ubicacion').val();
        
        var $url = '<?php echo site_url('movimiento/captura_submit'); ?>';
        var $variables = { articulo: $articulo, piezas: $piezas, lote: $lote, caducidad: $caducidad, ean: $ean, marca: $marca, costo: $costo, movimientoID: $movimientoID, ubicacion: $ubicacion };
        var posting = $.post( $url, $variables );
            
             posting.done(function( data ) {
                
                detalle();
                
                
                $piezas = $('#piezas').val('');
                $lote = $('#lote').val('');
                $caducidad = $('#caducidad').val('');
                $ean = $('#ean').val('');
                $marca = $('#marca').val('');
                $costo = $('#costo').val('');
                $('#ubicacion').html('');
                $('#susa').html('');
                $('#descripcion').html('');
                $('#pres').html('');
                $('#cans').html('');
                $('#codigo').html('');
                $('#costoe').html('');
                $articulo = $('#articulo').val('').focus();
                
                
             });
        
    }

    function envio2(event)
    {
        event.preventDefault();
        
        $cvearticulo = $('#articulo2').val();
        $piezas = $('#piezas').val();
        $movimientoID = $('#movimientoID').html();
        
        var $url = '<?php echo site_url('movimiento/captura_submit3'); ?>';
        var $variables = { cvearticulo: $cvearticulo, piezas: $piezas, movimientoID: $movimientoID };
        var posting = $.post( $url, $variables );
            
             posting.done(function( data ) {
                
                detalle();
                
                
                $('#piezas').val('');
                $('#lote2').html('');
                $('#articulo2').val('').focus();
                
             });
        
    }

    function detalle()
    {
        
        $movimientoID = $('#movimientoID').html();
        
        var $url = '<?php echo site_url('movimiento/detallePrepedido'); ?>';
        var $variables = { movimientoID: $movimientoID };
        var posting = $.post( $url, $variables );
            
             posting.done(function( data ) {
                
                $('#detalle').html(data);
                
             });
        
    }
    
    $('#articulo').on('blur', articuloValida);
    
    $('#articulo2').on('change', articuloValida2);

    //$('#lote2').on('focus', cargaLote);
    
    function cargaLote()
    {
        $articulo = $('#articulo2').val();
        var $url = '<?php echo site_url('movimiento/cargaLotes'); ?>';
        var $variables = { articulo: $articulo };
        var posting = $.post( $url, $variables );
            
             posting.done(function( data ) {
                
                $('#lote2').html(data);
                
             });

    }
    
    function articuloValida()
    {
        
        $articulo = $('#articulo').val();
        
        if($articulo.length > 0)
        {
            $orden = parseInt($('#orden').html());
            
            var $url = '<?php echo site_url('movimiento/articuloValida'); ?>';
            var $variables = { articulo: $articulo, orden: $orden };
            var posting = $.post( $url, $variables );
                
                 posting.done(function( data ) {
                    
                    $var1 = data.split('|');
                    
                    if($orden > 0)
                    {
                        if(parseInt($var1[5]) > 0)
                        {
                            $('#susa').html($var1[2]);
                            $('#descripcion').html($var1[3]);
                            $('#pres').html($var1[4]);
                            
                            $('#cans').html($var1[5]);
                            $('#codigo').html($var1[6]);
                            $('#costoe').html($var1[7]);
                            
                            getUbicaciones($articulo);
                            
                            return true;
                        }else{
                            
                            $('#susa').html('');
                            $('#descripcion').html('');
                            $('#pres').html('');
                            
                            $('#cans').html('');
                            $('#codigo').html('');
                            $('#costoe').html('');
                            $("#ubicacion").html('');
                            
                            if(parseInt($var1[5]) == -1)
                            {
                                alert('Esta clave no esta asignada en esta orden de compra.');
                            }else
                            {
                                alert('Ya se recibio la cantidad estipulada');
                            }
                            
                            $('#articulo').val('').focus();
    
                            return false;
                        }
                    }else{
                            $('#susa').html($var1[2]);
                            $('#descripcion').html($var1[3]);
                            $('#pres').html($var1[4]);
                            
                            $('#cans').html($var1[5]);
                            $('#codigo').html($var1[6]);
                            $('#costoe').html($var1[7]);
                            
            
                            getUbicaciones($articulo);
                            
                            return true;
                    }
                    
    
                    
                 });
        }
        
    }
    
    function getUbicaciones($articulo)
    {
        var $url = '<?php echo site_url('movimiento/getUbicaciones'); ?>';
        var $variables = { cvearticulo: $articulo };
        var posting = $.post( $url, $variables );
        
             posting.done(function( data ) {
                
                $("#ubicacion").html(data);
                
             });
    }
    
    function articuloValida2()
    {
        
        $articulo = $('#articulo2').val();
        
        var $url = '<?php echo site_url('movimiento/articuloValida'); ?>';
        var $variables = { articulo: $articulo };
        var posting = $.post( $url, $variables );
            
             posting.done(function( data ) {
                
                $var1 = data.split('|');
                
                $('#susa').html($var1[2]);
                $('#descripcion').html($var1[3]);
                $('#pres').html($var1[4]);
                cargaLote();
                
             });
        
    }

    $('#cierre').on('click', cierre);
    
    function cierre(event){
        if(confirm("Seguro que deseas cerrar este Movimiento ??")){
            
            return true;
            
        }else{
            event.preventDefault();
            return false;
        }
    }
    
    var availableTags = '<?php echo $json; ?>';
    var arr = $.map(JSON.parse(availableTags), function(el) { return el; });

    $( "#marca" ).autocomplete({
    
source: arr,
minLength: 2,
select: function( event, ui ) {
    
    $("#marca").val(ui.item.value);

    return false;
    
    }
});

-->
</script>