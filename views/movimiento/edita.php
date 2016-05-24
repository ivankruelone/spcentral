<?php
	$row = $query->row();
?>

							<div class="row-fluid">
                                <div class="span12">
                                    
                                    <?php echo MY_form_open('movimiento/edita_submit'); ?>
                                    
                                    <?php echo MY_form_datepicker('Fecha del documento', 'fecha', 3, true, $row->fecha); ?>
                                    
                                    <?php echo MY_form_input('orden', 'orden', 'Orden de compra', 'text', 'Orden de compra', 3, true, $row->orden); ?>

                                    <?php echo MY_form_input('referencia', 'referencia', 'Referencia de documento', 'text', 'Referencia de documento', 3, true, $row->referencia); ?>

                                    <?php echo MY_form_dropdown2('Sucursal', 'sucursal_referencia', $sucursales, $row->clvsucursalReferencia, 6); ?>

                                    <?php echo MY_form_dropdown2('Proveedor', 'proveedor', $proveedores, $row->proveedorID, 6); ?>

                                    <?php echo MY_form_input('observaciones', 'observaciones', 'Observaciones', 'text', 'Observaciones', 12, false, $row->observaciones); ?>
                                    
                                    <?php echo form_hidden('tipoMovimiento', $row->tipoMovimiento); ?>

                                    <?php echo form_hidden('subtipoMovimiento', $row->subtipoMovimiento); ?>

                                    <?php echo form_hidden('movimientoID', $row->movimientoID); ?>

                                    <?php echo MY_form_submit(); ?>
                                    
                                    <?php echo form_close(); ?>
                                    
								</div>	
                            </div>
