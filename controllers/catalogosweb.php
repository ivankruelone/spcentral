<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Catalogosweb extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        if (!Current_User::user()) {
            redirect('welcome');
        }
        
        $this->load->model('Catalogosweb_model');
        $this->load->helper('utilities');

    }
    
    function articulo($cvesuministro)
    {
        $this->load->library('pagination');

        $config['base_url'] = site_url('catalogosweb/articulo/'.$cvesuministro);
        $config['total_rows'] = $this->Catalogosweb_model->getCountArticulo($cvesuministro);
        $config['per_page'] = 500;
        $config['uri_segment'] = 4;
        
        $this->pagination->initialize($config); 
        $data['subtitulo'] = "Catalogo de articulos";
        $data['query'] = $this->Catalogosweb_model->getArticulosLimit($cvesuministro, $config['per_page'], $this->uri->segment(4));
        //$data['js'] = "catalogosweb/productos_por_secuencia_js";
        $this->load->view('main', $data);
    }
    
    function cliente()
    {
        $data['subtitulo'] = "Catalogo de Clientes";
        $data['query'] = $this->Catalogosweb_model->getClientes();
        //$data['js'] = "catalogosweb/productos_por_secuencia_js";
        $this->load->view('main', $data);
    }

    function nuevo_cliente()
    {
        $data['subtitulo'] = "Nuevo Cliente";
        //$data['js'] = "catalogosweb/productos_por_secuencia_js";
        $this->load->view('main', $data);
    }

    function nuevo_cliente_submit()
    {
        $busca = $this->input->post('busca');
        
        if(strlen($busca) > 0)
        {
            $query = $this->util->getDataOficina('clienteBusca', array('busca' => $busca));
        }
        $data['subtitulo'] = "Nuevo Cliente: Resultado de la busqueda";
        $data['query'] = $query;
        $data['js'] = "catalogosweb/nuevo_cliente_submit_js";
        $this->load->view('main', $data);
    }
    
    function agregarCliente()
    {
        $rfc = $this->input->post('rfc');
        $cliente = $this->util->getDataOficina('cliente', array('rfc' => $rfc));
        
        
        if(!isset($cliente->error))
        {
            foreach($cliente as $a)
            {
                echo $this->Catalogosweb_model->insertaCliente($a);
            }
            
        }else{
            echo 0;
        }
    }
    
    function contrato($rfc)
    {
        $data['subtitulo'] = "Catalogo de Contratos por cliente";
        $data['query'] = $this->Catalogosweb_model->getContrato($rfc);
        $data['rfc'] = $rfc;
        //$data['js'] = "catalogosweb/productos_por_secuencia_js";
        $this->load->view('main', $data);
    }

    function nuevo_contrato($rfc)
    {
        $data['subtitulo'] = "Nuevo Contrato: " . $rfc;
        $data['rfc'] = $rfc;
        //$data['js'] = "catalogosweb/productos_por_secuencia_js";
        $this->load->view('main', $data);
    }
    
    function nuevo_contrato_submit()
    {
        $rfc = $this->input->post('rfc');
        $numero = $this->input->post('numero');
        $denominado = $this->input->post('denominado');
        $this->Catalogosweb_model->insertContrato($rfc, $numero, $denominado);
        redirect('catalogosweb/contrato/' . $rfc);
    }

    function contrato_editar($rfc, $contratoID)
    {
        $data['subtitulo'] = "Editar Contrato: " . $rfc;
        $data['rfc'] = $rfc;
        $data['contratoID'] = $contratoID;
        $data['query'] = $this->Catalogosweb_model->getContratoByContratoID($contratoID);
        //$data['js'] = "catalogosweb/productos_por_secuencia_js";
        $this->load->view('main', $data);
    }
    
    function contrato_editar_submit()
    {
        $contratoID = $this->input->post('contratoID');
        $numero = $this->input->post('numero');
        $denominado = $this->input->post('denominado');
        $rfc = $this->input->post('rfc');
        $referencia_factura = $this->input->post('referencia_factura');
        
        $this->Catalogosweb_model->updateContrato($contratoID, $numero, $denominado, $referencia_factura);
        redirect('catalogosweb/contrato/'.$rfc);
    }
    
    function contrato_precios($rfc, $contratoID)
    {
        $data['subtitulo'] = "Editar Precios: " . $rfc;
        $data['rfc'] = $rfc;
        $data['contratoID'] = $contratoID;
        $this->Catalogosweb_model->insertaArticuloContratoPrecio($contratoID);
        $data['query'] = $this->Catalogosweb_model->getContratoPrecioByContratoID($contratoID);
        $data['query2'] = $this->Catalogosweb_model->getContratoByContratoID($contratoID);
        $data['js'] = "catalogosweb/contrato_precios_js";
        $this->load->view('main', $data);
    }
    
    function saveContratoPrecio()
    {
        $contratoPrecioID = $this->input->post('contratoPrecioID');
        $precioContrato = $this->input->post('precioContrato');
        
        $this->Catalogosweb_model->saveContratoPrecio($contratoPrecioID, $precioContrato);
    }
    
    function contrato_sucursal($rfc)
    {
        $data['subtitulo'] = 'Anexar sucursal al cliente: <span id="rfc">' . $rfc . '</span>';
        $data['rfc'] = $rfc;
        $data['query'] = $this->Catalogosweb_model->getContratoPrecioByContratoID($rfc);
        $data['js'] = "catalogosweb/contrato_sucursal_js";
        $this->load->view('main', $data);
    }
    
    function showSucursalesCliente()
    {
        $rfc = $this->input->post('rfc');
        $data['query'] = $this->Catalogosweb_model->getSucursalesCliente($rfc);
        $this->load->view('catalogosweb/showSucursalesCliente', $data);
    }
    
    function contrato_sucursal_submit1()
    {
        $rfc = $this->input->post('rfc');
        $clvsucursal = $this->input->post('clvsucursal');
        
        $this->Catalogosweb_model->insertSucursalCliente($rfc, $clvsucursal);
    }

    function contrato_sucursal_submit2()
    {
        $rfc = $this->input->post('rfc');
        $clvsucursal1 = $this->input->post('clvsucursal1');
        $clvsucursal2 = $this->input->post('clvsucursal2');
        
        $this->Catalogosweb_model->insertSucursalCliente2($rfc, $clvsucursal1, $clvsucursal2);
    }
    
    function clienteSucursalEliminar($receptorSucursalID)
    {
        $this->Catalogosweb_model->eliminaReceptorSucursalID($receptorSucursalID);
    }

    function prueba()
    {
        $query = $this->Catalogosweb_model->getContratoByContratoID(1);
        $row = $query->row();
        
        $licitacion = $row->numero;
        $sucursal = "HOSPITAL BASICO COMUNITARIO DE TAMAZULAPAN DEL ESPIRITU SANTO";
        $string = $row->referencia_factura;
        
        $este = array('$licitacion');
        $por = array($licitacion);
        
        $string = str_replace($este, $por, $string);
        
        echo $string;
    }
    
    function nuevo_articulo_submit()
    {
        $clave = $this->input->post('clave');
        $susa = $this->input->post('susa');
        $clave = str_replace('/', '|', $clave);
        
        if(PATENTE == 1)
        {
            if(strlen($clave) > 0)
            {
                $query = $this->util->getDataOficina('patente', array('ean' => $clave));
            }else{
                $query = $this->util->getDataOficina('patenteDescripcion', array('descripcion' => $susa));
            }
        }else{
            
            if(strlen($clave) > 0)
            {
                $query = $this->util->getDataOficina('articuloClave', array('clave' => $clave));
            }else{
                $query = $this->util->getDataOficina('articuloSusa', array('susa' => $susa));
            }
        }
        
        $data['subtitulo'] = "Nuevo Articulo: Resultado de la busqueda";
        $data['query'] = $query;
        $data['js'] = "catalogosweb/nuevo_articulo_submit_js";
        $this->load->view('main', $data);
    }
    
    function agregarArticulo()
    {
        $clave = $this->input->post('clave');
        $clave = str_replace('/', '|', $clave);
        $articulo = $this->util->getDataOficina('articuloClave', array('clave' => $clave));
        
        
        if(!isset($articulo->error))
        {
            foreach($articulo as $a)
            {
                echo $this->Catalogosweb_model->insertaArticulo($a);
            }
            
        }else{
            echo 0;
        }
    }
    
    function agregarArticulo2()
    {
        $ean = $this->input->post('clave');
        $origen = $this->input->post('origen');
        $articulo = $this->util->getDataOficina('patenteOrigen', array('ean' => $ean, 'origen' => $origen));
        
        if(!isset($articulo->error))
        {
            foreach($articulo as $a)
            {
                echo $this->Catalogosweb_model->insertaArticulo2($a);
            }
            
        }else{
            echo 0;
        }
    }
    
    function agregaMasivo()
    {
        if(PATENTE == 1)
        {
            $query = $this->db->get('tmp_codigos');
            
            foreach($query->result() as $row)
            {
                $articulo = $this->util->getDataOficina('patenteSinOrigen', array('ean' => $row->codigo));
                if(!isset($articulo->error))
                {
                    foreach($articulo as $a)
                    {
                        echo $this->Catalogosweb_model->insertaArticulo2($a);
                    }
                    
                }else{
                    echo 0;
                }
            }
        }
        
    }
    
    function agregaMasivo2()
    {
        if(PATENTE == 1)
        {
            $sql = "SELECT ean FROM tmp_inv t where ean not in(select cvearticulo from articulos) group by ean;";
            $query = $this->db->query($sql);
            
            foreach($query->result() as $row)
            {
                $articulo = $this->util->getDataOficina('patenteSinOrigen', array('ean' => $row->ean));
                if(!isset($articulo->error))
                {
                    foreach($articulo as $a)
                    {
                        echo $this->Catalogosweb_model->insertaArticulo3($a);
                    }
                    
                }else{
                    echo 0;
                }
            }
        }
        
    }

    function nuevo_articulo()
    {
        $data['subtitulo'] = "Nuevo Articulo";
        //$data['js'] = "catalogosweb/productos_por_secuencia_js";
        $this->load->view('main', $data);
    }
    
    function proveedor()
    {
        $data['subtitulo'] = "Catalogo de proveedores";
        $data['query'] = $this->Catalogosweb_model->getProveedor();
        //$data['js'] = "catalogosweb/productos_por_secuencia_js";
        $this->load->view('main', $data);
    }
    
    function proveedor_nuevo()
    {
        $data['subtitulo'] = "Nuevo Proveedor";
        $data['js'] = "catalogosweb/proveedor_js";
        $data['json'] = json_encode($this->util->getDataOficina('proveedor', array()));
        $this->load->view('main', $data);
    }
    
    function proveedor_nuevo_submit()
    {
        $rfc = trim($this->input->post('rfc'));
        $razon = trim($this->input->post('razon'));
        $proveedorID = $this->input->post('proveedorID');
        $this->Catalogosweb_model->insertProveedor($rfc, $razon, $proveedorID);
        redirect('catalogosweb/proveedor');
    }
    
    function proveedor_edita($proveedorID)
    {
        $data['subtitulo'] = "Nuevo Proveedor";
        $data['js'] = "catalogosweb/proveedor_js";
        $data['query'] = $this->Catalogosweb_model->getProveedorByID($proveedorID);
        $data['json'] = $this->Catalogosweb_model->getJsonProveedor();
        $this->load->view('main', $data);
    }

    function proveedor_edita_submit()
    {
        $rfc = trim($this->input->post('rfc'));
        $razon = trim($this->input->post('razon'));
        $proveedorID = $this->input->post('proveedorID');
        $this->Catalogosweb_model->actualizaProveedor($rfc, $razon, $proveedorID);
        redirect('catalogosweb/proveedor');
    }

    function sucursal()
    {
        $data['subtitulo'] = "Catalogo de sucursales";
        $data['query'] = $this->Catalogosweb_model->getSucursal();
        //$data['js'] = "catalogosweb/productos_por_secuencia_js";
        $this->load->view('main', $data);
    }

    function sucursal_nuevo()
    {
        $data['subtitulo'] = "Nueva sucursal";
        $data['js'] = "catalogosweb/sucursal_js";
        $data['juris'] = $this->util->getJurisCombo();
        $this->load->view('main', $data);
    }

    function sucursal_nuevo_submit()
    {
        $clvsucursal = trim($this->input->post('clvsucursal'));
        $descsucursal = trim($this->input->post('descsucursal'));
        $numjurisd = $this->input->post('numjurisd');
        $this->Catalogosweb_model->insertSucursal($clvsucursal, $descsucursal, $numjurisd);
        redirect('catalogosweb/sucursal');
    }

    function sucursal_edita($clvsucursal)
    {
        $data['subtitulo'] = "Edita Sucursal";
        $data['js'] = "catalogosweb/sucursal_js";
        $data['query'] = $this->Catalogosweb_model->getSucursalByClvsucursal($clvsucursal);
        $data['query2'] = $this->Catalogosweb_model->getSucursalExtByClvsucursal($clvsucursal);
        $data['juris'] = $this->util->getJurisCombo();
        $this->load->view('main', $data);
    }

    function sucursal_edita_submit()
    {
        //nombreSucursalPersonalizado, domicilioSucursalPersonalizado
        $clvsucursal = trim($this->input->post('clvsucursal'));
        $nombreSucursalPersonalizado = trim($this->input->post('nombreSucursalPersonalizado'));
        $domicilioSucursalPersonalizado = trim($this->input->post('domicilioSucursalPersonalizado'));
        $numjurisd = $this->input->post('numjurisd');
        $this->Catalogosweb_model->actualizaSucursal($clvsucursal, $numjurisd, $nombreSucursalPersonalizado, $domicilioSucursalPersonalizado);
        redirect('catalogosweb/sucursal');
    }

    function usuario()
    {
        $data['subtitulo'] = "Catalogo de usuarios";
        $data['query'] = $this->Catalogosweb_model->getUsuario();
        //$data['js'] = "catalogosweb/productos_por_secuencia_js";
        $this->load->view('main', $data);
    }

    function usuario_nuevo()
    {
        $data['subtitulo'] = "Nuevo usuario";
        $data['js'] = "catalogosweb/usuario_js";
        $data['sucursal'] = $this->util->getSucursalesCombo();
        $data['puesto'] = $this->util->getPuestoCombo();
        $data['activo'] = $this->util->getActivoCombo();
        $this->load->view('main', $data);
    }

    function usuario_nuevo_submit()
    {
        $clvusuario = trim($this->input->post('clvusuario'));
        $password = trim($this->input->post('password'));
        $nombreusuario = trim($this->input->post('nombreusuario'));
        $clvsucursal = $this->input->post('clvsucursal');
        $clvpuesto = $this->input->post('clvpuesto');
        $estaactivo = $this->input->post('estaactivo');
        $this->Catalogosweb_model->insertUsuario($clvusuario, $password, $nombreusuario, $clvsucursal, $clvpuesto, $estaactivo);
        redirect('catalogosweb/usuario');
    }

    function usuario_edita($usuario)
    {
        $data['subtitulo'] = "Edita usuario";
        $data['js'] = "catalogosweb/usuario_js";
        $data['sucursal'] = $this->util->getSucursalesCombo();
        $data['puesto'] = $this->util->getPuestoCombo();
        $data['activo'] = $this->util->getActivoCombo();
        $data['query'] = $this->Catalogosweb_model->getUsuarioByUsuario($usuario);
        $this->load->view('main', $data);
    }

    function usuario_edita_submit()
    {
        $clvusuario = trim($this->input->post('clvusuario'));
        $password = trim($this->input->post('password'));
        $nombreusuario = trim($this->input->post('nombreusuario'));
        $clvsucursal = $this->input->post('clvsucursal');
        $clvpuesto = $this->input->post('clvpuesto');
        $estaactivo = $this->input->post('estaactivo');
        $usuario = $this->input->post('usuario');
        $this->Catalogosweb_model->actualizaUsuario($clvusuario, $password, $nombreusuario, $clvsucursal, $clvpuesto, $estaactivo, $usuario);
        redirect('catalogosweb/usuario');
    }
    
    function actualiza()
    {
        $this->load->model('login_model');
        $data['subtitulo'] = "Actualiza Catalogos";
        $data['js'] = "catalogosweb/usuario_js";
        $this->load->view('main', $data);
    }

    function actualizaManual()
    {
        $this->load->model('login_model');
        $data['subtitulo'] = "Actualiza Catalogos manualmente";
        $this->load->view('main', $data);
    }

	function do_upload_articulos()
	{
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'txt|oaxaca';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload())
		{
			$error = array('error' => $this->upload->display_errors());
            $this->session->set_flashdata('error', $error);
            redirect('catalogosweb/actualizaManual');
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
            $this->__parseFile($data['upload_data']['full_path'], 'articulos');
            $this->session->set_flashdata('error', 'Archivo subido correctamente');
            redirect('catalogosweb/actualizaManual');
		}
	}
    
	function do_upload_sucursales()
	{
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'txt|oaxaca';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload())
		{
			$error = array('error' => $this->upload->display_errors());
            $this->session->set_flashdata('error', $error);
            redirect('catalogosweb/actualizaManual');
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
            $this->__parseFile($data['upload_data']['full_path'], 'sucursales');
            $this->session->set_flashdata('error', 'Archivo subido correctamente');
            redirect('catalogosweb/actualizaManual');
		}
	}

	function do_upload_usuarios()
	{
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'txt|oaxaca';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload())
		{
			$error = array('error' => $this->upload->display_errors());
            $this->session->set_flashdata('error', $error);
            redirect('catalogosweb/actualizaManual');
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
            $this->__parseFile($data['upload_data']['full_path'], 'usuarios');
            $this->session->set_flashdata('error', 'Archivo subido correctamente');
            redirect('catalogosweb/actualizaManual');
		}
	}

    function __actualizacion($tabla)
    {
        $data = array('tabla' => $tabla);
        $this->db->set('ultima_actualizacion', 'now()', false);
        $this->db->replace('actualizacion', $data);
    }

    function __parseFile($file, $tabla)
    {
        $this->load->helper('file');
        $this->load->library('encrypt');
        $this->load->library('Services_JSON');
        
        $string = read_file($file);
        
        $json = $this->encrypt->decode($string);
        
        $j = new Services_JSON();
        
        $arreglo = $j->decode($json);
        
        foreach($arreglo as $row)
        {
            $this->db->replace($tabla, $row);
            $this->__actualizacion($tabla);
        }        
    }
    
    function exportar()
    {
        $data['subtitulo'] = "Exportar datos";
        $data['js'] = "catalogosweb/exportar_js";
        $this->load->view('main', $data);
    }
    
    function exportar_submit()
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        
        $this->load->helper('download');
        $this->load->library('Services_JSON');
        $this->load->library('encrypt');
        
        $fecha1 = $this->input->post('fecha1');
        $fecha2 = $this->input->post('fecha2');
        
        $a = array('clvsucursal' => SUCURSAL);
        
        $a['inventario'] = $this->Catalogosweb_model->getInventarioExportar();
        $a['kardex'] = $this->Catalogosweb_model->getKardexExportar($fecha1, $fecha2);
        $a['movimiento'] = $this->Catalogosweb_model->getMovimientoExportar($fecha1, $fecha2);
        $a['movimientoDetalle'] = $this->Catalogosweb_model->getMovimientoDetalleExportar($fecha1, $fecha2);
        $a['movimientoEmbarque'] = $this->Catalogosweb_model->getMovimientoEmbarqueExportar($fecha1, $fecha2);
        $a['receta'] = $this->Catalogosweb_model->getRecetaExportar($fecha1, $fecha2);
        $a['recetaDetalle'] = $this->Catalogosweb_model->getRecetaDetalleExportar($fecha1, $fecha2);
        $a['devolucion'] = $this->Catalogosweb_model->getDevolucionExportar($fecha1, $fecha2);
        $a['proveedor'] = $this->Catalogosweb_model->getProveedorExportar();
        
         $j = new Services_JSON();
         $string = $j->encode($a);
         
        //$data = $this->encrypt->encode($string);
        
        $fecha = date('YmdHis');
        
        $name = 'descarga_'.SUCURSAL.'_'.$fecha1.'_'.$fecha2.'_'.$fecha.'.txt';
        
        force_download($name, $string); 
        
    }
    
    function domicilio()
    {
        $data['subtitulo'] = "Establecer Domicilio";
        $data['query'] = $this->Catalogosweb_model->getDomicilio();
        $this->load->view('main', $data);
    }
    
    function domicilio_submit()
    {
        $domicilio = $this->input->post('domicilio');
        $data = array('idDomicilio' => 1, 'domicilio' => strtoupper($domicilio));
        $this->db->replace('sucursal_domicilio', $data);
        redirect('workspace');
    }
    
}
