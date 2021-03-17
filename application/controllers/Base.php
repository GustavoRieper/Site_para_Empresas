<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Base extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->helper('url'); //Esta função deve estar presente para utilizar o "BASE_URL, SITE_URL" entre outros.
    }

    public function index(){
        $this->load->helper('form');
        $this->load->library(array('form_validation', 'email'));
        $this->load->model('blog_model', 'blog');

        //Regra de Validação do formulário
        $this->form_validation->set_rules('nome', 'Nome', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('assunto', 'Assunto', 'trim|required');
        $this->form_validation->set_rules('mensagem', 'Mensagem', 'trim|required');
        if($this->form_validation->run() == FALSE):
            $dados['formerror'] = validation_errors();
        else:
            $dados_form = $this->input->post();
            $this->email->from($dados_form['email'], $dados_form['nome']);
            $this->email->to('gustavorieper@gmail.com');
            $this->email->subject($dados_form['assunto']);
            $this->email->message($dados_form['mensagem']);
            if($this->email->send()):
                $dados['formerror'] = '<p id="sucess">Mensagem enviada com sucesso!</p>';
                $this->load->view('index', $dados);
            else:
                $dados['formerror'] = '<p id="erro">Ops... Algo de errado aconteceu. Tente novamente em minutos.</p>';
                $this->load->view('index', $dados);
            endif;
        endif;

        $dados['titulo'] = 'Home';
        $this->load->view('index', $dados);
    }
    public function blog(){
        $dados['titulo'] = 'Blog';
		$this->load->view('blog', $dados);
    }
}
