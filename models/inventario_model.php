<?php
class Inventario_model extends CI_Model {

    /**
     * Catalogos_model::__construct()
     * 
     * @return
     */
    function __construct()
    {
        parent::__construct();
    }
    
    function getInventario()
    {
        $sql = "SELECT inventarioID, cvearticulo, comercial, susa, descripcion, pres, lote, caducidad, cantidad, ean, marca, suministro, tipoprod, ventaxuni, numunidades, posicionID, nivelID, moduloID, pasilloID, ubicacion
FROM inventario i
join articulos a using(id)
join temporal_suministro s on a.tipoprod = s.cvesuministro
left join posicion p using(ubicacion)
where cantidad <> 0 and i.clvsucursal = ?
order by tipoprod, cvearticulo * 1 asc;";
        $query = $this->db->query($sql, $this->session->userdata('clvsucursal'));
        return $query;
    }
    
    function getInventarioBusqueda($clave, $susa)
    {
        if(strlen(trim($clave)) > 0)
        {
            $filtro1 = " and (cvearticulo like '%$clave%' or ean like '%$clave%')";
        }else{
            $filtro1 = null;
        }
        
        if(strlen(trim($susa)) > 0)
        {
            $filtro2 = " and (susa like '%$susa%' or comercial like '%$susa%')";
        }else{
            $filtro2 = null;
        }

        $sql = "SELECT inventarioID, cvearticulo, comercial, susa, descripcion, pres, lote, caducidad, cantidad, ean, marca, suministro, tipoprod, ventaxuni, numunidades, posicionID, nivelID, moduloID, pasilloID, ubicacion
FROM inventario i
join articulos a using(id)
join temporal_suministro s on a.tipoprod = s.cvesuministro
left join posicion p using(ubicacion)
where i.clvsucursal = ? $filtro1 $filtro2
order by tipoprod, cvearticulo * 1 asc;";
        $query = $this->db->query($sql, $this->session->userdata('clvsucursal'));
        return $query;
    }

    function getInventarioByArea($areaID)
    {
        $sql = "SELECT inventarioID, cvearticulo, comercial, susa, descripcion, pres, lote, caducidad, cantidad, ean, marca, suministro, tipoprod, ventaxuni, numunidades, posicionID, nivelID, moduloID, pasilloID, ubicacion
FROM inventario i
join articulos a using(id)
join temporal_suministro s on a.tipoprod = s.cvesuministro
left join ubicacion u using(ubicacion)
where cantidad <> 0 and i.clvsucursal = ? and areaID = ?
order by tipoprod, cvearticulo * 1 asc;";
        $query = $this->db->query($sql, array($this->session->userdata('clvsucursal'), $areaID));
        return $query;
    }

    function getInventarioByPasillo($pasilloID)
    {
        $sql = "SELECT inventarioID, cvearticulo, comercial, susa, descripcion, pres, lote, caducidad, cantidad, ean, marca, suministro, tipoprod, ventaxuni, numunidades, posicionID, nivelID, moduloID, pasilloID, ubicacion
FROM inventario i
join articulos a using(id)
join temporal_suministro s on a.tipoprod = s.cvesuministro
left join ubicacion u using(ubicacion)
where cantidad <> 0 and i.clvsucursal = ? and pasilloID = ?
order by tipoprod, cvearticulo * 1 asc;";
        $query = $this->db->query($sql, array($this->session->userdata('clvsucursal'), $pasilloID));
        return $query;
    }

    function getInventarioReciba()
    {
        $sql = "SELECT inventarioID, cvearticulo, comercial, susa, descripcion, pres, lote, caducidad, cantidad, ean, marca, suministro, tipoprod, ventaxuni, numunidades, posicionID, nivelID, moduloID, pasilloID, ubicacion
FROM inventario i
join articulos a using(id)
join temporal_suministro s on a.tipoprod = s.cvesuministro
left join posicion p using(ubicacion)
left join pasillo o using(pasilloID)
where cantidad <> 0 and i.clvsucursal = ? and pasilloTipo = 3
order by tipoprod, cvearticulo * 1 asc;";
        $query = $this->db->query($sql, $this->session->userdata('clvsucursal'));
        return $query;
    }

