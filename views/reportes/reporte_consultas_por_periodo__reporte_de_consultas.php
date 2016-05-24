<!-- consultas -->
                            <div class="row-fluid">
                                <div class="span12">
                                    <h1 style="text-align: center;">TOTAL DE CONSULTAS</h1>
                                    <table id="ventas-table" class="table table-striped table-bordered table-hover">
                                        <thead>
                                       
                                            <tr>
                                                <th>#</th>
                                                <th>Fecha</th>
                                                <th>Descripci&oacute;n</th>
                                                <th>Precio</th>
                                                <th>Medico</th>
                                                <th>Paciente</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $precio = 0;
                                           
                                            $n = 0;
                                            foreach($query->result() as $row){
                                               $n++;
                                                
                                            ?>
                                            <tr>
                                                <td><?php echo $n; ?></td>
                                                <td><?php echo $row->fecha; ?></td>
                                                <td><?php echo $row->descripcion; ?></td>
                                                <td style="text-align: right;">$ <?php echo $row->precio; ?></td>
                                                <td><?php echo $row->nombrecompleto; ?></td>
                                                <td><?php echo $row->paciente; ?></td>
                                            </tr>
                                            <?php 
                                            
                                            $precio = $precio + $row->precio;
                                               
                                            } 
                                            
                                            $total_consultas = $n;
                                            $total_consul = $precio;
                                            $total_consultas_meta = $n * 200;
                                            ?>
                                       </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="3" style="text-align: right;">Total</td>
                                                <td style="text-align: right;">$ <?php echo number_format($precio, 2); ?></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    
                                   
                            
                                </div>
                            </div>
                            
       <!-- canceladas -->
                                <div class="row-fluid">
                                <div class="span12">
                                    <h1 style="text-align: center;">TOTAL DE CONSULTAS CANCELADAS</h1>
                                    <table id="ventas-table" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Fecha</th>
                                                <th>Descripci&oacute;n</th>
                                                <th>Precio</th>
                                                <th>Medico</th>
                                                <th>Paciente</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            
                                           
                                            $n = 0;
                                            foreach($query1->result() as $row){
                                               $n++;
                                                
                                            ?>
                                            <tr>
                                                <td><?php echo $n; ?></td>
                                                <td><?php echo $row->fecha; ?></td>
                                                <td><?php echo $row->descripcion; ?></td>
                                                <td style="text-align: right;">$ <?php echo $row->precio; ?></td>
                                                <td><?php echo $row->nombrecompleto; ?></td>
                                                <td><?php echo $row->paciente; ?></td>
                                            </tr>
                                            <?php 
                                            
                                               
                                            } 
                                            
                                            ?>
                                        </tbody>
                                        
                                    </table>
                                    
                                   
                            
                                </div>
                            </div>
                            
       <!-- certificados medicos -->
                            <div class="row-fluid">
                                <div class="span12">
                                    <h1 style="text-align: center;">TOTAL DE CERTIFICADOS MEDICOS</h1>
                                    <table id="ventas-table" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Fecha</th>
                                                <th>Descripci&oacute;n</th>
                                                <th>Precio</th>
                                                <th>Medico</th>
                                                <th>Paciente</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $precio = 0;
                                           
                                            $n = 0;
                                            foreach($query2->result() as $row){
                                               $n++;
                                                
                                            ?>
                                            <tr>
                                                <td><?php echo $n; ?></td>
                                                <td><?php echo $row->fecha; ?></td>
                                                <td><?php echo $row->descripcion; ?></td>
                                                <td style="text-align: right;">$ <?php echo $row->precio; ?></td>
                                                <td><?php echo $row->nombrecompleto; ?></td>
                                                <td><?php echo $row->paciente; ?></td>
                                            </tr>
                                            <?php 
                                            
                                            $precio = $precio + $row->precio;
                                               
                                            } 
                                            
                                            $total_examen = $n;
                                            $total_examen_me = $precio;
                                            $total_medico = $n * 15;
                                            ?>
                                       </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="3" style="text-align: right;">Total</td>
                                                <td style="text-align: right;">$ <?php echo number_format($precio, 2); ?></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    
                                   
                            
                                </div>
                            </div>
                            
       <!-- toma presion -->
                            <div class="row-fluid">
                                <div class="span12">
                                    <h1 style="text-align: center;">TOTAL TOMA DE PRESION</h1>
                                    <table id="ventas-table" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Fecha</th>
                                                <th>Descripci&oacute;n</th>
                                                <th>Precio</th>
                                                <th>Medico</th>
                                                <th>Paciente</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $precio = 0;
                                           
                                            $n = 0;
                                            foreach($query7->result() as $row){
                                               $n++;
                                                
                                            ?>
                                            <tr>
                                                <td><?php echo $n; ?></td>
                                                <td><?php echo $row->fecha; ?></td>
                                                <td><?php echo $row->descripcion; ?></td>
                                                <td style="text-align: right;">$ <?php echo $row->precio; ?></td>
                                                <td><?php echo $row->nombrecompleto; ?></td>
                                                <td><?php echo $row->paciente; ?></td>
                                            </tr>
                                            <?php 
                                            
                                            $precio = $precio + $row->precio;
                                               
                                            } 
                                            
                                            $total_presion = $n;
                                            $total_presion_me = $precio;
                                            $total_medico_pre = $n * 9;
                                            ?>
                                       </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="3" style="text-align: right;">Total</td>
                                                <td style="text-align: right;">$ <?php echo number_format($precio, 2); ?></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    
                                   
                            
                                </div>
                            </div>
                            
