<?php
class Login_model extends CI_Model
{
    var $url = null;
    var $formato_datos = "/format/json";
    var $json = null;
    var $config, $tengoCentral, $soyAlmacen, $central;


    function __construct()
    {
        parent::__construct();
        $this->setConfig();
    }
    
    function setConfig()
    {
        $configuracion = $this->util->getConfig();
        $this->config = $configuracion->config;
        $this->tengoCentral = $configuracion->tengoCentral;
        $this->soyAlmacen = $configuracion->soyAlmacen;
        $this->central = $configuracion->central;
        if($this->tengoCentral == 1)
        {
            $this->url = $this->central;
        }
    }

    function __get_data($url)
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
    
    function __actualizacion($tabla)
    {
        $data = array('tabla' => $tabla);
        $this->db->set('ultima_actualizacion', 'now()', false);
        $this->db->replace('actualizacion', $data);
    }
    
    function __getCatalogo($cat)
    {
        $suc = '/clvsucursal/'.SUCURSAL;
        return $this->url.$cat.$suc.$this->formato_datos;
    }
    
    function __articulos()
    {
        $this->db->db_debug = FALSE;
        $this->json = $this->__get_data($this->__getCatalogo('articulosCompleto'));
        $arreglo = json_decode($this->json, true);
        
        $this->db->insert_batch('articulos', $arreglo, TRUE);

        if($this->db->_error_message())
        {
        }else{
            $this->__actualizacion('articulos');
        }

//        foreach($arreglo as $row)
//        {
//            $this->db->replace('articulos', $row);
//            $this->__actualizacion('articulos');
//        }
    }

    function __rechecar()
    {
        $this->db->db_debug = FALSE;
        $this->json = $this->__get_data($this->__getCatalogo('rechecar'));
        $arreglo = json_decode($this->json, true);
        
        if(count($arreglo) > 0)
        {
            $sql = "truncate rechecar;";
            $this->db->query($sql);
        
            $this->db->insert_batch('rechecar', $arreglo, TRUE);
            
            $sql = "insert ignore rechecar_final(clvsucursal, folioreceta, cvearticulo, observaciones, checado)(select clvsucursal, folioreceta, cvearticulo, observaciones, checado from rechecar);";
            $this->db->query($sql);
    
            if($this->db->_error_message())
            {
            }else{
                $this->__actualizacion('rechecar');
            }
            
        }

//        foreach($arreglo as $row)
//        {
//            $this->db->replace('articulos', $row);
//            $this->__actualizacion('articulos');
//        }
    }

    function __sucursales()
    {
        $this->db->db_debug = FALSE;
        $this->json = $this->__get_data($this->__getCatalogo('sucursales'));
        $arreglo = json_decode($this->json, true);
        
        $this->db->insert_batch('sucursales', $arreglo, true);
        if($this->db->_error_message())
        {
            
        }else{
            $this->__actualizacion('sucursales');
        }

        
        
//        foreach($arreglo as $row)
//        {
            //$this->db->replace('sucursales', $row);
//            $this->__actualizacion('sucursales');
//        }
    }

    function __usuarios()
    {
        $this->json = $this->__get_data($this->__getCatalogo('usuarios'));
        $arreglo = json_decode($this->json, true);
        
        $this->db->insert_batch('usuarios', $arreglo, true);
        
        if($this->db->_error_message())
        {
            
        }else{
            $this->__actualizacion('usuarios');
        }
        
//        foreach($arreglo as $row)
//        {
//            $this->db->replace('usuarios', $row);
//            $this->__actualizacion('usuarios');
//        }
    }

    function __programa()
    {
        $this->json = $this->__get_data($this->__getCatalogo('programa'));
        $arreglo = json_decode($this->json, true);

        $this->db->insert_batch('programa', $arreglo, true);
        
        if($this->db->_error_message())
        {
            
        }else{
            $this->__actualizacion('programa');
        }

//        foreach($arreglo as $row)
//        {
//            $this->db->replace('programa', $row);
//            $this->__actualizacion('programa');
//        }
    }

