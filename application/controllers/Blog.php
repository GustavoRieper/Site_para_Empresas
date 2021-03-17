<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('option_model', 'option');
        $this->load->model('blog_model', 'blog');
    }

    public function index(){
        redirect('blog/listar', 'refresh');
    }

    public function listar(){
        //Verifica se o usuário está logado
        verifica_login();

        //Carrega View
        $dados['titulo'] = 'Listagem de Posts | Ótica - Brasil';
        $dados['h2'] = 'Listagem de Posts';
        $dados['tela'] = 'listar';
        $dados['blog'] = $this->blog->get();
        $this->load->view('painel/blog', $dados);
    }

    public function cadastrar(){
        //Verifica se o usuário está logado
        verifica_login();

        //regras de validação
        $this->form_validation->set_rules('titulo', 'Título', 'trim|required');
        $this->form_validation->set_rules('conteudo', 'Conteúdo', 'trim|required');

        //Verificação de validação
        if($this->form_validation->run() == false):
            if(validation_errors()):
                set_msg(validation_errors());
            endif;
        else:
            $this->load->library('upload', config_upload());
            if($this->upload->do_upload('imagem')):
                //Upload foi executado
                $dados_upload = $this->upload->data();
                $dados_form = $this->input->post();
                $dados_insert['titulo'] = to_db($dados_form['titulo']);
                $dados_insert['conteudo'] = to_db($dados_form['conteudo']);
                $dados_insert['imagem'] = $dados_upload['file_name'];

                //salvar no Banco de Dados
                if($id = $this->blog->salvar($dados_insert)):
                    set_msg('<p>Postagem cadastrado com sucesso!</p>');
                    redirect('blog/editar/'.$id, 'refresh');
                else:
                    set_msg('<p>Erro! Postagem não cadastrada.</p>');
                endif;
            else:
                //Erro no Upload
                $msg = $this->upload->display_errors();
                $msg .= '<p>São pertmitidos apenas arquivos em JPG e PNG com até 512KB.</p>';
                set_msg($msg);
            endif;
        endif;

        //Carrega View
        $dados['titulo'] = 'Cadastrar Postagem | Ótica - Brasil';
        $dados['h2'] = 'Cadastrar Postagem';
        $dados['tela'] = 'cadastrar';
        $this->load->view('painel/blog', $dados);
    }

    public function excluir(){
        //Verifica se o usuário está logado
        verifica_login();

        //Verirfica se foi passado o IR da Noticia
        $id = $this->uri->segment(3);
        if($id > 0):
            //Id informado, continua com exclusão
            if($blog = $this->blog->get_single($id)):
                $dados['blog'] = $blog;
            else:
                set_msg('<p>Postagem inexistente! Escolha uma postagem para excluir.</p>');
                redirect('blog/listar', 'refresh');
            endif;
        else:
            //Se não foi informado um ID na URL
            set_msg('<p>Você deve scolher uma postagem para excluir</p>');
            redirect('blog/listar', 'refresh');
        endif;

        //Regras de Validação
        $this->form_validation->set_rules('enviar', 'Enviar', 'trim|required');

        //Verificação de validação
        if($this->form_validation->run() == false):
            if(validation_errors()):
                set_msg(validation_errors());
            endif;
        else:
            $imagem = 'uploads/' . $blog->imagem;
            if($this->blog->excluir($id)):
                unlink($imagem);
                set_msg('<p>Postagem excluída com sucesso!</p>');
                redirect('blog/listar', 'refresh');
            else:
                set_msg('<p>Erro! Nenhuma postagem excluiída.</p>');
            endif;
        endif;

        //Carrega View
        $dados['titulo'] = 'Excluir Postagem | Ótica - Brasil';
        $dados['h2'] = 'Excluir Postagem';
        $dados['tela'] = 'excluir';
        $this->load->view('painel/blog', $dados);
    }

    public function editar(){
        //Verifica se o usuário está logado
        verifica_login();

        //Verirfica se foi passado o IR da Noticia
        $id = $this->uri->segment(3);
        if($id > 0):
            //Id informado, continua com a edição
            if($blog = $this->blog->get_single($id)):
                $dados['blog'] = $blog;
                $dados_update['id'] = $blog->id;
            else:
                set_msg('<p>Postagem inexistente! Escolha uma postagem para editar.</p>');
                redirect('blog/listar', 'refresh');
            endif;
        else:
            //Se não foi informado um ID na URL
            set_msg('<p>Você deve scolher uma postagem para editar</p>');
            redirect('blog/listar', 'refresh');
        endif;

        //regras de validação
        $this->form_validation->set_rules('titulo', 'Título', 'trim|required');
        $this->form_validation->set_rules('conteudo', 'Conteúdo', 'trim|required');

        //Verificação de validação
        if($this->form_validation->run() == false):
            if(validation_errors()):
                set_msg(validation_errors());
            endif;
        else:
            $this->load->library('upload', config_upload());
            if(isset($_FILES['imagem']) && $_FILES['imagem']['name'] != ''):
                //Foi enviado uma image, devo fazer upload
                if($this->upload->do_upload('imagem')):
                    //Se o Upload foi efeturado
                    $imagem_antiga = 'uploads/' .$blog->imagem;
                    $dados_upload = $this->upload->data();
                    $dados_form = $this->input->post();
                    $dados_update['titulo'] = to_db($dados_form['titulo']);
                    $dados_update['conteudo'] = to_db($dados_form['conteudo']);
                    $dados_update['imagem'] = $dados_upload['file_name'];
                    if($this->blog->salvar($dados_update)):
                        unlink($imagem_antiga);
                        set_msg('<p>Postagem alterada com sucesso!</p>');
                        $dados['blog']->imagem = $dados_update['imagem'];
                    else:
                        set_msg('<p>Erro! Nenhuma alteração foi salva.</p>');
                    endif;
                else:
                    //Erro no Upload
                    $msg = $this->upload->display_errors();
                    $msg .= '<p>São pertmitidos apenas arquivos em JPG e PNG com até 512KB.</p>';
                    set_msg($msg);
                endif;
            else:
                //Não foi enviado uma imagem
                $dados_form = $this->input->post();
                $dados_update['titulo'] = to_db($dados_form['titulo']);
                $dados_update['conteudo'] = to_db($dados_form['conteudo']);
                if($this->blog->salvar($dados_update)):
                    set_msg('<p>Postagem alterada com sucesso!</p>');
                else:
                    set_msg('<p>Erro! Nenhuma alteração foi salva.</p>');
                endif;
            endif;
        endif;

        //Carrega View
        $dados['titulo'] = 'Alterar Postagem | Ótica - Brasil';
        $dados['h2'] = 'Alterar Postagem';
        $dados['tela'] = 'editar';
        $this->load->view('painel/blog', $dados);
    }

}