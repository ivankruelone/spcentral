<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Inventario extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        if (!Current_User::user()) {
            redirect('welcome');
        }
        
        $this->load->model('Inventario_model');
        $this->load->helper('utilities');
        date_default_timezone_set('America/Mexico_City');

    }
    
    function caducidades()
    {
        $data['subtitulo'] = "Inventario por caducidades";
        $data['caducidades'] = $this->util->getCaducidades();
        $data['js'] = "inventario/caducidades_js";
        $this->load->view('main', $data);
    }
    
    function inventarioByCaducidad()
    {
        $caducidad = $this->input->post('caducidad');
        $data['query'] = $this->Inventario_model->getInventarioByCaducidad($caducidad);
        $data['caducidad'] = $caducidad;
        $this->load->view('inventario/caducidadesDetalle', $data);
    }

    function index()
    {
        $data['subtitulo'] = "";
        $data['query'] = $this->Inventario_model->getInventario();
        //$data['js'] = "inventario/por_sucursal_js";
        $this->load->view('main', $data);
    }

    function datos($inventarioID)
    {
        $data['subtitulo'] = "";
        $data['query'] = $this->Inventario_model->getInventarioByID($inventarioID);
        $data['json'] = json_encode($this->util->getDataOficina('laboratorio', array()));
        $data['js'] = "inventario/datos_js";
        $this->load->view('main', $data);
    }
    
    function datos_submit()
    {
        $lote = $this->input->post('lote');
        $caducidad = $this->input->post('caducidad');
        $marca = $this->input->post('marca');
        $ean = $this->input->post('ean');
        $comercial = $this->input->post('comercial');
        $inventarioID = $this->input->post('inventarioID');
        
        $this->Inventario_model->actualizaDatos($lote, $caducidad, $marca, $ean, $inventarioID, $comercial);
        redirect('inventario/index');
    }

    function cantidad($inventarioID)
    {
        $data['subtitulo'] = "";
        $data['query'] = $this->Inventario_model->getInventarioByID($inventarioID);
        $data['js'] = "inventario/datos_js";
        $this->load->view('main', $data);
    }

    function cantidad_submit()
    {
        $cantidad = $this->input->post('cantidad');
        $inventarioID = $this->input->post('inventarioID');
        
        $this->Inventario_model->actualizaCantidad($cantidad, $inventarioID);
        $this->util->postInventario();
        redirect('inventario/ajuste');
    }
    
    function convierte($inventarioID)
    {
        $data['subtitulo'] = "Convertir a piezas";
        $data['query'] = $this->Inventario_model->getInventarioByID($inventarioID);
        $data['js'] = "inventario/convierte_js";
        $this->load->view('main', $data);
    }
    
    function getIDCvearticuloPieza($cvearticulo)
    {
        $sql = "SELECT id FROM articulos a where cvearticulo = ?;";
        $query = $this->db->query($sql, $cvearticulo.'*p');
        $row = $query->row();
        return $row->id;
    }
    
    function convierte_submit()
    {
        $this->db->trans_start();
        
        $inventarioID = $this->input->post('inventarioID');
        $convertir = $this->input->post('convertir');
        
        $sql = "SELECT inventarioID, cvearticulo, numunidades, marca, costo, ean, cantidad, lote, caducidad FROM inventario i
join articulos using(id)
where inventarioID = ?;";

        $query = $this->db->query($sql, $inventarioID);
        
        $row = $query->row();
        
        $id_nuevo = $this->getIDCvearticuloPieza($row->cvearticulo);
        
        $sql2 = "SELECT * FROM inventario i where id = ? and lote = ?;";
        
        $query2 = $this->db->query($sql2, array($id_nuevo, $row->lote));
        
        
        $cantidad = (int)$row->cantidad - (int)$convertir;
        
        $data = array(
            'tipoMovimiento' => 3,
            'subtipoMovimiento' => 18,
            'receta' => 0,
            'usuario' => $this->session->userdata('usuario'),
            'movimientoID' => 0,
            'cantidad' => $cantidad
            );
        $this->db->set('ultimo_movimiento', 'now()', false);
        $this->db->update('inventario', $data, array('inventarioID' => $inventarioID));
        
        
        if($query2->num_rows() == 0)
        {
                    $data = array(
                        'id' => $id_nuevo,
                        'lote' => $row->lote,
                        'caducidad' => $row->caducidad,
                        'cantidad' => $convertir * $row->numunidades,
                        'tipoMovimiento' => 3,
                        'subtipoMovimiento' => 18,
                        'receta' => 0,
                        'usuario' => $this->session->userdata('usuario'),
                        'movimientoID' => 0,
                        'ean' => $row->ean,
                        'marca' => $row->marca,
                        'costo' => $row->costo / $row->numunidades,
                        'clvsucursal' => $this->session->userdata('clvsucursal')
                        );
                    
                    $this->db->set('ultimo_movimiento', 'now()', false);
                    $this->db->insert('inventario', $data);
        }else{
                    $row2 = $query2->row();
                    
                    $cantidad2 = ($convertir * $row->numunidades) + $row2->cantidad;
                    
                    $data = array(
                        'cantidad' => $cantidad2,
                        'tipoMovimiento' => 3,
                        'subtipoMovimiento' => 18,
                        'receta' => 0,
                        'usuario' => $this->session->userdata('usuario'),
                        'movimientoID' => 0,
                        );
                    
                    $this->db->set('ultimo_movimiento', 'now()', false);
                    $this->db->update('inventario', $data, array('inventarioID' => $row2->inventarioID));
        }
        
        
        $this->util->postInventario();
        
        $this->db->trans_complete();
        redirect('inventario/index');
    }

    function kardex()
    {
        $data['subtitulo'] = "";
        $data['subtipos'] = $this->util->getSubtipoMovimientoCombo();
        $data['lotes'] = $this->util->getLoteComodinCombo();
        $data['js'] = "inventario/kardex_js";
        $this->load->view('main', $data);
    }

    function kardex_submit()
    {
        $cvearticulo = $this->input->post('articulo');
        $lote = $this->input->post('lote');
        $fecha1 = $this->input->post('fecha1');
        $fecha2 = $this->input->post('fecha2');
        $subtipoMovimiento = $this->input->post('subtipoMovimiento');
        
        $data['subtitulo'] = "";
        $data['query'] = $this->Inventario_model->kardex($cvearticulo, $lote, $fecha1, $fecha2, $subtipoMovimiento);
        //$data['js'] = "inventario/kardex_js";
        $this->load->view('main', $data);
    }
    
    function imprimeInventario($tipoprod)
    {
        set_time_limit(0);
        ini_set('memory_limit','-1');
        
        $data['cabeza'] = $this->Inventario_model->getInventarioCabezaTipo($tipoprod);
        $data['query'] = $this->Inventario_model->getInventarioByTipoprod($tipoprod);
        $this->load->view('impresiones/inventario', $data);
    }
    
    function imprimeInventarioByArea($areaID)
    {
        set_time_limit(0);
        ini_set('memory_limit','-1');
        
        $data['cabeza'] = $this->Inventario_model->getInventarioCabezaArea($areaID);
        $data['query'] = $this->Inventario_model->getInventarioByArea($areaID);
        $this->load->view('impresiones/inventario', $data);
    }

    function imprimeInventarioByPasillo($pasilloID)
    {
        set_time_limit(0);
        ini_set('memory_limit','-1');
        
        $data['cabeza'] = $this->Inventario_model->getInventarioCabezaPasillo($pasilloID);
        $data['query'] = $this->Inventario_model->getInventarioByPasillo($pasilloID);
        $this->load->view('impresiones/inventario', $data);
    }

    function imprimeInventarioCaducidades($caducidad)
    {
        set_time_limit(0);
        ini_set('memory_limit','-1');
        
        $caducidades = $this->util->getCaducidades();
        
        $data['cabeza'] = $this->Inventario_model->getInventarioCabezaCaducidad($caducidad, $caducidades);
        $data['query'] = $this->Inventario_model->getInventarioByCaducidad($caducidad);
        $this->load->view('impresiones/inventario', $data);
    }

    function antibioticos()
    {
        $data['subtitulo'] = "Reporte de antibi&oacute;ticos";
        $data['query'] = $this->Inventario_model->getAntibioticoGeneral();
        $this->load->view('main', $data);
    }
    
    function antibioticos_detalle1($id)
    {
        $data['subtitulo'] = "Reporte de antibi&oacute;ticos";
        $data['query'] = $this->Inventario_model->getAntibioticoGeneralByID($id);
        $this->load->view('main', $data);
    }

    function impresionAntibioticos($id, $lote)
    {
        set_time_limit(0);
        ini_set('memory_limit','-1');
        
        $this->load->model('Catalogosweb_model');
        $data['cabeza'] = $this->Inventario_model->getAntibioticosCabeza($id, $lote);
        $data['query'] = $this->Inventario_model->getAntibioticoImpresion($id, $lote);
        $data['query2'] = $this->Catalogosweb_model->getDomicilio();
        $data['lote'] = $lote;
        $this->load->view('impresiones/antibioticos', $data);
    }

    function concentrado()
    {
        $data['subtitulo'] = "Inventario Concentrado por Clave";
        $data['query'] = $this->Inventario_model->inventarioConcentrado();
        //$data['js'] = "inventario/por_sucursal_js";
        $this->load->view('main', $data);
    }
    
    function asigna_ubicacion($inventarioID, $origen)
    {
        $data['subtitulo'] = "Asigna ubicacion";
        $data['query'] = $this->Inventario_model->getUbicacionInventario($inventarioID);
        $data['ubicacionesDisponibles'] = $this->util->getUbicacionesDisponibles($inventarioID);
        $data['origen'] = $origen;
        $data['js'] = "inventario/asigna_ubicacion_js";
        $this->load->model('almacen_model');
        $this->load->view('main', $data);
    }
    
    function asigna_ubicacion_disponibles_submit()
    {
        $inventarioID = $this->input->post('inventarioID');
        $ubicacion = $this->input->post('ubicacion');
        $cantidad = $this->input->post('cantidad');
        $origen = $this->input->post('origen');
        $areaID = $this->input->post('areaID');
        
        $this->Inventario_model->updateUbicacion($inventarioID, $ubicacion, $cantidad);
        redirect('inventario/index');
        
    }

    function asigna_ubicacion_asignadas_submit()
    {
        $inventarioID = $this->input->post('inventarioID');
        $ubicacion = $this->input->post('ubicacion2');
        
        $this->Inventario_model->updateUbicacion($inventarioID, $ubicacion);
        redirect('inventario/index');
    }
    
    function dibujaEsquema()
    {
        $ubicacion = $this->input->post('ubicacion');
        $this->load->model('almacen_model');
        
        $query = $this->almacen_model->getPasillos();
        
        foreach($query->result() as $row)
        {
            echo $this->almacen_model->drawModuloInventario($row->pasilloID);
        }
        
        
        
    }
    
    function reciba()
    {
        $data['subtitulo'] = "";
        $data['query'] = $this->Inventario_model->getInventarioReciba();
        //$data['js'] = "inventario/por_sucursal_js";
        $this->load->view('main', $data);
       
    }
    
    function ajuste()
    {
        $data['subtitulo'] = "Busca el producto para hacer el ajuste";
        //$data['js'] = "catalogosweb/productos_por_secuencia_js";
        $this->load->view('main', $data);
    }
    
    function ajuste_submit()
    {
        $clave = $this->input->post('clave');
        $susa = $this->input->post('susa');
        
        $data['query'] = $this->Inventario_model->getInventarioBusqueda($clave, $susa);
        
        $this->load->view('main', $data);
    }

}