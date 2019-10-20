<?php
/**
Template Name: PROGRAMACION Page
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



<div class="fullpage-gallery event-gallery contenedor-cruz-estudio">
    <div class="eventos-destacados">
        <div id="evento-destacado-1" class="evento-destacado">
            <img id="img-evento-destacado-1" src="">
            <div class="info-destacados">
                <h2 id="h2-evento-destacado-1"></h2>
                <h3 id="h3-evento-destacado-1"></h3>
            </div>
            <a id="enlace-evento-destacado-1" class="enlace-mas-info" href="#">
                <p>
                    <img src="http://localhost/02wordpress/wp-content/uploads/2019/10/REPLIKAWeb-23-blanco-01.svg"> más info
                </p>
            </a>
        </div>
        <div id="evento-destacado-2" class="evento-destacado">
            <img id="img-evento-destacado-2" src="">
            <div class="info-destacados">
                <h2 id="h2-evento-destacado-2"></h2>
                <h3 id="h3-evento-destacado-2"></h3>
            </div>
            <!--<a id="enlace-evento-destacado-2"href="#">
                <img src="http://localhost/02wordpress/wp-content/uploads/2019/08/REPLIKAWeb-23.svg"> más info
            </a>-->

            <a id="enlace-evento-destacado-2" class="enlace-mas-info" href="#">
                <p>
                    <img src="http://localhost/02wordpress/wp-content/uploads/2019/10/REPLIKAWeb-23-blanco-01.svg"> más info
                </p>
            </a>
        </div>
    </div>



    <div id="contenedor-general-eventos">
        <div id="calendario">
            <!--<div id="fila-mes-ano">
				<p id="mes-mostrado" data-mes="10">septiembre</p>
				<p id="ano-mostrado" data-ano="2019">2019</p>
				<div class="flecha-calendario" id="flecha-mes-posterior"><i class="fa fa-arrow-right"></i></div>
			</div>-->
            <!--<div class="dia">
				<div class="circulo">
					<p class="numDia">01</p>
				</div>
			</div>-->
        </div>
        <div id="panel-info-evento-derecho">
            <div id="panel-contenedor-titulo-categoria">
                <div class="panel-titulo-evento"><h2 id="panel-titulo-evento">El apagon</h2></div>
                <div id="panel-color-categoria"><div></div></div>
            </div>

            <p class="etiqueta">hora</p>
            <p id="panel-hora-evento">20.00 h.</p>
            <div class="espacio-vacio"></div>
            <p class="etiqueta">precio</p>
            <p id="panel-precio-evento">18,00 €</p>
            <div class="espacio-vacio"></div>
            <p class="etiqueta">entradas:</p>
            <a id="panel-enlace-compra-entradas" href="#"><p>comprar entradas online</p></a>
            <a id="panel-enlace-get-permalink" class="enlace-mas-info" href="#"><p><img src="http://localhost/02wordpress/wp-content/uploads/2019/08/REPLIKAWeb-23.svg"> más info</p></a>
        </div>
        <div id="fila-eventos-anteriores">
            <a href="http://localhost/02wordpress/eventos-anteriores/"><p>eventos anteriores</p></a>
        </div>
    </div>


</div>



<?php
get_footer();