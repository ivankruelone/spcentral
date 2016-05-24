							<div class="row-fluid">
                                <div class="span12">
                                
                                    <table id="proveedores-table" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Menu</th>
                                                <th>Submenu</th>
                                                <th style="text-align: center;">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            
                                            foreach($query->result() as $row){
                                                
                                                if($row->opcion == null)
                                                {
                                                    $valor = FALSE;
                                                }else{
                                                    $valor = TRUE;
                                                }
                                                
                                                $data = array(
                                                    'name'        => 'opcion_'.$row->submenu,
                                                    'id'          => $row->submenuID,
                                                    'value'       => $usuario,
                                                    'checked'     => $valor,
                                                    'style'       => 'margin:10px',
                                                    );
                                            
                                            ?>
                                            <tr>
                                                <td><?php echo $row->menu; ?></td>
                                                <td><?php echo $row->submenu; ?></td>
                                                <td style="text-align: center;"><?php echo form_checkbox($data); ?></td>
                                            </tr>
                                            <?php 
                                            
                                            } 
                                            
                                            ?>
                                        </tbody>
                                    </table>
                                
                                </div>
                            </div>