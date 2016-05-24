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
    <caption id="tipo">ver</caption>
    <tr>
        <td>Fecha inicial: <span style="color: red;"><?php echo $rango['fecha_inicial']; ?></span></td>
        <td>Fecha final: <span style="color: red;"><?php echo $rango['fecha_final']; ?></span></td>
        <td>Sucursal: <span style="color: red;"><?php echo $this->session->userdata('clvsucursal') . ' - ' .$this->session->userdata('sucursal'); ?></span></td>
    
    </tr>

    <tr>
        
        <!--<td><?php //echo MY_form_datepicker('Fecha de Consulta', 'fechaCon', 6, true);?></td>-->
        <td><?php echo MY_form_datepicker('Fecha de surtido', 'fechaSur', 6, true, $receta->fecha, true);?></td>
        <td><?php echo MY_form_input('folioReceta', 'folioReceta', 'Folio Receta', 'text', 'Folio Receta:', 12, true, $receta->folioreceta, true); ?></td>
        <td>Usuario: <span style="color: red;"><?php echo $this->session->userdata('usuario'); ?></span> - <?php echo date('Y-m-d H:i:s'); ?> - <span id="diferencia"><?php echo $config['dias_diferencia']; ?></span></td>

    </tr>
    
    <tr>
            
        <td><?php echo MY_form_dropdown2('Programa:', 'tipoReceta', $tipoReceta, $receta->idprograma, 2, 'icon-reorder', true, true); ?></td>
        <td><?php echo MY_form_dropdown2('Requerimiento:', 'tipoReq', $requerimiento, $receta->tiporequerimiento, 2, 'icon-reorder', true, true); ?></td>
        <td><?php echo MY_form_dropdown2('Servicio:', 'categoria', $categoria, $receta->cveservicio, 2, 'icon-reorder', true, true); ?></td>
    </tr>

    <tr>
        <td><?php echo MY_form_input('expediente', 'expediente', 'Numero de expediente', 'text', 'Numero de expediente:', 12, false, $receta->cvepaciente, true); ?></td>
        <td><?php echo MY_form_input('pat', 'pat', 'Paterno', 'text', 'Paterno:', 12, false, $receta->apaterno, true); ?></td>
        <td><?php echo MY_form_input('mat', 'mat', 'Materno', 'text', 'Materno:', 12, false, $receta->amaterno, true); ?></td>
    </tr>

    <tr>
   
        <td><?php echo MY_form_input('nombre', 'nombre', 'Nombre', 'text', 'Nombre:', 12, false, $receta->nombre, true); ?></td>
        <td><?php echo MY_form_dropdown2('Sexo:', 'sexo', $sexo, $receta->genero, 2, 'icon-reorder', true, true); ?></td>
         <td><?php echo MY_form_input('edad', 'edad', 'Edad', 'number', 'Edad:', 12, false, $receta->edad, true); ?></td>
    
    </tr>

    <tr>
    
        <td><?php echo MY_form_input('cveMedico', 'cveMedico', 'Clave de medico', 'text', 'Clave de Medico:', 12, false, $receta->cvemedico, true); ?></td>
        <td colspan="2"><?php echo MY_form_input('medico', 'medico', 'Medico', 'text', 'Medico:', 22, false, $receta->nombremedico, true); ?></td>
    
    </tr>
    

</table>

<div id="productos">


</div>



<?php
	echo form_hidden('consecutivo', $receta->consecutivo);
	
    
    echo MY_form_submit(true);
    echo form_close();
?>


    </div>
</div>
