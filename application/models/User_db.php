<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_db extends CI_Model {

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

    // public function get_user_by_cpf($cpf) {
    //     $this->db->where('cpf', $cpf);
    //     $query = $this->db->get('usuario'); // Supondo que a tabela do usuário seja 'users'
    //     return $query->row();
    // }

    public function register_user($dados) {
        // Faz o hash da senha
        $dados['senha'] = password_hash($dados['senha'], PASSWORD_BCRYPT);
    
        // Inserir na tabela contato_cliente_1
        $this->db->insert('usuario', $dados);
    
        // Registrar na tabela de log (log_registros)
        $log_data = array(
            'acao' => 'INSERÇÃO USUÁRIO',
            'tabela_afetada' => 'usuario',
            'id_afetado' => $this->db->insert_id()  // ID inserido na tabela contato_cliente_1
        );
    
        $this->db->insert('log', $log_data);
    
        return $this->db->insert_id();  // Retorna o ID inserido na tabela contato_cliente_1
    }

    public function update_password($cpf, $new_password) {
        // Atualiza a senha na tabela usuario
        $this->db->set('senha', $new_password);
        $this->db->where('cpf', $cpf);
        $this->db->update('usuario');

        return $this->db->affected_rows();  // Retorna o número de linhas afetadas
    }

    public function get_user_by_cpf($cpf) {
        $this->db->select('*');
        $this->db->from('usuario');
        $this->db->where('cpf', $cpf);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return null;
    }


}
?>
