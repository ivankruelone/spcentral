							<div class="row-fluid">
                                <div class="span12">
                            
                                    <table id="ventas-table" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Folio Receta</th>
                                                <th>Unidad</th>
                                                <th>Clave Paciente</th>
                                                <th>Nombre</th>
                                                <th>Paterno</th>
                                                <th>Materno</th>
                                                <th>Clave Articulo</th> 
                                                <th>Susa</th>                                                                                           
                                                <th>Descripcion</th>
                                                <th>Presentacion</th>
                                                <th>Cantidad Requerida</th>
                                                <th>Cantidad Surtida</th>
                                                <th>Clave Medico</th>
                                                <th>Nombre Medico</th>
                                                <th>Programa</th>
                                                <th>Requerimiento</th>
                                                <th>Fecha Consulta</th>
                                                <th>Fecha Surtido</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            
                                            $cantidadsurtida = 0;
                                            $cantidadrequerida = 0;
                                            $num=0;
                                            
                                            foreach($query->result() as $row){
                                            $num++;    
                                            
                                                
                                            ?>
                                            <tr>
                                                <td><?php echo $num; ?></td>
                                                <td><?php echo $row->folioreceta; ?></td>
                                                <td><?php echo $row->descsucursal; ?></td>
                                                <td><?php echo $row->cvepaciente; ?></td>
                                                <td><?php echo ($row->nombre); ?></td>
                                                <td><?php echo ($row->apaterno); ?></td>
                                                <td><?php echo ($row->amaterno); ?></td>                                                                                              
                                                <td><?php echo ($row->cvearticulo); ?></td>
                                                <td><?php echo ($row->susa); ?></td>
                                                <td><?php echo ($row->descripcion); ?></td>
                                                <td><?php echo ($row->pres); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($row->canreq, 0); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($row->cansur, 0); ?></td>
                                                <td><?php echo ($row->cvemedico); ?></td>
                                                <td><?php echo ($row->nombremedico); ?></td>
                                                <td><?php echo ($row->programa); ?></td>
                                                <td><?php echo ($row->requerimiento); ?></td>
                                                <td><?php echo $row->fecha; ?></td>
                                                <td><?php echo $row->fechaexp; ?></td>
                                                </tr>
                                                
                                                
                                            <?php 
                                    
                                                $cantidadsurtida = $cantidadsurtida + $row->cansur;
                                                $cantidadrequerida = $cantidadrequerida + $row->canreq;
                                            
                                            } 
                                            
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="11" style="text-align: right;">Totales</td>
                                                <td style="text-align: right;"><?php echo number_format($cantidadrequerida, 0); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($cantidadsurtida, 0); ?></td>
                                                <td colspan="6">&nbsp;</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    
                            
                                </div>
                            </div>
