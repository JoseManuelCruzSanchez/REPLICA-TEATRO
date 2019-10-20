<?php

get_header();
get_sidebar('new-sidebar2');
get_sidebar('new-sidebar');
?>

<div class="fullpage-gallery event-gallery">
    <?php
    // Start the Loop.
    while ( have_posts() ) : the_post();

        // Include the page content template.
        get_template_part( 'content', 'page' );

        ?>
            <div id="contenedor-detalle-evento">
                <div id="col-izq">
                    <div id="contenedor-compartir">
                        <?php echo dame_share_buttons(get_permalink(get_the_ID()), get_field('titulo_del_evento', get_the_ID())) ?>
                    </div>
                    <div id="titulo-categoria">
                        <div id="titulo"><h2><?php echo get_field('titulo_del_evento', get_the_ID()); ?></h2></div>
                        <div id="categoria" style="background-color:<?php echo get_field('categoria_del_evento', get_the_ID()); ?>;"></div>

                    </div>
                    <div>
                        <p><?php echo get_field('descripcion_principal', get_the_ID()); ?></p>
                    </div>
                    <img src="<?php echo get_field('imagen_del_evento', get_the_ID()); ?>">
                </div>
                <div id="col-drch">
                    <img src="<?php echo get_field('imagen_del_evento', get_the_ID()); ?>">

                    <p>creador/a: <?php echo get_field('creador_del_evento', get_the_ID()); ?></p>
                    <p>hora: <?php echo get_field('hora_del_evento', get_the_ID()); ?> h.</p>
                    <p>precio: <?php echo get_field('precio_del_evento', get_the_ID()); ?> €</p>
                    <p>añadir al calendario</p>
                    <a href="<?php echo get_field('enlace_compra_entrada_evento', get_the_ID()); ?>"><p>ENTRADA ONLINE</p></a>
                </div>
            </div>
        <?php
    endwhile;
    ?>
</div>

<?php

function dame_share_buttons($url_post, $titulo_post){
    $url = urlencode($url_post);
    return '<p id="compartir" onclick="aparece(this.nextElementSibling)">compartir</p>
            <div id="popup-share-btns" class="">
                <!-- WHATSAPP -->
                <a href="whatsapp://send?text=' . $url . '" data-action="share/whatsapp/share">
                    <!--<img src="https://findicons.com/files/icons/2789/light/128/whatsapp.png">-->
                    <img src="http://localhost/02wordpress/wp-content/uploads/2019/10/whatsapp.svg">

                </a>
                <!-- EMAIL -->
                <a href="mailto:?subject=' . $titulo_post . ' &amp;body=' . $url . '" title="Share by Email">
                    <!--<img src="https://findicons.com/files/icons/832/social_and_web/64/gmail.png">-->
                    <img src="http://localhost/02wordpress/wp-content/uploads/2019/10/email.svg">

                </a>

                <!-- TWITTER -->
                <a href="https://twitter.com/share?url=' . $url . '">
                    <!--<img src="https://findicons.com/files/icons/818/aquaticus_social/64/twitter.png">-->
                    <img src="http://localhost/02wordpress/wp-content/uploads/2019/10/twitter.svg">

                </a>

                <!-- LINKEDIN -->
                <a href="https://www.linkedin.com/shareArticle?mini=true&url=' . $url . '&title=' . $titulo_post . '">
                    <!--<img src="https://findicons.com/files/icons/819/social_me/64/linkedin.png">-->
                    <img src="http://localhost/02wordpress/wp-content/uploads/2019/10/linkedin.svg">
                </a>
                <!-- FACEBOOK -->
                <a href="https://www.facebook.com/sharer/sharer.php?u=' . $url . '" target="_blank" rel="noopener">
                    <!--<img src="https://findicons.com/files/icons/2052/social_network/32/facebook.png">-->
                    <img src="http://localhost/02wordpress/wp-content/uploads/2019/10/facebook.svg">
                </a>
            </div>';
}
get_footer();









