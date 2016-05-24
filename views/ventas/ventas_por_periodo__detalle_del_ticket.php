							<div class="row-fluid">
                                <div class="span12">
                            
                                    <table id="ventas-table" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Ticket</th>
                                                <th>C.Barras</th>
                                                <th>Descripci&oacute;n</th>
                                                <th>Sustancia activa</th>
                                                <th>Precio/u</th>
                                                <th>Piezas</th>
                                                <th>Iva</th>
                                                <th>% Descuento</th>
                                                <th>Descuento</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            
                                            $piezas = 0;
                                            $iva = 0;
                                            $descuento = 0;
                                            $total = 0;
                                            
                                            foreach($query->result() as $row){
                                                
                                            ?>
                                            <tr>
                                                <td><?php echo $row->venta; ?></td>
                                                <td><?php echo $row->ean; ?></td>
                                                <td><?php echo $row->descripcion; ?></td>
                                                <td><?php echo $row->sustancia; ?></td>
                                                <td style="text-align: right;"><?php echo $row->precio; ?></td>
                                                <td style="text-align: right;"><?php echo $row->cantidad; ?></td>
                                                <td style="text-align: right;"><?php echo $row->iva; ?></td>
                                                <td style="text-align: right;"><?php echo $row->descuento_tasa; ?></td>
                                                <td style="text-align: right;"><?php echo $row->descuento; ?></td>
                                                <td style="text-align: right;"><?php echo $row->total; ?></td>
                                            </tr>
                                            <?php 
                                            
                                                $piezas = $piezas + $row->cantidad;
                                                $iva = $iva + $row->iva;
                                                $descuento = $descuento + $row->descuento;
                                                $total = $total + $row->total;
                                            
                                            } 
                                            
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="5" style="text-align: right;">Totales</td>
                                                <td style="text-align: right;"><?php echo number_format($piezas, 0); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($iva, 2); ?></td>
                                                <td style="text-align: right;"><?php echo $row->descuento_tasa; ?></td>
                                                <td style="text-align: right;"><?php echo number_format($descuento, 2); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($total, 2); ?></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                            
                                </div>
                            </div>
