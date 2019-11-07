
var tabla_preguntas ;
var tabla_opciones ;

// Funcion para cargar datos de la pregunta (carga opciones e imagen delegando en otras funciones)
function loadPregunta($id_pregunta){
    var datos = {
        'action' : "show",
        'id_pregunta' : $id_pregunta
    };

    $.ajax({
        url: '/php/abm-preguntas.php',//# TODO armar url
        type: 'POST',
        data: datos,
        dataSrc: 'data',
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

            // Recargo opciones de esa pregunta
            tabla_opciones.ajax.reload();

            // Cargo imagen de la pregunta
            loadImage($id_pregunta);


            $('#preguntaFormContainer').toggle();
            $('#preguntaFormContainer').show();

            $('#div_opciones-table').show();

            $('#extrasPreguntaContainer').toggle();
            $('#extrasPreguntaContainer').show();

        }
    })
}

function deletePregunta($id_pregunta){
    var datos = {
        'action' : "delete",
        'id_pregunta' : $id_pregunta
    };

    $.ajax({
        url: '/php/abm-preguntas.php',//# TODO armar url
        type: 'POST',
        data: datos,
        //dataType: 'json',
        success: function(data) {
            alert(" Eliminado pregunta ");
            var jsonResult = JSON.stringify(data);
            $("#results").val(unescape(jsonResult));
            tabla_preguntas.ajax.reload();
        },
        error: function(data) {
            alert(" ERROR Eliminando pregunta ");
            var jsonResult = JSON.stringify(data);
            $("#results").val( "ERROR " + unescape(jsonResult));

        }
    })
}

// Funcion para cargar la imagen
function loadImage($id_pregunta){

    var datos = {
        'action' : "show",
        'id_pregunta' : $id_pregunta
    };

    $.ajax({
        url: '/php/abm-preguntas-imagenes.php',//# TODO armar url
        type: 'POST',
        data: datos,
        dataSrc: 'data',
        dataType: 'json',
        success: function(data) {
            //alert(JSON.stringify(data));
            var imagen = data.data[0];
            if(imagen && imagen !="") {
                $('#imagen').attr("src", imagen.path);
            }else{
                $('#imagen').attr("src", '/img/no_image.jpg');
            }
            $('#imagenFormContainer').toggle();
            $('#imagenFormContainer').show();
        }
    })
}