    function getInventariobyTipoprod($tipoprod)
    {
        $sql = "SELECT inventarioID, cvearticulo, comercial, susa, descripcion, pres, lote, caducidad, cantidad, ean, marca, suministro, tipoprod, ventaxuni, numunidades
FROM inventario i
join articulos a using(id)
join temporal_suministro s on a.tipoprod = s.cvesuministro
where cantidad <> 0 and i.clvsucursal = ? and a.tipoprod = ?
order by tipoprod, cvearticulo * 1 asc;";
        $query = $this->db->query($sql, array($this->session->userdata('clvsucursal'), $tipoprod));
        return $query;
    }

    function getInventarioByCaducidad($caducidad)
    {
        
        switch ((int)$caducidad) {
            case 0:
                $cad = " and DATEDIFF(case when caducidad = '0000-00-00' then '9999-12-31' else caducidad end, now()) <= 0";
                break;
            case 1:
                $cad = " and DATEDIFF(case when caducidad = '0000-00-00' then '9999-12-31' else caducidad end, now()) between 1 and 90";
                break;
            case 2:
                $cad = " and DATEDIFF(case when caducidad = '0000-00-00' then '9999-12-31' else caducidad end, now()) between 91 and 180";
                break;
            case 3:
                $cad = " and DATEDIFF(case when caducidad = '0000-00-00' then '9999-12-31' else caducidad end, now()) between 181 and 365";
                break;
            case 4:
                $cad = " and DATEDIFF(case when caducidad = '0000-00-00' then '9999-12-31' else caducidad end, now())> 365";
                break;
        }
        
        
        $sql = "SELECT inventarioID, cvearticulo, comercial, susa, descripcion, pres, lote, caducidad, cantidad, ean, marca, suministro, tipoprod, ventaxuni, numunidades
FROM inventario i
join articulos a using(id)
join temporal_suministro s on a.tipoprod = s.cvesuministro
where cantidad <> 0 and i.clvsucursal = ? $cad
order by tipoprod, cvearticulo * 1 asc;";
        $query = $this->db->query($sql, $this->session->userdata('clvsucursal'));
        return $query;
        
    }
    
    function getInventarioByID($inventarioID)
    {
        $sql = "SELECT inventarioID, cvearticulo, comercial, susa, descripcion, pres, lote, caducidad, cantidad, ean, marca, suministro, tipoprod, ventaxuni, numunidades, comercial, ubicacion
FROM inventario i
join articulos a using(id)
join temporal_suministro s on a.tipoprod = s.cvesuministro
where inventarioID = ?
order by tipoprod, cvearticulo * 1 asc;";
        $query = $this->db->query($sql, $inventarioID);
        return $query;
    }
    
    function getCvearticuloPieza($cvearticulo)
    {
        $sql = "SELECT * FROM articulos a where cvearticulo = ?;";
        $query = $this->db->query($sql, $cvearticulo.'*p');
        return $query;
    }
    
    function actualizaDatos($lote, $caducidad, $marca, $ean, $inventarioID, $comercial)
    {
        $this->db->trans_start();
        
        $query = $this->getInventarioByInventarioID($inventarioID);
        $row = $query;
        
        $this->db->where('id', $row->id);
        $this->db->where('lote', $lote);
        $this->db->where('ubicacion', $row->ubicacion);
        $this->db->where_not_in('inventarioID', array($inventarioID));
        
        $query2 = $this->db->get('inventario');
        
        
        if($query2->num_rows() == 0)
        {

            $data = array(
                'lote' => $lote,
                'caducidad' => $caducidad,
                'tipoMovimiento' => 3,
                'subtipoMovimiento' => 16,
                'receta' => 0,
                'usuario' => $this->session->userdata('usuario'),
                'movimientoID' => 0,
                'ean' => $ean,
                'marca' => $marca,
                'comercial' => $comercial 
                );
            $this->db->update('inventario', $data, array('inventarioID' => $inventarioID));
            
        }else{
            $row2 = $query2->row();
            
            if((int)$row2->cantidad <= 0)
            {
                $data = array(
                    'id'    => $row->id,
                    'lote' => $lote,
                    'caducidad' => $caducidad,
                    'cantidad' => $row->cantidad,
                    'tipoMovimiento' => 3,
                    'subtipoMovimiento' => 16,
                    'receta' => 0,
                    'usuario' => $this->session->userdata('usuario'),
                    'movimientoID' => 0,
                    'ean' => $row->ean,
                    'marca' => $row->marca,
                    'costo' => $row->costo,
                    'clvsucursal' => $row->clvsucursal,
                    'ubicacion' => $row->ubicacion,
                    'comercial' => $row->comercial,
                    'inventarioID' => $row2->inventarioID 
                    );
                $this->db->set('ultimo_movimiento', 'now()', false);
                $this->db->replace('inventario', $data);

                $data = array(
                    'tipoMovimiento' => 3,
                    'subtipoMovimiento' => 16,
                    'receta' => 0,
                    'cantidad' => 0,
                    'usuario' => $this->session->userdata('usuario'),
                    'movimientoID' => 0
                    );
                $this->db->set('ultimo_movimiento', 'now()', false);
                $this->db->update('inventario', $data, array('inventarioID' => $inventarioID));


            }else{
                $this->session->set_flashdata('error', 'Debes hacer ajuste');
            }
        }
        
        $this->db->trans_complete();
        
    }
    
