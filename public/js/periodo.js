$(function(){    
    get_periodo();

});

function get_periodo(){
    baseUrl = '/get_periodo';
    $.ajax({
        type: 'GET',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: baseUrl,
        dataType: 'JSON',
        success: function(response){
            // console.log(response);
            mostrar_tabla_periodo(response);
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

function mostrar_tabla_periodo(data){
    limpiarTabla('periodoTable');
    htmls ='<tr></tr>';
    $('#periodoTable tbody').html(htmls);
    var table = document.getElementById("periodoTable");
    for(var a=0;a < data.length;a++){
        var row = table.insertRow(a+1);
        row.insertCell(0).innerHTML = a+1;
        row.insertCell(1).innerHTML = data[a].fecha_inicio?data[a].fecha_inicio:'';
        row.insertCell(2).innerHTML = data[a].fecha_fin?data[a].fecha_fin:'';
        row.insertCell(3).innerHTML = '<button type="button" class="btn btn-primary btn-sm" title="Editar" onClick="editarPeriodo('+data[a].id+')" data-toggle="modal" data-target="#periodoModal">'+
        '<span class="btn-inner--icon"> <i class="ni ni-ruler-pencil"></i></span>'+
        '</button>'+
        '<button type="button" class="btn btn-danger btn-sm" title="Eliminar" onClick="eliminarPeriodo('+data[a].id+')">'+
        '<span class="btn-inner--icon"> <i class="ni ni-basket"></i></span>'+
        '</button>';
    }
    return null;
}

function agregarPeriodo(){
    document.querySelector("h5[id='periodomodalLabel']").textContent= 'Agregar Periodo';
}




function guardarPeriodo(){
    let fecha_inicio_periodo = document.querySelector("form[id='periodoForm'] input[id='fecha_inicio_periodo']").value;
    let fecha_fin_periodo = document.querySelector("form[id='periodoForm'] input[id='fecha_fin_periodo']").value;

    if(fecha_inicio_periodo.length >0 && fecha_fin_periodo.length >0 ){

        let data={'fecha_inicio':fecha_inicio_periodo,'fecha_fin':fecha_fin_periodo};


        baseUrl = '/guardar_periodo';
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
                    get_periodo();
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

function eliminarPeriodo(id){
    if(id > 0){
         baseUrl = '/eliminar_periodo/'+id;
        $.ajax({
            type: 'DELETE',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: baseUrl,
            dataType: 'JSON',
            success: function(response){
                // console.log(response);
                if(response.status==200){
                    // ok
                    get_periodo();
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
        alert('Hubo un problema con el ID, no se pudo eliminar');
    }
}
function editarPeriodo(id){

    baseUrl = '/get_periodo/'+id;
    $.ajax({
        type: 'GET',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: baseUrl,
        dataType: 'JSON',
        success: function(response){            
            document.querySelector("form[id='periodoForm'] input[id='fecha_inicio_periodo']").value = response.fecha_inicio;
            document.querySelector("form[id='periodoForm'] input[id='fecha_fin_periodo']").value = response.fecha_fin;        

        }
    }).fail( function( jqXHR, textStatus, errorThrown ){
        console.log(jqXHR);
        console.log(textStatus);
        console.log(errorThrown);
    });

    document.querySelector("h5[id='periodomodalLabel']").textContent= 'Editar Periodo';
    document.querySelector("button[id='btnGuardarPeriodo']").textContent = 'Actualizar';
    document.querySelector("button[id='btnGuardarPeriodo']").setAttribute('onclick','actualizarPeriodo('+id+')');
    document.querySelector("button[id='btnGuardarPeriodo']").setAttribute('class','btn btn-warning');
}

function actualizarPeriodo(id){
    let fecha_inicio_periodo = document.querySelector("form[id='periodoForm'] input[id='fecha_inicio_periodo']").value;
    let fecha_fin_periodo = document.querySelector("form[id='periodoForm'] input[id='fecha_fin_periodo']").value;

    let data={'id':id, 'fecha_inicio':fecha_inicio_periodo,'fecha_fin':fecha_fin_periodo};

    baseUrl = '/actualizar_periodo';
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
                get_periodo();
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