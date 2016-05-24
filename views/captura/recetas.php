<div class="row-fluid">
    <div class="span12">
        
<?php
    echo MY_form_open('captura/recetas__agregar');
    
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
        <td>Fecha inicial: <span style="color: red;"><?php echo $rango['fecha_inicial']; ?></span></td>
        <td>Fecha final: <span style="color: red;"><?php echo $rango['fecha_final']; ?></span></td>
        <td>Sucursal: <span style="color: red;"><?php echo $this->session->userdata('clvsucursal') . ' - ' .$this->session->userdata('sucursal'); ?></span></td>
    
    </tr>

    <tr>
        
        <!--<td><?php //echo MY_form_datepicker('Fecha de Consulta', 'fechaCon', 6, true);?></td>-->
        <td><?php echo MY_form_datepicker('Fecha de surtido', 'fechaSur', 6, true, $rango['fecha_surtido']);?></td>
        <td><?php echo MY_form_input('folioReceta', 'folioReceta', 'Folio Receta', 'text', 'Folio Receta:', 12); ?></td>
        <td>Usuario: <span style="color: red;"><?php echo $this->session->userdata('usuario'); ?></span> - <?php echo date('Y-m-d H:i:s'); ?> - <span id="diferencia"><?php echo $config['dias_diferencia']; ?></span></td>

    </tr>
    
    <tr>
            
        <td><?php echo MY_form_dropdown2('Programa:', 'tipoReceta', $tipoReceta, '1', 2); ?></td>
        <td><?php echo MY_form_dropdown2('Requerimiento:', 'tipoReq', $requerimiento, $rango['tiporequerimiento'], 2); ?></td>
        <td><?php echo MY_form_dropdown2('Servicio:', 'categoria', $categoria, '52', 2); ?></td>
    </tr>

    <tr>
        <td><?php echo MY_form_input('expediente', 'expediente', 'Numero de expediente', 'text', 'Numero de expediente:', 12); ?></td>
        <td><?php echo MY_form_input('pat', 'pat', 'Paterno', 'text', 'Paterno:', 12); ?></td>
        <td><?php echo MY_form_input('mat', 'mat', 'Materno', 'text', 'Materno:', 12); ?></td>
    </tr>

    <tr>
   
        <td><?php echo MY_form_input('nombre', 'nombre', 'Nombre', 'text', 'Nombre:', 12); ?></td>
        <td><?php echo MY_form_dropdown2('Sexo:', 'sexo', $sexo, null, 2); ?></td>
         <td><?php echo MY_form_input('edad', 'edad', 'Edad', 'number', 'Edad:', 12); ?></td>
    
    </tr>

    <tr>
    
        <td><?php echo MY_form_input('cveMedico', 'cveMedico', 'Clave de medico', 'text', 'Clave de Medico:', 12); ?></td>
        <td colspan="2"><?php echo MY_form_input('medico', 'medico', 'Medico', 'text', 'Medico:', 22); ?></td>
    
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
        <td><?php echo MY_form_input('req', 'req', 'Solicitada', 'text', 'Solicitad:', 12, FALSE); ?></td>
        <td><?php echo MY_form_input('sur', 'sur', 'Surtida', 'text', 'Surtida:', 12, FALSE); ?></td>
        <!--<td>LOTE: <select size="1" id="lote" name="lote"></select></td>-->
        <td><?php echo MY_form_dropdown3('Lote: ', 'lote', 4);?></td>

       <!-- <td><?php echo MY_form_input('precio', 'precio', 'Precio', 'text', 'Precio:', 12, FALSE, null, true); ?></td> -->
      
    </tr>
    
    <tr>
        <td><?php echo form_button($data);?></td>
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
