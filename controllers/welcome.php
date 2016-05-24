<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Welcome extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        
        if (Current_User::user()) {
            redirect('workspace');
        }

    }


    public function index()
    {
        $this->load->view('login');
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
