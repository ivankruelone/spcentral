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
	$row = $query->row();
    
    if($row->orden > 0)
    {
        $orden = $this->util->getDataOficina('ordenDetalle', array('folprv' => $row->orden));
    }else{
        $orden = null;
    }
    
?>
                            <div class="row-fluid">
                                <div class="span12">
                                
                                    <?php
                                    
                                    if($row->statusMovimiento == 0){
                                    
                                    ?>
                                
                                    <p style="text-align: left;"><?php echo anchor('movimiento/cierre/'.$row->movimientoID.'/'.$row->tipoMovimiento.'/'.$row->subtipoMovimiento, 'Cerrar este movimiento', array('id' => 'cierre')); ?></p>
                                    
                                    <?php
                                    
                                    echo form_hidden('subtipoMovimiento', $row->subtipoMovimiento);
                                    
                                    
                                    }
                                    
                                    $atts = array(
                                      'width'      => '800',
                                      'height'     => '100',
                                      'scrollbars' => 'no',
                                      'status'     => 'no',
                                      'resizable'  => 'no',
                                      'screenx'    => '0',
                                      'screeny'    => '0'
                                    );

                                    ?>
                                    
                                
                                    <table class="table table-condensed">
                                        <thead>
                                            <tr>
                                                <th>Movimiento</th>
                                                <th>Tipo de Movimiento</th>
                                                <th>Subtipo de Movimiento</th>
                                                <th>Orden</th>
                                                <th>Referencia</th>
                                                <th>Fecha</th>
                                                <th>Proveedor</th>
                                                <th>Sucursal</th>
                                                <th>Sucursal Referencia</th>
                                                <th>Usuario</th>
                                                <th>Alta/Cierre/Baja</th>
                                                <th>Observaciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td id="movimientoID"><?php echo $row->movimientoID;?></td>
                                                <td><?php echo $row->tipoMovimientoDescripcion;  if(PATENTE == 1){ echo "<br />"; echo anchor_popup('movimiento/actualizaArticulo', 'Act. Cat.', $atts); }?></td>
                                                <td><?php echo $row->subtipoMovimientoDescripcion; ?></td>
                                                <td id="orden"><?php echo $row->orden; ?><a href="#" id="id-btn-dialog1" class="btn btn-purple btn-small">Orden</a></td>
                                                <td><?php echo $row->referencia; ?></td>
                                                <td><?php echo $row->fecha; ?></td>
                                                <td><?php echo $row->razon; ?></td>
                                                <td><?php echo $row->sucursal; ?></td>
                                                <td><?php echo $row->sucursal_referencia; ?></td>
                                                <td><?php echo $row->nombreusuario; ?></td>
                                                <td><?php echo $row->fechaAlta.'<br />'.$row->fechaCierre.'<br />'.$row->fechaCancelacion; ?></td>
                                                <td><?php echo $row->observaciones; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>                                
                                    
                                </div>
                            </div>
                            
                            <?php
                                    
                            if($row->statusMovimiento == 0){
                            
                            ?>
                            
							<div class="row-fluid">
                                <div class="span12">
                                    
                                    <div class="widget-box">
											<div class="widget-header">
												<h4>Productos en Inventario</h4>
											</div>
                                    
                                    <div class="widget-body">
												<div class="widget-main">
                                                
                                                
                                                <?php
                                                echo form_open('movimiento/validaArea');
                                                echo form_hidden('movimientoID', $movimientoID);
                                                echo MY_form_dropdown2('Area: ', 'areaID', $areas, $areaID, 12);
                                                echo MY_form_submit();
                                                echo form_close();
                                                ?>
                                                
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>Area</th>
                                                            <th>Clave</th>
                                                            <th>Sustancia</th>
                                                            <th>Descripcion</th>
                                                            <th>Presentacion</th>
                                                            <th>Lote</th>
                                                            <th>Caducidad</th>
                                                            <th style="text-align: right;">Inventario</th>
                                                            <th>Transferir todo</th>
                                                            <th colspan="2">Transferir parcial</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                        
                                                        foreach($query2->result() as $row2){ 
                                                        
                                                        $data_parcial = array(
                                                          'name'        => 'parcial_'.$row2->inventarioID,
                                                          'id'          => 'parcial_'.$row2->inventarioID,
                                                          'value'       => $row2->cantidad,
                                                          'type'        => 'number',
                                                          'min'         => 1,
                                                          'max'         => $row2->cantidad,
                                                          'size'        => '5',
                                                          'class'       => 'input-mini'
                                                        );
                                                        
                                                        
                                                        $data_boton = array(
                                                            'name' => 'button_'.$row2->inventarioID,
                                                            'id' => 'button_'.$row2->inventarioID,
                                                            'inventarioID' => $row2->inventarioID,
                                                            'movimientoID'  => $row->movimientoID,
                                                            'type' => 'button',
                                                            'content' => 'Transfer',
                                                            'class'     => 'btn btn-small'
                                                        );
                                                        
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $row2->area; ?></td>
                                                            <td><?php echo $row2->cvearticulo; ?></td>
                                                            <td><?php echo $row2->susa; ?></td>
                                                            <td><?php echo $row2->descripcion; ?></td>
                                                            <td><?php echo $row2->pres; ?></td>
                                                            <td><?php echo $row2->lote; ?></td>
                                                            <td><?php echo $row2->caducidad; ?></td>
                                                            <td style="text-align: right; color: red;"><?php echo $row2->cantidad; ?></td>
                                                            <td><?php echo anchor('movimiento/transferirTodo/'.$row->movimientoID.'/'.$row2->inventarioID, 'TODO', array('movimientoID' => $row->movimientoID, 'inventarioID' => $row2->inventarioID, 'valor' => $row2->cantidad, 'class' => 'btn btn-small btn-primary', 'id' => 'link_'.$row2->inventarioID)); ?></td>
                                                            <td><?php echo form_input($data_parcial); ?></td>
                                                            <td><?php echo form_button($data_boton); ?></td>
                                                        </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                                

												</div>
											</div>
                                    </div>
                                    
								</div>	
                            </div>
                            
                            <?php
                            
                            }
                            
                            ?>

							<div class="row-fluid">
                                <div class="span12" id="detalle">
                                
                                
                                </div>
                            </div>
                            <div id="dialog-message" class="hide">
                            
                            <h3>Detalle de la orden compra</h3>
                            
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Codigo</th>
                                        <th>Secuencia</th>
                                        <th>Clave</th>
                                        <th>Descripcion 1</th>
                                        <th>Descripcion 2</th>
                                        <th>Costo</th>
                                        <th>IVA</th>
                                        <th>Cantidad Pedida</th>
                                        <th>Aplicada</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    if(is_array($orden)){
                                        foreach($orden as $o){
                                    ?>
                                    <tr>
                                        <td><?php echo $o->codigo; ?></td>
                                        <td><?php echo $o->sec; ?></td>
                                        <td><?php echo $o->clagob; ?></td>
                                        <td><?php echo $o->susa1; ?></td>
                                        <td><?php echo $o->susa2; ?></td>
                                        <td><?php echo $o->costo; ?></td>
                                        <td><?php echo $o->iva; ?></td>
                                        <td><?php echo $o->canp; ?></td>
                                        <td><?php echo $o->aplica; ?></td>
                                    </tr>
                                    <?php 
                                    
                                        }
                                    }
                                    
                                    ?>
                                </tbody>
                            </table>
							
                            </div><!-- #dialog-message -->
