<?php
	$error = $this->session->flashdata('error');
    
    if(strlen($error) > 0)
    {
        
?>
<div class="alert alert-error">
    <button type="button" class="close" data-dismiss="alert">
        <i class="icon-remove"></i>
    </button>

    <strong>
        <i class="icon-remove"></i>
        Error!
    </strong>

    <?php echo $error; ?>
    <br />
</div>

<?php
	}
?>

<?php
	$row = $query->row();
    
    if($row->orden > 0)
    {
        $orden = $this->util->getDataOficina('ordenDetalle', array('folprv' => $row->orden));
    }else{
        $orden = null;
    }
    
?>
                            <div class="row-fluid">
                                <div class="span12">
                                
                                    <?php
                                    
                                    if($row->statusMovimiento == 0){
                                    
                                    ?>
                                
                                    <p style="text-align: left;"><?php echo anchor('movimiento/cierre/'.$row->movimientoID.'/'.$row->tipoMovimiento.'/'.$row->subtipoMovimiento, 'Cerrar este movimiento', array('id' => 'cierre')); ?></p>
                                    
                                    <?php
                                    
                                    echo form_hidden('subtipoMovimiento', $row->subtipoMovimiento);
                                    
                                    
                                    }
                                    
                                    $atts = array(
                                      'width'      => '800',
                                      'height'     => '100',
                                      'scrollbars' => 'no',
                                      'status'     => 'no',
                                      'resizable'  => 'no',
                                      'screenx'    => '0',
                                      'screeny'    => '0'
                                    );

                                    ?>
                                    
                                
                                    <table class="table table-condensed">
                                        <thead>
                                            <tr>
                                                <th>Movimiento</th>
                                                <th>Tipo de Movimiento</th>
                                                <th>Subtipo de Movimiento</th>
                                                <th>Orden</th>
                                                <th>Referencia</th>
                                                <th>Fecha</th>
                                                <th>Proveedor</th>
                                                <th>Sucursal</th>
                                                <th>Sucursal Referencia</th>
                                                <th>Usuario</th>
                                                <th>Alta/Cierre/Baja</th>
                                                <th>Observaciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td id="movimientoID"><?php echo $row->movimientoID;?></td>
                                                <td><?php echo $row->tipoMovimientoDescripcion;  if(PATENTE == 1){ echo "<br />"; echo anchor_popup('movimiento/actualizaArticulo', 'Act. Cat.', $atts); }?></td>
                                                <td><?php echo $row->subtipoMovimientoDescripcion; ?></td>
                                                <td id="orden"><?php echo $row->orden; ?><a href="#" id="id-btn-dialog1" class="btn btn-purple btn-small">Orden</a></td>
                                                <td><?php echo $row->referencia; ?></td>
                                                <td><?php echo $row->fecha; ?></td>
                                                <td><?php echo $row->razon; ?></td>
                                                <td><?php echo $row->sucursal; ?></td>
                                                <td><?php echo $row->sucursal_referencia; ?></td>
                                                <td><?php echo $row->nombreusuario; ?></td>
                                                <td><?php echo $row->fechaAlta.'<br />'.$row->fechaCierre.'<br />'.$row->fechaCancelacion; ?></td>
                                                <td><?php echo $row->observaciones; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>                                
                                    
                                </div>
                            </div>
                            
                            <?php
                                    
                            if($row->statusMovimiento == 0){
                                
                                if($row->tipoMovimiento == 1)
                                {
                            
                            ?>
                            
							<div class="row-fluid">
                                <div class="span12">
                                    
                                    <div class="widget-box">
											<div class="widget-header">
												<h4>Datos de los productos</h4>
											</div>
                                    
                                    <div class="widget-body">
												<div class="widget-main">
                                                
                                                <?php echo form_open('movimiento/captura_submit', array('class' => 'form-inline', 'id' => 'captura_form')); ?>
														<input name="articulo" id="articulo" type="text" class="input-large" placeholder="Clave de articulo" required="required" />
														<!--<input name="comercial" id="comercial" type="text" class="input-large" placeholder="Nombre comercial" />-->
														<input name="piezas" id="piezas" type="number" class="input-small" placeholder="Piezas" required="required" />
														<input name="lote" id="lote" type="text" class="input-small" placeholder="Lote" pattern="[a-zA-Z0-9&ntilde;&Ntilde;]+" required="required" />
														<input name="caducidad" id="caducidad" type="text" class="input-small" placeholder="Caducidad" required="required"/>
														<input name="ean" id="ean" type="text" class="input-medium" placeholder="EAN" pattern="[0-9]+" maxlength="14" />
														<input name="marca" id="marca" type="text" class="input-small" placeholder="Marca" required="required" />
														<input name="costo" id="costo" type="text" class="input-small" placeholder="Costo" pattern="\d+(\.\d+)?" required="required" />
                                                        <label>Sector salud:</label>
                                                        <input name="comercial" id="comercial" type="checkbox"/>
                                                        <br />
                                                        <select id="ubicacion" name="ubicacion"></select>

														<button class="btn btn-info btn-small" id="button_aceptar">
															<i class="icon-key bigger-110"></i>
															Aceptar
														</button>
                                                <?php echo form_close(); ?>
                                                <table class="table">
                                                    <tr>
                                                        <td id="susa" style="color: green;"></td>
                                                        <td id="descripcion" style="color: blue;"></td>
                                                        <td id="pres" style="color: red;"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Cantidad Pedida: <span id="cans" style="color: red;">0</span></td>
                                                        <td>Codigo esperado: <span id="codigo" style="color: red;">0</span></td>
                                                        <td>Costo esperado: <span id="costoe" style="color: red;">0</span></td>
                                                    </tr>
                                                </table>
												</div>
											</div>
                                    </div>
                                    
								</div>	
                            </div>
                            
                            <?php
                                    
                                }elseif($row->tipoMovimiento == 2){
                            
                            ?>
							<div class="row-fluid">
                                <div class="span12">
                                    
                                    <div class="widget-box">
											<div class="widget-header">
												<h4>Datos de los productos</h4>
											</div>
                                    
                                    <div class="widget-body">
												<div class="widget-main">
                                                
                                                <?php echo form_open('movimiento/captura_submit2', array('class' => 'form-inline', 'id' => 'captura_form2')); ?>
														<input name="articulo2" id="articulo2" type="text" class="input-large" placeholder="Clave de articulo" required="required" />
														<input name="piezas" id="piezas" type="numeric" class="input-small" placeholder="Piezas" required="required" />
                                                        <select size="1" name="lote2" id="lote2"></select>

														<button class="btn btn-info btn-small" id="button_aceptar2">
															<i class="icon-key bigger-110"></i>
															Aceptar
														</button>
                                                <?php echo form_close(); ?>
                                                <table class="table">
                                                    <tr>
                                                        <td id="susa" style="color: green;"></td>
                                                        <td id="descripcion" style="color: blue;"></td>
                                                        <td id="pres" style="color: red;"></td>
                                                    </tr>
                                                </table>
												</div>
											</div>
                                    </div>
                                    
								</div>	
                            </div>
                            
                            <?php
                                }
                                    
                            ?>


                            
                            <?php
                            
                            }
                            
                            ?>

							<div class="row-fluid">
                                <div class="span12" id="detalle">
                                
                                
                                </div>
                            </div>
                            <div id="dialog-message" class="hide">
                            
                            <h3>Detalle de la orden compra</h3>
                            
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Codigo</th>
                                        <th>Secuencia</th>
                                        <th>Clave</th>
                                        <th>Descripcion 1</th>
                                        <th>Descripcion 2</th>
                                        <th>Costo</th>
                                        <th>IVA</th>
                                        <th>Cantidad Pedida</th>
                                        <th>Aplicada</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    if(is_array($orden)){
                                        foreach($orden as $o){
                                    ?>
                                    <tr>
                                        <td><?php echo $o->codigo; ?></td>
                                        <td><?php echo $o->sec; ?></td>
                                        <td><?php echo $o->clagob; ?></td>
                                        <td><?php echo $o->susa1; ?></td>
                                        <td><?php echo $o->susa2; ?></td>
                                        <td><?php echo $o->costo; ?></td>
                                        <td><?php echo $o->iva; ?></td>
                                        <td><?php echo $o->canp; ?></td>
                                        <td><?php echo $o->aplica; ?></td>
                                    </tr>
                                    <?php 
                                    
                                        }
                                    }
                                    
                                    ?>
                                </tbody>
                            </table>
							
                            </div><!-- #dialog-message -->
