							<div class="row-fluid">
                                <div class="span12">
                                    
                                    <p><?php echo anchor('almacen/pasillo_nuevo/'.$areaID, 'Agrega un pasillo'); ?></p>
                            
                                    <table id="table" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID Area</th>
                                                <th>Area</th>
                                                <th>ID Pasillo</th>
                                                <th>Pasillo</th>
                                                <th>Tipo de Rack</th>
                                                <th>Tipo de Pasillo</th>
                                                <th>Sentido</th>
                                                <th>Posiciones</th>
                                                <th>Edita</th>
                                                <th>Agrega Pasillos</th>
                                                <th>Inventario</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            
                                            $posiciones = 0;
                                            
                                            foreach($query->result() as $row){
                                            
                                            ?>
                                            <tr>
                                                <td><?php echo $row->areaID; ?></td>
                                                <td><?php echo $row->area; ?></td>
                                                <td><?php echo $row->pasilloID; ?></td>
                                                <td><?php echo $row->pasillo; ?></td>
                                                <td><?php echo $row->rack; ?></td>
                                                <td><?php echo $row->pasilloTipoDescripcion; ?></td>
                                                <td><?php echo $row->sentidoDescripcion; ?></td>
                                                <td style="text-align: right;"><?php echo number_format($row->posiciones, 0); ?></td>
                                                <td><?php echo anchor('almacen/pasillo_edita/'.$row->areaID.'/'.$row->pasilloID, 'Edita'); ?></td>
                                                <td><?php echo anchor('almacen/area_modulo/'.$row->areaID.'/'.$row->pasilloID, 'Ver modulos'); ?></td>
                                                <td><?php echo anchor('almacen/area_modulo_inventario/'.$row->areaID.'/'.$row->pasilloID, 'Ver inventario'); ?></td>
                                            </tr>
                                            <?php 
                                            
                                            $posiciones = $posiciones + $row->posiciones;
                                            
                                            } 
                                            
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="7" style="text-align: right;">Total</td>
                                                <td style="text-align: right;"><?php echo number_format($posiciones, 0); ?></td>
                                                <td colspan="3">&nbsp;</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                            
                                </div>
                            </div>
