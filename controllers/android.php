<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Sucursales
 *
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array.
 *
 * @package		CodeIgniter
 * @subpackage	Rest Server
 * @category	Controller
 * @author		Phil Sturgeon
 * @link		http://philsturgeon.co.uk/code/
*/

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH.'/libraries/REST_Controller.php';

class Catalogos extends REST_Controller
{
    
    /**
     * Catalogos::__construct()
     * 
     * @return
     */
    function __construct()
    {
        parent::__construct();
        $this->load->model('catalogos_model');
    }
    
	/**
	 * Catalogos::cias_get()
	 * 
	 * @return
	 */
	function cias_get()
    {
        
        $cias = $this->catalogos_model->cias();
    	
        if($cias)
        {
            $this->response($cias, 200); // 200 being the HTTP response code
        }

        else
        {
            $this->response(array('error' => 'User could not be found'), 404);
        }
    }

	/**
	 * Catalogos::cliente_tipo_get()
	 * 
	 * @return
	 */
	function cliente_tipo_get()
    {
        
        $cliente_tipo = $this->catalogos_model->cliente_tipo();
    	
        if($cliente_tipo)
        {
            $this->response($cliente_tipo, 200); // 200 being the HTTP response code
        }

        else
        {
            $this->response(array('error' => 'User could not be found'), 404);
        }
    }

	/**
	 * Catalogos::clientes_get()
	 * 
	 * @return
	 */
	function clientes_get()
    {
        
        $clientes = $this->catalogos_model->clientes();
    	
        if($clientes)
        {
            $this->response($clientes, 200); // 200 being the HTTP response code
        }

        else
        {
            $this->response(array('error' => 'User could not be found'), 404);
        }
    }

	/**
	 * Catalogos::clientes_autorizados_get()
	 * 
	 * @return
	 */
	function clientes_autorizados_get()
    {
        if(!$this->get('sucursal'))
        {
        	$this->response(NULL, 400);
        }
        
        $clientes_autorizados = $this->catalogos_model->clientes_autorizados( $this->get('sucursal') );
    	
        if($clientes_autorizados)
        {
            $this->response($clientes_autorizados, 200); // 200 being the HTTP response code
        }

        else
        {
            $this->response(array('error' => 'User could not be found'), 404);
        }
    }

	/**
	 * Catalogos::descuentos_mayoreo_get()
	 * 
	 * @return
	 */
	function descuentos_mayoreo_get()
    {
        
        $descuentos_mayoreo = $this->catalogos_model->descuentos_mayoreo();
    	
        if($descuentos_mayoreo)
        {
            $this->response($descuentos_mayoreo, 200); // 200 being the HTTP response code
        }

        else
        {
            $this->response(array('error' => 'User could not be found'), 404);
        }
    }

	/**
	 * Catalogos::fidelizacion_tipo_get()
	 * 
	 * @return
	 */
	function fidelizacion_tipo_get()
    {
        
        $fidelizacion_tipo = $this->catalogos_model->fidelizacion_tipo();
    	
        if($fidelizacion_tipo)
        {
            $this->response($fidelizacion_tipo, 200); // 200 being the HTTP response code
        }

        else
        {
            $this->response(array('error' => 'User could not be found'), 404);
        }
    }

	/**
	 * Catalogos::formas_pago_get()
	 * 
	 * @return
	 */
	function formas_pago_get()
    {
        
        $formas_pago = $this->catalogos_model->formas_pago();
    	
        if($formas_pago)
        {
            $this->response($formas_pago, 200); // 200 being the HTTP response code
        }

        else
        {
            $this->response(array('error' => 'User could not be found'), 404);
        }
    }

	/**
	 * Catalogos::lineas_get()
	 * 
	 * @return
	 */
	function lineas_get()
    {
        
        $lineas = $this->catalogos_model->lineas();
    	
        if($lineas)
        {
            $this->response($lineas, 200); // 200 being the HTTP response code
        }

        else
        {
            $this->response(array('error' => 'User could not be found'), 404);
        }
    }

	/**
	 * Catalogos::sublineas_get()
	 * 
	 * @return
	 */
	function sublineas_get()
    {
        
        $sublineas = $this->catalogos_model->sublineas();
    	
        if($sublineas)
        {
            $this->response($sublineas, 200); // 200 being the HTTP response code
        }

        else
        {
            $this->response(array('error' => 'User could not be found'), 404);
        }
    }

