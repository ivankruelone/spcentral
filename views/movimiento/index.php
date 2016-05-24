							<div class="row-fluid">
                                <div class="span12">
                                    
                                    <?php
                                    
                                    if($subtipoMovimiento == 15){
                                    
                                    ?>
                                    
                                    <p style="text-align: center; color: red;">Este tipo de movimiento borra el inventario actual y el movimiento se convierte en el nuevo inventario.</p>
                                    
                                    <?php
                                    
                                    }
                                    
                                    ?>
                                    
                                    <p><?php echo anchor('movimiento/nuevo/'.$tipoMovimiento.'/'.$subtipoMovimiento, 'Nuevo Movimiento'); ?></p>
                                    
                                    <p style="text-align: center;"><?php echo $this->pagination->create_links(); ?></p>
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
                                            <?php 
                                            
                                            foreach($query->result() as $row){
                                                
                                                $factura = null;
                                                $descargaXML = null;
                                                $descargaPDF = null;
                                                $folioFactura = null;
                                                $fechaFactura = null;
                                                
                                                if($row->statusMovimiento == 0)
                                                {
                                                    $link_edita = anchor('movimiento/edita/'.$row->movimientoID, 'Edita <i class="icon-pencil bigger-130"> </i>');
                                                    $imprime = null;
                                                    
                                                }else{
                                                    $link_edita = null;
                                                    $imprime = anchor('movimiento/imprime/'.$row->movimientoID.'/'.$tipoMovimiento.'/'.$subtipoMovimiento, 'Imprime <i class="icon-print bigger-130"> </i>', array('target' => '_blank'));
                                                }
                                                
                                                if($subtipoMovimiento == 13)
                                                {
                                                    $embarque = anchor('movimiento/embarque/'.$row->movimientoID.'/'.$tipoMovimiento.'/'.$subtipoMovimiento, 'Embarque <i class="icon-truck bigger-130"> </i>');
                                                    
                                                    if($row->statusPrepedido == 0)
                                                    {
                                                        $prepedido = anchor('movimiento/prepedido/'.$row->movimientoID.'/'.$tipoMovimiento.'/'.$subtipoMovimiento, 'Pre-pedido');
                                                        $guia = null;
                                                    }else{
                                                        $prepedido = null;
                                                        $guia = anchor('movimiento/guia/'.$row->movimientoID.'/'.$tipoMovimiento.'/'.$subtipoMovimiento, 'Guia Surtido', array('target' => '_blank'));
                                                    }
                                                    
                                                    if($row->statusMovimiento == 1 && $row->idFactura > 0)
                                                    {
                                                        $factura = null;
                                                        $folioFactura = '<span style="color: red;">'.$row->folioFactura.' <i class="icon-file bigger-130"> </i> </span>';
                                                        $descargaXML = anchor('movimiento/descargaXML/'.$row->movimientoID, 'Descarga XML <i class="icon-download bigger-130"> </i>');
                                                        $descargaPDF = anchor('movimiento/descargaPDF/'.$row->movimientoID, 'Descarga PDF <i class="icon-download bigger-130"> </i>');
                                                        $fechaFactura = $row->fechaFactura;
                                                    }elseif($row->statusMovimiento == 1 && $row->idFactura == 0){
                                                        $folioFactura = null;
                                                        $descargaXML = null;
                                                        $descargaPDF = null;
                                                        $fechaFactura = null;
                                                        $factura = anchor('movimiento/factura/'.$row->movimientoID.'/'.$tipoMovimiento.'/'.$subtipoMovimiento, 'Facturar <i class="icon-file bigger-130"> </i>');
                                                    }else{
                                                        $folioFactura = null;
                                                        $descargaXML = null;
                                                        $descargaPDF = null;
                                                        $fechaFactura = null;
                                                        $factura = null;
                                                    }
                                                    
                                                }else{
                                                    $embarque = null;
                                                    $prepedido = null;
                                                    $guia = null;
                                                    $factura = null;
                                                    $descargaXML = null;
                                                    $descargaPDF = null;
                                                }
                                                
                                                if($subtipoMovimiento == 3)
                                                {
                                                    if($row->statusMovimiento == 1 && $row->asignaFactura == 0)
                                                    {
                                                        $prepedido = anchor('movimiento/asigna_factura/'.$row->movimientoID.'/'.$tipoMovimiento.'/'.$subtipoMovimiento, 'Asisgna Factura <i class="icon-folder-close bigger-130"> </i>');
                                                    }
                                                    
                                                }
                                                
                                            
                                            ?>
                                            <tr>
                                                <td><?php echo $row->movimientoID; ?></td>
                                                <td><?php echo $row->tipoMovimientoDescripcion; ?></td>
                                                <td><?php echo $row->subtipoMovimientoDescripcion; ?></td>
                                                <td><?php echo $row->orden; ?></td>
                                                <td><?php echo $row->referencia; ?></td>
                                                <td><?php echo $row->fecha; ?></td>
                                                <td><?php echo $row->razon; ?></td>
                                                <td><?php echo $row->sucursal; ?></td>
                                                <td><?php echo $row->sucursal_referencia; ?></td>
                                                <td><?php echo $row->nombreusuario; ?></td>
                                                <td><?php echo $row->fechaAlta.'<br />'.$row->fechaCierre.'<br />'.$row->fechaCancelacion; ?></td>
                                                <td><?php echo $row->observaciones; ?></td>
                                            </tr>
                                            <tr>
                                                <td><?php echo $link_edita; ?></td>
                                                <td><?php echo $prepedido; ?></td>
                                                <td><?php echo $guia; ?></td>
                                                <td><?php echo anchor('movimiento/captura/'.$row->movimientoID, 'Captura <i class="icon-barcode bigger-130"> </i>'); ?></td>
                                                <td><?php if($tipoMovimiento == 2) echo anchor('movimiento/transfer/'.$row->movimientoID.'/'.$this->movimiento_model->getAreaLimit1(), 'Transfer <i class="icon-barcode bigger-130"> </i>'); ?></td>
                                                <td><?php echo $embarque; ?></td>
                                                <td><?php echo $imprime; ?></td>
                                                <td><?php echo $factura; ?></td>
                                                <td><?php echo $folioFactura; ?></td>
                                                <td><?php echo $descargaXML; ?></td>
                                                <td><?php echo $descargaPDF; ?></td>
                                                <td><?php echo $fechaFactura; ?></td>
                                            </tr>
                                            <?php }?>
                                        </tbody>
                                    </table>
                                    
								</div>	
                            </div>
