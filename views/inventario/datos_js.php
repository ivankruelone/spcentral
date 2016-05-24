<script type="text/javascript">
<!--
    $('#caducidad').datepicker({
        language: "es",
        calendarWeeks: true,
        autoclose: true,
        todayHighlight: true,
        format: "yyyy-mm-dd"
        });
        
	$("#lote").change(function(){
	   $("#lote").val($("#lote").val().toUpperCase());
	});

	$("#marca").change(function(){
	   $("#marca").val($("#marca").val().toUpperCase());
	});
    
    $("#comercial").change(function(){
	   $("#comercial").val($("#comercial").val().toUpperCase());
	});
    
    
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