	/**
	 * Catalogos::sucursales_get()
	 * 
	 * @return
	 */
	function sucursales_get()
    {
        
        $sucursales = $this->catalogos_model->sucursales();
    	
        if($sucursales)
        {
            $this->response($sucursales, 200); // 200 being the HTTP response code
        }

        else
        {
            $this->response(array('error' => 'User could not be found'), 404);
        }
    }

	/**
	 * Catalogos::proveedores_get()
	 * 
	 * @return
	 */
	function proveedores_get()
    {
        
        $proveedores = $this->catalogos_model->proveedores();
    	
        if($proveedores)
        {
            $this->response($proveedores, 200); // 200 being the HTTP response code
        }

        else
        {
            $this->response(array('error' => 'User could not be found'), 404);
        }
    }

	/**
	 * Catalogos::tipos_movimientos_get()
	 * 
	 * @return
	 */
	function tipos_movimientos_get()
    {
        
        $tipos_movimientos = $this->catalogos_model->tipos_movimientos();
    	
        if($tipos_movimientos)
        {
            $this->response($tipos_movimientos, 200); // 200 being the HTTP response code
        }

        else
        {
            $this->response(array('error' => 'User could not be found'), 404);
        }
    }

	/**
	 * Catalogos::usuarios_get()
	 * 
	 * @return
	 */
	function usuarios_get()
    {
        
        $usuarios = $this->catalogos_model->usuarios();
    	
        if($usuarios)
        {
            $this->response($usuarios, 200); // 200 being the HTTP response code
        }

        else
        {
            $this->response(array('error' => 'User could not be found'), 404);
        }
    }

	/**
	 * Catalogos::usuarios_sucursal_get()
	 * 
	 * @return
	 */
	function usuarios_sucursal_get()
    {
        if(!$this->get('sucursal'))
        {
        	$this->response(NULL, 400);
        }
        
        $usuarios = $this->catalogos_model->usuarios_sucursal( $this->get('sucursal') );
    	
        if($usuarios)
        {
            $this->response($usuarios, 200); // 200 being the HTTP response code
        }

        else
        {
            $this->response(array('error' => 'User could not be found'), 404);
        }
    }

	/**
	 * Catalogos::usuario_nomina_get()
	 * 
	 * @return
	 */
	function usuario_nomina_get()
    {
        if(!$this->get('nomina'))
        {
        	$this->response(NULL, 400);
        }
        
        $usuario = $this->catalogos_model->usuario_nomina( $this->get('nomina') );
    	
        if($usuario)
        {
            $this->response($usuario, 200); // 200 being the HTTP response code
        }

        else
        {
            $this->response(array('error' => 'User could not be found'), 404);
        }
    }

	/**
	 * Catalogos::productos_get()
	 * 
	 * @return
	 */
	function productos_get()
    {
        if(!$this->get('tipo'))
        {
        	$this->response(NULL, 400);
        }
        
        $productos = $this->catalogos_model->productos( $this->get('tipo') );
    	
        if($productos)
        {
            $this->response($productos, 200); // 200 being the HTTP response code
        }

        else
        {
            $this->response(array('error' => 'User could not be found'), 404);
        }
    }

	function productos_inventario_get()
    {
        if(!$this->get('tipo'))
        {
        	$this->response(NULL, 400);
        }
        
        $productos = $this->catalogos_model->productos_inventario( $this->get('tipo') );
    	
        if($productos)
        {
            $this->response($productos, 200); // 200 being the HTTP response code
        }

        else
        {
            $this->response(array('error' => 'User could not be found'), 404);
        }
    }

	function tarjetas_autorizadas_get()
    {
        if(!$this->get('sucursal'))
        {
        	$this->response(NULL, 400);
        }
        
        $tarjetas_autorizadas = $this->catalogos_model->tarjetas_autorizadas( $this->get('sucursal') );
    	
        if($tarjetas_autorizadas)
        {
            $this->response($tarjetas_autorizadas, 200); // 200 being the HTTP response code
        }

        else
        {
            $this->response(array('error' => 'User could not be found'), 404);
        }
    }

	function tcp_get()
    {
        
        $tcp = $this->catalogos_model->tcp();
    	
        if($tcp)
        {
            $this->response($tcp, 200); // 200 being the HTTP response code
        }

        else
        {
            $this->response(array('error' => 'User could not be found'), 404);
        }
    }

}