						<?php
                        
                        $row = $query->row();
                        
                        $query2 = $this->Inventario_model->getCvearticuloPieza($row->cvearticulo);
                        
                        if($query2->num_rows() > 0)
                        {
                            
                        
	
?>
                        	<div class="row-fluid">
                                <div class="span12">
                                    
                                    <?php echo MY_form_open('inventario/convierte_submit'); ?>
                                    
                                    <?php echo MY_form_input('cvearticulo', 'cvearticulo', 'Clave de articulo', 'text', 'Clave de articulo', 3, true, $row->cvearticulo, true); ?>

                                    <?php echo MY_form_input('susa', 'susa', 'Susa', 'text', 'Susa', 12, true, $row->susa, true); ?>

                                    <?php echo MY_form_input('descripcion', 'descripcion', 'Descripcion', 'text', 'Descripcion', 12, true, $row->descripcion, true); ?>

                                    <?php echo MY_form_input('pres', 'pres', 'Presentacion', 'text', 'Presentacion', 12, true, $row->pres, true); ?>

                                    <?php echo MY_form_input('lote', 'lote', 'Lote', 'text', 'Lote', 3, true, $row->lote, true, '[a-zA-Z0-9&ntilde;&Ntilde;]+'); ?>

                                    <?php echo MY_form_input('caducidad', 'caducidad', 'Caducidad', 'text', 'Caducidad', 3, true, $row->caducidad, true); ?>
                                    
                                    <?php echo MY_form_input('numunidades', 'numunidades', 'Numero de unidades', 'number', 'Numero de unidades', 3, true, $row->numunidades, true, '[0-9]+'); ?>

                                    <?php echo MY_form_input('convertir', 'convertir', 'Convertir', 'number', 'Convertir (Menor o igual a <span id="cantidad">'.$row->cantidad.'</span>)', 3, true, 1); ?>

                                    <?php echo form_hidden('inventarioID', $row->inventarioID); ?>

                                    <?php echo MY_form_submit(); ?>
                                    
                                    <?php echo form_close(); ?>
                                    
								</div>	
                            </div>
<?php
	}else{
?>
                            <div class="row-fluid">
                                <div class="span12">
                                
                                <p class="alert alert-error">No existe la presentacion por PIEZA.</p>
                                
                                </div>
                            </div>
<?php
	}
?>
