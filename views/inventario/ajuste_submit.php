							<div class="row-fluid">
                                <div class="span12">
                                
                                <?php
                                
                                $error = $this->session->flashdata('error');
                                if(strlen($error) >0){
                                
                                ?>
                                
                                <div class="alert alert-error">
										<button type="button" class="close" data-dismiss="alert">
											<i class="icon-remove"></i>
										</button>

										<strong>
											<i class="icon-remove"></i>
											Error !
										</strong>

										<?php echo $error; ?>
										<br />
                                </div>
                                    
                                    <?php
                                    
                                    }
                                    
                                    ?>

                                    <table class="table table-condensed">
                                        <thead>
                                            <tr>
                                                <th>Clave</th>
                                                <th>Nombre comercial</th>
                                                <th>Susa</th>
                                                <th>Descripcion</th>
                                                <th>Presentacion</th>
                                                <th>Lote</th>
                                                <th>Caducidad</th>
                                                <th style="text-align: right;">Cantidad</th>
                                                <th>EAN</th>
                                                <th>Marca</th>
                                                <th>Suministro</th>
                                                <th>Ubicacion</th>
                                                <th colspan="3">Edicion</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                
                                            $cantidad = 0;
                                            
                                            foreach($query->result() as $row){
                                                
                                                $edita_cantidad = anchor('inventario/cantidad/'.$row->inventarioID, 'Cantidad');
                                                
                                                
                                            
                                            ?>
                                            <tr>
                                                <td><?php echo $row->cvearticulo; ?></td>
                                                <td><?php echo $row->comercial; ?></td>
                                                <td><?php echo $row->susa; ?></td>
                                                <td><?php echo $row->descripcion; ?></td>
                                                <td><?php echo $row->pres; ?></td>
                                                <td><?php echo $row->lote; ?></td>
                                                <td><?php echo $row->caducidad; ?></td>
                                                <td style="text-align: right;"><?php echo number_format($row->cantidad, 0); ?></td>
                                                <td><?php echo $row->ean; ?></td>
                                                <td><?php echo $row->marca; ?></td>
                                                <td><?php echo $row->suministro; ?></td>
                                                <td><?php echo anchor('inventario/asigna_ubicacion/'.$row->inventarioID.'/'.$this->uri->segment(2), $row->pasilloID.'-'.$row->moduloID.'-'.$row->nivelID.'-'.$row->posicionID); ?></td>
                                                <td><?php echo $edita_cantidad; ?></td>
                                            </tr>
                                            <?php 
                                            
                                                $cantidad = $cantidad + $row->cantidad;
                                            
                                            }
                                            
                                            
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="7">Total</td>
                                                <td style="text-align: right;"><?php echo number_format($cantidad, 0); ?></td>
                                                <td colspan="6">&nbsp;</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    
								</div>	
                            </div>