    function __devolucion_causa()
    {
        $this->json = $this->__get_data($this->__getCatalogo('devolucion_causa'));
        $arreglo = json_decode($this->json, true);

        $this->db->insert_batch('devolucion_causa', $arreglo, true);
        
        if($this->db->_error_message())
        {
            
        }else{
            $this->__actualizacion('devolucion_causa');
        }

//        foreach($arreglo as $row)
//        {
//            $this->db->replace('devolucion_causa', $row);
//            $this->__actualizacion('devolucion_causa');
//        }
    }

    function __servicios()
    {
        $this->json = $this->__get_data($this->__getCatalogo('servicios'));
        $arreglo = json_decode($this->json, true);

        $this->db->insert_batch('fservicios', $arreglo, true);
        
        if($this->db->_error_message())
        {
            
        }else{
            $this->__actualizacion('servicios');
        }

//        foreach($arreglo as $row)
//        {
//            $this->db->replace('fservicios', $row);
//            $this->__actualizacion('servicios');
//        }
    }

    function __articulos1()
    {
        $this->json = $this->__get_data($this->__getCatalogo('articulosCompleto'));
        $arreglo = json_decode($this->json, true);
        echo "Catalogo de articulos: " .number_format(count($arreglo), 0)." Registros para actualizar.<br />";
        
        
        $this->db->insert_batch('articulos', $arreglo, TRUE);

        if($this->db->_error_message())
        {
        }else{
            $this->__actualizacion('articulos');
        }
        echo "Listo.<br />";
    }

    function __programa1()
    {
        $this->json = $this->__get_data($this->__getCatalogo('programa'));
        $arreglo = json_decode($this->json, true);
        echo "Catalogo de programas: " .number_format(count($arreglo), 0)." Registros para actualizar.<br />";
        $this->db->insert_batch('programa', $arreglo, TRUE);

        if($this->db->_error_message())
        {
        }else{
            $this->__actualizacion('programa');
        }
        echo "Listo.<br />";
    }

    function __devolucion_causa1()
    {
        $this->json = $this->__get_data($this->__getCatalogo('devolucion_causa'));
        $arreglo = json_decode($this->json, true);
        echo "Catalogo de Causas de devolucion: " .number_format(count($arreglo), 0)." Registros para actualizar.<br />";
        $this->db->insert_batch('devolucion_causa', $arreglo, TRUE);

        if($this->db->_error_message())
        {
        }else{
            $this->__actualizacion('devolucion_causa');
        }
        echo "Listo.<br />";
    }

    function __servicios1()
    {
        $this->json = $this->__get_data($this->__getCatalogo('servicios'));
        $arreglo = json_decode($this->json, true);
        echo "Catalogo de servicios: " .number_format(count($arreglo), 0)." Registros para actualizar.<br />";
        $this->db->insert_batch('fservicios', $arreglo, TRUE);

        if($this->db->_error_message())
        {
        }else{
            $this->__actualizacion('servicios');
        }
        echo "Listo.<br />";
    }

    function __sucursales1()
    {
        $this->json = $this->__get_data($this->__getCatalogo('sucursales'));
        $arreglo = json_decode($this->json, true);
        echo "Catalogo de sucursales: " .number_format(count($arreglo), 0)." Registros para actualizar.<br />";
        $this->db->insert_batch('sucursales', $arreglo, TRUE);

        if($this->db->_error_message())
        {
        }else{
            $this->__actualizacion('sucursales');
        }
        echo "Listo.<br />";
    }

    function __usuarios1()
    {
        $this->json = $this->__get_data($this->__getCatalogo('usuarios'));
        $arreglo = json_decode($this->json, true);
        echo "Catalogo de usuarios: " .number_format(count($arreglo), 0)." Registros para actualizar.<br />";
        $this->db->insert_batch('usuarios', $arreglo, TRUE);

        if($this->db->_error_message())
        {
        }else{
            $this->__actualizacion('usuarios');
        }
        echo "Listo.<br />";
    }
    
