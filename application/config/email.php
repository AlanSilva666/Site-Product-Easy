<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config = array(
    'protocol' => 'smtp',
    'smtp_host' => 'smtp-mail.outlook.com',
    'smtp_port' => 587,
    'smtp_user' => 'alan_alfenas2010@live.com',
    'smtp_pass' => 'martins2',
    'smtp_crypto' => 'tls', // Pode ser 'ssl' ou 'tls'
    'mailtype' => 'html',
    'charset' => 'utf-8'
);


// Método para configurar o e-mail
// function configure_email() {
//     $config = get_instance()->config->item('email');
//     return $config;
// }
