							<div class="row-fluid">
                                <div class="span12">

                                    <table class="table table-condensed">
                                        <thead>
                                            <tr>
                                                <th>Clave</th>
                                                <th>Susa</th>
                                                <th>Descripcion</th>
                                                <th>Presentacion</th>
                                                <th style="text-align: right;">Demanda</th>
                                                <th style="text-align: right;">Inventario</th>
                                                <th style="text-align: right;">Pedido</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                
                                            $demanda = 0;
                                            $inventario = 0;
                                            $pedido = 0;
                                            
                                            foreach($query->result() as $row){
                                                
                                            
                                            ?>
                                            <tr>
                                                <td><?php echo $row->cvearticulo; ?></td>
                                                <td><?php echo $row->susa; ?></td>
                                                <td><?php echo $row->descripcion; ?></td>
                                                <td><?php echo $row->pres; ?></td>
                                                <td style="text-align: right;"><?php echo number_format($row->demanda, 0); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($row->inventario, 0); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($row->pedido, 0); ?></td>
                                            </tr>
                                            <?php 
                                            
                                                $demanda = $demanda + $row->demanda;
                                                $inventario = $inventario + $row->inventario;
                                                $pedido = $pedido + $row->pedido;
                                            
                                            }
                                            
                                            
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="4">Total</td>
                                                <td style="text-align: right;"><?php echo number_format($demanda, 0); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($inventario, 0); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($pedido, 0); ?></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    
								</div>	
                            </div>
