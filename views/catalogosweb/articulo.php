							<div class="row-fluid">
                                <div class="span12">
                                    
                                    <p><?php echo anchor('catalogosweb/nuevo_articulo', 'Nuevo articulo'); ?></p>
                                    
                                    <?php echo $this->pagination->create_links(); ?>
                                    
                                    <table class="table table-condensed">
                                        <caption>Registros: <?php echo $query->num_rows(); ?></caption>
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Clave</th>
                                                <th>Susa</th>
                                                <th>Descripcion</th>
                                                <th>Presentacion</th>
                                                <th>Venta x Unidad</th>
                                                <th>Unidades</th>
                                                <th>Antibiotico</th>
                                                <th>Clasificacion</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                
                                            foreach($query->result() as $row){
                                                
                                                $semaforo = '<i class="icon-circle" style="color: '.$row->semaforoColor.'"> ' . $row->semaforoDescripcion . '</i>';

                                            
                                            ?>
                                            <tr>
                                                <td><?php echo $row->id; ?></td>
                                                <td><?php echo $row->cvearticulo; ?></td>
                                                <td><?php echo $row->susa; ?></td>
                                                <td><?php echo $row->descripcion; ?></td>
                                                <td><?php echo $row->pres; ?></td>
                                                <td><?php echo $row->ventaxuni; ?></td>
                                                <td><?php echo $row->numunidades; ?></td>
                                                <td style="text-align: center;"><?php echo table_ok_cancel_element($row->antibiotico); ?></td>
                                                <td style="text-align: center;"><?php echo $semaforo; ?></td>
                                            </tr>
                                            <?php 
                                            
                                            
                                            }
                                            
                                            
                                            ?>
                                        </tbody>
                                    </table>
                                    
								</div>	
                            </div>
