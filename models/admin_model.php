<?php
class Admin_model extends CI_Model {

    /**
     * Catalogos_model::__construct()
     * 
     * @return
     */
    function __construct()
    {
        parent::__construct();
    }
    
    function getUsuario()
    {
        $sql = "SELECT usuario, clvusuario, password, nombreusuario, case when estaactivo = 0 then 'INACTIVO' else 'ACTIVO' end as estaactivo, descsucursal, puesto
FROM usuarios u
join sucursales s using(clvsucursal)
join puesto p using(clvpuesto);";
        $query = $this->db->query($sql);
        return $query;
    }
    
    function getUsuarioByUsuario()
    {
        $sql = "SELECT usuario, clvusuario, password, nombreusuario, case when estaactivo = 0 then 'INACTIVO' else 'ACTIVO' end as estaactivo, descsucursal, puesto, last_login
FROM usuarios u
join sucursales s using(clvsucursal)
join puesto p using(clvpuesto)
where usuario = ?;";
        $query = $this->db->query($sql, $this->session->userdata('usuario'));
        return $query;
    }
    
    function getPermisosByUsuario($usuario)
    {
        $sql = "SELECT menu, submenu, s.submenuID, opcion FROM submenu s
join menu m using(menuID)
left join usuarios_submenu u on s.submenuID = u.submenuID and usuario = ?
order by menuID, s.submenuID;";

        $query = $this->db->query($sql, $usuario);
        
        return $query;
    }
    
    function savePermiso($usuario, $submenu)
    {
        $this->db->where('usuario', $usuario);
        $this->db->where('submenuID', $submenu);
        $query = $this->db->get('usuarios_submenu');
        
        if($query->num_rows() == 0)
        {
            $data = array(
                'usuario' => $usuario,
                'submenuID' => $submenu,
                'opcion' => 1
                );
            
            $this->db->insert('usuarios_submenu', $data);
        }else{
            $data = array(
                'usuario' => $usuario,
                'submenuID' => $submenu
                );
            $this->db->delete('usuarios_submenu', $data);
        }
    }

    function update_avatar($avatar)
    {
        $update = array(
                'avatar' => $avatar
        );
        $this->db->where('usuario', $this->session->userdata('usuario'));
        $this->db->update('usuarios', $update);
        $this->session->set_userdata($update);
        return "<img src=\"".base_url()."assets/avatars/".$avatar."\" />";
    }
    
    function checkOldPassword($oldP)
    {
        $this->db->where('usuario', $this->session->userdata('usuario'));
        $this->db->where('password', $oldP);
        
        $query = $this->db->get('usuarios');
        return $query->num_rows();
    }
    
    function saveNewPassword($password)
    {
        $data = array('password' => $password);
        $this->db->update('usuarios', $data, array('usuario' => $this->session->userdata('usuario')));
    }

}