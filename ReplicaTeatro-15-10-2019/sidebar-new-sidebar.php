<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package starter
 */

?>

  <div id="lateral_menu_wrap" class="lateral_menu border-right collapsed"> 

      <input id="collapse" type="image" class="menu-button arrow-collapsed" src="http://localhost\02wordpress\wp-content\themes\Replika Teatro\arrow.png">

        <div id="lateral_menu" class="col-xs-12 lateral_menu_wrapper collapsed-wrapper">

              <div class="link-lateral col-xs-12 border-bottom"> 
                <a href="http://localhost/02wordpress/programacion/" class="link-block-lateral w-inline-block w--current">
                  <span class="blink"><img id="p-arrow" src="http://localhost/02wordpress/wp-content/uploads/2019/08/REPLIKAWeb-23.svg"></span>
                  <p>programación</p>
                </a>
            </div>
              <div class="link-lateral col-xs-12 border-bottom"> 
                <a href="http://localhost/02wordpress/entradas/" class="link-block-lateral w-inline-block w--current">
                  <span class=" blink"><img id="p-arrow" src="http://localhost/02wordpress/wp-content/uploads/2019/08/REPLIKAWeb-23.svg"></span>
                  <p>entradas</p>
                </a>
            </div>
              <div class="link-lateral col-xs-12 border-bottom"> 
                <a href="http://localhost/02wordpress/compania/" class="link-block-lateral w-inline-block w--current">
                  <span class=" blink"><img id="p-arrow" src="http://localhost/02wordpress/wp-content/uploads/2019/08/REPLIKAWeb-23.svg"></span>
                  <p>la compañia</p>
                </a>
            </div>
       </div>                       
  </div>

<script>
  jQuery("#collapse").click(function(){
      jQuery(".lateral_menu").toggleClass("collapsed");
      jQuery(".lateral_menu_wrapper").toggleClass("collapsed-wrapper");
      jQuery(".menu-button").toggleClass("arrow-collapsed");
      jQuery(".fullpage-gallery").toggleClass("gallery-expand");
      jQuery(".swiper-slide").toggleClass("expanded");

  }); 
  
</script>