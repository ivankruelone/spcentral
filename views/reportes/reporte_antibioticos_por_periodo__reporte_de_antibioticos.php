							<div class="row-fluid">
                                <div class="span12">
                            
                                    <table id="ventas-table" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Secuencia</th>
                                                <th>C. Barras</th>
                                                <th>Sustancia</th>
                                                <th>Fecha</th>
                                                <th>Detalle</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            
                                           
                                            
                                            foreach($query->result() as $row){
                                                
                                            ?>
                                            <tr>
                                                <td><?php echo $row->sec; ?></td>
                                                <td><?php echo $row->ean; ?></td>
                                                <td><?php echo $row->sustancia; ?></td>
                                                <td><?php echo $row->fecha; ?></td>
                                                <td><?php echo anchor('reportes/reporte_antibioticos_por_periodo__detalle/'.$row->ean.'/'.$fecha1.'/'.$fecha2, '<i class="icon-plus"></i>', array('class' => 'green')); ?></td>
                                            </tr>
                                            <?php 
                                            
                                               
                                            } 
                                            
                                            ?>
                                        </tbody>
                                        
                                    </table>
                                    
                                   
                            
                                </div>
                            </div>
