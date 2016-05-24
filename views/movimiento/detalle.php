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

<table class="table table-condensed">
    <thead>
        <tr>
            <th>Detalle</th>
            <th>ID</th>
            <th>Clave</th>
            <th>Comercial</th>
            <th>Susa</th>
            <th>Descripcion</th>
            <th>Presentacion</th>
            <th style="text-align: right;">Piezas</th>
            <th>Lote</th>
            <th>Caducidad</th>
            <th>Costo</th>
            <th>Importe</th>
            <th>IVA</th>
            <th>Subtotal</th>
            <th>Ubicacion</th>
            <th>Eliminar</th>
            <th>Devolucion</th>
        </tr>
    </thead>
    <tbody>
        <?php
        
        
        $importeTotal = 0;
        $piezas = 0;
        $ivaTotal = 0;
        $total = 0;
        
        foreach($query->result() as $row){
            
            $importe = $row->costo * $row->piezas;
            
            if($row->tipoprod == 0)
            {
                $iva = 0;
            }else{
                $iva = $row->costo * $row->piezas * IVA;
            }
            
            $subtotal = $importe + $iva;

            
            if($row->statusMovimiento == 0)
            {
                $link_elimina = anchor('movimiento/elimina_detalle/'.$row->movimientoDetalle, 'Elimina', array('class' => 'elimina_detalle'));
            }else{
                $link_elimina = null;
            }
            
            if($row->statusMovimiento == 1 && $row->subtipoMovimiento == 13)
            {
                $link_devolucion = anchor('movimiento/devolucion/'.$row->movimientoDetalle, 'Devolucion', array('class' => 'devolucion'));
            }elseif($row->statusMovimiento == 0 && $row->subtipoMovimiento == 2)
            {
                $link_devolucion = anchor('movimiento/modifica/'.$row->movimientoDetalle.'/'.$movimientoID, 'Modificar');
            }else{
                $link_devolucion = null;
            }
        
        ?>
        <tr>
            <td><?php echo $row->movimientoDetalle; ?></td>
            <td><?php echo $row->id; ?></td>
            <td><?php echo $row->cvearticulo; ?></td>
            <td><?php echo $row->comercial; ?></td>
            <td><?php echo $row->susa; ?></td>
            <td><?php echo $row->descripcion; ?></td>
            <td><?php echo $row->pres; ?></td>
            <td style="text-align: right;"><?php echo number_format($row->piezas, 0); ?></td>
            <td><?php echo $row->lote; ?></td>
            <td><?php echo $row->caducidad; ?></td>
            <td style="text-align: right;"><?php echo number_format($row->costo, 2); ?></td>
            <td style="text-align: right;"><?php echo number_format($importe, 2); ?></td>
            <td style="text-align: right;"><?php echo number_format($iva, 2); ?></td>
            <td style="text-align: right;"><?php echo number_format($subtotal, 2); ?></td>
            <td style="text-align: center;"><?php echo $row->area; ?></td>
            <td><?php echo $link_elimina; ?></td>
            <td><?php echo $link_devolucion; ?></td>
        </tr>
        <?php 
        
            $importeTotal = $importeTotal + $importe;
            $piezas = $piezas + $row->piezas;
            $ivaTotal = $ivaTotal + $iva;
            $total = $total + $subtotal;
        
        } 
        
        ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="7" style="text-align: right;">Totales</td>
            <td style="text-align: right;"><?php echo number_format($piezas, 0); ?></td>
            <td colspan="3">&nbsp;</td>
            <td style="text-align: right;"><?php echo number_format($importeTotal, 2); ?></td>
            <td style="text-align: right;"><?php echo number_format($ivaTotal, 2); ?></td>
            <td style="text-align: right;"><?php echo number_format($total, 2); ?></td>
            <td colspan="2">&nbsp;</td>
        </tr>
    </tfoot>
</table>
<script type="text/javascript">
<!--
    $('.elimina_detalle').on('click', elimina);
    
    function elimina(event)
    {
        event.preventDefault();
        
        if(confirm("Deseas eliminar este registro??"))
        {
            var $url = event.currentTarget.href;
            var $variables = { };
            var posting = $.post( $url, $variables );
                
                 posting.done(function( data ) {
                    
                    detalle();
                    
                 });
            return true;
        }else{
            return false;
        }
    }

    function detalle()
    {
        
        $movimientoID = $('#movimientoID').html();
        
        var $url = '<?php echo site_url('movimiento/detalle'); ?>';
        var $variables = { movimientoID: $movimientoID };
        var posting = $.post( $url, $variables );
            
             posting.done(function( data ) {
                
                $('#detalle').html(data);
                
             });
        
    }
-->
</script>