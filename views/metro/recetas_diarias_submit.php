							<div class="row-fluid">
                                <div class="span12">
                            
                                    <table id="ventas-table" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Nomina</th>
                                                <th>Usuario</th>
                                                <th>Recetas</th>
                                                <th>Registros</th>
                                                <th>Registros / Receta</th>
                                                <th>Piezas</th>
                                                <th>Saldo</th>
                                             </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            
                                            $num = 0;
                                            $cantidadsurtida = 0;
                                            $total = 0;
                                            $recetas = 0;
                                            $registros = 0;
                                            
                                            
                                            foreach($query->result() as $row){
                                            $num++;    
                                                
                                            
//r.fecha, r.cvepaciente, r.cveservicio, r.nombremedico, r.folioreceta, r.cvearticulo, r.descripcion, 
//r.tiporequerimiento, r.cantidadsurtida, a.precioven, r.cantidadsurtida * a.precioven as total, 
//a.preciocon, a.precioven - a.preciosinser as importedescuento, (a.precioven - a.preciosinser) * r.cantidadsurtida as subtotaldescuento,
// a.preciosinser * r.cantidadsurtida as importecondescuento, a.iva, a.preciosinser * r.cantidadsurtida + iva as total                                                
                                            ?>
                                            <tr>
                                                <td><?php echo $row->nomina; ?></td>
                                                <td><?php echo utf8_encode($row->nombreusuario); ?></td>
                                                <td style="text-align: right;"><?php echo number_format ($row->recetas, 0); ?></td>
                                                <td style="text-align: right;"><?php echo number_format ($row->registros, 0); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($row->registros / $row->recetas, 2); ?></td>
                                                <td style="text-align: right;"><?php echo number_format ($row->surtida, 0); ?></td>
                                                <td style="text-align: right;"><?php echo number_format ($row->saldo, 2); ?></td>
                                                </tr>
                                                
                                                
                                            <?php 
                                    
                                                $cantidadsurtida = $cantidadsurtida + $row->surtida;
                                                $total = $total + $row->saldo;
                                                $recetas = $recetas + $row->recetas;
                                                $registros = $registros + $row->registros;
                                            
                                            } 
                                            
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="2" style="text-align: right;">Totales</td>
                                                <td style="text-align: right;"><?php echo number_format($recetas, 0); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($registros, 0); ?></td>
                                                <td></td>
                                                <td style="text-align: right;"><?php echo number_format($cantidadsurtida, 0); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($total, 2); ?></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    
                            
                                </div>
                            </div>