    function actualizaCantidad($cantidad, $inventarioID)
    {
        $data = array(
            'tipoMovimiento' => 3,
            'subtipoMovimiento' => 11,
            'receta' => 0,
            'usuario' => $this->session->userdata('usuario'),
            'movimientoID' => 0,
            'cantidad' => $cantidad
            );
        $this->db->update('inventario', $data, array('inventarioID' => $inventarioID));
    }

    function kardex($cvearticulo, $lote, $fecha1, $fecha2, $subtipoMovimiento)
    {
        
        if($lote == 'TODOS')
        {
            $where_lote = null;
        }else{
            $where_lote = " and lote = '$lote'";
        }
        
        if($subtipoMovimiento == 0)
        {
            $where_subtipoMovimiento = null;
        }else{
            $where_subtipoMovimiento = " and subtipoMovimiento = $subtipoMovimiento";
        }
        
        $sql = "SELECT cvearticulo, comercial, susa, descripcion, pres, lote, caducidad, cantidadOld, cantidadNew, cast(cantidadNew - CantidadOld  as signed) as cantidad, tipoMovimientoDescripcion, subtipoMovimientoDescripcion, receta, movimientoID, fechaKardex, ubicacion_anterior, ubicacion_actual
FROM kardex k
join articulos using(id)
join tipo_movimiento t using(tipoMovimiento)
join subtipo_movimiento s using(subtipoMovimiento)
where cvearticulo = ? and fechaKardex between ? and ? $where_lote $where_subtipoMovimiento
order by kardexID asc;";

        $query = $this->db->query($sql, array((string)$cvearticulo, $fecha1.' 00:00:00', $fecha2.' 23:59:59'));
        return $query;
    }
    
    function getSuministro($tipoprod)
    {
        $this->db->where('cvesuministro', $tipoprod);
        $query = $this->db->get('temporal_suministro');
        
        if($query->num_rows() > 0)
        {
            $row = $query->row();
            $suministro = $row->suministro;
        }else{
            $suministro = null;
        }
        
        return $suministro;
    }
    
    function  getInventarioCabezaTipo($tipoprod)
    {
        $suministro = $this->getSuministro($tipoprod);
        
        $tabla = '<table>
            <tr>
                <td style="text-align: center; "><b>'.COMPANIA.'</b></td>
                <td style="text-align: center; "><b>'.$this->session->userdata('clvsucursal').' - '.$this->session->userdata('sucursal').'</b></td>
            </tr>
            <tr>
                <td style="text-align: center; "><b>INVENTARIO DE '.$suministro.'</b></td>
                <td style="text-align: center; ">FECHA DE GENERACION: <b>'.date('d/m/Y H:i:s').'</b></td>
            </tr>
        </table>
        ';
        
        $tabla .= "
        <br />";
        
        $tabla .= "
        <table>
            <thead>
                <tr>
                    <th style=\"width: 7%;\"><b>Clave</b></th>
                    <th style=\"width: 19%;\"><b>Sustancia Activa</b></th>
                    <th style=\"width: 19%;\"><b>Descripcion</b></th>
                    <th style=\"width: 18%;\"><b>Presentacion</b></th>
                    <th style=\"width: 7%;\"><b>Lote</b></th>
                    <th style=\"width: 5%; text-align: left; \"><b>Cad.</b></th>
                    <th style=\"width: 7%; text-align: left; \"><b>EAN</b></th>
                    <th style=\"width: 10%; text-align: left; \"><b>Marca</b></th>
                    <th style=\"width: 6%; text-align: right; \"><b>Inv.</b></th>
                </tr>
            </thead>
            </table>";
        return $tabla;
    }
    
