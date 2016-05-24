<?php
	$row = $query->row();
?>

							<div class="row-fluid">
                                <div class="span12">
                                    
                                    <?php echo MY_form_open('movimiento/devolucion_submit'); ?>
                                    
                                    <?php echo MY_form_input('movimiento', 'movimiento', 'Movimiento', 'text', 'Movimiento', 3, true, $row->movimientoID, true); ?>

                                    <?php echo MY_form_input('referencia', 'referencia', 'Referencia', 'text', 'Referencia', 3, true, $row->referencia, true); ?>

                                    <?php echo MY_form_input('susa', 'susa', 'Sustancia', 'text', 'Sustancia', 12, true, $row->susa, true); ?>
                                    
                                    <?php echo MY_form_input('descripcion', 'descripcion', 'Descripcion', 'text', 'Descripcion', 12, true, $row->descripcion, true); ?>

                                    <?php echo MY_form_input('pres', 'pres', 'Presentacion', 'text', 'Presentacion', 12, true, $row->pres, true); ?>

                                    <?php echo MY_form_input('lote', 'lote', 'Lote', 'text', 'Lote', 3, true, $row->lote, true); ?>

                                    <?php echo MY_form_input('caducidad', 'caducidad', 'Caducidad', 'text', 'Caducidad', 3, true, $row->caducidad, true); ?>

                                    <?php echo MY_form_input('devuelve', 'devuelve', 'Cantidad a devolver', 'number', 'Cantidad a Devolver (Menor o igual a <span id="piezas">'.$row->piezas.'</span>)', 3, true, $row->piezas); ?>

                                    <?php echo MY_form_dropdown2('Causas', 'causa', $causas, null, 6); ?>
                                    
                                    <?php echo form_hidden('tipoMovimiento', $row->tipoMovimiento); ?>

                                    <?php echo form_hidden('subtipoMovimiento', $row->subtipoMovimiento); ?>

                                    <?php echo form_hidden('movimientoID', $row->movimientoID); ?>

                                    <?php echo form_hidden('movimientoDetalle', $row->movimientoDetalle); ?>

                                    <?php echo MY_form_submit(); ?>
                                    
                                    <?php echo form_close(); ?>
                                    
								</div>	
                            </div>
