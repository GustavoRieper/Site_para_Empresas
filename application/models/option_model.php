<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Option_model extends CI_Model{

    function __construct(){
        parent::__construct();
    }

    public function get_option($option_name){
        $this->db->where('option_name', $option_name);
        $query = $this->db->get('options', 1);
        if($query->num_rows() == 1):
            $row = $query->row();
            return $row->option_value;
        else:
            return NULL;
        endif;

    }

    public function update_option($option_name, $option_value){
        $this->db->where('option_name', $option_name);
        $query = $this->db->get('options', 1);
        if($query->num_rows() == 1):
            //Opção Já existe, então deve ser atualizada
            $this->db->set('option_value', $option_value);
            $this->db->where('option_name', $option_name);
            $this->db->update('options');
            return $this->db->affected_rows();
        else:
            //Opção não existe, então deve-se inserir
            $dados = array(
                'option_name'   => $option_name,
                'option_value'  => $option_value
            );
            $this->db->insert('options', $dados);
            return $this->db->insert_id(); //Retorna a ID do ultimo sert realiado no banco de dados
        endif;
    }
}