<?php
class Metro_model extends CI_Model {

    /**
     * Catalogos_model::__construct()
     * 
     * @return
     */
     
     
     var $servicio = null;
     
    function __construct()
    {
        parent::__construct();
        $this->servicio = SERVICIO;
    }
    
    function getSucursales()
    {
        $this->db->order_by('clvsucursal');
        $query = $this->db->get('sucursales');
        
        $a = array('TODOS' => 'TODOS');
        foreach($query->result() as $row)
        {
            $a[$row->clvsucursal] = $row->clvsucursal. ' - ' . trim($row->descsucursal);
        }
        
        return $a;
    }
    
    function getConcentradoFechas($fecha1, $fecha2)
    {
        $sql = "select cvecentrosalud, descsucursal, case when tipoprod = 0 then 'MEDICAMENTO' else 'MATERIAL DE CURACION' end as suministro, sum(cantidadsurtida) as cantidadsurtida, sum(precioven * cantidadsurtida) as importe, sum(case when tipoprod = 0 then 0 else precioven * 0.16 * cantidadsurtida end) as iva, sum(9.98 * cantidadsurtida) as servicio, sum(9.98 * cantidadsurtida *0.16) as servicioiva
from receta r
left join sucursales s on r.cvecentrosalud = s.clvsucursal 
left join articulos a on r.cvearticulo = a.cvearticulo
where status = 't' and fecha between ? and ?
group by cvecentrosalud, descsucursal, suministro
order by cvecentrosalud;";

        $query = $this->db->query($sql, array($fecha1, $fecha2));
        
        return $query;
    }
    
    function getConcentradoArticulo($fecha1, $fecha2)
    {
        $sql = "select cvearticulo, a.descripcion, susa, pres, precioven, sum(cantidadsurtida) as cantidadsurtida, sum(precioven * cantidadsurtida) as importe from receta r
join articulos a using(cvearticulo)
where fecha between ? and ? and status = 't'
group by cvearticulo, a.descripcion, susa, pres, precioven
order by importe desc
;";
        $query = $this->db->query($sql, array($fecha1, $fecha2));
        return $query;
    }
    
    function getConcentradoArticulo2($fecha1, $fecha2)
    {
        $sql = "select a.id, a.cvearticulo, a.descripcion, susa, pres, precioven, numunidades, sum(cantidadsurtida) as cantidadsurtida, sum(precioven * cantidadsurtida) as importe, sum(case when tipoprod = '0' then 0 else precioven * cantidadsurtida * 0.16 end) as iva, sum(case when tipoprod = '0' then precioven * cantidadsurtida else precioven * cantidadsurtida * 1.16 end) as subtotal, sum(9.98 * cantidadsurtida) as servicio, sum(9.98 * cantidadsurtida *0.16) as servicioiva
from receta r
join articulos a on r.cvearticulo = a.cvearticulo and fecha between ? and ? and status = 't'
group by a.id, a.cvearticulo, a.descripcion, susa, pres, precioven, numunidades
order by importe desc
;";
        $query = $this->db->query($sql, array($fecha1, $fecha2));
        return $query;
    }
    
    function getDetalleArticulo($fecha1, $fecha2, $articulo)
    {
        $sql = "select fecha, folioreceta, cvecentrosalud, descsucursal, a.cvearticulo, a.descripcion, susa, pres, precioven, cantidadrequerida, cantidadsurtida, precioven * cantidadsurtida as importe, case when tipoprod = '0' then 0 else precioven * cantidadsurtida * 0.16 end as iva, case when tipoprod = '0' then precioven * cantidadsurtida else precioven * cantidadsurtida * 1.16 end as subtotal, 9.98 * cantidadsurtida as servicio, 9.98 * cantidadsurtida *0.16 as servicioiva
from receta r
join articulos a on r.cvearticulo = a.cvearticulo and fecha between ? and ? and status = 't' and a.id = ?
join sucursales s on r.cvecentrosalud = s.clvsucursal
order by importe desc";
        $query = $this->db->query($sql, array($fecha1, $fecha2, $articulo));
        return $query;

    }

