							<div class="row-fluid">
                                <div class="span12">
                                
                                    <p><?php echo anchor('reportes/imprimeNegado/'.$fecha1.'/'.$fecha2, 'Imprime el reporte');?></p>

                                    <table class="table table-condensed">
                                    <caption>Reporte de negados, periodo: <?php echo $fecha1; ?> al <?php echo $fecha2; ?></caption>
                                        <thead>
                                            <tr>
                                                <th>Clave</th>
                                                <th>Susa</th>
                                                <th>Descripcion</th>
                                                <th>Presentacion</th>
                                                <th style="text-align: right;">Negados</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                
                                            $neg = 0;
                                            
                                            foreach($query->result() as $row){
                                                
                                                
                                            
                                            ?>
                                            <tr>
                                                <td><?php echo $row->cvearticulo; ?></td>
                                                <td><?php echo $row->susa; ?></td>
                                                <td><?php echo $row->descripcion; ?></td>
                                                <td><?php echo $row->pres; ?></td>
                                                <td style="text-align: right;"><?php echo number_format($row->negado, 0); ?></td>
                                            </tr>
                                            <?php 
                                            
                                                $neg = $neg + $row->negado;
                                            
                                            }
                                            
                                            
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="4">Total</td>
                                                <td style="text-align: right;"><?php echo number_format($neg, 0); ?></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                
                                </div>
                            </div>