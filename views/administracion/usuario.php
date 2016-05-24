							<div class="row-fluid">
                                <div class="span12">
                            
                                    <p><?php echo anchor('administracion/usuario_nuevo', 'Agrega un usuario'); ?></p>

                                    <table id="proveedores-table" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nombre</th>
                                                <th>Puesto</th>
                                                <th>Clave</th>
                                                <th>Password</th>
                                                <th>Status</th>
                                                <th>Sucursal</th>
                                                <th colspan="2">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            
                                            $i = 1;
                                            foreach($query->result() as $row){
                                            
                                            ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $row->nombreusuario; ?></td>
                                                <td><?php echo $row->puesto; ?></td>
                                                <td><?php echo $row->clvusuario; ?></td>
                                                <td><?php echo $row->password; ?></td>
                                                <td class="center"><?php echo $row->estaactivo ?></td>
                                                <td><?php echo $row->descsucursal; ?></td>
                                                <td><?php echo anchor('administracion/usuario_edita/'.$row->usuario, 'Edita'); ?></td>
                                                <td><?php echo anchor('administracion/usuario_permisos/'.$row->usuario, 'Permisos'); ?></td>
                                            </tr>
                                            <?php 
                                            
                                            $i++;
                                            
                                            } 
                                            
                                            ?>
                                        </tbody>
                                    </table>
                            
                                </div>
                            </div>
