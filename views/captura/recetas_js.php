<script>

$('#fechaSur').focus();

$(document).on('ready', inicio);

function inicio()
{
    
    $tipo = $("#tipo").html();
    if($tipo == 'captura')
    {
        tiporeq();
    }else if($tipo == 'edita')
    {
        var reqinicial = '<?php if(isset($receta->tiporequerimiento)){ echo $receta->tiporequerimiento; } ?>';
        reqinicial = reqinicial.trim();
        
        if(reqinicial == '2')
        {
            tiporeq();
        }
        
    }
    
    if($tipo == 'ver')
    {
        actualizaTablaProductosVer();
        
    }else{
        actualizaTablaProductos();
        
    }
    
    
}

$('#noexistelote').on('change', cambiaNoExisteLote);

function cambiaNoExisteLote(data)
{
    
    var $noexistelote = null;
    if($('#noexistelote').is(':checked'))
    {
        $noexistelote = true;
        $("#agregar_lote").show();
    }else{
        $noexistelote = false;
        $("#agregar_lote").hide();
    }
    
}


$('#fechaSur').datepicker({
    language: "es",
    calendarWeeks: true,
    autoclose: true,
    todayHighlight: true,
    format: "yyyy-mm-dd"
    });


$('#folioReceta').on('change', checkFolio);

function checkFolio(data){
    
    var $url = '<?php echo site_url('captura/verifica_folio'); ?>';
    var $variables = { folioReceta : data.currentTarget.value };
    var posting = $.post( $url, $variables );
        
         posting.done(function( data ) {
            
            $res = data.split('|');
            
            if ( $res[0] > 0)
            {
                alert('Ya existe una receta capturada con este folio: ' + $res[1] + ' y esta activa en la sucursal: ' + $res[2] + ' - ' + $res[3] + ', en la fecha: ' + $res[4] + '.');
                $('#folioReceta').val('').focus();
            }else{
                
            }
            
         });

}

$(function() {
  var regexDateValidator = function (fecha) {
   return (fecha).match(/([0-9]{4})\-([0-9]{2})\-([0-9]{2})/);
   }
     
    $("#fechacad").blur(function(event){
         accept = regexDateValidator($(this).val());
         
         if (!accept)
         {
            alert('Fecha invalida.');
            $("#fechacad").val('');
            $('#lote').focus();
         }
         else
         {
            var $fechacap = $('#fechaSur').val();
            var $fechacad = event.currentTarget.value;
            var $url = '<?php echo site_url('captura/valida_fecha'); ?>';
            var $variables = { fechacap : $fechacap, fechacad : $fechacad };
            var posting = $.post( $url, $variables );
            
            posting.done(function(data)
            {

                if (data == 0)
                {
                    alert('Fecha invalida, o fuera de rango');
                    $("#fechacad").val('').focus();
                }
            });
            
         } 
    });
    });
    
$('#edad').on('change', checkEdad);

function checkEdad(data)
{
    var $edad = data.currentTarget.value;
    if ( $edad > 120)
    {
        alert('Verifica edad.');
        $('#edad').val('');
        $('#sexo').focus();
    }    
}


$('#fechaSur').on('change', checkFecha);

function checkFecha(event)
{
    var $fecha = event.currentTarget.value;
    var $url = '<?php echo site_url('captura/verifica_fecha_rango'); ?>';
    var $variables = { fecha : $fecha };
    var posting = $.post( $url, $variables );
        
         posting.done(function( data ) {
            if ( data == 0)
            {
                alert('Fecha invalida, fuera de rango de captura.');
                $('#' + event.currentTarget.attributes.id.value).val('').focus();
            }else{
                
            }
            
         });
}

$('#tipoReq').on('change', tiporeq);
function tiporeq(data){
    var $tiporeq = $('#tipoReq').val()
    if ($tiporeq == 2)
    {
       $("#expediente").attr('disabled', 'disabled');
       $("#nombre").attr('disabled', 'disabled');
       $("#mat").attr('disabled', 'disabled');
       $("#pat").attr('disabled', 'disabled');
       $("#sexo").attr('disabled', 'disabled');
       $("#edad").attr('disabled', 'disabled');
       $("#expediente").val('0');
       $("#sexo").val('0');
       $("#edad").val('0');
       $("#nombre").val('COLECTIVO');
       $("#mat").val('COLECTIVO');
       $("#pat").val('COLECTIVO');
    }
    else
    {   
       $("#expediente").val('');
       $("#nombre").val('');
       $("#mat").val('');
       $("#pat").val('');
       $("#sexo").val('1');
       $("#edad").val('0');
       $("#expediente").removeAttr("disabled");
       $("#nombre").removeAttr("disabled");
       $("#mat").removeAttr("disabled");
       $("#pat").removeAttr("disabled");
       $("#sexo").removeAttr("disabled");
       $("#edad").removeAttr("disabled"); 
    }
    
}
    

$('#expediente').on('change', checkExpediente);

