							<div class="row-fluid">
                                <div class="span12">
                            
                                    <table id="ventas-table" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Secuencia</th>
                                                <th>Sustancia</th>
                                                <th>Precio</th>
                                                <th>Cantidad</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            
                                            $cantidad = 0;
                                            $total = 0;
                                            
                                            foreach($query->result() as $row){
                                                
                                            ?>
                                            <tr>
                                                <td style="text-align: right;"><?php echo $row->sec; ?></td>
                                                <td style="text-align: left;"><?php echo $row->sustancia; ?></td>
                                                <td style="text-align: right;"><?php echo $row->precio; ?></td>
                                                <td style="text-align: right;"><?php echo $row->cantidad; ?></td>
                                                <td style="text-align: right;"><?php echo $row->total; ?></td>
                                            </tr>
                                            <?php 
                                            
                                                $cantidad = $cantidad + $row->cantidad;
                                                $total = $total + $row->total;
                                            
                                            } 
                                            
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="3" style="text-align: right;">Totales</td>
                                                <td style="text-align: right;"><?php echo number_format($cantidad, 0); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($total, 2); ?></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    
                                   

									
						
							</div>
                            
                                </div>
                         
