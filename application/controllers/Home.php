<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// Carregue a biblioteca PHPSpreadsheet
require 'vendor/autoload.php';
        
// Use as classes necessárias
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require APPPATH . 'libraries/PHPMailer/Exception.php';
require APPPATH . 'libraries/PHPMailer/PHPMailer.php';
require APPPATH . 'libraries/PHPMailer/SMTP.php';

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('request_db');
        $this->load->library(['form_validation', 'session']);
        $this->load->library('pagination');
        $this->load->helper(['url', 'security']);
    }

    public function index($usuario_id = NULL) {
        if (!$this->session->userdata('logged_in') || $this->session->userdata('usuario_id') != $usuario_id) {
            redirect('login');
        }

        $data['welcome_message'] = '';
        $session_key = 'welcome_message_shown_' . $usuario_id;

        if (!$this->session->userdata($session_key)) {
            $nome_usuario = $this->session->userdata('nome');
            $data['welcome_message'] = "<h1> Olá, $nome_usuario! <br> Seja bem-vindo(a) ao Easy Product.";
            $this->session->set_userdata($session_key, true);
        }

        $data['usuario_id'] = $usuario_id;
        $this->load->view('home/index', $data);
    }

    public function specs($usuario_id = NULL) {
        // Verifica se o usuário está autenticado
        if (!$this->session->userdata('logged_in') || $this->session->userdata('usuario_id') != $usuario_id) {
            redirect('login');
        }

        $data['usuario_id'] = $usuario_id;
        $this->load->view('home/specs', $data);
    }

    public function fotos($usuario_id = NULL) {
        // Verifica se o usuário está autenticado
        if (!$this->session->userdata('logged_in') || $this->session->userdata('usuario_id') != $usuario_id) {
            redirect('login');
        }

        $data['usuario_id'] = $usuario_id;
        $this->load->view('home/fotos', $data);
    }

    public function multimidia($usuario_id = NULL) {
        // Verifica se o usuário está autenticado
        if (!$this->session->userdata('logged_in') || $this->session->userdata('usuario_id') != $usuario_id) {
            redirect('login');
        }

        $data['usuario_id'] = $usuario_id;
        $this->load->view('home/multimidia', $data);
    }

    //Função para cadastrar um pedido pro usuário logado
    public function fale_conosco($usuario_id = NULL) {
        // Verifica se o usuário está autenticado
        if (!$this->session->userdata('logged_in') || $this->session->userdata('usuario_id') != $usuario_id) {
            redirect('login');
        }

        $data['usuario_id'] = $usuario_id;
        $this->load->view('home/fale_conosco', $data);
    }

    //Função para cadastrar um pedido pro usuário logado
    public function request_c() {
        // Carregar bibliotecas e helpers necessários
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->helper('url');
    
        // Carregar dados do formulário
        $dados = [
            'usuario_id' => $this->session->userdata('usuario_id'), // Adiciona o usuario_id
            'nome' => trim($this->input->post('tNome', TRUE)),
            'email' => trim($this->input->post('tMail', TRUE)),
            'sexo' => trim($this->input->post('tSexo', TRUE)),
            'data_nascimento' => trim($this->input->post('tNasc', TRUE)),
            'endereco' => trim($this->input->post('endereco', TRUE)),
            'bairro' => trim($this->input->post('bairro', TRUE)),
            'numero' => trim($this->input->post('tNum', TRUE)),
            'uf' => trim($this->input->post('uf', TRUE)),
            'cidade' => trim($this->input->post('cidade', TRUE)),
            'cep' => trim($this->input->post('cep', TRUE)),
            'cpf' => trim($this->input->post('tCpf', TRUE)),
            'rg' => trim($this->input->post('tRg', TRUE)),
            'telefone_1' => trim($this->input->post('tTel1', TRUE)),
            'telefone_2' => trim($this->input->post('tTel2', TRUE)),
            'mensagem' => trim($this->input->post('tMsg', TRUE)),
            'quantidade' => trim($this->input->post('tQtd', TRUE)),
            'total_pagar' => trim($this->input->post('tTot', TRUE))
        ];
    
        // Manter o valor dos campos em caso de erro
        $this->session->set_flashdata('dados_form', $dados);
    
        // Verifica a validade do CPF
        if (!$this->validaCPF($dados['cpf'])) {
            $this->session->set_flashdata('cpf_invalido', 'CPF INVÁLIDO!');
            redirect('home/fale_conosco/' . $this->session->userdata('usuario_id'));
        }
    
        // Verifica se todos os campos obrigatórios estão preenchidos
        if (!$this->validar_campos($dados)) {
            $this->session->set_flashdata('campos_em_branco', 'PREENCHA TODOS OS CAMPOS PARA REALIZAR O PEDIDO!');
            redirect('home/fale_conosco/' . $this->session->userdata('usuario_id'));
        }
    
        // Registro da solicitação no banco de dados
        $register_success = $this->request_db->register_request($dados);
    
        if ($register_success) {

            // Envie o email de confirmação de compra
            $this->send_purchase_email($dados['email'], $dados['nome'], $dados['cpf'], 
            $dados['endereco'], $dados['numero'], $dados['bairro'], $dados['cidade'], $dados['uf'],
            $dados['quantidade'], $dados['total_pagar']);

            $this->send_purchase_email_for_adm($dados['email'], $dados['nome'], $dados['cpf'], 
            $dados['endereco'], $dados['numero'], $dados['bairro'], $dados['cidade'], $dados['uf'],
            $dados['quantidade'], $dados['total_pagar']);
    
            // Define a mensagem de sucesso na sessão
            $this->session->set_flashdata('pedido_realizado', 'Pedido realizado com sucesso!');
            // Redireciona para a página de listar pedidos
            redirect('home/listar_pedidos/' . $this->session->userdata('usuario_id'));
        } else {
            // Define a mensagem de erro na sessão
            $this->session->set_flashdata('pedido_nao_realizado', 'Não foi possível completar o pedido. Tente novamente.');
            // Redireciona para a página de contato
            redirect('home/fale_conosco/' . $this->session->userdata('usuario_id'));
        }
    }

    // Função para editar um pedido específico
    public function edit_request($usuario_id = NULL, $contato_id = NULL) {
        // Verifica se o usuário está autenticado
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    
        // Verifica se os IDs passados na URL correspondem ao ID do usuário na sessão
        if ($this->session->userdata('usuario_id') != $usuario_id) {
            redirect('home'); // Redireciona para a página inicial ou para outra página apropriada
        }
    
        // Carrega o model Request_db
        $this->load->model('request_db');
    
        // Obtém os dados do pedido específico do usuário
        $data['row_usuario'] = $this->request_db->get_request_by_id($usuario_id, $contato_id);
    
        // Verifica se o pedido foi encontrado
        if (empty($data['row_usuario'])) {
            show_404(); // Mostra a página de erro 404 se o pedido não for encontrado
        }
    
        // Define os IDs do usuário e do contato para a view
        $data['usuario_id'] = $usuario_id;
        $data['contato_id'] = $contato_id;
    
        // Carrega a view edit_request.php
        $this->load->view('home/edit_request', $data);
    }
    
    // Função para atualizar um pedido específico
    public function update_request($usuario_id, $contato_id) {
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->helper('url');
    
        $dados = [
            'contato_id' => trim($this->input->post('contato_id', TRUE)),
            'nome' => trim($this->input->post('tNome', TRUE)),
            'email' => trim($this->input->post('tMail', TRUE)),
            'sexo' => trim($this->input->post('tSexo', TRUE)),
            'data_nascimento' => trim($this->input->post('tNasc', TRUE)),
            'cpf' => trim($this->input->post('tCpf', TRUE)),
            'rg' => trim($this->input->post('tRg', TRUE)),
            'telefone_1' => trim($this->input->post('tTel1', TRUE)),
            'telefone_2' => trim($this->input->post('tTel2', TRUE)),
            'cep' => trim($this->input->post('cep', TRUE)),
            'endereco' => trim($this->input->post('endereco', TRUE)),
            'numero' => trim($this->input->post('tNum', TRUE)),
            'bairro' => trim($this->input->post('bairro', TRUE)),
            'uf' => trim($this->input->post('uf', TRUE)),
            'cidade' => trim($this->input->post('cidade', TRUE)),
            'mensagem' => trim($this->input->post('tMsg', TRUE)),
            'quantidade' => trim($this->input->post('tQtd', TRUE)),
            'total_pagar' => trim($this->input->post('tTot', TRUE))
        ];
    
        $this->session->set_flashdata('dados_form', $dados);
    
        if (!$this->validaCPF($dados['cpf'])) {
            $this->session->set_flashdata('cpf_invalido', 'CPF INVÁLIDO!');
            redirect('home/edit_request/' . $usuario_id . '/' . $contato_id);
        }
    
        if (!$this->validar_campos($dados)) {
            $this->session->set_flashdata('campos_em_branco', 'PREENCHA TODOS OS CAMPOS PARA ATUALIZAR O PEDIDO!');
            redirect('home/edit_request/' . $usuario_id . '/' . $contato_id);
        }
    
        $update_success = $this->request_db->update_request_data($usuario_id, $contato_id, $dados);
    
        if ($update_success) {

            // $log_data = array(
            //     'acao' => 'ATUALIZAÇÃO DE PEDIDO',
            //     'tabela_afetada' => 'conato_cliente_1',
            //     'id_afetado' => $update_success->usuario_id,
            //     'id_contato_id' => $update_success->contato_id
            // );
            // $this->db->insert('log', $log_data);

            // Envie o email de confirmação de compra
            $this->send_purchase_email_update($dados['contato_id'], $dados['email'], $dados['nome'], $dados['cpf'], 
            $dados['endereco'], $dados['numero'], $dados['bairro'], $dados['cidade'], $dados['uf'],
            $dados['quantidade'], $dados['total_pagar']);

            $this->send_purchase_email_update_for_adm($dados['contato_id'], $dados['email'], $dados['nome'], $dados['cpf'], 
            $dados['endereco'], $dados['numero'], $dados['bairro'], $dados['cidade'], $dados['uf'],
            $dados['quantidade'], $dados['total_pagar']);

            $this->session->set_flashdata('dados_atualizados', 'Dados atualizados com sucesso!');
            redirect('home/listar_pedidos/' . $usuario_id);
        } else {
            $this->session->set_flashdata('dados_nao_atualizados', 'Não foi possível atualizar os dados. Tente novamente.');
            redirect('home/edit_request/' . $usuario_id . '/' . $contato_id);
        }
    }

    // Função para cancelar um pedido específico
    public function cancel_request($usuario_id = NULL, $contato_id = NULL) {
        // Verifica se o usuário está autenticado
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }

        // Verifica se os IDs passados na URL correspondem ao ID do usuário na sessão
        if ($this->session->userdata('usuario_id') != $usuario_id) {
            redirect('home'); // Redireciona para a página inicial ou para outra página apropriada
        }

        // Carrega o model Request_db
        $this->load->model('request_db');

        // Obtém os dados do pedido específico do usuário
        $data['row_usuario'] = $this->request_db->get_request_by_id($usuario_id, $contato_id);

        // Verifica se o pedido foi encontrado
        if (empty($data['row_usuario'])) {
            show_404(); // Mostra a página de erro 404 se o pedido não for encontrado
        }

        // Define os IDs do usuário e do contato para a view
        $data['usuario_id'] = $usuario_id;
        $data['contato_id'] = $contato_id;

        // Carrega a view cancel_request.php
        $this->load->view('home/cancel_request', $data);
    }

    // Função para deletar um pedido específico
    public function del_request($usuario_id, $contato_id) {
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->model('request_db'); // Carrega o model Request_db

        $dados = [
            'contato_id' => trim($this->input->post('contato_id', TRUE)),
            'nome' => trim($this->input->post('tNome', TRUE)),
            'email' => trim($this->input->post('tMail', TRUE)),
            'data_nascimento' => trim($this->input->post('tNasc', TRUE)),
            'cpf' => trim($this->input->post('tCpf', TRUE)),
            'quantidade' => trim($this->input->post('tQtd', TRUE)),
            'total_pagar' => trim($this->input->post('tTot', TRUE))
        ];
    
        $this->session->set_flashdata('dados_form', $dados);
    
        // Deleta o pedido
        $del_success = $this->request_db->del_register($usuario_id,$contato_id);
        // $dados = array();
    
        if ($del_success) {
            // Envie o email de confirmação de compra
            $this->send_purchase_email_delete($dados['contato_id'], $dados['nome'], $dados['email'], $dados['data_nascimento'],
            $dados['cpf'], $dados['quantidade'], $dados['total_pagar']);

            $this->send_purchase_email_for_delete_adm($dados['contato_id'], $dados['nome'], $dados['email'], $dados['data_nascimento'],
            $dados['cpf'], $dados['quantidade'], $dados['total_pagar']);

            $this->session->set_flashdata('success_message', 'SUCESSO: PEDIDO CANCELADO!');
        } else {
            $this->session->set_flashdata('error_message', 'NÃO FOI POSSÍVEL REMOVER O PEDIDO!');
        }
        
        // Redireciona para a listagem de pedidos
        redirect('home/listar_pedidos/' . $usuario_id);
    }
 
    public function google_glass($usuario_id = NULL) {
        // Verifica se o usuário está autenticado
        if (!$this->session->userdata('logged_in') || $this->session->userdata('usuario_id') != $usuario_id) {
            redirect('login');
        }

        $data['usuario_id'] = $usuario_id;
        $this->load->view('home/google_glass', $data);
    }

    public function listar_pedidos($usuario_id = NULL) { 
        // Verifica se o usuário está logado e se é o próprio usuário acessando seus pedidos
        if (!$this->session->userdata('logged_in') || $this->session->userdata('usuario_id') != $usuario_id) {
            redirect('login');
        }

        // Configuração da paginação
        $this->load->library('pagination');
        $config['base_url'] = base_url('index.php/home/listar_pedidos/' . $usuario_id);
        $config['total_rows'] = $this->request_db->count_all_requests($usuario_id); // Total de registros
        $config['per_page'] = $this->input->get('per_page') ? $this->input->get('per_page') : 5; // Quantidade de registros por página
        $config['uri_segment'] = 4; // Segmento da URI que contém o número da página
        $config['reuse_query_string'] = TRUE; // Mantém os parâmetros da query string

        // Estilo da paginação
        $config['full_tag_open'] = '<div class="pagination">';
        $config['full_tag_close'] = '</div>';
        $config['first_link'] = 'Primeira';
        $config['last_link'] = 'Última';
        $config['next_link'] = 'Próxima';
        $config['prev_link'] = 'Anterior';

        // Configuração dos links da página
        $config['num_tag_open'] = '<span class="pagina_atual">';
        $config['num_tag_close'] = '</span>';
        $config['cur_tag_open'] = '<strong>';
        $config['cur_tag_close'] = '</strong>';

        // Inicializa a biblioteca de paginação
        $this->pagination->initialize($config);

        // Obter o número da página
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

        // Prepara dados para a view
        $data['usuario_id'] = $usuario_id;
        $data['pedidos'] = $this->request_db->get_requests($config['per_page'], $page, $usuario_id);

        if (!empty($data['pedidos'])) {
            $data['result_count'] = "MOSTRANDO " . ($page + 1) . " A " . min($page + $config['per_page'], $config['total_rows']) . " DE " . $config['total_rows'] . " RESULTADOS";
        } else {
            $data['result_count'] = "MOSTRANDO 0 A 0 DE 0 RESULTADOS ";
        }

        // Carrega a view com a paginação
        $this->load->view('home/listar_pedidos', $data);
    }
    
    public function exportar_pedidos($formato, $usuario_id) {
        if (!$this->session->userdata('logged_in') || $this->session->userdata('usuario_id') != $usuario_id) {
            redirect('login');
        }
    
        // Obter parâmetros de paginação
        $per_page = $this->input->get('per_page') ? $this->input->get('per_page') : 5;
        $page = $this->input->get('page') ? $this->input->get('page') : 0;
    
        // Carregue a biblioteca para exportar para Excel ou PDF
        if ($formato == 'excel') {
            $this->exportar_para_excel($usuario_id, $per_page, $page);
        } elseif ($formato == 'pdf') {
            $this->load->library('PDFGenerator');
            $this->exportar_para_pdf($usuario_id, $per_page, $page);
        }
    }

    public function exportar_para_excel($usuario_id, $per_page, $page) {
        if (!$this->session->userdata('logged_in') || $this->session->userdata('usuario_id') != $usuario_id) {
            redirect('login');
        }
    
        // Obtenha os pedidos da página atual
        $pedidos = $this->request_db->get_requests($per_page, $page, $usuario_id);
    
        // Crie um novo objeto Spreadsheet
        $spreadsheet = new Spreadsheet();
    
        // Defina o cabeçalho das colunas
        $sheet = $spreadsheet->getActiveSheet();
    
        // Defina o título principal que abrange todas as colunas
        $titulo = 'RELATÓRIO DE PEDIDOS POR FILTRO DE PÁGINA';
        $sheet->setCellValue('A1', $titulo);
        $sheet->mergeCells('A1:D1'); // Ajuste o range conforme o número de colunas
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    
        // Adicione bordas ao título principal
        $sheet->getStyle('A1:D1')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN)->getColor()->setRGB('000000');
    
        // Defina os cabeçalhos das colunas
        $sheet->setCellValue('A2', 'NÚMERO DO PEDIDO')
              ->setCellValue('B2', 'CLIENTE')
              ->setCellValue('C2', 'QUANTIDADE')
              ->setCellValue('D2', 'VALOR');
    
        // Estilize os cabeçalhos
        $sheet->getStyle('A2:D2')->getFont()->setBold(true)->getColor()->setRGB('000000');
        $sheet->getStyle('A2:D2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A2:D2')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN)->getColor()->setRGB('000000');
    
        // Preencha os dados dos pedidos
        $linha = 3;
        foreach ($pedidos as $pedido) {
            $sheet->setCellValue('A'.$linha, $pedido->contato_id)
                  ->setCellValue('B'.$linha, $pedido->nome)
                  ->setCellValue('C'.$linha, $pedido->quantidade)
                  ->setCellValue('D'.$linha, ' R$ '.number_format($pedido->total_pagar, 2, ',', '.'));
    
            // Centralize os dados nos campos
            $sheet->getStyle('A'.$linha.':D'.$linha)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    
            // Ajuste a altura da linha
            $sheet->getRowDimension($linha)->setRowHeight(-1);
    
            // Aplique bordas a cada célula
            $sheet->getStyle('A'.$linha.':D'.$linha)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN)->getColor()->setRGB('000000');
    
            $linha++;
        }
    
        // Ajuste a largura das colunas automaticamente
        foreach (range('A', 'D') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    
        // Defina o nome do arquivo
        $filename = 'RELATÓRIO_DE_PEDIDOS_' . date('d-m-Y') . '.xlsx';
    
        // Configurações do header para download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
    
        // Saída do arquivo
        $writer = new Xlsx($spreadsheet);
        ob_end_clean(); // Limpa o buffer de saída antes de enviar o arquivo Excel
        $writer->save('php://output');
        exit; // Encerra a execução após enviar o arquivo
    }

    public function exportar_pedidos_all($formato, $usuario_id) {
        if (!$this->session->userdata('logged_in') || $this->session->userdata('usuario_id') != $usuario_id) {
            redirect('login');
        }
    
        // Obter parâmetros de paginação
        $per_page = $this->input->get('per_page') ? $this->input->get('per_page') : 50;
        $page = $this->input->get('page') ? $this->input->get('page') : 0;
    
        // Carregue a biblioteca para exportar para Excel ou PDF
        if ($formato == 'excel') {
            $this->exportar_para_excel_all($usuario_id, $per_page, $page);
        } elseif ($formato == 'pdf') {
            $this->load->library('PDFGenerator');
            $this->exportar_para_pdf($usuario_id, $per_page, $page);
        }
    }

    public function exportar_para_excel_all($usuario_id, $per_page, $page) {
        if (!$this->session->userdata('logged_in') || $this->session->userdata('usuario_id') != $usuario_id) {
            redirect('login');
        }
    
        // Obtenha os pedidos da página atual
        $pedidos = $this->request_db->get_requests($per_page, $page, $usuario_id);
    
        // Crie um novo objeto Spreadsheet
        $spreadsheet = new Spreadsheet();
    
        // Defina o cabeçalho das colunas
        $sheet = $spreadsheet->getActiveSheet();
    
        // Defina o título principal que abrange todas as colunas
        $titulo = 'RELATÓRIO DE TODOS OS PEDIDOS';
        $sheet->setCellValue('A1', $titulo);
        $sheet->mergeCells('A1:D1'); // Ajuste o range conforme o número de colunas
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    
        // Adicione bordas ao título principal
        $sheet->getStyle('A1:D1')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN)->getColor()->setRGB('000000');
    
        // Defina os cabeçalhos das colunas
        $sheet->setCellValue('A2', 'NÚMERO DO PEDIDO')
              ->setCellValue('B2', 'CLIENTE')
              ->setCellValue('C2', 'QUANTIDADE')
              ->setCellValue('D2', 'VALOR');
    
        // Estilize os cabeçalhos
        $sheet->getStyle('A2:D2')->getFont()->setBold(true)->getColor()->setRGB('000000');
        $sheet->getStyle('A2:D2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A2:D2')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN)->getColor()->setRGB('000000');
    
        // Preencha os dados dos pedidos
        $linha = 3;
        foreach ($pedidos as $pedido) {
            $sheet->setCellValue('A'.$linha, $pedido->contato_id)
                  ->setCellValue('B'.$linha, $pedido->nome)
                  ->setCellValue('C'.$linha, $pedido->quantidade)
                  ->setCellValue('D'.$linha, ' R$ '.number_format($pedido->total_pagar, 2, ',', '.'));
    
            // Centralize os dados nos campos
            $sheet->getStyle('A'.$linha.':D'.$linha)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    
            // Ajuste a altura da linha
            $sheet->getRowDimension($linha)->setRowHeight(-1);
    
            // Aplique bordas a cada célula
            $sheet->getStyle('A'.$linha.':D'.$linha)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN)->getColor()->setRGB('000000');
    
            $linha++;
        }
    
        // Ajuste a largura das colunas automaticamente
        foreach (range('A', 'D') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    
        // Defina o nome do arquivo
        $filename = 'RELATÓRIO_DE_TODOS_OS_PEDIDOS_' . date('d-m-Y') . '.xlsx';
    
        // Configurações do header para download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
    
        // Saída do arquivo
        $writer = new Xlsx($spreadsheet);
        ob_end_clean(); // Limpa o buffer de saída antes de enviar o arquivo Excel
        $writer->save('php://output');
        exit; // Encerra a execução após enviar o arquivo
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

    // Função para enviar o e-mail de notificação de compra
    private function send_purchase_email($to_email, $to_name, $to_cpf, $to_rua, $to_num, $to_bairro, $to_city, $to_uf, $quantity, $total) {
        $mail = new PHPMailer(true);
        $mailContent = "";
    
        // Buscando o contato_id do banco de dados
        $to_contato_id = $this->request_db->get_contato_id($to_email, $to_name);
        
        if (!$to_contato_id) {
            log_message('error', 'Erro ao buscar contato_id para ' . $to_email);
            return; // Encerre a função caso não encontre o contato_id
        }
    
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
    
            $mail->Subject = 'Confirmação de Compra - Product Easy';
            $mail->isHTML(true);
    
            // Definindo a codificação do e-mail
            $mail->CharSet = 'UTF-8';
            
            $login_url = base_url('index.php/login');
            // Mensagem do e-mail
            $mailContent = "<h1>Olá, $to_name.</h1>
                    <h1>Seu pedido foi realizado com sucesso!</h1>
                    <p>Segue abaixo, os detalhes do seu pedido:</p>
                    <p>Número do pedido: $to_contato_id</p>
                    <p>Local de entrega: $to_rua, Número: $to_num - Bairro: $to_bairro. </p>
                    <p>Cidade: $to_city / $to_uf </p>
                    <p>CPF: $to_cpf</p>
                    <p>Nome: $to_name.</p>
                    <p>Email: $to_email</p>
                    <p>Quantidade: $quantity Óculos Google Glass.</p>
                    <p>Total a Pagar: R$ $total,00</p>
                    <p>Obrigado por comprar conosco!</p>
                    <p>Para acompanhar o status do seu pedido, clique aqui:</p>
                    <a href='$login_url'>Product Easy</a>";
            $mail->Body = $mailContent;
    
            // Envia o e-mail
            if ($mail->send()) {
                log_message('info', 'E-mail enviado com sucesso para ' . $to_email);
                $this->request_db->log_email($to_email, $mail->Subject, $mailContent, 'success');
            } else {
                log_message('error', 'Erro ao enviar e-mail: ' . $mail->ErrorInfo);
                $this->request_db->log_email($to_email, $mail->Subject, $mailContent, 'failed', $mail->ErrorInfo);
            }
        } catch (Exception $e) {
            log_message('error', 'Erro ao enviar e-mail: ' . $e->getMessage());
            $this->request_db->log_email($to_email, $mail->Subject, $mailContent, 'failed', $e->getMessage());
        }
    }
    
    // Função para enviar o e-mail de notificação de compra para o administrador
    private function send_purchase_email_for_adm($to_email, $to_name, $to_cpf, $to_rua, $to_num, $to_bairro, $to_city, $to_uf, $quantity, $total) {
        $mail = new PHPMailer(true);
        $mailContent = "";

        // Buscando o contato_id do banco de dados
        $to_contato_id = $this->request_db->get_contato_id($to_email, $to_name);
        
        if (!$to_contato_id) {
            log_message('error', 'Erro ao buscar contato_id para ' . $to_email);
            return; // Encerre a função caso não encontre o contato_id
        }

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
            $mail->addAddress('alan_alfenas2020@outlook.com');

            $mail->Subject = 'Confirmação de Compra - Product Easy';
            $mail->isHTML(true);

            // Definindo a codificação do e-mail
            $mail->CharSet = 'UTF-8';

            // Mensagem do e-mail para o administrador
            $mailContent = "<h1>Olá, Despachante!</h1>
                            <h1>Compra realizada. </h1>
                            <p>Segue abaixo, os detalhes do pedido: </p>
                            <p>Número do pedido: $to_contato_id</p>
                            <p>Nome: $to_name.</p>
                            <p>CPF: $to_cpf</p>
                            <p>Email: $to_email</p>
                            <p>Local de entrega: $to_rua, Número: $to_num - Bairro: $to_bairro. </p>
                            <p>Cidade: $to_city / $to_uf </p>
                            <p>Quantidade: $quantity Óculos Google Glass.</p>";
                            // <p>Total a Pagar: R$ $total,00</p>";
            $mail->Body = $mailContent;

            // Envia o e-mail
            if ($mail->send()) {
                log_message('info', 'E-mail enviado com sucesso para o administrador');
                $this->request_db->log_email_despa($to_email, $mail->Subject, $mailContent, 'success');
            } else {
                log_message('error', 'Erro ao enviar e-mail: ' . $mail->ErrorInfo);
                $this->request_db->log_email_despa($to_email, $mail->Subject, $mailContent, 'failed', $mail->ErrorInfo);
            }
        } catch (Exception $e) {
            log_message('error', 'Erro ao enviar e-mail: ' . $e->getMessage());
            $this->request_db->log_email_despa($to_email, $mail->Subject, $mailContent, 'failed', $e->getMessage());
        }
    }

    // Função para enviar o e-mail de notificação de compra
    private function send_purchase_email_update($to_contato_id, $to_email, $to_name, $to_cpf, $to_rua, $to_num, $to_bairro, $to_city, $to_uf, $quantity, $total) {
        $mail = new PHPMailer(true);
        $mailContent = "";

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

            $mail->Subject = 'ATUALIZAÇÃO DE COMPRA - Product Easy';
            $mail->isHTML(true);

            // Definindo a codificação do e-mail
            $mail->CharSet = 'UTF-8';

            $login_url = base_url('index.php/login');
            // Mensagem do e-mail
            $mailContent = "<h1>Olá, $to_name.</h1>
                    <h1>Seu pedido foi atualizado com sucesso!</h1>
                    <p>Segue abaixo, os detalhes da atualização:</p>
                    <p>Número do pedido: $to_contato_id</p>
                    <p>Local de entrega: $to_rua, Número: $to_num - Bairro: $to_bairro. </p>
                    <p>Cidade: $to_city / $to_uf </p>
                    <p>CPF: $to_cpf</p>
                    <p>Nome: $to_name.</p>
                    <p>Email: $to_email</p>
                    <p>Quantidade: $quantity Óculos Google Glass.</p>
                    <p>Total a Pagar: R$ $total,00</p>
                    <p>Obrigado por comprar conosco!</p>
                    <p>Para acompanhar o status do seu pedido, clique aqui:</p>
                    <a href='$login_url'>Product Easy</a>";
            $mail->Body = $mailContent;

            // Envia o e-mail
            if ($mail->send()) {
                log_message('info', 'E-mail enviado com sucesso para ' . $to_email);
                $this->request_db->log_email($to_email, $mail->Subject, $mailContent, 'success');
            } else {
                log_message('error', 'Erro ao enviar e-mail: ' . $mail->ErrorInfo);
                $this->request_db->log_email($to_email, $mail->Subject, $mailContent, 'failed', $mail->ErrorInfo);
            }
        } catch (Exception $e) {
            log_message('error', 'Erro ao enviar e-mail: ' . $e->getMessage());
            $this->request_db->log_email($to_email, $mail->Subject, $mailContent, 'failed', $e->getMessage());
        }
    }

    // Função para enviar o e-mail de notificação de compra para o administrador
    private function send_purchase_email_update_for_adm($to_contato_id, $to_email, $to_name, $to_cpf, $to_rua, $to_num, $to_bairro, $to_city, $to_uf, $quantity, $total) {
        $mail = new PHPMailer(true);
        $mailContent = "";

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
            $mail->addAddress('alan_alfenas2020@outlook.com');

            $mail->Subject = 'ATUALIZAÇÃO DE COMPRA - Product Easy';
            $mail->isHTML(true);

            // Definindo a codificação do e-mail
            $mail->CharSet = 'UTF-8';

            // Mensagem do e-mail para o administrador
            $mailContent = "<h1>Olá, Despachante!</h1>
                            <h1>PEDIDO ATUALIZADO. </h1>
                            <p>Segue abaixo, os detalhes da atualização: </p>
                            <p>Número do pedido: $to_contato_id</p>
                            <p>Nome: $to_name.</p>
                            <p>CPF: $to_cpf</p>
                            <p>Email: $to_email</p>
                            <p>Local de entrega: $to_rua, Número: $to_num - Bairro: $to_bairro. </p>
                            <p>Cidade: $to_city / $to_uf </p>
                            <p>Quantidade: $quantity Óculos Google Glass.</p>";
                            // <p>Total a Pagar: R$ $total,00</p>";
            $mail->Body = $mailContent;

            // Envia o e-mail
            if ($mail->send()) {
                log_message('info', 'E-mail enviado com sucesso para o administrador');
                $this->request_db->log_email_despa($to_email, $mail->Subject, $mailContent, 'success');
            } else {
                log_message('error', 'Erro ao enviar e-mail: ' . $mail->ErrorInfo);
                $this->request_db->log_email_despa($to_email, $mail->Subject, $mailContent, 'failed', $mail->ErrorInfo);
            }
        } catch (Exception $e) {
            log_message('error', 'Erro ao enviar e-mail: ' . $e->getMessage());
            $this->request_db->log_email_despa($to_email, $mail->Subject, $mailContent, 'failed', $e->getMessage());
        }
    }

    private function send_purchase_email_delete($to_contato_id, $to_nome, $to_email, $to_nascimento, $to_cpf, $to_qtd, $to_valor) {
        $mail = new PHPMailer(true);
        $mailContent = "";

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

            $mail->Subject = 'CANCELAMENTO DE COMPRA - Product Easy';
            $mail->isHTML(true);

            // Definindo a codificação do e-mail
            $mail->CharSet = 'UTF-8';

            $login_url = base_url('index.php/login');
            // Mensagem do e-mail
            $mailContent = "<h1>Olá, $to_nome.</h1>
                    <h1>SEU PEDIDO FOI CANCELADO!</h1>
                    <p>Segue abaixo, os detalhes do pedido cancelado:</p>
                    <p>Número do pedido: $to_contato_id</p>
                    <p>Nome: $to_nome.</p>
                    <p>CPF: $to_cpf</p>
                    <p>Email: $to_email</p>
                    <p>Quantidade: $to_qtd Óculos Google Glass.</p>
                    <p>Total a Pagar: R$ $to_valor,00</p>
                    <p>Para ficar por dentro das novidades, acesse:</p>
                    <a href='$login_url'>Product Easy</a>";
            $mail->Body = $mailContent;

            // Envia o e-mail
            if ($mail->send()) {
                log_message('info', 'E-mail enviado com sucesso para ' . $to_email);
                $this->request_db->log_email($to_email, $mail->Subject, $mailContent, 'success');
            } else {
                log_message('error', 'Erro ao enviar e-mail: ' . $mail->ErrorInfo);
                $this->request_db->log_email($to_email, $mail->Subject, $mailContent, 'failed', $mail->ErrorInfo);
            }
        } catch (Exception $e) {
            log_message('error', 'Erro ao enviar e-mail: ' . $e->getMessage());
            $this->request_db->log_email($to_email, $mail->Subject, $mailContent, 'failed', $e->getMessage());
        }
    }

    // Função para enviar o e-mail de notificação de compra para o administrador
    private function send_purchase_email_for_delete_adm($to_contato_id, $to_nome, $to_email, $to_nascimento, $to_cpf, $to_qtd, $to_valor) {
        $mail = new PHPMailer(true);
        $mailContent = "";

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
            $mail->addAddress('alan_alfenas2020@outlook.com');

            $mail->Subject = 'CANCELAMENTO DE COMPRA- Product Easy';
            $mail->isHTML(true);

            // Definindo a codificação do e-mail
            $mail->CharSet = 'UTF-8';

            // Mensagem do e-mail para o administrador
            $mailContent = "<h1>Olá, Despachante!</h1>
                            <h1>PEDIDO CANCELADO.</h1>
                            <p>Segue abaixo, os detalhes do pedido cancelado: </p>
                            <p>Número do pedido: $to_contato_id</p>
                            <p>Cliente: $to_nome </p>
                            <p>CPF: $to_cpf</p>
                            <p>Email: $to_email</p>
                            <p>Quantidade: $to_qtd Óculos Google Glass.</p>";
                            // <p>Total a Pagar: R$ $total,00</p>";
            $mail->Body = $mailContent;

            // Envia o e-mail
            if ($mail->send()) {
                log_message('info', 'E-mail enviado com sucesso para o administrador');
                $this->request_db->log_email_despa($to_email, $mail->Subject, $mailContent, 'success');
            } else {
                log_message('error', 'Erro ao enviar e-mail: ' . $mail->ErrorInfo);
                $this->request_db->log_email_despa($to_email, $mail->Subject, $mailContent, 'failed', $mail->ErrorInfo);
            }
        } catch (Exception $e) {
            log_message('error', 'Erro ao enviar e-mail: ' . $e->getMessage());
            $this->request_db->log_email_despa($to_email, $mail->Subject, $mailContent, 'failed', $e->getMessage());
        }
    }
    
}
?>
