							<div class="row-fluid">
                                <div class="span12">
                                    
                                    <?php echo MY_form_open('catalogosweb/nuevo_articulo_submit'); ?>
                                    
                                    <?php echo MY_form_input('clave', 'clave', 'Clave', 'text', 'Clave', 3, false); ?>

                                    <?php echo MY_form_input('susa', 'susa', 'Sustancia', 'text', 'Sustancia', 6, false); ?>

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
                                
                                <?php if(PATENTE == 1){?>
                                    <table class="table table-condensed">
                                        <thead>
                                            <tr>
                                                <th>EAN</th>
                                                <th>Susa</th>
                                                <th>Descripcion</th>
                                                <th>Laboratorio</th>
                                                <th>origen</th>
                                                <th>IVA</th>
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
                                                    <td id="clave_<?php echo $n; ?>"><?php echo $row->ean; ?></td>
                                                    <td><?php echo $row->sustancia; ?></td>
                                                    <td><?php echo $row->descripcion; ?></td>
                                                    <td><?php echo $row->laboratorioProvisional; ?></td>
                                                    <td><?php echo $row->origen; ?></td>
                                                    <td><?php echo $row->iva; ?></td>
                                                    <td style="text-align: center;"><?php echo anchor('catalogosweb/agregarArticulo2', 'Agregar', array('class' => 'agrega2', 'id' => $n, 'origen' => $row->origen)) ?></td>
                                                </tr>
                                                <?php 
                                                
                                                    $n++;
                                                }
                                            
                                            }
                                            
                                            ?>
                                        </tbody>
                                    </table>

                                
                                <?php }else{?>
                                    
                                    
                                    <table class="table table-condensed">
                                        <thead>
                                            <tr>
                                                <th>Clave</th>
                                                <th>Susa</th>
                                                <th>Descripcion</th>
                                                <th>Presentacion</th>
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
                                                    <td id="clave_<?php echo $n; ?>"><?php echo $row->cvearticulo; ?></td>
                                                    <td><?php echo $row->susa; ?></td>
                                                    <td><?php echo $row->descripcion; ?></td>
                                                    <td><?php echo $row->pres; ?></td>
                                                    <td style="text-align: center;"><?php echo anchor('catalogosweb/agregarArticulo', 'Agregar', array('class' => 'agrega', 'id' => $n)) ?></td>
                                                </tr>
                                                <?php 
                                                
                                                    $n++;
                                                }
                                            
                                            }
                                            
                                            ?>
                                        </tbody>
                                    </table>
                                    
                                    <?php }?>
                                    
								</div>	
                            </div>
                            
