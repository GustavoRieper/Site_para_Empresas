<?php
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/inicio.css'); ?>"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/reset.css'); ?>"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/painel.css'); ?>"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/jquery-te-1.4.0.css'); ?>"/>
        <script type="text/javascript" src="<?php echo base_url('assets/js/jquery-3.6.0.min.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/jquery-te-1.4.0.min.js'); ?>"></script>
        <title><?php echo $titulo ?> | Ótica - Brasil</title>
        <style>
            .menu{
                position: relative;
                float: right;
                margin-right: 50px;
            }
            .menu li{
                font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
                display: inline;
                text-transform: uppercase;
                font-size:14pt;
                transition: all 0.2s;
            }
            .menu li a{
                text-decoration:none;
                color: #b60202;
            }
            .menu li a:hover{
                color:#e95050;
                transition: all 0.2s;
            }
        </style>
</head>
<body>
    <section class="sessao1">
        <h1> A maior rede de ótica do Brasil</h1>
        <div id="back_section1">
            <a href="<?php base_url(); ?>">        
                <img id="logo_sessao1" src="<?php echo base_url('assets/img/padroes/logo.png'); ?>" title="Frederique Constant" />
            </a>
            <nav>
                <ul class="menu">
                    <li><a target="_BLANK" href="<?php echo base_url(); ?>">Ver site</a> | </li>
                    <li><a href="<?php echo base_url('blog/listar'); ?>">Blog</a> | </li>
                    <li><a href="<?php echo base_url('setup'); ?>">Configurações</a> | </li>
                    <li><a href="<?php echo base_url('setup/logout'); ?>">Sair</a></li>
                </ul>
            </nav>
        </div>
    </section>