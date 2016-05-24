							<div class="row-fluid">
                                <div class="span12">
                                    
                                    <p><?php echo anchor('catalogosweb/nuevo_cliente', 'Nuevo cliente'); ?></p>
                                    
                                    <table class="table table-condensed">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>RFC</th>
                                                <th>Razon Social</th>
                                                <th style="text-align: center;">Contratos</th>
                                                <th style="text-align: center;">Sucursales</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                
                                            foreach($query->result() as $row){
                                                

                                            
                                            ?>
                                            <tr>
                                                <td><?php echo $row->id; ?></td>
                                                <td><?php echo $row->rfc; ?></td>
                                                <td><?php echo $row->razon; ?></td>
                                                <td style="text-align: center;"><?php echo anchor('catalogosweb/contrato/'.$row->rfc, 'Contratos'); ?></td>
                                                <td style="text-align: center;"><?php echo anchor('catalogosweb/contrato_sucursal/'.$row->rfc, 'Sucursales'); ?></td>
                                            </tr>
                                            <?php 
                                            
                                            
                                            }
                                            
                                            
                                            ?>
                                        </tbody>
                                    </table>
                                    
								</div>	
                            </div>
