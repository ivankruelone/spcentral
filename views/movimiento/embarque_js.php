<script type="text/javascript">
<!--
	$( ":input" ).on('change', cambio);
    
    function cambio(event)
    {
        $valor = event.currentTarget.value.toUpperCase();
        $id = event.currentTarget.attributes.id.value;
        $('#' + $id).val($valor);
    }
-->
</script>