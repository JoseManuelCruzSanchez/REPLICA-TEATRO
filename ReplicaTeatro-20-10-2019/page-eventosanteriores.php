<?php
/**
Template Name: EVENTOS ANTERIORES Page
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package starter
 */

get_header();
get_sidebar('new-sidebar2');
get_sidebar('new-sidebar');

?>



    <div class="flex-container contenedor-cruz-estudio" style="overflow-y: auto">

        <section><h2>fecha</h2><h2>evento</h2><h2>creador/a</h2></section>
        <div id="accordion" style="display: none">

        <?php
            $fecha_hoy = DateTime::createFromFormat('d/m/Y', date('d/m/Y'));

            $loop = new WP_Query(array( 'post_type' => 'eventos',
                                        'posts_per_page' => -1,
                                        'meta_key' => 'fecha_del_evento',
                                        'orderby' => 'meta_value',
                                        'order' => 'asc') );
            while ( $loop->have_posts() ) {
                $loop->the_post();
                $fecha_post = DateTime::createFromFormat('d/m/Y', get_field('fecha_del_evento', get_the_ID()));
                if($fecha_post < $fecha_hoy) {
	                ?>
                    <h3 class="no-padding">
                        <div>
                            <div><p><?php echo $fecha_post->format('d.m.Y'); ?></p></div>
                            <div class="categoria-titulo">
                                <div class="color-categoria"
                                     style="background-color:<?php echo get_field( 'categoria_del_evento', get_the_ID() ); ?>;"></div>
                                <p><?php echo get_field( 'titulo_del_evento', get_the_ID() ) ?></p>
                            </div>
                            <div><p><?php echo get_field( 'creador_del_evento', get_the_ID() ) ?></p></div>
                        </div>
                    </h3>
                    <div class="row margin-none">
                        <div class="col-xs-2" onclick="toggle_ampliar_imagen(this)" onmouseover="ampliar_imagen(this)">
                            <img src="<?php echo get_field( 'imagen_del_evento', get_the_ID() ) ?>">
                        </div>
                        <div class="col-xs-10">
                            <p>
				                <?php echo get_field( 'descripcion_secundaria', get_the_ID() ) ?>
                            </p>
                        </div>
                    </div>
	                <?php
                }
            }
            wp_reset_query();
            ?>
            <!--<h3 class="no-padding">
                <div>
                    <div><p>27.06.2019</p></div>
                    <div class="categoria-titulo">
                        <div class="color-categoria"></div>
                        <p>El color de agosto de paloma</p>
                    </div>
                    <div><p>vel erat</p></div>
                </div>
            </h3>
            <div class="row margin-none">
                <div class="col-xs-2">
                    <img src="http://localhost/02Wordpress/wp-content/uploads/2019/10/mostafa-meraji-pxAwsJCsD6Q-unsplash.jpg">
                </div>
                <div class="col-xs-10">
                    <p>Es un hecho establecido hace demasiado tiempo que un lector se distraerá con el contenido del
                        texto de un sitio mientras que mira su diseño. El punto de usar Lorem Ipsum es que tiene una
                        distribución más o menos normal de las letras, al contrario de usar textos como por ejemplo
                        "Contenido aquí, contenido aquí". </p>
                </div>
            </div>--> <!-- EJEMPLO DE ACORDEON -->



        </div>

        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script type="text/javascript" src="http://localhost\02wordpress\wp-content\themes\Replika Teatro\js\scriptacordeon.js"></script>



</div>



<?php
get_footer();