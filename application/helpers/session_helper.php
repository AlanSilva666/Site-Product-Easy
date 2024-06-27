<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('check_login')) {
    function check_login() {
        $CI =& get_instance();
        $CI->load->library('session');

        if (!$CI->session->userdata('logged_in')) {
            redirect('login/index');
        }
    }
}
