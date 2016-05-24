					<?php $row = $query->row(); ?>
                    		<div class="row-fluid">
                                <div class="span12">
                                    
                                    <?php echo MY_form_open('catalogosweb/contrato_editar_submit'); ?>
                                    
                                    <?php echo MY_form_input('numero', 'numero', 'Texto del contrato', 'text', 'Numero de contrato', 6, true, $row->numero); ?>

                                    <?php echo MY_form_input('denominado', 'denominado', 'Nombre corto', 'text', 'Nombre corto', 6, true, $row->denominado); ?>

                                    <?php echo MY_form_textarea('referencia_factura', 'referencia_factura', 'Referencia', 'text', 'Referencia', 6, true, $row->referencia_factura); ?>

                                    <?php echo form_hidden('rfc', $rfc); ?>
                                    
                                    <?php echo form_hidden('contratoID', $contratoID); ?>
                                    
                                    <?php echo MY_form_submit(); ?>
                                    
                                    <?php echo form_close(); ?>
                                    
                                    <h2>Etiquetas disponibles</h2>
                                    <p>
                                        | <span id="licitacion" style="color: red;">$licitacion</span> | 
                                        <span id="mes" style="color: red;">$mes_actual</span> |
                                        <span id="anio" style="color: red;">$anio_actual</span> |
                                        <span id="nombre_corto" style="color: red;">$nombre_corto</span> |
                                        <span id="numero_contrato" style="color: red;">$numero_contrato</span> |
                                        <span id="numero_sucursal" style="color: red;">$numero_sucursal</span> |
                                        <span id="nombre_sucursal" style="color: red;">$nombre_sucursal</span> |
                                        <span id="direccion_sucursal" style="color: red;">$direccion_sucursal</span> |
                                        <span id="referencia_pedido" style="color: red;">$referencia_pedido</span> |
                                        <span id="mes_pedido" style="color: red;">$mes_pedido</span> |
                                        <span id="anio_pedido" style="color: red;">$anio_pedido</span> |
                                        <span id="sucursal_personalizado_nombre" style="color: red;">$sucursal_personalizado_nombre</span> |
                                        <span id="sucursal_personalizado_direccion" style="color: red;">$sucursal_personalizado_direccion</span> |
                                    </p>
                                    
								</div>	
                            </div>