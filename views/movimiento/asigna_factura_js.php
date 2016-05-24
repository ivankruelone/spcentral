<script type="text/javascript">
<!--
	$("#default_form").on('submit', envio);
    
    function envio(e)
    {
        var $referencia = $("#referencia").val();
        if(confirm("Esta seguro que el numero de factura es: " + $referencia + " ?"))
        {
            return true;
        }else{
            e.preventDefault();
            return false;
        }
    }
-->
</script>