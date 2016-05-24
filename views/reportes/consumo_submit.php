							<div class="row-fluid">
                                <div class="span12">
                                
                                    <p><?php echo anchor('reportes/imprimeConsumo/'.$fecha1.'/'.$fecha2, 'Imprime el reporte');?></p>
                                
                                    <table class="table table-condensed">
                                    <caption>Reporte de consumos, periodo: <?php echo $fecha1; ?> al <?php echo $fecha2; ?></caption>
                                        <thead>
                                            <tr>
                                                <th>Clave</th>
                                                <th>Susa</th>
                                                <th>Descripcion</th>
                                                <th>Presentacion</th>
                                                <th style="text-align: right;">Cantidad Requerida</th>
                                                <th style="text-align: right;">Cantidad Surtida</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                
                                            $req = 0;
                                            $sur = 0;
                                            
                                            foreach($query->result() as $row){
                                                
                                                
                                            
                                            ?>
                                            <tr>
                                                <td><?php echo $row->cvearticulo; ?></td>
                                                <td><?php echo $row->susa; ?></td>
                                                <td><?php echo $row->descripcion; ?></td>
                                                <td><?php echo $row->pres; ?></td>
                                                <td style="text-align: right;"><?php echo number_format($row->canreq, 0); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($row->cansur, 0); ?></td>
                                            </tr>
                                            <?php 
                                            
                                                $req = $req + $row->canreq;
                                                $sur = $sur + $row->cansur;
                                            
                                            }
                                            
                                            
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="4">Total</td>
                                                <td style="text-align: right;"><?php echo number_format($req, 0); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($sur, 0); ?></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                
                                </div>
                            </div>