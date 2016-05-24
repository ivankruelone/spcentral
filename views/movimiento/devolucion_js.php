<script type="text/javascript">
<!--
    
    $("#devuelve").on('change', operacion);
    
    function operacion(event)
    {
        var $devuelve = event.currentTarget.value;
        $devuelve = parseInt($devuelve);

    	var $piezas = $("#piezas").html();
        $piezas = parseInt($piezas);
        
        if($devuelve > 0)
        {
            if($devuelve > $piezas)
            {
                $("#devuelve").val('');
                alert("Valor invalido. Debe ser menor  o igual a: " + $piezas);
            }else{
                
            }
        }else{
            $("#devuelve").val('');
            alert("Valor invalido. Debe ser positivo y mayor a 0.");
        }
    }
    
    
-->
</script>