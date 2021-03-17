<?php
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/inicio.css'); ?>"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/reset.css'); ?>"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/painel.css'); ?>"/>
        <title><?php echo $titulo ?> | Ótica - Brasil</title>
</head>
<body>
    <div class="linha">
        <div class="coluna col4">&nbsp;</div>
        <div class="coluna col4">
            <h2><?php echo $h2; ?></h2>
            <?php
                if($msg = get_msg()):
                    echo '<div class="msg-box">'.$msg.'</div>';
                endif;
                echo form_open();
                echo form_label('Usuário', 'login');
                echo form_input('login', set_value('login'), array('autofocus' => 'autofocus'));
                echo form_label('Senha', 'senha');
                echo form_password('senha');
                echo form_submit('enviar', 'Acessar', array('class' => 'enviar'));
                echo form_close();
            ?>
        </div>
        <div class="coluna col4">&nbsp;</div>
    </div>
</body>
</html>