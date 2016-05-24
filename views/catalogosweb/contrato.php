							<div class="row-fluid">
                                <div class="span12">
                                    
                                    <p><?php echo anchor('catalogosweb/nuevo_contrato/'.$rfc, 'Nuevo contrato'); ?></p>
                                    
                                    <table class="table table-condensed">
                                        <thead>
                                            <tr>
                                                <th>ID Contrato</th>
                                                <th>RFC</th>
                                                <th>Razon Social</th>
                                                <th>Denominacion</th>
                                                <th>Nombre Corto</th>
                                                <th style="text-align: center;" colspan="2">Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                
                                            foreach($query->result() as $row){
                                                

                                            
                                            ?>
                                            <tr>
                                                <td><?php echo $row->contratoID; ?></td>
                                                <td><?php echo $row->rfc; ?></td>
                                                <td><?php echo $row->razon; ?></td>
                                                <td><?php echo $row->numero; ?></td>
                                                <td><?php echo $row->denominado; ?></td>
                                                <td style="text-align: center;"><?php echo anchor('catalogosweb/contrato_editar/'.$rfc.'/'.$row->contratoID, 'Editar'); ?></td>
                                                <td style="text-align: center;"><?php echo anchor('catalogosweb/contrato_precios/'.$rfc.'/'.$row->contratoID, 'Precios'); ?></td>
                                            </tr>
                                            <?php 
                                            
                                            
                                            }
                                            
                                            
                                            ?>
                                        </tbody>
                                    </table>
                                    
								</div>	
                            </div>
