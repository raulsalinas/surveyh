$(function(){    

    document.getElementById("btnChartLiderazgo").click();  
    // document.getElementById("btnChartSatisfaccion").click();  
    get_encuestas_empezadas();
    get_encuestas_completadas();
    get_cantidad_usuarios();
    get_encuestas_satisfacion_comenzadas_mensual();
    get_encuestas_liderazgo_comenzadas_mensual();
    get_avance_encuestas_satisfaccion();
    get_avance_encuestas_liderazgo();
});


function get_encuestas_empezadas(){
    baseUrl = '/get_cantidad_encuestas_empezadas/';
    $.ajax({
        type: 'GET',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: baseUrl,
        dataType: 'JSON',
        success: function(response){
            // console.log(response);
            mostrar_card_dashboard_encuesta_empezadas(response);

 
        }
    }).fail( function( jqXHR, textStatus, errorThrown ){
        console.log(jqXHR);
        console.log(textStatus);
        console.log(errorThrown);
    });
}

function mostrar_card_dashboard_encuesta_empezadas(data){
    document.querySelector("div[id='card-dashboard'] span[id='total_empezadas']").textContent = data.total_empezadas;
    document.querySelector("div[id='card-dashboard'] span[id='total_empezadas_satisfaccion']").textContent = data.total_empezadas_satisfaccion;
    document.querySelector("div[id='card-dashboard'] span[id='total_empezadas_liderazgo']").textContent = data.total_empezadas_liderazgo;

    if(data.total_empezadas_satisfaccion == 0){
        document.querySelector("div[id='card-dashboard'] span[id='total_empezadas_satisfaccion']").parentElement.setAttribute('class','text-danger mr-2')
        document.querySelector("div[id='card-dashboard'] span[id='total_empezadas_satisfaccion']").parentElement.querySelector("i").setAttribute("class",'fa fa-arrow-down')

    }
    if(data.total_empezadas_liderazgo == 0){
        document.querySelector("div[id='card-dashboard'] span[id='total_empezadas_liderazgo']").parentElement.setAttribute('class','text-danger mr-2')
        document.querySelector("div[id='card-dashboard'] span[id='total_empezadas_liderazgo']").parentElement.querySelector("i").setAttribute("class",'fa fa-arrow-down')

    }
}

function get_encuestas_completadas(){
    baseUrl = '/get_cantidad_encuestas_completadas/';
    $.ajax({
        type: 'GET',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: baseUrl,
        dataType: 'JSON',
        success: function(response){
            // console.log(response);
            mostrar_card_dashboard_encuesta_completadas(response);
        }
    }).fail( function( jqXHR, textStatus, errorThrown ){
        console.log(jqXHR);
        console.log(textStatus);
        console.log(errorThrown);
    });
}

function mostrar_card_dashboard_encuesta_completadas(data){
    document.querySelector("div[id='card-dashboard'] span[id='total_completada']").textContent = data.cantidad_total_completado;
    document.querySelector("div[id='card-dashboard'] span[id='total_completada_satisfaccion']").textContent = data.cantidad_completado_satisfaccion;
    document.querySelector("div[id='card-dashboard'] span[id='total_completada_liderazgo']").textContent = data.cantidad_completado_liderazgo;

    if(data.cantidad_completado_satisfaccion == 0){
        document.querySelector("div[id='card-dashboard'] span[id='total_completada_satisfaccion']").parentElement.setAttribute('class','text-danger mr-2')
        document.querySelector("div[id='card-dashboard'] span[id='total_completada_satisfaccion']").parentElement.querySelector("i").setAttribute("class",'fa fa-arrow-down')

    }
    if(data.cantidad_completado_liderazgo == 0){
        document.querySelector("div[id='card-dashboard'] span[id='total_completada_liderazgo']").parentElement.setAttribute('class','text-danger mr-2')
        document.querySelector("div[id='card-dashboard'] span[id='total_completada_liderazgo']").parentElement.querySelector("i").setAttribute("class",'fa fa-arrow-down')

    }
}


