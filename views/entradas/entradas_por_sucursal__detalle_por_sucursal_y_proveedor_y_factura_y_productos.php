							<div class="row-fluid">
                                <div class="span12">
                            
                                    <table id="ventas-table" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Entrada</th>
                                                <th>Descripci&oacute;n</th>
                                                <th>Sustancia</th>
                                                <th>Cantidad</th>
                                                <th>Subtotal</th>
                                                <th>IVA</th>
                                                <th>Total</th>
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
                                                <td><?php echo $row->entrada; ?></td>
                                                <td><?php echo $row->descripcion; ?></td>
                                                <td><?php echo $row->sustancia; ?></td>
                                                <td style="text-align: right;"><?php echo number_format($row->cantidad, 0); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($row->subtotal, 2); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($row->iva, 2); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($row->subtotal + $row->iva, 2); ?></td>
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
                                                <td colspan="3" style="text-align: right;">Totales</td>
                                                <td style="text-align: right;"><?php echo number_format($cantidad, 0); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($subtotal, 2); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($iva, 2); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($subtotal + $iva, 2); ?></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    
                            
                                </div>
                            </div>
