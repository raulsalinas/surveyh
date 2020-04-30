$(function(){    
    get_preguntas();

});

function get_preguntas(){
    baseUrl = '/get_pregunta';
    $.ajax({
        type: 'GET',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: baseUrl,
        dataType: 'JSON',
        success: function(response){
            // console.log(response);
            mostrar_tabla_preguntas(response);
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

function mostrar_tabla_preguntas(data){
    limpiarTabla('preguntaTable');
    htmls ='<tr></tr>';
    $('#preguntaTable tbody').html(htmls);
    var table = document.getElementById("preguntaTable");
    for(var a=0;a < data.length;a++){
        var row = table.insertRow(a+1);
        row.insertCell(0).innerHTML = a+1;
        row.insertCell(1).innerHTML = data[a].descripcion?data[a].descripcion:'';
        row.insertCell(2).innerHTML = data[a].tipo_encuesta_descripcion?data[a].tipo_encuesta_descripcion:'';
        row.insertCell(3).innerHTML = '<button type="button" class="btn btn-primary btn-sm" title="Editar" onClick="editarPregunta('+data[a].id+')" data-toggle="modal" data-target="#preguntaModal">'+
        '<span class="btn-inner--icon"> <i class="ni ni-ruler-pencil"></i></span>'+
        '</button>'+
        '<button type="button" class="btn btn-danger btn-sm" title="Eliminar" onClick="eliminarPregunta('+data[a].id+')">'+
        '<span class="btn-inner--icon"> <i class="ni ni-basket"></i></span>'+
        '</button>';
    }
    return null;
}

function agregarPregunta(){
    document.querySelector("h5[id='preguntamodalLabel']").textContent= 'Agregar Pregunta';
    cargar_tipo_encuesta();
}


function cargar_tipo_encuesta(){
    document.querySelector("select[id='tipoPreguntaFormControlSelect']").options.length = 0;

    baseUrl = '/get_tipo_encuesta';
    $.ajax({
        type: 'GET',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: baseUrl,
        dataType: 'JSON',
        success: function(response){
            // console.log(response);
            response.map((value,index)=>{
                let combo = document.querySelector("select[id='tipoPreguntaFormControlSelect']");
                let option = document.createElement("option");
                option.text = value.descripcion;
                option.value = value.id;
                combo.add(option);
            });



        }
    }).fail( function( jqXHR, textStatus, errorThrown ){
        console.log(jqXHR);
        console.log(textStatus);
        console.log(errorThrown);
    });
}

function guardarPregunta(){
    let pregunta = document.querySelector("form[id='preguntaForm'] input[id='preguntaFormControlInput']").value;
    let tipo_encuesta = document.querySelector("form[id='preguntaForm'] select[id='tipoPreguntaFormControlSelect']").value;

    if(pregunta.length >0){

        let data={'pregunta':pregunta,'tipo_encuesta':tipo_encuesta};


        baseUrl = '/guardar_pregunta';
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
                    get_preguntas();
                    alert('Se guardo con existo');
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
    }else{
        alert('Debe escriir una texto en el campo pregunta');
    }
}

function eliminarPregunta(id){
    if(id > 0){
         baseUrl = '/eliminar_pregunta/'+id;
        $.ajax({
            type: 'DELETE',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: baseUrl,
            dataType: 'JSON',
            success: function(response){
                console.log(response);
                if(response.status==200){
                    // ok
                    get_preguntas();
                    alert('Se elimino con existo');
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
    }else{
        alert('Hubo un problema con el ID de la pregunta, no se pudo eliminar');
    }
}
function editarPregunta(id){
    cargar_tipo_encuesta();

    baseUrl = '/get_pregunta/'+id;
    $.ajax({
        type: 'GET',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: baseUrl,
        dataType: 'JSON',
        success: function(response){
            
            document.querySelector("form[id='preguntaForm'] input[id='preguntaFormControlInput']").value= response.descripcion;
            document.querySelector("form[id='preguntaForm'] select[id='tipoPreguntaFormControlSelect']").value = response.id_tipo_encuesta;
        

        }
    }).fail( function( jqXHR, textStatus, errorThrown ){
        console.log(jqXHR);
        console.log(textStatus);
        console.log(errorThrown);
    });

    document.querySelector("h5[id='preguntamodalLabel']").textContent= 'Editar Pregunta';
    document.querySelector("button[id='btnGuardarPregunta']").textContent = 'Actualizar';
    document.querySelector("button[id='btnGuardarPregunta']").setAttribute('onclick','actualizarPregunta('+id+')');
    document.querySelector("button[id='btnGuardarPregunta']").setAttribute('class','btn btn-warning');
}

function actualizarPregunta(id){
    let pregunta = document.querySelector("form[id='preguntaForm'] input[id='preguntaFormControlInput']").value;
    let tipo_encuesta = document.querySelector("form[id='preguntaForm'] select[id='tipoPreguntaFormControlSelect']").value;

    let data={'id':id,'pregunta':pregunta,'tipo_encuesta':tipo_encuesta};

    baseUrl = '/actualizar_pregunta';
    $.ajax({
        type: 'PUT',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: baseUrl,
        dataType: 'JSON',
        data:data,
        success: function(response){
            // console.log(response);
            if(response.status==200){
                // ok
                get_preguntas();
                alert('Se guardo con existo');
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