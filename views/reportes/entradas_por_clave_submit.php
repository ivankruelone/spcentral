<div class="row-fluid">
                                <div class="span12">
                                    <table class="table table-condensed">
                                    <caption><?php  echo $subtitulo?></caption>
                                        <thead>
                                            <tr>
                                                <th style="text-align: center;">Facturas</th>
                                                <th>Clave</th>
                                                <th>Descripci&oacute;n</th>
                                                <th style="text-align: center;">Lotes</th>
                                                <th style="text-align: center;">Caducidades</th>
                                                <th style="text-align: center;">Piezas</th>
                                                <th style="text-align: center;">Proveedores</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            
                                            foreach($query2->result() as $row){                                                
                                            ?>
                                            <tr>
                                                <td style="text-align: center;"><?php echo $row->facturas; ?></td>
                                                <td><?php echo $row->cvearticulo; ?></td>
                                                <td><?php echo $row->descripcion; ?></td>
                                                <td style="text-align: center;"><?php echo $row->lotes; ?></td>
                                                <td style="text-align: center;"><?php echo $row->caducidad; ?></td>
                                                <td style="text-align: center;"><?php echo $row->piezas; ?></td>
                                                <td style="text-align: center;"><?php echo $row->proveedor; ?></td>
                                            </tr>
                                            <?php 
             
                                            }
                                            
                                            
                                            ?>
                                        </tbody>

                                    </table>
                                
                                </div>
                            </div>



<div class="row-fluid">
                                <div class="span12">
                                    <table class="table table-condensed">
                                        <thead>
                                            <tr>
                                                <th>Folio Factura</th>
                                                <th>Clave</th>
                                                <th>Descripci&oacute;n</th>
                                                <th>Lote</th>
                                                <th>Caducidad</th>
                                                <th>Piezas</th>
                                                <th>Proveedor</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            
                                            foreach($query->result() as $row){                                                
                                            ?>
                                            <tr>
                                                <td><?php echo $row->referencia; ?></td>
                                                <td><?php echo $row->cvearticulo; ?></td>
                                                <td><?php echo $row->descripcion; ?></td>
                                                <td><?php echo $row->lote; ?></td>
                                                 <td><?php echo $row->caducidad; ?></td>
                                                <td><?php echo $row->piezas; ?></td>
                                                <td><?php echo $row->razon; ?></td>
                                            </tr>
                                            <?php 
             
                                            }
                                            
                                            
                                            ?>
                                        </tbody>

                                    </table>
                                
                                </div>
                            </div>