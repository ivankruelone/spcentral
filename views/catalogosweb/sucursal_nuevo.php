							<div class="row-fluid">
                                <div class="span12">
                                    
                                    <?php echo MY_form_open('catalogosweb/sucursal_nuevo_submit'); ?>
                                    
                                    <?php echo MY_form_input('clvsucursal', 'clvsucursal', 'Clave sucursal', 'number', 'Clave sucursal', 3); ?>

                                    <?php echo MY_form_input('descsucursal', 'descsucursal', 'Descripcion sucursal', 'text', 'Descripcion Sucursal', 6); ?>

                                    <?php echo MY_form_input('calle', 'calle', 'Calle', 'text', 'Calle', 12); ?>

                                    <?php echo MY_form_input('noexterior', 'noexterior', 'No. exterior', 'text', 'No. exterior', 6); ?>

                                    <?php echo MY_form_input('nointerior', 'nointerior', 'No. interior', 'text', 'No. interior', 6); ?>

                                    <?php echo MY_form_input('colonia', 'colonia', 'Colonia', 'text', 'Colonia', 6); ?>

                                    <?php echo MY_form_input('municipio', 'municipio', 'Municipio', 'text', 'Municipio', 6); ?>

                                    <?php echo MY_form_input('estado', 'estado', 'Estado', 'text', 'Estado', 6); ?>

                                    <?php echo MY_form_input('pais', 'pais', 'Pais', 'text', 'Pais', 6); ?>

                                    <?php echo MY_form_input('cp', 'cp', 'C. P.', 'number', 'C. P.', 3); ?>

                                    <?php echo MY_form_dropdown2('Jurisdiccion', 'numjurisd', $juris, null, 12); ?>    

                                    <?php echo MY_form_submit(); ?>
                                    
                                    <?php echo form_close(); ?>
                                    
								</div>	
                            </div>
