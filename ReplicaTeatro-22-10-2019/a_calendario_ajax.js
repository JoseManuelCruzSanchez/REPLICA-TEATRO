var eventos;

if(window.location.pathname.indexOf('/programacion/') !== -1){
    jQuery(document).ready(function () {
        let fecha_actual = new Date();
        ajax_peticion_datos_eventos(fecha_actual.getMonth() +1, fecha_actual.getFullYear());
    });

    function ajax_peticion_datos_eventos(que_mes, que_ano){
        // console.log('ajax_peticion_datos_eventos')
        // console.log('que_mes: ' + que_mes)
        // console.log('que_año: ' + que_ano)
        // console.log('ajax_peticion_datos_eventos')
        var url = dcms_vars.ajaxurl;
        jQuery.ajax({
            type: "post",
            url: url,
            data: {
                action: "obtener_eventos_teatro", //Esta es la función php que se dispara
                mes_calendario: {
                    mes: que_mes,
                    ano: que_ano,
                },
            },
            error: function(response){
                console.log('Algo fallo en a_calendario_ajax.php');
                console.log("response: " + response);
            },
            success: function (response) {
                eventos = JSON.parse(response);

                inserta_eventos_destacados_en_DOM(eventos.destacados, eventos.mes_actual);

                genera_calendario_y_panel_derecho(eventos.mes_actual, que_mes, que_ano);

                // console.log(eventos);
            },
        });
    }

    function inserta_eventos_destacados_en_DOM(array_eventos_destacados, array_eventos_mes) {
        //console.log(array_eventos_destacados)
        if(array_eventos_destacados.length === 0){
            let array_eventos = obtener_eventos_proximos(2, array_eventos_mes);
            if(array_eventos.length === 2){
                panel_destacados_izquierdo(array_eventos[0]);
                panel_destacados_derecho(array_eventos[1]);
            }
            else if(array_eventos.length === 1){
                panel_destacados_izquierdo(array_eventos[0]);
            }

        }
        else if(array_eventos_destacados.length === 1){
            panel_destacados_izquierdo(array_eventos_destacados[0]);
            let array_eventos = obtener_eventos_proximos(1, array_eventos_mes);
            if(array_eventos.length === 1){
                panel_destacados_derecho(array_eventos[0]);
            }

        }
        else/*(array_eventos.length === 2 o más)*/{
            panel_destacados_izquierdo(array_eventos_destacados[0]);
            panel_destacados_derecho(array_eventos_destacados[1]);
        }

        function panel_destacados_izquierdo(evento){
            document.getElementById('img-evento-destacado-1').src = evento.imagen_del_evento;
            document.getElementById('h2-evento-destacado-1').innerHTML = evento.titulo_del_evento;
            document.getElementById('h3-evento-destacado-1').innerHTML = evento.fecha_del_evento + ' / ' + evento.hora_del_evento;
            document.getElementById('enlace-evento-destacado-1').href = evento.get_permalink;
        }

        function panel_destacados_derecho(evento) {
            document.getElementById('img-evento-destacado-2').src = evento.imagen_del_evento;
            document.getElementById('h2-evento-destacado-2').innerHTML = evento.titulo_del_evento;
            document.getElementById('h3-evento-destacado-2').innerHTML = evento.fecha_del_evento + ' / ' + evento.hora_del_evento;
            document.getElementById('enlace-evento-destacado-2').href = evento.get_permalink;
        }

        function obtener_eventos_proximos(cuantos, array_eventos_mes){
            let contador = 0;
            let array_eventos = [];
            let fecha_actual = new Date();
            fecha_actual.setHours(0,0,0,0); /*Hora de medianoche por si son iguales las dos fechas en la comparacion*/
            let i = 0;
            while(contador !== cuantos){
                if(array_eventos_mes[i] === undefined){
                    break;
                }else{
                    let split_fecha = array_eventos_mes[i].fecha_del_evento.split('/');
                    /*Mes y año invertido por formato anglosajon*/
                    let fecha_evento = new Date(split_fecha[1] + '-' + split_fecha[0] + '-' + split_fecha[2]);
                    //Date.getTime() para comparar los miliseconds
                    if(fecha_evento.getTime() >= fecha_actual.getTime()){
                        array_eventos.push(array_eventos_mes[i]);
                        contador++;
                    }
                    i++;
                }

            }
            return array_eventos;
        }

    }

    function genera_calendario_y_panel_derecho(array_eventos_mes, que_mes, que_ano) {
        cargar_dias_calendario(que_mes, que_ano);
        recalculaAltoDiaCalendario();
        set_listeners();
        var datos_panel_derecho = {
            titulo_evento: document.getElementById('panel-titulo-evento'),
            color_categoria: document.getElementById('panel-color-categoria').firstChild,
            hora_evento: document.getElementById('panel-hora-evento'),
            precio_evento: document.getElementById('panel-precio-evento'),
            enlace_compra_entradas: document.getElementById('panel-enlace-compra-entradas'),
            enlace_evento_detalle: document.getElementById('panel-enlace-get-permalink')
        };

        insertar_evento_siguiente_a_fecha_actual_en_panel_derecho(array_eventos_mes);
        function insertar_evento_siguiente_a_fecha_actual_en_panel_derecho(array_eventos_mes) {
            let fecha_actual = new Date();
            fecha_actual.setHours(0,0,0,0); /*Hora de medianoche por si son iguales las dos fechas en la comparacion*/
            for(let i = 0; i < array_eventos_mes.length; i++){
                let split_fecha = array_eventos_mes[i].fecha_del_evento.split('/');
                /*Mes y año invertido por formato anglosajon*/
                let fecha_evento = new Date(split_fecha[1] + '-' + split_fecha[0] + '-' + split_fecha[2]);
                //Date.getTime() para comparar los miliseconds
                if(fecha_evento.getTime() >= fecha_actual.getTime()){
                    //console.log(fecha_evento.getTime())
                    //console.log(fecha_actual.getTime())

                    datos_panel_derecho.titulo_evento.innerHTML = array_eventos_mes[i].titulo_del_evento;//: document.getElementById('panel-titulo-evento'),
                    datos_panel_derecho.color_categoria.style.backgroundColor = array_eventos_mes[i].categoria_del_evento;//: document.getElementById('panel-color-categoria').firstChild,
                    datos_panel_derecho.hora_evento.innerHTML = array_eventos_mes[i].hora_del_evento + ' h.';//: document.getElementById('panel-hora-evento'),
                    datos_panel_derecho.precio_evento.innerHTML = array_eventos_mes[i].precio_del_evento + ' €';//: document.getElementById('panel-precio-evento'),
                    datos_panel_derecho.enlace_compra_entradas.href = array_eventos_mes[i].enlace_compra_entrada_evento;//: document.getElementById('panel-enlace-compra-entradas')
                    datos_panel_derecho.enlace_evento_detalle.href = array_eventos_mes[i].get_permalink;
                    break;//Solo queremos la primera ocurrencia
                }
            }
        }

        function recalculaAltoDiaCalendario(){
            let anchoContenedorDia = document.querySelectorAll('.dia')[0].offsetWidth;
            let dias = document.querySelectorAll('.dia');
            let numDias = document.querySelectorAll('.numDia');
            for(let i = 0; i < dias.length; i++){
                dias[i].style.height = Math.floor(anchoContenedorDia / 4 * 2.5) + 'px';
                numDias[i].style.fontSize = Math.floor(anchoContenedorDia / 3) + 'px';
                numDias[i].style.marginTop = Math.floor(anchoContenedorDia / 7) + 'px';
                numDias[i].style.marginRight = Math.floor(anchoContenedorDia / 9) + 'px';
            }
            document.querySelector('#fila-mes-ano').style.fontSize = Math.floor(anchoContenedorDia / 3) + 'px';
            document.querySelector('#fila-eventos-anteriores').style.fontSize = Math.floor(anchoContenedorDia / 5) + 'px';
            document.querySelector('#h2-evento-destacado-2').style.fontSize = Math.floor(anchoContenedorDia / 2) + 'px';
            document.querySelector('#h2-evento-destacado-1').style.fontSize = Math.floor(anchoContenedorDia / 2) + 'px';
            document.querySelector('#h3-evento-destacado-2').style.fontSize = Math.floor(anchoContenedorDia / 5) + 'px';
            document.querySelector('#h3-evento-destacado-1').style.fontSize = Math.floor(anchoContenedorDia / 5) + 'px';
            document.querySelector('#enlace-evento-destacado-2').style.fontSize = Math.floor(anchoContenedorDia / 5) + 'px';
            document.querySelector('#enlace-evento-destacado-1').style.fontSize = Math.floor(anchoContenedorDia / 5) + 'px';

            recalculaTamanosPanelInfoDerecho();
            function recalculaTamanosPanelInfoDerecho(){
                let panel_info_derecho = document.getElementById('panel-info-evento-derecho');
                panel_info_derecho.style.fontSize = Math.floor(panel_info_derecho.offsetWidth / 4.5) + 'px';
            }
        }

        function cambiar_info_panel_derecho_hover_o_click(event){
            if(event.target.className.indexOf('circulo') !== -1){
                actualiza_info(event.target.dataset.id);
            }
            else if(event.target.parentNode.className.indexOf('circulo') !== -1){
                actualiza_info(event.target.parentNode.dataset.id);
            }
            function actualiza_info(elem_hover_id){
                let evento = '';
                for(let i = 0; i < array_eventos_mes.length; i++){
                    if(array_eventos_mes[i].id == elem_hover_id){
                        evento = array_eventos_mes[i];
                    }
                }
                datos_panel_derecho.titulo_evento.innerHTML = evento.titulo_del_evento;//: document.getElementById('panel-titulo-evento'),
                datos_panel_derecho.color_categoria.style.backgroundColor = evento.categoria_del_evento;//: document.getElementById('panel-color-categoria').firstChild,
                datos_panel_derecho.hora_evento.innerHTML = evento.hora_del_evento + ' h.';//: document.getElementById('panel-hora-evento'),
                datos_panel_derecho.precio_evento.innerHTML = evento.precio_del_evento + ' €';//: document.getElementById('panel-precio-evento'),
                datos_panel_derecho.enlace_evento_detalle.href = evento.get_permalink;
                datos_panel_derecho.enlace_compra_entradas.href = evento.enlace_compra_entrada_evento;//: document.getElementById('panel-enlace-compra-entradas')
            }
        }

        function set_listeners(){
            let flechas_calendario = document.querySelectorAll('.flecha-calendario');
            for(let i = 0; i < flechas_calendario.length; i++){
                flechas_calendario[i].addEventListener('click', click_flecha_calendario);
            }

            let dias_con_evento = document.querySelectorAll('.circulo');
            for(let i = 0; i < dias_con_evento.length; i++){
                dias_con_evento[i].addEventListener('mouseover', cambiar_info_panel_derecho_hover_o_click, true);
                dias_con_evento[i].addEventListener('click', cambiar_info_panel_derecho_hover_o_click, true);
            }

            window.addEventListener("resize", recalculaAltoDiaCalendario);
        }

        function click_flecha_calendario(){
            if(this.id === 'flecha-mes-anterior'){
                let mes = parseInt(document.querySelector('#mes-mostrado').dataset.mes) - 1;
                let ano = parseInt(document.querySelector('#ano-mostrado').dataset.ano);
                //cargar_dias_calendario(mes, ano);
                ajax_peticion_datos_eventos(mes, ano)
            }
            else if(this.id === 'flecha-mes-posterior'){
                let mes = parseInt(document.querySelector('#mes-mostrado').dataset.mes) + 1;
                let ano = parseInt(document.querySelector('#ano-mostrado').dataset.ano);
                //cargar_dias_calendario(mes, ano);
                ajax_peticion_datos_eventos(mes, ano)
            }
            recalculaAltoDiaCalendario();
        }

        function cargar_dias_calendario(que_mes, que_anyo){
            function get_dias_con_numero(fecha_primer_dia, fecha_ultimo_dia, arrayEventos){
                let resultado = '';
                do{
                    resultado += get_dia_con_circulo_si_coinciden_fechas(fecha_primer_dia, arrayEventos);
                    fecha_primer_dia.setDate(fecha_primer_dia.getDate() + 1); /*Sumo un dia para la sig vuelta de bucle*/
                }while(fecha_primer_dia.getDate() !== fecha_ultimo_dia.getDate());
                resultado += get_dia_con_circulo_si_coinciden_fechas(fecha_primer_dia, arrayEventos);

                function get_dia_con_circulo_si_coinciden_fechas(fecha_primer_dia, arrayEventos){
                    let resultado = '<div class="dia" data-fecha="' + fecha_primer_dia.toLocaleDateString() +'">'+
                        '<div class="">'+
                        '<p class="numDia">' + fecha_primer_dia.getDate() + '</p>'+
                        '</div>'+
                        '</div>';
                    for(let i = 0; i < arrayEventos.length; i++){
                        let split_fecha = arrayEventos[i].fecha_del_evento.split('/');
                        /*Mes y año invertido por formato anglosajon*/
                        let fecha_evento = new Date(split_fecha[1] + '-' + split_fecha[0] + '-' + split_fecha[2]);
                        let fecha_hoy = new Date();
                        fecha_hoy.setHours(0,0,0,0);
                        if(fecha_evento.getTime() === fecha_primer_dia.getTime() && fecha_evento.getTime() >= fecha_hoy.getTime()){
                            resultado = '<div class="dia" data-fecha="' + fecha_primer_dia.toLocaleDateString() +'">'+
                                '<div class="circulo" data-id="'+ arrayEventos[i].id +'">'+
                                '<p class="numDia">' + fecha_primer_dia.getDate() + '</p>'+
                                '</div>'+
                                '</div>';
                        }
                    }
                    return resultado;
                }
                return resultado;
            }
            function cargar_fila_mes_ano(primer_dia_mes){
                return '<div id="fila-mes-ano">'+
                            '<div class="flecha-calendario" id="flecha-mes-anterior"><img src="http://localhost/02wordpress/wp-content/uploads/2019/08/REPLIKAWeb-23.svg"></div>'+
                            '<div>'+
                                '<p id="mes-mostrado" data-mes="' + (1 + primer_dia_mes.getMonth()) + '">'+primer_dia_mes.toLocaleString('es', {month: 'long'})+'</p>'+
                                '<p id="ano-mostrado" data-ano="' + (primer_dia_mes.getFullYear()) + '">'+primer_dia_mes.getFullYear()+'</p>'+
                            '</div>'+
                            '<div class="flecha-calendario" id="flecha-mes-posterior"><img src="http://localhost/02wordpress/wp-content/uploads/2019/08/REPLIKAWeb-23.svg"></div>'+
                        '</div>';
            }
            function anadir_dias_vacios_si_mes_no_empieza_en_lunes(ob_primer_dia_mes){
                let resultado = '';
                let dia_empieza_mes = ob_primer_dia_mes.toLocaleString('es', {weekday: 'long'});
                function get_dias_sin_numero(cuantos){
                    let resultado = '';
                    for(let i = 0; i < cuantos; i++){
                        resultado += 	'<div class="dia">'+
                            '<div>'+
                            '<p class="numDia"></p>'+
                            '</div>'+
                            '</div>';
                    }
                    return resultado;
                }
                if(dia_empieza_mes.localeCompare("martes") === 0){
                    resultado += get_dias_sin_numero(1);
                }
                else if(dia_empieza_mes.localeCompare("miércoles") === 0){
                    resultado += get_dias_sin_numero(2);
                }
                else if(dia_empieza_mes.localeCompare("jueves") === 0){
                    resultado += get_dias_sin_numero(3);
                }
                else if(dia_empieza_mes.localeCompare("viernes") === 0){
                    resultado += get_dias_sin_numero(4);
                }
                else if(dia_empieza_mes.localeCompare("sábado") === 0){
                    resultado += get_dias_sin_numero(5);
                }
                else if(dia_empieza_mes.localeCompare("domingo") === 0){
                    resultado += get_dias_sin_numero(6);
                }
                return resultado;
            }

            let ob_primer_dia_mes = new Date(que_anyo, que_mes -1, 1);
            let ob_ultimo_dia_mes = new Date(que_anyo, que_mes, 0);
            let salida_datos = document.querySelector('#calendario');
            salida_datos.innerHTML = '';
            salida_datos.innerHTML += cargar_fila_mes_ano(ob_primer_dia_mes);
            salida_datos.innerHTML += anadir_dias_vacios_si_mes_no_empieza_en_lunes(ob_primer_dia_mes);
            salida_datos.innerHTML += get_dias_con_numero(ob_primer_dia_mes, ob_ultimo_dia_mes, array_eventos_mes);

            /*Vuelvo a añadir listeners porque se han creado nuevos elementos que no los tendrán asignados*/
            set_listeners();
        }

    }

}
else if(window.location.pathname.indexOf('/eventos-anteriores/') !== -1){
    function toggle_ampliar_imagen(esto){
        // esto.classList.toggle("ampliar-div");
        // esto.classList.toggle("col-xs-2");
        // esto.firstElementChild.classList.toggle("ampliar-img");
        //ESTO ES PORQUE HAY UNA REGLA CSS "contain: content;" QUE NO ME PERMITE USAR height: 100vh
        document.getElementById('content').classList.toggle("body-container");
    }

    function ampliar_imagen(esto){
        // console.log(esto)
        // esto.classList.add("ampliar-div");
        // esto.classList.remove("col-xs-2");
        // esto.firstElementChild.classList.add("ampliar-img");
        //ESTO ES PORQUE HAY UNA REGLA CSS "contain: content;" QUE NO ME PERMITE USAR height: 100vh
        document.getElementById('content').classList.remove("body-container");
    }
}
else if(window.location.pathname.indexOf('/eventos/') !== -1){
    function aparece(esto) {
        jQuery('#' + esto.id).fadeToggle()
            .css( {
                "background-color": "white",
                "display": "inline-block"
            } );

    }
}




