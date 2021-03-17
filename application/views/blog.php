<?php include("header.php"); ?>
<div class="blog">
    <div class="row1">
        <span>Confira nossas postagens para ajudar na escolha do melhor óculos para você</span>
        <div class="post">
            <div class="zone1">
                <?php
                    if($blog = $this->blog->get(3)):
                        foreach($blog as $linha):
                        ?>
                            <img src="<?php base_url('uploads/'.$linha->imagem); ?>">
                        
            </div>
            <div class="zone2">
                <h2><?php echo to_html($linha->titulo); ?></h2>
                <p><?php echo resumo_post($linha->conteudo); ?>...
            <a href="<?php echo base_url('post/'.$linha->id); ?>">Leia mais &raquo;</a></p>
                <?php
                        endforeach;
                    else:
                        echo '<p>Nenhuma postagem cadastrada.</p>';
                    endif;
                ?>
            </div>
        </div>
    </div>
    <div class="row2">
        <img src="<?php echo base_url('assets/img/inicio/womam.png'); ?>">
    </div>
</div>