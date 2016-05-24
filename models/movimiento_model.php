<?php
class Movimiento_model extends CI_Model {

    /**
     * Catalogos_model::__construct()
     * 
     * @return
     */
     
    var $urlExchange;
    var $url;
    var $formato_datos = "/format/json";
    var $json;
    
    function __construct()
    {
        parent::__construct();
        $this->urlExchange = 'http://almacenoaxaca.homeip.net/index.php/Exchange/';
        $this->url = "http://189.203.201.184/oaxacacentral/index.php/catalogos/";
    }
    
    function __get_data($url, $referencia)
    {
        
    	$ch = curl_init();
    	$timeout = 2;
    	curl_setopt($ch, CURLOPT_URL, $url);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    	$data = curl_exec($ch);
    	curl_close($ch);
        
        
        
    	return $data;
    
    }

    function __getData($url)
    {
        
    	$ch = curl_init();
    	$timeout = 2;
    	curl_setopt($ch, CURLOPT_URL, $url);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    	$json = curl_exec($ch);
    	curl_close($ch);
        $data = json_decode($json);
        
    	return $data;
    
    }

    function __getCatalogo($cat, $referencia)
    {
        $suc = '/referencia/'.$referencia;
        return $this->url.$cat.$suc.$this->formato_datos;
    }

    function hola()
    {
        return null;
    }
    
    function getSubtipoMovimientoByMovimientoID($movimientoID)
    {
        $this->db->select('subtipoMovimiento');
        $this->db->where('movimientoID', $movimientoID);
        $query = $this->db->get('movimiento');
        
        $row = $query->row();
        return $row->subtipoMovimiento;
    }
    
    function getInventarioBySubtipoMovimiento($movimientoID, $areaID)
    {
        $subtipoMovimiento = $this->getSubtipoMovimientoByMovimientoID($movimientoID);
        
        if($subtipoMovimiento == 6)
        {
            $sql = "SELECT area, inventarioID, cvearticulo, susa, descripcion, pres, cantidad, lote, caducidad
FROM inventario i
join articulos a using(id)
join ubicacion u using(ubicacion)
where cantidad > 0 and caducidad <= date(now()) and areaID = ?
order by susa, descripcion;";
        }else{
            $sql = "SELECT area, inventarioID, cvearticulo, susa, descripcion, pres, cantidad, lote, caducidad
FROM inventario i
join articulos a using(id)
join ubicacion u using(ubicacion)
where cantidad > 0 and caducidad >= date(now()) and areaID = ?
order by susa, descripcion;";
        
        }
        
        $query = $this->db->query($sql, $areaID);
        
        return $query;
    }
    
    function getMovimientosCuenta($tipoMovimiento, $subtipoMovimiento)
    {
        $sql = "SELECT count(*) as cuenta
FROM movimiento m
join tipo_movimiento t using(tipoMovimiento)
join subtipo_movimiento s using(subtipoMovimiento)
join movimiento_status a using(statusMovimiento)
join sucursales s1 using(clvsucursal)
join sucursales s2 on m.clvsucursalReferencia = s2.clvsucursal
join proveedor p using(proveedorID)
join usuarios u using(usuario)
where m.tipoMovimiento = ? and m.subtipoMovimiento = ?;";
        $query = $this->db->query($sql, array($tipoMovimiento, $subtipoMovimiento));
        $row = $query->row();
        return $row->cuenta;
    }
    
    function getMovimientos($tipoMovimiento, $subtipoMovimiento, $limit, $offset = 0)
    {
        $sql = "SELECT movimientoID, statusMovimiento, statusPrepedido, asignaFactura, observaciones, tipoMovimientoDescripcion, subtipoMovimientoDescripcion, orden, referencia, fecha, razon, s1.descsucursal as sucursal, s2.descsucursal as sucursal_referencia, nombreusuario, fechaAlta, fechaCierre, fechaCancelacion, idFactura, folioFactura, fechaFactura, urlpdf, urlxml
        FROM movimiento m
join tipo_movimiento t using(tipoMovimiento)
join subtipo_movimiento s using(subtipoMovimiento)
join movimiento_status a using(statusMovimiento)
join sucursales s1 using(clvsucursal)
join sucursales s2 on m.clvsucursalReferencia = s2.clvsucursal
join proveedor p using(proveedorID)
join usuarios u using(usuario)
where m.tipoMovimiento = ? and m.subtipoMovimiento = ?
order by m.movimientoID desc
limit ? offset ?
;";

        $query = $this->db->query($sql, array($tipoMovimiento, $subtipoMovimiento, (int)$limit, (int)$offset));
        return $query;
    }
    

    
    function getMovimientoByMovimientoID($movimientoID)
    {
        $sql = "SELECT m.tipoMovimiento, m.subtipoMovimiento, m.statusMovimiento, remision, movimientoID, statusMovimiento, observaciones, tipoMovimientoDescripcion, subtipoMovimientoDescripcion, orden, nuevo_folio, referencia, fecha, razon, clvsucursalReferencia, s1.descsucursal as sucursal, s2.descsucursal as sucursal_referencia, clvsucursalReferencia, nombreusuario, fechaAlta, fechaCierre, fechaCancelacion, upper(concat(s2.calle, ', ', s2.colonia, ', C. P. ', s2.cp, ', ', s2.municipio)) as domicilio, idFactura, folioFactura, urlxml, urlpdf, fechaFactura, year(fecha) as anio, month(fecha) as mes, s3.nombreSucursalPersonalizado, s3.domicilioSucursalPersonalizado
        FROM movimiento m
join tipo_movimiento t using(tipoMovimiento)
join subtipo_movimiento s using(subtipoMovimiento)
join movimiento_status a using(statusMovimiento)
join sucursales s1 using(clvsucursal)
join sucursales s2 on m.clvsucursalReferencia = s2.clvsucursal
left join sucursales_ext s3 on m.clvsucursalReferencia = s3.clvsucursal
join proveedor p using(proveedorID)
join usuarios u using(usuario)
where m.movimientoID = ?;";

        $query = $this->db->query($sql, $movimientoID);
        return $query;
    }