<!-- aplicar inyeccion -->
                            <div class="row-fluid">
                                <div class="span12">
                                    <h1 style="text-align: center;">TOTAL DE APLICACI&Oacute;N DE INYECCI&Oacute;N</h1>
                                    <table id="ventas-table" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Fecha</th>
                                                <th>Descripci&oacute;n</th>
                                                <th>Precio</th>
                                                <th>Medico</th>
                                                <th>Paciente</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $precio = 0;
                                           
                                            $n = 0;
                                            foreach($query8->result() as $row){
                                               $n++;
                                                
                                            ?>
                                            <tr>
                                                <td><?php echo $n; ?></td>
                                                <td><?php echo $row->fecha; ?></td>
                                                <td><?php echo $row->descripcion; ?></td>
                                                <td style="text-align: right;">$ <?php echo $row->precio; ?></td>
                                                <td><?php echo $row->nombrecompleto; ?></td>
                                                <td><?php echo $row->paciente; ?></td>
                                            </tr>
                                            <?php 
                                            
                                            $precio = $precio + $row->precio;
                                               
                                            } 
                                            
                                            $total_iny = $n;
                                            $total_iny_me = $precio;
                                            $total_medico_iny = $n * 9;
                                            ?>
                                       </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="3" style="text-align: right;">Total</td>
                                                <td style="text-align: right;">$ <?php echo number_format($precio, 2); ?></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    
                                   
                            
                                </div>
                            </div>
                            
