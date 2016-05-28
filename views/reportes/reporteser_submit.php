<div class="row-fluid">
                                <div class="span12">
                                
                                    <p><?php echo anchor('reportes/imprimeReporteEs/'.$fecha1.'/'.$fecha2.'/'.$area, 'Imprime el reporte');?></p>
                                
                                    <table class="table table-condensed table-hover">
                                    <caption><?php  echo $subtitulo?></caption>
                                        <thead>
                                            <tr>
                                                <th>Proveedor</th>
                                                <th>Clave</th>
                                                <th>Sustancia</th>
                                                <th>Lote</th>
                                                <th>Caducidad</th>
                                                <th>Costo</th>
                                                <th style="text-align: right;">Entrada </th>
                                                <th style="text-align: right;">Salida</th>
                                                <th style="text-align: right;">Restante</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $req = 0;
                                            $sur = 0;
                                            $res = 0;
                                            
                                            foreach($query->result() as $row){                                                
                                            ?>
                                            <tr>
                                                <td><?php echo $row->razon; ?></td>
                                                <td><?php echo $row->cvearticulo; ?></td>
                                                <td><?php echo $row->susa; ?></td>
                                                <td><?php echo $row->lote; ?></td>
                                                <td><?php echo $row->caducidad; ?></td>
                                                <td style="text-align: right;"><?php echo number_format($row->costo,2); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($row->entradas, 0); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($row->salidas, 0); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($row->cantidad, 0); ?></td>
                                            </tr>
                                            <?php 
                                            
                                                $req = $req + $row->entradas;
                                                $sur = $sur + $row->salidas;
                                                $res = $res + $row->cantidad;
                                                //$ress = $res + ($row->entra+$row->sale);
                                             
                                            }
                                            
                                            
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="6">Total</td>
                                                <td style="text-align: right;"><?php echo number_format($req, 0); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($sur, 0); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($res, 0); ?></td>
                                                
                                            </tr>
                                        </tfoot>
                                    </table>
                                
                                </div>
                            </div>