    function getArea($areaID)
    {
        $this->db->where('areaID', $areaID);
        $query = $this->db->get('area');
        
        if($query->num_rows() == 1)
        {
            $row = $query->row();
            return $row->area;
        }else{
            return null;
        }
    }

    function  getInventarioCabezaArea($areaID)
    {
        $area = $this->getArea($areaID);
        
        $tabla = '<table>
            <tr>
                <td style="text-align: center; "><b>'.COMPANIA.'</b></td>
                <td style="text-align: center; "><b>'.$this->session->userdata('clvsucursal').' - '.$this->session->userdata('sucursal').'</b></td>
            </tr>
            <tr>
                <td style="text-align: center; "><b>INVENTARIO AREA: '.$area.'</b></td>
                <td style="text-align: center; ">FECHA DE GENERACION: <b>'.date('d/m/Y H:i:s').'</b></td>
            </tr>
        </table>
        ';
        
        $tabla .= "
        <br />";
        
        $tabla .= "
        <table>
            <thead>
                <tr>
                    <th style=\"width: 7%;\"><b>Clave</b></th>
                    <th style=\"width: 19%;\"><b>Sustancia Activa</b></th>
                    <th style=\"width: 19%;\"><b>Descripcion</b></th>
                    <th style=\"width: 18%;\"><b>Presentacion</b></th>
                    <th style=\"width: 7%;\"><b>Lote</b></th>
                    <th style=\"width: 5%; text-align: left; \"><b>Cad.</b></th>
                    <th style=\"width: 7%; text-align: left; \"><b>EAN</b></th>
                    <th style=\"width: 10%; text-align: left; \"><b>Marca</b></th>
                    <th style=\"width: 6%; text-align: right; \"><b>Inv.</b></th>
                </tr>
            </thead>
            </table>";
        return $tabla;
    }

    function getPasillo($pasilloID)
    {
        $sql = "SELECT * FROM pasillo p
join area a using(areaID)
where pasilloID = ?;";
        $query = $this->db->query($sql, $pasilloID);
        
        if($query->num_rows() == 1)
        {
            $row = $query->row();
            return $row->area . ' - ' . $row->pasillo;
        }else{
            return null;
        }
    }

    function  getInventarioCabezaPasillo($pasilloID)
    {
        $pasillo = $this->getPasillo($pasilloID);
        
        $tabla = '<table>
            <tr>
                <td style="text-align: center; "><b>'.COMPANIA.'</b></td>
                <td style="text-align: center; "><b>'.$this->session->userdata('clvsucursal').' - '.$this->session->userdata('sucursal').'</b></td>
            </tr>
            <tr>
                <td style="text-align: center; "><b>INVENTARIO AREA: '.$pasillo.'</b></td>
                <td style="text-align: center; ">FECHA DE GENERACION: <b>'.date('d/m/Y H:i:s').'</b></td>
            </tr>
        </table>
        ';
        
        $tabla .= "
        <br />";
        
        $tabla .= "
        <table>
            <thead>
                <tr>
                    <th style=\"width: 7%;\"><b>Clave</b></th>
                    <th style=\"width: 19%;\"><b>Sustancia Activa</b></th>
                    <th style=\"width: 19%;\"><b>Descripcion</b></th>
                    <th style=\"width: 18%;\"><b>Presentacion</b></th>
                    <th style=\"width: 7%;\"><b>Lote</b></th>
                    <th style=\"width: 5%; text-align: left; \"><b>Cad.</b></th>
                    <th style=\"width: 7%; text-align: left; \"><b>EAN</b></th>
                    <th style=\"width: 10%; text-align: left; \"><b>Marca</b></th>
                    <th style=\"width: 6%; text-align: right; \"><b>Inv.</b></th>
                </tr>
            </thead>
            </table>";
        return $tabla;
    }

