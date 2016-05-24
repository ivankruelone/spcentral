<script type="text/javascript">
<!--
    $('#fecha1').datepicker({
        language: "es",
        calendarWeeks: true,
        autoclose: true,
        todayHighlight: true,
        format: "yyyy-mm-dd"
        });

    $('#fecha2').datepicker({
        language: "es",
        calendarWeeks: true,
        autoclose: true,
        todayHighlight: true,
        format: "yyyy-mm-dd"
        });

    $( "#articulo" ).autocomplete({
        
    source: '<?php echo site_url('movimiento/busca_articulo'); ?>',
    minLength: 2,
    select: function( event, ui ) {
        
        
        $("#articulo").val(ui.item.cvearticulo);
        $('#lote').focus();
        return false;
        
        }
    });
	
    $('#articulo').on('change', cargaLote);
    
    function cargaLote()
    {
        $articulo = $('#articulo').val();
        var $url = '<?php echo site_url('movimiento/cargaLotesOpcion2'); ?>';
        var $variables = { articulo: $articulo };
        var posting = $.post( $url, $variables );
            
             posting.done(function( data ) {
                
                $('#lote').html(data);
                
             });

    }
-->
</script>