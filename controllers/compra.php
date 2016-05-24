<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Compra extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        if (!Current_User::user()) {
            redirect('welcome');
        }

        $this->load->model('compra_model');
        $this->load->helper('utilities');

    }
    
    function ordenes()
    {
        $data['subtitulo'] = "Ordenes de los ultimos 6 meses";
        $data['query'] = $this->util->getDataOficina('getLastOrdenes', array());
        //$data['js'] = "movimiento/nuevo_js";
        $this->load->view('main', $data);
    }

    function detalle_orden($id_orden)
    {
        $data['subtitulo'] = "Detalle de la orden";
        $data['query'] = $this->util->getDataOficina('getDetalleOrdenByIDOrden', array('id_orden' => $id_orden));
        //$data['js'] = "movimiento/nuevo_js";
        $this->load->view('main', $data);
    }

}