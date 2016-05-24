<?php
	
function MY_form_open($action, $id = 'default_form')
{
    
    $form = form_open($action, array('class' => 'form-horizontal', 'id' => $id));
    return $form;
}

function MY_form_datepicker($label, $name, $span, $required = TRUE, $value = null, $disabled = FALSE)
{
    if ( $required === TRUE ){
        $req = 'required="required"';
    }else{
        $req = null;
    }

    if ( $disabled === TRUE){
        $dis = 'disabled = "disabled"';
    }else{
        $dis = '';
    }

    $form = '
													<div class="row-fluid">
														<label for="'.$name.'">'.$label.'</label>
													</div>

													<div class="control-group">
														<div class="row-fluid input-append">
															<input maxlength="10" class="span'.$span.' date-picker" id="'.$name.'" name="'.$name.'" type="text" data-date-format="dd/mm/yyyy" '.$req.' value="'.$value.'" '.$dis.' />
															<span class="add-on">
																<i class="icon-calendar"></i>
															</span>
														</div>
													</div>
';
    
    return $form;


}

function MY_form_dropdown($label, $name, $opciones, $seleccionado, $span, $icono = "icon-reorder", $required = TRUE)
{
    if ( $required === TRUE ){
        $req = 'required="required"';
    }else{
        $req = null;
    }

    $form = '
													<div class="row-fluid">
														<label for="'.$name.'">'.$label.'</label>
													</div>

													<div class="control-group">
														<div class="row-fluid input-append">
															'.form_dropdown($name, $opciones, $seleccionado, 'id="'.$name.'"').'
															<span class="add-on">
																<i class="'.$icono.'"></i>
															</span>
														</div>
													</div>
';
    
    return $form;


}

function MY_form_datepicker_range($label, $name, $span, $required = TRUE)
{
    
    if ( $required === TRUE ){
        $req = 'required="required"';
    }else{
        $req = null;
    }
    
    $form = 
    '
                                    <div class="row-fluid">
                                        <label for="'.$name.'">'.$label.'</label>
                                    </div>
                                    
                                    <div class="control-group">
                                        <div class="row-fluid input-prepend">
                                            <span class="add-on">
                                                <i class="icon-calendar"></i>
                                            </span>
                                            
                                            <input class="span'.$span.'" type="text" name="'.$name.'" id="'.$name.'" '.$req.' />
                                        </div>
                                    </div>
    ';
    
    return $form;
}

function MY_form_submit($disabled = false)
{
    if($disabled == true)
    {
        $deshabilita = 'disabled="disabled"';
    }else{
        $deshabilita = null;
    }
    
    $form = '
                                    <div class="form-actions">
    									<button class="btn btn-info" type="submit" '.$deshabilita.'>
    										<i class="icon-ok bigger-110"></i>
    										Aceptar
    									</button>
    
								    </div>
            ';
            
    return $form;
    
}

function MY_form_input($name, $id, $placehorder, $type, $texto, $span = 3, $required = TRUE, $value = null, $disabled = FALSE, $pattern = null)
{
    
    if ( $required === TRUE ){
        $req = 'required="required"';
    }else{
        $req = null;
    }
    
    if ( $disabled === TRUE){
        $dis = 'disabled';
    }else{
        $dis = '';
    }
    
    if($pattern == null){
        
        $patt = null;
    }else{
        $patt = 'pattern="'.$pattern.'"';
    }

    $form = '
    <div class="control-group">
        <label class="control-label" for="'.$id.'">'.$texto.'</label>
            <div class="controls">
                <input class="span'.$span.'" name="'.$name.'" value="'.$value.'" id="'.$id.'" placeholder="'.$placehorder.'" type="'.$type.'" '.$req.' '.$dis.' '.$patt.' />
                <i class=""></i>
            </div>
    </div>
    ';
    
    return $form;
}

function MY_form_textarea($name, $id, $placehorder, $type, $texto, $span = 3, $required = TRUE, $value = null, $disabled = FALSE, $rows = 15, $cols = 50)
{
    
    if ( $required === TRUE ){
        $req = 'required="required"';
    }else{
        $req = null;
    }
    
    if ( $disabled === TRUE){
        $dis = 'disabled';
    }else{
        $dis = '';
    }
    

    $form = '
    <div class="control-group">
        <label class="control-label" for="'.$id.'">'.$texto.'</label>
            <div class="controls">
                <textarea class="span'.$span.'" name="'.$name.'" id="'.$id.'" placeholder="'.$placehorder.'" type="'.$type.'" '.$req.' '.$dis.' rows="'.$rows.'" cols="'.$cols.'" />'.$value.'</textarea>
                <i class=""></i>
            </div>
    </div>
    ';
    
    return $form;
}

function MY_form_dropdown2($label, $name, $opciones, $seleccionado, $span, $icono = "icon-reorder", $required = TRUE, $disabled = FALSE)
{
    if ( $required === TRUE ){
        $req = 'required="required"';
    }else{
        $req = null;
    }

    if ( $disabled === TRUE){
        $dis = 'disabled = "disabled"';
    }else{
        $dis = '';
    }

    $form = '
    <div class="control-group">
        <label class="control-label" for="'.$name.'">'.$label.'</label>
            <div class="controls">
                '.form_dropdown($name, $opciones, $seleccionado, 'id="'.$name.'" '.$dis).'
            </div>
    </div>
';
    
    return $form;


}

function MY_form_dropdown3($label, $name, $span, $icono = "icon-reorder")
{

    $form = '
    <div class="control-group">
        <label class="control-label" for="'.$name.'">'.$label.'</label>
            <div class="controls">
                <select size="1" id="'.$name.'" name="'.$name.'"></select>
            </div>
    </div>
';
    
    return $form;


}
