<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mail extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('reportes_model');
        $this->load->helper('utilities');
        date_default_timezone_set('America/Mexico_City');

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

}