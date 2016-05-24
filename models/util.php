<?php
class Util extends CI_Model {
    
    var $urlPost = "http://189.203.201.184/oaxacacentral/index.php/catalogos/";
    var $urlPostFacturacion = "http://192.168.1.200/fe/index.php/api/factura/";
    var $version = '1.0.5';
    var $fechaVersion = '01/05/2015';
    var $formato_datos = "/format/json";
    var $oficinaLocal;
    var $oficinaForanea;

    /**
     * Catalogos_model::__construct()
     * 
     * @return
     */
    function __construct()
    {
        parent::__construct();
        $this->oficinaLocal = 'http://192.168.1.220/oficinas/exchange/';
        $this->oficinaForanea = 'http://189.203.201.166/oficinas/exchange/';
    }
    
    function getConfig()
    {
        $data = new stdClass();
        //config, tengoCentral, soyAlmacen, central
        if ($this->db->table_exists('config'))
        {
            $this->db->where('config', 1);
            $query = $this->db->get('config');
            
            if($query->num_rows() > 0)
            {
                $row = $query->row();
                $data->config = $row->config;
                $data->tengoCentral = $row->tengoCentral;
                $data->soyAlmacen = $row->soyAlmacen;
                $data->central = $row->central;
            }else{
                $data->config = 0;
                $data->tengoCentral = 1;
                $data->soyAlmacen = 0;
                $data->central = '';
            }
            
        }else{
            $data->config = 0;
            $data->tengoCentral = 1;
            $data->soyAlmacen = 0;
            $data->central = '';
        }
        
        return $data;
        
    }
    
    function getVersion()
    {
        return $this->version;
    }
    
    function getFechaVersion()
    {
        return $this->fechaVersion;
    }
    
    function getRecetasIncorrectas()
    {
        $sql = "SELECT * FROM rechecar_final c
join receta r using(clvsucursal, folioreceta) where checado = 0;";
        $query = $this->db->query($sql);
        return $query;
    }
    
    function getCaducidades()
    {
        $a = array(
            '0' => 'Caducados',
            '1' => 'Hasta 3 Meses',
            '2' => 'Desde 3 hasta 6 Meses',
            '3' => 'Desde 6 hasta 12 Meses',
            '4' => 'Mayores a 12 Meses'
            );
            
        return $a;
    }
    
    function getSemaforoCombo()
    {
        $query = $this->db->get('semaforo');
        
        $a = array();
        
        foreach($query->result() as $row)
        {
            $a[$row->semaforo] = $row->semaforoDescripcion;
        }
        
        return $a;
    }
    
    function getDescripcionTipos($subtipoMovimiento)
    {
        $sql = "SELECT * FROM tipo_movimiento t
join subtipo_movimiento s using(tipoMovimiento)
where subtipoMovimiento = ?;";
        
        $query = $this->db->where($sql, $subtipoMovimiento);
        
        if($query->num_rows() > 0)
        {
            $row = $query->row();
            return $row->tipoMovimientoDescripcion . ' - ' . $row->subtipoMovimientoDescripcion;
        }else{
            return null;
        }
    }
    
    function getSucursalesCombo()
    {
        $query = $this->db->get('sucursales');
        
        $a = array();
        
        foreach($query->result() as $row)
        {
            $a[$row->clvsucursal] = $row->clvsucursal.' - '.$row->descsucursal;
        }
        
        return $a;
    }
    
    function getJurisCombo()
    {
        $query = $this->db->get('jurisdiccion');
        
        $a = array();
        
        foreach($query->result() as $row)
        {
            $a[$row->numjurisd] = $row->numjurisd.' - '.$row->jurisdiccion;
        }
        
        return $a;
    }

    function getPuestoCombo()
    {
        $query = $this->db->get('puesto');
        
        $a = array();
        
        foreach($query->result() as $row)
        {
            $a[$row->clvpuesto] = $row->puesto;
        }
        
        return $a;
    }