<!-- TOMA DE GLUCOSA -->
                            <div class="row-fluid">
                                <div class="span12">
                                    <h1 style="text-align: center;">TOTAL DE TOMA DE GLUCOSA</h1>
                                    <table id="ventas-table" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Fecha</th>
                                                <th>Descripci&oacute;n</th>
                                                <th>Precio</th>
                                                <th>Medico</th>
                                                <th>Paciente</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $precio = 0;
                                           
                                            $n = 0;
                                            foreach($query9->result() as $row){
                                               $n++;
                                                
                                            ?>
                                            <tr>
                                                <td><?php echo $n; ?></td>
                                                <td><?php echo $row->fecha; ?></td>
                                                <td><?php echo $row->descripcion; ?></td>
                                                <td style="text-align: right;">$ <?php echo $row->precio; ?></td>
                                                <td><?php echo $row->nombrecompleto; ?></td>
                                                <td><?php echo $row->paciente; ?></td>
                                            </tr>
                                            <?php 
                                            
                                            $precio = $precio + $row->precio;
                                               
                                            } 
                                            
                                            $total_glu = $n;
                                            $total_glu_me = $precio;
                                            $total_medico_glu = $n * 12;
                                            ?>
                                       </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="3" style="text-align: right;">Total</td>
                                                <td style="text-align: right;">$ <?php echo number_format($precio, 2); ?></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    
                                   
                            
                                </div>
                            </div>
                            
      <!-- venta total -->
                            <div class="row-fluid">
                                <div class="span12">
                                    <h1 style="text-align: center;">VENTA TOTAL DE CONSULTAS</h1>
                                    <table id="ventas-table" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Fecha</th>
                                                <th>Descripci&oacute;n</th>
                                                <th>Medico</th>
                                                <th>Paciente</th>
                                                <th>Ticket</th>
                                                <th>Precio total Ticket</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $precio = 0;
                                           
                                            $n = 0;
                                            foreach($query3->result() as $row){
                                               $n++;
                                                
                                            ?>
                                            <tr>
                                                <td><?php echo $n; ?></td>
                                                <td><?php echo $row->fecha; ?></td>
                                                <td><?php echo $row->descripcion; ?></td>
                                                <td><?php echo $row->nombrecompleto; ?></td>
                                                <td><?php echo $row->paciente; ?></td>
                                                <td><?php echo $row->ticket; ?></td>
                                                <td style="text-align: right;">$ <?php echo $row->total_t; ?></td>
                                                
                                                
                                            </tr>
                                            <?php 
                                            
                                            $precio = $precio + $row->total_t;
                                               
                                            } 
                                            
                                            $total_recetas=$precio;
                                           
                                            ?>
                                       </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="6" style="text-align: right;">Total</td>
                                                <td style="text-align: right;">$ <?php echo number_format($precio, 2); ?></td>
                                                
                                            </tr>
                                        </tfoot>
                                    </table>
                                    
                                   
                            
                                </div>
                            </div>
                            
      <!-- venta gontor -->
                            <div class="row-fluid">
                                <div class="span12">
                                    <h1 style="text-align: center;">VENTAS GONTOR</h1>
                                    <table id="ventas-table" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Fecha</th>
                                                <th>Descripci&oacute;n</th>
                                                <th>Medico</th>
                                                <th>Paciente</th>
                                                <th>Ticket</th>
                                                <th>Precio total Ticket</th>
                                                <th>Tipo</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $precio = 0;
                                           
                                            $n = 0;
                                            foreach($query4->result() as $row){
                                               $n++;
                                                
                                            ?>
                                            <tr>
                                                <td><?php echo $n; ?></td>
                                                <td><?php echo $row->fecha; ?></td>
                                                <td><?php echo $row->descripcion; ?></td>
                                                <td><?php echo $row->nombrecompleto; ?></td>
                                                <td><?php echo $row->paciente; ?></td>
                                                <td><?php echo $row->ticket; ?></td>
                                                <td style="text-align: right;">$ <?php echo $row->total_g; ?></td>
                                                <td><?php echo $row->sublinea_desc; ?></td>
                                                
                                            </tr>
                                            <?php 
                                            
                                            $precio = $precio + $row->total_g;
                                               
                                            } 
                                            $total_gontor=$precio;
                                            $porcentaje_gontor=$total_gontor/$total_consultas;
                                            ?>
                                       </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="6" style="text-align: right;">Total</td>
                                                <td style="text-align: right;">$ <?php echo number_format($precio, 2); ?></td>
                                                <td style="text-align: right;">% <?php echo number_format($porcentaje_gontor,2); ?> </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                            
                                </div>
                            </div>
          
          <!-- venta imperial -->
                            <div class="row-fluid">
                                <div class="span12">
                                    <h1 style="text-align: center;">VENTAS IMPERIAL</h1>
                                    <table id="ventas-table" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Fecha</th>
                                                <th>Descripci&oacute;n</th>
                                                <th>Medico</th>
                                                <th>Paciente</th>
                                                <th>Ticket</th>
                                                <th>Precio total Ticket</th>
                                                <th>Tipo</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $precio = 0;
                                           
                                            $n = 0;
                                            foreach($query5->result() as $row){
                                               $n++;
                                                
                                            ?>
                                            <tr>
                                                <td><?php echo $n; ?></td>
                                                <td><?php echo $row->fecha; ?></td>
                                                <td><?php echo $row->descripcion; ?></td>
                                                <td><?php echo $row->nombrecompleto; ?></td>
                                                <td><?php echo $row->paciente; ?></td>
                                                <td><?php echo $row->ticket; ?></td>
                                                <td style="text-align: right;">$ <?php echo $row->total_g; ?></td>
                                                <td><?php echo $row->sublinea_desc; ?></td>
                                                
                                            </tr>
                                            <?php 
                                            
                                            $precio = $precio + $row->total_g;
                                               
                                            } 
                                            
                                            $total_imperial=$precio;
                                            $porcentaje_imperial=$total_imperial/$total_consultas;
                                            ?>
                                       </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="6" style="text-align: right;">Total</td>
                                                <td style="text-align: right;">$ <?php echo number_format($precio, 2); ?></td>
                                                <td style="text-align: right;">% <?php echo number_format($porcentaje_imperial,2); ?> </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                            
                                </div>
                            </div>
                            
      <!-- venta naturistas -->
                            <div class="row-fluid">
                                <div class="span12">
                                    <h1 style="text-align: center;">VENTAS COMISIONABLES</h1>
                                    <table id="ventas-table" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Fecha</th>
                                                <th>Medico</th>
                                                <th>Ticket</th>
                                                <th>C. Barras</th>
                                                <th>Descripci&oacute;n</th>
                                                <th>Precio total</th>
                                                <th>Tipo</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $precio = 0;
                                           
                                            $n = 0;
                                            foreach($query6->result() as $row){
                                               $n++;
                                                
                                            ?>
                                            <tr>
                                                <td><?php echo $n; ?></td>
                                                <td><?php echo $row->fecha; ?></td>
                                                <td><?php echo $row->nombrecompleto; ?></td>
                                                <td><?php echo $row->ticket; ?></td>
                                                <td><?php echo $row->ean; ?></td>
                                                <td><?php echo $row->descripcion; ?></td>
                                                <td style="text-align: right;">$ <?php echo $row->total; ?></td>
                                                <td><?php echo $row->sublinea_desc; ?></td>
                                                
                                            </tr>
                                            <?php 
                                            
                                            $precio = $precio + $row->total;
                                               
                                            } 
                                            
                                            ?>
                                       </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="6" style="text-align: right;">Total</td>
                                                <td style="text-align: right;">$ <?php echo number_format($precio, 2); ?></td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                            
                                </div>
                            </div>
                        