// Funcion para cargar una opcion
function loadOption($id_opcion){

    var datos = {
        'action' : "show",
        'id_opcion' : $id_opcion
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
}

// Funcion para eliminar una opcion de la pregunta
function deleteOption($id_opcion){
    var datos = {
        'action' : "delete",
        'id_opcion' : $id_opcion
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
}


$(document).ready(function() {

    // Armo la DATATABLE de las preguntas : peticion ajax, mapeando JSON recibido y columnas
    tabla_preguntas = $('#preguntas-table').DataTable({
        "autoWidth": false,
        "order": [[ 0, "desc" ]],
        "processing": true,
        "ajax": {
            "url":"/php/abm-preguntas.php", //# TODO armar url
            "type": "POST",
            //"dataSrc": "data",
            "data": {
              'action': 'list'
            },
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
                    return "<button id='"+row.id+"' class='btn btn-primary btn-lg btn-block btn-view' data-toggle='modal' data-target='#preguntaModal'>Ver!</button>" ;
                }
            }

        ],
    });

    $('#preguntas-table tbody').on( 'click', 'button.btn-view', function () {
        var data = tabla_preguntas.row( $(this).parents('tr') ).data();

        $('#div_tipo_pregunta').hide();
        $('#div_vf_rta_valida').hide();
        $('#div_cant_opciones_validas').show();
        //$('#div_opciones-table').show();


        // Cargo datos de la pregunta
        loadPregunta(data.id_pregunta);
    } )

    // Evento eliminar asociado a cada ROW de la tabla de PREGUNTAS
    $('#preguntas-table tbody').on( 'click', 'button.btn-cancel', function () {
        var data = tabla_preguntas.row( $(this).parents('tr') ).data();
        deletePregunta(data.id_pregunta);

    } )


    // TABLA DE OPCIONES
    tabla_opciones = $('#opciones-table').DataTable({
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
        loadOption(data.id_opcion);

    } )

    // ELIMINAR OPCIONES DE PREGUNTA
    $('#opciones-table tbody').on( 'click', 'button.btn-cancel', function () {
        var data = tabla_opciones.row( $(this).parents('tr') ).data();
        deleteOption(data.id_opcion);


    } );


    function ajaxSaveOptionCallRequest(f_method, f_url, f_data) {
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
                //alert('Pregunta creada correctamente');

            },
            error: function(data) {
                var jsonResult = JSON.stringify(data);
                $("#results").val("ERROR "+ jsonResult);
                //alert('Error al crear pregunta');
            }

        });
    }

    function ajaxSaveQuestionCallRequest(f_method, f_url, f_data) {
        var f_contentType = 'application/x-www-form-urlencoded; charset=UTF-8';
        $.ajax({
            url: f_url,
            type: f_method,
            contentType: f_contentType,
            dataType: 'json',
            data: f_data,
            success: function(data) {

                if(data.id_pregunta){
                    $("#id_pregunta").val(data.id_pregunta);
                }

                if(f_data['tipo_pregunta'] == "VF")
                        simularInsertTrueFalse();

                var jsonResult = JSON.stringify(data);
                $("#results").val(unescape(jsonResult));
                alert('Pregunta creada correctamente');

            },
            error: function(data) {
                var jsonResult = JSON.stringify(data);
                $("#results").val("ERROR "+ jsonResult);
                alert('Error al crear pregunta');
            }

        });
    }


    function ajaxSaveImageRequest(f_method, f_url, f_data) {
        var f_contentType = 'multipart/form-data';

        $.ajax({
            url: f_url,
            type: f_method,
            //contentType: f_contentType,
            contentType: false,
            processData: false,
            data: f_data,
            success: function(data) {
                var jsonResult = JSON.stringify(data);
                $("#results").val(unescape(jsonResult));
                loadImage($('#id_pregunta').val());
            },
            error: function(data) {
                var jsonResult = JSON.stringify(data);
                $("#results").val("ERROR "+ jsonResult);
            }

        });
    }

    $('#tipo_pregunta').on('change', function() {
        tipo_pregunta = $("#tipo_pregunta option:selected" ).val();
        //alert(tipo_pregunta);
        if(tipo_pregunta == "MC"){
            $('#div_vf_rta_valida').hide();
            $('#div_cant_opciones_validas').show();
            $('#opciones-table').DataTable().clear().draw();
            $('#div_opciones-table').show();
        }else if(tipo_pregunta == "VF"){
            $('#div_cant_opciones_validas').hide();
            $('#div_opciones-table').hide();
            $('#div_vf_rta_valida').show();


        }
    })

    // Evento del boton de GRABAR PREGUNTAS
    $("#saveButton").click(function(event) {
        event.preventDefault();
        var form = $('#ajaxForm');
        var method = form.attr('method');
        var url = form.attr('action') ;

        tipo_pregunta = $("#tipo_pregunta option:selected" ).val();
        if(tipo_pregunta == "VF"){
            $('input[name="cant_opciones_validas"]').val("1");
        }

        var jsonData = $(form).serializeObject();
        console.log(jsonData);
        //ajaxSaveQuestionCallRequest(method, url, jsonData);

        // GRABO OPCIONES VERDADERO/FALSE
        //if(tipo_pregunta == "VF") {
            ajaxSaveQuestionCallRequest(method, url, jsonData);
        //}else{
        //    ajaxCallRequest(method, url, jsonData);
        //}

        $('#modalImagenButton').show();
        $('#extrasPreguntaContainer').show();
        $('#preguntas-table').DataTable().ajax.reload();
    });

    // Evento de NUEUVA PREGUNTA
    $("#newButton").click(function(event) {
        event.preventDefault();
        var form = $('#ajaxForm');
        form.get(0).reset();


        $('#div_tipo_pregunta').show();
        $('#div_vf_rta_valida').hide();
        $('#div_cant_opciones_validas').hide();

        $('#modalImagenButton').hide();
        $('#extrasPreguntaContainer').hide();
        $('#opciones-table').DataTable().clear().draw();

        //$('#div_opciones-table').hide();

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
        ajaxSaveOptionCallRequest(method, url, jsonData);

        $('#opciones-table').DataTable().ajax.reload();
        $('#opcionFormContainer').hide();
    });

    // Evento del boton de GRABAR IMAGEN
    $("#saveButton_imagen").click(function(event) {
        event.preventDefault();
        var form = $('#imagenForm');
        var method = form.attr('method');
        var url = form.attr('action') ;

        var jsonData = $(form).serializeObject();

        var fd = new FormData();
        var files = $('#nueva_imagen')[0].files[0];

        fd.append('action',jsonData['action_imagen']);
        fd.append('id_pregunta',$('#id_pregunta').val());
        fd.append('nueva_imagen',files);

        //var jsonData = $(form).serializeObject();
        //console.log(jsonData);
        ajaxSaveImageRequest(method, url, fd);

    });

    // Evento de NUEUVA OPCION
    $("#newButton_opcion").click(function(event) {
        event.preventDefault();
        var form = $('#opcionForm');
        form.get(0).reset();

        $('#opcionFormContainer').toggle();
        $('#opcionFormContainer').show();
    });

    function simularInsertTrueFalse() {
        var form = $('#opcionForm');
        var method = form.attr('method');
        var url = form.attr('action');
        var jsonData = $(form).serializeObject();

        //alert($('#id_pregunta').val());
        jsonData['action'] = 'create';
        jsonData['id_pregunta'] = Number($('#id_pregunta').val());

        jsonData['descripcion'] = 'VERDADERO';
        jsonData['es_correcta'] = Number($('#vf_rta_valida').val() == "V");

        console.log(jsonData);
        ajaxSaveOptionCallRequest(method, url, jsonData);

        jsonData['descripcion'] = 'FALSO';
        jsonData['es_correcta'] = Number($('#vf_rta_valida').val() == "F");

        console.log(jsonData);
        ajaxSaveOptionCallRequest(method, url, jsonData);

    }

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