    function getMovimiento($movimientoID)
    {
        $this->db->where('movimientoID', $movimientoID);
        $query = $this->db->get('movimiento');
        return $query;
    }
    
    function insertMovimiento($tipoMovimiento, $subtipoMovimiento, $fecha, $orden, $referencia, $sucursal_referencia, $proveedor, $observaciones, $remision)
    {
        $data = array(
            'tipoMovimiento'    => $tipoMovimiento,
            'subtipoMovimiento' => $subtipoMovimiento,
            'orden'             => $orden,
            'referencia'        => $referencia,
            'fecha'             => $fecha,
            'statusMovimiento'  => 0,
            'proveedorID'       => $proveedor,
            'clvsucursal'       => $this->session->userdata('clvsucursal'),
            'clvsucursalReferencia' => $sucursal_referencia,
            'usuario'           => $this->session->userdata('usuario'),
            'observaciones'     => $observaciones,
            'remision'          => $remision
            );
        
        $this->db->set('fechaAlta', 'now()', false);
        $this->db->insert('movimiento', $data);
        $movimientoID = $this->db->insert_id();
        
        if($movimientoID > 0 && $orden > 0)
        {
            $this->getProductosFolprv($orden);
        }
        
        if($sucursal_referencia == 19000 && $tipoMovimiento == 1 && $subtipoMovimiento == 2)
        {
            //$this->cargaPedido($referencia, $movimientoID);
        }elseif($sucursal_referencia <> 19000 && $tipoMovimiento == 1 && $subtipoMovimiento == 2)
        {
            //$this->cargaPedidoUnidades($referencia, $movimientoID);
        }
    }
    
    function getLotes($cvearticulo)
    {
        $sql = "SELECT inventarioID, lote, caducidad, cantidad FROM inventario i join articulos a using(id) where cvearticulo = ? having cantidad > 0 order by caducidad;";
        $query = $this->db->query($sql, $cvearticulo);
        return $query;
    }
    
    function getLotesAunCaducados($cvearticulo)
    {
        $sql = "SELECT inventarioID, lote, caducidad, cantidad FROM inventario i join articulos a using(id) where cvearticulo = ? having cantidad > 0 order by caducidad;";
        $query = $this->db->query($sql, $cvearticulo);
        return $query;
    }

    function updateMovimiento($tipoMovimiento, $subtipoMovimiento, $fecha, $orden, $referencia, $sucursal_referencia, $proveedor, $observaciones, $movimientoID)
    {
        $data = array(
            'tipoMovimiento'    => $tipoMovimiento,
            'subtipoMovimiento' => $subtipoMovimiento,
            'orden'             => $orden,
            'referencia'        => $referencia,
            'fecha'             => $fecha,
            'proveedorID'       => $proveedor,
            'clvsucursal'       => $this->session->userdata('clvsucursal'),
            'clvsucursalReferencia' => $sucursal_referencia,
            'usuario'           => $this->session->userdata('usuario'),
            'observaciones'     => $observaciones
            );
        
        $this->db->update('movimiento', $data, array('movimientoID' => $movimientoID));
    }
    
    function getArticuloByClave($cvearticulo)
    {
        $sql = "SELECT * FROM articulos a where id in(SELECT id FROM inventario i where ean = ? and ean > 0);";
        $query2 = $this->db->query($sql, (string)$cvearticulo);
        
        if($query2->num_rows() > 0)
        {
            return $query2;
        }else{
            $this->db->where('cvearticulo', (string)$cvearticulo);
            $query = $this->db->get('articulos');
            return $query;
        }
        
        
    }

    function insertDetalle($movimientoID, $id, $piezas, $costo, $lote, $caducidad, $ean, $marca, $ubicacion, $comercial)
    {
        $query = $this->getArticuloByClave($id);
        
        if($query->num_rows() == 1)
        {
            $row = $query->row();
            
            if($row->activo == 1)
            {
            $data = array(
                'movimientoID'  => $movimientoID,
                'id'            => $row->id,
                'piezas'        => $piezas,
                'costo'         => $costo,
                'lote'          => $lote,
                'caducidad'     => $caducidad,
                'ean'           => $ean,
                'marca'         => $marca,
                'ubicacion'     => $ubicacion,
                'comercial'     => $comercial
                );
            
            $this->db->insert('movimiento_detalle', $data);
            }else{
                
            }
            
        }else{
            
        }
    }
    
    function getInventarioByID($inventarioID)
    {
        $this->db->where('inventarioID', $inventarioID);
        $query = $this->db->get('inventario');
        return $query;
    }
    
    function insertDetalle2($movimientoID, $inventarioID, $piezas)
    {
        $query = $this->getInventarioByID($inventarioID);
        
        if($query->num_rows() == 1)
        {
            $row = $query->row();
            
            if($row->cantidad < $piezas)
            {
                $this->session->set_flashdata('error', 'Hay menos piezas en el inventario con ese lote, de las ' . $piezas. ' que requieres solo se pueden surtir ' . $row->cantidad . '.');
                $piezas = $row->cantidad;
                
            }
            
            $data = array(
                'movimientoID'  => $movimientoID,
                'id'            => $row->id,
                'piezas'        => $piezas,
                'costo'         => $row->costo,
                'lote'          => $row->lote,
                'caducidad'     => $row->caducidad,
                'ean'           => $row->ean,
                'marca'         => $row->marca,
                'ubicacion'     => $row->ubicacion,
                'comercial'     => $row->comercial
                );
            
            $this->db->insert('movimiento_detalle', $data);
        }else{
            
        }
    }

