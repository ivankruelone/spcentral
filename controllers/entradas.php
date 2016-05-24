<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Entradas extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        if (!Current_User::user()) {
            redirect('welcome');
        }
        
        $this->load->model('Entradas_model');
        $this->load->helper('utilities');

    }
    
    public function entradas_por_sucursal()
    {
        $data['subtitulo'] = "";
        $data['js'] = "entradas/entradas_por_sucursal_js";
        $this->load->view('main', $data);
    }

    public function entradas_por_sucursal__reporte_de_entradas_por_sucursal()
    {
        $fecha1 = $this->input->post('fecha1');
        $fecha2 = $this->input->post('fecha2');
        
        $data['query'] = $this->Entradas_model->reporte_de_entradas_por_sucursal($fecha1, $fecha2);
        $data['fecha1'] = $fecha1;
        $data['fecha2'] = $fecha2;
        $data['subtitulo'] = "Periodo " .$fecha1 . " al " . $fecha2;
        $data['js'] = "entradas/entradas_por_sucursal__reporte_de_entradas_por_sucursal_js";
        $this->load->view('main', $data);
    }
    
    public function entradas_por_sucursal__detalle_por_sucursal_y_proveedor($sucursal, $fecha1, $fecha2)
    {
        
        $data['query'] = $this->Entradas_model->detalle_por_sucursal_y_proveedor($sucursal, $fecha1, $fecha2);
        $data['fecha1'] = $fecha1;
        $data['fecha2'] = $fecha2;
        $data['sucursal'] = $sucursal;
        $data['sucursalNombre'] = $this->Entradas_model->getSucursalNombre($sucursal);
        $data['subtitulo'] = "Periodo " .$fecha1 . " al " . $fecha2;
        $data['js'] = "entradas/entradas_por_sucursal__reporte_de_entradas_por_sucursal_js";
        $this->load->view('main', $data);
    }

    public function entradas_por_sucursal__detalle_por_sucursal_y_proveedor_y_factura($sucursal, $proveedor, $fecha1, $fecha2)
    {
        
        $data['query'] = $this->Entradas_model->detalle_por_sucursal_y_proveedor_y_factura($sucursal, $proveedor, $fecha1, $fecha2);
        $data['fecha1'] = $fecha1;
        $data['fecha2'] = $fecha2;
        $data['sucursal'] = $sucursal;
        $data['proveedor'] = $proveedor;
        $data['sucursalNombre'] = $this->Entradas_model->getSucursalNombre($sucursal);
        $data['subtitulo'] = "Periodo " .$fecha1 . " al " . $fecha2;
        $data['js'] = "entradas/entradas_por_sucursal__reporte_de_entradas_por_sucursal_js";
        $this->load->view('main', $data);
    }

    public function entradas_por_sucursal__detalle_por_sucursal_y_proveedor_y_factura_y_productos($sucursal, $proveedor, $entrada, $fecha1, $fecha2)
    {
        
        $data['query'] = $this->Entradas_model->detalle_por_sucursal_y_proveedor_y_factura_y_producto($sucursal, $entrada);
        $data['fecha1'] = $fecha1;
        $data['fecha2'] = $fecha2;
        $data['sucursal'] = $sucursal;
        $data['proveedor'] = $proveedor;
        $data['sucursalNombre'] = $this->Entradas_model->getSucursalNombre($sucursal);
        $data['subtitulo'] = "Periodo " .$fecha1 . " al " . $fecha2;
        $data['js'] = "entradas/entradas_por_sucursal__detalle_por_sucursal_y_proveedor_y_factura_y_productos_js";
        $this->load->view('main', $data);
    }

    public function traspasos_por_sucursal()
    {
        $data['subtitulo'] = "";
        //$data['js'] = "entradas/entradas_por_sucursal_js";
        $this->load->view('main', $data);
    }

    public function traspasos_por_sucursal__reporte_de_traspasos_por_sucursal()
    {
        $fecha1 = $this->input->post('fecha1');
        $fecha2 = $this->input->post('fecha2');
        
        $data['query'] = $this->Entradas_model->reporte_de_entradas_por_sucursal($fecha1, $fecha2);
        $data['fecha1'] = $fecha1;
        $data['fecha2'] = $fecha2;
        $data['subtitulo'] = "Periodo " .$fecha1 . " al " . $fecha2;
        $data['js'] = "entradas/entradas_por_sucursal__reporte_de_entradas_por_sucursal_js";
        $this->load->view('main', $data);
    }
}
