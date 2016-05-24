<?php
	$row2 = $query2->row();
?>
							<div class="row-fluid">
                                <div class="span12">
                                
                                    <ul class="unstyled spaced">
                                    
                                        <li>
                                            <i class="icon-bell purple"></i>
                                            Area: <?php echo $row2->areaID.' - '.$row2->area; ?>
                                        </li>

                                        <li>
                                            <i class="icon-star blue"></i>
                                            Pasillo: <?php echo $row2->pasilloID.' - '.$row2->pasillo; ?>
                                        </li>

                                        <li>
                                            <i class="icon-star green"></i>
                                            Rack: <?php echo $row2->rack; ?>
                                        </li>

                                        <li>
                                            <i class="icon-star red"></i>
                                            Tipo de Pasillo: <?php echo $row2->pasilloTipoDescripcion; ?>
                                        </li>

                                        <li>
                                            <i class="icon-star orange"></i>
                                            Sentido: <?php echo $row2->sentidoDescripcion; ?>
                                        </li>

                                    </ul>
                                    
                                    <p><?php echo anchor('almacen/modulo_nuevo/'.$areaID.'/'.$pasilloID, 'Agrega un modulo nuevo'); ?></p>

                                    <table id="table" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Modulo</th>
                                                <th>Posiciones</th>
                                                <th>Clonar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            
                                            $posiciones = 0;
                                            
                                            foreach($query->result() as $row){?>
                                            <tr>
                                                <td><?php echo $row->moduloID; ?></td>
                                                <td style="text-align: right;"><?php echo number_format($row->posiciones, 0); ?></td>
                                                <td><?php echo anchor('almacen/modulo_clona/'.$areaID.'/'.$pasilloID.'/'.$row->moduloID, 'Clonar', array('class' => 'clona')); ?></td>
                                            </tr>
                                            <?php 
                                            
                                            $posiciones = $posiciones + $row->posiciones;
                                            
                                            } 
                                            
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td>Total de posiciones</td>
                                                <td style="text-align: right;"><?php echo number_format($posiciones, 0); ?></td>
                                                <td colspan="2">&nbsp;</td>
                                            </tr>
                                        </tfoot>
                                    </table>

                                
                                </div>
                            </div>
                            
                            <div class="row-fluid">
                                <div class="span12">
                                
                                <?php echo $modulo; ?>
                                
                                <div id="dialog-message" class="hide">
										<p>
											Esta posici&oacute;n estara asociada con algun producto de tu catalogo.
										</p>

										<div class="hr hr-12 hr-double"></div>

										<p>
											<?php echo form_dropdown('idArticulo', $articulos, null, 'id="idArticulo"');?>
										</p>
                                        
                                        <p>
                                            <span id="cvearticulo" style="color: red;"></span>
                                            <span id="susa" style="color: blue;"></span>
                                            <span id="descripcion" style="color: green;"></span>
                                            <span id="pres" style="color: orange;"></span>
                                        </p>
                                        
                                        <p>
                                            Minimo: <br />
                                        
                                            <?php 
                                            $data = array(
                                              'name'        => 'minimo',
                                              'id'          => 'minimo',
                                              'type'        => 'number',
                                            );

                                            
                                            echo form_input($data);?>
                                        
                                        </p>

                                        <p>
                                            Maximo: <br />
                                        
                                            <?php 
                                            $data = array(
                                              'name'        => 'maximo',
                                              'id'          => 'maximo',
                                              'type'        => 'number',
                                            );

                                            
                                            echo form_input($data);?>
                                        
                                        </p>

									</div><!-- #dialog-message -->
                                
                                </div>
                            </div>
                            
                            