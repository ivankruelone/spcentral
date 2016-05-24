<?php
class Ventas_model extends CI_Model {

    /**
     * Catalogos_model::__construct()
     * 
     * @return
     */
    function __construct()
    {
        parent::__construct();
    }
    
    function reporte_de_ventas_por_periodo_sucursal($sucursal, $fecha1, $fecha2)
    {
        $fecha1 = $fecha1 . " 00:00:00";
        $fecha2 = $fecha2 . " 23:59:59";
        
        $this->db->select('v.id, v.venta, nombresucursal, c.razon, v.fecha, u1.nombrecompleto as cajero, sum(d.cantidad) as cantidad, sum(d.iva) as iva, sum(d.total) as total');
        $this->db->from('ventas v');
        $this->db->join('clientes c', 'v.cliente = c.cliente', 'LEFT');
        $this->db->join('usuarios u1', 'v.cajero = u1.numeroempleado', 'LEFT');
        $this->db->join('sucursales s', 'v.sucursal = s.sucursal', 'left');
        $this->db->join('detalle d', 'v.id = d.id', 'LEFT');
        $this->db->where('v.estatus', 1);
        $this->db->where('fecha >=', $fecha1);
        $this->db->where('fecha <=', $fecha2);
        $this->db->where('v.sucursal', $sucursal);
        $this->db->group_by('v.id');
        $query = $this->db->get();
        
        return $query;
        
    }

    function reporte_de_ventas_por_periodo($fecha1, $fecha2)
    {
        $fecha1 = $fecha1 . " 00:00:00";
        $fecha2 = $fecha2 . " 23:59:59";
        
        $this->db->select('v.id, v.venta, nombresucursal, c.razon, v.fecha, u1.nombrecompleto as cajero, sum(d.cantidad) as cantidad, sum(d.iva) as iva, sum(d.total) as total');
        $this->db->from('ventas v');
        $this->db->join('clientes c', 'v.cliente = c.cliente', 'LEFT');
        $this->db->join('usuarios u1', 'v.cajero = u1.numeroempleado', 'LEFT');
        $this->db->join('sucursales s', 'v.sucursal = s.sucursal', 'left');
        $this->db->join('detalle d', 'v.id = d.id', 'LEFT');
        $this->db->where('v.estatus', 1);
        $this->db->where('fecha >=', $fecha1);
        $this->db->where('fecha <=', $fecha2);
        $this->db->group_by('v.id');
        $query = $this->db->get();
        
        return $query;
        
    }
    
    function reporte_de_ventas_por_sucursal($fecha1, $fecha2)
    {
        $fecha1 = $fecha1 . " 00:00:00";
        $fecha2 = $fecha2 . " 23:59:59";
        
        $this->db->select("s.sucursal, nombresucursal, ifnull(sum(cantidad), 0) as cantidad, ifnull(sum(d.iva), 0) as iva, ifnull(sum(total), 0) as total, ifnull(sum(cantidad * ultimocosto), 0) as costo, (select count(*) from ventas where s.sucursal = ventas.sucursal and ventas.fecha between '$fecha1' and '$fecha2') as tickets", false);
        $this->db->from('sucursales s');
        $this->db->join('ventas v', "s.sucursal = v.sucursal and v.fecha between '$fecha1' and '$fecha2'", 'LEFT');
        $this->db->join('detalle d', 'v.id = d.id', 'LEFT');
        $this->db->join('productos p', 'd.ean = p.ean', 'LEFT');
        $this->db->where('v.estatus', 1);
        $this->db->group_by('s.sucursal');
        $query = $this->db->get();
        
        return $query;
        
    }
    
