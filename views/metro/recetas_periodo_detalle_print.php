							<div class="row-fluid">
                                <div class="span12">
                            
                                    <table id="ventas-table" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Fecha</th>
                                                <th># Sucursal</th>
                                                <th>Sucursal</th>
                                                <th>Clave Paciente</th>
                                                <th>Nombre</th>
                                                <th>Clave Medico</th>
                                                <th>Nombre Medico</th>
                                                <th>Tipo Receta</th>
                                                <th>Folio Receta</th>
                                                <th>Clave Articulo</th>
                                                <th>Descripcion</th>
                                                <th>Programa</th>
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
                                                
                                            
//r.fecha, r.cvepaciente, r.cveservicio, r.nombremedico, r.folioreceta, r.cvearticulo, r.descripcion, 
//r.tiporequerimiento, r.cantidadsurtida, a.precioven, r.cantidadsurtida * a.precioven as total, 
//a.preciocon, a.precioven - a.preciosinser as importedescuento, (a.precioven - a.preciosinser) * r.cantidadsurtida as subtotaldescuento,
// a.preciosinser * r.cantidadsurtida as importecondescuento, a.iva, a.preciosinser * r.cantidadsurtida + iva as total                                                
                                            ?>
                                            <tr>
                                                <td><?php echo $num; ?></td>
                                                <td><?php echo $row->fecha; ?></td>
                                                <td><?php echo $row->clvsucursal; ?></td>
                                                <td><?php echo utf8_encode($row->descsucursal); ?></td>
                                                <td><?php echo $row->cvepaciente; ?></td>
                                                <td><?php echo utf8_encode($row->nombre); ?></td>
                                                <td><?php echo $row->cvemedico; ?></td>
                                                <td><?php echo $row->nombremedico; ?></td>
                                                <td><?php echo $row->requerimiento; ?></td>
                                                <td><?php echo $row->folioreceta; ?></td>
                                                <td><?php echo $row->cvearticulo; ?></td>
                                                <td><?php echo $row->descripcion; ?></td>
                                                <td><?php echo $row->programa; ?></td>
                                                <td style="text-align: right;"><?php echo number_format ($row->costounitario, 2); ?></td>
                                                <td style="text-align: right;"><?php echo number_format ($row->cantidadrequerida, 0); ?></td>
                                                <td style="text-align: right;"><?php echo number_format ($row->cantidadsurtida, 0); ?></td>
                                                <td style="text-align: right;"><?php echo number_format ($row->importe, 2); ?></td>
                                                <td style="text-align: right;"><?php echo number_format ($row->iva, 2); ?></td>
                                                <td style="text-align: right;"><?php echo number_format ($row->importe + $row->iva, 2); ?></td>
                                                </tr>
                                                
                                                
                                            <?php 
                                    
                                                $cantidadsurtida = $cantidadsurtida + $row->cantidadsurtida;
                                                $req = $req + $row->cantidadrequerida;
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
                                                <td colspan="14" style="text-align: right;">Productos</td>
                                                <td style="text-align: right;"><?php echo number_format($req, 0); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($cantidadsurtida, 0); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($importe, 2); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($iva, 2); ?></td>
                                                <td style="text-align: right;" style="font-size: large;"><?php echo number_format($total, 2); ?></td>
                                            </tr>
                                            <tr>
                                                <td colspan="15" style="text-align: right;">Servicio</td>
                                                <td style="text-align: right;"><?php echo number_format($cantidadsurtida, 0); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($servicio, 2); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($servicio_iva, 2); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($servicio_total, 2); ?></td>
                                            </tr>
                                            <tr>
                                                <td colspan="18" style="text-align: right;">Total</td>
                                                <td style="text-align: right;"><?php echo number_format($total_general, 2); ?></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    
                            
                                </div>
                            </div>
