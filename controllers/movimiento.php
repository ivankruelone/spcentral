<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Movimiento extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        if (!Current_User::user()) {
            redirect('welcome');
        }

        $this->load->model('movimiento_model');
        $this->load->helper('utilities');

    }
    
    function index($tipoMovimiento, $subtipoMovimiento)
    {
        $this->load->library('pagination');
        $data['subtitulo'] = "Movimientos";
        $data['tipoMovimiento'] = $tipoMovimiento;
        $data['subtipoMovimiento'] = $subtipoMovimiento;
        
        $config['base_url'] = site_url('movimiento/index/'.$tipoMovimiento.'/'.$subtipoMovimiento);
        $config['total_rows'] = $this->movimiento_model->getMovimientosCuenta($tipoMovimiento, $subtipoMovimiento);
        $config['per_page'] = 50;
        $config['uri_segment'] = 5;
        
        $data['query'] = $this->movimiento_model->getMovimientos($tipoMovimiento, $subtipoMovimiento, $config['per_page'], $this->uri->rsegment(5));

        $this->pagination->initialize($config); 
        
        $this->load->view('main', $data);
    }

    function nuevo($tipoMovimiento, $subtipoMovimiento)
    {
        $this->util->actArticulo();
        $data['subtitulo'] = "Nuevo Movimiento";
        $data['tipoMovimiento'] = $tipoMovimiento;
        $data['subtipoMovimiento'] = $subtipoMovimiento;
        $data['sucursales'] = $this->util->getSucursalesCombo();
        $data['proveedores'] = $this->util->getProveedorCombo();
        $data['js'] = "movimiento/nuevo_js";
        $this->load->view('main', $data);
    }
    
    function actualizaArticulo()
    {
        $this->util->actArticulo();
        echo "Listo";
        echo "<br />";
        echo "Cierra esta ventana";
    }
    
    function nuevo_submit()
    {
        $tipoMovimiento = $this->input->post('tipoMovimiento');
        $subtipoMovimiento = $this->input->post('subtipoMovimiento');
        $fecha = $this->input->post('fecha');
        $fecha = $this->input->post('fecha');
        $orden = $this->input->post('orden');
        $referencia = $this->input->post('referencia');
        $remision = $this->input->post('remision');
        $sucursal_referencia = $this->input->post('sucursal_referencia');
        $proveedor = $this->input->post('proveedor');
        $observaciones = $this->input->post('observaciones');
        
        $this->movimiento_model->insertMovimiento($tipoMovimiento, $subtipoMovimiento, $fecha, $orden, $referencia, $sucursal_referencia, $proveedor, $observaciones, $remision);
        redirect('movimiento/index/'.$tipoMovimiento.'/'.$subtipoMovimiento);
    }
    
    function edita($movimientoID)
    {
        $data['subtitulo'] = "Nuevo Movimiento";
        $data['sucursales'] = $this->util->getSucursalesCombo();
        $data['proveedores'] = $this->util->getProveedorCombo();
        $data['query'] = $this->movimiento_model->getMovimiento($movimientoID);
        $data['js'] = "movimiento/nuevo_js";
        $this->load->view('main', $data);
    }

    function edita_submit()
    {
        $movimientoID = $this->input->post('movimientoID');
        $tipoMovimiento = $this->input->post('tipoMovimiento');
        $subtipoMovimiento = $this->input->post('subtipoMovimiento');
        $fecha = $this->input->post('fecha');
        $fecha = $this->input->post('fecha');
        $orden = $this->input->post('orden');
        $referencia = $this->input->post('referencia');
        $sucursal_referencia = $this->input->post('sucursal_referencia');
        $proveedor = $this->input->post('proveedor');
        $observaciones = $this->input->post('observaciones');
        
        $this->movimiento_model->updateMovimiento($tipoMovimiento, $subtipoMovimiento, $fecha, $orden, $referencia, $sucursal_referencia, $proveedor, $observaciones, $movimientoID);
        redirect('movimiento/index/'.$tipoMovimiento.'/'.$subtipoMovimiento);
    }

    function captura($movimientoID)
    {
        $data['subtitulo'] = "Captura de Movimiento";
        $data['sucursales'] = $this->util->getSucursalesCombo();
        $data['proveedores'] = $this->util->getProveedorCombo();
        $data['query'] = $this->movimiento_model->getMovimientoByMovimientoID($movimientoID);
        $data['json'] = json_encode($this->util->getDataOficina('laboratorio', array()));
        $data['js'] = "movimiento/captura_js";
        $this->load->view('main', $data);
    }
    
    function validaArea()
    {
        $movimientoID = $this->input->post('movimientoID');
        $areaID = $this->input->post('areaID');
        
        redirect('movimiento/transfer/'.$movimientoID.'/'.$areaID);
    }
    
    function transfer($movimientoID, $areaID)
    {
        $data['subtitulo'] = "Captura de Transferencia";
        $data['areaID'] = $areaID;
        $data['movimientoID'] = $movimientoID;
        
        $data['areas'] = $this->movimiento_model->getAreaIDDropdown();
        $data['query'] = $this->movimiento_model->getMovimientoByMovimientoID($movimientoID);
        $data['query2'] = $this->movimiento_model->getInventarioBySubtipoMovimiento($movimientoID, $areaID);
        
        
        //$data['json'] = json_encode($this->util->getDataOficina('laboratorio', array()));
        $data['js'] = "movimiento/transfer_js";
        $this->load->view('main', $data);
    }
    
    function transferParcial()
    {
        $movimientoID = $this->input->post('movimientoID');
        $inventarioID = $this->input->post('inventarioID');
        $valor = $this->input->post('valor');
        
        $this->movimiento_model->transferAplica($movimientoID, $inventarioID, $valor);
    }
    
    function prepedido($movimientoID)
    {
        $data['subtitulo'] = "Pre-pedido";
        $data['sucursales'] = $this->util->getSucursalesCombo();
        $data['proveedores'] = $this->util->getProveedorCombo();
        $data['query'] = $this->movimiento_model->getMovimientoByMovimientoID($movimientoID);
        $data['json'] = json_encode($this->util->getDataOficina('laboratorio', array()));
        $data['js'] = "movimiento/prepedido_js";
        $this->load->view('main', $data);
    }

    function busca_articulo()
    {
        $term = $this->input->get_post('term');
        echo $this->movimiento_model->getArticulosJSON($term);
    }
    
    function busca_proveedor()
    {
        $term = $this->input->get_post('term');
        echo $this->movimiento_model->getProveedorJSON($term);
    }

    function busca_sucursal()
    {
        $term = $this->input->get_post('term');
        echo $this->movimiento_model->getSucursalJSON($term);
    }

    function articuloValida()
    {
        $articulo = $this->input->post('articulo');
        $orden = $this->input->post('orden');
        echo $this->movimiento_model->getArticuloDatos($articulo, $orden);
    }
    
    function getEANMarca()
    {
        $ean = $this->input->post('ean');
        echo $this->movimiento_model->getMarca($ean);
    }
    
    function detalle()
    {
        $movimientoID = $this->input->post('movimientoID');
        $data['query'] = $this->movimiento_model->getDetalle($movimientoID);
        $data['movimientoID'] = $movimientoID;
        $this->load->view('movimiento/detalle', $data);
    }
    
    function detallePrepedido()
    {
        $movimientoID = $this->input->post('movimientoID');
        $data['query'] = $this->movimiento_model->getDetallePrepedido($movimientoID);
        $data['movimientoID'] = $movimientoID;
        $this->load->view('movimiento/detallePrepedido', $data);
    }

    function modifica($movimientoDetalle, $movimientoID)
    {
        $data['subtitulo'] = "Modificar clave de entrada";
        $data['query'] = $this->movimiento_model->getDetalleByMovimientoDetalle($movimientoDetalle);
        $data['movimientoID'] = $movimientoID;
        $this->load->view('main', $data);
    }
    
    function modifica_submit()
    {
        $movimientoID = $this->input->post('movimientoID');
        $movimientoDetalle = $this->input->post('movimientoDetalle');
        $piezas = $this->input->post('piezas');
        $costo = $this->input->post('costo');
        $lote = $this->input->post('lote');
        $caducidad = $this->input->post('caducidad');
        $ean = $this->input->post('ean');
        $marca = $this->input->post('marca');
        
        $data = array(
            'piezas' => $piezas,
            'costo' => $costo,
            'lote' => $lote,
            'caducidad' => $caducidad,
            'ean' => $ean,
            'marca' => $marca
            );
            
        $this->movimiento_model->modificaDetalle($data, $movimientoDetalle);
        redirect('movimiento/captura/'.$movimientoID);

    }

    function elimina_detalle($movimientoDetalle)
    {
        $this->movimiento_model->eliminaDetalle($movimientoDetalle);
    }
    
    function elimina_detalle_prepedido($movimientoPrepedido)
    {
        $this->movimiento_model->eliminaDetallePrepedido($movimientoPrepedido);
    }

    function cargaLotes()
    {
        $articulo = $this->input->post('articulo');
        $subtipoMovimiento = $this->input->post('subtipoMovimiento');
        
        if($subtipoMovimiento == 6 || $subtipoMovimiento == 7)
        {
            $query = $this->movimiento_model->getLotes($articulo);
        }else{
            $query = $this->movimiento_model->getLotes($articulo);
        }
        
        
        
        $a = null;
        
        foreach($query->result() as $row)
        {
            $a .= '<option value="'.$row->inventarioID.'">'.$row->lote.' - '.$row->caducidad.' ('.$row->cantidad.')</option>
            ';
        }
        
        echo $a;
    }
    
    function cargaLotesOpcion2()
    {
        $articulo = $this->input->post('articulo');
        $query = $this->movimiento_model->getLotes($articulo);
        
        $a = '<option value="TODOS">TODOS</option>
        ';
        
        foreach($query->result() as $row)
        {
            $a .= '<option value="'.$row->lote.'">'.$row->lote.' - '.$row->caducidad.' ('.$row->cantidad.')</option>
            ';
        }
        
        echo $a;
    }

    function captura_submit()
    {
        $movimientoID = $this->input->post('movimientoID');
        $articulo = $this->input->post('articulo');
        $piezas = $this->input->post('piezas');
        $lote = $this->input->post('lote');
        $caducidad = $this->input->post('caducidad');
        $ean = $this->input->post('ean');
        $costo = $this->input->post('costo');
        $marca = $this->input->post('marca');
        $ubicacion = $this->input->post('ubicacion');
        $comercial = $this->input->post('comercial');
        
        $var1 = explode('|', $articulo);
        $id = $var1[0];
        
        $this->movimiento_model->insertDetalle($movimientoID, $id, $piezas, $costo, $lote, $caducidad, $ean, $marca, $ubicacion, $comercial);
        
    }
    
    function captura_submit2()
    {
        $movimientoID = $this->input->post('movimientoID');
        $inventarioID = $this->input->post('inventarioID');
        $piezas = $this->input->post('piezas');
        
        $this->movimiento_model->insertDetalle2($movimientoID, $inventarioID, $piezas);
        
    }
    
    function captura_submit3()
    {
        $cveArticulo = $this->input->post('cvearticulo');
        $movimientoID = $this->input->post('movimientoID');
        $piezas = $this->input->post('piezas');
        
        $this->movimiento_model->insertDetalle3($movimientoID, $cveArticulo, $piezas);
        
    }

    function cierrePrepedido($movimientoID, $tipoMovimiento, $subtipoMovimiento)
    {
        $this->movimiento_model->cierrePrepedido($movimientoID);
        redirect('movimiento/index/'.$tipoMovimiento.'/'.$subtipoMovimiento);
    }
    
    function evaluaCierre($movimientoID, $tipoMovimiento, $subtipoMovimiento)
    {
        $sql = "SELECT m.movimientoDetalle, m.movimientoID, m.id, sum(m.piezas) as piezas, m.costo, m.lote, m.caducidad, m.ean, m.marca, ifnull(i.cantidad, 'NADA') as cantidad, o.tipoMovimiento, o.subtipoMovimiento, inventarioID, m.ubicacion, m.comercial
FROM movimiento_detalle m
join movimiento o using(movimientoID)
left join inventario i on m.id = i.id and m.lote = i.lote and m.ubicacion = i.ubicacion
where m.movimientoID = ? and piezas > 0
group by id, lote, i.ubicacion
having piezas > cantidad
limit 1;";
        
        $query = $this->db->query($sql, $movimientoID);
        
        if($query->num_rows() == 1)
        {
            $row = $query->row();
            
            $this->session->set_flashdata('error', 'El detalle: ' . $row->movimientoDetalle . ', no se puede cerrar debido a que la salida ' . $row->piezas . ' es mayor a la cantidad en el inventario ' . $row->cantidad . ', en el lote: ' .$row->lote . '.');
            
            redirect('movimiento/captura/'.$movimientoID);
        }
        
    }

    function cierre($movimientoID, $tipoMovimiento, $subtipoMovimiento)
    {
        if($tipoMovimiento == 2)
        {
            $this->evaluaCierre($movimientoID, $tipoMovimiento, $subtipoMovimiento);
        }
        
        $this->db->trans_start();
        
        if($subtipoMovimiento == 15)
        {
            $sql_pon_a_cero = "update 
            inventario 
            set cantidad = 0, tipoMovimiento = ?, subtipoMovimiento = ?, ultimo_movimiento = now(), receta = 0, movimientoID = ?, usuario = ? 
            where clvsucursal = ? and cantidad <> 0;";
            $this->db->query($sql_pon_a_cero, array($tipoMovimiento, $subtipoMovimiento, $movimientoID, $this->session->userdata('usuario'), $this->session->userdata('clvsucursal')));
            
        }
        
        $sql1 = "SELECT m.movimientoDetalle, m.movimientoID, m.id, sum(m.piezas) as piezas, m.costo, m.lote, m.caducidad, m.ean, m.marca, ifnull(i.cantidad, 'NADA') as cantidad, o.tipoMovimiento, o.subtipoMovimiento, inventarioID, m.ubicacion, m.comercial
FROM movimiento_detalle m
join movimiento o using(movimientoID)
left join inventario i on m.id = i.id and m.lote = i.lote and m.ubicacion = i.ubicacion
where m.movimientoID = ? and piezas > 0 and statusMovimiento = 0
group by id, lote, i.ubicacion;";
        
        $query1 = $this->db->query($sql1, $movimientoID);
        
        foreach($query1->result() as $row1)
        {
            if($row1->cantidad == 'NADA')
            {
                if((int)$row1->tipoMovimiento == 1)
                {
                    $data = array(
                        'id' => $row1->id,
                        'lote' => $row1->lote,
                        'caducidad' => $row1->caducidad,
                        'cantidad' => $row1->piezas,
                        'tipoMovimiento' => $row1->tipoMovimiento,
                        'subtipoMovimiento' => $row1->subtipoMovimiento,
                        'receta' => 0,
                        'usuario' => $this->session->userdata('usuario'),
                        'movimientoID' => $row1->movimientoID,
                        'ean' => $row1->ean,
                        'marca' => $row1->marca,
                        'costo' => $row1->costo,
                        'clvsucursal' => $this->session->userdata('clvsucursal'),
                        'ubicacion' => $row1->ubicacion,
                        'comercial' => $row1->comercial
                        );
                    
                    $this->db->set('ultimo_movimiento', 'now()', false);
                    $this->db->insert('inventario', $data);
                    
                }elseif((int)$row1->tipoMovimiento == 2)
                {
                    $cantidad  = ((int)0 - (int)$row1->piezas);
                    $data = array(
                        'id' => $row1->id,
                        'lote' => $row1->lote,
                        'caducidad' => $row1->caducidad,
                        'cantidad' => $cantidad,
                        'tipoMovimiento' => $row1->tipoMovimiento,
                        'subtipoMovimiento' => $row1->subtipoMovimiento,
                        'receta' => 0,
                        'usuario' => $this->session->userdata('usuario'),
                        'movimientoID' => $row1->movimientoID,
                        'clvsucursal' => $this->session->userdata('clvsucursal'),
                        'ubicacion' => $row1->ubicacion,
                        'comercial' => $row1->comercial
                        );
                        
                    $this->db->set('ultimo_movimiento', 'now()', false);
                    $this->db->insert('inventario', $data);
                    
                }
            }else{
                if((int)$row1->tipoMovimiento == 1)
                {
                    $cantidad = ((int)$row1->cantidad + (int)$row1->piezas);
                    $data = array(
                        'id' => $row1->id,
                        'lote' => $row1->lote,
                        'caducidad' => $row1->caducidad,
                        'cantidad' => $cantidad,
                        'tipoMovimiento' => $row1->tipoMovimiento,
                        'subtipoMovimiento' => $row1->subtipoMovimiento,
                        'receta' => 0,
                        'usuario' => $this->session->userdata('usuario'),
                        'movimientoID' => $row1->movimientoID,
                        'ean' => $row1->ean,
                        'marca' => $row1->marca,
                        'costo' => $row1->costo,
                        'clvsucursal' => $this->session->userdata('clvsucursal'),
                        'ubicacion' => $row1->ubicacion,
                        'comercial' => $row1->comercial
                        );
                        
                    $this->db->set('ultimo_movimiento', 'now()', false);
                    $this->db->update('inventario', $data, array('inventarioID' => $row1->inventarioID));

                }elseif((int)$row1->tipoMovimiento == 2)
                {
                    $cantidad = ((int)$row1->cantidad - (int)$row1->piezas);
                    $data = array(
                        'id' => $row1->id,
                        'lote' => $row1->lote,
                        'caducidad' => $row1->caducidad,
                        'cantidad' => $cantidad,
                        'tipoMovimiento' => $row1->tipoMovimiento,
                        'subtipoMovimiento' => $row1->subtipoMovimiento,
                        'receta' => 0,
                        'usuario' => $this->session->userdata('usuario'),
                        'movimientoID' => $row1->movimientoID,
                        'clvsucursal' => $this->session->userdata('clvsucursal'),
                        'ubicacion' => $row1->ubicacion,
                        'comercial' => $row1->comercial
                        );
                        
                    $this->db->set('ultimo_movimiento', 'now()', false);
                    $this->db->update('inventario', $data, array('inventarioID' => $row1->inventarioID));
                }
            }
            
            
            if((int)$row1->subtipoMovimiento == 1 || (int)$row1->subtipoMovimiento == 2 || (int)$row1->subtipoMovimiento == 3)
            {
                if((float)$row1->costo > 0)
                {
                    $data3 = array('ultimo_costo' => $row1->costo);
                    $this->db->update('articulos', $data3, array('id' => $row1->id));
                    
                }
            }
            
        }
        
        if((int)$row1->subtipoMovimiento == 1)
        {
            $folio = $this->util->getDataOficina('folio', array('foliador' => $this->session->userdata('cxp')));
        }else{
            $folio = new StdClass();
            $folio->folio = 0;
        }
        
        
        $data2  = array('statusMovimiento' => 1, 'nuevo_folio' => $folio->folio);
        $this->db->set('fechaCierre', 'now()', false);
        $this->db->update('movimiento', $data2, array('movimientoID' => $movimientoID));
        
        
        
        $this->db->trans_complete();
        
        
        if ($this->db->trans_status() === TRUE)
        {
            $json = $this->util->getOrdenPostJson($movimientoID);
            $res = $this->util->postDataOficina('orden', $json);
        
            if($res == null)
            {
                
            }else{
                $this->db->update('movimiento', array('aplicada' => 1), array('movimientoID' => $movimientoID));
            }
        
            $this->util->postMovimiento($movimientoID);
            $this->util->postInventario();// generate an error... or use the log_message() function to log your error
        } 
        
        
        redirect('movimiento/index/'.$tipoMovimiento.'/'.$subtipoMovimiento);
        
    }

    function sendData()
    {
        $json = $this->util->getOrdenPostJson(304);
        $res = $this->util->postDataOficina('orden', $json);
    }

    function imprime($movimientoID, $tipoMovimiento, $subtipoMovimiento)
    {
        set_time_limit(0);
        ini_set('memory_limit','-1');

        $data['header'] = $this->movimiento_model->header($movimientoID);
        //$data['detalle1'] = $this->pedidos_model->pedido_embarque($id);
        $data['detalle'] = $this->movimiento_model->detalle($movimientoID);/*HOJA DE PEDIDO */
        $data['formato'] = $this->movimiento_model->formato01($movimientoID);/*HOJA DE EMBARQUE*/
        $data['formato1'] = $this->movimiento_model->formato02($movimientoID);/*HOJA DE DEVOLUCIONES*/
        $data['tipoMovimiento'] = $tipoMovimiento;
        $data['movimientoID'] = $movimientoID;
        $data['subtipoMovimiento'] = $subtipoMovimiento;
      
        $this->load->view('impresiones/movimiento', $data);
    }

    function guia($movimientoID, $tipoMovimiento, $subtipoMovimiento)
    {
        set_time_limit(0);
        ini_set('memory_limit','-1');

        $data['header'] = $this->movimiento_model->header($movimientoID);
        //$data['detalle1'] = $this->pedidos_model->pedido_embarque($id);
        //$data['detalle'] = $this->movimiento_model->detalle($movimientoID);/*HOJA DE PEDIDO */
        $data['detalle'] = $this->movimiento_model->getAreasGuia($movimientoID);
        $data['tipoMovimiento'] = $tipoMovimiento;
        $data['movimientoID'] = $movimientoID;
        $data['subtipoMovimiento'] = $subtipoMovimiento;
      
        $this->load->view('impresiones/guia', $data);
    }

    function embarque($movimientoID, $tipoMovimiento, $subtipoMovimiento)
    {
        $data['subtitulo'] = "Datos de Embarque";
        $data['movimientoID'] = $movimientoID;
        $data['tipoMovimiento'] = $tipoMovimiento;
        $data['subtipoMovimiento'] = $subtipoMovimiento;
        $data['movimientoID'] = $movimientoID;
        $data['query'] = $this->movimiento_model->getEmbarque($movimientoID);
        $data['js'] = "movimiento/embarque_js";
        $this->load->view('main', $data);
    }
    
    function embarque_submit()
    {
        $movimientoID = $this->input->post('movimientoID');
        $tipoMovimiento = $this->input->post('tipoMovimiento');
        $subtipoMovimiento = $this->input->post('subtipoMovimiento');
        
        $embarco = $this->input->post('embarco');
        $operador = $this->input->post('operador');
        $unidad = $this->input->post('unidad');
        $placas = $this->input->post('placas');
        $cajas = $this->input->post('cajas');
        $hieleras = $this->input->post('hieleras');
        $surtio = $this->input->post('surtio');
        $valido = $this->input->post('valido');
        $observaciones = $this->input->post('observaciones');
        
        $this->movimiento_model->replaceEmbarque($movimientoID, $embarco, $operador, $unidad, $placas, $cajas, $hieleras, $surtio, $valido, $observaciones);
        redirect('movimiento/index/'.$tipoMovimiento.'/'.$subtipoMovimiento);
    }

    function devolucion($movimientoDetalle)
    {
        $data['subtitulo'] = "Devolucion de mercancia a paquete";
        $data['causas'] = $this->util->getDevolucionCausasCombo();
        $data['query'] = $this->movimiento_model->getDetalleByMovimientoDetalle($movimientoDetalle);
        $data['js'] = "movimiento/devolucion_js";
        $this->load->view('main', $data);
    }
    
    function devolucion_submit()
    {
        $this->db->trans_start();
        
        $movimientoID = $this->input->post('movimientoID');
        $movimientoDetalle = $this->input->post('movimientoDetalle');
        $devuelve = $this->input->post('devuelve');
        $causa = $this->input->post('causa');
        
        $data1 = array('movimientoDetalle' => $movimientoDetalle, 'devuelve' => $devuelve, 'causaID' => $causa, 'clvsucursal' => $this->session->userdata('clvsucursal'));
        
        $this->db->insert('devolucion', $data1);
        
        $query = $this->movimiento_model->getDetalleByMovimientoDetalle($movimientoDetalle);
        $row = $query->row();
        
        $piezasActuales = $row->piezas - $devuelve;
        
        $data2 = array('piezas' => $piezasActuales);
        
        $this->db->update('movimiento_detalle', $data2, array('movimientoDetalle' => $movimientoDetalle));
        
        
        $this->db->where('id', $row->id);
        $this->db->where('lote', $row->lote);
        $query3 = $this->db->get('inventario');
        
        if($query3->num_rows() > 0)
        {
            $row3 = $query3->row();

                    $data = array(
                        'id' => $row3->id,
                        'lote' => $row3->lote,
                        'caducidad' => $row3->caducidad,
                        'cantidad' => ($row3->cantidad + $devuelve),
                        'tipoMovimiento' => 1,
                        'subtipoMovimiento' => 17,
                        'receta' => 0,
                        'usuario' => $this->session->userdata('usuario'),
                        'movimientoID' => $movimientoID,
                        'ean' => $row3->ean,
                        'marca' => $row3->marca,
                        'costo' => $row3->costo,
                        'clvsucursal' => $this->session->userdata('clvsucursal')
                        );
                        
                    $this->db->update('inventario', $data, array('inventarioID' => $row3->inventarioID));
        }else{
                    $data = array(
                        'id' => $row->id,
                        'lote' => $row->lote,
                        'caducidad' => $row->caducidad,
                        'cantidad' => $devuelve,
                        'tipoMovimiento' => 1,
                        'subtipoMovimiento' => 17,
                        'receta' => 0,
                        'usuario' => $this->session->userdata('usuario'),
                        'movimientoID' => $movimientoID,
                        'ean' => $row->ean,
                        'marca' => $row->marca,
                        'costo' => $row->costo,
                        'clvsucursal' => $this->session->userdata('clvsucursal')
                        );
                    $this->db->insert('inventario', $data);
            
        }
        
        
        $this->db->trans_complete();
        
        if ($this->db->trans_status() === TRUE)
        {
            $this->util->postMovimiento($movimientoID);
            $this->util->postInventario();
        }
        
        redirect('movimiento/captura/'.$movimientoID);
        
    }
    
    function validaOrden()
    {
        $folprv = $this->input->post('orden');
        $data = $this->util->getDataOficina('orden', array('folprv' => $folprv));
        echo json_encode($data);
    }
    
    function getUbicaciones()
    {
        $cvearticulo = $this->input->post('cvearticulo');
        echo $this->util->getUbicacionesComboByClave($cvearticulo);
    }
    
    function prueba()
    {
        $this->util->postFacturar(43, 1);
    }
    
    function asigna_factura($movimientoID, $tipoMovimiento, $subtipoMovimiento)
    {
        $data['subtitulo'] = "Asigna Factura";
        $data['movimientoID'] = $movimientoID;
        $data['tipoMovimiento'] = $tipoMovimiento;
        $data['subtipoMovimiento'] = $subtipoMovimiento;
        $data['js'] = "movimiento/asigna_factura_js";
        $this->load->view('main', $data);
        
    }
    
    function asigna_factura_submit()
    {
        $movimientoID = $this->input->post('movimientoID');
        $tipoMovimiento = $this->input->post('tipoMovimiento');
        $subtipoMovimiento = $this->input->post('subtipoMovimiento');
        $referencia = trim($this->input->post('referencia'));
        
        $this->movimiento_model->asignaFactura($movimientoID, $referencia);
        redirect('movimiento/index/'.$tipoMovimiento.'/'.$subtipoMovimiento);
    }
    
    function factura($movimientoID, $tipoMovimiento, $subtipoMovimiento)
    {
        $data['subtitulo'] = "Facturar pedido";
        $data['clientes'] = $this->movimiento_model->getClientesByMovimientoIDCombo($movimientoID);
        $data['movimientoID'] = $movimientoID;
        $data['tipoMovimiento'] = $tipoMovimiento;
        $data['subtipoMovimiento'] = $subtipoMovimiento;
        $data['js'] = "movimiento/factura_js";
        $this->load->view('main', $data);
    }
    
    function factura_submit()
    {
        $movimientoID = $this->input->post('movimientoID');
        $tipoMovimiento = $this->input->post('tipoMovimiento');
        $subtipoMovimiento = $this->input->post('subtipoMovimiento');
        $contratoID = $this->input->post('contratoID');
        
        $query = $this->movimiento_model->getMovimientoByMovimientoID($movimientoID);
        $row = $query->row();
        
        if($row->idFactura == 0)
        {
            $this->util->postFacturar($movimientoID, $contratoID);
        }
        
        redirect('movimiento/index/'.$tipoMovimiento.'/'.$subtipoMovimiento);
    }
    
    function getContratoByCliente()
    {
        $rfc = $this->input->post('rfc');
        
        echo $this->movimiento_model->getContratoCombo($rfc);
    }
    
    function getFacturaVistaPrevia()
    {
        $this->load->model('Catalogosweb_model');
        $contratoID = $this->input->post('contratoID');
        $movimientoID = $this->input->post('movimientoID');
        $data['query'] = $this->movimiento_model->getFacturaProductosByContratoID($contratoID, $movimientoID);
        $data['referencia'] = $this->movimiento_model->getFacturaReferencia($contratoID, $movimientoID);
        $this->load->view('movimiento/facturaVistaPrevia', $data);
    }
    
    function descargaXML($movimientoID)
    {
        $query = $this->movimiento_model->getMovimientoByMovimientoID($movimientoID);
        $row = $query->row();
        
        $this->load->helper('download');
        $data = file_get_contents($row->urlxml); // Read the file's contents
        $name = 'factura_'.$row->folioFactura.'.xml';
        
        force_download($name, $data); 
    }

    function descargaPDF($movimientoID)
    {
        $query = $this->movimiento_model->getMovimientoByMovimientoID($movimientoID);
        $row = $query->row();
        
        $this->load->helper('download');
        $data = file_get_contents($row->urlpdf); // Read the file's contents
        $name = 'factura_'.$row->folioFactura.'.pdf';
        
        force_download($name, $data); 
    }
    
    function correOrdenes()
    {
        $sql = "SELECT movimientoID FROM movimiento m where orden > 0 and statusMovimiento = 1 and aplicada = 0;";
        $query = $this->db->query($sql);
        
        foreach($query->result() as $row)
        {
            $this->pruebaOrden($row->movimientoID);
        }
    }
    
    function pruebaOrden($movimientoID = 421)
    {
        $json = $this->util->getOrdenPostJson($movimientoID);
        $res = $this->util->postDataOficina('orden', $json);
        
        if($res == null)
        {
            
        }else{
            $this->db->update('movimiento', array('aplicada' => 1), array('movimientoID' => $movimientoID));
        }
        
    }
    
    function pru()
    {
        $this->movimiento_model->getProductosFolprv(28685);
    }

}