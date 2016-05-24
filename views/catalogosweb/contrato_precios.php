<?php
	$row2 = $query2->row();
?>
							<div class="row-fluid">
                                <div class="span12">
                                    
                                    <p><?php echo $row2->rfc; ?></p>
                                    <p><?php echo $row2->razon; ?></p>
                                    <p><?php echo $row2->numero; ?></p>
                                    <p><?php echo $row2->denominado; ?></p>
                                    
                                    <table class="table table-condensed">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Clave</th>
                                                <th>Susa</th>
                                                <th>Descripcion</th>
                                                <th>Presentacion</th>
                                                <th>Precio para este contrato</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                
                                            foreach($query->result() as $row){
                                                
                                                $data = array(
                                                  'name'        => 'precio_'.$row->contratoPrecioID,
                                                  'id'          => $row->contratoPrecioID,
                                                  'value'       => $row->precioContrato,
                                                  'maxlength'   => '10',
                                                );
                                    
                                               
                                                
                                            ?>
                                            <tr>
                                                <td><?php echo $row->id; ?></td>
                                                <td><?php echo $row->cvearticulo; ?></td>
                                                <td><?php echo $row->susa; ?></td>
                                                <td><?php echo $row->descripcion; ?></td>
                                                <td><?php echo $row->pres; ?></td>
                                                <td><?php echo form_input($data); ?></td>
                                            </tr>
                                            <?php 
                                            
                                            
                                            }
                                            
                                            
                                            ?>
                                        </tbody>
                                    </table>
                                    
								</div>	
                            </div>
