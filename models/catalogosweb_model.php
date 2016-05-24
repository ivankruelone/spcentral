<?php
class Catalogosweb_model extends CI_Model {

    /**
     * Catalogos_model::__construct()
     * 
     * @return
     */
    function __construct()
    {
        parent::__construct();
    }
    
    function getCountArticulo($cvesuministro)
    {
        $sql = "SELECT count(*) as cuenta FROM articulos a where tipoprod = ?;";
        $query = $this->db->query($sql, $cvesuministro);
        $row = $query->row();
        
        return $row->cuenta;
    }
    
    function insertaArticulo($data)
    {
        $this->db->db_debug = FALSE;
        $this->db->trans_start();
        $this->db->insert('articulos', $data);
        $id = $this->db->insert_id();
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE)
        {
            return 0;
        }else{
            return $id;
        }
        
    }
    
    function insertaArticulo2($data)
    {
        $this->db->db_debug = FALSE;
        $this->db->trans_start();
        $this->db->where('cvearticulo', $data->cvearticulo);
        $query = $this->db->get('articulos');
        $id = 0;
        if($query->num_rows() == 0)
        {
            $this->db->insert('articulos', $data);
            echo $this->db->last_query();
            $id = $this->db->insert_id();
        }
        
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE)
        {
            return 0;
        }else{
            return $id;
        }
        
    }

    function insertaArticulo3($data)
    {
        $this->db->where('cvearticulo', $data->cvearticulo);
        $query = $this->db->get('articulos');
        $id = 0;
        if($query->num_rows() == 0)
        {
            $this->db->insert('articulos', $data);
            $id = $this->db->insert_id();
        }
        
    }

    function insertaCliente($data)
    {
        $this->db->db_debug = FALSE;
        $this->db->trans_start();
        $this->db->insert('receptores', $data);
        $id = $this->db->insert_id();
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE)
        {
            return 0;
        }else{
            return $id;
        }
        
    }

    function getInventarioExportar()
    {
        $this->db->where_not_in('cantidad', array(0));
        $query = $this->db->get('inventario');
        
        $a = array();
        
        foreach($query->result() as $row)
        {
            array_push($a, $row);
        }
        
        return $a;
    }
    
    function getKardexExportar($fecha1, $fecha2)
    {
        $this->db->where('fechaKardex >=', $fecha1.' 00:00:00');
        $this->db->where('fechaKardex <=', $fecha2.' 23:59:59');
        $query = $this->db->get('kardex');
        
        $a = array();
        
        foreach($query->result() as $row)
        {
            array_push($a, $row);
        }
        
        return $a;
    }
    
    function getMovimientoExportar($fecha1, $fecha2)
    {
        $this->db->where('fechaCierre >=', $fecha1.' 00:00:00');
        $this->db->where('fechaCierre <=', $fecha2.' 23:59:59');
        $this->db->where('statusMovimiento', 1);
        $query = $this->db->get('movimiento');
        
        $a = array();
        
        foreach($query->result() as $row)
        {
            array_push($a, $row);
        }
        
        return $a;
    }

    function getMovimientoDetalleExportar($fecha1, $fecha2)
    {
        $this->db->select('d.*');
        $this->db->from('movimiento c');
        $this->db->join('movimiento_detalle d', 'c.movimientoID = d.movimientoID');
        $this->db->where('c.fechaCierre >=', $fecha1.' 00:00:00');
        $this->db->where('c.fechaCierre <=', $fecha2.' 23:59:59');
        $this->db->where('c.statusMovimiento', 1);
        $query = $this->db->get();
        
        $a = array();
        
        foreach($query->result() as $row)
        {
            array_push($a, $row);
        }
        
        return $a;
    }
    
    function getDomicilio()
    {
        $this->db->where('idDomicilio', 1);
        $query = $this->db->get('sucursal_domicilio');
        
        return $query;
    }
    
    function getContrato($rfc)
    {
        $this->db->from('contrato c');
        $this->db->where('c.rfc', $rfc);
        $this->db->join('receptores r', 'c.rfc = r.rfc');
        $query = $this->db->get();
        
        return $query;
    }
    
    function getContratoByContratoID($contratoID)
    {
        $this->db->from('contrato c');
        $this->db->where('c.contratoID', $contratoID);
        $this->db->join('receptores r', 'c.rfc = r.rfc');
        $query = $this->db->get();
        
        return $query;
    }

    function insertContrato($rfc, $numero, $denominado)
    {
        $data = array('rfc' => $rfc, 'numero' => $numero, 'denominado' => strtoupper($denominado));
        $this->db->insert('contrato', $data);
    }
    
    function updateContrato($contratoID, $numero, $denominado, $referencia_factura)
    {
        $data = array('numero' => $numero, 'denominado' => strtoupper($denominado), 'referencia_factura' => $referencia_factura);
        $this->db->update('contrato', $data, array('contratoID' => $contratoID));
    }
    
    function insertaArticuloContratoPrecio($contratoID)
    {
        $sql = "insert ignore contrato_precio (contratoID, id)(SELECT ?, id FROM articulos);";
        $this->db->query($sql, $contratoID);
    }
    
    function getContratoPrecioByContratoID($contratoID)
    {
        $sql = "SELECT * FROM contrato_precio c
join articulos a using(id)
where contratoID = ?
order by cvearticulo * 1;";

        $query = $this->db->query($sql, $contratoID);
        
        return $query;
    }
    
    function saveContratoPrecio($contratoPrecioID, $precioContrato)
    {
        $data = array('precioContrato' => $precioContrato);
        $this->db->update('contrato_precio', $data, array('contratoPrecioID' => $contratoPrecioID));
    }
    
    function getSucursalesCliente($rfc)
    {
        $sql = "SELECT * FROM receptores_sucursal r
join receptores e using(rfc)
join sucursales s using(clvsucursal)
where rfc = ?;";

        $query = $this->db->query($sql, (string)$rfc);
        
        return $query;
    }
    
    function insertSucursalCliente($rfc, $clvsucursal)
    {
        $data = array('rfc' => $rfc, 'clvsucursal' => $clvsucursal);
        
        $this->db->where('rfc', $rfc);
        $this->db->where('clvsucursal', $clvsucursal);
        $query = $this->db->get('receptores_sucursal');
        
        $this->db->where('clvsucursal', $clvsucursal);
        $query2 = $this->db->get('sucursales');
        
        if($query->num_rows() == 0 && $query2->num_rows() > 0)
        {
            $this->db->insert('receptores_sucursal', $data);
        }
        
        
    }
    
    function insertSucursalCliente2($rfc, $clvsucursal1, $clvsucursal2)
    {
        for($i = $clvsucursal1; $i<= $clvsucursal2; $i++)
        {
            $this->insertSucursalCliente($rfc, $i);
        }
    }
    
    function eliminaReceptorSucursalID($receptorSucursalID)
    {
        $this->db->delete('receptores_sucursal', array('receptorSucursalID' => $receptorSucursalID));
    }

    function getMovimientoEmbarqueExportar($fecha1, $fecha2)
    {
        $this->db->select('d.*');
        $this->db->from('movimiento c');
        $this->db->join('movimiento_embarque d', 'c.movimientoID = d.movimientoID');
        $this->db->where('c.fechaCierre >=', $fecha1.' 00:00:00');
        $this->db->where('c.fechaCierre <=', $fecha2.' 23:59:59');
        $this->db->where('c.statusMovimiento', 1);
        $query = $this->db->get();
        
        $a = array();
        
        foreach($query->result() as $row)
        {
            array_push($a, $row);
        }
        
        return $a;
    }

    function getRecetaExportar($fecha1, $fecha2)
    {
        $fecha1 = $fecha1. " 00:00:00";
        $fecha2 = $fecha2. " 23:59:59";

        $sql = "SELECT * FROM receta r where (alta between ? and ?) or (cambio between ? and ?);";
        $query = $this->db->query($sql, array($fecha1, $fecha2, $fecha1, $fecha2));
        
        $a = array();
        
        foreach($query->result() as $row)
        {
            array_push($a, $row);
        }
        
        return $a;
    }

    function getRecetaDetalleExportar($fecha1, $fecha2)
    {
        $fecha1 = $fecha1. " 00:00:00";
        $fecha2 = $fecha2. " 23:59:59";

        $sql = "SELECT d.* FROM receta r join receta_detalle d using(consecutivo) where (alta between ? and ?) or (cambio between ? and ?);";
        $query = $this->db->query($sql, array($fecha1, $fecha2, $fecha1, $fecha2));
        
        $a = array();
        
        foreach($query->result() as $row)
        {
            array_push($a, $row);
        }
        
        return $a;
    }
    
    function getProveedorExportar()
    {
        $sql = "SELECT proveedorID, rfc, razon, ".$this->session->userdata('clvsucursal')." as clvsucursal FROM proveedor p;";
        $query = $this->db->query($sql);
        
        $a = array();
        foreach($query->result() as $row)
        {
            array_push($a, $row);
        }
        
        return $a;
    }

    function getDevolucionExportar($fecha1, $fecha2)
    {
        $fecha1 = $fecha1. " 00:00:00";
        $fecha2 = $fecha2. " 23:59:59";

        $sql = "SELECT * FROM devolucion where fechaDevolucion between ? and ?;";
        $query = $this->db->query($sql, array($fecha1, $fecha2));
        
        $a = array();
        
        foreach($query->result() as $row)
        {
            array_push($a, $row);
        }
        
        return $a;
    }

    function getArticulos($cvesuministro)
    {
        $sql = "SELECT suministro, id, antibiotico, semaforo, semaforoDescripcion, semaforoColor, cvearticulo, susa, descripcion, pres, case when ventaxuni = 0 then 'NO' else 'SI' end as ventaxuni, numunidades FROM articulos a
join temporal_suministro s on a.tipoprod = s.cvesuministro
join semaforo o using(semaforo)
where tipoprod = ?
order by tipoprod, cvearticulo * 1
limit 500;";
        
        return $this->db->query($sql, $cvesuministro);
    }
    
    function getArticulosLimit($cvesuministro, $limit, $offset = 0)
    {
        $sql = "SELECT suministro, id, antibiotico, semaforo, semaforoDescripcion, semaforoColor, cvearticulo, susa, descripcion, pres, case when ventaxuni = 0 then 'NO' else 'SI' end as ventaxuni, numunidades FROM articulos a
join temporal_suministro s on a.tipoprod = s.cvesuministro
join semaforo o using(semaforo)
where tipoprod = ?
order by tipoprod, cvearticulo * 1
limit ? offset ?;";
        
        return $this->db->query($sql, array($cvesuministro, $limit, (int)$offset));
    }

    function getClientes()
    {
        $sql = "SELECT * from receptores order by razon;";
        
        return $this->db->query($sql);
    }

    function getProveedor()
    {
        $this->db->where_not_in('proveedorID', array(1));
        $query = $this->db->get('proveedor');
        return $query;
    }
    
    function getProveedorID()
    {
        $sql = "SELECT ifnull(max(proveedorID) + 1, 0) as proveedorID FROM proveedor p where proveedorID >= 10000;";
        $query = $this->db->query($sql);
        
        $row = $query->row();
        
        if($row->proveedorID == 0)
        {
            return 10000;
        }else{
            return $row->proveedorID;
        }
    }
    
    function insertProveedor($rfc, $razon, $proveedorID)
    {
        $this->db->where('rfc', $rfc);
        $query = $this->db->get('proveedor');
        
        if($query->num_rows() == 0)
        {
            if($proveedorID == 0)
            {
                $proveedorID = $this->getProveedorID();
            }else{
                
            }
            $data = array('rfc' => $rfc, 'razon' => $razon, 'proveedorID' => $proveedorID);
            $this->db->insert('proveedor', $data);
        }else{
            
        }
    }
    
    function getProveedorByID($proveedorID)
    {
        $this->db->where('proveedorID', $proveedorID);
        $query = $this->db->get('proveedor');
        return $query;
    }
    
    function getJsonProveedor()
    {
        $json = null;
        $ctx = stream_context_create(array('http'=>
            array(
                'timeout' => 5, // 1 200 Seconds = 20 Minutes
            )
        ));
        if($json = file_get_contents('http://192.168.1.220/oficinas/api/proveedor', false, $ctx))
        {
            if(strlen($json) == 0)
            {
                $json = file_get_contents('http://189.203.201.166/oficinas/api/proveedor');
            }
        }
        
        
        return $json;
    }
    

    function actualizaProveedor($rfc, $razon, $proveedorID)
    {
        $data = array('rfc' => $rfc, 'razon' => $razon);
        $this->db->update('proveedor', $data, array('proveedorID' => $proveedorID));
    }

    function getSucursal()
    {
        $this->db->where_not_in('clvsucursal', array(0));
        $query = $this->db->get('sucursales');
        return $query;
    }

    function insertSucursal($clvsucursal, $descsucursal, $numjurisd)
    {
        $this->db->where('clvsucursal', $clvsucursal);
        $query = $this->db->get('sucursales');
        
        if($query->num_rows() == 0)
        {
            $data = array('clvsucursal' => $clvsucursal, 'descsucursal' => $descsucursal, 'numjurisd' => $numjurisd);
            $this->db->insert('sucursales', $data);
        }else{
            
        }
    }
    
    function getSucursalByClvsucursal($clvsucursal)
    {
        $this->db->where('clvsucursal', $clvsucursal);
        $query = $this->db->get('sucursales');
        return $query;
    }
    
    function getSucursalExtByClvsucursal($clvsucursal)
    {
        $this->db->where('clvsucursal', $clvsucursal);
        $query = $this->db->get('sucursales_ext');
        return $query;
    }

    function actualizaSucursal($clvsucursal, $numjurisd, $nombreSucursalPersonalizado, $domicilioSucursalPersonalizado)
    {
        $data = array('clvsucursal' => $clvsucursal, 'nombreSucursalPersonalizado' => $nombreSucursalPersonalizado, 'domicilioSucursalPersonalizado' => $domicilioSucursalPersonalizado);
        $this->db->replace('sucursales_ext', $data);
    }

    function getUsuario()
    {
        $sql = "SELECT usuario, clvusuario, password, nombreusuario, case when estaactivo = 0 then 'INACTIVO' else 'ACTIVO' end as estaactivo, descsucursal, puesto
FROM usuarios u
join sucursales s using(clvsucursal)
join puesto p using(clvpuesto);";
        $query = $this->db->query($sql);
        return $query;
        
    }

    function insertUsuario($clvusuario, $password, $nombreusuario, $clvsucursal, $clvpuesto, $estaactivo)
    {
        $this->db->where('clvusuario', $clvusuario);
        $query = $this->db->get('usuarios');
        
        if($query->num_rows() == 0)
        {
            $data = array('clvusuario' => $clvusuario, 'password' => $password, 'nombreusuario' => $nombreusuario, 'clvsucursal' => $clvsucursal, 'clvpuesto' => $clvpuesto, 'estaactivo' => $estaactivo);
            $this->db->insert('usuarios', $data);
        }else{
            
        }
    }
    
    function getUsuarioByUsuario($usuario)
    {
        $this->db->where('usuario', $usuario);
        $query = $this->db->get('usuarios');
        return $query;
    }

    function actualizaUsuario($clvusuario, $password, $nombreusuario, $clvsucursal, $clvpuesto, $estaactivo, $usuario)
    {
        $data = array('clvusuario' => $clvusuario, 'password' => $password, 'nombreusuario' => $nombreusuario, 'clvsucursal' => $clvsucursal, 'clvpuesto' => $clvpuesto, 'estaactivo' => $estaactivo);
        $this->db->update('usuarios', $data, array('usuario' => $usuario));
    }
}