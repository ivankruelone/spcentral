<script type="text/javascript">
<!--
$( "#cveArticulo" ).focus();

$('#fechacaducidad').datepicker({
    language: "es",
    calendarWeeks: true,
    autoclose: true,
    todayHighlight: true,
    format: "yyyy-mm-dd"
    });

$( "#cveArticulo" ).autocomplete({
    
source: '<?php echo site_url('captura/busca_cveArticulo'); ?>',
minLength: 2,
select: function( event, ui ) {
    
    $("#cveArticulo").val(ui.item.cveArticulo);
    return false;
    
    }
});	
-->
</script>