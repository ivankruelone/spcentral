							<div class="row-fluid">
                            
                                <div class="span12">
                                
                                    <h2>Sucursal <?php echo $sucursalNombre; ?></h2>
                            
                                    <table id="por_codigo_de_barras-table" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Secuencia</th>
                                                <th>Sustancia</th>
                                                <th>Cantidad</th>
                                                <th>Precio</th>
                                                <th>Costo</th>
                                                <th>Venta</th>
                                                <th>Margen</th>
                                                <th>Linea</th>
                                                <th>Sublinea</th>
                                                <th>Antibiotico</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            
                                            $cantidad = 0;
                                            $total = 0;
                                            $costo = 0;
                                            $margen = 0;
                                            
                                            foreach($query->result() as $row){
                                            
                                            ?>
                                            <tr>
                                                <td><?php echo $row->sec; ?></td>
                                                <td><?php echo $row->sustancia; ?></td>
                                                <td style="text-align: right;"><?php echo number_format($row->cantidad, 0); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($row->precio, 2); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($row->costo, 2); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($row->total, 2); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($row->total - $row->costo, 2); ?></td>
                                                <td><?php echo $row->linea_desc; ?></td>
                                                <td><?php echo $row->sublinea_desc; ?></td>
                                                <td class="center"><?php echo table_ok_cancel_element($row->antibiotico); ?></td>
                                            </tr>
                                            <?php 
                                            
                                                $cantidad = $cantidad + $row->cantidad;
                                                $total = $total + $row->total;
                                                $costo = $costo + $row->costo;
                                                $margen = $margen + $row->total - $row->costo;
                                                
                                            } 
                                            
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="2" style="text-align: right;">Total</td>
                                                <td style="text-align: right;"><?php echo number_format($cantidad, 0); ?></td>
                                                <td>&nbsp;</td>
                                                <td style="text-align: right;"><?php echo number_format($costo, 2); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($total, 2); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($margen, 2); ?></td>
                                                <td colspan="4">&nbsp;</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    
                                </div>
                            
                            </div>
                            
