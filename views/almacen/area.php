							<div class="row-fluid">
                                <div class="span12">
                                    
                                    <p><?php echo anchor('almacen/area_nueva', 'Agrega una area'); ?></p>
                            
                                    <table id="table" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID Area</th>
                                                <th>Area</th>
                                                <th>Edita</th>
                                                <th>Agrega Pasillos</th>
                                                <th>Inventario</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($query->result() as $row){?>
                                            <tr>
                                                <td><?php echo $row->areaID; ?></td>
                                                <td><?php echo $row->area; ?></td>
                                                <td><?php echo anchor('almacen/area_edita/'.$row->areaID, 'Edita'); ?></td>
                                                <td><?php echo anchor('almacen/area_ver_pasillos/'.$row->areaID, 'Ver pasillos'); ?></td>
                                                <td><?php echo anchor('almacen/area_inventario/'.$row->areaID, 'Ver inventario'); ?></td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                            
                                </div>
                            </div>