    function getConcentradoTotal()
    {
        $sql = "select 
extract(year from fecha)as anio, 
extract(month from fecha) as mes, 
sum(cantidadsurtida) as cantidadsurtida, 
sum(preciosinser * cantidadsurtida) as importe, 
sum(case when tipoprod = '0' then 0 else preciosinser * 0.16 * cantidadsurtida end) as iva, 
sum(costoservicio * cantidadsurtida) as servicio, 
sum(costoservicio * cantidadsurtida *0.16) as servicioiva 
from receta r 
left join sucursales s on r.cvecentrosalud = s.clvsucursal 
left join articulos a on r.cvearticulo = a.cvearticulo 
where status = 't' and fecha >= '2014-06-01' 
group by anio, mes 
order by anio, mes;";
        
        $query = $this->db->query($sql);
        return $query;
    }
    
    function getProgramaCombo()
    {
        $this->db->order_by('idprograma');
        $query = $this->db->get('programa');
        
        $a = array('TODOS' => 'TODOS');
        foreach($query->result() as $row)
        {
            $a[$row->idprograma] = $row->idprograma. ' - ' . trim($row->programa);
        }
        
        return $a;
    }

    function recetas_periodo_detalle($fecha1, $fecha2, $sucursal, $idprograma, $articulo, $funcion)
    {
        $group = '';
        $where = '';
        $uno = '';
        $dos = '';
        if($funcion == 'rpd')
        {
            $this->db->select("r.fecha, programa, clvsucursal, cvemedico, descsucursal, r.cvepaciente, (trim(r.nombre) || ' ' || trim(r.apaterno) || ' ' || trim(r.amaterno)) as nombre, r.cveservicio, r.nombremedico, r.folioreceta, r.cvearticulo, (r.descripcion || ' ' || r.presentacion) as descripcion, requerimiento, r.cantidadsurtida, costounitario, r.cantidadrequerida, (r.cantidadsurtida * costounitario) as importe, CASE WHEN cvesuministro = '0' then 0 else cantidadsurtida * costounitario * 0.16 end as iva", false);
            $order = $this->db->order_by('fecha, folioreceta');
        }
        if($funcion == 'ppd')
        {
            $this->db->select("r.cvearticulo, (r.descripcion || ' ' || r.presentacion) as descripcion, sum(r.cantidadsurtida) as surtida, costounitario, sum(r.cantidadrequerida) as requerida, (sum(r.cantidadsurtida) * costounitario) as importe, CASE WHEN cvesuministro = '0' then 0 else sum(cantidadsurtida) * costounitario * 0.16 end as iva", false);
            $order = $this->db->order_by('importe','desc');
            $group = $this->db->group_by("r.cvearticulo, r.descripcion, r.presentacion, costounitario, r.cvesuministro");
        }
        if($funcion == 'pd')
        {
            $this->db->select("clvsucursal, descsucursal, sum(r.cantidadsurtida) as surtida, costounitario, sum(r.cantidadrequerida) as requerida, (sum(r.cantidadsurtida) * costounitario) as importe, CASE WHEN cvesuministro = '0' then 0 else sum(cantidadsurtida) * costounitario * 0.16 end as iva", false);
            $where = $this->db->where('r.cvearticulo =', $articulo);
            $group = $this->db->group_by("clvsucursal, descsucursal, costounitario, r.cvesuministro");
            $order = $this->db->order_by('importe','desc');
        }
        if($funcion == 'pdp')
        {
            $this->db->select("r.idprograma, programa, sum(r.cantidadsurtida) as surtida, costounitario, sum(r.cantidadrequerida) as requerida, (sum(r.cantidadsurtida) * costounitario) as importe, CASE WHEN cvesuministro = '0' then 0 else sum(cantidadsurtida) * costounitario * 0.16 end as iva", false);
            $where = $this->db->where('r.cvearticulo =', $articulo, 'cvecentrosalud=', $sucursal );
            $group = $this->db->group_by("r.idprograma, programa, costounitario, r.cvesuministro");
            $order = $this->db->order_by('importe','desc');
    
        }
        if($funcion == 'pdr')
        {
            $this->db->select ("r.folioreceta, sum(r.cantidadsurtida) as surtida, costounitario, sum(r.cantidadrequerida) as requerida, (sum(r.cantidadsurtida) * costounitario) as importe, CASE WHEN cvesuministro = '0' then 0 else sum(cantidadsurtida) * costounitario * 0.16 end as iva", false);
            $where = $this->db->where('r.cvearticulo =', $articulo, 'cvecentrosalud=', $sucursal );
            $group = $this->db->group_by("r.folioreceta, costounitario, r.cvesuministro");
            $order = $this->db->order_by('importe','desc');
            
    
        }

        $this->db->from('receta r');
        //$this->db->join('articulos a', 'r.cvearticulo=a.cvearticulo', 'LEFT');
        $this->db->join('programa p', 'r.idprograma = p.idprograma', 'LEFT');
        $this->db->join('sucursales s', 'r.cvecentrosalud = s.clvsucursal', 'LEFT');
        $this->db->join('temporal_requerimiento t', 'r.tiporequerimiento = t.tiporequerimiento', 'LEFT');
        $this->db->where('fecha >=', $fecha1);
        $this->db->where('fecha <=', $fecha2);
        $where;
        $group;

        if($sucursal == 'TODOS')
        {
            
        }else{
            
            $this->db->where('cvecentrosalud', $sucursal);
        }   

        
        if($idprograma == 'TODOS')
        {
            
        }else{

            $this->db->where('trim(r.idprograma)=', substr($idprograma, 0, 1));
            
        }
        
        $this->db->where('status', 't');
        $order;
        $query = $this->db->get();
       
        //echo $this->db->last_query();
        //echo die();
        return $query;
        
    }

    
    function getFormato($fecha1, $fecha2, $sucursal)
    {
        $this->db->select("r.fecha, calleynum || ' ' || colonia as domicilio, numjurisd, programa, clvsucursal, cvemedico, descsucursal, r.cvepaciente, (trim(r.nombre) || ' ' || trim(r.apaterno) || ' ' || trim(r.amaterno)) as nombre, r.cveservicio, r.nombremedico, r.folioreceta, r.cvearticulo, (r.descripcion || ' ' || r.presentacion) as descripcion, requerimiento, r.cantidadsurtida, costounitario, r.cantidadrequerida, (r.cantidadsurtida * costounitario) as importe, CASE WHEN cvesuministro = '0' then 0 else cantidadsurtida * costounitario * 0.16 end as iva", false);
        $this->db->from('receta r');
        //$this->db->join('articulos a', 'r.cvearticulo=a.cvearticulo', 'LEFT');
        $this->db->join('programa p', 'r.idprograma = p.idprograma', 'LEFT');
        $this->db->join('sucursales s', 'r.cvecentrosalud = s.clvsucursal', 'LEFT');
        $this->db->join('temporal_requerimiento t', 'r.tiporequerimiento = t.tiporequerimiento', 'LEFT');
        $this->db->where('fecha >=', $fecha1);
        $this->db->where('fecha <=', $fecha2);
        $this->db->where('cvecentrosalud', $sucursal);
        $this->db->where('status', 't');
        $query = $this->db->get();
        //echo $this->db->last_query();
        //echo die();
        
        return $query;
        
    }

