<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('set_msg')):
    //Seta uma mensagem via session para ser lida posteriormente.
    function set_msg($msg=NULL){
        $ci = & get_instance();
        $ci->session->set_userdata('aviso', $msg);
    }
endif;

if(!function_exists('get_msg')):
    //Retorna uma mensagem definida pela função SET_MSG
    function get_msg($destroy=TRUE){
        $ci = & get_instance();
        $retorno = $ci->session->userdata('aviso');
        if($destroy) $ci->session->unset_userdata('aviso');
        return $retorno;
    }
endif;

if(!function_exists('verifica_login')):
    //Verifica se o usuário está logado, caso negativa, redireciona para outra página
    function verifica_login($redirect='setup/login'){
        $ci = & get_instance();
        if($ci->session->userdata('logged') != TRUE):
            set_msg('<p>Acesso restrito! Faça login para continuar</p>');
            redirect($redirect, 'refresh');
        endif;
    }
endif;

if(!function_exists('config_upload')):
    //Define as Configurações para upload de imagens/arquivos
    function config_upload($path='./uploads/', $types='jpg|png', $size=512){
        $config['upload_path'] = $path;
        $config['allowed_types'] = $types;
        $config['max_size'] = $size;
        return $config;
    }
endif;

if(!function_exists('to_db')):
    //Codifica o html para salvar no Banco de Dados
    function to_db($string=NULL){
        return htmlentities($string);
    }
endif;

if(!function_exists('to_html')):
    //Codifica o html para salvar no Banco de Dados
    function to_html($string=NULL){
        return html_entity_decode($string);
    }
endif;

if(!function_exists('resumo_post')):
    //Gera um texto parcial a partir do conteúdo de um post
    function resumo_post($string=NULL, $tamanho=100){
        $string = to_html($string);
        $string = strip_tags($string);
        $string = substr($string, 0, $tamanho);
    }
endif;
