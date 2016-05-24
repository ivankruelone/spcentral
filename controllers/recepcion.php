<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Recepcion
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

class Recepcion extends REST_Controller
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
    
    function venta_post()
    {
        //$this->some_model->updateUser( $this->get('id') );
        $message = array('id' => $this->get('id'), 'name' => $this->post('a'), 'email' => $this->post('b'), 'message' => 'ADDED!');
        
        $this->response($message, 200); // 200 being the HTTP response code
    }


}