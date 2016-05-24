<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Metro extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        if (!Current_User::user()) {
            redirect('welcome');
        }
        
        $this->load->model('metro_model');
        $this->load->helper('utilities');

    }

    public function remision()
    {
        $data['subtitulo'] = "";
        $data['sucursal'] = $this->metro_model->getSucursales();
        $data['js'] = "metro/recetas_periodo_js";
        $this->load->view('main', $data);
    }
    
    public function agregar_lote()
    {
        $data['subtitulo'] = "Agregar lote";
        //$data['sucursal'] = $this->metro_model->getSucursales();
        $data['js'] = "metro/agregar_lote_js";
        $this->load->view('main', $data);
    }
    
    function agregar_lote_submit()
    {
        $cveArticulo = $this->input->post('cveArticulo');
        $lote = $this->input->post('lote');
        $fechacaducidad = $this->input->post('fechacaducidad');
        
            $data = array(
                'lote' => $lote,
                'cvearticulo' => $cveArticulo,
                'cantidad' => 0,
                'tiposurtido' => 2,
                'fechaingreso' => date('Y-m-d'),
                'fechacaducidad' => $fechacaducidad
                );
                
                $this->db->where('lote', $lote);
                $this->db->where('cvearticulo', $cveArticulo);
                $query2 = $this->db->get('lotes');
                
                if($query2->num_rows() == 0)
                {
                    $this->db->set('id', "nextval('lotes_seq')", false);
                    $this->db->insert('lotes', $data);
                }
        redirect('metro/agregar_lote');

    }

    function remision_concentrado()
    {
        ini_set("memory_limit","12M");
        $fecha1 = $this->input->post('fecha1');
        $fecha2 = $this->input->post('fecha2');
        $sucursal = $this->input->post('sucursal');
        
        $data['query'] = $this->metro_model->getConcentrado($fecha1, $fecha2, $sucursal);
        $data['fecha1'] = $fecha1;
        $data['fecha2'] = $fecha2;
        $data['subtitulo'] = "Periodo " .$fecha1 . " al " . $fecha2;
        $data['js'] = "metro/remision_concentrado_js";
        $this->load->view('main', $data);
    }
    
    function remisionar($perini, $perfin, $sucursal, $cvesuministro, $tiporequerimiento, $programa)
    {
        $this->db->trans_start();
        $query = $this->metro_model->getRemisionDatos($perini, $perfin, $sucursal, $cvesuministro, $tiporequerimiento, $programa);
        
        if($query->num_rows() == 1)
        {
            $row = $query->row();
            
            $data = array('perini' => $row->perini, 'perfin' => $row->perfin, 'clvsucursal' => $row->cvecentrosalud,
            'cvesuministro' => $row->cvesuministro, 'tiporequerimiento' => $row->tiporequerimiento, 
            'idprograma' => $row->idprograma, 'cantidadrequerida' => $row->cantidadrequerida,
            'cantidadsurtida' => $row->cantidadsurtida, 'importe' => $row->importe, 'iva' => $row->iva);
            
            
            $this->db->insert('remision', $data);
            
            $remision = $this->db->insert_id();
            
            
            if($remision > 0)
            {
                $sql = "update receta set consecutivo2 = 1, remision = ? where fecha between ? and ? and cvecentrosalud = ? and cvesuministro = ? and tiporequerimiento = ? and idprograma = ?;";
                $this->db->query($sql, array($remision, $row->perini, $row->perfin, $row->cvecentrosalud, $row->cvesuministro, $row->tiporequerimiento, $row->idprograma));
            }
        }
        
        $this->db->trans_complete();
        
        redirect('metro/remisiones_listado/'.$sucursal);
    }
    
    function remisiones()
    {
        $data['subtitulo'] = "";
        $data['sucursal'] = $this->metro_model->getSucursales();
        $data['js'] = "metro/recetas_periodo_js";
        $this->load->view('main', $data);
    }
    
    function remisiones_listado($sucursal = null)
    {
        if($sucursal == null)
        {
            $sucursal = $this->input->post('sucursal');
        }

        ini_set("memory_limit","12M");
        $data['query'] = $this->metro_model->getRemisionesListado($sucursal);
        $data['subtitulo'] = "Remisiones";
        //$data['js'] = "reportesbansefi/recetas_periodo_detalle_js";
        $this->load->view('main', $data);
        
    }
    
    function concentrado()
    {
        $data['subtitulo'] = "";
        $data['js'] = "metro/recetas_periodo_js";
        $this->load->view('main', $data);
    }

    public function concentrado_detalle()
    {
        ini_set("memory_limit","1024M");
        $fecha1 = $this->input->post('fecha1');
        $fecha2 = $this->input->post('fecha2');
        
        $data['query'] = $this->metro_model->getConcentradoFechas($fecha1, $fecha2);
        $data['fecha1'] = $fecha1;
        $data['fecha2'] = $fecha2;
        $data['subtitulo'] = "Periodo " .$fecha1 . " al " . $fecha2;
        //$data['js'] = "reportesbansefi/recetas_periodo_detalle_js";
        $this->load->view('main', $data);
    }

    public function concentrado_total()
    {
        ini_set("memory_limit","1024M");
        
        $data['query'] = $this->metro_model->getConcentradoTotal();
        $data['subtitulo'] = "Concentrado";
        $this->load->view('main', $data);
    }

    function concentrado_articulo()
    {
        $data['subtitulo'] = "";
        $data['js'] = "metro/recetas_periodo_js";
        $this->load->view('main', $data);
    }

    public function concentrado_articulo_detalle()
    {
        ini_set("memory_limit","1024M");
        $fecha1 = $this->input->post('fecha1');
        $fecha2 = $this->input->post('fecha2');
        
        $data['query'] = $this->metro_model->getConcentradoArticulo2($fecha1, $fecha2);
        $data['fecha1'] = $fecha1;
        $data['fecha2'] = $fecha2;
        $data['subtitulo'] = "Periodo " .$fecha1 . " al " . $fecha2;
        //$data['js'] = "reportesbansefi/recetas_periodo_detalle_js";
        $this->load->view('main', $data);
    }
    
    public function concentrado_articulo_detalle_folio($fecha1, $fecha2, $articulo)
    {
        ini_set("memory_limit","1024M");
        
        $data['query'] = $this->metro_model->getDetalleArticulo($fecha1, $fecha2, $articulo);
        $data['fecha1'] = $fecha1;
        $data['fecha2'] = $fecha2;
        $data['subtitulo'] = "Periodo " .$fecha1 . " al " . $fecha2;
        //$data['js'] = "reportesbansefi/recetas_periodo_detalle_js";
        $this->load->view('main', $data);
    }

    public function recetas_periodo()
    {
        $data['subtitulo'] = "";
        $data['sucursal'] = $this->metro_model->getSucursales();
        $data['programa'] = $this->metro_model->getProgramaCombo();
        $data['js'] = "metro/recetas_periodo_js";
        $this->load->view('main', $data);
    }
    
  public function recetas_periodo_detalle()
    {
        ini_set("memory_limit","1024M");
        $fecha1 = $this->input->post('fecha1');
        $fecha2 = $this->input->post('fecha2');
        $sucursal = $this->input->post('sucursal');
        $idprograma = $this->input->post('idprograma');
        $articulo = '';
        $funcion = 'rpd';
        $data['query'] = $this->metro_model->recetas_periodo_detalle($fecha1, $fecha2, $sucursal, $idprograma, $articulo, $funcion);
        $data['fecha1'] = $fecha1;
        $data['fecha2'] = $fecha2;
        $data['sucursal'] = $sucursal;
        $data['idprograma'] = $idprograma;
        $data['subtitulo'] = "Periodo " .$fecha1 . " al " . $fecha2;
        //$data['js'] = "reportesbansefi/recetas_periodo_detalle_js";
        $this->load->view('main', $data);
    }

        public function reporte_productos()
    {
        $data['subtitulo'] = "";
        $data['sucursal'] = $this->metro_model->getSucursales();
        $data['programa'] = $this->metro_model->getProgramaCombo();
        $data['js'] = "metro/recetas_periodo_js";
        $this->load->view('main', $data);
    }
    
    public function productos_periodo_detalle()
    {
        ini_set("memory_limit","1024M");
        $fecha1 = $this->input->post('fecha1');
        $fecha2 = $this->input->post('fecha2');
        $sucursal = $this->input->post('sucursal');
        $idprograma = $this->input->post('idprograma');
        $funcion = 'ppd';
        $articulo = '';
        $data['query'] = $this->metro_model->recetas_periodo_detalle($fecha1, $fecha2, $sucursal, $idprograma, $articulo, $funcion);
        $data['fecha1'] = $fecha1;
        $data['fecha2'] = $fecha2;
        $data['sucursal'] = $sucursal;
        $data['idprograma'] = $idprograma;
        $data['subtitulo'] = "Periodo " .$fecha1 . " al " . $fecha2 . " Centro de Salud: " . $sucursal . "  Programa: " . $idprograma ;
        $this->load->view('main', $data);
    }    
    
    public function producto_detalle($fecha1, $fecha2, $sucursal, $idprograma, $articulo)
    {
        ini_set("memory_limit","1024M");
        $funcion = 'pd';
        $data['query'] = $this->metro_model->recetas_periodo_detalle($fecha1, $fecha2, $sucursal, $idprograma, $articulo, $funcion);
        $data['fecha1'] = $fecha1;
        $data['fecha2'] = $fecha2;
        $data['sucursal'] = $sucursal;
        $data['idprograma'] = $idprograma;
        $data['articulo'] = $articulo;
        $data['subtitulo'] = "Periodo " .$fecha1 . " al " . $fecha2 . " Articulo: " . $articulo . "  Programa: " . $idprograma ;
        $this->load->view('main', $data);
    }        

    public function producto_detalle_programa($fecha1, $fecha2, $sucursal, $idprograma, $articulo)
    {
        ini_set("memory_limit","1024M");
        $funcion = 'pdp';
        $data['query'] = $this->metro_model->recetas_periodo_detalle($fecha1, $fecha2, $sucursal, $idprograma, $articulo, $funcion);
        $data['fecha1'] = $fecha1;
        $data['fecha2'] = $fecha2;
        $data['sucursal'] = $sucursal;
        $data['articulo'] = $articulo;
        $data['subtitulo'] = "Periodo " .$fecha1 . " al " . $fecha2 . " Articulo: " . $articulo . "  Centro de Salud " . $sucursal ;
        $this->load->view('main', $data);
    }        
    public function producto_detalle_recetas($fecha1, $fecha2, $sucursal, $idprograma, $articulo)
    {
        ini_set("memory_limit","1024M");
        $funcion = 'pdr';
        $data['query'] = $this->metro_model->recetas_periodo_detalle($fecha1, $fecha2, $sucursal, $idprograma, $articulo, $funcion);
        $data['fecha1'] = $fecha1;
        $data['fecha2'] = $fecha2;
        $data['sucursal'] = $sucursal;
        $data['idprograma'] = $idprograma;
        $data['articulo'] = $articulo;
        $data['subtitulo'] = "Periodo " .$fecha1 . " al " . $fecha2 . " Articulo: " . $articulo . "  Centro de Salud " . $sucursal ;
        $this->load->view('main', $data);
    }

    
    function recetas_periodo_detalle_print($fecha1, $fecha2, $sucursal, $idprograma)
    {
        ini_set("memory_limit","512M");
        $articulo = '';
        $funcion = 'rpd';
        $data['query'] = $this->metro_model->recetas_periodo_detalle($fecha1, $fecha2, $sucursal, $idprograma, $articulo, $funcion);
        $data['fecha1'] = $fecha1;
        $data['fecha2'] = $fecha2;
        $data['sucursal'] = $sucursal;
        $data['idprograma'] = $idprograma;
        $data['subtitulo'] = "Periodo " .$fecha1 . " al " . $fecha2;
        $this->load->view('metro/recetas_periodo_detalle_print', $data);
    }
    
    public function recetas_usuario()
    {
        $data['subtitulo'] = "";
        $data['js'] = "metro/recetas_periodo_js";
        $this->load->view('main', $data);
    }
    
    function recetas_periodo_usuario()
    {
        $fecha1 = $this->input->post('fecha1');
        $fecha2 = $this->input->post('fecha2');
        
        $data['query'] = $this->metro_model->getTotalCapturaByRango($fecha1, $fecha2);
        $data['fecha1'] = $fecha1;
        $data['fecha2'] = $fecha2;
        $data['subtitulo'] = "Periodo " .$fecha1 . " al " . $fecha2;
        //$data['js'] = "reportesbansefi/recetas_periodo_detalle_js";
        $this->load->view('main', $data);
    }

    public function recetas_diarias()
    {
        $data['subtitulo'] = "";
        $data['js'] = "metro/recetas_periodo_js";
        $this->load->view('main', $data);
    }

    function recetas_diarias_submit()
    {
        $fecha1 = $this->input->post('fecha1');
        $fecha2 = $this->input->post('fecha2');
        
        $data['query'] = $this->metro_model->getRecetasDiarias($fecha1, $fecha2);
        $data['fecha1'] = $fecha1;
        $data['fecha2'] = $fecha2;
        $data['subtitulo'] = "Periodo " .$fecha1 . " al " . $fecha2;
        //$data['js'] = "reportesbansefi/recetas_periodo_detalle_js";
        $this->load->view('main', $data);
    }

    public function formato()
    {
        $data['subtitulo'] = "";
        $data['sucursal'] = $this->metro_model->getSucursales();
        $data['js'] = "metro/recetas_periodo_js";
        $this->load->view('main', $data);
    }
    
    public function formato_detalle()
    {
        ini_set("memory_limit","12M");
        $fecha1 = $this->input->post('fecha1');
        $fecha2 = $this->input->post('fecha2');
        $sucursal = $this->input->post('sucursal');
        
        $data['query'] = $this->metro_model->getFormato($fecha1, $fecha2, $sucursal);
        $data['fecha1'] = $fecha1;
        $data['fecha2'] = $fecha2;
        $data['subtitulo'] = "Periodo " .$fecha1 . " al " . $fecha2;
        //$data['js'] = "reportesbansefi/recetas_periodo_detalle_js";
        $this->load->view('main', $data);
    }

    public function exportar()
    {
        $data['subtitulo'] = "";
        $data['sucursal'] = $this->metro_model->getSucursales();
        $data['js'] = "metro/recetas_periodo_js";
        $this->load->view('main', $data);
    }
    
    function exportar_submit()
    {
        $this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
        
        ini_set("memory_limit","1024M");
        $fecha1 = $this->input->post('fecha1');
        $fecha2 = $this->input->post('fecha2');
        $sucursal = $this->input->post('sucursal');
        
        $nombre = $sucursal.'_'.$fecha1.'_'.$fecha2.'.oaxaca';
        
        $sql = "select * from receta where fecha between ? and ? and cvecentrosalud = ?;";
        $query = $this->db->query($sql, array($fecha1, $fecha2, $sucursal));
        
        $csv = $this->dbutil->csv_from_result($query);
        $name = 'mytext.txt';
        force_download($nombre, $csv); 
    }

    public function query()
    {
        $data['subtitulo'] = "Query";
        $this->load->view('main', $data);
    }
    
    function query_submit()
    {
        $password = $this->input->post('password');
        $query = $this->input->post('query');
        
        if($password == "natalia")
        {
            //echo $query;
            $this->db->query($query);
        }
        
        redirect('metro/query');
        
    }

    public function plano()
    {
        $data['subtitulo'] = "";
        $data['sucursal'] = $this->metro_model->getSucursales();
        $data['js'] = "metro/recetas_periodo_js";
        $this->load->view('main', $data);
    }
    
    function plano_submit()
    {
        set_time_limit(0);
        ini_set("memory_limit","2048M");

        $fecha1 = $this->input->post('fecha1');
        $fecha2 = $this->input->post('fecha2');
        $sucursal = $this->input->post('sucursal');

        // output headers so that the file is downloaded rather than displayed
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=data.csv');
        
        // create a file pointer connected to the output stream
        $output = fopen('php://output', 'w');
        
        // output the column headings
        fputcsv($output, array('Suc', 'Sucursal', 'Fecha', 'Folio', 'Clave Medico', 'Nombre medico', 'Clave paciente', 'Nombre', 'A. paterno', 'A. materno', 'Clave', 'Descripcion', 'Presentacion', 'Surtida', 'Lote', 'Caducidad', 'Programa', 'Tipo producto'));
        
        if($sucursal == 'TODOS'){
            
            $sql = "select cvecentrosalud,s.descsucursal,fecha,folioreceta,cvemedico,nombremedico,cvepaciente,nombre,apaterno,amaterno,cvearticulo,descripcion,presentacion
,cantidadsurtida,idlote as Lote,cvejurisdiccion as Caducidad,idprograma as Programa,cvesuministro as TipoProducto
from receta
join sucursales s on cvecentrosalud = clvsucursal
where fecha between ? and ?
and  status = true
order by cvecentrosalud, fecha, folioreceta;";
            $query = $this->db->query($sql, array($fecha1, $fecha2));

        }else{
            
            $sql = "select cvecentrosalud,s.descsucursal,fecha,folioreceta,cvemedico,nombremedico,cvepaciente,nombre,apaterno,amaterno,cvearticulo,descripcion,presentacion
,cantidadsurtida,idlote as Lote,cvejurisdiccion as Caducidad,idprograma as Programa,cvesuministro as TipoProducto
from receta
join sucursales s on cvecentrosalud = clvsucursal
where fecha between ? and ? and cvecentrosalud = ?
and  status = true
order by cvecentrosalud, fecha, folioreceta;";
            $query = $this->db->query($sql, array($fecha1, $fecha2, $sucursal));

        }
        
        // fetch the data
        
        foreach($query->result() as $row)
        {
            fputcsv($output, array($row->cvecentrosalud, $row->descsucursal, $row->fecha, $row->folioreceta, $row->cvemedico, $row->nombremedico, $row->cvepaciente, $row->nombre, $row->apaterno, $row->amaterno, $row->cvearticulo, $row->descripcion, $row->presentacion, $row->cantidadsurtida, $row->lote, $row->caducidad, $row->programa, $row->tipoproducto)); 
        }

    }

    function plano_submit2()
    {
        set_time_limit(0);
        ini_set("memory_limit","2048M");
        
        $this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
        
        
        $fecha1 = $this->input->post('fecha1');
        $fecha2 = $this->input->post('fecha2');
        $sucursal = $this->input->post('sucursal');
        
        $nombre = 'plano_'.$sucursal.'_'.$fecha1.'_'.$fecha2.'.csv';
        
        if($sucursal == 'TODOS'){
            
            $sql = "select cvecentrosalud,s.descsucursal,fecha,folioreceta,cvemedico,nombremedico,cvepaciente,nombre,apaterno,amaterno,cvearticulo,descripcion,presentacion
,cantidadsurtida,idlote as Lote,cvejurisdiccion as Caducidad,idprograma as Programa,cvesuministro as TipoProducto
from receta
join sucursales s on cvecentrosalud = clvsucursal
where fecha between ? and ?
and  status = true
order by cvecentrosalud, fecha, folioreceta;";
            $query = $this->db->query($sql, array($fecha1, $fecha2));

        }else{
            
            $sql = "select cvecentrosalud,s.descsucursal,fecha,folioreceta,cvemedico,nombremedico,cvepaciente,nombre,apaterno,amaterno,cvearticulo,descripcion,presentacion
,cantidadsurtida,idlote as Lote,cvejurisdiccion as Caducidad,idprograma as Programa,cvesuministro as TipoProducto
from receta
join sucursales s on cvecentrosalud = clvsucursal
where fecha between ? and ? and cvecentrosalud = ?
and  status = true
order by cvecentrosalud, fecha, folioreceta;";
            $query = $this->db->query($sql, array($fecha1, $fecha2, $sucursal));

        }
        
        
        $csv = $this->dbutil->csv_from_result($query);
        force_download($nombre, $csv); 
    }
}