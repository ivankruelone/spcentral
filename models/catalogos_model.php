<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Catalogos_model extends CI_Model {

    /**
     * Catalogos_model::__construct()
     * 
     * @return
     */
    function __construct()
    {
        parent::__construct();
    }
    
    
    /**
     * Catalogos_model::productos()
     * 
     * @param mixed $tipo
     * @return
     */
    function productos()
    {
        $sql = "SELECT * from productos;";
        $query = $this->db->query($sql);
        
        return $query->result();
    }
    
    function productos_sucursal($sucursal)
    {
        $sql = "SELECT ean, p.sec, descripcion, sustancia, presentacion, case when s.precio is null then p.precio else s.precio end as precio, ultimocosto, iva, fisico, linea,
sublinea, antibiotico, minimo, maximo, preorden, marca, imagen, alta, cambio, descuento_limitado
FROM productos p
LEFT JOIN productos_con_precio_especial_sec s on p.sec = s.sec and s.sucursal = ?;";
        $query = $this->db->query($sql, $sucursal);
        
        return $query->result();
    }

    function productos_inventario($tipo)
    {
        switch($tipo){
            
            case "G":

                $sql = "SELECT c.ean, c.descripcion, '0' as inv FROM catalogo.catalogo_productos_gen c
                        join pdv.sublineas s on c.linea = s.linea and c.sublinea = s.sublinea;";
            
            break;
            
            case "D":

                $sql = "SELECT c.ean, c.descripcion, '0' FROM catalogo.catalogo_productos_ddr c
                        join pdv.sublineas s on c.linea = s.linea and c.sublinea = s.sublinea;";
            
            break;

            default:

                $sql = "SELECT c.* FROM catalogo.catalogo_productos_gen c
                        join pdv.sublineas s on c.linea = s.linea and c.sublinea = s.sublinea;";
            
            break;

        }
        
        
        
        $query = $this->db->query($sql);
        
        return $query->result();
    }

    /**
     * Catalogos_model::cias()
     * 
     * @return
     */
    function cias()
    {
        $query = $this->db->get('cia');
        return $query->result();
    }

    /**
     * Catalogos_model::descuentos_mayoreo()
     * 
     * @return
     */
    function descuentos_mayoreo()
    {
        $query = $this->db->get('pdv.descuentos_mayoreo');
        return $query->result();
    }

    /**
     * Catalogos_model::fidelizacion_tipo()
     * 
     * @return
     */
    function fidelizacion_tipo()
    {
        $query = $this->db->get('pdv.fidelizacion_tipo');
        return $query->result();
    }

    /**
     * Catalogos_model::formas_pago()
     * 
     * @return
     */
    function formas_pago()
    {
        $query = $this->db->get('pdv.formas_pago');
        return $query->result();
    }

    /**
     * Catalogos_model::lineas()
     * 
     * @return
     */
    function lineas()
    {
        $query = $this->db->get('lineas');
        return $query->result();
    }

    /**
     * Catalogos_model::sublineas()
     * 
     * @return
     */
    function sublineas()
    {
        $query = $this->db->get('sublineas');
        return $query->result();
    }

    /**
     * Catalogos_model::sucursales()
     * 
     * @return
     */
    function sucursales()
    {
        $query = $this->db->get('sucursales');
        return $query->result();
    }

    /**
     * Catalogos_model::proveedores()
     * 
     * @return
     */
    function proveedores()
    {
        $query = $this->db->get('proveedores');
        return $query->result();
    }

    /**
     * Catalogos_model::tipos_movimientos()
     * 
     * @return
     */
    function tipos_movimientos()
    {
        $query = $this->db->get('tipos_movimientos');
        return $query->result();
    }

    /**
     * Catalogos_model::cliente_tipo()
     * 
     * @return
     */
    function cliente_tipo()
    {
        $query = $this->db->get('cliente_tipo');
        return $query->result();
    }

    /**
     * Catalogos_model::clientes()
     * 
     * @return
     */
    function clientes()
    {
        $query = $this->db->get('clientes');
        return $query->result();
    }

    /**
     * Catalogos_model::clientes_autorizados()
     * 
     * @param mixed $sucursal
     * @return
     */
    function clientes_autorizados($sucursal)
    {
        $this->db->where('sucursal', $sucursal);
        $query = $this->db->get('clientes_credito_autorizado');
        return $query->result();
    }

    /**
     * Catalogos_model::usuarios_sucursal()
     * 
     * @param mixed $sucursal
     * @return
     */
    function usuarios_sucursal($sucursal)
    {
        $sql = "SELECT 0 as sucursal, numeroempleado, nombrecompleto, password, activo, nivel FROM usuarios where numeroempleado <> 40002;";

        $query = $this->db->query($sql, $sucursal);
        return $query->result();
    }

    /**
     * Catalogos_model::usuario_nomina()
     * 
     * @param mixed $nomina
     * @return
     */
    function usuario_nomina($nomina)
    {
        $sql = "SELECT succ as sucursal, nomina as numeroempleado, completo as nombrecompleto, MD5(concat(nomina, nomina)) as password
, case when tipo = 1 then 1 else 0 end as activo
, case when puestox = 'MEDICO' then 2 else 1 end as nivel
FROM catalogo.cat_empleado c
where nomina = ?;";

        $query = $this->db->query($sql, $nomina);
        return $query->result();
    }

    /**
     * Catalogos_model::usuarios()
     * 
     * @return
     */
    function usuarios()
    {
        $sql = "SELECT succ as sucursal, nomina as numeroempleado, completo as nombrecompleto, MD5(concat(nomina, nomina)) as password
, case when tipo = 1 then 1 else 0 end as activo
, case when puestox = 'MEDICO' then 2 else 1 end as nivel
FROM catalogo.cat_empleado c
where tipo = 1;";

        $query = $this->db->query($sql);
        return $query->result();
    }

    function tarjetas_autorizadas($sucursal)
    {
        $sql = "SELECT suc as sucursal, tipo, fol1, fol2 FROM vtadc.tarjetas_suc t where suc = ?;";

        $query = $this->db->query($sql, $sucursal);
        return $query->result();
    }

    function tcp()
    {
        $sql = "SELECT codigo, trim(nombre) as nombre, vigencia FROM vtadc.tarjetas t where tipo = 1;";

        $query = $this->db->query($sql);
        return $query->result();
    }

}