    function  getInventarioCabezaCaducidad($caducidad, $caducidades)
    {
        
        $tabla = '<table>
            <tr>
                <td style="text-align: center; "><b>'.COMPANIA.'</b></td>
                <td style="text-align: center; "><b>'.$this->session->userdata('clvsucursal').' - '.$this->session->userdata('sucursal').'</b></td>
            </tr>
            <tr>
                <td style="text-align: center; "><b>INVENTARIO CON CADUCIDAD: '.strtoupper($caducidades[$caducidad]).'</b></td>
                <td style="text-align: center; ">FECHA DE GENERACION: <b>'.date('d/m/Y H:i:s').'</b></td>
            </tr>
        </table>
        ';
        
        $tabla .= "
        <br />";
        
        $tabla .= "
        <table>
            <thead>
                <tr>
                    <th style=\"width: 7%;\"><b>Clave</b></th>
                    <th style=\"width: 19%;\"><b>Sustancia Activa</b></th>
                    <th style=\"width: 19%;\"><b>Descripcion</b></th>
                    <th style=\"width: 18%;\"><b>Presentacion</b></th>
                    <th style=\"width: 7%;\"><b>Lote</b></th>
                    <th style=\"width: 5%; text-align: left; \"><b>Cad.</b></th>
                    <th style=\"width: 7%; text-align: left; \"><b>EAN</b></th>
                    <th style=\"width: 10%; text-align: left; \"><b>Marca</b></th>
                    <th style=\"width: 6%; text-align: right; \"><b>Inv.</b></th>
                </tr>
            </thead>
            </table>";
        
        return $tabla;
    }
    
    function getArticulo($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('articulos');
        
        return $query->row();
    }
    
    function  getAntibioticosCabeza($id, $lote)
    {
        $data = $this->getArticulo($id);
        $tabla = '<table>
            <tr>
                <td style="text-align: center; "><b>'.COMPANIA.'</b></td>
                <td style="text-align: center; "><b>'.$this->session->userdata('clvsucursal').' - '.$this->session->userdata('sucursal').'</b></td>
            </tr>
            <tr>
                <td style="text-align: center; "><b>REPORTE DE ANTIBIOTICOS</b>, CLAVE: <b>'.$data->cvearticulo.'</b>, LOTE: <b>'.$lote.'</b></td>
                <td style="text-align: center; ">FECHA DE GENERACION: <b>'.date('d/m/Y H:i:s').'</b></td>
            </tr>
        </table>
        ';
        
        $tabla .= "
        <br />";
        
        $tabla .= "
        <table>
            <thead>
                <tr>
                    <th style=\"width: 5%;\"><b>Entrada</b></th>
                    <th style=\"width: 5%;\"><b>Salida</b></th>
                    <th style=\"width: 15%;\"><b>Sustancia Activa</b></th>
                    <th style=\"width: 19%;\"><b>Descripcion</b></th>
                    <th style=\"width: 15%;\"><b>Presentacion</b></th>
                    <th style=\"width: 5%; text-align: right; \"><b>Piezas </b></th>
                    <th style=\"width: 10%; text-align: left; \"><b>Medico</b></th>
                    <th style=\"width: 5%; text-align: left; \"><b>Cedula</b></th>
                    <th style=\"width: 18%; text-align: left; \"><b>Domicilio</b></th>
                    <th style=\"width: 5%; text-align: left; \"><b>Folio</b></th>
                </tr>
            </thead>
            </table>";
        return $tabla;
    }

    function getAntibioticoGeneral()
    {
        $sql = "SELECT id, cvearticulo, susa, descripcion, pres
FROM kardex k
join articulos a using(id)
where antibiotico = 1
group by id
order by susa;";
        
        $query = $this->db->query($sql);
        return $query;
        
    }

    function getAntibioticoGeneralByID($id)
    {
        $sql = "SELECT id, cvearticulo, susa, descripcion, pres, lote, caducidad
FROM kardex k
join articulos a using(id)
where antibiotico = 1 and id = ?
group by id, lote
order by susa;";
        
        $query = $this->db->query($sql, (int)$id);
        return $query;
        
    }
    
    function getAntibioticoImpresion($id, $lote)
    {
        $sql = "SELECT case when k.tipoMovimiento = 1 then fechaKardex else '' end as entrada, case when k.tipoMovimiento = 2 then fechaKardex when k.tipoMovimiento = 3 then fechaKardex else '' end as salida, cvearticulo, susa, descripcion, pres, cantidadNew - cantidadOld as piezas, lote, nombremedico, cvemedico, folioreceta
FROM kardex k
join articulos a using(id)
left join movimiento m using(movimientoID)
left join receta r on r.consecutivo = k.receta
where antibiotico = 1 and id = ? and lote = ?
order by kardexID
;";
        $query = $this->db->query($sql, array($id, $lote));
        
        return $query;
    }
    