function checkExpediente(data){
    
    var $url = '<?php echo site_url('captura/verifica_expediente'); ?>';
    var $variables = { expediente : data.currentTarget.value};
    var posting = $.post( $url, $variables );
        
         posting.done(function( data ) {
            
            if(data.length == 0)
            {
                $("#nombre").val('');
                $("#pat").val('');
                $("#mat").val('');
                $("#sexo").val('');
                $("#edad").val('0');
            }else{
                var $res = data.split('|');
                $("#nombre").val($res[0]);
                $("#pat").val($res[1]);
                $("#mat").val($res[2]);
                $("#sexo").val($res[3]);
                $("#edad").val($res[4]);
            }
            
         });

}


$('#cveMedico').on('change', checkcveMedico);

function checkcveMedico(data){
    
    var $url = '<?php echo site_url('captura/verifica_cveMedico'); ?>';
    var $variables = { cveMedico : data.currentTarget.value };
    var posting = $.post( $url, $variables );
        
         posting.done(function( data ) {
            
            if(data.length == 0)
            {
                $("#medico").val('');
            }else{
                $("#medico").val(data);
            }
            
         });

}

function getPrograma()
{
    var $tipoReceta = $("#tipoReceta").val();
    return $tipoReceta;
}

$('#lote').on('change', checklote);

function checklote(data){
    
    var $url = '<?php echo site_url('captura/verifica_lote'); ?>';
    var $cvearticulo = $('#cveArticulo').val();
    var $variables = { lote : data.currentTarget.value.toUpperCase(), cvearticulo : $cvearticulo };
    var posting = $.post( $url, $variables );
        
         posting.done(function( data ) {
            
            if(data.length == 0)
            {
                $("#fechacad").val('');
            }else{
                var $res = data.split('|');
                $("#fechacad").val($res[2]);
            }
            
         });

}

$( "#cveArticulo" ).autocomplete({
    
source: '<?php echo site_url('captura/busca_cveArticulo'); ?>',
minLength: 2,
select: function( event, ui ) {
    
    if(ui.item.cveArticulo.trim() == 'M100')
    {
        $("#precio").removeAttr('disabled');
    }
    
    $("#cveArticulo").val(ui.item.cveArticulo);
    $('#descripcion').html(ui.item.descripcion);
    $('#susa').html(ui.item.susa);
    $('#pres').html(ui.item.pres);
    $('#ampuleo').html(ui.item.ampuleo);
    //$('#nombre').val(ui.item.nombre);
    //$('#expediente').val(ui.item.paciente);
    getLotes(ui.item.cveArticulo);
    
    
    
    $('#req').focus();
    return false;
    
    }
});

function getLotes($cveArticulo)
{
    var $url = '<?php echo site_url('captura/actualizaLotes'); ?>';
    var $variables = {cveArticulo: $cveArticulo};
    var posting = $.post( $url, $variables );
        
         posting.done(function( data ) {
            
            $('#lote').html(data);
            
         });
}

$("#addproducto").on("click", agregaProdcuto);

function agregaProdcuto()
{
    var $var1 = $("#cveArticulo").val().trim().toUpperCase();
    var $clave = $var1.split('|');
    var $req = $("#req").val();
    var $sur = $("#sur").val();
    var $lote = $("#lote").val().trim().toUpperCase();
    var $fechacad = '0000-00-00';
    var $precio = 0;
    
    
    if($lote.length == 0)
    {
        alert('Lote no puede estar vacio.')
        $("#lote").focus();
        return false;
    }
 
    var $url = '<?php echo site_url('captura/add_producto'); ?>';
    var $variables = { cveArticulo : $clave[0].toUpperCase(), req: $req, sur: $sur, precio: $precio, lote: $lote, fechacad: $fechacad };
    var posting = $.post( $url, $variables );
        
         posting.done(function( data ) {
            
            $('#descripcion').html('');
            $('#susa').html('');
            $('#pres').html('');
            $('#ampuleo').html('');
            $('#req').val('');
            $('#sur').val('');
            $('#lote').html('');
            actualizaTablaProductos();
            $('#cveArticulo').val('').focus();
            
         });
    
}

function actualizaTablaProductos()
{
    var $url = '<?php echo site_url('captura/actualiza_tabla_productos'); ?>';
    var $variables = {};
    var posting = $.post( $url, $variables );
        
         posting.done(function( data ) {
            
            $('#productos').html(data);
            
         });
}

function actualizaTablaProductosVer()
{
    var $url = '<?php echo site_url('captura/actualiza_tabla_productos_ver'); ?>';
    var $variables = {};
    var posting = $.post( $url, $variables );
        
         posting.done(function( data ) {
            
            $('#productos').html(data);
            
         });
}

$(".elimina").on("click", elimina);

function elimina(data)
{
    if(confirm("Seguro que deseas eliminar ?")){
        
        data.preventDefault();
        var $url = data.currentTarget.attributes.href.value;
        var $variables = {};
        var posting = $.post( $url, $variables );
            
             posting.done(function( data ) {
                
                $('#productos').html(data);
                
             });
    }
}

