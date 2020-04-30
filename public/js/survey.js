


$(function(){    
    // console.log(tipo_encuesta);
    document.querySelector("h3[id='title_survey']").textContent = 'Encuesta de '+tipo_encuesta.descripcion; // title 
    mostrar_pregunta_consecutiva(preguntas);

});

function mostrar_pregunta_consecutiva(preguntas){
    
    let tamaño_preguntas= preguntas.length ;
    let primera_pregunta_descripcion ='';
    let primera_pregunta_id ='';
    let pendientes =0;
    let completadas =0;
    // console.log(preguntas);


    for (let i = 0; i < preguntas.length; i++) {
        if(preguntas[i].respuesta == '' || preguntas[i].respuesta <= 0 ){
            pendientes+=1;
            primera_pregunta_descripcion = preguntas[i].pregunta;
            primera_pregunta_id = preguntas[i].id;
            primera_pregunta_id_periodo = preguntas[i].id_periodo;
            break;
        }else{
            completadas+=1;
        }
    }
 
    
    document.querySelector("h3[id='title_survey']").textContent = 'Encuesta de '+tipo_encuesta.descripcion+  '('+completadas+ '/'+tamaño_preguntas+')'; // title 
    if(pendientes == 0){
        document.querySelector("h4[id='pregunta']").textContent = '';
        document.querySelector("button[id='btnAnterior']").setAttribute('disabled',true);
        document.querySelector("button[id='btnSiguiente']").setAttribute('disabled',true);
        alert('Encuesta completada para este periodo, Gracias!');

        
    }else{
        document.querySelector("input[id='id_pregunta']").value = primera_pregunta_id; 
        document.querySelector("input[id='id_periodo']").value = primera_pregunta_id_periodo; 
        document.querySelector("h4[id='pregunta']").textContent = primera_pregunta_descripcion+'?';
    }
}

function mostrar_pregunta(preguntas){
    
    let tamaño_preguntas= preguntas.length ;
    let primera_pregunta_descripcion ='';
    let primera_pregunta_id ='';
    let pendientes =0;
    let completadas =0;
    console.log(preguntas);


    for (let i = 0; i < preguntas.length; i++) {
        if(preguntas[i].respuesta == '' || preguntas[i].respuesta <= 0 ){
            pendientes+=1;
            primera_pregunta_descripcion = preguntas[i].pregunta;
            primera_pregunta_id = preguntas[i].id;
            primera_pregunta_id_periodo = preguntas[i].id_periodo;
            break;
        }else{
            completadas+=1;
        }
    }
 
    
    document.querySelector("h3[id='title_survey']").textContent = 'Encuesta de '+tipo_encuesta.descripcion+  '('+completadas+ '/'+tamaño_preguntas+')'; // title 
    if(pendientes == 0){
        document.querySelector("h4[id='pregunta']").textContent = '';
        document.querySelector("button[id='btnAnterior']").setAttribute('disabled',true);
        document.querySelector("button[id='btnSiguiente']").setAttribute('disabled',true);
        alert('Encuesta completada para este periodo, Gracias!');

        
    }else{
        document.querySelector("input[id='id_pregunta']").value = primera_pregunta_id; 
        document.querySelector("input[id='id_periodo']").value = primera_pregunta_id_periodo; 
        document.querySelector("h4[id='pregunta']").textContent = primera_pregunta_descripcion+'?';
    }
}

function siguiente_pregunta(){


    // let tamaño_preguntas= preguntas.length ;

    let customRadio = document.querySelectorAll("input[name='customRadio']")
    let haschecked= false; 
    for( i = 0; i < customRadio.length; i++ ) {
        if( customRadio[i].checked ) {
            haschecked=true;
        }
    }
    if (haschecked==false){
        alert('Debe Marcar una Opción');
    }else{
        guardar_resulstado();

    }

}


function anterior_pregunta(){
    let id_pregunta = document.querySelector("input[id='id_pregunta']").value; 
    let indice='';
    let id='';
    let pregunta='';
    let respuesta='';
    let id_periodo='';
    let tamaño_preguntas= preguntas.length ;
    let pendientes =0;
    let completadas =0;

    if(id_pregunta >0 ){
        // console.log(id_pregunta);
        // console.log(preguntas);
        preguntas.forEach((element,index) => {
            if(element.id == id_pregunta ){
                indice=index;
            }
            if(element.respuesta == '' || element.respuesta <= 0 ){
                pendientes+=1;
            }else{
                completadas+=1;
            }
        });
        
        indice = indice -1;
        console.log(preguntas);
        
        if(indice >=0){
            console.log(indice);
             
            id = preguntas[indice]['id'];
            pregunta =  preguntas[indice]['pregunta'];
            respuesta = preguntas[indice]['respuesta'];
            id_periodo = preguntas[indice]['id_periodo'];
       
            
            document.querySelector("h3[id='title_survey']").textContent = 'Encuesta de '+tipo_encuesta.descripcion+  '('+completadas+ '/'+tamaño_preguntas+')'; // title 
            document.querySelector("input[id='id_pregunta']").value = id; 
            document.querySelector("input[id='id_periodo']").value = id_periodo; 
            document.querySelector("h4[id='pregunta']").textContent = pregunta+'?';

            let customRadio = document.querySelectorAll("input[name='customRadio']")
            for( i = 0; i < customRadio.length; i++ ) {
                if( customRadio[i].value == respuesta) {                    
                    customRadio[i].checked =true;
                }
            }
    

        }
    }



}

function guardar_resulstado(){
    let id_pregunta = document.querySelector("input[id='id_pregunta']").value; 
    let id_periodo = document.querySelector("input[id='id_periodo']").value; 
    // console.log(id_pregunta);
    
    let id_escala = 0;
    let customRadio = document.querySelectorAll("input[name='customRadio']")
    for( i = 0; i < customRadio.length; i++ ) {
        if( customRadio[i].checked ) {
            id_escala = customRadio[i].value;
        }
    }

    if(id_escala > 0){

        let data ={id_pregunta:id_pregunta,id_periodo:id_periodo, id_escala:id_escala, id_usuario: usuario.id};
        // console.log(data);
        
        baseUrl = '/guardar_respuesta';
        $.ajax({
            type: 'POST',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: baseUrl,
            dataType: 'JSON',
            data:data,

            success: function(response){
                // console.log(response);
                if(response.status==200){
                    // ok
                    alert('Se guardo con existo');
                    refresh_preguntas(tipo_encuesta);
                    
                    let customRadio = document.querySelectorAll("input[name='customRadio']")
                     for( i = 0; i < customRadio.length; i++ ) {
                        if( customRadio[i].checked ) {
                            customRadio[i].checked=false;
                        }
                    }


                }else{
                    alert('hubo un problema, se pudo guardar');
                }
                // mostrar_pregunta(response)
            }
        }).fail( function( jqXHR, textStatus, errorThrown ){
            console.log(jqXHR);
            console.log(textStatus);
            console.log(errorThrown);
        });
    }


}

function refresh_preguntas(tipo_encuesta){
    baseUrl = '/refresh_preguntas_usuario/';
    $.ajax({
        type: 'GET',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: baseUrl,
        dataType: 'JSON',
        data:tipo_encuesta,
        success: function(response){
            // console.log(response);
            preguntas= response;
            // mostrar_pregunta(preguntas);

 
        }
    }).fail( function( jqXHR, textStatus, errorThrown ){
        console.log(jqXHR);
        console.log(textStatus);
        console.log(errorThrown);
    });
}

function actualizar_resulstado(){

}