<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ventas extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        if (!Current_User::user()) {
            redirect('welcome');
        }
        
        $this->load->model('Ventas_model');
        $this->load->helper('utilities');

    }
    
    public function ventas_por_sucursal()
    {
        $data['subtitulo'] = "";
        $data['js'] = "ventas/ventas_por_sucursal_js";
        $this->load->view('main', $data);
    }
    
    public function ventas_por_sucursal__reporte_de_ventas_por_sucursal()
    {
        $fecha1 = $this->input->post('fecha1');
        $fecha2 = $this->input->post('fecha2');
        
        $data['query'] = $this->Ventas_model->reporte_de_ventas_por_sucursal($fecha1, $fecha2);
        $data['devolucion'] = $this->Ventas_model->devoluciones($fecha1, $fecha2);
        $data['fecha1'] = $fecha1;
        $data['fecha2'] = $fecha2;
        $data['subtitulo'] = "Periodo " .$fecha1 . " al " . $fecha2;
        $data['js'] = "ventas/ventas_por_sucursal__reporte_de_ventas_por_sucursal_js";
        $this->load->view('main', $data);
    }
    
    public function ventas_por_sucursal__venta_por_sucursal($sucursal, $fecha1, $fecha2)
    {
        $data['query'] = $this->Ventas_model->reporte_de_ventas_por_periodo_sucursal($sucursal, $fecha1, $fecha2);
        $data['subtitulo'] = "Periodo " .$fecha1 . " al " . $fecha2;
        $data['js'] = "ventas/ventas_por_sucursal__venta_por_sucursal_js";
        $this->load->view('main', $data);
    }

    function detalle_por_sucursal_ean($sucursal, $fecha1, $fecha2){
        $data['sucursalNombre'] = $this->Ventas_model->getSucursalNombre($sucursal);
        $data['query'] = $this->Ventas_model->sucursal_por_ean($sucursal, $fecha1, $fecha2);
        $this->load->view('ventas/detalle_por_sucursal_ean', $data);
    }

    function detalle_por_sucursal_sec($sucursal, $fecha1, $fecha2){
        $data['sucursalNombre'] = $this->Ventas_model->getSucursalNombre($sucursal);
        $data['query'] = $this->Ventas_model->sucursal_por_sec($sucursal, $fecha1, $fecha2);
        $this->load->view('ventas/detalle_por_sucursal_sec', $data);
    }

    function detalle_por_sucursal_comisionables($sucursal, $fecha1, $fecha2){
        $data['sucursalNombre'] = $this->Ventas_model->getSucursalNombre($sucursal);
        $data['query'] = $this->Ventas_model->sucursal_por_comisionables($sucursal, $fecha1, $fecha2);
        $this->load->view('ventas/detalle_por_sucursal_comisionables', $data);
    }

    function detalle_por_sucursal_por_dia($sucursal, $fecha1, $fecha2){
        $data['sucursalNombre'] = $this->Ventas_model->getSucursalNombre($sucursal);
        $data['query'] = $this->Ventas_model->sucursal_por_dia($sucursal, $fecha1, $fecha2);
        $this->load->view('ventas/detalle_por_sucursal_por_dia', $data);
    }

    public function ventas_por_periodo()
    {
        $data['subtitulo'] = "";
        $data['js'] = "ventas/ventas_por_periodo_js";
        $this->load->view('main', $data);
    }
    
    public function ventas_por_periodo__reporte_de_ventas_por_periodo()
    {
        $fecha1 = $this->input->post('fecha1');
        $fecha2 = $this->input->post('fecha2');
        
        $data['query'] = $this->Ventas_model->reporte_de_ventas_por_periodo($fecha1, $fecha2);
        $data['subtitulo'] = "Periodo " .$fecha1 . " al " . $fecha2;
        $data['js'] = "ventas/ventas_por_periodo__reporte_de_ventas_por_periodo_js";
        $this->load->view('main', $data);
    }
    
    public function ventas_por_periodo__detalle_del_ticket($id)
    {
        $data['subtitulo'] = "";
        $data['query'] = $this->Ventas_model->detalle_productos($id);
        $data['js'] = "ventas/detalle_producto_js";
        $this->load->view('main', $data);
    }
    
    public function negados_por_secuencia()
    {
        $data['subtitulo'] = "";
        $data['js'] = "ventas/negados_por_secuencia_js";
        $this->load->view('main', $data);
    }
    
    
    public function negados_por_secuencia__reporte_de_negados_por_secuencia()
    {
        $fecha1 = $this->input->post('fecha1');
        $fecha2 = $this->input->post('fecha2');
        
        $data['query'] = $this->Ventas_model->reporte_de_negados_por_secuencia($fecha1, $fecha2);
        $data['subtitulo'] = "Periodo " .$fecha1 . " al " . $fecha2;
        $data['js'] = "ventas/negados_por_secuencia__reporte_de_negados_por_secuencia_js";
        $this->load->view('main', $data);
    }
    
    public function negados_por_cbarras()
    {
        $data['subtitulo'] = "";
        $data['js'] = "ventas/negados_por_cbarras_js";
        $this->load->view('main', $data);
    }
    
    public function negados_por_cbarras__reporte_de_negados_por_cbarras()
    {
        $fecha1 = $this->input->post('fecha1');
        $fecha2 = $this->input->post('fecha2');
        
        $data['query'] = $this->Ventas_model->reporte_de_negados_por_cbarras($fecha1, $fecha2);
        $data['subtitulo'] = "Periodo " .$fecha1 . " al " . $fecha2;
        $data['js'] = "ventas/negados_por_cbarras__reporte_de_negados_por_cbarras_js";
        $this->load->view('main', $data);
    }
}