    function devoluciones($fecha1, $fecha2)
    {
        $fecha1 = $fecha1 . " 00:00:00";
        $fecha2 = $fecha2 . " 23:59:59";
        
        $sql = "SELECT sucursal, ifnull(sum(precio * cantidad), 0) as importe
from sucursales s
left join venta_devolucion v using(sucursal)
where fecha between ? and ?
group by sucursal;";
        
        $query = $this->db->query($sql, array($fecha1, $fecha2));
        
        $a = array();
        foreach($query->result() as $row)
        {
            $a[$row->sucursal] = $row->importe;
        }
        
        return $a;
    }

    function sucursal_por_ean($sucursal, $fecha1, $fecha2)
    {
        $fecha1 = $fecha1 . " 00:00:00";
        $fecha2 = $fecha2 . " 23:59:59";
        
        $this->db->select("p.sec, p.ean, p.descripcion, p.sustancia, p.fisico, p.antibiotico, linea_desc, sublinea_desc, d.precio, ifnull(sum(cantidad), 0) as cantidad, ifnull(sum(d.iva), 0) as iva, ifnull(sum(total), 0) as total, ifnull(sum(cantidad * ultimocosto), 0) as costo", false);
        $this->db->from('ventas v');
        $this->db->join('detalle d', 'v.id = d.id', 'LEFT');
        $this->db->join('productos p', 'd.ean = p.ean', 'LEFT');
        $this->db->join('lineas l', 'p.linea = l.linea', 'INNER');
        $this->db->join('sublineas s', 'p.sublinea = s.sublinea and p.linea = s.linea', 'INNER');
        $this->db->where('v.estatus', 1);
        $this->db->where('v.sucursal', $sucursal);
        $this->db->where("v.fecha between '$fecha1' and '$fecha2'", null, false);
        $this->db->group_by('p.ean, d.precio');
        $this->db->order_by('cantidad', 'DESC');
        $query = $this->db->get();
        
        return $query;
        
    }

    function sucursal_por_comisionables($sucursal, $fecha1, $fecha2)
    {
        $fecha1 = $fecha1 . " 00:00:00";
        $fecha2 = $fecha2 . " 23:59:59";
        
        $this->db->select("p.sec, p.ean, p.descripcion, p.sustancia, p.fisico, p.antibiotico, linea_desc, sublinea_desc, d.precio, ifnull(sum(cantidad), 0) as cantidad, ifnull(sum(d.iva), 0) as iva, ifnull(sum(total), 0) as total, ifnull(sum(cantidad * ultimocosto), 0) as costo", false);
        $this->db->from('ventas v');
        $this->db->join('detalle d', 'v.id = d.id', 'INNER');
        $this->db->join('comisionables_ean c', 'd.ean = c.ean', 'INNER');
        $this->db->join('productos p', 'd.ean = p.ean', 'INNER');
        $this->db->join('lineas l', 'p.linea = l.linea', 'INNER');
        $this->db->join('sublineas s', 'p.sublinea = s.sublinea and p.linea = s.linea', 'INNER');
        $this->db->where('v.estatus', 1);
        $this->db->where('v.sucursal', $sucursal);
        $this->db->where("v.fecha between '$fecha1' and '$fecha2'", null, false);
        $this->db->group_by('p.ean, d.precio');
        $this->db->order_by('cantidad', 'DESC');
        $query = $this->db->get();
        
        return $query;
        
    }

    function sucursal_por_dia($sucursal, $fecha1, $fecha2)
    {
        $fecha1 = $fecha1 . " 00:00:00";
        $fecha2 = $fecha2 . " 23:59:59";
        
        $this->db->select("v.fecha, DAYOFWEEK(v.fecha) as dia, s.sucursal, nombresucursal, ifnull(sum(cantidad), 0) as cantidad, ifnull(sum(d.iva), 0) as iva, ifnull(sum(total), 0) as total, ifnull(sum(cantidad * ultimocosto), 0) as costo, (select count(*) from ventas where s.sucursal = ventas.sucursal and ventas.fecha = v.fecha) as tickets", false);
        $this->db->from('sucursales s');
        $this->db->join('ventas v', "s.sucursal = v.sucursal and v.fecha between '$fecha1' and '$fecha2'", 'LEFT');
        $this->db->join('detalle d', 'v.id = d.id', 'LEFT');
        $this->db->join('productos p', 'd.ean = p.ean', 'LEFT');
        $this->db->where('v.estatus', 1);
        $this->db->where('v.sucursal', $sucursal);
        $this->db->group_by('v.fecha');
        $query = $this->db->get();
        
        return $query;
        
    }

