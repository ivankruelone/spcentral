							<div class="row-fluid">
                                <div class="span12">
                            
                                    <table id="ventas-table" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Sucursal</th>
                                                <th>Nombre de Sucursal</th>
                                                <th>Tickets</th>
                                                <th>Piezas</th>
                                                <th>IVA</th>
                                                <th>Costo</th>
                                                <th>Venta</th>
                                                <th>Dev.</th>
                                                <th>Importe</th>
                                                <th>Margen</th>
                                                <th>Ticket promedio</th>
                                                <th>Detalle</th>
                                                <th>EAN</th>
                                                <th>SEC</th>
                                                <th>Comision</th>
                                                <th>Por dia</th>
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
                                            $devolucionTotal = 0;
                                            
                                            foreach($query->result() as $row){
                                                
                                                if(isset($devolucion[$row->sucursal]))
                                                {
                                                    $devolucionMonto = $devolucion[$row->sucursal];
                                                }else{
                                                    $devolucionMonto = 0;
                                                }
                                                
                                            ?>
                                            <tr>
                                                <td><?php echo $row->sucursal; ?></td>
                                                <td><?php echo $row->nombresucursal; ?></td>
                                                <td style="text-align: right;"><?php echo number_format($row->tickets, 0); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($row->cantidad, 0); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($row->iva, 2); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($row->costo, 2); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($row->total, 2); ?></td>
                                                
                                                <td style="text-align: right;"><?php echo number_format($devolucionMonto, 2); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($row->total - $devolucionMonto, 2); ?></td>

                                                <td style="text-align: right;"><?php echo number_format(($row->total - $row->costo), 2); ?></td>
                                                <td style="text-align: right;"><?php echo number_format(($row->total / $row->tickets), 2); ?></td>
                                                <td style="text-align: center;"><?php echo anchor('ventas/ventas_por_sucursal__venta_por_sucursal/'.$row->sucursal.'/'.$fecha1.'/'.$fecha2, '<i class="icon-plus"></i>', array('class' => 'green')); ?></td>
                                                <td style="text-align: center;"><?php echo anchor('ventas/detalle_por_sucursal_ean/'.$row->sucursal.'/'.$fecha1.'/'.$fecha2, '<i class="icon-plus"></i>', array('class' => 'green', 'data-toggle' => 'modal')); ?></td>
                                                <td style="text-align: center;"><?php echo anchor('ventas/detalle_por_sucursal_sec/'.$row->sucursal.'/'.$fecha1.'/'.$fecha2, '<i class="icon-plus"></i>', array('class' => 'green', 'data-toggle' => 'modal')); ?></td>
                                                <td style="text-align: center;"><?php echo anchor('ventas/detalle_por_sucursal_comisionables/'.$row->sucursal.'/'.$fecha1.'/'.$fecha2, '<i class="icon-plus"></i>', array('class' => 'green', 'data-toggle' => 'modal')); ?></td>
                                                <td style="text-align: center;"><?php echo anchor('ventas/detalle_por_sucursal_por_dia/'.$row->sucursal.'/'.$fecha1.'/'.$fecha2, '<i class="icon-plus"></i>', array('class' => 'green', 'data-toggle' => 'modal')); ?></td>
                                            </tr>
                                            <?php 
                                            
                                                $devolucionTotal = $devolucionTotal + $devolucionMonto;
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
                                                <td colspan="2" style="text-align: right;">Totales</td>
                                                <td style="text-align: right;"><?php echo number_format($tickets, 0); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($cantidad, 0); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($iva, 2); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($costo, 2); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($total, 2); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($devolucionTotal, 2); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($total - $devolucionTotal, 2); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($margen, 2); ?></td>
                                                <td style="text-align: right;"><?php echo number_format(($total / $tickets), 2); ?></td>
                                                <td colspan="5">&nbsp;</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    
                            
                                </div>
                            </div>