    function insertDetalle3($movimientoID, $cveArticulo, $piezas)
    {
            
        $query = $this->getArticuloByClave($cveArticulo);
            
        if($query->num_rows() > 0)
        {
            
            $row = $query->row();    
            
            $data = array(
                'movimientoID'  => $movimientoID,
                'id'            => $row->id,
                'piezas'        => $piezas
                );
            
            $this->db->insert('movimiento_prepedido', $data);
        }
    }

    function getDetalle($movimientoID)
    {
        $sql = "SELECT m.*, area, cvearticulo, susa, descripcion, pres, statusMovimiento, tipoprod, tipoMovimiento, subtipoMovimiento
        FROM movimiento_detalle m
join articulos a using(id)
join movimiento o using(movimientoID)
left join ubicacion u using(ubicacion)
where movimientoID = ?;";
        $query = $this->db->query($sql, $movimientoID);
        return $query;
    }
    
    function getDetallePrepedido($movimientoID)
    {
        $sql = "SELECT m.*, cvearticulo, susa, descripcion, pres, statusMovimiento, tipoprod, tipoMovimiento, subtipoMovimiento
        FROM movimiento_prepedido m
join articulos a using(id)
join movimiento o using(movimientoID)
where movimientoID = ?;";
        $query = $this->db->query($sql, $movimientoID);
        return $query;
    }

    function getDetalleByMovimientoDetalle($movimientoDetalle)
    {
        $sql = "SELECT m.*, referencia, cvearticulo, susa, descripcion, pres, statusMovimiento, tipoprod, tipoMovimiento, subtipoMovimiento
        FROM movimiento_detalle m
join articulos a using(id)
join movimiento o using(movimientoID)
where movimientoDetalle = ?;";
        $query = $this->db->query($sql, $movimientoDetalle);
        return $query;
    }
    
    function eliminaDetalle($movimientoDetalle)
    {
        $this->db->delete('movimiento_detalle', array('movimientoDetalle' => $movimientoDetalle));
    }
    
    function eliminaDetallePrepedido($movimientoPrepedido)
    {
        $this->db->delete('movimiento_prepedido', array('movimientoPrepedido' => $movimientoPrepedido));
    }

    function getArticuloDatos($cvearticulo, $orden)
    {
        $query = $this->getArticuloByClave($cvearticulo);
        
        if($query->num_rows() == 1)
        {
            $row = $query->row();
            if($row->activo == 1)
            {
                
                $datos = $this->getOrdenDetalleByClave($orden, $cvearticulo);
                
                if(isset($datos->error) || $orden == 0)
                {
                    return $row->id.'|'.$row->cvearticulo.'|'.$row->susa.'|'.$row->descripcion.'|'.$row->pres.'|-1|0|0';
                }else{
                    
                    foreach($datos as $datos)
                    {
                        
                    }
                    return $row->id.'|'.$row->cvearticulo.'|'.$row->susa.'|'.$row->descripcion.'|'.$row->pres.'|'.($datos->cans - $datos->aplica).'|'.$datos->codigo.'|'.$datos->costo;
                }
                
                
                
            }else{
                return '0|0|NO ENCONTRADO|NO ENCONTRADO|NO ENCONTRADO|-1|0|0';
            }
            
        }else{
            return '0|0|NO ENCONTRADO|NO ENCONTRADO|NO ENCONTRADO|-1|0|0';
        }
    }
    
    function getMarca($ean)
    {
        $sql = "SELECT ean, marca FROM inventario i where ean = ? group by ean;";
        $query = $this->db->query($sql, (double)$ean);
        if($query->num_rows() > 0)
        {
            $row = $query->row();
            return $row->ean . '|' . $row->marca;
        }else{
            return '|';
        }
    }
    
    function getOrdenDetalleByClave($folprv, $clave)
    {
        $clave = str_replace('/', 'diagonal', $clave);
        if(PATENTE == 1)
        {
            return $this->util->getDataOficina('ordenDetalleCodigo', array('folprv' => $folprv, 'codigo' => $clave));
        }else{
            return $this->util->getDataOficina('ordenDetalleClave', array('folprv' => $folprv, 'clave' => $clave));
        }
    }
    
    function getArticulosJSON($term)
    {
        $this->load->library('Services_JSON');
        $j = new Services_JSON();
        
        $sql = "select * from articulos where (id like '%$term%' or cvearticulo like '%$term%' or susa like '%$term%' or descripcion like '%$term%') and activo = 1  limit 20;";
        $query = $this->db->query($sql);
        
        $a = array();
        
        foreach($query->result() as $row)
        {
            $b = array('id' => $row->id, 'cvearticulo' => $row->cvearticulo, 'susa' => $row->susa, 'descripcion' => $row->descripcion, 'pres' => $row->pres, 'value' => $row->cvearticulo.'|'.$row->cvearticulo.'|'.$row->susa.'|'.$row->descripcion.'|'.$row->pres);
            array_push($a, $b);
        }
        return $j->encode($a);
        
    }
    
    function getProveedorJSON($term)
    {
        $this->load->library('Services_JSON');
        $j = new Services_JSON();
        
        $sql = "SELECT * FROM proveedor p where proveedorID like '%$term%' or rfc like '%$term%' or razon like '%$term%' limit 20;";
        $query = $this->db->query($sql);
        
        $a = array();
        
        foreach($query->result() as $row)
        {
            $b = array('proveedorID' => $row->proveedorID, 'rfc' => $row->rfc, 'razon' => $row->razon, 'value' => $row->proveedorID.'|'.$row->rfc.'|'.$row->razon);
            array_push($a, $b);
        }
        return $j->encode($a);
        
    }

    function getSucursalJSON($term)
    {
        $this->load->library('Services_JSON');
        $j = new Services_JSON();
        
        $sql = "SELECT * FROM sucursales s where clvsucursal like '%$term%' or descsucursal like '%$term%' limit 20;";
        $query = $this->db->query($sql);
        
        $a = array();
        
        foreach($query->result() as $row)
        {
            $b = array('clvsucursal' => $row->clvsucursal, 'descsucursal' => $row->descsucursal, 'value' => $row->clvsucursal.'|'.$row->descsucursal);
            array_push($a, $b);
        }
        return $j->encode($a);
        
    }