    function __actualizaTablas()
    {

    }
    
    function verifyCredentials($usuario, $password)
    {
        $sql = "select * from usuarios where clvusuario = ? and password = ? and estaactivo = 1;";
        $query = $this->db->query($sql, array($usuario, $password));

        if ($query->num_rows() > 0) {
            $this->__asignSessionParameters($query);
            $this->__actualizaTablas();
            
            
            
            if($this->tengoCentral == 1)
            {
                
                $this->__rechecar();
                $this->__articulos();
                $this->__sucursales();
                $this->__usuarios();
                $this->__programa();
                $this->__devolucion_causa();
                $this->__servicios();
                $this->__auditaReceta();
                $this->__auditaMovimiento();
                $this->__inventario();
            }else{
                $this->util->actSucursales();
                if(PATENTE == 1)
                {
                    $this->util->actArticulo();
                }
            }
            return true;
        } else {
            return false;
        }

    }
    
    function __auditaReceta()
    {
        $sql = "SELECT consecutivo FROM receta r where consecutivo not in(select consecutivo from receta_audita);";
        $query = $this->db->query($sql);
        
        foreach($query->result() as $row)
        {
            $this->util->postReceta($row->consecutivo);
        }
    }

    function __auditaMovimiento()
    {
        $sql = "SELECT movimientoID FROM movimiento r where movimientoID not in(select MovimientoID from movimiento_audita);";
        $query = $this->db->query($sql);
        
        foreach($query->result() as $row)
        {
            $this->util->postMovimiento($row->movimientoID);
        }
    }
    
    function __inventario()
    {
        $this->util->postInventario();
    }

    function __asignSessionParameters($query)
    {
        
        $this->load->helper('string');
        $row = $query->row();
        
        $this->util->generateMenu($row->usuario, $row->superuser);
        
        $this->db->select('trim(descsucursal) as descsucursal, tiposucursal, numjurisd, diaped');
        $this->db->where('clvsucursal', SUCURSAL);
        $query2 = $this->db->get('sucursales');
        
        $this->db->where('config', 1);
        $query3 = $this->db->get('config');
        
        if($query3->num_rows() > 0)
        {
            $row3 = $query3->row();
            $cxp = $row3->cxp;
        }else{
            $cxp = 'pru';
        }
        
        if($query2->num_rows == 1)
        {
            $row2 = $query2->row();
            $sucursal = $row2->descsucursal;
            $tiposucursal = $row2->tiposucursal;
            $numjurisd = $row2->numjurisd;
            $diaped = $row2->diaped;
        }else{
            $sucursal = null;
            $tiposucursal = 0;
            $numjurisd = 0;
            $diaped = 0;
        }
        
        $sql = "update usuarios set last_login = now() where usuario = ?;";
        $this->db->query($sql, $row->usuario);

        $aleatorio = random_string('numeric', 10);
        
        if($row->avatar == null)
        {
            $row->avatar = 'avatar2.png';
        }

        $newdata = array(
            'nombrecompleto'    => $row->nombreusuario,
            'nivel'             => $row->clvpuesto,
            'usuario'           => $row->usuario,
            'clvsucursal'       => SUCURSAL,
            'clvusuario'        => $row->clvusuario,
            'sucursal'          => $sucursal,
            'tipoSucursal'      => $tiposucursal,
            'jur'               => $numjurisd,
            'diaped'            => $diaped,
            'aleatorio'         => $aleatorio,
            'logged_in'         => true,
            'superuser'         => $row->superuser,
            'avatar'            => $row->avatar,
            'cxp'               => $cxp
            );

        $this->session->set_userdata($newdata);

    }
    
    function actualizaCatalogos()
    {
        if($this->tengoCentral == 1)
        {
            $this->__articulos1();
            $this->__sucursales1();
            $this->__usuarios1();
            $this->__programa1();
            $this->__devolucion_causa1();
            $this->__servicios1();
        }
    }


}