    function getDevolucionCausasCombo()
    {
        $query = $this->db->get('devolucion_causa');
        
        $a = array();
        
        foreach($query->result() as $row)
        {
            $a[$row->causaID] = $row->causaDescripcion.' ('.$row->opcion.')';
        }
        
        return $a;
    }

    function getActivoCombo()
    {
        $query = $this->db->get('activo');
        
        $a = array();
        
        foreach($query->result() as $row)
        {
            $a[$row->activo] = $row->activoDescripcion;
        }
        
        return $a;
    }

    function getArticuloComboFaltaUbicacion()
    {
        $sql = "SELECT * FROM articulos a where activo = 1 and tipoPresentacion = 1 and id not in(SELECT id FROM posicion p
join pasillo a using(pasilloID) where id > 0 and pasilloTipo = 1) order by tipoprod, cvearticulo * 1;";

        $sql = "SELECT * FROM articulos a where activo = 1 and tipoPresentacion = 1 order by tipoprod, cvearticulo * 1;";

        $query = $this->db->query($sql);
        
        $a = array('0' => 'SELECCIONA UNA CLAVE');
        
        foreach($query->result() as $row)
        {
            $a[$row->id] = $row->cvearticulo.'|'.$row->susa.'|'.$row->descripcion.'|'.$row->pres;
        }
        
