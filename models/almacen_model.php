<?php
class Almacen_model extends CI_Model {

    /**
     * Catalogos_model::__construct()
     * 
     * @return
     */
    function __construct()
    {
        parent::__construct();
    }
    
    function getAreas()
    {
        $query = $this->db->get('area');
        return $query;
    }
    
    function getArea($areaID)
    {
        $this->db->where('areaID', $areaID);
        $query = $this->db->get('area');
        return $query;
    }
    
    function insertArea($area)
    {
        $this->db->where('area', $area);
        $query = $this->db->get('area');
        
        if($query->num_rows() == 0)
        {
            $data = array('area' => $area);
            $this->db->insert('area', $data);
        }
    }
    
    function updateArea($areaID, $area)
    {
        $this->db->update('area', array('area' => $area), array('areaID' => $areaID));
    }
    
    function getRackByRackID($rackID)
    {
        $this->db->where('rackID', $rackID);
        $query = $this->db->get('rack');
        return $query;
    }
    
    function getPasillosByAreaID($areaID)
    {
        $sql = "SELECT *, count(*) as posiciones FROM pasillo p
left join area a using(areaID)
left join rack r using(rackID)
left join pasillo_tipo o using(pasilloTipo)
left join pasillo_sentido s using(sentido)
left join modulo m using(pasilloID)
left join nivel n using(pasilloID, moduloID)
left join posicion c using(pasilloID, moduloID, nivelID)
where areaID = ?
group by pasilloID;";

        $query = $this->db->query($sql, $areaID);
        return $query;
    }
    
    function insertPasillo($data)
    {
        $this->db->insert('pasillo', $data);
    }

    function updatePasillo($data, $pasilloID)
    {
        $this->db->update('pasillo', $data, array('pasilloID' => $pasilloID));
    }

    function getPasilloByPasilloID($pasilloID)
    {
        $sql = "SELECT * FROM pasillo p
join area a using(areaID)
join rack r using(rackID)
join pasillo_tipo o using(pasilloTipo)
join pasillo_sentido s using(sentido)
where pasilloID = ?;";

        $query = $this->db->query($sql, $pasilloID);
        return $query;
    }
    
    function getModulosByPasilloID($pasilloID)
    {
        $sql = "SELECT moduloID, count(*) as posiciones FROM modulo m
join pasillo p using(pasilloID)
join nivel n using(pasilloID, moduloID)
join posicion s using(pasilloID, moduloID, nivelID)
join pasillo_sentido i using(sentido)
where pasilloID = ?
group by moduloID;";

        $query = $this->db->query($sql, $pasilloID);
        
        return $query;
    }
    
    function getOrdenamientoPasillo($pasilloID)
    {
        $sql = "SELECT ordenamiento FROM pasillo p
join pasillo_sentido s using(sentido)
where pasilloID = ?;";
        $query = $this->db->query($sql, $pasilloID);
        
        if($query->num_rows() > 0)
        {
            $row = $query->row();
            return $row->ordenamiento;
        }else{
            return null;
        }
    }
    
    function drawModuloQuery($pasilloID)
    {
        $ordenamiento = $this->getOrdenamientoPasillo($pasilloID);
        $sql = "SELECT moduloID FROM modulo m where pasilloID = ? order by moduloID $ordenamiento;";
        
        $query = $this->db->query($sql, $pasilloID);
        
        return $query;
        
    }
    
    function lastModulo($pasilloID)
    {
        $sql = "SELECT max(moduloID) as moduloID FROM modulo m where pasilloID = ?;";
        $query = $this->db->query($sql, $pasilloID);
        $row = $query->row();
        return $row->moduloID;
    }
    
    function drawModulo($pasilloID)
    {
        $modulo = '<table class="table table-striped table-bordered" style="font-size: smaller; vertical-align: bottom;">
    <tr>';
    
        $query = $this->drawModuloQuery($pasilloID);
        $lastModulo = $this->lastModulo($pasilloID);
        
        foreach($query->result() as $row)
        {
            if($lastModulo == $row->moduloID)
            {
                $borraModulo = anchor('almacen/eliminaModulo/'.$pasilloID.'/'.$row->moduloID, 'Eliminar', array('class' => 'elimina', 'rel' => 'MODULO'));
            }else{
                $borraModulo = null;
            }
            $modulo .= '<td style="vertical-align: bottom;">'.$this->drawNivel($pasilloID, $row->moduloID).'Modulo '.$row->moduloID.' '.$borraModulo.'</td>';
        }
        
        $modulo .= '    
        </tr>
    </table>';

        return $modulo;
    }
    
    function drawModuloInventario($pasilloID)
    {
        $modulo = '<table class="table table-striped table-bordered" style="font-size: smaller; vertical-align: bottom;">
    <tr>';
    
        $query = $this->drawModuloQuery($pasilloID);
        
        foreach($query->result() as $row)
        {
            $modulo .= '<td style="vertical-align: bottom;">'.$this->drawNivelInventario($pasilloID, $row->moduloID).'Modulo '.$row->moduloID.'</td>';
        }
        
        $modulo .= '    
        </tr>
    </table>';

        return $modulo;
    }

