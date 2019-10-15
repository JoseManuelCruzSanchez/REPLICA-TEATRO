<?php

function  genera_un_evento_single($post_id){
	$single_evento = array();
	$single_evento['id']                                =   $post_id;
	$single_evento['titulo_del_evento']                 =   get_field('titulo_del_evento', $post_id);
	$single_evento['fecha_del_evento']                  =   get_field('fecha_del_evento', $post_id);
	$single_evento['hora_del_evento']                   =   get_field('hora_del_evento', $post_id);
	$single_evento['evento_destacado']                  =   get_field('evento_destacado', $post_id);
	$single_evento['imagen_del_evento']                 =   get_field('imagen_del_evento', $post_id);
	$single_evento['opciones_para_compartir_en_redes']  =   get_field('opciones_para_compartir_en_redes', $post_id);
	$single_evento['precio_del_evento']                 =   get_field('precio_del_evento', $post_id);
	$single_evento['categoria_del_evento']              =   get_field('categoria_del_evento', $post_id);
	$single_evento['descripcion_principal']             =   get_field('descripcion_principal', $post_id);
	$single_evento['descripcion_secundaria']            =   get_field('descripcion_secundaria', $post_id);
	$single_evento['creador_del_evento']                =   get_field('creador_del_evento', $post_id);
	$single_evento['enlace_compra_entrada_evento']      =   get_field('enlace_compra_entrada_evento', $post_id);

	$single_evento['get_permalink']                     =   get_the_permalink($post_id);
	return $single_evento;
}

function enviar_eventos_del_mes($mes_actual){
	$array_eventos = array();
	$array_eventos['destacados'] = array();
	//$array_eventos['mes_anterior'] = array();
	$array_eventos['mes_actual'] = array();
	//$array_eventos['mes_posterior'] = array();

//	$mes_anterior = array();
//	$mes_posterior = array();
//	$mes_anterior['ano'] = $mes_actual['ano'];
//	$mes_posterior['ano'] = $mes_actual['ano'];
//	if($mes_actual['mes'] == '1'){
//		$mes_anterior['mes'] = intval($mes_actual['mes']) -1;
//		$mes_anterior['ano'] = intval($mes_actual['ano']) -1;
//	}
//	else if($mes_actual['mes'] == '12'){
//		$mes_posterior['mes'] = intval($mes_actual['mes']) +1;
//		$mes_posterior['ano'] = intval($mes_actual['ano']) +1;
//	}
//	else{
//		$mes_anterior['mes'] = strval(intval($mes_actual['mes']) -1);
//		$mes_posterior['mes'] = strval(intval($mes_actual['mes']) +1);
//	}

	//$fecha_hoy = date('d/m/Y');
	$num_eventos_destacados = 2;
	$fecha_hoy = DateTime::createFromFormat('d/m/Y', date('d/m/Y'));
	$loop = new WP_Query(array('post_type' => 'eventos',
	                           'posts_per_page' => -1,
	                           'meta_key' => 'fecha_del_evento',
	                           'orderby' => 'meta_value',
	                           'order' => 'asc') );
	while ( $loop->have_posts() ) {
		$loop->the_post();
		$fecha_post = DateTime::createFromFormat('d/m/Y', get_field('fecha_del_evento', get_the_ID()));
		if($num_eventos_destacados > 0){
			if($fecha_post >= $fecha_hoy && get_field('evento_destacado', get_the_ID())){
				//error_log(get_field('titulo_del_evento', get_the_ID()));
				//error_log('RESULTADO: ' . $fecha_post->format('d/m/Y'));
				array_push($array_eventos['destacados'], genera_un_evento_single(get_the_ID()));
				$num_eventos_destacados--;
			}

		}

		/*if($mes_anterior['ano'] == $fecha_post->format('Y') && $mes_anterior['mes'] == $fecha_post->format('m')){
			array_push($array_eventos['mes_anterior'], genera_un_evento_single(get_the_ID()));
		}*/
		if($mes_actual['ano'] == $fecha_post->format('Y') && $mes_actual['mes'] == $fecha_post->format('m')){
			array_push($array_eventos['mes_actual'], genera_un_evento_single(get_the_ID()));
		}
		/*else if($mes_posterior['ano'] == $fecha_post->format('Y') && $mes_posterior['mes'] == $fecha_post->format('m')){
			array_push($array_eventos['mes_posterior'], genera_un_evento_single(get_the_ID()));
		}*/
	}
	wp_reset_query();

	echo json_encode($array_eventos);
}
