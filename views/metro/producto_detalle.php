							<div class="row-fluid">
                                <div class="span12">
                                
                                <p style="text-align: right;"><?php //echo anchor('metro/recetas_periodo_detalle_print/'.$fecha1.'/'.$fecha2.'/'.$sucursal.'/'.$idprograma, 'Version para imprimir', array('target' => '_blank')); ?></p>
                            
                                    <table id="ventas-table" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Clave Unidad</th>
                                                <th>Unidad</th>
                                                <th>Costo Unitario</th>
                                                <th>Solicitadas</th>
                                                <th>Surtidas</th>
                                                <th>Importe</th>
                                                <th>IVA</th>
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
                                            
                                            foreach($query->result() as $row){
                                            $num++;    
                                                
                                            
       //("r.cvearticulo, (r.descripcion || ' ' || r.presentacion) as descripcion, 
       //sum(r.cantidadsurtida), costounitario, sum(r.cantidadrequerida), 
       //sum(r.cantidadsurtida) * costounitario) as importe, CASE WHEN cvesuministro = '0' then 0 else 
       //sum(cantidadsurtida) * costounitario * 0.16 end as iva", false);
                                           ?>
                                            <tr>
                                                <td><?php echo $num; ?></td>
                                                <td><?php echo $row->clvsucursal; ?></td>
                                                <td><?php echo $row->descsucursal; ?></td>
                                                <td style="text-align: right;"><?php echo number_format ($row->costounitario, 2); ?></td>
                                                <td style="text-align: right;"><?php echo number_format ($row->requerida, 0); ?></td>
                                                <td style="text-align: right;"><?php echo number_format ($row->surtida, 0); ?></td>
                                                <td style="text-align: right;"><?php echo number_format ($row->importe, 2); ?></td>
                                                <td style="text-align: right;"><?php echo number_format ($row->iva, 2); ?></td>
                                                <td style="text-align: right;"><?php echo number_format ($row->importe + $row->iva, 2); ?></td>
                                                <td style="text-align: center;"><?php echo anchor('metro/producto_detalle_programa/'.$fecha1.'/'.$fecha2.'/'.$row->clvsucursal.'/'.$idprograma.'/'.$articulo, 'Detalle'); ?></td>                                                
                                                </tr>
                                                
                                                
                                            <?php 
                                    
                                                $cantidadsurtida = $cantidadsurtida + $row->surtida;
                                                $req = $req + $row->requerida;
                                                $importe = $importe + $row->importe;
                                                $iva = $iva + $row->iva;
                                                $total = $total + $row->importe + $row->iva;
                                            
                                            }
                                            
                                            $servicio = SERVICIO * $cantidadsurtida;
                                            $servicio_iva = SERVICIO * 0.16 * $cantidadsurtida;
                                            $servicio_total = $servicio + $servicio_iva;
                                            
                                            $total_general = $servicio_total + $total;
                                            
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="4" style="text-align: right;">Productos</td>
                                                <td style="text-align: right;"><?php echo number_format($req, 0); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($cantidadsurtida, 0); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($importe, 2); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($iva, 2); ?></td>
                                                <td style="text-align: right;" style="font-size: large;"><?php echo number_format($total, 2); ?></td>
                                            </tr>
                                            <tr>
                                                <td colspan="5" style="text-align: right;">Servicio</td>
                                                <td style="text-align: right;"><?php echo number_format($cantidadsurtida, 0); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($servicio, 2); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($servicio_iva, 2); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($servicio_total, 2); ?></td>
                                            </tr>
                                            <tr>
                                                <td colspan="8" style="text-align: right;">Total</td>
                                                <td style="text-align: right;"><?php echo number_format($total_general, 2); ?></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    
                            
                                </div>
                            </div>