    function drawNivelQuery($pasilloID, $moduloID)
    {
        $sql = "SELECT nivelID FROM nivel n where pasilloID = ? and moduloID = ? order by nivelID desc;";
        $query = $this->db->query($sql, array($pasilloID, $moduloID));
        return $query;
    }
    
    function lastNivel($pasilloID, $moduloID)
    {
        $sql = "SELECT max(nivelID) as nivelID FROM nivel n where pasilloID = ? and moduloID = ?;";
        $query = $this->db->query($sql, array($pasilloID, $moduloID));
        $row = $query->row();
        return $row->nivelID;
    }

    function drawNivel($pasilloID, $moduloID)
    {
        $nivel = '
        <table class="table table-striped table-bordered">';
        
        $query = $this->drawNivelQuery($pasilloID, $moduloID);
        $lastNivel = $this->lastNivel($pasilloID, $moduloID);
        

        foreach($query->result() as $row)
        {
            if($lastNivel == $row->nivelID)
            {
                $borraNivel = anchor('almacen/eliminaNivel/'.$pasilloID.'/'.$moduloID.'/'.$row->nivelID, 'Eliminar', array('class' => 'elimina', 'rel' => 'NIVEL')).' | '.anchor('almacen/agregaNivel/'.$pasilloID.'/'.$moduloID.'/'.$row->nivelID, 'Agregar', array('class' => 'agrega', 'rel' => 'NIVEL'));
            }else{
                $borraNivel = null;
            }

            $nivel .= '
            <tr>
                <td>'.$this->drawPosicion($pasilloID, $moduloID, $row->nivelID).'Nivel '.$row->nivelID.' '.$borraNivel.'</td>
            </tr>';
        }
        
        $nivel .='        
        </table>';
        
        return $nivel;
    }

    function drawNivelInventario($pasilloID, $moduloID)
    {
        $nivel = '
        <table class="table table-striped table-bordered">';
        
        $query = $this->drawNivelQuery($pasilloID, $moduloID);

        foreach($query->result() as $row)
        {

            $nivel .= '
            <tr>
                <td>'.$this->drawPosicionInventario($pasilloID, $moduloID, $row->nivelID).'Nivel '.$row->nivelID.'</td>
            </tr>';
        }
        
        $nivel .='        
        </table>';
        
        return $nivel;
    }

    function drawPosicionQuery($pasilloID, $moduloID, $nivelID)
    {
        $sql = "SELECT p.*, ifnull(cvearticulo, 'VACIO') as cvearticulo, ifnull(minimo, 0) as minimo, ifnull(maximo, 0) as maximo
FROM posicion p
join pasillo o using(pasilloID)
left join rack_buffer b using(id, pasilloTipo)
left join articulos a using(id)
where pasilloID = ? and moduloID = ? and nivelID = ?
order by posicionID";
        $query = $this->db->query($sql, array($pasilloID, $moduloID, $nivelID));
        return $query;
    }
    
    function lastPosicion($pasilloID, $moduloID, $nivelID)
    {
        $sql = "SELECT max(posicionID) as posicionID FROM posicion p where pasilloID = ? and moduloID = ? and nivelID = ?;";
        $query = $this->db->query($sql, array($pasilloID, $moduloID, $nivelID));
        $row = $query->row();
        return $row->posicionID;
    }

    function drawPosicion($pasilloID, $moduloID, $nivelID)
    {
        $posicion = '<table class="table table-striped table-bordered">
            <tr>';
        
        $query = $this->drawPosicionQuery($pasilloID, $moduloID, $nivelID);
        $lastPosicion = $this->lastPosicion($pasilloID, $moduloID, $nivelID);
        
        foreach($query->result() as $row)
        {
            if($lastPosicion == $row->posicionID)
            {
                $borraPosicion = anchor('almacen/eliminaPosicion/'.$row->ubicacion, ' <i class="icon-minus"></i> ', array('class' => 'elimina', 'rel' => 'POSICION')).anchor('almacen/agregaPosicion/'.$row->ubicacion, ' <i class="icon-plus"></i> ', array('class' => 'agrega', 'rel' => 'POSICION'));
            }else{
                $borraPosicion = null;
            }
            
            if($row->id == 0)
            {
                $link = '<a href="#" id="id-btn-dialog-'.$row->ubicacion.'" class="btn btn-purple btn-small" rel="'.$row->id.'" minimo="'.$row->minimo.'" maximo="'.$row->maximo.'">Asignar Clave</a>';
            }else{
                $link = '<a href="#" id="id-btn-dialog-'.$row->ubicacion.'" class="btn btn-info btn-small" rel="'.$row->id.'" minimo="'.$row->minimo.'" maximo="'.$row->maximo.'">'.$row->cvearticulo.'</a>';
            }
            
            

            $posicion .= '
            <td>Pos. '.$row->posicionID.' '.$borraPosicion.'<br />'.$link.'</td>
            ';
        }
        
        $posicion .= '
            </tr>
        </table>
        ';
        
        return $posicion;
    }
    
