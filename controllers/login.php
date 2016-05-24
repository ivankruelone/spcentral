<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function landing()
    {

        $usuario = $this->input->post('usuario');
        $password = $this->input->post('password');
        $this->load->model('login_model');

        if ($this->login_model->verifyCredentials($usuario, $password)) {
            redirect('workspace');
        } else {
            redirect('welcome');
        }


    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('welcome');
    }
}
