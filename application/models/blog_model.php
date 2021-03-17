<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog_model extends CI_Model{

    function __construct(){
        parent::__construct();
    }
    
    public function salvar($dados){
        if(isset($dados['id']) && $dados['id'] > 0):
            //Notícia já existe, devo editar
            $this->db->where('id', $dados['id']);
            unset($dados['id']);
            $this->db->update('blog', $dados);
            return $this->db->affected_rows();
        else:
            //Nóticia não existe, devo cadastrar
            $this->db->insert('blog', $dados);
            return $this->db->insert_id();
        endif;
    }

    public function get($limit=3, $offset=0){
        if($limit == 0): 
            $this->db->order_by('id', 'desc');
            $query = $this->db->get('blog');
            if($query->num_rows() > 0):
                return $query->result();
            else:
                return NULL;
            endif;
        else:
            $this->db->order_by('id', 'desc');
            $query = $this->db->get('blog', $limit);
            if($query->num_rows() > 0):
                return $query->result();
            else:
                return NULL;
            endif;
        endif;

    }

    public function get_single($id=0){
        $this->db->where('id', $id);
        $query = $this->db->get('blog', 1);
        if($query->num_rows() == 1):
            $row = $query->row();
            return $row;
        else:
            return NULL;
        endif;
    }

    public function excluir($id=0){
        $this->db->where('id', $id);
        $this->db->delete('blog');
        return $this->db->affected_rows();
    }
}