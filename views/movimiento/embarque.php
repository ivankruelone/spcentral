<?php
	if($query->num_rows() > 0)
    {
        $row = $query->row();
        
        $embarco = $row->embarco;
        $operador = $row->operador;
        $unidad = $row->unidad;
        $placas = $row->placas;
        $cajas = $row->cajas;
        $hieleras = $row->hieleras;
        $surtio = $row->surtio;
        $valido = $row->valido;
        $observaciones = $row->observaciones;

    }else{
        $embarco = null;
        $operador = null;
        $unidad = null;
        $placas = null;
        $cajas = null;
        $hieleras = null;
        $surtio = null;
        $valido = null;
        $observaciones = null;
        
    }
?>

							<div class="row-fluid">
                                <div class="span12">
                                    
                                    <?php echo MY_form_open('movimiento/embarque_submit'); ?>
                                    
                                    <?php echo MY_form_input('embarco', 'embarco', 'Embarco', 'text', 'Embarco', 3, false, $embarco); ?>

                                    <?php echo MY_form_input('operador', 'operador', 'Operador', 'text', 'Operador', 3, false, $operador); ?>

                                    <?php echo MY_form_input('unidad', 'unidad', 'Unidad', 'text', 'Unidad', 3, false, $unidad); ?>

                                    <?php echo MY_form_input('placas', 'placas', 'Placas', 'text', 'Placas', 3, false, $placas); ?>

                                    <?php echo MY_form_input('cajas', 'cajas', 'Cajas', 'number', 'Cajas', 3, false, $cajas); ?>

                                    <?php echo MY_form_input('hieleras', 'hieleras', 'Hieleras', 'number', 'Hieleras', 3, false, $hieleras); ?>

                                    <?php echo MY_form_input('surtio', 'surtio', 'Surtio', 'text', 'Surtio', 3, false, $surtio); ?>
                                    
                                    <?php echo MY_form_input('valido', 'valido', 'Valido', 'text', 'Valido', 3, false, $valido); ?>

                                    <?php echo MY_form_input('observaciones', 'observaciones', 'Observaciones', 'text', 'Observaciones', 12, false, $observaciones); ?>

                                    <?php echo form_hidden('movimientoID', $movimientoID); ?>

                                    <?php echo form_hidden('tipoMovimiento', $tipoMovimiento); ?>

                                    <?php echo form_hidden('subtipoMovimiento', $subtipoMovimiento); ?>

                                    <?php echo MY_form_submit(); ?>
                                    
                                    <?php echo form_close(); ?>
                                    
								</div>	
                            </div>