function get_cantidad_usuarios(){
    baseUrl = '/get_cantidad_usuarios/';
    $.ajax({
        type: 'GET',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: baseUrl,
        dataType: 'JSON',
        success: function(response){
            // console.log(response);
            mostrar_card_dashboard_cantidad_usuarios(response);
        }
    }).fail( function( jqXHR, textStatus, errorThrown ){
        console.log(jqXHR);
        console.log(textStatus);
        console.log(errorThrown);
    });
}

function mostrar_card_dashboard_cantidad_usuarios(data){
    document.querySelector("div[id='card-dashboard'] span[id='cantidad_usuarios']").textContent = data.cantidad_usuarios;

}



function get_encuestas_satisfacion_comenzadas_mensual(){
    baseUrl = '/get_encuestas_satisfacion_comenzadas_mensual/';
    $.ajax({
        type: 'GET',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: baseUrl,
        dataType: 'JSON',
        success: function(response){
            let data= {"data":{"datasets":[{"data":response}]}};
            document.querySelector("li[id='chartSatisfaccion']").setAttribute('data-update',JSON.stringify(data));
        }
    }).fail( function( jqXHR, textStatus, errorThrown ){
        console.log(jqXHR);
        console.log(textStatus);
        console.log(errorThrown);
    });
}

function get_encuestas_liderazgo_comenzadas_mensual(){
    baseUrl = '/get_encuestas_liderazgo_comenzadas_mensual/';
    $.ajax({
        type: 'GET',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: baseUrl,
        dataType: 'JSON',
        success: function(response){
            let data= {"data":{"datasets":[{"data":response}]}};
            document.querySelector("li[id='chartLiderazgo']").setAttribute('data-update',JSON.stringify(data));
        }
    }).fail( function( jqXHR, textStatus, errorThrown ){
        console.log(jqXHR);
        console.log(textStatus);
        console.log(errorThrown);
    });

}



function get_avance_encuestas_satisfaccion(){
    baseUrl = '/get_avance_encuestas_satisfaccion/';
    $.ajax({
        type: 'GET',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: baseUrl,
        dataType: 'JSON',
        success: function(response){
            let id_tabla = 'avanceSatisfaccionTable';
            mostrar_tabla_avance(id_tabla,response);

        }
    }).fail( function( jqXHR, textStatus, errorThrown ){
        console.log(jqXHR);
        console.log(textStatus);
        console.log(errorThrown);
    });
}

function get_avance_encuestas_liderazgo(){

    baseUrl = '/get_avance_encuestas_liderazgo/';
    $.ajax({
        type: 'GET',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: baseUrl,
        dataType: 'JSON',
        success: function(response){
            let id_tabla = 'avanceLiderazgoTable';

            mostrar_tabla_avance(id_tabla,response);

        }
    }).fail( function( jqXHR, textStatus, errorThrown ){
        console.log(jqXHR);
        console.log(textStatus);
        console.log(errorThrown);
    });
}



function limpiarTabla(idElement){
    // console.log("limpiando tabla....");
    var table = document.getElementById(idElement);
    for(var i = table.rows.length - 1; i > 0; i--)
    {
        table.deleteRow(i);
    }
    return null;
}



function mostrar_tabla_avance(id_table,data){
    limpiarTabla(id_table);
    htmls ='<tr></tr>';
    $('#'+id_table+' tbody').html(htmls);
    var table = document.getElementById(id_table);
    for(var a=0;a < data.length;a++){
        var row = table.insertRow(a+1);
        row.insertCell(0).innerHTML = data[a].nombre?data[a].nombre:'';
        row.insertCell(1).innerHTML = data[a].preguntas_respondidas?data[a].preguntas_respondidas:'0';
        row.insertCell(2).innerHTML = '<div class="d-flex align-items-center">'+
        '<span class="mr-2">'+ data[a].porcentaje_avance+'%</span>'+
            '<div>'+
                '<div class="progress">'+
                    '<div class="progress-bar bg-gradient-primary" role="progressbar" aria-valuenow="'+ data[a].porcentaje_avance+'" aria-valuemin="0" aria-valuemax="100" style="width: '+ data[a].porcentaje_avance+'%;"></div>'+
                '</div>'+
            '</div>'+
        '</div>';
    }
    return null;
}


