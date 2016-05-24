							<div class="row-fluid">
                                <div class="span12">
                                
                                <p style="text-align: right;"><?php //echo anchor('metro/recetas_periodo_detalle_print/'.$fecha1.'/'.$fecha2.'/'.$sucursal.'/'.$idprograma, 'Version para imprimir', array('target' => '_blank')); ?></p>
                            
                                    <table id="ventas-table" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Clave de articulo</th>
                                                <th>Sustancia</th>
                                                <th>Descripcion</th>
                                                <th>Presentacion</th>
                                                <th>Costo unitario</th>
                                                <th>Cantidad surtida</th>
                                                <th>Importe</th>
                                                <th>IVA Productos</th>
                                                <th>Subtotal Productos</th>
                                                <th>Servicio</th>
                                                <th>IVA del servicio</th>
                                                <th>Subtotal Servicio</th>
                                                <th>Total</th>
                                                <th>Cuidado</th>
                                                <th>Ver detalle</th>
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
                                            
                                            $cuidado = null;
                                            
                                            if($row->numunidades >= 50)
                                            {
                                                $cuidado = '<span style="color: red; ">ALTO</span>';
                                            }elseif($row->numunidades > 6 && $row->numunidades < 50)
                                            {
                                                $cuidado = '<span style="color: orange; ">MEDIO</span>';
                                            }elseif($row->numunidades <= 6)
                                            {
                                                $cuidado = '<span style="color: orange; ">BAJO</span>';
                                            }
                                            
//r.fecha, r.cvepaciente, r.cveservicio, r.nombremedico, r.folioreceta, r.cvearticulo, r.descripcion, 
//r.tiporequerimiento, r.cantidadsurtida, a.precioven, r.cantidadsurtida * a.precioven as total, 
//a.preciocon, a.precioven - a.preciosinser as importedescuento, (a.precioven - a.preciosinser) * r.cantidadsurtida as subtotaldescuento,
// a.preciosinser * r.cantidadsurtida as importecondescuento, a.iva, a.preciosinser * r.cantidadsurtida + iva as total                                                
                                            ?>
                                            <tr>
                                                <td><?php echo $num; ?></td>
                                                <td><?php echo $row->cvearticulo; ?></td>
                                                <td><?php echo utf8_encode($row->descripcion); ?></td>
                                                <td><?php echo utf8_encode($row->susa); ?></td>
                                                <td><?php echo utf8_encode($row->pres); ?></td>
                                                <td style="text-align: right;"><?php echo number_format ($row->precioven, 2); ?></td>
                                                <td style="text-align: right;"><?php echo number_format ($row->cantidadsurtida, 0); ?></td>
                                                <td style="text-align: right;"><?php echo number_format ($row->importe, 2); ?></td>
                                                <td style="text-align: right;"><?php echo number_format ($row->iva, 2); ?></td>
                                                <td style="text-align: right;"><?php echo number_format ($row->subtotal, 2); ?></td>
                                                <td style="text-align: right;"><?php echo number_format ($row->servicio, 2); ?></td>
                                                <td style="text-align: right;"><?php echo number_format ($row->servicioiva, 2); ?></td>
                                                <td style="text-align: right;"><?php echo number_format ($row->servicio + $row->servicioiva, 2); ?></td>
                                                <td style="text-align: right;"><?php echo number_format ($row->servicio + $row->servicioiva + $row->subtotal, 2); ?></td>
                                                <td style="text-align: center;"><?php echo $cuidado; ?></td>
                                                <td style="text-align: center;"><?php echo anchor('metro/concentrado_articulo_detalle_folio/'.$fecha1.'/'.$fecha2.'/'.$row->id, 'Detalle'); ?></td>
                                                </tr>
                                                
                                                
                                            <?php 
                                    
                                                $cantidadsurtida = $cantidadsurtida + $row->cantidadsurtida;
                                                $importe = $importe + $row->importe;
                                                $iva = $iva + $row->iva;
                                                $total = $total + $row->subtotal;
                                                
                                                $servicio = $servicio + $row->servicio;
                                                $servicioiva = $servicioiva + $row->servicioiva;
                                                $totalservicio = $totalservicio + $row->servicio + $row->servicioiva;
                                                
                                                $total_total =  $total_total + $row->subtotal + $row->servicio + $row->servicioiva;
                                            
                                            }
                                            
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="6" style="text-align: right;">Productos</td>
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