    function getEmbarque($movimientoID)
    {
        $this->db->where('movimientoID', $movimientoID);
        $query = $this->db->get('movimiento_embarque');
        return $query;
    }
    
    function replaceEmbarque($movimientoID, $embarco, $operador, $unidad, $placas, $cajas = 0, $hieleras = 0, $surtio, $valido, $observaciones)
    {
        $data = array(
            'movimientoID' => $movimientoID,
            'embarco' => $embarco,
            'operador' => $operador,
            'unidad' => $unidad,
            'placas' => $placas,
            'cajas' => $cajas,
            'hieleras' => $hieleras,
            'surtio' => $surtio,
            'valido' => $valido,
            'observaciones' => $observaciones
            );
            
            $this->db->replace('movimiento_embarque', $data);
    }

    function header($movimientoID)
    {
        $query = $this->getMovimientoByMovimientoID($movimientoID);
        $row = $query->row();
  
        $logo = array(
                                  'src' => base_url().'assets/img/logo.png',
                                  'width' => '120'
                       );
        $tabla = '<table cellpadding="1">
            <tr>
                 <td rowspan="8" width="100px">'.img($logo).'</td>   
                <td rowspan="8" width="450px" align="center"><font size="8">'.COMPANIA.'<br />ORIGEN: '.$row->sucursal.'<br />MOVIMIENTO: '.$row->tipoMovimientoDescripcion.' - '.$row->subtipoMovimientoDescripcion.'<br />PROVEEDOR: '.$row->razon.'<br />DESTINO: '.$row->sucursal_referencia.'<br />Observaciones: '.$row->observaciones .'</font><br />Referencia: '.barras($row->referencia).'</td>
                <td width="75px">ID Movimiento: </td>
                <td width="95px" align="right">'.$row->movimientoID.'</td>
            </tr>
            <tr>
                <td width="75px">FECHA: </td>
                <td width="95px" align="right">'.$row->fecha.'</td>
            </tr>
            <tr>
                <td width="75px"># SUC: </td>
                <td width="95px" align="right">'.$row->clvsucursalReferencia.'</td>
            </tr>
            <tr>
                <td width="75px">Orden: </td>
                <td width="95px" align="right">'.$row->orden.'</td>
            </tr>
            <tr>
                <td width="75px">Referencia: </td>
                <td width="95px" align="right">'.$row->referencia.'</td>
            </tr>
            <tr>
                <td width="75px">Remision: </td>
                <td width="95px" align="right">'.$row->remision.'</td>
            </tr>
            <tr>
                <td width="75px">Fol CxP: </td>
                <td width="95px" align="right">'.$row->nuevo_folio.'</td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: right;">ID: '.barras($row->movimientoID).'</td>
            </tr>
        </table>';
        
        return $tabla;
    }

    function detalle($movimientoID)/*HOJA DE PEDIDO hoja 1*/
    {
        $query = $this->getDetalle($movimientoID);
        
        $tabla = '
        <style>
        table
        {
        	font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;
        }
        th
        {
        	font-weight: normal;
        	border-bottom: 2px solid #000000;
        }
        td
        {
        	border-bottom: 1px solid #000000;
        }
        </style>';
        
        $tabla.= '<table cellpadding="4">
         
        <thead>
        

              
          
            <tr>
                <th width="50px">Clave</th>
                <th width="130px">Nom. Generico</th>
                <th width="160px">Descripci&oacute;n</th>
                <th width="130px">Presentacion</th>
                <th width="50px" align="right">Costo</th>
                <th width="40px" align="right">Sur.</th>
                <th width="50px" align="right">Importe</th>
                <th width="50px" align="right">IVA</th>
                <th width="50px" align="right">LOT CAD</th>
            </tr>
        </thead>
        <tbody>
        ';

        $importeTotal = 0;
        $piezas = 0;
        $ivaTotal = 0;
        $total = 0;

        foreach($query->result() as $row)
        {

            $importe = $row->costo * $row->piezas;
            
            if($row->tipoprod == 0)
            {
                $iva = 0;
            }else{
                $iva = $row->costo * $row->piezas * IVA;
            }
            
            $subtotal = $importe + $iva;
            
            
            $tabla.= '<tr>
                <td width="50px">'.$row->cvearticulo.'</td>
                <td width="130px">'.trim($row->comercial.' '.$row->susa).'</td>
                <td width="160px">'.$row->descripcion.'</td>
                <td width="130px">'.$row->pres.'</td>
                <td width="50px" align="right">'.number_format($row->costo, 2).'</td>
                <td width="40px" align="right">'.number_format($row->piezas, 0).'</td>
                <td width="50px" align="right">'.number_format($importe, 2).'</td>
                <td width="50px" align="right">'.number_format($iva, 2).'</td>
                <td width="50px" align="left">'.$row->lote.' - '.formato_caducidad($row->caducidad).'</td>
            </tr>
            ';


            $importeTotal = $importeTotal + $importe;
            $piezas = $piezas + $row->piezas;
            $ivaTotal = $ivaTotal + $iva;
            $total = $total + $subtotal;

        }
            
        

        
        $tabla.= '</tbody>
        <tfoot>
            <tr>
                <td colspan="5" align="right">Subtotales</td>
                <td align="right">'.number_format($piezas, 0).'</td>
                <td align="right">'.number_format($importeTotal, 2).'</td>
                <td align="right">'.number_format($ivaTotal, 2).'</td>
                <td align="right">&nbsp;</td>
            </tr>
            
            <tr>
                <td colspan="7" align="right">Total de documento</td>
                <td align="right">'.number_format(($importeTotal + $ivaTotal), 2).'</td>
                <td align="right">&nbsp;</td>
            </tr>
           
        </tfoot>
        </table>';
        
     
        
        return $tabla;
    }
    
