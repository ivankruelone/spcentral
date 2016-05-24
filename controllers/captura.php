<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Captura extends CI_Controller
{
    var $idInicial = 9776;
    var $idFinal = 1000000;

    public function __construct()
    {
        parent::__construct();

        if (!Current_User::user()) {
            redirect('welcome');
        }

        $this->load->model('captura_model');
        $this->load->helper('utilities');

    }
    
    public function recetas($fechaCon = null)
    {
        $this->captura_model->cleanProductosTemporal();
        $data['subtitulo'] = "Captura de recetas";
        $data['js'] = "captura/recetas_js";
        $data['categoria'] = $this->captura_model->getCveServicioCombo();
        $data['requerimiento'] = $this->captura_model->getRequerimientoCombo();
        $data['tipoReceta'] = $this->captura_model->getProgramaCombo();
        $data['sexo'] = $this->captura_model->getSexoCombo();
        $data['rango'] = $this->captura_model->getRango();
        $data['config'] = $this->captura_model->getConfig();
        $data['fechaCon'] = $fechaCon;
        $this->load->view('main', $data);
    }
    
    function verifica_folio()
    {
        $folioReceta = $this->input->post('folioReceta');
        echo $this->captura_model->getRecetaExist2(strtoupper($folioReceta));
    }
    
        function verifica_lote()
    {
        $lote = $this->input->post('lote');
        $cvearticulo = $this->input->post('cvearticulo');
        echo $this->captura_model->getlote($lote, $cvearticulo);
    }
    
    function actualizaLotes()
    {
        $cveArticulo = $this->input->post('cveArticulo');
        echo $this->captura_model->getLotesCombo($cveArticulo);
    }
    
    function busca_expediente()
    {
        $term = $this->input->get_post('term');
        echo $this->captura_model->getPadronByCvePacienteJson($term);
    }
    
    function busca_cveArticulo()
    {
        $term = $this->input->get_post('term');
        echo $this->captura_model->getArticuloByCveArticulo($term);
    }
    
    function verifica_expediente()
    {
        $expediente = $this->input->post('expediente');
        echo $this->captura_model->getPacienteFromCvePaciente($expediente);
    }
    
    function verifica_cveMedico()
    {
        $cveMedico = $this->input->post('cveMedico');
        echo $this->captura_model->getMedicoFromCveMedico($cveMedico);
    }
    
    function add_producto()
    {
        $cveArticulo = $this->input->post('cveArticulo');
        $req = $this->input->post('req');
        $sur = $this->input->post('sur');
        $precio = $this->input->post('precio');
        $lote = $this->input->post('lote');
        $fechacad = $this->input->post('fechacad');
        
        
        
        $this->captura_model->insertProducto($cveArticulo, $req, $sur, $precio, $lote, $fechacad);
    }
    
    function actualiza_tabla_productos()
    {
        $data['query'] = $this->captura_model->getTablaProductosTemporal2();
        $this->load->view('captura/tabla_productos', $data);
    }
    
    function actualiza_tabla_productos_ver()
    {
        $data['query'] = $this->captura_model->getTablaProductosTemporal2();
        $this->load->view('captura/tabla_productos_ver', $data);
    }

    function eliminar($serie)
    {
        $this->captura_model->deleteProducto($serie);
        $data['query'] = $this->captura_model->getTablaProductosTemporal2();
        $this->load->view('captura/tabla_productos', $data);
    }
    
    function guardalote($cvearticulo,$idlote,$fechacad)
    {
        $sql = "select * from lotes where lote = ? and cvearticulo = ? and status = 't'";
              
        $query = $this->db->query($sql, array(trim(strtoupper($idlote)),trim($cvearticulo)));
        
        if($query->num_rows() == 0)
        {
            $this->db->set('id', "nextval('lotes_seq')", false);
            $sql = array('lote' => trim(strtoupper($idlote)), 'cvearticulo' => $cvearticulo,'cantidad' => 0,'tiposurtido' => 2,
            'fechaingreso' => date('Y-m-d'), 'fechacaducidad' => $fechacad, 'status' => 't');
            $this->db->insert('lotes', $sql);
        }else{
            
            
            $updateData = array('fechacaducidad' => $fechacad);
            $where = array('lote' => trim(strtoupper($idlote)), 'cvearticulo' => $cvearticulo);
            
            $this->db->update('lotes', $updateData, $where);
            
        }        
        
    }
    
    function guardar()
    {
        
        $this->db->trans_start();
        $fechaConsulta = $this->input->post('fechaConsulta');
        $fechaSurtido = $this->input->post('fechaSurtido');
        $folioReceta = $this->input->post('folioReceta');
        $tipoReceta = $this->input->post('tipoReceta');
        $categoria = $this->input->post('categoria');
        $expediente = $this->input->post('expediente');
        $paterno = $this->input->post('paterno');
        $materno = $this->input->post('materno');
        $nombre = $this->input->post('nombre');
        $sexo = $this->input->post('sexo');
        $edad = $this->input->post('edad');
        $cveMedico = $this->input->post('cveMedico');
        $medico = $this->input->post('medico');
        $tipoReq = $this->input->post('tipoReq');
        $tipo = $this->input->post('tipo');
        $consecutivo_edicion = $this->input->post('consecutivo');
        
        if($sexo == null)
        {
            $sexo = 0;
        }
        
        if($tipo == 'captura')
        {
            
            $data = array(
                'clvsucursal' => $this->session->userdata('clvsucursal'),
                'cvemedico' => $cveMedico, 
                'cveservicio' => $categoria, 
                'cvepaciente' => $expediente, 
                'fecha' => $fechaSurtido,
                'nombre' => ($nombre), 
                'apaterno' => ($paterno), 
                'genero' => trim($sexo), 
                'edad' => ($edad), 
                'amaterno' => ($materno), 
                'nombremedico' => ($medico),
                'tiporequerimiento' => $tipoReq, 
                'folioreceta' => $folioReceta, 
                'fechaexp' => $fechaConsulta, 
                'idprograma' => $tipoReceta, 
                'usuario' => $this->session->userdata('usuario')
                );
                
                $this->db->set('alta', 'now()', false);
                $this->db->insert('receta', $data);
                
                $consecutivo = $this->db->insert_id();
                
        }elseif($tipo == 'edita'){
            $data = array(
                'clvsucursal' => $this->session->userdata('clvsucursal'),
                'cvemedico' => $cveMedico, 
                'cveservicio' => $categoria, 
                'cvepaciente' => $expediente, 
                'fecha' => $fechaSurtido,
                'nombre' => ($nombre), 
                'apaterno' => ($paterno), 
                'genero' => trim($sexo), 
                'edad' => ($edad), 
                'amaterno' => ($materno), 
                'nombremedico' => ($medico),
                'tiporequerimiento' => $tipoReq, 
                'folioreceta' => $folioReceta, 
                'fechaexp' => $fechaConsulta, 
                'idprograma' => $tipoReceta, 
                'usuario' => $this->session->userdata('usuario')
                );
                
                $this->db->set('cambio', 'now()', false);
                $this->db->update('receta', $data, array('consecutivo' => $consecutivo_edicion));
                
                $sql_borra_audita = "delete from receta_audita where consecutivo = ?";
                $this->db->query($sql_borra_audita, $consecutivo_edicion);
                
                $consecutivo = $consecutivo_edicion;
        }
        
        
            
            $sql_paciente = "insert into paciente (cvepaciente, nombre, apaterno, amaterno, genero, edad) values (?, ?, ?, ?, ?, ?) on duplicate key update nombre = values(nombre), apaterno = values(apaterno), amaterno = values(amaterno), genero = values(genero), edad = values(edad);";
            $this->db->query($sql_paciente, array((string)$expediente, (string)$nombre, (string)$paterno, (string)$materno, (int)$sexo, (int)$edad));
            
            $sql_medico = "insert into medico (cvemedico, nombremedico) values (?, ?) on duplicate key update nombremedico = values(nombremedico);";
            $this->db->query($sql_medico, array($cveMedico, $medico));

        
        $productos = $this->captura_model->getTablaProductosTemporal2();
        
        foreach($productos->result() as $row)
        {
            $data2 = array(
                'consecutivo' => $consecutivo,
                'id' => $row->id,
                'lote' => $row->lote,
                'caducidad' => $row->caducidad,
                'canreq' => $row->req,
                'cansur' => $row->sur,
                'descontada' => 0
                );
            
            if($row->consecutivo_temporal == 0)
            {
               $this->db->set('altaDetalle', "now()", false);
               $this->db->insert('receta_detalle', $data2);
               
               
               if($row->cantidad == 'NADA')
               {
                    $cantidad  = ((int)0 - (int)$row->sur);
                    $data = array(
                        'id' => $row->id,
                        'lote' => $row->lote,
                        'caducidad' => $row->caducidad,
                        'cantidad' => $cantidad,
                        'tipoMovimiento' => 2,
                        'subtipoMovimiento' => 10,
                        'receta' => $consecutivo,
                        'usuario' => $this->session->userdata('usuario'),
                        'movimientoID' => 0,
                        'clvsucursal' => $this->session->userdata('clvsucursal')
                        );
                        
                    $this->db->set('ultimo_movimiento', 'now()', false);
                    $this->db->insert('inventario', $data);
               }else{
                    $cantidad  = ((int)$row->cantidad - (int)$row->sur);
                    $data = array(
                        'id' => $row->id,
                        'lote' => $row->lote,
                        'caducidad' => $row->caducidad,
                        'cantidad' => $cantidad,
                        'tipoMovimiento' => 2,
                        'subtipoMovimiento' => 10,
                        'receta' => $consecutivo,
                        'usuario' => $this->session->userdata('usuario'),
                        'movimientoID' => 0,
                        'clvsucursal' => $this->session->userdata('clvsucursal')
                        );
                        
                    $this->db->set('ultimo_movimiento', 'now()', false);
                    $this->db->update('inventario', $data, array('inventarioID' => $row->inventarioID));
               }
               
               
            }else{
                //$this->db->update('receta', $data, array('consecutivo' => $row->consecutivo_temporal));
            }
            

            
        }
        
        $this->captura_model->cleanProductosTemporal();
        
        
        
        $this->db->trans_complete();
        
        
        if ($this->db->trans_status() === TRUE)
        {
            $this->util->postReceta($consecutivo);
            $this->util->postInventarioReceta($consecutivo);// generate an error... or use the log_message() function to log your error
        } 
        
        echo $consecutivo;
        
        
    }

    public function rango()
    {
        $data['subtitulo'] = "Definir rango de captura";
        $data['js'] = "captura/rango_js";
        $data['rango'] = $this->captura_model->getRango();
        $data['requerimiento'] = $this->captura_model->getRequerimientoCombo();
        $this->load->view('main', $data);
    }

    function rango__agregar()
    {
        $fecha_inicial = $this->input->post('fecha_inicial');
        $fecha_final = $this->input->post('fecha_final');
        $fecha_surtido = $this->input->post('fecha_surtido');
        $tiporequerimiento = $this->input->post('tipoReq');
        $this->captura_model->guardaRango($fecha_inicial, $fecha_final, $fecha_surtido, $tiporequerimiento);
        redirect('captura/recetas');
    }
    
    function verifica_fecha_rango()
    {
        $fecha = $this->input->post('fecha');
        echo $this->captura_model->checkFechaRango($fecha);
    }

function valida_fecha()
    {
        $fecha = $this->input->post('fechacad');
        $fechacap = $this->input->post('fechacap');
        $fechalim1 = Date('Y-m-d',strtotime('+3 months', strtotime($fechacap)));
        $fechalim2 = Date('Y-m-d',strtotime('+120 months', strtotime($fechacap)));
        if ($fecha < $fechalim1 or $fecha > $fechalim2)
        {
            $res = 1;
        }
        else
        {
            $res = 1;
        }
        echo $res;
            
    }

    public function edicion()
    {
        $data['subtitulo'] = "Definir rango de captura";
        $data['js'] = "captura/edicion_js";
        $data['rango'] = $this->captura_model->getRango();
        $data['mensaje'] = $this->session->flashdata('mensaje');
        $this->load->view('main', $data);
    }
    
    function edicion_submit()
    {
        $folioReceta = $this->input->post('folioReceta');
        $query = $this->captura_model->getReceta($folioReceta);
        
        if($query->num_rows() > 0)
        {
            $row = $query->row();
            
            if(trim($row->clvsucursal) == trim($this->session->userdata('clvsucursal')))
            {
                    $this->session->set_flashdata('folioReceta', $folioReceta);
                    redirect('captura/edita/');
            }else{
                $this->session->set_flashdata('mensaje', "Este folio: ".$folioReceta.", esta capturado en la sucursal: " . $row->cvecentrosalud . ' - ' . $this->captura_model->getSucursalNombreByClvSucursal($row->cvecentrosalud));
                redirect('captura/edicion');
            }
        }else{
                $this->session->set_flashdata('mensaje', "Este folio: ".$folioReceta.", no existe.");
                redirect('captura/edicion');
        }
        
    }
    
    function edita($consecutivo = null)
    {
        if($consecutivo == null)
        {
            $folioReceta = $this->session->flashdata('folioReceta');
            
        }else{
            $folioReceta = $this->captura_model->getFolioRecetaByConsecutivo($consecutivo);
        }
        

        $this->session->keep_flashdata('folioReceta');

        $this->captura_model->cleanProductosTemporal();
        $this->captura_model->fillProductosTemporal($folioReceta);
        $data['subtitulo'] = "Modifica receta";
        $data['js'] = "captura/recetas_js";
        $data['categoria'] = $this->captura_model->getCveServicioCombo();
        $data['requerimiento'] = $this->captura_model->getRequerimientoCombo();
        $data['tipoReceta'] = $this->captura_model->getProgramaCombo();
        $data['sexo'] = $this->captura_model->getSexoCombo();
        $data['query'] = $this->captura_model->getTablaProductosTemporal2();
        $data['rango'] = $this->captura_model->getRango();
        $data['config'] = $this->captura_model->getConfig();
        $data['receta'] = $this->captura_model->getRecetaCompleta($folioReceta);
        $this->load->view('main', $data);
    }
    
    function ver($consecutivo)
    {
        $this->captura_model->cleanProductosTemporal();
        $this->captura_model->fillProductosTemporalByConsecutivo($consecutivo);
        $data['subtitulo'] = "Modifica receta";
        $data['js'] = "captura/recetas_js";
        $data['categoria'] = $this->captura_model->getCveServicioCombo();
        $data['requerimiento'] = $this->captura_model->getRequerimientoCombo();
        $data['tipoReceta'] = $this->captura_model->getProgramaCombo();
        $data['sexo'] = $this->captura_model->getSexoCombo();
        $data['query'] = $this->captura_model->getTablaProductosTemporal2();
        $data['rango'] = $this->captura_model->getRango();
        $data['config'] = $this->captura_model->getConfig();
        $data['receta'] = $this->captura_model->getRecetaCompletaByConsecutivo($consecutivo);
        $this->load->view('main', $data);
    }

    function elimina_receta()
    {
        $folioReceta = $this->session->flashdata('folioReceta');
        
        $this->db->update('receta', array('status' => 'f'), array('folioreceta' => $folioReceta));
        
        redirect('captura/recetas');
    }
    
    function verificaCveArticulo()
    {
        $cveArticulo = $this->input->post('cveArticulo');
        echo $this->captura_model->checkCveArticulo($cveArticulo);
    }
    
    function procesaLotes()
    {
        $query = $this->db->get('temporal_lotes');
        foreach($query->result() as $row)
        {
            $data = array(
                'lote' => $row->lote,
                'cvearticulo' => $row->cvearticulo,
                'cantidad' => 0,
                'tiposurtido' => 2,
                'fechaingreso' => date('Y-m-d'),
                'fechacaducidad' => $row->fechacaducidad
                );
                
                $this->db->where('lote', $row->lote);
                $this->db->where('cvearticulo', $row->cvearticulo);
                $query2 = $this->db->get('lotes');
                
                if($query2->num_rows() == 0)
                {
                    $this->db->set('id', "nextval('lotes_seq')", false);
                    $this->db->insert('lotes', $data);
                }
        }
    }
    
    function liberar($consecutivo)
    {
        $this->util->postLiberareceta($consecutivo);
        redirect('workspace');
    }

    public function rapida($fechaCon = null)
    {
        $this->captura_model->cleanProductosRapida();
        $data['subtitulo'] = "Captura rapida de recetas";
        $data['js'] = "captura/rapida_js";
        $data['config'] = $this->captura_model->getConfig();
        $this->load->view('main', $data);
    }
    
    function folio_submit()
    {
        $folioReceta = $this->input->post('folioReceta');
        $folioReceta = $this->captura_model->cleanFolio($folioReceta);
        
        $exist = $this->captura_model->existReceta($folioReceta);
        if($exist == 1)
        {
            $this->session->set_flashdata('error', 'Este folio: <b>'.$folioReceta.'</b> ya existe, no se puede duplicar.');
            redirect('captura/rapida');
            
        }
        
        $data['subtitulo'] = "Captura rapida de recetas";
        $data['js'] = "captura/folio_submit_js";
        $data['config'] = $this->captura_model->getConfig();
        $data['folioReceta'] = $folioReceta;
        $this->load->view('main', $data);
        
    }
    
    function buscaArticuloScaner()
    {
        $ean = trim($this->input->post('ean'));
        
        $query = $this->captura_model->getArticuloScaner($ean);
        
        if($query->num_rows() > 0)
        {
            $row = $query->row();
            
            $this->captura_model->saveRecetaDetalle($row->inventarioID, $ean);
            
            echo '1';
        }else{
            echo '0';
        }
    }
    
    function actualiza_tabla_productos_rapida()
    {
        $data['query'] = $this->captura_model->detalleRecetaRapida();
        $this->load->view('captura/tabla_productos_rapida', $data);
    }
    
    function eliminar_rapida($serie)
    {
        $this->captura_model->deleteSerieRapida($serie);
        $this->actualiza_tabla_productos_rapida();
    }
    
    function guardaRapida()
    {
        $folioReceta = $this->input->post('folioReceta');
        $resultado = $this->captura_model->guardaRapidaDB($folioReceta);
        if($resultado == true)
        {
            $this->session->set_flashdata('ok', 'Este folio: <b>'.$folioReceta.'</b> se guardo correctamente.');
            $this->captura_model->cleanProductosRapida();
            echo 1;
        }else{
            echo 0;
        }
    }

}
