                                    
                                    <p><?php echo anchor('inventario/imprimeInventarioCaducidades/'.$caducidad, 'Imprimir inventario', array('target' => '_blank')); ?></p>
                                    
                                    <table class="table table-condensed">
                                        <thead>
                                            <tr>
                                                <th>Clave</th>
                                                <th>Nombre Comercial</th>
                                                <th>Susa</th>
                                                <th>Descripcion</th>
                                                <th>Presentacion</th>
                                                <th>Lote</th>
                                                <th>Caducidad</th>
                                                <th style="text-align: right;">Cantidad</th>
                                                <th>EAN</th>
                                                <th>Marca</th>
                                                <th>Suministro</th>
                                                <th colspan="3">Edicion</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                
                                            $cantidad = 0;
                                            
                                            foreach($query->result() as $row){
                                                
                                                if($this->session->userdata('nivel') == 3)
                                                {
                                                    $edita_datos = anchor('inventario/datos/'.$row->inventarioID, 'Datos');
                                                    $edita_cantidad = anchor('inventario/cantidad/'.$row->inventarioID, 'Cantidad');
                                                }else{
                                                    $edita_datos = anchor('inventario/datos/'.$row->inventarioID, 'Datos');
                                                    $edita_cantidad = null;
                                                }
                                                
                                                if($row->ventaxuni == 1 && $row->numunidades > 1)
                                                {
                                                    $convierte = anchor('inventario/convierte/'.$row->inventarioID, 'Convertir a piezas');
                                                }else{
                                                    $convierte = null;
                                                }
                                                
                                                
                                            
                                            ?>
                                            <tr>
                                                <td><?php echo $row->cvearticulo; ?></td>
                                                <td><?php echo $row->comercial; ?></td>
                                                <td><?php echo $row->susa; ?></td>
                                                <td><?php echo $row->descripcion; ?></td>
                                                <td><?php echo $row->pres; ?></td>
                                                <td><?php echo $row->lote; ?></td>
                                                <td><?php echo $row->caducidad; ?></td>
                                                <td style="text-align: right;"><?php echo number_format($row->cantidad, 0); ?></td>
                                                <td><?php echo $row->ean; ?></td>
                                                <td><?php echo $row->marca; ?></td>
                                                <td><?php echo $row->suministro; ?></td>
                                                <td><?php echo $edita_datos; ?></td>
                                                <td><?php echo $edita_cantidad; ?></td>
                                                <td><?php echo $convierte; ?></td>
                                            </tr>
                                            <?php 
                                            
                                                $cantidad = $cantidad + $row->cantidad;
                                            
                                            }
                                            
                                            
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="7">Total</td>
                                                <td style="text-align: right;"><?php echo number_format($cantidad, 0); ?></td>
                                                <td colspan="6">&nbsp;</td>
                                            </tr>
                                        </tfoot>
                                    </table>