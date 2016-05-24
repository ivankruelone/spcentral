							<div class="row-fluid">
                                <div class="span12">
                            
                                    <table id="ventas-table" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>UNIDAD MEDICA</th>
                                                <th>DOMICILIO</th>
                                                <th>JURISDICCION</th>
                                                <th>NOMBRE PACIENTE</th>
                                                <th>NUMERO DE AFILIACION</th>
                                                <th>FECHA RECETA</th>
                                                <th>FOLIO RECETA</th>
                                                <th>TIPO URARIO(PROGRAMA)</th>
                                                <th>NOMBRE MEDICO</th>
                                                <th>CEDULA PROFESIONAL</th>
                                                <th>CLAVE MEDICAMENTO O MATERIAL DE CURACION</th>
                                                <th>NOMBRE GENERICO MEDICAMENTO</th>
                                                <th>CANTIDAD SOLICITADA</th>
                                                <th>CANTIDAD SURTIDA</th>
                                                <th>COSTO POR PIEZA</th>
                                             </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            
                                            $num = 0;
                                            $cantidadsurtida = 0;
                                            $req = 0;
                                            $total = 0;
                                            $iva = 0;
                                            $importe = 0;
                                            
                                            foreach($query->result() as $row){
                                            $num++;    
                                                
                                            
//r.fecha, r.cvepaciente, r.cveservicio, r.nombremedico, r.folioreceta, r.cvearticulo, r.descripcion, 
//r.tiporequerimiento, r.cantidadsurtida, a.precioven, r.cantidadsurtida * a.precioven as total, 
//a.preciocon, a.precioven - a.preciosinser as importedescuento, (a.precioven - a.preciosinser) * r.cantidadsurtida as subtotaldescuento,
// a.preciosinser * r.cantidadsurtida as importecondescuento, a.iva, a.preciosinser * r.cantidadsurtida + iva as total                                                
                                            ?>
                                            <tr>
                                                <td><?php echo utf8_encode($row->descsucursal); ?></td>
                                                <td><?php echo utf8_encode($row->domicilio); ?></td>
                                                <td><?php echo $row->numjurisd; ?></td>
                                                <td><?php echo utf8_encode($row->nombre); ?></td>
                                                <td><?php echo $row->cvepaciente; ?></td>
                                                <td><?php echo $row->fecha; ?></td>
                                                <td><?php echo $row->folioreceta; ?></td>
                                                <td><?php echo $row->programa; ?></td>
                                                <td><?php echo utf8_encode($row->nombremedico); ?></td>
                                                <td><?php echo $row->cvemedico; ?></td>
                                                <td><?php echo $row->cvearticulo; ?></td>
                                                <td><?php echo $row->descripcion; ?></td>
                                                <td><?php echo $row->cantidadrequerida; ?></td>
                                                <td><?php echo $row->cantidadsurtida; ?></td>
                                                <td><?php echo $row->costounitario; ?></td>
                                                </tr>
                                                
                                                
                                            <?php 
                                    
                                                $cantidadsurtida = $cantidadsurtida + $row->cantidadsurtida;
                                                $req = $req + $row->cantidadrequerida;
                                                $importe = $importe + $row->importe;
                                                $iva = $iva + $row->iva;
                                                $total = $total + $row->importe + $row->iva;
                                            
                                            }
                                            
                                            $servicio = 8.55 * $cantidadsurtida;
                                            $servicio_iva = 8.55 * 0.16 * $cantidadsurtida;
                                            $servicio_total = $servicio + $servicio_iva;
                                            
                                            $total_general = $servicio_total + $total;
                                            
                                            ?>
                                        </tbody>
                                    </table>
                                    
                            
                                </div>
                            </div>
