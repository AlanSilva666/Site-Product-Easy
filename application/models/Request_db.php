<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Request_db extends CI_Model {

    public function verify_login($cpf, $password) {
        $this->db->where('cpf', $cpf);
        $query = $this->db->get('usuario');

        if ($query->num_rows() == 1) {
            $user = $query->row();
            if (password_verify($password, $user->senha)) {
                return $user; // Retorna o objeto do usuário completo
            }
        }
        return FALSE;
    }
    
    public function cpf_exists($cpf) {
        $this->db->where('cpf', $cpf);
        $query = $this->db->get('usuario');
        return $query->num_rows() > 0;
    }

    public function get_user_by_cpf($cpf) {
        $this->db->where('cpf', $cpf);
        $query = $this->db->get('usuario'); // Supondo que a tabela do usuário seja 'users'
        return $query->row();
    }

    public function get_contato_id($email, $name) {
        $this->db->select('contato_id');
        $this->db->from('contato_cliente_1'); // Substitua pelo nome correto da sua tabela de contatos
        $this->db->where('email', $email);
        $this->db->where('nome', $name);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->row()->contato_id;
        } else {
            return null;
        }
    }

    public function get_request_by_id($usuario_id, $contato_id) {
        $this->db->where('usuario_id', $usuario_id);
        $this->db->where('contato_id', $contato_id);
        $query = $this->db->get('contato_cliente_1');
        return $query->row();
    }
    
    // public function register_request($data) {
    //     return $this->db->insert('contato_cliente_1', $data);
    // }

    public function register_request($dados) {
        // Faz o hash da senha
        // $dados['senha'] = password_hash($dados['senha'], PASSWORD_BCRYPT);
    
        // Inserir na tabela contato_cliente_1
        $this->db->insert('contato_cliente_1', $dados);
    
        // Registrar na tabela de log (log_registros)
        $log_data = array(
            'acao' => 'INSERÇÃO DE PEDIDO',
            'tabela_afetada' => 'contato_cliente_1',
            'id_afetado' => $this->db->insert_id()  // ID inserido na tabela contato_cliente_1
        );
    
        $this->db->insert('log', $log_data);
    
        return $this->db->insert_id();  // Retorna o ID inserido na tabela contato_cliente_1
    }

    public function update_request_data($usuario_id, $contato_id, $dados) {
        // Define as condições para a atualização
        $this->db->where('usuario_id', $usuario_id);
        $this->db->where('contato_id', $contato_id);
    
        // Executa a atualização na tabela contato_cliente_1
        $this->db->update('contato_cliente_1', $dados);
    
        // Prepara os dados para inserção no log
        $log_data = array(
            'acao' => 'ATUALIZAÇÃO DE PEDIDO',
            'tabela_afetada' => 'contato_cliente_1',
            'id_afetado' => $usuario_id,  // ID do usuário afetado
            'id_contato_id' => $contato_id  // ID do contato afetado
        );
    
        // Insere os dados no log
        $this->db->insert('log', $log_data);
    
        // Retorna o ID da inserção no log
        return $this->db->insert_id();
    }
    
    // Função para obter todas as solicitações
    public function get_all_requests() {
        $query = $this->db->get('contato_cliente_1');
        return $query->result();
    }

    public function get_requests($limit, $offset, $usuario_id) {
        $this->db->select('*');
        $this->db->from('contato_cliente_1');
        $this->db->where('usuario_id', $usuario_id);
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        return $query->result();
    }
    
    public function count_all_requests($usuario_id) {
        $this->db->where('usuario_id', $usuario_id);
        return $this->db->count_all_results('contato_cliente_1');
    }
    

    public function update_password($cpf, $new_password) {
        $this->db->set('senha', $new_password);
        $this->db->where('cpf', $cpf);
        return $this->db->update('usuario');
    }
    
    public function del_register($usuario_id, $contato_id) {
        // Define as condições para a deleção
        $this->db->where('usuario_id', $usuario_id);
        $this->db->where('contato_id', $contato_id);
        
        // Executa a deleção na tabela contato_cliente_1
        $deleted = $this->db->delete('contato_cliente_1');
        
        if ($deleted) {
            // Prepara os dados para inserção no log
            $log_data = array(
                'acao' => 'REMOÇÃO DE PEDIDO',
                'tabela_afetada' => 'contato_cliente_1',
                'id_afetado' => $usuario_id,  // ID do usuário afetado
                'id_contato_id' => $contato_id  // ID do contato afetado
            );
            
            // Insere os dados no log
            $this->db->insert('log', $log_data);
    
            return true; // Retorna verdadeiro se a deleção foi bem-sucedida
        } else {
            return false; // Retorna falso se a deleção falhou
        }
    }
    
    public function log_email($to_email, $subject, $body, $status, $error_message = NULL) {
        $data = array(
            'to_email' => $to_email,
            'subject' => $subject,
            'body' => $body,
            'status' => $status,
            'error_message' => $error_message
        );
        return $this->db->insert('email_logs_client', $data);
    }

    public function log_email_despa($to_email, $subject, $body, $status, $error_message = NULL) {
        $data = array(
            'to_email' => $to_email,
            'subject' => $subject,
            'body' => $body,
            'status' => $status,
            'error_message' => $error_message
        );
        return $this->db->insert('email_logs_despa', $data);
    }

    

}
?>
