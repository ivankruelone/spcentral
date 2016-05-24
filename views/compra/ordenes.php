							<div class="row-fluid">
                                <div class="span12">
                                    
                                    <table class="table table-condensed">
                                        <caption>Registros: <?php echo count($query); ?></caption>
                                        <thead>
                                            <tr>
                                                <th>Folio de Provedor</th>
                                                <th># Provedor</th>
                                                <th>Provedor</th>
                                                <th>Captura</th>
                                                <th>Envio</th>
                                                <th>Limite</th>
                                                <th>Status</th>
                                                <th style="text-align: right; ">Pedido</th>
                                                <th style="text-align: right; ">Recibida</th>
                                                <th style="text-align: center; ">Ver detalle</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                
                                            foreach($query as $row){

                                                $color = '';
                                                $status = 'VENCIDA';
                                                

                                                if($row->aplica >= $row->cans)
                                                {
                                                    $color = ROJO;
                                                    $status = 'COMPLETA';
                                                }elseif($row->activa == 1)
                                                {
                                                    $color = VERDE;
                                                    $status = 'ACTIVA';
                                                }

                                            
                                            ?>
                                            <tr style="background-color: <?php echo $color; ?>">
                                                <td><?php echo $row->folprv; ?></td>
                                                <td><?php echo $row->prv; ?></td>
                                                <td><?php echo $row->razo; ?></td>
                                                <td><?php echo $row->fecha_captura; ?></td>
                                                <td><?php echo $row->fecha_envio; ?></td>
                                                <td><?php echo $row->fecha_limite; ?></td>
                                                <td><?php echo $status; ?></td>
                                                <td style="text-align: right; "><?php echo number_format($row->cans, 0); ?></td>
                                                <td style="text-align: right; "><?php echo number_format($row->aplica, 0); ?></td>
                                                <td style="text-align: center; "><?php echo anchor('compra/detalle_orden/' . $row->id_orden, 'Ver detalle'); ?></td>
                                            </tr>
                                            <?php 
                                            
                                            
                                            }
                                            
                                            
                                            ?>
                                        </tbody>
                                    </table>
                                    
								</div>	
                            </div>