    function embarque($movimientoID)
    {
        $this->db->where('movimientoID', $movimientoID);
        $query = $this->db->get('movimiento_embarque');
        return $query;
    }

    function formato01($movimientoID)/*Formato de embarque HOJA 2*/
    {
        $query2 = $this->embarque($movimientoID);
        if($query2->num_rows() > 0)
        {
            $row2 = $query2->row();
            $embarco = $row2->embarco;
            $operador = $row2->operador;
            $unidad = $row2->unidad;
            $placas = $row2->placas;
            $cajas = $row2->cajas;
            $hieleras = $row2->hieleras;
            $surtio = $row2->surtio;
            $valido = $row2->valido;
            $observaciones = $row2->observaciones;
        }else{
            $embarco = null;
            $operador = null;
            $unidad = null;
            $placas = null;
            $cajas = null;
            $hieleras = null;
            $surtio = null;
            $valido = null;
            $observaciones = null;
            
        }
        

        $query = $this->getMovimientoByMovimientoID($movimientoID);
        $row = $query->row();

        $alm_formato='<table cellspacing="0" cellpadding="4" border="1" width="720">

<tr align="center">
<td>Embarco:</td>
<td colspan="2">'.$embarco.'</td>
<td colspan="6" rowspan="5">Movimiento ID:<h1>'.$row->movimientoID.'</h1>Fecha:<h1>'.$row->fecha.'</h1></td>
</tr>

<tr align="center">
<td>Operador:</td>
<td colspan="2">'.$operador.'</td>
</tr>

<tr align="center">
<td>Unidad:</td>
<td colspan="2">'.$unidad.'</td>
</tr>

<tr align="center">
<td>Placas:</td>
<td colspan="2">'.$placas.'</td>
</tr>

<tr align="center">
<td colspan="3"><br/><br /><br /></td>
</tr>

<tr >
<td colspan="9" style="font-size: xx-large">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Numero de Cajas:'.$cajas.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Numero de Hieleras:'.$hieleras.'</td>
</tr>

<tr >
<td colspan="9" style="font-size: xx-large">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Surtio:'.$surtio.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Validado por:'.$valido.'</td>
</tr>


<tr align="LEFT">
<td colspan="9"></td>
</tr>

<tr align="LEFT">
<td colspan="9" style="font-size: xx-large" ><br/>Observaciones:<br/> '.$observaciones.'</td>
</tr>





<tr  align="center">
<td colspan="9">NOMBRE Y FIRMA DE QUIEN EMBARCA</td>
</tr>

<tr align="center">
<td colspan="8" rowspan="2">'.$embarco.'</td>

<td bgcolor="BLACK"></td>
</tr>

<tr align="center">
<td bgcolor="BLACK"></td>


</tr>



<tr >
<td colspan="9">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;AUTORIZO&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;RESPONSABLE</td>
</tr>

<tr align="center">
<td colspan="4" rowspan="2"></td>
<td colspan="4" rowspan="2"></td>
<td bgcolor="BLACK" ></td>
</tr>



<tr align="center">
<td bgcolor="BLACK"></td>


</tr>

<tr align="center">
<td colspan="9" ></td>

</tr>






<tr align="center">
<td colspan="2">Firma del Operador:</td>
<td colspan="5">Sucursal</td>
<td colspan="2">Sello Unidad Hospitalaria:</td>
</tr>
<tr align="center">
<td colspan="2">'.$operador.'<br /><br /><br /></td>
<td colspan="5"> '.$row->sucursal_referencia.'</td>
<td colspan="2" rowspan="3"></td>
</tr>
<tr align="center">
<td colspan="5"><br/><br/>Nombre,Cargo y Firma de quien recibe <br/><br/></td>
<td colspan="2">Fecha y hora de recepción</td>
</tr>
<tr align="center">
<td colspan="7"></td>
</tr>
<tr align="center">
<td colspan="9" bgcolor="#666666 "></td>
</tr>

</table>';

        return $alm_formato;
    }
    
    function opcionesDevolucion()
    {
        $this->db->where('id', 1);
        $query = $this->db->get('opcion_devolucion');
        return $query->row();
    }

