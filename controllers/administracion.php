<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Administracion extends CI_Controller
{
    
    public function __construct()
    {
        parent::__construct();

        if (!Current_User::user()) {
            redirect('welcome');
        }

        $this->load->model('admin_model');
        $this->load->helper('utilities');

    }
    
    public function usuario()
    {
        $data['subtitulo'] = "Usuarios del sistema";
        $data['query'] = $this->admin_model->getUsuario();
        //$data['js'] = "movimiento/nuevo_js";
        $this->load->view('main', $data);
    }
    
    function usuario_permisos($usuario)
    {
        $data['subtitulo'] = "Usuarios del sistema: Asigna Permisos";
        $data['query'] = $this->admin_model->getPermisosByUsuario($usuario);
        $data['usuario'] = $usuario;
        $data['js'] = "administracion/usuario_permisos_js";
        $this->load->view('main', $data);
    }
    
    function savePermiso()
    {
        $usuario = $this->input->post('usuario');
        $submenu = $this->input->post('submenu');
        
        $this->admin_model->savePermiso($usuario, $submenu);
    }

    public function profile()
    {
        $data['subtitulo'] = "Perfil de usuario";
        $data['query'] = $this->admin_model->getUsuarioByUsuario();
        $data['js'] = "administracion/profile_js";
        $this->load->view('main', $data);
    }
    
    function change_password()
    {
        $data['subtitulo'] = "Perfil de usuario";
        //$data['js'] = "administracion/profile_js";
        $this->load->view('main', $data);
    }
    
    function change_password_submit()
    {
        $oldP = $this->input->post('oldP');
        $password1 = $this->input->post('password1');
        $password2 = $this->input->post('password2');
        
        
        $checkOld = $this->admin_model->checkOldPassword($oldP);
        
        if((int)$checkOld > 0)
        {
            if($password1 == $password2)
            {
                $this->admin_model->saveNewPassword($password1);
                $this->session->set_flashdata('correcto', 'Password cambiado correctamente, el proximo inicio de sesion deberas ponerlo.');
                redirect('administracion/change_password');
            }else{
                $this->session->set_flashdata('error', 'El password nuevo no coicide ambas veces.');
                redirect('administracion/change_password');
            }
        }else{
            $this->session->set_flashdata('error', 'El password anterior es incorrecto.');
            redirect('administracion/change_password');
        }
        
    }
    
    function upload_avatar()
    {
        $uploaddir = './assets/avatars/';
        $file = basename($_FILES['userfile']['name']);
        $uploadfile = $uploaddir . $file;

        $config['image_library'] = 'gd2';
        $config['source_image'] = $uploadfile;
        $config['create_thumb'] = false;
        $config['maintain_ratio'] = true;
        $config['width'] = 400;
        $config['height'] = 400;
        $config['master_dim'] = 'auto';

        if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {

            $this->load->library('image_lib', $config);
            $this->image_lib->resize();

            echo $this->admin_model->update_avatar($file);
        } else {
            echo "error";
        }
    
    }

}