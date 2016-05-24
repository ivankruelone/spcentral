<?php
	$row = $query->row();
?>
                            <div class="row-fluid">
                                <div class="span12">
                                
                                <?php echo MY_form_open('movimiento/modifica_submit'); ?>
                                
                                <?php echo MY_form_input('cvearticulo', 'cvearticulo', 'cvearticulo', 'text', 'Clave', 6, true, $row->cvearticulo, true); ?>
                                
                                <?php echo MY_form_input('sustancia', 'sustancia', 'Sustancia', 'text', 'Sustancia', 12, true, $row->susa, true); ?>

                                <?php echo MY_form_input('descripcion', 'descripcion', 'Descripcion', 'text', 'Descripcion', 12, true, $row->descripcion, true); ?>

                                <?php echo MY_form_input('pre', 'pres', 'Presentacion', 'text', 'Presentacion', 12, true, $row->pres, true); ?>

                                <?php echo MY_form_input('lote', 'lote', 'Lote', 'text', 'Lote', 6, true, $row->lote); ?>

                                <?php echo MY_form_input('caducidad', 'caducidad', 'Caducidad', 'date', 'Caducidad', 6, true, $row->caducidad); ?>

                                <?php echo MY_form_input('piezas', 'piezas', 'Piezas', 'number', 'Piezas', 6, true, $row->piezas); ?>

                                <?php echo MY_form_input('costo', 'costo', 'Costo', 'text', 'Costo', 6, true, $row->costo); ?>
                                
                                <?php echo MY_form_input('ean', 'ean', 'EAN', 'text', 'EAN', 6, true, $row->ean); ?>

                                <?php echo MY_form_input('marca', 'marca', 'Marca', 'text', 'Marca', 12, false, $row->marca); ?>

                                <?php echo form_hidden('movimientoDetalle', $row->movimientoDetalle); ?>

                                <?php echo form_hidden('movimientoID', $row->movimientoID); ?>

                                <?php echo MY_form_submit(); ?>
                                    
                                <?php echo form_close(); ?>
                                
                                </div>
                            </div>