    function formato02($movimientoID)/*Formato de devoluciones HOJA 3*/
    {
        $query2 = $this->embarque($movimientoID);
        if($query2->num_rows() > 0)
        {
            $row2 = $query2->row();
            $embarco = $row2->embarco;
            $operador = $row2->operador;
            $unidad = $row2->unidad;
            $placas = $row2->placas;
            $cajas = $row2->cajas;
            $hieleras = $row2->hieleras;
            $surtio = $row2->surtio;
            $valido = $row2->valido;
            $observaciones = $row2->observaciones;
        }else{
            $embarco = null;
            $operador = null;
            $unidad = null;
            $placas = null;
            $cajas = null;
            $hieleras = null;
            $surtio = null;
            $valido = null;
            $observaciones = null;
            
        }
        

        $query = $this->getMovimientoByMovimientoID($movimientoID);
        $row = $query->row();
        
        $row3 = $this->opcionesDevolucion();
        
        $alm_formato1='<table cellspacing="0" cellpadding="4" border="0.8" width="720">
        
<tr align="center">
<td colspan="11" bgcolor="#C8C8C8"> FORMATO DE INCIDENCIAS</td>
</tr>
<tr align="center">
<td>Num.Suc</td>
<td colspan="7">'.$row->clvsucursalReferencia.'</td>
<td colspan="3" rowspan="4">Nombre y Firma de quien elaboro incidencias</td>
</tr>

<tr align="center">
<td>Cliente:</td>
<td colspan="7">'.$row->sucursal_referencia.'</td>
</tr>

<tr align="center">
<td>Operador:</td>
<td colspan="7">'.$operador.' </td>
</tr>

<tr align="lefth" >
<td  colspan="11" bgcolor="#F3F3F3">'.$row3->devolucion.''.$row3->devolucion1.''.$row3->devolucion2.'</td>
</tr>

<tr align="center">
<td  bgcolor="#C8C8C8">Causa</td>
<td colspan="2" bgcolor="#C8C8C8">Clave</td>
<td colspan="3" bgcolor="#C8C8C8">Descripcion</td>
<td bgcolor="#C8C8C8">Lote</td>
<td bgcolor="#C8C8C8">Caducidad</td>
<td bgcolor="#C8C8C8">Cantidad</td>
<td colspan="2" bgcolor="#C8C8C8">Observaciones</td>
</tr>

<tr align="center">
<td ></td>
<td colspan="2"></td>
<td colspan="3"></td>
<td ></td>
<td ></td>
<td ></td>
<td colspan="2"></td>
</tr>

<tr align="center">
<td ></td>
<td colspan="2"></td>
<td colspan="3"></td>
<td ></td>
<td ></td>
<td ></td>
<td colspan="2"></td>
</tr>

<tr align="center">
<td ></td>
<td colspan="2"></td>
<td colspan="3"></td>
<td ></td>
<td ></td>
<td ></td>
<td colspan="2"></td>
</tr>

<tr align="center">
<td ></td>
<td colspan="2"></td>
<td colspan="3"></td>
<td ></td>
<td ></td>
<td ></td>
<td colspan="2"></td>
</tr>

<tr align="center">
<td ></td>
<td colspan="2"></td>
<td colspan="3"></td>
<td ></td>
<td ></td>
<td ></td>
<td colspan="2"></td>
</tr>

<tr align="center">
<td ></td>
<td colspan="2"></td>
<td colspan="3"></td>
<td ></td>
<td ></td>
<td ></td>
<td colspan="2"></td>
</tr>

<tr align="center">
<td ></td>
<td colspan="2"></td>
<td colspan="3"></td>
<td ></td>
<td ></td>
<td ></td>
<td colspan="2"></td>
</tr>

<tr align="center">
<td ></td>
<td colspan="2"></td>
<td colspan="3"></td>
<td ></td>
<td ></td>
<td ></td>
<td colspan="2"></td>
</tr>

<tr align="center">
<td ></td>
<td colspan="2"></td>
<td colspan="3"></td>
<td ></td>
<td ></td>
<td ></td>
<td colspan="2"></td>
</tr>
<tr align="center">
<td ></td>
<td colspan="2"></td>
<td colspan="3"></td>
<td ></td>
<td ></td>
<td ></td>
<td colspan="2"></td>
</tr>

<tr align="center">
<td ></td>
<td colspan="2"></td>
<td colspan="3"></td>
<td ></td>
<td ></td>
<td ></td>
<td colspan="2"></td>
</tr>

<tr align="center">
<td ></td>
<td colspan="2"></td>
<td colspan="3"></td>
<td ></td>
<td ></td>
<td ></td>
<td colspan="2"></td>
</tr>

<tr align="center">
<td ></td>
<td colspan="2"></td>
<td colspan="3"></td>
<td ></td>
<td ></td>
<td ></td>
<td colspan="2"></td>
</tr>

<tr align="center">
<td ></td>
<td colspan="2"></td>
<td colspan="3"></td>
<td ></td>
<td ></td>
<td ></td>
<td colspan="2"></td>
</tr>

<tr align="center">
<td ></td>
<td colspan="2"></td>
<td colspan="3"></td>
<td ></td>
<td ></td>
<td ></td>
<td colspan="2"></td>
</tr>

<tr align="center">
<td ></td>
<td colspan="2"></td>
<td colspan="3"></td>
<td ></td>
<td ></td>
<td ></td>
<td colspan="2"></td>
</tr>

<tr align="center">
<td ></td>
<td colspan="2"></td>
<td colspan="3"></td>
<td ></td>
<td ></td>
<td ></td>
<td colspan="2"></td>
</tr>

<tr align="center">
<td ></td>
<td colspan="2"></td>
<td colspan="3"></td>
<td ></td>
<td ></td>
<td ></td>
<td colspan="2"></td>
</tr>

<tr align="center">
<td ></td>
<td colspan="2"></td>
<td colspan="3"></td>
<td ></td>
<td ></td>
<td ></td>
<td colspan="2"></td>
</tr>

<tr align="center">
<td ></td>
<td colspan="2"></td>
<td colspan="3"></td>
<td ></td>
<td ></td>
<td ></td>
<td colspan="2"></td>
</tr>

<tr align="center">
<td ></td>
<td colspan="2"></td>
<td colspan="3"></td>
<td ></td>
<td ></td>
<td ></td>
<td colspan="2"></td>
</tr>

<tr align="center">
<td ></td>
<td colspan="2"></td>
<td colspan="3"></td>
<td ></td>
<td ></td>
<td ></td>
<td colspan="2"></td>
</tr>

<tr align="center">
<td ></td>
<td colspan="2"></td>
<td colspan="3"></td>
<td ></td>
<td ></td>
<td ></td>
<td colspan="2"></td>
</tr>

<tr align="center">
<td ></td>
<td colspan="2"></td>
<td colspan="3"></td>
<td ></td>
<td ></td>
<td ></td>
<td colspan="2"></td>
</tr>

<tr align="center">
<td ></td>
<td colspan="2"></td>
<td colspan="3"></td>
<td ></td>
<td ></td>
<td ></td>
<td colspan="2"></td>
</tr>


<tr align="left">
<td colspan="11"> 

<h1 style="color:red; font-size:28px;">NOTA: POR ESTE CONDUCTO RECIBIMOS LAS INCIDENCIAS Y DEVOLUCIONES DETECTADAS EN SU FOLIO DE ENVIO, CONFORME A LA VERIFICACION DE LOS PRODUCTOS QUE RECIBIO FISICAMENTE, Y CUYA CANTIDAD SERA DESCONTADA DE DICHO  FOLIO.</h1>

 </td>
</tr>



</table>';

        return $alm_formato1;
    }
    