    function inventarioConcentrado()
    {
        $sql = "SELECT id, cvearticulo, susa, descripcion, pres, ifnull(demanda, 0) as demanda, ifnull(cantidad, 0) as inventario, (case when demanda - cantidad > 0 then demanda - cantidad else 0 end) as pedido
FROM articulos a
left join demandacalculada d using(id)
left join inv i using(id)
where tipoPresentacion = 1;";

        $query = $this->db->query($sql);
        return $query;
    }
    
    function pedido()
    {
        $sql = "SELECT id, cvearticulo, susa, descripcion, pres, ifnull(demanda, 0) as demanda, ifnull(cantidad, 0) as inventario, (case when demanda - cantidad > 0 then demanda - cantidad else 0 end) as pedido
FROM articulos a
left join demandacalculada d using(id)
left join inv i using(id)
where tipoPresentacion = 1
having pedido > 0;";
        $query = $this->db->query($sql);
        return $query;
    }
    
    function getUbicacionInventario($inventarioID)
    {
        $sql = "SELECT * FROM inventario i
join articulos a using(id)
left join posicion p using(ubicacion)
where inventarioID = ?;";
        $query = $this->db->query($sql, $inventarioID);
        return $query;
    }
    
    function getInventarioByInventarioID($inventarioID)
    {
        $this->db->where('inventarioID', $inventarioID);
        $query = $this->db->get('inventario');
        return $query->row();
    }
    
    function updateUbicacion($inventarioID, $ubicacion, $cantidad)
    {
        $this->db->trans_start();
        
        $inv  = $this->getInventarioByInventarioID($inventarioID);
        $cantidadNueva = $inv->cantidad - $cantidad;
        
        $this->db->where('id', $inv->id);
        $this->db->where('lote', $inv->lote);
        $this->db->where('ubicacion', $ubicacion);
        $query = $this->db->get('inventario');
        
        if($query->num_rows() > 0)
        {
            $row = $query->row();
            
            $cantidadActualiza = $row->cantidad + $cantidad;
            
            $actualiza = array(
                'cantidad' => $cantidadActualiza, 
                'tipoMovimiento' => 3, 
                'subtipoMovimiento' => 19, 
                'receta' => 0, 
                'usuario' => $this->session->userdata('usuario'), 
                'movimientoID' => 0,
                'ean' => $inv->ean, 
                'marca' => $inv->marca, 
                'costo' => $inv->costo, 
                'clvsucursal' => $inv->clvsucursal, 
                'ubicacion' => $ubicacion
            );
            $this->db->set('ultimo_movimiento', 'now()', false);
            $this->db->update('inventario', $actualiza, array('inventarioID' => $row->inventarioID));

        }else{
            $inserta = array(
                'id' => $inv->id, 
                'lote' => $inv->lote, 
                'caducidad' => $inv->caducidad, 
                'cantidad' => $cantidad, 
                'tipoMovimiento' => 3, 
                'subtipoMovimiento' => 19, 
                'receta' => 0, 
                'usuario' => $this->session->userdata('usuario'), 
                'movimientoID' => 0,
                'ean' => $inv->ean, 
                'marca' => $inv->marca, 
                'costo' => $inv->costo, 
                'clvsucursal' => $inv->clvsucursal, 
                'ubicacion' => $ubicacion
            );
            $this->db->set('ultimo_movimiento', 'now()', false);
            $this->db->insert('inventario', $inserta);
        }
        
        
        $cantidadRestante = $inv->cantidad - $cantidad;
        
            $actualizaRestante = array(
                'cantidad' => $cantidadRestante, 
                'tipoMovimiento' => 3, 
                'subtipoMovimiento' => 19, 
                'receta' => 0, 
                'usuario' => $this->session->userdata('usuario'), 
                'movimientoID' => 0,
            );
            $this->db->set('ultimo_movimiento', 'now()', false);
            $this->db->update('inventario', $actualizaRestante, array('inventarioID' => $inv->inventarioID));
            
            $this->db->trans_complete();
    }

}