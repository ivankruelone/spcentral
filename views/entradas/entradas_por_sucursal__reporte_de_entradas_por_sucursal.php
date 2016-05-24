							<div class="row-fluid">
                                <div class="span12">
                            
                                    <table id="ventas-table" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Sucursal</th>
                                                <th>Nombre de Sucursal</th>
                                                <th>Piezas</th>
                                                <th>Subtotal</th>
                                                <th>IVA</th>
                                                <th>Total</th>
                                                <th>Detalle</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            
                                            $cantidad = 0;
                                            $iva = 0;
                                            $subtotal = 0;
                                            
                                            foreach($query->result() as $row){
                                                
                                            ?>
                                            <tr>
                                                <td><?php echo $row->sucursal; ?></td>
                                                <td><?php echo $row->nombresucursal; ?></td>
                                                <td style="text-align: right;"><?php echo number_format($row->cantidad, 0); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($row->subtotal, 2); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($row->iva, 2); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($row->subtotal + $row->iva, 2); ?></td>
                                                <td style="text-align: center;"><?php echo anchor('entradas/entradas_por_sucursal__detalle_por_sucursal_y_proveedor/'.$row->sucursal.'/'.$fecha1.'/'.$fecha2, '<i class="icon-plus"></i>', array('class' => 'green')); ?></td>
                                            </tr>
                                            <?php 
                                            
                                                $cantidad = $cantidad + $row->cantidad;
                                                $iva = $iva + $row->iva;
                                                $subtotal = $subtotal + $row->subtotal;
                                                
                                            
                                            } 
                                            
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="2" style="text-align: right;">Totales</td>
                                                <td style="text-align: right;"><?php echo number_format($cantidad, 0); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($subtotal, 2); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($iva, 2); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($subtotal + $iva, 2); ?></td>
                                                <td>&nbsp;</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    
                            
                                </div>
                            </div>
