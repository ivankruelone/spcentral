<table class="table">
    <thead>
        <tr>
            <th>Id</th>
            <th>Clave</th>
            <th>EAN</th>
            <th>Comercial</th>
            <th>Susa</th>
            <th>Descripcion</th>
            <th>Presentacion</th>
            <th>Lote</th>
            <th>Fecha Cad</th>
            <th style="text-align: right;">Surtida</th>
            <th>Eliminar</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        
            $sur = 0;
        
            foreach($query->result() as $row)
            {
        ?>
        <tr>
            <td><?php echo $row->serie; ?></td>
            <td><?php echo $row->cvearticulo; ?></td>
            <td><?php echo $row->ean; ?></td>
            <td><?php echo $row->comercial; ?></td>
            <td><?php echo $row->susa; ?></td>
            <td><?php echo $row->descripcion; ?></td>
            <td><?php echo $row->pres; ?></td>
            <td><?php echo strtoupper($row->lote); ?></td>
            <td><?php echo $row->caducidad; ?></td>
            <td style="text-align: right;"><?php echo number_format($row->sur, 0); ?></td>
            <td><?php echo anchor('captura/eliminar_rapida/'.$row->serie, 'Elimina', array('class' => 'elimina')); ?></td>
        </tr>
        
        <?php
                
                $sur = $sur  + $row->sur;
        
            }
        
        ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="9">Totales</td>
            <td style="text-align: right;"><?php echo number_format($sur, 0); ?></td>
            <td style="text-align: right;">&nbsp;</td>
        </tr>
    </tfoot>
</table>

Total de Productos: <span id="productos_total"><?php echo $sur; ?></span>

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
                $("#cveArticulo") .val('').focus();
                
             });
    }
}


	
-->
</script>
