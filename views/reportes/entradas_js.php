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

    $( "#proveedorID" ).autocomplete({
        
    source: '<?php echo site_url('movimiento/busca_proveedor'); ?>',
    minLength: 2,
    select: function( event, ui ) {
        
        
        $("#proveedorID").val(ui.item.proveedorID);
        return false;
        
        }
    });

</script>