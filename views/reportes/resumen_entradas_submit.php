<div class="row-fluid">
                                <div class="span12">
                                    <table class="table table-condensed">
                                    <caption><?php  echo $subtitulo?></caption>
                                        <thead>
                                            <tr>
                                                <th>Facturas</th>
                                                <th>Claves</th>
                                                <th>Piezas</th>
                                                <th>Lotes</th>
                                                <th>Proveedores</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            
                                            foreach($query2->result() as $row){                                                
                                            ?>
                                            <tr>
                                                <td><?php echo $row->folios; ?></td>
                                                <td><?php echo $row->claves; ?></td>
                                                <td><?php echo $row->piezas; ?></td>
                                                <td><?php echo $row->lotes; ?></td>
                                                <td><?php echo $row->proveedor; ?></td>
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
                                                <th>Piezas</th>
                                                <th>Sustancia Activa</th>
                                                <th>Descripcion</th>
                                                <th>Presentacion</th>
                                                <th>Lote</th>
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
                                                <td><?php echo $row->piezas; ?></td>
                                                <td><?php echo $row->susa; ?></td>
                                                <td><?php echo $row->descripcion; ?></td>
                                                <td><?php echo $row->pres; ?></td>
                                                <td><?php echo $row->lote; ?></td>
                                                <td><?php echo $row->razon; ?></td>
                                            </tr>
                                            <?php 
             
                                            }
                                            
                                            
                                            ?>
                                        </tbody>

                                    </table>
                                
                                </div>
                            </div>