<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once FCPATH . 'vendor/autoload.php';

class M_pdf {

    public function __construct() {
    }

    public function load($param = NULL) {
        if ($param == NULL) {
            $param = '"en-GB-x","A4","","",10,10,10,10,6,3';
        }

        return new \Mpdf\Mpdf();
    }
}
