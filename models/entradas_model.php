<?php
class Entradas_model extends CI_Model {

    /**
     * Catalogos_model::__construct()
     * 
     * @return
     */
    function __construct()
    {
        parent::__construct();
    }
    
    function getSucursalNombre($sucursal)
    {
        $this->db->where('sucursal', $sucursal);
        $row = $this->db->get('sucursales')->row();
        return $row->nombresucursal;
    }

    function reporte_de_entradas_por_sucursal($fecha1, $fecha2)
    {
        $sql = "SELECT s.sucursal, nombresucursal, sum(cantidad) as cantidad, sum(d.precio * cantidad) as subtotal, sum(case when p.iva = 1 then (d.precio * cantidad * 0.16) else 0 end) as iva
FROM entradas_control e
left join entradas_detalle d on e.sucursal = d.sucursal and e.entrada = d.entrada
left join sucursales s on e.sucursal = s.sucursal
left join productos p on d.ean = p.ean
where e.fecha between ? and ?
group by e.sucursal;";

        $query = $this->db->query($sql, array($fecha1, $fecha2));
        return $query;
    }
    
    function detalle_por_sucursal_y_proveedor($sucursal, $fecha1, $fecha2)
    {
        $sql = "SELECT e.proveedor, razon, sum(cantidad) as cantidad, e.fecha, sum(d.precio * cantidad) as subtotal, sum(case when p.iva = 1 then (d.precio * cantidad * 0.16) else 0 end) as iva FROM entradas_control e
left join entradas_detalle d on e.sucursal = d.sucursal and e.entrada = d.entrada
left join  proveedores v on e.proveedor = v.proveedor
left join productos p on d.ean = p.ean
where e.sucursal = ? and e.fecha between ? and ?
group by e.proveedor;";

        $query = $this->db->query($sql, array($sucursal, $fecha1, $fecha2));
        return $query;
    }

    function detalle_por_sucursal_y_proveedor_y_factura($sucursal, $proveedor, $fecha1, $fecha2)
    {
        $sql = "SELECT e.entrada, e.proveedor, razon, sum(cantidad) as cantidad, sum(d.precio * cantidad) as subtotal, sum(case when p.iva = 1 then (d.precio * cantidad * 0.16) else 0 end) as iva
FROM entradas_control e
left join entradas_detalle d on e.sucursal = d.sucursal and e.entrada = d.entrada
left join  proveedores v on e.proveedor = v.proveedor
left join productos p on d.ean = p.ean
where e.sucursal = ? and e.proveedor = ? and e.fecha between ? and ?
group by e.entrada;";

        $query = $this->db->query($sql, array($sucursal, $proveedor, $fecha1, $fecha2));
        return $query;
    }
    
    function detalle_por_sucursal_y_proveedor_y_factura_y_producto($sucursal, $entrada)
    {
        $sql = "SELECT e.entrada, descripcion, sustancia, cantidad, d.precio * cantidad subtotal, case when p.iva = 1 then (d.precio * cantidad * 0.16) else 0 end as iva
FROM entradas_control e
left join entradas_detalle d on e.sucursal = d.sucursal and e.entrada = d.entrada
left join  proveedores v on e.proveedor = v.proveedor
left join productos p on d.ean = p.ean
where e.sucursal = ? and e.entrada = ?;";

        $query = $this->db->query($sql, array($sucursal, $entrada));
        return $query;
    }

}