<?php
class Current_User
{

    private static $user;


    public static function user()
    {

        if (!isset(self::$user)) {

            $CI = &get_instance();
            $CI->load->library('session');

            if (!$logged_in = $CI->session->userdata('logged_in')) {
                return false;
            }

            self::$user = $logged_in;
        }

        return self::$user;
    }


}
