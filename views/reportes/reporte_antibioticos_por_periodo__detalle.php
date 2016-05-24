							<div class="row-fluid">
                                <div class="span12">
                            
                                    <table id="ventas-table" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>C.Barras</th>
                                                <th>Sustancia</th>
                                                <th>Medico</th>
                                                <th>Movimiento</th>
                                                <th>Piezas</th>
                                                <th>Mov. pasado</th>
                                                <th>Mov. actual</th>
                                                <th>Fecha</th>
                                                <th>Empleado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            
                                            foreach($query->result() as $row){
                                                
                                            ?>
                                            <tr>
                                                <td><?php echo $row->ean; ?></td>
                                                <td><?php echo $row->sustancia; ?></td>
                                                <td><?php echo $row->nombre_medico; ?></td>
                                                <td style="text-align: right;"><?php echo $row->movimiento; ?></td>
                                                <td style="text-align: right;"><?php echo $row->piezas; ?></td>
                                                <td style="text-align: right;"><?php echo $row->vieja; ?></td>
                                                <td style="text-align: right;"><?php echo $row->nueva; ?></td>
                                                <td style="text-align: right;"><?php echo $row->fecha; ?></td>
                                                <td style="text-align: right;"><?php echo $row->nombrecompleto; ?></td>
                                            </tr>
                                            <?php 
                                            
                                            
                                            } 
                                            
                                            ?>
                                        </tbody>
                                    </table>
                            
                                </div>
                            </div>
