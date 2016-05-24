							<div class="row-fluid">
                                <div class="span12">
                                    
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Codigo</th>
                                        <th>Secuencia</th>
                                        <th>Clave</th>
                                        <th>Descripcion 1</th>
                                        <th>Descripcion 2</th>
                                        <th style="text-align: right; ">Costo</th>
                                        <th>IVA</th>
                                        <th style="text-align: right; ">Cantidad Pedida</th>
                                        <th style="text-align: right; ">Aplicada</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    if(is_array($query)){

                                        $cans = 0;
                                        $aplica = 0;

                                        foreach($query as $o){
                                    ?>
                                    <tr>
                                        <td><?php echo $o->codigo; ?></td>
                                        <td><?php echo $o->sec; ?></td>
                                        <td><?php echo $o->clagob; ?></td>
                                        <td><?php echo $o->susa1; ?></td>
                                        <td><?php echo $o->susa2; ?></td>
                                        <td style="text-align: right; "><?php echo number_format($o->costo, 2); ?></td>
                                        <td><?php echo $o->iva; ?></td>
                                        <td style="text-align: right; "><?php echo number_format($o->cans, 0); ?></td>
                                        <td style="text-align: right; "><?php echo number_format($o->aplica, 0); ?></td>
                                    </tr>
                                    <?php 

                                        $cans = $cans + $o->cans;
                                        $aplica = $aplica + $o->aplica;
                                    
                                        }
                                    }
                                    
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td style="text-align: right; " colspan="7">Totales</td>
                                        <td style="text-align: right; "><?php echo number_format($cans, 0); ?></td>
                                        <td style="text-align: right; "><?php echo number_format($aplica, 0); ?></td>
                                    </tr>
                                </tfoot>
                            </table>
                                    
								</div>	
                            </div>