    function cargaPedido($referencia, $movimientoID)
    {
        
        $result = $this->getPedido($referencia);
        
        if(count($result['detalle']) > 0)
        {
            //referencia, clave, cansur, lote, caducidad
            
            $a = array();
            
            foreach($result['detalle'] as $row)
            {
                $row['referencia'] = $referencia;
                $row['movimientoID'] = $movimientoID;
                array_push($a, $row);
            }
            
            $this->db->insert_batch('pedido_transpaso', $a);
            
            $sql = "insert into movimiento_detalle (movimientoID, id, piezas, costo, lote, caducidad, ean, marca)(SELECT movimientoID, a.id, cansur, 0, lote, caducidad, 0, '' FROM pedido_transpaso p
    join articulos a on p.clave = a.cvearticulo
    where movimientoID = ? and referencia = ?);";
            
            $this->db->query($sql, array($movimientoID, $referencia));
            
        }
    }
    
    function cargaPedidoUnidades($referencia, $movimientoID)
    {
        $this->json = $this->__get_data($this->__getCatalogo('movimientoDetalle', $referencia), $referencia);
        
        $arreglo = json_decode($this->json, true);
        
        if(count($arreglo) > 0)
        {
            //referencia, clave, cansur, lote, caducidad
            
            $a = array();
            
            foreach($arreglo as $row)
            {
                $row['movimientoID'] = $movimientoID;
                array_push($a, $row);
            }
            
            $this->db->insert_batch('movimiento_detalle', $a);
            
        }
    }

    function getPedido($referencia)
    {
        //$username = 'admin';
        //$password = '1234';
         
        // Alternative JSON version
        // $url = 'http://twitter.com/statuses/update.json';
        // Set up and execute the curl process
        $curl_handle = curl_init();
       	$timeout = 2;
        curl_setopt($curl_handle, CURLOPT_URL, $this->urlExchange.'getPedido');
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_handle, CURLOPT_POST, 1);
    	curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, array('referencia' => $referencia));
         
        // Optional, delete this line if your API is open
        //curl_setopt($curl_handle, CURLOPT_USERPWD, $username . ':' . $password);
         
        $buffer = curl_exec($curl_handle);
        curl_close($curl_handle);
         
        $result = json_decode($buffer, true);
        
        return $result;
    }
    
    function getPedidoUnidad($referencia)
    {
        //$username = 'admin';
        //$password = '1234';
         
        // Alternative JSON version
        // $url = 'http://twitter.com/statuses/update.json';
        // Set up and execute the curl process
        $curl_handle = curl_init();
    	$timeout = 2;
        
        curl_setopt($curl_handle, CURLOPT_URL, 'http://189.203.201.184/oaxacacentral/index.php/catalogos/movimientoDetalle/referencia/'.$referencia.'/format/json');
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_handle, CURLOPT_POST, 1);
    	curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, array('referencia' => $referencia));
         
        // Optional, delete this line if your API is open
        //curl_setopt($curl_handle, CURLOPT_USERPWD, $username . ':' . $password);
         
        $buffer = curl_exec($curl_handle);
        curl_close($curl_handle);
         
        $result = json_decode($buffer, true);
        
        return $result;
    }

    function modificaDetalle($data, $movimientoDetalle)
    {
        $this->db->update('movimiento_detalle', $data, array('movimientoDetalle' => $movimientoDetalle));
    }
    
    function getAreasGuia($movimientoID)
    {
        $sql = "SELECT areaID, area FROM movimiento_prepedido m
join articulos a using(id)
left join inventario i using(id)
left join ubicacion u using(ubicacion)
where m.movimientoID = ? and cantidad > 0
group by areaID;";
        $query = $this->db->query($sql, (int)$movimientoID);

        return $query;
    }
    
    function getProductosFolprv($folprv)
    {
        $arreglo = $this->util->getDataOficina('ordenDetalle', array('folprv' => $folprv));
        foreach($arreglo as $a)
        {
            if(PATENTE == 1)
            {
                $this->__agregaArticuloPatente($a->codigo);
            }else{
                $this->__agregaArticulo($a->clagob);
            }
        }
        
    }
    
    function __agregaArticulo($clave)
    {
        $this->load->model('Catalogosweb_model');
        $clave = trim(str_replace('/', '|', $clave));
        $articulo = $this->util->getDataOficina('articuloClave', array('clave' => $clave));
        
        
        if(!isset($articulo->error))
        {
            foreach($articulo as $a)
            {
                $this->Catalogosweb_model->insertaArticulo($a);
            }
            
        }
    }
    
    function __agregaArticuloPatente($clave)
    {
        echo $clave;
        $this->load->model('Catalogosweb_model');
        $articulo = $this->util->getDataOficina('patenteSinOrigen', array('ean' => $clave));
        
        
        if(!isset($articulo->error))
        {
            foreach($articulo as $a)
            {
                $this->Catalogosweb_model->insertaArticulo3($a);
            }
            
        }
    }

    function cierrePrepedido($movimientoID)
    {
        $data = array(
            'statusPrepedido' => 1
        );
        
        $this->db->update('movimiento', $data, array('movimientoID' => $movimientoID));
    }
    
    function getNuevoFolioFromReferencia($referencia)
    {
        $sql = "SELECT nuevo_folio FROM movimiento m where referencia = ? and nuevo_folio > 0 limit 1;";
        $query = $this->db->query($sql, (string)$referencia);
        
        return $query;
    }
    
    function asignaFactura($movimientoID, $referencia)
    {
        
        $query = $this->getNuevoFolioFromReferencia($referencia);
        
        
        if($query->num_rows() == 0)
        {
            $folio = $this->util->getDataOficina('folio', array('foliador' => $this->session->userdata('cxp')));
        }else{
            $row = $query->row();
            
            $folio = new StdClass();
            $folio->folio = $row->nuevo_folio;
        }
        
        
        
        $data = array('referencia' => $referencia, 'asignaFactura' => 1, 'nuevo_folio' => $folio->folio);
        $this->db->set('asignaFacturaFecha', 'now()', false);
        $this->db->update('movimiento', $data, array('movimientoID' => $movimientoID));
    }
    
    function getClientesBySucursal($clvsucursal)
    {
        $sql = "SELECT * FROM receptores_sucursal r
JOIN receptores e using(rfc)
where clvsucursal = ?;";

        $query = $this->db->query($sql, $clvsucursal);
        
        return $query;
    }
    
    function getClientesByMovimientoID($movimientoID)
    {
        $sql = "SELECT * FROM receptores_sucursal r
JOIN receptores e using(rfc)
where clvsucursal = (select clvsucursalReferencia from movimiento where movimientoID = ?);";

        $query = $this->db->query($sql, (int)$movimientoID);
        
        return $query;
    }
    
    function getClientesByMovimientoIDCombo($movimientoID)
    {
        $query = $this->getClientesByMovimientoID($movimientoID);
        
        $a = array();
        
        foreach($query->result() as $row)
        {
            $a[$row->rfc] = $row->rfc . ' - ' . $row->razon;
        }
        
        return $a;
    }
    
    function getContratoCombo($rfc)
    {
        $this->db->where('rfc', $rfc);
        $query = $this->db->get('contrato');
        
        if($query->num_rows() > 0)
        {
            $a = '';
            foreach($query->result() as $row)
            {
                $a .= '
                <option value="'.$row->contratoID.'">'.$row->denominado.' - '.$row->numero.'</option>';
            }
            
            return $a;
            
        }else{
            return null;
        }
    }
    
    function getFacturaProductosByContratoID($contratoID, $movimientoID)
    {
        $sql = "SELECT * FROM movimiento_detalle m
join articulos a using(id)
left join contrato_precio c on m.id = c.id and contratoID = ?
left join ubicacion using(ubicacion)
where movimientoID = ?;";
        
        $query = $this->db->query($sql, array($contratoID, $movimientoID));
        
        return $query;
    }
    
    function getFacturaReferencia($contratoID = 0, $movimientoID)
    {
        if($contratoID <> 0)
        {
            $query = $this->Catalogosweb_model->getContratoByContratoID($contratoID);
            $row = $query->row();

            $licitacion = $row->numero;
            $string = $row->referencia_factura;
            $nombre_corto = $row->denominado;
        }else{
            $licitacion = null;
            $string = null;
            $nombre_corto = null;
        }
        
        
        $query2 = $this->getMovimientoByMovimientoID($movimientoID);
        $row2 = $query2->row();
        
        $mes_actual = $this->getMesActual();
        $anio_actual = date('Y');
        
        $nombre_sucursal = $row2->sucursal_referencia;
        $direccion_sucursal = $row2->domicilio;
        $referencia_pedido = $row2->observaciones;
        $anio_pedido = $row2->anio;
        $mes_pedido = $this->getMesNombre($row2->mes);
        $sucursal_personalizado_nombre = $row2->nombreSucursalPersonalizado;
        $sucursal_personalizado_direccion = $row2->domicilioSucursalPersonalizado;
        
        $este = array('$licitacion', '$mes_actual', '$anio_actual', '$nombre_corto', '$nombre_sucursal', '$direccion_sucursal', '$referencia_pedido', '$anio_pedido', '$mes_pedido', '$sucursal_personalizado_nombre', '$sucursal_personalizado_direccion');
        $por = array($licitacion, $mes_actual, $anio_actual, $nombre_corto, $nombre_sucursal, $direccion_sucursal, $referencia_pedido, $anio_pedido, $mes_pedido, $sucursal_personalizado_nombre, $sucursal_personalizado_direccion);
        
        $string = str_replace($este, $por, $string);
        
        return $string;
    }
    
    function getMesActual()
    {
        $mes = date('m');
        return $this->getMesNombre($mes);
    }
    
    function getMesNombre($mes)
    {
        $mes = (int)$mes;
        
        $a = array(
            1 => 'ENERO',
            2 => 'FEBRERO',
            3 => 'MARZO',
            4 => 'ABRIL',
            5 => 'MAYO',
            6 => 'JUNIO',
            7 => 'JULIO',
            8 => 'AGOSTO',
            9 => 'SEPTIEMBRE',
            10 => 'OCTUBRE',
            11 => 'NOVIEMBRE',
            12 => 'DICIEMBRE'
        );
        
        return $a[$mes];
    }
    
    function transferAplica($movimientoID, $inventarioID, $valor)
    {
        $query = $this->getInventarioByID($inventarioID);
        $inv = $query->row();
        
        $data = array('movimientoID' => $movimientoID, 'id' => $inv->id, 'piezas' => $valor, 'costo' => $inv->costo, 'lote' => $inv->lote, 'caducidad' => $inv->caducidad, 'ean' => $inv->ean, 'marca' => $inv->marca, 'ubicacion' => $inv->ubicacion, 'comercial' => $inv->comercial);
        $this->db->insert('movimiento_detalle', $data);
    }
    
    function getAreaLimit1()
    {
        $sql = "SELECT * FROM area a limit 1;";
        $query = $this->db->query($sql);
        
        if($query->num_rows() > 0)
        {
            $row = $query->row();
            return $row->areaID;
        }else{
            return 0;
        }
    }
    
    function getAreaIDDropdown()
    {
        $sql = "SELECT * FROM area a;";
        $query = $this->db->query($sql);
        
        $a = array();
        
        foreach($query->result() as $row)
        {
            $a[$row->areaID] = $row->area;
        }
        
        return $a;
    }
}