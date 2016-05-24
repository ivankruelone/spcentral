							<div class="row-fluid">
                                <div class="span12">
                                    
                                    <table id="proveedores-table" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th># Sucursal</th>
                                                <th>Sucursal</th>
                                                <th>Edita</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($query->result() as $row){?>
                                            <tr>
                                                <td><?php echo $row->clvsucursal; ?></td>
                                                <td><?php echo $row->descsucursal; ?></td>
                                                <td><?php echo anchor('catalogosweb/sucursal_edita/'.$row->clvsucursal, 'Edita'); ?></td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                            
                                </div>
                            </div>
