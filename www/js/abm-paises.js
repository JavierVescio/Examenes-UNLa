

$(document).ready(function() {

    // Armo la DATATABLE de los administradores : peticion ajax, mapeando JSON recibido y columnas
    var table = $('#paises-table').DataTable({
        "autoWidth": false,
        "order": [[ 0, "desc" ]],
        "processing": true,
        info: false,
        retrieve: false,
        bPaginate: false,
        oLanguage:{
            "sSearch": "Buscar: "
        },
        "ajax": {
            "url":"/php/abm-paises.php", //# TODO armar url
            "type": "POST",
            "data": {
              'action': 'list'
            },
        },

        "columns": [
            { "data": "id_pais"},
            { "data": "nombre"},
            { "data": "nombre_corto"},
            {
                //"targets": -1,
                "data": null,
                'render': function (data, type, row) {
                    return "<button id='"+row.id+"' class='btn btn-primary btn-block btn-cancel btn-danger glyphicon glyphicon-trash'></button>" ;
                }
            },
            {
                //"targets": -1,
                "data": null,
                'render': function (data, type, row) {
                    return "<button id='"+row.id+"' class='btn btn-primary btn-block btn-view glyphicon glyphicon-pencil' data-toggle='modal' data-target='#paisModal'></button>" ;
                }
            }

        ],
    });

    $('#paises-table tbody').on( 'click', 'button.btn-view', function () {
        var data = table.row( $(this).parents('tr') ).data();

        var datos = {
            'action' : "show",
            'id_pais' : data.id_pais
        };

        $.ajax({
            url: '/php/abm-paises.php',//# TODO armar url
            type: 'POST',
            data: datos,
            dataSrc: 'data',
            dataType: 'json',
            success: function(data) {

                var pais = data.data[0];

                // Muestro en el recuadro los resultados para debug
                //var jsonResult = JSON.stringify(pais);
                //$("#results").val(unescape(jsonResult));

                // Seteo los campos del formulario
                $('#id_pais').val(pais.id_pais);
                $('#nombre').val(pais.nombre);
                $('#nombre_corto').val(pais.nombre_corto);

            }
        })

    } )

    // Evento eliminar asociado a cada ROW de la tabla
    $('#paises-table tbody').on( 'click', 'button.btn-cancel', function () {
        var data = table.row( $(this).parents('tr') ).data();

        var datos = {
            'action' : "delete",
            'id_pais' : data.id_pais
        };

        $.ajax({
            url: '/php/abm-paises.php',//# TODO armar url
            type: 'POST',
            data: datos,
            //dataType: 'json',
            success: function(data) {
                alert(" Eliminado pais ");
               // var jsonResult = JSON.stringify(data);
                //$("#results").val(unescape(jsonResult));
                $('#sede-table').DataTable().ajax.reload();
            },
            error: function(data) {
                alert(" ERROR Eliminando pais ");
                //var jsonResult = JSON.stringify(data);
                //$("#results").val( "ERROR " + unescape(jsonResult));

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
                //var jsonResult = JSON.stringify(data);
                //$("#results").val(unescape(jsonResult));

            },
            error: function(data) {
                //var jsonResult = JSON.stringify(data);
                //localStorage.removeItem('auth_token');
                //$("#results").val("ERROR "+ jsonResult);
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
        $('#paises-table').DataTable().ajax.reload();
        $('#paisModal').modal('toggle')
    });

    $("#newButton").click(function(event) {
        event.preventDefault();
        var form = $('#ajaxForm');
        form.get(0).reset();

    });



});


