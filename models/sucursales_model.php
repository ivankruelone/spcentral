<?php
class Sucursales_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
    
    
    function sucursales()
    {
        $sql = "SELECT trim(tipo2) as tipo, estado, suc as id, trim(nombre) as nombre, trim(dire) as direccion, cp, trim(col) as colonia, trim(pobla) as poblacion, lat as latitud, lon as longitud
FROM catalogo.sucursal s
where suc >100 and suc<= 2000 and tipo1 = 'A' and (lat > 0 or lon > 0);";
        
        $query = $this->db->query($sql);
        
        return $query->result();
    }

    function sucursales_estado($estado)
    {
        $sql = "SELECT trim(tipo2) as tipo, estado, suc as id, trim(nombre) as nombre, trim(dire) as direccion, cp, trim(col) as colonia, trim(pobla) as poblacion, lat as latitud, lon as longitud
FROM catalogo.sucursal s
where estado = ? and suc >100 and suc<= 2000 and tipo1 = 'A' and (lat > 0 or lon > 0);";
        
        $query = $this->db->query($sql, $estado);
        
        return $query->result();
    }

    function sucursal($id)
    {
        $sql = "SELECT trim(tipo2) as tipo, estado, suc as id, trim(nombre) as nombre, trim(dire) as direccion, cp, trim(col) as colonia, trim(pobla) as poblacion, lat as latitud, lon as longitud
FROM catalogo.sucursal s
where suc = ?;";
        
        $query = $this->db->query($sql, $id);
        
        return $query->result();
    }
    
    function estados()
    {
        $sql = "select c_estado as idestado, upper(trim(d_estado)) as estado from facturacion.codigos group by c_estado";
        $query = $this->db->query($sql);
        return $query->result();
    }
}