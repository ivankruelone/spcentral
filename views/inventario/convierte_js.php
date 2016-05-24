<script type="text/javascript">
<!--
	$("#convertir").on('change', operacion);
    
    function operacion(event)
    {
        var $convierte = event.currentTarget.value;
        $convierte = parseInt($convierte);

    	var $piezas = $("#cantidad").html();
        $piezas = parseInt($piezas);
        
        if($convierte > 0)
        {
            if($convierte > $piezas)
            {
                $("#convertir").val('');
                alert("Valor invalido. Debe ser menor  o igual a: " + $piezas);
            }else{
                
            }
        }else{
            $("#convertir").val('');
            alert("Valor invalido. Debe ser positivo y mayor a 0.");
        }
    }
-->
</script>