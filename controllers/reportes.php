<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reportes extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        if (!Current_User::user()) {
            redirect('welcome');
        }
        
        $this->load->model('reportes_model');
        $this->load->helper('utilities');
        date_default_timezone_set('America/Mexico_City');

    }
    
    public function recetas_periodo()
    {
        $data['subtitulo'] = "";
        $data['js'] = "reportes/recetas_periodo_js";
        $data['programa'] = $this->reportes_model->getProgramasCombo();
        $data['requerimiento'] = $this->reportes_model->getRequerimientoCombo();
        $this->load->view('main', $data);
    }
    
    public function recetas_periodo_detalle()
    {
        set_time_limit(0);
        ini_set('memory_limit','-1');
        
        $fecha1 = $this->input->post('fecha1');
        $fecha2 = $this->input->post('fecha2');
        $idprograma = $this->input->post('idprograma');
        $tiporequerimiento = $this->input->post('tiporequerimiento');
        
        $data['query'] = $this->reportes_model->recetas_periodo_detalle($fecha1, $fecha2, $idprograma, $tiporequerimiento);
        $data['fecha1'] = $fecha1;
        $data['fecha2'] = $fecha2;
        $data['subtitulo'] = "Periodo " .$fecha1 . " al " . $fecha2;
        //$data['js'] = "reportes/recetas_periodo_detalle_js";
        $this->load->view('main', $data);
    }
    
    function imprimeReporte()
    {
        set_time_limit(0);
        ini_set('memory_limit','-1');
        
        $fecha1 = $this->input->post('fecha1');
        $fecha2 = $this->input->post('fecha2');
        $idprograma = $this->input->post('idprograma');
        $tiporequerimiento = $this->input->post('tiporequerimiento');

        $programas = $this->reportes_model->getProgramasCombo();
        $requerimientos = $this->reportes_model->getRequerimientoCombo();

        $data['cabeza'] = $this->reportes_model->getReporteRecetasCabeza($fecha1, $fecha2, $idprograma, $tiporequerimiento, $programas, $requerimientos);
        $data['fecha1'] = $fecha1;
        $data['fecha2'] = $fecha2;
        $data['query'] = $this->reportes_model->recetas_periodo_detalle($fecha1, $fecha2, $idprograma, $tiporequerimiento);
        $this->load->view('impresiones/reporteRecetas', $data);
    }
    
    public function reporte_productos()
    {
        $data['subtitulo'] = "";
        $data['js'] = "reportes/recetas_periodo_js";
        $data['programa'] = $this->reportes_model->getProgramasCombo();
        $data['requerimiento'] = $this->reportes_model->getRequerimientoCombo();
        $this->load->view('main', $data);
    }    
    
    public function productos_periodo_detalle()
    {
        $fecha1 = $this->input->post('fecha1');
        $fecha2 = $this->input->post('fecha2');
        $idprograma = $this->input->post('idprograma');
        $tiporequerimiento = $this->input->post('tiporequerimiento');
        
        $data['query'] = $this->reportes_model->recetas_periodo_detalle($fecha1, $fecha2, $idprograma, $tiporequerimiento);
        $data['fecha1'] = $fecha1;
        $data['fecha2'] = $fecha2;
        $data['subtitulo'] = "Periodo " .$fecha1 . " al " . $fecha2;
        //$data['js'] = "reportes/recetas_periodo_detalle_js";
        $this->load->view('main', $data);
    }

    
    public function recetas_periodo_anterior()
    {
        $data['subtitulo'] = "";
        $data['js'] = "reportes/recetas_periodo_js";
        $data['sucursal'] = $this->reportes_model->getSucursalesCombo();
        $this->load->view('main', $data);
    }
    
    public function recetas_periodo_anterior_submit()
    {
        $fecha1 = $this->input->post('fecha1');
        $fecha2 = $this->input->post('fecha2');
        $clvsucursal = $this->input->post('clvsucursal');
        
        $data['query'] = $this->reportes_model->recetas_periodo_detalle_anterior($fecha1, $fecha2, $clvsucursal);
        $data['fecha1'] = $fecha1;
        $data['fecha2'] = $fecha2;
        $data['subtitulo'] = "Periodo " .$fecha1 . " al " . $fecha2;
        //$data['js'] = "reportes/recetas_periodo_detalle_js";
        $this->load->view('main', $data);
    }

    public function consumo()
    {
        $data['subtitulo'] = "Reporte de Consumos";
        $data['js'] = "reportes/recetas_periodo_js";
        $this->load->view('main', $data);
    }
    
    function consumo_submit()
    {
        $fecha1 = $this->input->post('fecha1');
        $fecha2 = $this->input->post('fecha2');
        
        $data['query'] = $this->reportes_model->getConsumo($fecha1, $fecha2);
        $data['fecha1'] = $fecha1;
        $data['fecha2'] = $fecha2;
        
        $data['subtitulo'] = "Reporte de Consumos";
        $this->load->view('main', $data);
    }

    public function negado()
    {
        $data['subtitulo'] = "Reporte de Negados";
        $data['js'] = "reportes/recetas_periodo_js";
        $this->load->view('main', $data);
    }

    function negado_submit()
    {
        $fecha1 = $this->input->post('fecha1');
        $fecha2 = $this->input->post('fecha2');
        
        $data['query'] = $this->reportes_model->getNegado($fecha1, $fecha2);
        $data['fecha1'] = $fecha1;
        $data['fecha2'] = $fecha2;
        
        $data['subtitulo'] = "Reporte de Negados";
        $this->load->view('main', $data);
    }

    function imprimeConsumo($fecha1, $fecha2)
    {
        set_time_limit(0);
        ini_set('memory_limit','-1');
        
        $data['cabeza'] = $this->reportes_model->getReporteConsumoCabeza($fecha1, $fecha2);
        $data['fecha1'] = $fecha1;
        $data['fecha2'] = $fecha2;
        $data['query'] = $this->reportes_model->getConsumo($fecha1, $fecha2);
        $this->load->view('impresiones/reporteConsumo', $data);
    }

    function imprimeNegado($fecha1, $fecha2)
    {
        set_time_limit(0);
        ini_set('memory_limit','-1');
        
        $data['cabeza'] = $this->reportes_model->getReporteNegadoCabeza($fecha1, $fecha2);
        $data['fecha1'] = $fecha1;
        $data['fecha2'] = $fecha2;
        $data['query'] = $this->reportes_model->getNegado($fecha1, $fecha2);
        $this->load->view('impresiones/reporteNegado', $data);
    }
    
    function inventario_por_area()
    {
        $this->reportes_model->getExcel(0, null, null);
        
        $filename = $this->uri->segment(2).'_'.date('Ymd_his').'.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
                     
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }
    
    function esi()
    {
        $data['subtitulo'] = "";
        $data['js'] = "reportes/esi_js";
        $this->load->view('main', $data);
    }

    function esi_submit()
    {
        $fecha1 = $this->input->post('fecha1');
        $fecha2 = $this->input->post('fecha2');
        
        $this->reportes_model->getExcel(1, $fecha1, $fecha2);
        
        $filename = $this->uri->segment(2).'_'.date('Ymd_his').'.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
                     
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }
    
    function esi_por_clave()
    {
        $data['subtitulo'] = "";
        $data['js'] = "reportes/esi_por_clave_js";
        $this->load->view('main', $data);
    }
    
    function esi_por_clave_submit()
    {
        $fecha1 = $this->input->post('fecha1');
        $fecha2 = $this->input->post('fecha2');
        $articulo = $this->input->post('articulo');
        
        $this->reportes_model->getExcel(1, $fecha1, $fecha2, $articulo);
        
        $filename = $this->uri->segment(2).'_'.date('Ymd_his').'.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
                     
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }

    function entradas()
    {
        $data['subtitulo'] = "";
        $data['js'] = "reportes/entradas_js";
        $this->load->view('main', $data);
    }

    function entradas_submit()
    {
        $fecha1 = $this->input->post('fecha1');
        $fecha2 = $this->input->post('fecha2');
        $proveedorID = $this->input->post('proveedorID');
        
        $this->reportes_model->getMovimiento(1, $fecha1, $fecha2, $proveedorID);
        
        $filename = $this->uri->segment(2).'_'.date('Ymd_his').'.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
                     
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }

    function salidas()
    {
        $data['subtitulo'] = "";
        $data['js'] = "reportes/salidas_js";
        $this->load->view('main', $data);
    }

    function salidas_submit()
    {
        $fecha1 = $this->input->post('fecha1');
        $fecha2 = $this->input->post('fecha2');
        $clvsucursal = $this->input->post('clvsucursal');
        
        $this->reportes_model->getMovimiento(2, $fecha1, $fecha2, null, $clvsucursal);
        
        $filename = $this->uri->segment(2).'_'.date('Ymd_his').'.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
                     
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }

    function esiFile()
    {
        $this->reportes_model->getExcel(1, '2015-06-29', '2015-07-02');
        
        $ruta = './downloads/';
        $filename = $this->uri->segment(2).'.xlsx';
        $objWriter = new PHPExcel_Writer_Excel2007($this->excel);
        $objWriter->save($ruta.$filename);
    }

    function esiByMail()
    {
        $dia = $this->reportes_model->getFechaDiaAnterior();
        
        $this->reportes_model->getExcel(1, $dia, $dia);
        
        $ruta = './downloads/';
        $filename = $this->uri->segment(2).'_'.date('Ymd').'.xlsx';
        $objWriter = new PHPExcel_Writer_Excel2007($this->excel);
        $objWriter->save($ruta.$filename);
        
        $cc = 'ivan.zuniga@farfenix.com.mx';
        $correo = $this->reportes_model->getCorreos($this->uri->segment(2));
        $subject = 'ENTRADAS, SALIDAS E INVENTARIO';
        
        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'smtp.farfenix.com.mx',
            'smtp_user' => $cc,
            'smtp_pass' => '73dek',
            'mailtype'  => 'text', 
            'charset'   => 'iso-8859-1'
        );
        
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        
        $this->email->from($cc, APLICACION);
        $this->email->to($correo);
        $this->email->cc($cc);
        $this->email->attach($ruta.$filename);
        $this->email->subject($subject);
        $this->email->message('SALUDOS.');

        $this->email->send();

        unlink($ruta.$filename);
    }

    function esiMensualByMail()
    {
        $dia = $this->reportes_model->getFechaMesAnterior();
        
        $this->reportes_model->getExcel(1, $dia->primer_dia, $dia->ultimo_dia);
        
        $ruta = './downloads/';
        $filename = $this->uri->segment(2).'_'.date('Ymd').'.xlsx';
        $objWriter = new PHPExcel_Writer_Excel2007($this->excel);
        $objWriter->save($ruta.$filename);
        
        $cc = 'ivan.zuniga@farfenix.com.mx';
        $correo = $this->reportes_model->getCorreos($this->uri->segment(2));
        $subject = 'ENTRADAS, SALIDAS E INVENTARIO';
        
        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'smtp.farfenix.com.mx',
            'smtp_user' => $cc,
            'smtp_pass' => '73dek',
            'mailtype'  => 'text', 
            'charset'   => 'iso-8859-1'
        );
        
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        
        $this->email->from($cc, APLICACION);
        $this->email->to($correo);
        $this->email->cc($cc);
        $this->email->attach($ruta.$filename);
        $this->email->subject($subject);
        $this->email->message('SALUDOS.');

        $this->email->send();

        unlink($ruta.$filename);
        
        $this->reportes_model->inventarioMensual();
    }

    function cxp()
    {
        $data['subtitulo'] = "Facturas para cuentas por pagar";
        $data['js'] = "reportes/esi_js";
        $this->load->view('main', $data);
    }
    
    function cxp_submit()
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        
        $fecha1  = $this->input->post('fecha1');
        $fecha2  = $this->input->post('fecha2');
        $orden = $this->input->post('orden');
        
        $data['fecha1'] = $fecha1;
        $data['fecha2'] = $fecha2;
        $data['orden'] = $orden;
        
        $data['header'] = $this->reportes_model->header($fecha1, $fecha2, $orden);
        $data['detalle'] = null;
        
        $this->load->view('impresiones/cxp', $data);
    }
    
    function reportes_e_s()
    {
     $data['titulo'] = "";
     $data['js'] = "reportes/rep_es_js";
     $data['areas'] = $this->reportes_model->getAreas();
     $this->load->view('main', $data);  
    }
    
    function reporteser_submit()
    {
     set_time_limit(0);
     ini_set('memory_limit', '-1');
     $fecha1  = $this->input->post('fecha1');
     $fecha2  = $this->input->post('fecha2');
     $area = $this->input->post('areas');
     $data['fecha1'] = $fecha1;
     $data['fecha2'] = $fecha2;
     $data['area'] = $area;
     $data['query'] = $this->reportes_model->repes_detalle($fecha1, $fecha2, $area);
     $data['subtitulo'] = "Periodo de: " .$fecha1 . " al " . $fecha2;
     $this->load->view('main', $data);
    }
    
    
    function imprimeReporteEs($fecha1,$fecha2,$area){        
        $this->reportes_model->getEs($fecha1, $fecha2,$area);
        
        $filename = $this->uri->segment(2).'_'.date('Ymd_his').'.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
                     
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');  
    }
    
    function cxp_rep(){
      $data['subtitulo'] = "";
      $data['js'] = "reportes/entradas_js";
      $this->load->view('main', $data);
    }
    
    function cxp_rep_submit(){
       $fecha1 = $this->input->post('fecha1');
       $fecha2 = $this->input->post('fecha2');
       $proveedorID = $this->input->post('proveedorID');
        
       $this->reportes_model->getMovimiento2(1, $fecha1, $fecha2, $proveedorID);
        
       $filename = $this->uri->segment(2).'_'.date('Ymd_his').'.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); 
       $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
       $objWriter->save('php://output');
    }
    
    function concentrado(){
      $data['subtitulo'] = "";
      $data['movimiento'] = $this->reportes_model->getTipoMov();
      $data['js'] = "reportes/esi_js";
      $this->load->view('main', $data);  
    }
    
    function concentrado_submit(){
      $fecha1 = $this->input->post('fecha1');
      $fecha2 = $this->input->post('fecha2');
      $tipoMovimiento = $this->input->post('tipoMovimiento');

        
      $this->reportes_model->getMovimiento3($tipoMovimiento,$fecha1, $fecha2);
      $filename = $this->uri->segment(2).'_'.date('Ymd_his').'.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); 
      $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
      $objWriter->save('php://output');   
    }
    
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    function resumen_entradas()
    {
        $data['subtitulo'] = "";
        $data['js'] = "reportes/resumen_entradas_js";
        $this->load->view('main', $data);
    }

    function resumen_entradas_submit()
    {
     set_time_limit(0);
     ini_set('memory_limit', '-1');
     $fecha1  = $this->input->post('fecha1');
     $fecha2  = $this->input->post('fecha2');
     $data['fecha1'] = $fecha1;
     $data['fecha2'] = $fecha2;
     $data['query'] = $this->reportes_model->reportes_resumen_entradas_detalle($fecha1, $fecha2);
     $data['query2'] = $this->reportes_model->reportes_resumen_entradas($fecha1, $fecha2);
     $data['subtitulo'] = "Resumen De Entradas: " .$fecha1 . " al " . $fecha2;
     $this->load->view('main', $data);
    
}