<!-- reporte general -->
                            <div class="row-fluid">
                                <div class="span12">
                                    <h1 style="text-align: center;">Reporte general</h1>
                                    <table id="ventas-table" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Consultas</th>
                                                <th>Meta</th>
                                                <th>Total Venta</th>
                                                <th>Total % Gontor/Imperial</th>
                                                <th>Total para el Medico</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          
                                            <tr>
                                                <td  style="text-align: right;"><?php echo $total_consultas; ?></td>
                                                <td  style="text-align: right;">$<?php echo number_format($total_consultas_meta, 2); ?></td>
                                                <td  style="text-align: right;">$<?php echo number_format($total_recetas, 2); ?></td>
                                                <td  style="text-align: right;"><?php echo number_format($porcentaje_gontor + $porcentaje_imperial, 2); ?></td>
                                                <td  style="text-align: right;">$<?php echo number_format($total_consul, 2); ?></td>
                                            </tr>
                                          
                                       </tbody>
                                       
                                    </table>
                                    
                                    <table id="ventas-table" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Examen Medico</th>
                                                <th>Total x Examen Medico</th>
                                                <th>Total para el Medico</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          
                                            <tr>
                                                <td  style="text-align: right;"><?php echo $total_examen; ?></td>
                                                <td  style="text-align: right;">$<?php echo number_format($total_examen_me, 2); ?></td>
                                                <td  style="text-align: right;">$<?php echo number_format($total_medico, 2); ?></td>
                                            </tr>
                                          
                                       </tbody>
                                       
                                    </table>
                                    
                                     <table id="ventas-table" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Toma de Presion</th>
                                                <th>Total x Toma de Presion</th>
                                                <th>Total para el Medico</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          
                                            <tr>
                                                <td  style="text-align: right;"><?php echo $total_presion; ?></td>
                                                <td  style="text-align: right;">$<?php echo number_format($total_presion_me, 2); ?></td>
                                                <td  style="text-align: right;">$<?php echo number_format($total_medico_pre, 2); ?></td>
                                            </tr>
                                          
                                       </tbody>
                                       
                                    </table>
                                    
                                    <table id="ventas-table" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Aplicaci&oacute;n de Inyecci&oacute;n</th>
                                                <th>Total x Aplicaci&oacute;n de Inyecci&oacute;n</th>
                                                <th>Total para el Medico</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          
                                            <tr>
                                                <td  style="text-align: right;"><?php echo $total_iny; ?></td>
                                                <td  style="text-align: right;">$<?php echo number_format($total_iny_me, 2); ?></td>
                                                <td  style="text-align: right;">$<?php echo number_format($total_medico_iny, 2); ?></td>
                                            </tr>
                                          
                                       </tbody>
                                       
                                    </table>
                                    
                                    <table id="ventas-table" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Toma de Glucosa</th>
                                                <th>Total x Toma de Glucosa</th>
                                                <th>Total para el Medico</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          
                                            <tr>
                                                <td  style="text-align: right;"><?php echo $total_glu; ?></td>
                                                <td  style="text-align: right;">$<?php echo number_format($total_glu_me, 2); ?></td>
                                                <td  style="text-align: right;">$<?php echo number_format($total_medico_glu, 2); ?></td>
                                            </tr>
                                          
                                       </tbody>
                                       
                                    </table>

                            
                                </div>
                            </div>
                            
                            
                            
                           