    function drawPosicionInventario($pasilloID, $moduloID, $nivelID)
    {
        $posicion = '<table class="table table-striped table-bordered">
            <tr>';
        
        $query = $this->drawPosicionQuery($pasilloID, $moduloID, $nivelID);
        
        foreach($query->result() as $row)
        {
            
            if($row->cvearticulo == 'VACIO')
            {
                $pos = '<span style="color: green;"> -> LIBRE</span>';
            }else{
                $pos = '<span style="color: red;"> -> '.$row->cvearticulo.'</span>';
            }
            
            $posicion .= '
            <td id="ubicacion_'.$row->ubicacion.'" clave="'.$row->cvearticulo.'">Pos. '.$row->posicionID.' '.$pos.'</td>
            ';
        }
        
        $posicion .= '
            </tr>
        </table>
        ';
        
        return $posicion;
    }

    function eliminaUbicacion($ubicacion)
    {
        $this->db->delete('posicion', array('ubicacion' => $ubicacion));
    }
    
    function getPosicionByUbicacion($ubicacion)
    {
        $this->db->where('ubicacion', $ubicacion);
        $query = $this->db->get('posicion');
        return $query;
    }
    
    function agregaUbicacion($ubicacion)
    {
        $query = $this->getPosicionByUbicacion($ubicacion);
        $row = $query->row();
        $data = array('posicionID' => ($row->posicionID + 1), 'nivelID' => $row->nivelID, 'moduloID' => $row->moduloID, 'pasilloID' => $row->pasilloID, 'id' => 0);
        $this->db->insert('posicion', $data);
    }
    
    function eliminaNivel($pasilloID, $moduloID, $nivelID)
    {
        $this->db->trans_start();
        $sql_delete_posicion = "DELETE FROM posicion where pasilloID = ? and moduloID = ? and nivelID = ?;";
        $this->db->query($sql_delete_posicion, array($pasilloID, $moduloID, $nivelID));
        
        $sql_delete_nivel = "DELETE FROM nivel where pasilloID = ? and moduloID = ? and nivelID = ?;";
        $this->db->query($sql_delete_nivel, array($pasilloID, $moduloID, $nivelID));
        $this->db->trans_complete();
    }
    
    function agregaNivel($pasilloID, $moduloID, $nivelID, $posiciones)
    {
        $this->db->trans_start();
        $data = array('nivelID' => ($nivelID + 1), 'moduloID' => $moduloID, 'pasilloID' => $pasilloID);
        $this->db->insert('nivel', $data);
        
        for($i = 1; $i <= $posiciones; $i++)
        {
            $data2 = array('posicionID' => $i, 'nivelID' => ($nivelID + 1), 'moduloID' => $moduloID, 'pasilloID' => $pasilloID, 'id' => 0);
            $this->db->insert('posicion', $data2);
        }
        
        $this->db->trans_complete();
    }
    
    function eliminaModulo($pasilloID, $moduloID)
    {
        $this->db->trans_start();
        
        $sql_posicion = "DELETE FROM posicion where pasilloID = ? and moduloID = ?;";
        $this->db->query($sql_posicion, array($pasilloID, $moduloID));
        
        $sql_nivel = "DELETE FROM nivel where pasilloID = ? and moduloID = ?;";
        $this->db->query($sql_nivel, array($pasilloID, $moduloID));
        
        $sql_modulo = "DELETE FROM modulo where pasilloID = ? and moduloID = ?;";
        $this->db->query($sql_modulo, array($pasilloID, $moduloID));
        
        $this->db->trans_complete();
    }
    
    function checkUbicacion($id)
    {
        $sql = "SELECT * FROM posicion p
join pasillo a using(pasilloID)
where pasilloTipo = 1 and id = ?;";

        $query = $this->db->query($sql, $id);
        return $query->num_rows();
    }
    
    function getPasilloTipoByUbicacion($ubicacion)
    {
        $sql = "SELECT pasilloTipo FROM posicion p join pasillo o using(pasilloID) where ubicacion = ?;";
        $query = $this->db->query($sql, $ubicacion);
        $row = $query->row();
        return $row->pasilloTipo;
    }
    
    function asignaUbicacion($ubicacion, $id, $minimo, $maximo)
    {
        $pasilloTipo = $this->getPasilloTipoByUbicacion($ubicacion);
        
        if($id == 0)
        {
            $this->db->update('posicion', array('id' => $id), array('ubicacion' => $ubicacion));
            echo $this->db->affected_rows();
        }else{
            
            $data3 = array('minimo' => $minimo, 'maximo' => $maximo);
            $this->db->update('rack_buffer', $data3, array('id' => $id, 'pasilloTipo' => $pasilloTipo));
            
            if($this->checkUbicacion($id) == 0)
            {
                $this->db->update('posicion', array('id' => $id), array('ubicacion' => $ubicacion));
                echo $this->db->affected_rows();
            }
            else{
                echo 0;
            }        
        
        }

        
    }
    
    function getPasillos()
    {
        $sql= "SELECT * FROM pasillo p
join area a using(areaID);";

        $query = $this->db->query($sql);
        
        return $query;
    }
    
}
    