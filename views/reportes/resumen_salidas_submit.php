<div class="row-fluid">
                                <div class="span12">
                                    <table class="table table-condensed">
                                    <caption><?php  echo $subtitulo?></caption>
                                        <thead>
                                            <tr>
                                                <th style="text-align: center;">Facturas</th>
                                                <th style="text-align: center;">Claves</th>
                                                <th style="text-align: center;">Piezas</th>
                                                <th style="text-align: center;">Lotes</th>
                                                <th style="text-align: center;">Destino</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            
                                            foreach($query2->result() as $row){                                                
                                            ?>
                                            <tr>
                                                <td style="text-align: center;"><?php echo $row->folios; ?></td>
                                                <td style="text-align: center;"><?php echo $row->claves; ?></td>
                                                <td style="text-align: center;"><?php echo $row->piezas; ?></td>
                                                <td style="text-align: center;"><?php echo $row->lotes; ?></td>
                                                <td style="text-align: center;"><?php echo $row->sucdestino; ?></td>
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
                                                <th>Folio De Factura</th>
                                                <th>Clave</th>
                                                <th>Piezas</th>
                                                <th>Sustancia Activa</th>
                                                <th>Descripci&oacute;n</th>
                                                <th>Presentacion</th>
                                                <th>Lote</th>
                                                <th>Sucursal</th>
                                                
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
                                                <td><?php echo $row->descsucursal; ?></td>
                                            </tr>
                                            <?php 
             
                                            }
                                            
                                            
                                            ?>
                                        </tbody>

                                    </table>
                                
                                </div>
                            </div>