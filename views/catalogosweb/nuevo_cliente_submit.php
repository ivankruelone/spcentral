							<div class="row-fluid">
                                <div class="span12">
                                    
                                    <?php echo MY_form_open('catalogosweb/nuevo_cliente_submit'); ?>
                                    
                                    <?php echo MY_form_input('busca', 'busca', 'Texto de busqueda', 'text', 'RFC o Razon Solcial', 6, false); ?>

                                    <?php echo MY_form_submit(); ?>
                                    
                                    <?php echo form_close(); ?>
                                    
								</div>	
                            </div>
                            

							<div class="row-fluid">
                                <div class="span12" id="resultado">
                                
                                </div>
                            </div>
                            
                            
                            <div class="row-fluid">
                                <div class="span12">
                                    
                                    
                                    <table class="table table-condensed">
                                        <thead>
                                            <tr>
                                                <th>RFC</th>
                                                <th>Razon Social</th>
                                                <th>Agregar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            
                                            if(!isset($query->error))
                                            {
                                                
                                                $n = 1;
                                                
                                                foreach($query as $row){
                                                    
                                                    
                                                
                                                ?>
                                                <tr>
                                                    <td id="clave_<?php echo $n; ?>"><?php echo $row->rfc; ?></td>
                                                    <td><?php echo $row->razon; ?></td>
                                                    <td style="text-align: center;"><?php echo anchor('catalogosweb/agregarCliente', 'Agregar', array('class' => 'agrega', 'id' => $n)) ?></td>
                                                </tr>
                                                <?php 
                                                
                                                    $n++;
                                                }
                                            
                                            }
                                            
                                            ?>
                                        </tbody>
                                    </table>
                                    
								</div>	
                            </div>
                            
