<script type="text/javascript">
<!--
    $(document).on('ready', inicio);
    
    var $texto = $('#ubicacion_' + $("#ubicacionOriginal").html()).text();
    var $cantidadMaxima = parseInt($("#cantidadMaxima").val());
    
    function inicio()
    {
        var $ubicacionOriginal = $("#ubicacionOriginal").html();
        $('#ubicacion_' + $ubicacionOriginal).css('background-color', 'lightblue').text($texto + ' -> Ubicacion Original');
    }
    
    
    $("#cantidad").on('change', cambiaCantidad);
    
    function cambiaCantidad(e)
    {
        var valor = parseInt(e.currentTarget.value);
        if(valor <= $cantidadMaxima && valor > 0)
        {
            return true;
        }else if(valor <= 0){
            alert("La cantidad no puede ser igual a 0 o negativa.");
            $("#cantidad").val($cantidadMaxima);
            return false;
        }else if(valor > $cantidadMaxima){
            alert("La cantidad no puede ser mayor a " + $cantidadMaxima + '.');
            $("#cantidad").val($cantidadMaxima);
            return false;
        }else{
            return true;
        }
    }
    
	$("#ubicacion").on('change', getUbicacion);
    
    
    function getUbicacion(e)
    {
        $ubicacion = e.currentTarget.value;
        coloreaUbicacion($ubicacion);
    }
    
    function coloreaUbicacion($ubicacion)
    {
        
        var $ultima_ubicacion = $("#ultima_ubicacion").html();
        var $ubi = $("#ultima_asignada").html();
        
        $('#ubicacion_' + $ultima_ubicacion).css('background-color', '');
        
        inicio();
        
        $('#ubicacion_' + $ubicacion).css('background-color', 'lightcoral');
        $("#ultima_ubicacion").html($ubicacion);
    }
    
    $( "td[id^='ubicacion_']" ).on('dblclick', elige);
    
    
    function elige(e)
    {
        var $ubi = $("#ultima_asignada").html();
        var $id = e.currentTarget.attributes.id.value;
        $id = $id.replace('ubicacion_', '');
        $("#ubicacion").val($id);
        $('#ubicacion_' + $ubi).css('background-color', '');
        $('#ubicacion_' + $id).css('background-color', 'LawnGreen');
        $("#ultima_asignada").html($id);

    }

-->
</script>