    function getTotalCapturaByRango($fecha1, $fecha2)
    {
        $sql = "select nombreusuario, nomina, count(*) as cuenta, sum(cantidadsurtida) as cantidadsurtida, sum(saldo) as saldo from vista_receta_folio_usuario_fecha r
join usuarios u using(usuario)
where fecha between ? and ?
group by nomina, nombreusuario";
        
        $query = $this->db->query($sql, array($fecha1, $fecha2));
        return $query;

    }
    
    function getRecetasDiarias($fecha1, $fecha2)
    {
        $sql = "select nomina, nombreusuario, sum(registros) as registros, sum(recetas) as recetas, sum(surtida) as surtida, sum(saldo) as saldo from view_recetas_diarias where capturaFecha between ? and ? group by nomina, nombreusuario;";
        $query = $this->db->query($sql, array($fecha1, $fecha2));
        return $query;
    }
    
    function getConcentrado($fecha1, $fecha2, $sucursal)
    {
        $sql = "select ? as perini, ? as perfin, trim(cvecentrosalud) as cvecentrosalud, descsucursal, trim(cvesuministro) as cvesuministro, suministro, trim(tiporequerimiento) as tiporequerimiento, requerimiento, trim(idprograma) as idprograma, programa, status, sum(cantidadrequerida) as cantidadrequerida, sum(cantidadsurtida) as cantidadsurtida, sum(saldo) as importe, sum(case when cvesuministro = '0' then 0 else cantidadsurtida * costounitario * 0.16 end) as iva
from receta r
left join temporal_suministro m using(cvesuministro)
left join temporal_requerimiento q using(tiporequerimiento)
left join programa using(idprograma)
left join sucursales s on r.cvecentrosalud = s.clvsucursal
where fecha between ? and ? and cvecentrosalud = ? and status = 't' and remision = 0
group by cvecentrosalud, descsucursal, cvesuministro, suministro, tiporequerimiento, requerimiento, idprograma, programa, status;";

        $query = $this->db->query($sql, array($fecha1, $fecha2, $fecha1, $fecha2, $sucursal));
        return $query;
    }
    
