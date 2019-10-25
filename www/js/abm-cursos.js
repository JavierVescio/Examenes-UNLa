

$(document).ready(function() {
    //alert("TEST");

    // Armo la DATATABLE de los administradores : peticion ajax, mapeando JSON recibido y columnas
    var table = $('#cursos-table').DataTable({
        "autoWidth": false,
        "order": [[ 0, "desc" ]],
        "processing": true,

        "ajax": {
            "url":"/php/abm-cursos.php", //# TODO armar url
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
            { "data": "id_curso"},
            { "data": "nombre"},
            { "data": "descripcion"},
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

    $('#cursos-table tbody').on( 'click', 'button.btn-view', function () {
        var data = table.row( $(this).parents('tr') ).data();

        //alert('DEberia cargar el form con los datos');
        var datos = {
            'action' : "show",
            'id_curso' : data.id_curso
        };

        $.ajax({
            url: '/php/abm-cursos.php',//# TODO armar url
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

                var curso = data.data[0];

                // Muestro en el recuadro los resultados para debug
                var jsonResult = JSON.stringify(curso);
                $("#results").val(unescape(jsonResult));

                // Seteo los campos del formulario
                $('#id_curso').val(curso.id_curso);
                $('#nombre').val(curso.nombre);
                $('#descripcion').val(curso.descripcion);

                $('#cursoFormContainer').toggle();
                $('#cursoFormContainer').show();

            }
        })

    } )

    // Evento eliminar asociado a cada ROW de la tabla
    $('#cursos-table tbody').on( 'click', 'button.btn-cancel', function () {
        var data = table.row( $(this).parents('tr') ).data();

        var datos = {
            'action' : "delete",
            'id_curso' : data.id_curso
        };

        $.ajax({
            url: '/php/abm-cursos.php',//# TODO armar url
            type: 'POST',
            data: datos,
            //dataType: 'json',
            success: function(data) {
                alert(" Eliminado curso ");
                var jsonResult = JSON.stringify(data);
                $("#results").val(unescape(jsonResult));
                $('#cursos-table').DataTable().ajax.reload();
            },
            error: function(data) {
                alert(" ERROR Eliminando curso ");
                var jsonResult = JSON.stringify(data);
                $("#results").val( "ERROR " + unescape(jsonResult));

            }
        })

    } )


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
                //localStorage.removeItem('auth_token');
                $("#results").val("ERROR "+ jsonResult);
            }

        });
    }

    // Evento del boton de GRABAR del formulario
    $("#saveButton").click(function(event) {
        event.preventDefault();
        var form = $('#ajaxForm');
        var method = form.attr('method');
        var url = form.attr('action') ;
        var jsonData = $(form).serializeObject();
        console.log(jsonData);
        ajaxCallRequest(method, url, jsonData);
        $('#cursos-table').DataTable().ajax.reload();
    });

    $("#newButton").click(function(event) {
        event.preventDefault();
        var form = $('#ajaxForm');
        form.get(0).reset();

        $('#cursoFormContainer').toggle();
        $('#cursoFormContainer').show();
    });



});


