<?php defined('BASEPATH') or exit('No direct script access allowed');



function is_app_installed()
{
    $CI =& get_instance();

    return $CI->db->table_exists('users');
}
