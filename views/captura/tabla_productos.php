<table class="table">
    <thead>
        <tr>
            <th>Id</th>
            <th>Clave</th>
            <th>Susa</th>
            <th>Descripcion</th>
            <th>Presentacion</th>
            <th>Ampuleo</th>
            <th>Lote</th>
            <th>Fecha Cad</th>
            <th style="text-align: right;">Solicitada</th>
            <th style="text-align: right;">Surtida</th>
            <th>Eliminar</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        
            $req = 0;
            $sur = 0;
        
            foreach($query->result() as $row)
            {
        ?>
        <tr>
            <td><?php echo $row->consecutivo_temporal; ?></td>
            <td><?php echo $row->cvearticulo; ?></td>
            <td><?php echo $row->susa; ?></td>
            <td><?php echo $row->descripcion; ?></td>
            <td><?php echo $row->pres; ?></td>
            <td><?php echo $row->ampuleo; ?></td>
            <td><?php echo strtoupper($row->lote); ?></td>
            <td><?php echo $row->caducidad; ?></td>
            <td style="text-align: right;"><?php echo number_format($row->req, 0); ?></td>
            <td style="text-align: right;"><?php echo number_format($row->sur, 0); ?></td>
            <td><?php echo anchor('captura/eliminar/'.$row->serie, 'Elimina', array('class' => 'elimina')); ?></td>
        </tr>
        
        <?php
                
                $req = $req  + $row->req;
                $sur = $sur  + $row->sur;
        
            }
        
        ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="8">Totales</td>
            <td style="text-align: right;"><?php echo number_format($req, 0); ?></td>
            <td style="text-align: right;"><?php echo number_format($sur, 0); ?></td>
            <td style="text-align: right;">&nbsp;</td>
            <td></td>
        </tr>
    </tfoot>
</table>

Productos <span id="productos_total"><?php echo $sur; ?></span>

<script type="text/javascript">
<!--
$(".elimina").on("click", elimina);

function elimina(data)
{
    if(confirm("Seguro que deseas eliminar ?")){

        data.preventDefault();
        var $url = data.currentTarget.attributes.href.value;
        var $variables = {};
        var posting = $.post( $url, $variables );
            
             posting.done(function( data ) {
                
                $('#productos').html(data);
                
             });
    }
}
	
-->
</script>