    function sucursal_por_sec($sucursal, $fecha1, $fecha2)
    {
        $fecha1 = $fecha1 . " 00:00:00";
        $fecha2 = $fecha2 . " 23:59:59";
        
        $this->db->select("p.sec, p.sustancia, p.fisico, p.antibiotico, linea_desc, sublinea_desc, d.precio, ifnull(sum(cantidad), 0) as cantidad, ifnull(sum(d.iva), 0) as iva, ifnull(sum(total), 0) as total, ifnull(sum(cantidad * ultimocosto), 0) as costo", false);
        $this->db->from('ventas v');
        $this->db->join('detalle d', 'v.id = d.id', 'LEFT');
        $this->db->join('productos p', 'd.ean = p.ean', 'LEFT');
        $this->db->join('lineas l', 'p.linea = l.linea', 'INNER');
        $this->db->join('sublineas s', 'p.sublinea = s.sublinea and p.linea = s.linea', 'INNER');
        $this->db->where('v.estatus', 1);
        $this->db->where('v.sucursal', $sucursal);
        $this->db->where("v.fecha between '$fecha1' and '$fecha2'", null, false);
        $this->db->group_by('p.sec, d.precio');
        $this->db->order_by('cantidad', 'DESC');
        $query = $this->db->get();
        
        return $query;
        
    }

    function detalle_productos($id)
    {
        
        $this->db->select('d.id, d.venta, d.ean, a.descripcion, a.sustancia, d.precio, d.cantidad, d.iva, d.descuento_tasa, d.descuento, total');
        $this->db->from('detalle d');
        $this->db->join('productos a', 'a.ean = d.ean', 'LEFT');
        $this->db->where('d.id', $id);
        $query = $this->db->get();
        
        return $query;
        
    }
    
    function reporte_de_negados_por_secuencia($fecha1, $fecha2)
    {
        $fecha1 = $fecha1 . " 00:00:00";
        $fecha2 = $fecha2 . " 23:59:59";
        
        $this->db->select('a.sec, a.sustancia, a.precio, sum(n.cantidad) as cantidad, sum(a.precio*n.cantidad) as total, n.fecha');
        $this->db->from('negados n');
        $this->db->join('productos a', 'a.ean=n.ean', 'LEFT');
        $this->db->where('fecha >=', $fecha1);
        $this->db->where('fecha <=', $fecha2);
        $this->db->group_by('a.sec');
        $this->db->order_by('a.sec');
        $query = $this->db->get();
        
        return $query;
        
    }
    
    function reporte_de_negados_por_cbarras($fecha1, $fecha2)
    {
        $fecha1 = $fecha1 . " 00:00:00";
        $fecha2 = $fecha2 . " 23:59:59";
        
        $this->db->select('a.ean, a.descripcion, a.precio, sum(n.cantidad) as cantidad, sum(a.precio*n.cantidad) as total, n.fecha');
        $this->db->from('negados n');
        $this->db->join('productos a', 'a.ean=n.ean', 'LEFT');
        $this->db->where('fecha >=', $fecha1);
        $this->db->where('fecha <=', $fecha2);
        $this->db->group_by('a.ean');
        $this->db->order_by('a.ean');
        $query = $this->db->get();
        
        return $query;
        
    }

    function getSucursalNombre($sucursal)
    {
        $this->db->where('sucursal', $sucursal);
        $row = $this->db->get('sucursales')->row();
        return $row->nombresucursal;
    }
}