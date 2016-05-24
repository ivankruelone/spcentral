							<div class="row-fluid">
                                <div class="span12">
                                
                                <p style="text-align: right;"><?php //echo anchor('metro/recetas_periodo_detalle_print/'.$fecha1.'/'.$fecha2.'/'.$sucursal.'/'.$idprograma, 'Version para imprimir', array('target' => '_blank')); ?></p>
                            
                                    <table id="ventas-table" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th># Sucursal</th>
                                                <th>Sucursal</th>
                                                <th>Suministro</th>
                                                <th>Surtidas</th>
                                                <th>Importe</th>
                                                <th>IVA</th>
                                                <th>Subtotal Medicamento</th>
                                                <th>Servicio</th>
                                                <th>IVA del servicio</th>
                                                <th>Subtotal Servicio</th>
                                                <th>Total</th>
                                             </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            
                                            $num = 0;
                                            $cantidadsurtida = 0;
                                            $req = 0;
                                            $total = 0;
                                            $iva = 0;
                                            $importe = 0;
                                            $servicio = 0;
                                            $servicioiva = 0;
                                            $totalservicio = 0;
                                            
                                            $total_total = 0;
                                            
                                            foreach($query->result() as $row){
                                            $num++;    
                                                
                                            
//r.fecha, r.cvepaciente, r.cveservicio, r.nombremedico, r.folioreceta, r.cvearticulo, r.descripcion, 
//r.tiporequerimiento, r.cantidadsurtida, a.precioven, r.cantidadsurtida * a.precioven as total, 
//a.preciocon, a.precioven - a.preciosinser as importedescuento, (a.precioven - a.preciosinser) * r.cantidadsurtida as subtotaldescuento,
// a.preciosinser * r.cantidadsurtida as importecondescuento, a.iva, a.preciosinser * r.cantidadsurtida + iva as total                                                
                                            ?>
                                            <tr>
                                                <td><?php echo $num; ?></td>
                                                <td><?php echo $row->cvecentrosalud; ?></td>
                                                <td><?php echo utf8_encode($row->descsucursal); ?></td>
                                                <td><?php echo $row->suministro; ?></td>
                                                <td style="text-align: right;"><?php echo number_format ($row->cantidadsurtida, 0); ?></td>
                                                <td style="text-align: right;"><?php echo number_format ($row->importe, 2); ?></td>
                                                <td style="text-align: right;"><?php echo number_format ($row->iva, 2); ?></td>
                                                <td style="text-align: right;"><?php echo number_format ($row->importe + $row->iva, 2); ?></td>
                                                <td style="text-align: right;"><?php echo number_format ($row->servicio, 2); ?></td>
                                                <td style="text-align: right;"><?php echo number_format ($row->servicioiva, 2); ?></td>
                                                <td style="text-align: right;"><?php echo number_format ($row->servicio + $row->servicioiva, 2); ?></td>
                                                <td style="text-align: right;"><?php echo number_format ($row->servicio + $row->servicioiva + $row->importe + $row->iva, 2); ?></td>
                                                </tr>
                                                
                                                
                                            <?php 
                                    
                                                $cantidadsurtida = $cantidadsurtida + $row->cantidadsurtida;
                                                $importe = $importe + $row->importe;
                                                $iva = $iva + $row->iva;
                                                $total = $total + $row->importe + $row->iva;
                                                
                                                $servicio = $servicio + $row->servicio;
                                                $servicioiva = $servicioiva + $row->servicioiva;
                                                $totalservicio = $totalservicio + $row->servicio + $row->servicioiva;
                                                
                                                $total_total =  $total_total + $row->importe + $row->iva + $row->servicio + $row->servicioiva;
                                            
                                            }
                                            
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="4" style="text-align: right;">Productos</td>
                                                <td style="text-align: right;"><?php echo number_format($cantidadsurtida, 0); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($importe, 2); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($iva, 2); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($total, 2); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($servicio, 2); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($servicioiva, 2); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($totalservicio, 2); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($total_total, 2); ?></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    
                            
                                </div>
                            </div>