$("#cveArticulo").on("change", checkArt);

function checkArt(event)
{
    var $cveArticulo = event.currentTarget.value;
    var $paso1 = $cveArticulo.split('|');
    $cveArticulo = $paso1[0].toUpperCase();
    
    if($cveArticulo.length > 0){
        
        if($cveArticulo == 'M100' || $cveArticulo == 'm100')
        {
            $("#precio").removeAttr('disabled');
        }
    
        var $url = '<?php echo site_url('captura/verificaCveArticulo'); ?>';
        var $variables = { cveArticulo: $cveArticulo };
        var posting = $.post( $url, $variables );
            
             posting.done(function( data ) {
                
                $res = data.split('|');
                
                $('#descripcion').html($res[1]);
                $('#susa').html($res[2]);
                $('#pres').html($res[3]);
                $('#ampuleo').html($res[4]);
                
                if( $res[0] == 0 )
                {
                    alert("La clave tecleada: " + $cveArticulo + " no existe, verifica por favor.");
                    $("#cveArticulo").val('').focus();
                }else{
                    getLotes($cveArticulo);
                }
                
             });

    }
    

}

$("#default_form").on("submit", guarda);

function guarda(event)
{
    event.preventDefault();
    
    var $productos = $("#productos_total").html();
    
    var $fecha2 = $("#fechaSur").val();
    var $fecha1 = $("#fechaSur").val();
    var $folioReceta = $("#folioReceta").val();
    $folioReceta = $folioReceta.trim();
    
    var date1 = new Date($fecha1);
    var date2 = new Date($fecha2);
    var $diferencia =  $("#diferencia").html();
    var timeDiff = Math.abs(date2.getTime() - date1.getTime());
    var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
    
    if(diffDays > $diferencia && $diferencia > 0){
        alert("La diferencia en dias: " + diffDays + " es mayor a la permitida: " + $diferencia + ". Verifica las fechas por favor...")
    }else{
        
        var $tipo = $("#tipo").html();
        
        if(($productos > 0 && $folioReceta.length > 0) || ($folioReceta.length > 0 && $tipo == 'edita'))
        {
            
            var $mensajito = "Seguro que deseas guardar esta receta ?. ";
            if($tipo == 'edita' && $productos == 0)
            {
                $mensajito = $mensajito + "Esta receta no lleva productos asi que se eliminara.";
            }
            
            if(confirm($mensajito))
            {
                var $fechaConsulta = $("#fechaSur").val();
                var $fechaSurtido = $("#fechaSur").val();
                var $tipoReceta = $("#tipoReceta").val();
                var $categoria = $("#categoria").val();
                var $expediente = $("#expediente").val().toUpperCase().trim();
                var $paterno = $("#pat").val().toUpperCase().trim();
                var $materno = $("#mat").val().toUpperCase().trim();
                var $nombre = $("#nombre").val().toUpperCase().trim();
                var $cveMedico = $("#cveMedico").val().toUpperCase().trim();
                var $medico = $("#medico").val().toUpperCase().trim();
                var $tipoReq = $("#tipoReq").val();
                var $sexo = $("#sexo").val();
                var $edad = $("#edad").val();
                
                var $consecutivo = $( "input[name='consecutivo']" ).val();
                var $url = '<?php echo site_url('captura/guardar'); ?>';
                var $variables = { fechaConsulta: $fechaConsulta, fechaSurtido: $fechaSurtido, folioReceta: $folioReceta, tipoReceta: $tipoReceta, categoria: $categoria, expediente: $expediente, paterno: $paterno, materno: $materno, nombre: $nombre, cveMedico: $cveMedico, medico: $medico, tipoReq: $tipoReq, sexo: $sexo, edad: $edad, tipo: $tipo, consecutivo: $consecutivo};
                var posting = $.post( $url, $variables );
                
                 posting.done(function( data ) {
                    
                    if(data == 0)
                    {
                        alert("Algo fallo");
                    }else{
                        window.location.href = '<?php echo site_url('captura/recetas/'); ?>/' + $fechaConsulta
                    }
                    
                 });
    
            }
        }

    }
    
}

$("#sur").on("focus", checkSur);

function checkSur()
{
    var $req = $("#req").val();
    $req = $req.trim();
    
    if($req.length == 0)
    {
        $("#req").focus();
    }
}

$('#sur').on('blur', cantsur);
function cantsur()
{
    var $sur = $('#sur').val();
    var $req = $('#req').val();
    
    $sur = parseInt($sur);
    $req = parseInt($req);
    
    if($sur > $req)
    {
        alert('Cantidad surtida no puede ser mayor que la requerida.');
        $("#req").focus();
    }
}

$('#elimina_receta_unitaria').on('click', elimina_receta_unitaria);

function elimina_receta_unitaria(event)
{
    if(confirm("Deseas eliminar esta receta en su totalidad??"))
    {
        
    }else{
        event.preventDefault();
    }
}


</script>