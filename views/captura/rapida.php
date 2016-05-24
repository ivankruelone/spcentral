<?php
	$error = $this->session->flashdata('error');
    
    if(strlen($error) > 0)
    {
        
?>
<div class="alert alert-error">
    <button type="button" class="close" data-dismiss="alert">
        <i class="icon-remove"></i>
    </button>

    <strong>
        <i class="icon-remove"></i>
        Error!
    </strong>

    <?php echo $error; ?>
    <br />
</div>

<?php
	}
?>

<?php
	$ok = $this->session->flashdata('ok');
    
    if(strlen($ok) > 0)
    {
        
?>
<div class="alert alert-block alert-success">
    <button type="button" class="close" data-dismiss="alert">
        <i class="icon-remove"></i>
    </button>

    <strong>
        <i class="icon-ok"></i>
        Gracias !
    </strong>

    <?php echo $ok; ?>
    <br />
</div>

<?php
	}
?>

<div class="row-fluid">
    <div class="span12">
        
<?php
    echo MY_form_open('captura/folio_submit');
    
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
        <td>Sucursal: <span style="color: red;"><?php echo $this->session->userdata('clvsucursal') . ' - ' .$this->session->userdata('sucursal'); ?></span></td>
        <td> Usuario: <span style="color: red;"><?php echo $this->session->userdata('usuario'); ?></span> - <?php echo date('Y-m-d H:i:s'); ?> - <span id="diferencia"><?php echo $config['dias_diferencia']; ?></span></td>
    </tr>

    <tr>
        <td colspan="2"><?php echo MY_form_input('folioReceta', 'folioReceta', 'Folio Receta', 'text', 'Folio Receta:', 12); ?></td>

    </tr>
    
    

</table>

<div id="productos">


</div>



<?php
	echo form_hidden('consecutivo', 0);
    
    echo MY_form_submit();
    echo form_close();
?>


    </div>
</div>