function entradas_por_clave()
    {
        $data['subtitulo'] = "";
        $data['js'] = "reportes/entradas_por_clave_js";
        //$data['js'] = "reportes/esi_por_clave_js";
        $this->load->view('main', $data);
    }
    
    function entradas_por_clave_submit()
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        $fecha1 = $this->input->post('fecha1');
        $fecha2 = $this->input->post('fecha2');
        $cvearticulo = $this->input->post('cvearticulo');
        //$articulo = $this->input->post('articulo');
        $data['fecha1'] = $fecha1;
        $data['fecha2'] = $fecha2;
        $data['query'] = $this->reportes_model->entradas_por_clave_detalle($fecha1, $fecha2,$cvearticulo);
        $data['query2'] = $this->reportes_model->entradas_por_clave($fecha1, $fecha2,$cvearticulo);
        $data['subtitulo'] = "Resumen De Entradas: " .$fecha1 . " al " . $fecha2;
        $this->load->view('main', $data);
}
////////////////////////////////////////////////////////////////////////
function resumen_salidas()
    {
        $data['subtitulo'] = "";
        $data['js'] = "reportes/resumen_salidas_js";
        $this->load->view('main', $data);
    }

    function resumen_salidas_submit()
    {
     set_time_limit(0);
     ini_set('memory_limit', '-1');
     $fecha1  = $this->input->post('fecha1');
     $fecha2  = $this->input->post('fecha2');
     $data['fecha1'] = $fecha1;
     $data['fecha2'] = $fecha2;
     $data['query'] = $this->reportes_model->reportes_resumen_salidas_detalle($fecha1, $fecha2);
     $data['query2'] = $this->reportes_model->reportes_resumen_salidas($fecha1, $fecha2);
     $data['subtitulo'] = "Resumen De Salidas: " .$fecha1 . " al " . $fecha2;
     $this->load->view('main', $data);
    
}

function salidas_por_clave()
    {
        $data['subtitulo'] = "";
        $data['js'] = "reportes/entradas_por_clave_js";
        //$data['js'] = "reportes/esi_por_clave_js";
        $this->load->view('main', $data);
    }
    
    function salidas_por_clave_submit()
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        $fecha1 = $this->input->post('fecha1');
        $fecha2 = $this->input->post('fecha2');
        $cvearticulo = $this->input->post('cvearticulo');
        //$articulo = $this->input->post('articulo');
        $data['fecha1'] = $fecha1;
        $data['fecha2'] = $fecha2;
        $data['query'] = $this->reportes_model->salidas_por_clave_detalle($fecha1, $fecha2,$cvearticulo);
        $data['query2'] = $this->reportes_model->salidas_por_clave($fecha1, $fecha2,$cvearticulo);
        $data['subtitulo'] = "Resumen De Salidas: " .$fecha1 . " al " . $fecha2;
        $this->load->view('main', $data);
}



}