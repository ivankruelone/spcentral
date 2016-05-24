							<div class="row-fluid">
                                <div class="span12">
                            
                                    <table id="ventas-table" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Sucursal</th>
                                                <th>Nombre de Sucursal</th>
                                                <th>Fecha</th>
                                                <th>Dia</th>
                                                <th>Tickets</th>
                                                <th>Piezas</th>
                                                <th>IVA</th>
                                                <th>Costo</th>
                                                <th>Importe</th>
                                                <th>Margen</th>
                                                <th>Ticket promedio</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            
                                            $cantidad = 0;
                                            $iva = 0;
                                            $total = 0;
                                            $costo = 0;
                                            $margen = 0;
                                            $tickets = 0;
                                            
                                            foreach($query->result() as $row){
                                                
                                            ?>
                                            <tr>
                                                <td><?php echo $row->sucursal; ?></td>
                                                <td><?php echo $row->nombresucursal; ?></td>
                                                <td><?php echo $row->fecha; ?></td>
                                                <td><?php echo dia_de_la_semana($row->dia); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($row->tickets, 0); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($row->cantidad, 0); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($row->iva, 2); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($row->costo, 2); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($row->total, 2); ?></td>
                                                <td style="text-align: right;"><?php echo number_format(($row->total - $row->costo), 2); ?></td>
                                                <td style="text-align: right;"><?php echo number_format(($row->total / $row->tickets), 2); ?></td>
                                            </tr>
                                            <?php 
                                            
                                                $cantidad = $cantidad + $row->cantidad;
                                                $iva = $iva + $row->iva;
                                                $total = $total + $row->total;
                                                $costo = $costo + $row->costo;
                                                $tickets = $tickets + $row->tickets;
                                                
                                                $margen = $margen + $row->total - $row->costo;
                                            
                                            } 
                                            
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="4" style="text-align: right;">Totales</td>
                                                <td style="text-align: right;"><?php echo number_format($tickets, 0); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($cantidad, 0); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($iva, 2); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($costo, 2); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($total, 2); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($margen, 2); ?></td>
                                                <td style="text-align: right;"><?php echo number_format(($total / $tickets), 2); ?></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    
                            
                                </div>
                            </div>
