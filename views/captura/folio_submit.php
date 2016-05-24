<div class="row-fluid">
    <div class="span12">
        
<?php
    //echo MY_form_open('captura/recetas__agregar', 'detalle_captura');
    
    $data = array(
    'name' => 'button',
    'id' => 'addproducto',
    'value' => 'true',
    'type' => 'button',
    'class' => 'btn',
    'content' => 'Agregar'
    );


?>

<table>
    <caption id="tipo">captura</caption>
    <tr>
        
        <td><?php echo MY_form_input('folioReceta1', 'folioReceta1', 'Folio Receta', 'text', 'Folio Receta:', 12, true, $folioReceta, true); ?></td>
        <td>Usuario: <span style="color: red;"><?php echo $this->session->userdata('usuario'); ?></span> - <?php echo date('Y-m-d H:i:s'); ?> - <span id="diferencia"><?php echo $config['dias_diferencia']; ?></span></td>

    </tr>
    
    <tr>
    
        <td colspan="4"><?php echo MY_form_input('cveArticulo', 'cveArticulo', 'Clave de articulo', 'text', 'Clave de Articulo:', 12, FALSE); ?></td>
    
    </tr>
    
    <tr>

        <td id="susa" style="color: blue;" ></td>
        <td id="descripcion" style="color: green;" ></td>
        <td id="pres" style="color: red;" ></td>
        <td id="ampuleo" style="color: brown;" ></td>

    </tr>
    
    <tr>
        <td><?php echo form_button($data);?></td>
    </tr>

</table>

<div id="productos">


</div>



<?php
	echo form_hidden('consecutivo', 0);
    echo form_hidden('folioReceta', $folioReceta);
    echo MY_form_submit();
    //echo form_close();
?>


    </div>
</div>
