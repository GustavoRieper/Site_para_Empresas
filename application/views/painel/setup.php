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
        <div class="coluna col3">&nbsp;</div>
        <div class="coluna col6">
            <h2><?php echo $h2; ?></h2>
            <?php
                if($msg = get_msg()):
                    echo '<div class="msg-box">'.$msg.'</div>';
                endif;
                echo form_open();
                echo form_label('Nome para Login', 'login');
                echo form_input('login', set_value('login'), array('autofocus' => 'autofocus'));
                echo form_label('Email', 'email');
                echo form_input('email', set_value('email'));
                echo form_label('Senha', 'senha');
                echo form_password('senha', set_value('senha'));
                echo form_label('Repetir Senha', 'senha2');
                echo form_password('senha2', set_value('senha2'));
                echo form_submit('enviar', 'Salvar', array('class' => 'enviar'));
                echo form_close();
            ?>
        </div>
        <div class="coluna col3">&nbsp;</div>
    </div>
</body>
</html>