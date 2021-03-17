
<?php $this->load->view('painel/header'); ?>
<div class="linha blog-list">
    <div class="coluna col2">
        <ul class="menu">
            <li><a href="<?php echo base_url('blog/cadastrar'); ?>">Inserir</a> | </li>
            <li><a href="<?php echo base_url('blog/listar'); ?>">Listar</a> | </li>
        </ul>
    </div>
    <div class="coluna col10">
        <h2><?php echo $h2; ?></h2>
        <?php
            if($msg = get_msg()):
                echo '<div class="msg-box">'.$msg.'</div>';
            endif;
            switch ($tela):
                case 'listar':
                    if(isset($blog) && sizeof($blog) > 0):
                        ?>
                        <table>
                            <thead>
                                <th align="left">Título</th>
                                <th align="right">Ações</th>
                            </thead>
                            <tbody>
                                <?php
                                    foreach($blog as $linha):
                                        ?>
                                        <tr>
                                            <td class="titulo-blog"><?php echo $linha->titulo; ?></td>
                                            <td align="right" class="acoes">
                                                <?php echo anchor('blog/editar/'.$linha->id, 'Editar'); ?> | 
                                                <?php echo anchor('blog/excluir/'.$linha->id, 'Excluir'); ?> |
                                                <?php echo anchor('blog/'.$linha->id, 'Visualizar', array('target' => '_blank')); ?>
                                            </td>
                                        </tr>
                                        <?php
                                    endforeach
                                ?>
                            </tbody>
                        </table>
                        <?php
                    else:
                        echo '<div class="msg-box"><p>Nenhuma postagem cadastrada!</p></div>';
                    endif;
                break;
                case 'cadastrar':
                    echo form_open_multipart();
                    echo form_label('Título:', 'titulo');
                    echo form_input('titulo', set_value('titulo'));
                    echo form_label('Conteúdo:', 'conteudo');
                    echo form_textarea('conteudo', to_html(set_value('conteudo')), array('class' => 'editorhtml'));
                    echo form_label('Imagem da postagem (Thumbnail):', 'imagem');
                    echo form_upload('imagem');
                    echo form_submit('enviar', 'Salvar Postagem');
                    echo form_close();
                break;
                case 'editar':
                    echo form_open_multipart();
                    echo form_label('Título:', 'titulo');
                    echo form_input('titulo', set_value('titulo', to_html($blog->titulo)));
                    echo form_label('Conteúdo:', 'conteudo');
                    echo form_textarea('conteudo', to_html(set_value('conteudo', to_html($blog->conteudo))), array('class' => 'editorhtml'));
                    echo '<p><small>Imagem Atual:</small><br><img src="'.base_url('uploads/'.$blog->imagem).'" class="thumb-edicao"></p>';
                    echo form_label('Imagem da postagem (Thumbnail):', 'imagem');
                    echo form_upload('imagem');
                    echo form_submit('enviar', 'Atualizar Postagem');
                    echo form_close();
                break;
                case 'excluir':
                    echo form_open_multipart();
                    echo form_label('Título:', 'titulo');
                    echo form_input('titulo', set_value('titulo', to_html($blog->titulo)));
                    echo form_label('Conteúdo:', 'conteudo');
                    echo form_textarea('conteudo', to_html(set_value('conteudo', to_html($blog->conteudo))), array('class' => 'editorhtml'));
                    echo '<p><small>Imagem:</small><br><img src="'.base_url('uploads/'.$blog->imagem).'" class="thumb-edicao"></p>';
                    echo form_submit('enviar', 'Excluir Postagem');
                    echo form_close();
                break;
            endswitch;

        ?>
    </div>
</div>
<?php $this->load->view('painel/footer'); ?>