    function getRemisionDatos($fecha1, $fecha2, $sucursal, $cvesuministro, $tiporequerimiento, $programa)
    {
        $sql = "select ? as perini, ? as perfin, cvecentrosalud, descsucursal, trim(cvesuministro) as cvesuministro, suministro, trim(tiporequerimiento) as tiporequerimiento, requerimiento, trim(idprograma) as idprograma, programa, status, sum(cantidadrequerida) as cantidadrequerida, sum(cantidadsurtida) as cantidadsurtida, sum(saldo) as importe, sum(case when cvesuministro = '0' then 0 else cantidadsurtida * costounitario * 0.16 end) as iva
from receta r
left join temporal_suministro m using(cvesuministro)
left join temporal_requerimiento q using(tiporequerimiento)
left join programa using(idprograma)
left join sucursales s on r.cvecentrosalud = s.clvsucursal
where fecha between ? and ? and cvecentrosalud = ? and cvesuministro = ? and tiporequerimiento = ? and idprograma = ? and status = 't' and remision = 0
group by cvecentrosalud, descsucursal, cvesuministro, suministro, tiporequerimiento, requerimiento, idprograma, programa, status;";

        $query = $this->db->query($sql, array($fecha1, $fecha2, $fecha1, $fecha2, $sucursal, $cvesuministro, $tiporequerimiento, $programa));
        return $query;
    }
    
    function getRemisionesListado($sucursal)
    {
        $sql = "select r.*, r.clvsucursal as cvecentrosalud, descsucursal, suministro, requerimiento, programa
        from remision r
left join temporal_suministro m using(cvesuministro)
left join temporal_requerimiento q using(tiporequerimiento)
left join programa using(idprograma)
left join sucursales s on r.clvsucursal = s.clvsucursal
where r.clvsucursal = ?
order by remision desc;";
        $query = $this->db->query($sql, $sucursal);
        return $query;
    }


}