<table class="table table-condensed">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>RFC</th>
                                                <th>Razon Social</th>
                                                <th># Sucursal</th>
                                                <th>Nombre de Sucursal</th>
                                                <th style="text-align: center;">Eliminar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                
                                            foreach($query->result() as $row){
                                                

                                            
                                            ?>
                                            <tr>
                                                <td><?php echo $row->receptorSucursalID; ?></td>
                                                <td><?php echo $row->rfc; ?></td>
                                                <td><?php echo $row->razon; ?></td>
                                                <td><?php echo $row->clvsucursal; ?></td>
                                                <td><?php echo $row->descsucursal; ?></td>
                                                <td style="text-align: center;"><?php echo anchor('catalogosweb/clienteSucursalEliminar/'.$row->receptorSucursalID, 'Eliminar', array('class' => 'eliminar')); ?></td>
                                            </tr>
                                            <?php 
                                            
                                            
                                            }
                                            
                                            
                                            ?>
                                        </tbody>
                                    </table>
                                    <script type="text/javascript">
<!--
	var $rfc = $("#rfc").html();
    
    $(".eliminar").on('click', elimina);
    
    function elimina(event)
    {
        if(confirm('Desea eliminar esta sucursal para este cliente ?'))
        {
            event.preventDefault();
            var $url = event.currentTarget.attributes.href.value;
            eliminaSucursal($url);
        }else{
            return false;
        }
    }

    function eliminaSucursal($url)
    {
        var $variables = {};

        var posting = $.post( $url, $variables );
        
         posting.done(function( data ) {
            
            showSucursales();

            
         });
    }

    function showSucursales()
    {
        var $url = '<?php echo site_url('catalogosweb/showSucursalesCliente'); ?>';;
        var $variables = { rfc : $rfc };

        var posting = $.post( $url, $variables );
        
         posting.done(function( data ) {
            
            $("#sucursales").html(data);

            
         });
    }

-->
</script>