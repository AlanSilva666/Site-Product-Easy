<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require APPPATH . 'libraries/PHPMailer/Exception.php';
require APPPATH . 'libraries/PHPMailer/PHPMailer.php';
require APPPATH . 'libraries/PHPMailer/SMTP.php';

class Login extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('user_db');
        $this->load->library(['form_validation', 'session']);
        $this->load->helper(['url', 'security']);
    }

    public function index() {
        if ($this->session->userdata('logged_in')) {
            $usuario_id = $this->session->userdata('usuario_id');
            redirect("home/index/$usuario_id");
        } else {
            $this->load->view('login/index');
        }
    }

    public function process_login() {
        $cpf = $this->input->post('cpf', TRUE);
        $password = $this->input->post('senha', TRUE);

        // $this->session->set_flashdata('cpf', $cpf);

        $user = $this->user_db->verify_login($cpf, $password);

        if ($user) {
            $session_data = array(
                'usuario_id' => $user->usuario_id,
                'cpf' => $cpf,
                'nome' => $user->nome,
                'logged_in' => TRUE
            );
            $this->session->set_userdata($session_data);
            redirect("home/index/{$user->usuario_id}");
        } else {
            $this->session->set_flashdata('nao_autenticado', 'ERRO: LOGIN OU SENHA ESTÃO INVÁLIDOS.');
            redirect('login');
        }
    }

    public function register() {
        $dados = [
            'cpf' => trim($this->input->post('cpf', TRUE)),
            'nome' => trim($this->input->post('nome', TRUE)),
            'email' => trim($this->input->post('email', TRUE)),
            'idade' => trim($this->input->post('idade', TRUE)),
            'sexo' => trim($this->input->post('tSexo', TRUE)),
            'senha' => trim($this->input->post('senha', TRUE))
        ];

        // Manter o valor da senha em caso de erro
        $this->session->set_flashdata('cpf', $dados['cpf']);
        $this->session->set_flashdata('nome', $dados['nome']);
        $this->session->set_flashdata('email', $dados['email']);
        $this->session->set_flashdata('idade', $dados['idade']);
        $this->session->set_flashdata('sexo', $dados['sexo']);
        $this->session->set_flashdata('senha', $dados['senha']);

        $this->session->set_flashdata('dados_form', $dados);

        // Verifica os campos obrigatórios
        if ($this->user_db->cpf_exists($dados['cpf'])) {
            $this->session->set_flashdata('erro_cadastro', 'CPF JÁ CADASTRADO NO SISTEMA!');
            redirect('login/show_register');
        }

        // Verifica a validade do CPF
        if (!$this->validaCPF($dados['cpf'])) {
            $this->session->set_flashdata('cpf_invalido', 'CPF INVÁLIDO!');
            redirect('login/show_register');
        }

        if (!$this->validar_campos($dados)) {
            $this->session->set_flashdata('campos_em_branco', 'PREENCHA TODOS OS CAMPOS OBRIGATÓRIOS!');
            redirect('login/show_register');
        }
        
        // Verifica se a senha é forte o suficiente
        if (!$this->is_strong_password($dados['senha'])) {
            $this->session->set_flashdata('senha_fraca', 'CRIE UMA SENHA FORTE! <BR> LETRAS MAIÚSCULAS, MINÚSCULAS, <BR> NÚMEROS E CARACTERES ESPECIAIS.');
            redirect('login/show_register');
        }

        if ($dados['idade'] >= 18) {
            // Registra o usuário na tabela contato_cliente_1
            $this->user_db->register_user($dados);

            // Envie o email de boas-vindas
            $this->send_welcome_email($dados['email'], $dados['nome'], $dados['cpf'], $dados['idade'], $dados['sexo']);

            $this->session->set_flashdata('criado', TRUE);
            redirect('login');
        } else {
            $this->session->set_flashdata('menor_idade','É NECESSÁRIO TER MAIS DE 18 ANOS PARA SE CADASTRAR NO SISTEMA.');
            redirect('login/show_register');
        }
    }
    public function new_password() {
        $cpf = $this->input->post('cpf', TRUE);
        $new_password = $this->input->post('senha', TRUE);
        
        // Manter o valor do CPF em caso de erro
        $this->session->set_flashdata('cpf', $cpf);
        $this->session->set_flashdata('senha', $new_password);
    
        // Verificar se o CPF existe no banco de dados
        if (!$this->user_db->cpf_exists($cpf)) {
            $this->session->set_flashdata('erro_senha', 'CPF não encontrado!');
            redirect('login/show_new_password');
            return;
        }
    
        // Verificar se a senha é forte o suficiente
        if (!$this->is_strong_password($new_password)) {
            $this->session->set_flashdata('senha_forte', 'Crie uma senha forte! Letras maiúsculas, minúsculas, números e caracteres especiais.');
            redirect('login/show_new_password');
            return;
        }
    
        // Atualizar a senha no banco de dados
        if ($this->user_db->update_password($cpf, password_hash($new_password, PASSWORD_BCRYPT))) {
            // Buscar os dados do usuário
            $user = $this->user_db->get_user_by_cpf($cpf);
    
            // Envie o email de notificação de alteração de senha
            $this->send_password_change_email($user->email, $user->nome);
    
            // Registrar na tabela de log (log_registros)
            $log_data = array(
                'acao' => 'ATUALIZAÇÃO DE SENHA',
                'tabela_afetada' => 'usuario',
                'id_afetado' => $user->usuario_id
            );
    
            $this->db->insert('log', $log_data);
    
            // Mensagem de senha alterada
            $this->session->set_flashdata('senha_alterada', TRUE);
            redirect('login');
        } else {
            // Se ocorrer um erro ao atualizar a senha
            $this->session->set_flashdata('erro_senha', 'Erro ao atualizar a senha!');
            redirect('login/show_new_password');
        }
    }
    
    public function show_register() {
        $this->load->view('login/register');
    }

    public function show_new_password() {
        $this->load->view('login/new_password');
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('login');
    }

    // Função para verificar se a senha é forte o suficiente
    private function is_strong_password($senha) {
        // Pelo menos 8 caracteres
        if (strlen($senha) < 8) {
            return false;
        }
    
        // Pelo menos uma letra maiúscula, uma letra minúscula e um número
        if (!preg_match('/[A-Z]/', $senha) || !preg_match('/[a-z]/', $senha) || !preg_match('/[0-9]/', $senha)) {
            return false;
        }
    
        // Pelo menos um caractere especial
        if (!preg_match('/[!@#$%^&*()\-_=+{};:,<.>]/', $senha)) {
            return false;
        }
    
        return true;
    }

    private function validar_campos($dados) {
        // Verifica se algum dos campos obrigatórios está vazio
        foreach ($dados as $chave => $valor) {
            if (empty($valor) || preg_match('/^\s+$/', $valor)) {
                return false;
            }
        }
        return true;
    }

    private function validaCPF($cpf) {
        // Remove os caracteres especiais
        $cpf = preg_replace('/[^0-9]/is', '', $cpf);

        // Verifica se o número de dígitos é igual a 11
        if (strlen($cpf) != 11) {
            return false;
        }

        // Verifica se todos os dígitos são iguais
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        // Calcula os dígitos verificadores
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }

        return true;
    }

    // Função para enviar o e-mail de notificação de Cadastro
    private function send_welcome_email($to_email, $to_name, $to_cpf, $to_idade, $to_sexo) {
        $mail = new PHPMailer(true);

        try {
            // Configurações do servidor SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp-mail.outlook.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'alan_alfenas2010@live.com'; // Seu email
            $mail->Password = 'martins2'; // Sua senha
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            // Configurações do e-mail
            $mail->setFrom('alan_alfenas2010@live.com', 'Product Easy');
            $mail->addReplyTo('alan_alfenas2010@live.com', 'Product Easy');
            $mail->addAddress($to_email);

            $mail->Subject = 'Bem-vindo ao Product Easy';
            $mail->isHTML(true);

            // Definindo a codificação do e-mail
            $mail->CharSet = 'UTF-8';

            // Mensagem do e-mail
            $login_url = base_url('index.php/login');
            $mailContent = "<h1>Olá, $to_name.</h1>
                            <h1>Seja bem-vindo(a) ao Product Easy!</h1>
                            <p>Segue abaixo, os dados que você preencheu no cadastro de login: </p>
                            <p>CPF: $to_cpf</p>
                            <p>Nome: $to_name.</p>
                            <p>Email: $to_email</p>
                            <p>Idade: $to_idade anos.</p>
                            <p>Gênero: $to_sexo.</p>
                            <p>Para acessar ao Easy Product, você deve colocar seu CPF e sua senha.</p>
                            <p>Segue abaixo, o link para acessar o sistema:</p>
                            <a href='$login_url'>Proudct Easy</a>";

            $mail->Body = $mailContent;

            // Envia o e-mail
            if ($mail->send()) {
                log_message('info', 'E-mail enviado com sucesso para ' . $to_email);
            } else {
                log_message('error', 'Erro ao enviar e-mail: ' . $mail->ErrorInfo);
            }
        } catch (Exception $e) {
            log_message('error', 'Erro ao enviar e-mail: ' . $mail->ErrorInfo);
        }
    }

    // Função para enviar o e-mail de notificação de alteração de senha
    private function send_password_change_email($to_email, $to_name) {
        $mail = new PHPMailer(true);

        try {
            // Configurações do servidor SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp-mail.outlook.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'alan_alfenas2010@live.com'; // Seu email
            $mail->Password = 'martins2'; // Sua senha
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            // Configurações do e-mail
            $mail->setFrom('alan_alfenas2010@live.com', 'Product Easy');
            $mail->addReplyTo('alan_alfenas2010@live.com', 'Product Easy');
            $mail->addAddress($to_email);

            $mail->Subject = 'Atualização de senha';
            $mail->isHTML(true);

            // Definindo a codificação do e-mail
            $mail->CharSet = 'UTF-8';

            // Mensagem do e-mail
            $login_url = base_url('index.php/login');
            $mailContent = "<h1>Olá, $to_name.</h1>
                            <p>Sua senha foi alterada com sucesso!</p>
                            <p>Se você não solicitou essa alteração, por favor, entre em contato conosco imediatamente.</p>
                            <p>Coloque sua nova senha para acessar ao Product Easy.</p>
                            <p>Segue abaixo, o link para acessar o sistema:</p>
                            <a href='$login_url'>Product Easy</a>";
            $mail->Body = $mailContent;

            // Envia o e-mail
            if ($mail->send()) {
                log_message('info', 'E-mail enviado com sucesso para ' . $to_email);
            } else {
                log_message('error', 'Erro ao enviar e-mail: ' . $mail->ErrorInfo);
            }
        } catch (Exception $e) {
            log_message('error', 'Erro ao enviar e-mail: ' . $mail->ErrorInfo);
        }
    }
}
?>
