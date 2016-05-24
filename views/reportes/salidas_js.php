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

    $( "#clvsucursal" ).autocomplete({
        
    source: '<?php echo site_url('movimiento/busca_sucursal'); ?>',
    minLength: 2,
    select: function( event, ui ) {
        
        
        $("#clvsucursal").val(ui.item.clvsucursal);
        return false;
        
        }
    });

</script>