<script type="text/javascript">
<!--
	$("#rfc").change(function(){
	   $("#rfc").val($("#rfc").val().toUpperCase());
	});

	$("#razon").change(function(){
	   $("#razon").val($("#razon").val().toUpperCase());
	});
    
    var availableTags = '<?php echo $json; ?>';
    var arr = $.map(JSON.parse(availableTags), function(el) { return el; });

    $( "#rfc" ).autocomplete({
    
source: arr,
minLength: 2,
select: function( event, ui ) {
    
    $("#rfc").val(ui.item.rfc);
    $("#razon").val(ui.item.razon);
    $("#proveedorID").val(ui.item.proveedorID);

    return false;
    
    }
});
-->
</script>