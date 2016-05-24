<script>

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

    $( "#cvearticulo" ).autocomplete({
        
    source: '<?php echo site_url('movimiento/busca_articulo'); ?>',
    minLength: 2,
    select: function( event, ui ) {
        
        
        $("#cvearticulo").val(ui.item.cvearticulo);
        $('#lote').focus();
        return false;
        
        }
    });

</script>