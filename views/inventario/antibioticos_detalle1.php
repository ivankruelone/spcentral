							<div class="row-fluid">
                                <div class="span12">
                                    
                                    <table class="table table-condensed">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Clave</th>
                                                <th>Susa</th>
                                                <th>Descripcion</th>
                                                <th>Presentacion</th>
                                                <th>Detalle</th>
                                                <th>Lote</th>
                                                <th>Caducidad</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            
                                            foreach($query->result() as $row){
                                                
                                            
                                            ?>
                                            <tr>
                                                <td><?php echo $row->id; ?></td>
                                                <td><?php echo $row->cvearticulo; ?></td>
                                                <td><?php echo $row->susa; ?></td>
                                                <td><?php echo $row->descripcion; ?></td>
                                                <td><?php echo $row->pres; ?></td>
                                                <td><?php echo $row->lote; ?></td>
                                                <td><?php echo $row->caducidad; ?></td>
                                                <td><?php echo anchor('inventario/impresionAntibioticos/'.$row->id.'/'.$row->lote, 'Imprimir Reporte'); ?></td>
                                            </tr>
                                            <?php 
                                            
                                            
                                            }
                                            
                                            
                                            ?>
                                        </tbody>
                                    </table>
                                    
								</div>	
                            </div>
