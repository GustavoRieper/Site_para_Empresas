<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setup extends CI_Controller{

    function __construct(){
        parent::__construct();
        $this->load->helper('form'); //Para criar os formulários
        $this->load->library('form_validation');
        $this->load->model('option_model', 'option');
    }

    public function index(){
        if($this->option->get_option('setup_executado') == 1):
            //Setup ok.
            redirect('setup/alterar', 'refresh');
        else:
            //Sistema Não instalado
            redirect('setup/instalar', 'refresh');
        endif;
    }

    public function instalar(){
        if($this->option->get_option('setup_executado') == 1):
            //Setup ok.
            redirect('setup/alterar', 'refresh');
        endif;
        
        //Regras de Validação do Forumário
        $this->form_validation->set_rules('login', '<b>Login</b>', 'trim|required|min_length[5]');
        $this->form_validation->set_rules('email', '<b>Email</b>', 'trim|required|valid_email');
        $this->form_validation->set_rules('senha', '<b>Senha</b>', 'trim|required|min_length[6]');
        $this->form_validation->set_rules('senha2', '<b>Repetir senha</b>', 'trim|required|min_length[6]|matches[senha]');// Função MATCHES[SENHA] indica que o campo deve ser igual ao indicado

        //Verificação de validação
        if($this->form_validation->run() == false):
            if(validation_errors()):
                set_msg(validation_errors());
            endif;
        else:
            $dados_form = $this->input->post();
            $this->option->update_option('user_login', $dados_form['login']);
            $this->option->update_option('user_email', $dados_form['email']);
            $this->option->update_option('user_pass', password_hash($dados_form['senha'], PASSWORD_DEFAULT));//Ele cria uma senha criptografada
            $inserido = $this->option->update_option('setup_executado', 1);
            if($inserido):
                set_msg('<p>Sistema Instalado com sucesso, utilize os dados cadastrados para logar no Sistema.</p>');
                redirect('setup/login', 'refresh');
            endif;
        endif;

        //Carrega View
        $dados['titulo'] = 'Setup Admin | Ótica - Brasil';
        $dados['h2'] = 'Setup do Sistema';
        $this->load->view('painel/setup', $dados);
    }
    public function login(){
        if($this->option->get_option('setup_executado') != 1):
            //Setup não está instalado, então redirecionar para tela de instalação do SETUP
            redirect('setup/instalar', 'refresh');
        endif;
        //Regras de Validação
        $this->form_validation->set_rules('login', '<b>Login</b>', 'trim|required|min_length[5]');
        $this->form_validation->set_rules('senha', '<b>Senha</b>', 'trim|required|min_length[6]');

        //Verificação de validação
        if($this->form_validation->run() == false):
            if(validation_errors()):
                set_msg(validation_errors());
            endif;
        else:
            $dados_form = $this->input->post();
            if($this->option->get_option('user_login') == $dados_form['login']):
                //Usuário existe
                if(password_verify($dados_form['senha'], $this->option->get_option('user_pass'))):
                    //Senha correta
                    $this->session->set_userdata('logged', TRUE);
                    $this->session->set_userdata('user_login', $dados_form['login']);
                    $this->session->set_userdata('user_email', $this->option->get_option('user_email'));
                    //Fazer redirect para home do painel
                    redirect('setup/alterar','refresh');
                else:
                    //Senha Incorreta
                    set_msg('<p>Senha incorreta!</p>');
                endif;
            else:
                //Usuário não existe
                set_msg('<p>Usuário inexistente!</p>');
            endif;
        endif;

        //Carrega a View
        $dados['titulo'] = 'Acesso ao Sistema | Ótica - Brasil';
        $dados['h2'] = 'Acessar o painel';
        $this->load->view('painel/login', $dados);
    }

    public function alterar(){
        //verificar o login do usuário
        verifica_login();
        //Regras de Validação
        $this->form_validation->set_rules('login', '<b>Login</b>', 'trim|required|min_length[5]');
        $this->form_validation->set_rules('email', '<b>Email</b>', 'trim|required|valid_email');
        $this->form_validation->set_rules('senha', '<b>Senha</b>', 'trim|min_length[6]');
        if(isset($_POST['senha']) && $_POST['senha'] != ''):
            $this->form_validation->set_rules('senha2', 'Repita a senha', 'trim|required|min_lenght[6]|matches[senha]');
        endif;
        //Verificação de validação
        if($this->form_validation->run() == false):
            if(validation_errors()):
                set_msg(validation_errors());
            endif;
        else:
            $dados_form = $this->input->post();
            $this->option->update_option('user_login', $dados_form['login']);
            $this->option->update_option('user_email', $dados_form['email']);
            if(isset($dados_form['senha']) && $dados_form['senha'] != ''):
                $this->option->update_option('user_pass', password_hash($dados_form['senha'], PASSWORD_DEFAULT));
            endif;
            set_msg('<p>Dados atualizado com sucesso!</p>');
        endif;
        //Carrega View
        $_POST['login'] = $this->option->get_option('user_login');
        $_POST['email'] = $this->option->get_option('user_email');
        $dados['titulo'] = 'Painel Admin | Ótica - Brasil';
        $dados['h2'] = 'Alterar Configurações básicas';
        $this->load->view('painel/config', $dados);
    }

    public function logout(){
        //Destroi os dados da sessão
        $this->session->unset_userdata('logged');
        $this->session->unset_userdata('user_login');
        $this->session->unset_userdata('user_email');
        set_msg('<p>Logout realizado com sucesso!</p>');
        redirect('setup/login', 'refresh');
    }
}