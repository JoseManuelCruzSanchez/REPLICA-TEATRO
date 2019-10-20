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
get_footer();









