<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Almacen extends CI_Controller
{
    
    public function __construct()
    {
        parent::__construct();

        if (!Current_User::user()) {
            redirect('welcome');
        }

        $this->load->model('almacen_model');
        $this->load->model('Inventario_model');
        $this->load->helper('utilities');

    }

    function area()
    {
        $data['subtitulo'] = "Define las areas de tu almacen";
        $data['query'] = $this->almacen_model->getAreas();
        $this->load->view('main', $data);
    }

    function area_nueva()
    {
        $data['subtitulo'] = "Define las areas de tu almacen";
        $data['js'] = "almacen/area_nueva_js";
        $this->load->view('main', $data);
    }
    
    function area_nueva_submit()
    {
        $area = strtoupper($this->input->post('area'));
        $this->almacen_model->insertArea($area);
        redirect('almacen/area');
    }
    
    function area_edita($areaID)
    {
        $data['subtitulo'] = "Cambia el nombre de un area de tu almacen";
        $data['query'] = $this->almacen_model->getArea($areaID);
        $data['js'] = "almacen/area_nueva_js";
        $this->load->view('main', $data);
    }

    function area_edita_submit()
    {
        $areaID = $this->input->post('areaID');
        $area = strtoupper($this->input->post('area'));
        $this->almacen_model->updateArea($areaID, $area);
        redirect('almacen/area');
    }
    
    function area_ver_pasillos($areaID)
    {
        $data['query2'] = $this->almacen_model->getArea($areaID);
        $data['query'] = $this->almacen_model->getPasillosByAreaID($areaID);
        $data['areaID'] = $areaID;
        $data['js'] = "almacen/area_nueva_js";
        $this->load->view('main', $data);
    }
    
    function pasillo_nuevo($areaID)
    {
        $data['subtitulo'] = "Define los pasillos de tus areas";
        $data['racks'] = $this->util->getRack();
        $data['tipos'] = $this->util->getTipoPasillo();
        $data['sentidos'] = $this->util->getSentidoPasillo();
        $data['areaID'] = $areaID;
        $data['js'] = "almacen/pasillo_nuevo_js";
        $this->load->view('main', $data);
    }
    
    function changeRackID()
    {
        $rackID = $this->input->post('rackID');
        $query = $this->almacen_model->getRackByRackID($rackID);
        if($query->num_rows() == 0)
        {
            $imagen = null;
        }else{
            $row = $query->row();
            $imagen = $row->rackImagen;
        }
        $this->load->helper('html');
        echo img('./uploads/'.$imagen);
    }
    
    function pasillo_nuevo_submit()
    {
        $areaID = $this->input->post('areaID');
        $pasillo = strtoupper($this->input->post('pasillo'));
        $rackID = $this->input->post('rackID');
        $pasilloTipo  = $this->input->post('pasilloTipo');
        $sentido = $this->input->post('sentido');
        
        $data = array('pasillo' => $pasillo, 'rackID' => $rackID, 'areaID' => $areaID, 'pasilloTipo' => $pasilloTipo, 'sentido' => $sentido);
        
        $this->almacen_model->insertPasillo($data);
        
        redirect('almacen/area_ver_pasillos/'.$areaID);
    }
    
    function pasillo_edita($areaID, $pasilloID)
    {
        $data['subtitulo'] = "Edita el pasillo";
        $data['racks'] = $this->util->getRack();
        $data['tipos'] = $this->util->getTipoPasillo();
        $data['sentidos'] = $this->util->getSentidoPasillo();
        $data['query'] = $this->almacen_model->getPasilloByPasilloID($pasilloID);
        $data['areaID'] = $areaID;
        $data['js'] = "almacen/pasillo_nuevo_js";
        $this->load->view('main', $data);
    }
    
    function pasillo_edita_submit()
    {
        $areaID = $this->input->post('areaID');
        $pasilloID = $this->input->post('pasilloID');
        $pasillo = strtoupper($this->input->post('pasillo'));
        $rackID = $this->input->post('rackID');
        $pasilloTipo  = $this->input->post('pasilloTipo');
        $sentido = $this->input->post('sentido');
        
        $data = array('pasillo' => $pasillo, 'rackID' => $rackID, 'areaID' => $areaID, 'pasilloTipo' => $pasilloTipo, 'sentido' => $sentido);
        
        $this->almacen_model->updatePasillo($data, $pasilloID);
        
        redirect('almacen/area_ver_pasillos/'.$areaID);
        
    }

    function area_modulo($areaID, $pasilloID)
    {
        $data['query2'] = $this->almacen_model->getPasilloByPasilloID($pasilloID);
        $data['query'] = $this->almacen_model->getModulosByPasilloID($pasilloID);
        $data['articulos'] = $this->util->getArticuloComboFaltaUbicacion();
        $data['modulo'] = $this->almacen_model->drawModulo($pasilloID);
        $data['areaID'] = $areaID;
        $data['js'] = "almacen/area_modulo_js";
        $data['pasilloID'] = $pasilloID;
        $this->load->view('main', $data);
    }
    
    function modulo_nuevo($areaID, $pasilloID)
    {
        $data['areaID'] = $areaID;
        $data['pasilloID'] = $pasilloID;
        $data['js'] = "almacen/modulo_nuevo_js";
        $this->load->view('main', $data);
        
    }
    
    function getModuloSiguiente($pasilloID)
    {
        $sql = "SELECT max(moduloID) as moduloID FROM modulo m where pasilloID = ?;";
        $query = $this->db->query($sql, $pasilloID);
        
        if($query->num_rows() == 0)
        {
            $modulo = 1;
        }else{
            $row = $query->row();
            $modulo = $row->moduloID + 1;
        }
        
        return $modulo;
    }
    
    function modulo_nuevo_submit()
    {
        $areaID = $this->input->post('areaID');
        $pasilloID = $this->input->post('pasilloID');
        $niveles = $this->input->post('niveles');
        $posiciones  = $this->input->post('posiciones');
        $moduloID = $this->getModuloSiguiente($pasilloID);
        
        $this->db->trans_start();
        
        $data = array('pasilloID' => $pasilloID, 'moduloID' => $moduloID);
        $this->db->insert('modulo', $data);
        
        if($niveles > 0)
        {
            for($i = 1; $i <= $niveles; $i++)
            {
                $data2 = array('nivelID' => $i, 'moduloID' => $moduloID, 'pasilloID' => $pasilloID);
                $this->db->insert('nivel', $data2);
                
                if($niveles > 0)
                {
                    for($j = 1; $j <= $posiciones; $j++)
                    {
                        $data3 = array('posicionID' => $j, 'nivelID' => $i, 'moduloID' => $moduloID, 'pasilloID' => $pasilloID);
                        $this->db->insert('posicion', $data3);
                    }
                }
                
            }
            
        }
        
        $this->db->trans_complete();
        redirect('almacen/area_modulo/'.$areaID.'/'.$pasilloID);
        
    }

    function modulo_clona($areaID, $pasilloID, $modulo)
    {
        $moduloID = $this->getModuloSiguiente($pasilloID);
        
        $this->db->trans_start();
        
        $data = array('pasilloID' => $pasilloID, 'moduloID' => $moduloID);
        $this->db->insert('modulo', $data);
        
        $sql_nivel = "SELECT * FROM nivel n where pasilloID = ? and moduloID = ?;";
        
        $query_nivel = $this->db->query($sql_nivel, array($pasilloID, $modulo));
        
        foreach($query_nivel->result() as $row_nivel)
        {
            $data2 = array('nivelID' => $row_nivel->nivelID, 'moduloID' => $moduloID, 'pasilloID' => $pasilloID);
            $this->db->insert('nivel', $data2);
            
            $sql_posicion = "SELECT * FROM posicion p where pasilloID = ? and moduloID = ? and nivelID = ?;";
            $query_posicion = $this->db->query($sql_posicion, array($pasilloID, $modulo, $row_nivel->nivelID));
            
            foreach($query_posicion->result() as $row_posicion)
            {
                $data3 = array('posicionID' => $row_posicion->posicionID, 'nivelID' => $row_nivel->nivelID, 'moduloID' => $moduloID, 'pasilloID' => $pasilloID);
                $this->db->insert('posicion', $data3);
            }
        }
        
        $this->db->trans_complete();
        redirect('almacen/area_modulo/'.$areaID.'/'.$pasilloID);
        
    }
    
    function previewModulo()
    {
        $niveles = $this->input->post('niveles');
        $posiciones = $this->input->post('posiciones');
        
        $data['niveles'] = $niveles;
        $data['posiciones'] = $posiciones;
        
        $this->load->view('almacen/previewModulo', $data);
    }
    
    function eliminaPosicion($ubicacion)
    {
        $this->almacen_model->eliminaUbicacion($ubicacion);
    }
    
    function agregaPosicion($ubicacion)
    {
        $this->almacen_model->agregaUbicacion($ubicacion);
    }
    
    function eliminaNivel($pasilloID, $moduloID, $nivelID)
    {
        $this->almacen_model->eliminaNivel($pasilloID, $moduloID, $nivelID);
    }

    function agregaNivel($pasilloID, $moduloID, $nivelID)
    {
        $posiciones = $this->input->post('posiciones');
        $this->almacen_model->agregaNivel($pasilloID, $moduloID, $nivelID, $posiciones);
    }
    
    function eliminaModulo($pasilloID, $moduloID)
    {
        $this->almacen_model->eliminaModulo($pasilloID, $moduloID);
    }
    
    function asignaIDUbicacion()
    {
        $ubicacion = $this->input->post('ubicacion');
        $id = $this->input->post('id');
        $minimo = $this->input->post('minimo');
        $maximo = $this->input->post('maximo');
        
        $this->almacen_model->asignaUbicacion($ubicacion, $id, $minimo, $maximo);
    }
    
    function area_inventario($areaID)
    {
        $data['subtitulo'] = "Inventario por Area";
        $data['query'] = $this->Inventario_model->getInventarioByArea($areaID);
        $data['areaID'] = $areaID;
        //$data['js'] = "inventario/por_sucursal_js";
        $this->load->view('main', $data);
    }
    
    function area_modulo_inventario($areaID, $pasilloID)
    {
        $data['subtitulo'] = "Inventario por Pasillo";
        $data['query'] = $this->Inventario_model->getInventarioByPasillo($pasilloID);
        $data['areaID'] = $areaID;
        $data['pasilloID'] = $pasilloID;
        //$data['js'] = "inventario/por_sucursal_js";
        $this->load->view('main', $data);
    }

}