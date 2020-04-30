$(function(){    
    get_tipo_encuesta();

});

function get_tipo_encuesta(){
    baseUrl = '/get_tipo_encuesta';
    $.ajax({
        type: 'GET',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: baseUrl,
        dataType: 'JSON',
        success: function(response){
            // console.log(response);
            mostrar_tabla_tipo_encuesta(response);
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

function mostrar_tabla_tipo_encuesta(data){
    limpiarTabla('tipoEncuestaTable');
    htmls ='<tr></tr>';
    $('#tipoEncuestaTable tbody').html(htmls);
    var table = document.getElementById("tipoEncuestaTable");
    for(var a=0;a < data.length;a++){
        var row = table.insertRow(a+1);
        row.insertCell(0).innerHTML = a+1;
        row.insertCell(1).innerHTML = data[a].descripcion?data[a].descripcion:'';
        row.insertCell(2).innerHTML = '<button type="button" class="btn btn-primary btn-sm" title="Editar" onClick="editarTipoEncuesta('+data[a].id+')" data-toggle="modal" data-target="#tipoEncuestaModal">'+
        '<span class="btn-inner--icon"> <i class="ni ni-ruler-pencil"></i></span>'+
        '</button>';
    }
    return null;
}


function editarTipoEncuesta(id){
    baseUrl = '/get_tipo_encuesta/'+id;
    $.ajax({
        type: 'GET',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: baseUrl,
        dataType: 'JSON',
        success: function(response){
            document.querySelector("form[id='tipoEncuestaForm'] input[id='tipoEncuestaFormControlInput']").value= response.descripcion;
    
        }
    }).fail( function( jqXHR, textStatus, errorThrown ){
        console.log(jqXHR);
        console.log(textStatus);
        console.log(errorThrown);
    });

    document.querySelector("h5[id='tipoEncuestamodalLabel']").textContent= 'Editar Tipo Encuesta';
    document.querySelector("button[id='btnGuardarTipoEncuesta']").textContent = 'Actualizar';
    document.querySelector("button[id='btnGuardarTipoEncuesta']").setAttribute('onclick','actualizarTipoEncuesta('+id+')');
    document.querySelector("button[id='btnGuardarTipoEncuesta']").setAttribute('class','btn btn-warning');
}

function actualizarTipoEncuesta(id){
    let descripcion = document.querySelector("form[id='tipoEncuestaForm'] input[id='tipoEncuestaFormControlInput']").value;

    let data={'id':id, 'descripcion':descripcion};

    baseUrl = '/actualizar_tipo_encuesta';
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
                get_tipo_encuesta();
                alert('Se actualizo con existo');
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