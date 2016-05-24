							<div class="row-fluid">
                                <div class="span12">
                                    
                                    <p><?php echo anchor('catalogosweb/proveedor_nuevo', 'Agrega un proveedor'); ?></p>
                            
                                    <table id="proveedores-table" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>RFC</th>
                                                <th>Razon Social</th>
                                                <th>Edita</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($query->result() as $row){?>
                                            <tr>
                                                <td><?php echo $row->rfc; ?></td>
                                                <td><?php echo $row->razon; ?></td>
                                                <td><?php echo anchor('catalogosweb/proveedor_edita/'.$row->proveedorID, 'Edita'); ?></td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                            
                                </div>
                            </div>
