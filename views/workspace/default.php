<?php
	if($query2->num_rows() > 0)
    {
        $row2 = $query2->row();
        
        $domicilio = $row2->domicilio;
    }else{
        $domicilio = anchor('catalogosweb/domicilio', 'Establece el domicilio');
    }
?>
<div class="row-fluid">
    <div class="span12">
        <p>Nivel de Atenci&oacute;n: <?php echo $this->session->userdata('nivel'); ?></p>
        <p># Sucursal: <?php echo $this->session->userdata('clvsucursal'); ?></p>
        <p>Sucursal: <?php echo $this->session->userdata('sucursal'); ?></p>
        
        <p># Jurisdicci&oacute;n: <?php echo $this->session->userdata('jur'); ?></p>
        
        <p>Foliador CxP: <?php echo $this->session->userdata('cxp'); ?></p>
        
        <p>Domicilio: <?php echo $domicilio; ?></p>
        
        <p>Version: <?php echo $this->util->getVersion(); ?> (<?php echo $this->util->getFechaVersion(); ?>)</p>
        
        <?php
        
        if($query3->num_rows() > 0){
        
        
        ?>
        <h3 style="color: red;">Recetas incorrectas, Favor de revisar.</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Folio de receta</th>
                    <th>Clave de articulo</th>
                    <th>Observaciones</th>
                    <th>Edita receta</th>
                    <th>Liberar receta(Ya se corrigi&oacute;)</th>
                </tr>
            </thead>
                <tbody>
                
                <?php foreach($query3->result() as $row3){?>
                    <tr>
                        <td><?php echo $row3->folioreceta; ?></td>
                        <td><?php echo $row3->cvearticulo; ?></td>
                        <td><?php echo $row3->observaciones; ?></td>
                        <td><?php echo anchor('captura/edita/'.$row3->consecutivo, 'Edita la receta'); ?></td>
                        <td><?php echo anchor('captura/liberar/'.$row3->consecutivo, 'Libera la receta'); ?></td>
                    </tr>
                <?php }?>
                </tbody>
        </table>
        
        <?php } ?>
        
        <table class="table">
            <thead>
                <tr>
                    <th>Tabla</th>
                    <th>Ultima actualizacion</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($query->result() as $row){?>
                <tr>
                    <td><?php echo $row->tabla; ?></td>
                    <td><?php echo $row->ultima_actualizacion; ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        
        <h2>Changelog</h2>
        
        <h3>Version: 1.0.5 (01/05/2015)</h3>
<pre>
* Se agrega la referencia en la impresion de movimientos.
* Se agrega la version al programa, para rastrear si esta actualizado o no una sucursal.
* Se Reduce el tiempo de espera de las conexiones a 2 segundos, reduciendo el tiempo de guardado(En mejora; Se hara un handshake al iniciar sesion para saber si hay conectividad y bajar a cero las esperas).
* Se ordeno el reporte de recetas por fecha y folio.
    Atte. Ing. Iv&aacute;n Zu&ntilde;iga P&eacute;rez
    Correo: ivan.zuniga@farfenix.com.mx
</pre>

        <h3>Version: 1.0.4 (23/04/2015)</h3>
<pre>
* Exportar folios desde el almacen central y desde otras unidades.
* Actualizacion de catalogo mas rapida(inicio de sesion).
* Implementacion de chequeo de recetas desde el central.
* Adios Amigos.
    Atte. Ing. Iv&aacute;n Zu&ntilde;iga P&eacute;rez
    Correo: ivan.zuniga@farfenix.com.mx
</pre>

        <h3>Version: 1.0.3 (17/04/2015)</h3>
<pre>
* Se agrega Cantidad en la captura de recetas, para saber la cantidad actual de inventario.
* Implementaci&oacute;n de antibi&oacute;ticos y reporte.
* Pr&oacute;xima actualizaci&oacute;n: Sem&aacute;foros, Importar transpasos del almacen central, implementaci&oacute;n de pedido autom&aacute;tico por optimo.
    Atte. Ing. Iv&aacute;n Zu&ntilde;iga P&eacute;rez
    Correo: ivan.zuniga@farfenix.com.mx
</pre>
        
        <h3>Version: 1.0.2 (09/04/2015)</h3>
<pre>
* Correccion de bugs por timeout y memoria
* Reporte de caducidades (PDF)
* Reporte de Inventario (PDF)
* Reporte de Consumos (PDF)
* Reporte de Negados (PDF)
* Reporte de Recetas (PDF)
* Proxima actualizacion: Manejo de antibioticos, Semaforos, Importar transpasos del almacen central.
    Atte. Ing. Iv&aacute;n Zu&ntilde;iga P&eacute;rez
</pre>

    </div>
</div>