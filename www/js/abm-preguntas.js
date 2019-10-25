

$(document).ready(function() {

    // TEST MULTILINEA
    var i=1;
    $("#add_row").click(function(){
        b=i-1;
        $('#addr'+i).html($('#addr'+b).html()).find('td:first-child').html(i+1);
        $('#tab_logic').append('<tr id="addr'+(i+1)+'"></tr>');
        i++;
    });
    $("#delete_row").click(function(){
        if(i>1){
            $("#addr"+(i-1)).html('');
            i--;
        }
    });
    // FIN ---- TEST MULTILINEA

    // Armo la DATATABLE de las preguntas : peticion ajax, mapeando JSON recibido y columnas
    var table = $('#preguntas-table').DataTable({
        "autoWidth": false,
        "order": [[ 0, "desc" ]],
        "processing": true,
        "ajax": {
            "url":"/php/abm-preguntas.php", //# TODO armar url
            /*"beforeSend": function (request) {
                request.setRequestHeader("Authorization", "Token "+token);
            },*/
            "type": "POST",
            //"dataSrc": "data",
            "data": {
              'action': 'list'
            },
            /*"success": function(d){
              console.log(d);
            },
            "error": function(d){
                console.log(d);
            }*/
        },

        "columns": [
            { "data": "id_pregunta"},
            { "data": "descripcion"},
            { "data": "cant_opciones_validas"},
            { "data": "id_curso"},
            {
                //"targets": -1,
                "data": null,
                'render': function (data, type, row) {
                    return "<button id='"+row.id+"' class='btn btn-primary btn-lg btn-block btn-cancel'>Eliminar!</button>" ;
                }
            },
            {
                //"targets": -1,
                "data": null,
                'render': function (data, type, row) {
                    return "<button id='"+row.id+"' class='btn btn-primary btn-lg btn-block btn-view'>Ver!</button>" ;
                }
            }

        ],
    });

    $('#preguntas-table tbody').on( 'click', 'button.btn-view', function () {
        var data = table.row( $(this).parents('tr') ).data();

        var datos = {
            'action' : "show",
            'id_pregunta' : data.id_pregunta
        };

        $.ajax({
            url: '/php/abm-preguntas.php',//# TODO armar url
            type: 'POST',
            data: datos,
            dataSrc: 'data',
            headers: {
                //'x-auth-token': localStorage.accessToken,
                //"Authorization": "Token "+localStorage.auth_token,
                //"Content-Type": "application/json"
            },
            dataType: 'json',
            success: function(data) {

                var pregunta = data.data[0];

                // Muestro en el recuadro los resultados para debug
                var jsonResult = JSON.stringify(pregunta);
                $("#results").val(unescape(jsonResult));

                // Seteo los campos del formulario
                $('#id_pregunta').val(pregunta.id_pregunta);
                $('#descripcion').val(pregunta.descripcion);
                $('#cant_opciones_validas').val(pregunta.cant_opciones_validas);
                $('#id_curso').val(pregunta.id_curso);

                $('#opciones-table').DataTable().ajax.reload();
                //$('#opciones-table').DataTable().ajax.url('/php/abm-preguntas-opciones.php').load();

                $('#preguntaFormContainer').toggle();
                $('#preguntaFormContainer').show();

            }
        })
    } )

    // Evento eliminar asociado a cada ROW de la tabla de PREGUNTAS
    $('#preguntas-table tbody').on( 'click', 'button.btn-cancel', function () {
        var data = table.row( $(this).parents('tr') ).data();

        var datos = {
            'action' : "delete",
            'id_pregunta' : data.id_pregunta
        };

        $.ajax({
            url: '/php/abm-preguntas.php',//# TODO armar url
            type: 'POST',
            data: datos,
            headers: {
                //'x-auth-token': localStorage.accessToken,
                //"Authorization": "Token "+localStorage.auth_token,
                //"Content-Type": "application/json"
            },
            //dataType: 'json',
            success: function(data) {
                alert(" Eliminado pregunta ");
                var jsonResult = JSON.stringify(data);
                $("#results").val(unescape(jsonResult));
                $('#preguntas-table').DataTable().ajax.reload();
            },
            error: function(data) {
                alert(" ERROR Eliminando pregunta ");
                var jsonResult = JSON.stringify(data);
                $("#results").val( "ERROR " + unescape(jsonResult));

            }
        })

    } )


    // TABLA DE OPCIONES
    var tabla_opciones = $('#opciones-table').DataTable({
        "autoWidth": false,
        "order": [[ 0, "desc" ]],
        "processing": true,
        "paging":   false,
        "ordering": false,
        "info":     false,
        "bFilter": false,
        "ajax": {
            "url":"/php/abm-preguntas-opciones.php", //# TODO armar url
            "type": "POST",
            "data" : function ( d ) {
                return $.extend({}, d, {
                    'action': 'listFromQuestion',
                    'id_pregunta': $('#id_pregunta').val()
                });
            },
            /*
            "success": function(d){
              console.log(d);
            },
            "error": function(d){
                console.log(d);
            }*/
        },

        "columns": [
            { "data": "id_opcion"},
            { "data": "descripcion"},
            { "data": "es_correcta"},
            {
                //"targets": -1,
                "data": null,
                'render': function (data, type, row) {
                    return "<button id='"+row.id+"' class='btn btn-primary btn-lg btn-block btn-cancel'>X</button>" ;
                }
            },
            {
                //"targets": -1,
                "data": null,
                'render': function (data, type, row) {
                    return "<button id='"+row.id+"' class='btn btn-primary btn-lg btn-block btn-view'>Ver!</button>" ;
                }
            }

        ],
    });

    // EDITAR/VER DATOS DE OPCION
    $('#opciones-table tbody').on( 'click', 'button.btn-view', function () {
        var data = tabla_opciones.row( $(this).parents('tr') ).data();

        var datos = {
            'action' : "show",
            'id_opcion' : data.id_opcion
        };

        $.ajax({
            url: '/php/abm-preguntas-opciones.php',//# TODO armar url
            type: 'POST',
            data: datos,
            dataSrc: 'data',
            dataType: 'json',
            success: function(data) {

                var opcion = data.data[0];

                // Muestro en el recuadro los resultados para debug
                var jsonResult = JSON.stringify(opcion);
                $("#results").val(unescape(jsonResult));

                // Seteo los campos del formulario
                $('#id_opcion').val(opcion.id_opcion);
                $('#descripcion_opcion').val(opcion.descripcion);
                $('#es_correcta').prop('checked', getBoolean(opcion.es_correcta));

                $('#opcionFormContainer').toggle();
                $('#opcionFormContainer').show();

            }
        })

    } )

    // ELIMINAR OPCIONES DE PREGUNTA
    $('#opciones-table tbody').on( 'click', 'button.btn-cancel', function () {
        var data = tabla_opciones.row( $(this).parents('tr') ).data();

        var datos = {
            'action' : "delete",
            'id_opcion' : data.id_opcion
        };

        $.ajax({
            url: '/php/abm-preguntas-opciones.php',//# TODO armar url
            type: 'POST',
            data: datos,
            //dataType: 'json',
            success: function(data) {
                alert(" Eliminado opcion ");
                var jsonResult = JSON.stringify(data);
                $("#results").val(unescape(jsonResult));
                tabla_opciones.ajax.reload();
            },
            error: function(data) {
                alert(" ERROR Eliminando opcion ");
                var jsonResult = JSON.stringify(data);
                $("#results").val( "ERROR " + unescape(jsonResult));

            }
        })

    } );


    function ajaxCallRequest(f_method, f_url, f_data) {
        var f_contentType = 'application/x-www-form-urlencoded; charset=UTF-8';
        $.ajax({
            url: f_url,
            type: f_method,
            contentType: f_contentType,
            dataType: 'json',
            data: f_data,
            success: function(data) {
                var jsonResult = JSON.stringify(data);
                $("#results").val(unescape(jsonResult));

            },
            error: function(data) {
                var jsonResult = JSON.stringify(data);
                $("#results").val("ERROR "+ jsonResult);
            }

        });
    }


    function ajaxSaveOptionRequest(f_method, f_url, f_data) {
        var f_contentType = 'application/x-www-form-urlencoded; charset=UTF-8';

        $.ajax({
            url: f_url,
            type: f_method,
            contentType: f_contentType,
            dataType: 'json',
            data: f_data,
            success: function(data) {
                var jsonResult = JSON.stringify(data);
                $("#results").val(unescape(jsonResult));

            },
            error: function(data) {
                var jsonResult = JSON.stringify(data);
                $("#results").val("ERROR "+ jsonResult);
            }

        });
    }

    // Evento del boton de GRABAR PREGUNTAS
    $("#saveButton").click(function(event) {
        event.preventDefault();
        var form = $('#ajaxForm');
        var method = form.attr('method');
        var url = form.attr('action') ;
        var jsonData = $(form).serializeObject();
        console.log(jsonData);
        ajaxCallRequest(method, url, jsonData);
        $('#preguntas-table').DataTable().ajax.reload();
    });

    // Evento de NUEUVA PREGUNTA
    $("#newButton").click(function(event) {
        event.preventDefault();
        var form = $('#ajaxForm');
        form.get(0).reset();

        $('#preguntaFormContainer').toggle();
        $('#preguntaFormContainer').show();
    });

    // Lleno select de CURSOS
    fillCursos('id_curso');

    // Evento del boton de GRABAR OPCIONES
    $("#saveButton_opcion").click(function(event) {
        event.preventDefault();
        var form = $('#opcionForm');
        var method = form.attr('method');
        var url = form.attr('action') ;
        var jsonData = $(form).serializeObject();

        jsonData['action'] = jsonData['action_opcion'];
        jsonData['descripcion'] = jsonData['descripcion_opcion'];
        jsonData['id_pregunta'] = $('#id_pregunta').val();
        jsonData['es_correcta'] = Number($('#es_correcta').is(":checked"));

        console.log(jsonData);
        ajaxSaveOptionRequest(method, url, jsonData);
        $('#opciones-table').DataTable().ajax.reload();
    });

    // Evento de NUEUVA OPCION
    $("#newButton_opcion").click(function(event) {
        event.preventDefault();
        var form = $('#opcionForm');
        form.get(0).reset();

        $('#opcionFormContainer').toggle();
        $('#opcionFormContainer').show();
    });

});


function fillCursos(idSelect)
{
    $('#'+idSelect).empty()
    $.ajax({
        type: "POST",
        url: "/php/abm-cursos.php",
        headers: {
            //'x-auth-token': localStorage.accessToken,
            //"Content-Type": "application/json"
        },
        dataType: 'json',
        data: { 'action': 'list'  },
        success: function(data){
            data = data.data ;
            console.log(data);
            $.each(data, function(i, d) {
                $('#'+idSelect).append('<option value="' + d.id_curso + '">' + d.nombre + '</option>');
            });
        }
    });

}

function getBoolean(value){
    switch(value){
        case true:getBoolean
        case "true":
        case 1:
        case "1":
        case "on":
        case "yes":
            return true;
        default:
            return false;
    }
}

