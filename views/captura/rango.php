<div class="row-fluid">
    <div class="span12">
        
<?php
    echo MY_form_open('captura/rango__agregar');
    
?>

<table>

    <tr>
        
        <td><?php echo MY_form_datepicker('Fecha Inicial', 'fecha_inicial', 6, true, $rango['fecha_inicial']);?></td>
    
        <td><?php echo MY_form_datepicker('Fecha Final', 'fecha_final', 6, true, $rango['fecha_final']);?></td>

    </tr>
    
    <tr>
        
        <td><?php echo MY_form_datepicker('Fecha Surtido', 'fecha_surtido', 6, true, $rango['fecha_surtido']);?></td>
    
        <td><?php echo MY_form_dropdown2('Requerimiento:', 'tipoReq', $requerimiento, $rango['tiporequerimiento'], 2); ?></td>

    </tr>
    

</table>


<?php
	
    
    echo MY_form_submit();
    echo form_close();
?>


    </div>
</div>
