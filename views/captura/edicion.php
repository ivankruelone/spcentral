<div class="row-fluid">
    <div class="span12">
        
<?php
    echo MY_form_open('captura/edicion_submit');
    
?>

<p style="color: red;"><?php echo $mensaje; ?></p>
<table>

    <tr>
        <td><?php echo MY_form_input('folioReceta', 'folioReceta', 'Folio Receta', 'text', 'Folio Receta:', 12); ?></td>
    </tr>
    
    

</table>


<?php
	
    
    echo MY_form_submit();
    echo form_close();
?>


    </div>
</div>
