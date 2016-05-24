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

class Directorio extends REST_Controller
{
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('sucursales_model');
    }
    
	function sucursal_get()
    {
        if(!$this->get('id'))
        {
        	$this->response(NULL, 400);
        }

        // $user = $this->some_model->getSomething( $this->get('id') );
        
        $sucursal = $this->sucursales_model->sucursal( $this->get('id') );
    	
        if($sucursal)
        {
            $this->response($sucursal, 200); // 200 being the HTTP response code
        }

        else
        {
            $this->response(array('error' => 'User could not be found'), 404);
        }
    }

	function sucursales_estado_get()
    {
        if(!$this->get('estado'))
        {
        	$this->response(NULL, 400);
        }

        // $user = $this->some_model->getSomething( $this->get('id') );
        
        $sucursales = $this->sucursales_model->sucursales_estado( $this->get('estado') );
    	
        if($sucursales)
        {
            $this->response($sucursales, 200); // 200 being the HTTP response code
        }

        else
        {
            $this->response(array('error' => 'User could not be found'), 404);
        }
    }

	function sucursales_get()
    {
        // $user = $this->some_model->getSomething( $this->get('id') );
        
        $sucursales = $this->sucursales_model->sucursales();
    	
        if($sucursales)
        {
            $this->response($sucursales, 200); // 200 being the HTTP response code
        }

        else
        {
            $this->response(array('error' => 'User could not be found'), 404);
        }
    }

	function estados_get()
    {
        // $user = $this->some_model->getSomething( $this->get('id') );
        
        $estados = $this->sucursales_model->estados();
    	
        if($estados)
        {
            $this->response($estados, 200); // 200 being the HTTP response code
        }

        else
        {
            $this->response(array('error' => 'User could not be found'), 404);
        }
    }

}