        return $a;
    }

    function getUbicacionesDisponibles($inventarioID)
    {
        $sql = "SELECT pasilloTipo, areaID, pasilloID, posicionID, nivelID, moduloID, id, ubicacion, pasillo, rackID, sentido, area, pasilloTipoDescripcion, 'RECOMENDADO' as atributo
FROM posicion p
join pasillo o using(pasilloID)
join area a using(areaID)
join pasillo_tipo t using(pasilloTipo)
where id in(select id from inventario where inventarioID = ?)
union all
SELECT pasilloTipo, areaID, pasilloID, posicionID, nivelID, moduloID, id, ubicacion, pasillo, rackID, sentido, area, pasilloTipoDescripcion, 'LIBRE' as atributo
FROM posicion p
join pasillo o using(pasilloID)
join pasillo_tipo t using(pasilloTipo)
join area a using(areaID)
where id = 0;";

        $query = $this->db->query($sql, $inventarioID);
        
        $a = array('0' => 'SELECCIONA UNA UBICACION');
        
        foreach($query->result() as $row)
        {
            $a[$row->ubicacion] = $row->pasilloID . '-' . $row->moduloID . '-' . $row->nivelID . '-' . $row->posicionID . ' | ' . $row->area . ' ' . $row->pasillo . ' (' . $row->atributo . ')';
        }
        
        return $a;
    }

    function getUbicacionesAsignadas($inventarioID)
    {
        $sql = "SELECT * FROM posicion p where id = (select id from inventario where inventarioID = ?) order by pasilloID, moduloID, nivelID, posicionID ;";

        $query = $this->db->query($sql, $inventarioID);
        
        $a = array('0' => 'SELECCIONA UNA UBICACION');
        
        foreach($query->result() as $row)
        {
            $a[$row->ubicacion] = $row->pasilloID.'-'.$row->moduloID.'-'.$row->nivelID.'-'.$row->posicionID;
        }
        
        return $a;
    }

    function getProveedorCombo()
    {
        $query = $this->db->get('proveedor');
        
        $a = array();
        
        foreach($query->result() as $row)
        {
            $a[$row->proveedorID] = $row->rfc . ' - ' . $row->razon;
        }
        
        return $a;
    }

    function getSubtipoMovimientoCombo()
    {
        $sql = "SELECT * FROM subtipo_movimiento s join tipo_movimiento t using(tipoMovimiento)
order by tipoMovimiento, subtipoMovimiento;";

        $query = $this->db->query($sql);
        
        $a = array('0' => 'TODOS');
        
        foreach($query->result() as $row)
        {
            $a[$row->subtipoMovimiento] = $row->subtipoMovimientoDescripcion . ' ( ' . $row->tipoMovimientoDescripcion.' )';
        }
        
        return $a;
    }

    function getLoteComodinCombo()
    {
        
        $a = array('SL' => 'SL');
        
        return $a;
    }
    
    function actualizacion()
    {
        $this->db->order_by('ultima_actualizacion');
        return $this->db->get('actualizacion');
    }
    

    function getInventarioExportar()
    {
        $this->load->library('Services_JSON');
        
        $this->db->where_not_in('cantidad', array(0));
        $query = $this->db->get('inventario');
        
        $a = array();
        
        foreach($query->result() as $row)
        {
            array_push($a, $row);
        }
        
        $j = new Services_JSON();
        return $j->encode($a);
    }
    
    function getInventarioRecetaExportar($receta)
    {
        $this->load->library('Services_JSON');
        
        $sql = "SELECT i.* 
        FROM receta_detalle r
join inventario i on r.id = i.id and r.lote = i.lote 
where consecutivo = ?;";
        $query = $this->db->query($sql, $receta);
        
        $a = array();
        
        foreach($query->result() as $row)
        {
            array_push($a, $row);
        }
        
        $j = new Services_JSON();
        return $j->encode($a);
    }

    function getMovimientoExportar($movimientoID)
    {
        $this->load->library('Services_JSON');
        
        $this->db->where('movimientoID', $movimientoID);
        $query = $this->db->get('movimiento');

        $this->db->select('d.*');
        $this->db->from('movimiento c');
        $this->db->join('movimiento_detalle d', 'c.movimientoID = d.movimientoID');
        $this->db->where('c.movimientoID', $movimientoID);
        $query2 = $this->db->get();

        $this->db->select('d.*');
        $this->db->from('movimiento c');
        $this->db->join('movimiento_embarque d', 'c.movimientoID = d.movimientoID');
        $this->db->where('c.movimientoID', $movimientoID);
        $query3 = $this->db->get();
        
        $sql4 = "SELECT o.* FROM movimiento m
join movimiento_detalle d using(movimientoID)
join devolucion o using(movimientoDetalle)
where movimientoID = ?;";
        $query4 = $this->db->query($sql4, $movimientoID);
        

        $sql5 = "SELECT proveedorID, rfc, razon, ".$this->session->userdata('clvsucursal')." as clvsucursal FROM proveedor p;";
        $query5 = $this->db->query($sql5);

        $a = array();
        
        foreach($query->result() as $row)
        {
            array_push($a, $row);
        }
        
        $b = array();
        
        foreach($query2->result() as $row)
        {
            array_push($b, $row);
        }

        $c = array();
        
        foreach($query3->result() as $row)
        {
            array_push($c, $row);
        }
        
        $e = array();
        
        foreach($query4->result() as $row)
        {
            array_push($e, $row);
        }

        $f = array();
        
        foreach($query5->result() as $row)
        {
            array_push($f, $row);
        }

        $d = array('movimiento' => $a, 'movimientoDetalle' => $b, 'movimientoEmbarque' => $c, 'devolucion' => $e, 'proveedor' => $f);

        $j = new Services_JSON();
        $json =  $j->encode($d);
        
        return $json;
        
    }

    function getRecetaExportar($consecutivo)
    {
        $this->load->library('Services_JSON');
        
        $sql = "SELECT * FROM receta r where consecutivo = ?;";
        $query = $this->db->query($sql, array($consecutivo));

        $sql = "SELECT * FROM receta_detalle where consecutivo = ?;";
        $query2 = $this->db->query($sql, array($consecutivo));

        $a = array();
        
        foreach($query->result() as $row)
        {
            array_push($a, $row);
        }
        
        $b = array();
        
        foreach($query2->result() as $row)
        {
            array_push($b, $row);
        }

        
        $d = array('receta' => $a, 'recetaDetalle' => $b);

        $j = new Services_JSON();
        $json =  $j->encode($d);
        
        return $json;
        
    }

    function postInventario()
    {
        //$username = 'admin';
        //$password = '1234';
         
        // Alternative JSON version
        // $url = 'http://twitter.com/statuses/update.json';
        // Set up and execute the curl process
        $curl_handle = curl_init();
    	$timeout = 2;
        curl_setopt($curl_handle, CURLOPT_URL, $this->urlPost.'inventario/format/json');
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
    	curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($curl_handle, CURLOPT_POST, 1);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, array('clvsucursal' => SUCURSAL, 'json' => $this->getInventarioExportar()));
         
        // Optional, delete this line if your API is open
        //curl_setopt($curl_handle, CURLOPT_USERPWD, $username . ':' . $password);
         
        $buffer = curl_exec($curl_handle);
        curl_close($curl_handle);
         
        $result = json_decode($buffer);
        
        if(isset($result->status) && $result->status == 'success')
        {
            return true;
        }
         
        else
        {
            return false;
        }
    }

    function getFacturaDatos($contratoID, $movimientoID)
    {
        $this->load->model('movimiento_model');
        $this->load->model('Catalogosweb_model');
        $referencia = $this->movimiento_model->getFacturaReferencia($contratoID, $movimientoID);
        
        $query = $this->movimiento_model->getMovimientoByMovimientoID($movimientoID);
        $row = $query->row();

        $query2 = $this->Catalogosweb_model->getContratoByContratoID($contratoID);
        $row2 = $query2->row();
        
        $dat = array('rfc' => $row2->rfc, 'idFactura' => $row->idFactura);
        
        $productos = $this->movimiento_model->getFacturaProductosByContratoID($contratoID, $movimientoID);
        
        $i = 0;
        
        foreach($productos->result() as $p)
        {
            $b[$i]['item'] = $i;
            $b[$i]['piezas'] = $p->piezas;
            $b[$i]['unidad'] = 'PIEZAS';
            $b[$i]['ean'] = $p->cvearticulo;
            $b[$i]['descripcion'] = trim($p->comercial . ' (' . $p->susa . ') ' . $p->descripcion . ' ' . $p->pres . ' ' . $p->pasillo . ', ' . $p->piezas. ' PIEZA(S), LOTE: ' . $p->lote . ', CADUCIDAD: ' . $p->caducidad . ', ' . $p->marca); 
            $b[$i]['precio'] = $p->precioContrato;
            $b[$i]['iva'] = $p->tipoprod;
            $i++;
        }
        
        $a = array();
        $a['json']['datos'] = $dat;
        $a['json']['referencia'] = $referencia;
        $a['json']['productos'] = $b;
        
        return json_encode($a);
    }
    
    function saveFactura($result, $movimientoID)
    {
        $data = array(
            'folioFactura'  => $result->factura,
            'urlxml'        => $result->urlxml,
            'urlpdf'        => $result->urlpdf,
            'fechaFactura'  => $result->fecha,
            'idFactura'     => $result->idFactura
            );
            
        $this->db->update('movimiento', $data, array('movimientoID' => $movimientoID));
    }
    
    function postFacturar($movimientoID, $contratoID)
    {
        //$username = 'admin';
        //$password = '1234';
         
        // Alternative JSON version
        // $url = 'http://twitter.com/statuses/update.json';
        // Set up and execute the curl process
        $curl_handle = curl_init();
    	$timeout = 2;
        curl_setopt($curl_handle, CURLOPT_URL, $this->urlPostFacturacion.'facturar/format/json');
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
    	curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($curl_handle, CURLOPT_POST, 1);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, array('user' => USER_FACTURACION, 'pass' => PASS_FACTURACION, 'json' => $this->getFacturaDatos($contratoID, $movimientoID)));
         
        // Optional, delete this line if your API is open
        //curl_setopt($curl_handle, CURLOPT_USERPWD, $username . ':' . $password);
         
        $buffer = curl_exec($curl_handle);
        curl_close($curl_handle);
         
        $result = json_decode($buffer);
        
        
        if(isset($result->exito) && $result->exito == '1')
        {
            $this->saveFactura($result, $movimientoID);
            return true;
        }
         
        else
        {
            return false;
        }
    }

    function postInventarioReceta($receta)
    {
        //$username = 'admin';
        //$password = '1234';
         
        // Alternative JSON version
        // $url = 'http://twitter.com/statuses/update.json';
        // Set up and execute the curl process
        $curl_handle = curl_init();
    	$timeout = 2;
        curl_setopt($curl_handle, CURLOPT_URL, $this->urlPost.'inventarioReceta/format/json');
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
    	curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($curl_handle, CURLOPT_POST, 1);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, array('clvsucursal' => SUCURSAL, 'json' => $this->getInventarioRecetaExportar($receta)));
         
        // Optional, delete this line if your API is open
        //curl_setopt($curl_handle, CURLOPT_USERPWD, $username . ':' . $password);
         
        $buffer = curl_exec($curl_handle);
        curl_close($curl_handle);
         
        $result = json_decode($buffer);
        
        if(isset($result->status) && $result->status == 'success')
        {
            return true;
        }
         
        else
        {
            return false;
        }
    }

    function postMovimiento($movimientoID)
    {
        //$username = 'admin';
        //$password = '1234';
         
        // Alternative JSON version
        // $url = 'http://twitter.com/statuses/update.json';
        // Set up and execute the curl process
        $curl_handle = curl_init();
    	$timeout = 2;
        curl_setopt($curl_handle, CURLOPT_URL,  $this->urlPost.'movimiento/format/json');
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
    	curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($curl_handle, CURLOPT_POST, 1);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, array('clvsucursal' => SUCURSAL, 'json' => $this->getMovimientoExportar($movimientoID)));
         
        // Optional, delete this line if your API is open
        //curl_setopt($curl_handle, CURLOPT_USERPWD, $username . ':' . $password);
         
        $buffer = curl_exec($curl_handle);
        curl_close($curl_handle);
         
        $result = json_decode($buffer);
        
        if(isset($result->status) && $result->status == 'success')
        {
            $this->auditaMovimiento($movimientoID);
            return true;
        }
         
        else
        {
            return false;
        }
    }

    function postReceta($consecutivo)
    {
        //$username = 'admin';
        //$password = '1234';
         
        // Alternative JSON version
        // $url = 'http://twitter.com/statuses/update.json';
        // Set up and execute the curl process
        $curl_handle = curl_init();
    	$timeout = 2;
        curl_setopt($curl_handle, CURLOPT_URL,  $this->urlPost.'receta/format/json');
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
    	curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($curl_handle, CURLOPT_POST, 1);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, array('clvsucursal' => SUCURSAL, 'json' => $this->getRecetaExportar($consecutivo)));
         
        // Optional, delete this line if your API is open
        //curl_setopt($curl_handle, CURLOPT_USERPWD, $username . ':' . $password);
         
        $buffer = curl_exec($curl_handle);
        curl_close($curl_handle);
         
        $result = json_decode($buffer);
        
        if(isset($result->status) && $result->status == 'success')
        {
            $this->auditaReceta($consecutivo);
            return true;
        }
         
        else
        {
            return false;
        }
    }

    function postLiberareceta($consecutivo)
    {
        
        $sql = "SELECT * FROM rechecar_final r join receta c using(clvsucursal, folioreceta) where consecutivo = ?;";
        $query = $this->db->query($sql, $consecutivo);
        
        if($query->num_rows() > 0)
        {
            $row = $query->row();
            
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL,  $this->urlPost.'liberareceta/format/json');
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl_handle, CURLOPT_POST, 1);
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, array('clvsucursal' => $row->clvsucursal, 'folioreceta' => $row->folioreceta, 'cvearticulo' => $row->cvearticulo, 'observaciones' => $row->observaciones));
             
            // Optional, delete this line if your API is open
            //curl_setopt($curl_handle, CURLOPT_USERPWD, $username . ':' . $password);
             
            $buffer = curl_exec($curl_handle);
            curl_close($curl_handle);
             
            $result = json_decode($buffer);
            
            if(isset($result->status) && $result->status == 'success')
            {
                $this->db->update('rechecar_final', array('checado' => 1), array('clvsucursal' => $row->clvsucursal, 'folioreceta' => $row->folioreceta, 'cvearticulo' => $row->cvearticulo, 'observaciones' => $row->observaciones));
                return true;
            }
             
            else
            {
                return false;
            }
            
        }else{
            return false;
        }
        //$username = 'admin';
        //$password = '1234';
         
        // Alternative JSON version
        // $url = 'http://twitter.com/statuses/update.json';
        // Set up and execute the curl process
    }

    function auditaReceta($consecutivo)
    {
        $data = array('consecutivo' => $consecutivo);
        $this->db->set('ultima', 'now()', false);
        $this->db->replace('receta_audita', $data);
    }

    function auditaMovimiento($movimientoID)
    {
        $data = array('movimientoID' => $movimientoID);
        $this->db->set('ultima', 'now()', false);
        $this->db->replace('movimiento_audita', $data);
    }
    
    function getRack()
    {
        $query = $this->db->get('rack');
        
        $a = array();
        
        foreach($query->result() as $row)
        {
            $a[$row->rackID] = $row->rack;
        }
        
        return $a;
    }

    function getTipoPasillo()
    {
        $query = $this->db->get('pasillo_tipo');
        
        $a = array();
        
        foreach($query->result() as $row)
        {
            $a[$row->pasilloTipo] = $row->pasilloTipoDescripcion;
        }
        
        return $a;
    }

    function getSentidoPasillo()
    {
        $query = $this->db->get('pasillo_sentido');
        
        $a = array();
        
        foreach($query->result() as $row)
        {
            $a[$row->sentido] = $row->sentidoDescripcion;
        }
        
        return $a;
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

    function __getDataPost($url, $json)
    {
        
    	$ch = curl_init();
    	$timeout = 2;
    	curl_setopt($ch, CURLOPT_URL, $url);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, array('json' => $json));
    	$json = curl_exec($ch);
    	curl_close($ch);
        $data = json_decode($json);
        
    	return $data;
    
    }

    function __getURLLocal($cat, $data = array())
    {
        $parametros = $this->__parametros($data);
        return $this->oficinaLocal.$cat.$parametros.$this->formato_datos;
    }

    function __getURLLocalPost($cat)
    {
        return $this->oficinaLocal.$cat.$this->formato_datos;
    }

    function __getURLForanea($cat, $data = array())
    {
        $parametros = $this->__parametros($data);
        return $this->oficinaForanea.$cat.$parametros.$this->formato_datos;
    }

    function __getURLForaneaPost($cat)
    {
        return $this->oficinaForanea.$cat.$this->formato_datos;
    }

    function __parametros($data)
    {
        if(is_array($data))
        {
            if(count($data))
            {
                foreach( $data as $key => $key_value ){
        
                    $query_array[] =  $key . '/' . $key_value;
                
                }
        
                return '/'.implode( '/', $query_array );        
            }else{
                return null;
            }
        }else{
            return null;
        }
        
        
    }

    function getDataOficinaLocal($funcion, $parametros)
    {
        return $this->__getData($this->__getURLLocal($funcion, $parametros));
    }
    
    function getDataOficinaForanea($funcion, $parametros)
    {
        return $this->__getData($this->__getURLForanea($funcion, $parametros));
    }

    function getDataOficina($funcion, $parametros)
    {
        $respuestaLocal = $this->__getData($this->__getURLLocal($funcion, $parametros));
        if($respuestaLocal == null)
        {
            return $this->__getData($this->__getURLForanea($funcion, $parametros));
        }else{
            return $respuestaLocal;
        } 
    }
    
    function getOrdenPostJson($movimientoID)
    {
        $sql1 = "SELECT * FROM movimiento m where movimientoID = ?;";
        
        $query1 = $this->db->query($sql1, $movimientoID);
        
        if($query1->num_rows() > 0)
        {
            $row1 = $query1->row();
            
            if($row1->orden > 0)
            {
                
                $arr = array();
                $arr['orden'] = $row1->orden;
                
                $sql2 = "SELECT cvearticulo, piezas FROM movimiento_detalle m
join articulos a using(id) where movimientoID = ?;";
                
                $query2 = $this->db->query($sql2, $movimientoID);
                
                $i = 0;
                foreach($query2->result()  as $row2)
                {
                    $arr['detalle'][$i]['clave'] = $row2->cvearticulo;
                    $arr['detalle'][$i]['piezas'] = $row2->piezas;
                    $i++;
                }
                
                 
            }else{
                $arr = array();
            }
            
            
        }else{
            $arr = array();
        }
        
        return json_encode($arr);
        
    }
    
    function postDataOficina($funcion, $json)
    {
        $respuestaLocal = $this->__getDataPost($this->__getURLLocalPost($funcion), $json);
        if($respuestaLocal == null)
        {
            return $this->__getDataPost($this->__getURLForaneaPost($funcion), $json);
        }else{
            return $respuestaLocal;
        } 
    }

    function actSucursales()
    {
       
        $arreglo = json_decode(json_encode($this->getDataOficina('sucursal', array())), true);
        $this->db->insert_batch('sucursales', $arreglo, TRUE);
    }
    
    function queryUbicacionesComboByClave($cvearticulo)
    {
        $sql = "select *
from (
SELECT pasilloTipo, areaID, pasilloID, posicionID, nivelID, moduloID, id, ubicacion, pasillo, rackID, sentido, area, pasilloTipoDescripcion, 'RECOMENDADO' as atributo, 1 as atributoID
FROM posicion p
join pasillo o using(pasilloID)
join area a using(areaID)
join pasillo_tipo t using(pasilloTipo)
where id in(select id from articulos where cvearticulo = ?)
union all
SELECT pasilloTipo, areaID, pasilloID, posicionID, nivelID, moduloID, id, ubicacion, pasillo, rackID, sentido, area, pasilloTipoDescripcion, 'LIBRE' as atributo, case when pasilloTipo = 3 then 2 else 3 end as atributoID
FROM posicion p
join pasillo o using(pasilloID)
join pasillo_tipo t using(pasilloTipo)
join area a using(areaID)
where id = 0
) a
order by atributoID, areaID, pasilloTipo, pasilloID, moduloID, nivelID, posicionID
";
        
        $query = $this->db->query($sql, $cvearticulo);
        
        return $query;
    }

    function getUbicacionesComboByClave($cvearticulo)
    {

        $query = $this->queryUbicacionesComboByClave($cvearticulo);
        
        $a = null;
        
        foreach($query->result() as $row)
        {
            $a .= '<option value="'.$row->ubicacion.'">'.$row->pasilloID . '-' . $row->moduloID . '-' . $row->nivelID . '-' . $row->posicionID . ' | ' . $row->area . ' | ' . $row->pasillo . '(' . $row->atributo . ')'.'</option>';
        }
        
        return $a;
    }

    function getUbicacionesComboByClaveArray($cvearticulo)
    {
        
        $a = array();

        $query = $this->queryUbicacionesComboByClave($cvearticulo);
        
        foreach($query->result() as $row)
        {
            $a[$row->ubicacion] = $row->pasilloID . '-' . $row->moduloID . '-' . $row->nivelID . '-' . $row->posicionID . ' | ' . $row->area . ' ' . $row->pasillo . ' (' . $row->atributo . ')';
        }
        
        return $a;
    }

    function __getSubmenu($menuID)
    {
        $sql = "SELECT * FROM submenu s where menuID = ?;";
        $query = $this->db->query($sql, $menuID);
        
        $a = array();
        
        foreach($query->result() as $row)
        {
            $a[$row->submenuID]['submenu'] = $row->submenu;
            $a[$row->submenuID]['uri'] = $row->uri;
        }
        
        return $a;
    }
    
    function __getSubmenuByUsuario($menuID, $usuario)
    {
        $sql = "SELECT s.submenuID, submenu, uri FROM submenu s
join menu m using(menuID)
left join usuarios_submenu u on s.submenuID = u.submenuID where usuario = ? and menuID = ?
order by menuID, s.submenuID
;";
        $query = $this->db->query($sql, array($usuario, $menuID));
        
        $a = array();
        
        foreach($query->result() as $row)
        {
            $a[$row->submenuID]['submenu'] = $row->submenu;
            $a[$row->submenuID]['uri'] = $row->uri;
        }
        
        return $a;
    }

    function __getMenu()
    {
        $sql = "SELECT * FROM menu m order by orden;";
        $query = $this->db->query($sql);
        
        $a = array();
        
        foreach($query->result() as $row)
        {
            $a[$row->menuID]['menu'] = $row->menu;
            $a[$row->menuID]['controlador'] = $row->controlador;
            $a[$row->menuID]['icono'] = $row->icono;
            $a[$row->menuID]['items'] = $this->__getSubmenu($row->menuID);
        }
        
        return $a;
    }
    
    function __getMenuByUsuario($usuario)
    {
        $sql = "SELECT menuID, menu, controlador, icono FROM submenu s
join menu m using(menuID)
left join usuarios_submenu u on s.submenuID = u.submenuID where usuario = ?
group by menuID
order by menuID, s.submenuID
;";
        $query = $this->db->query($sql, $usuario);
        
        $a = array();
        
        foreach($query->result() as $row)
        {
            $a[$row->menuID]['menu'] = $row->menu;
            $a[$row->menuID]['controlador'] = $row->controlador;
            $a[$row->menuID]['icono'] = $row->icono;
            $a[$row->menuID]['items'] = $this->__getSubmenuByUsuario($row->menuID, $usuario);
        }
        
        return $a;
    }

    function generateMenu($usuario, $superuser)
    {
        $this->load->helper('file');
        
        if($superuser == 1)
        {
            $arr = $this->__getMenu();
        }else{
            $arr = $this->__getMenuByUsuario($usuario);
        }
        
        $json = json_encode($arr);
            
        write_file('./menu/'.$usuario.'.txt', $json);
    }
    
    function getMenuByUsuario()
    {
        $this->load->helper('file');
        $json = read_file('./menu/'.$this->session->userdata('usuario').'.txt');
        $arr = json_decode($json);
        //print_r($arr);
        return $arr;
    }

    function actArticulo()
    {
        if(PATENTE == 1)
        {
            $this->db->truncate('articulos_temporal');
            $arreglo = json_decode(json_encode($this->getDataOficina('articuloPatente', array())), true);
            $this->db->insert_batch('articulos_temporal', $arreglo, TRUE);
        
            $sql = "insert ignore into articulos (cvearticulo, descripcion, pres, susa, tipoprod, cvecliente) (SELECT * from articulos_temporal);";
        
            $this->db->query($sql);
        
            $sql = "update articulos a, articulos_temporal p set a.susa = p.susa, a.descripcion = p.descripcion, a.tipoprod = ifnull(p.tipoprod, 0) where a.cvearticulo = p.cvearticulo;";

            $this->db->query($sql);
        }
        
    }

}