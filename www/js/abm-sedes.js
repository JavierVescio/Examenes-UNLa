

$(document).ready(function() {
    //alert("TEST");

    // Armo la DATATABLE de los administradores : peticion ajax, mapeando JSON recibido y columnas
    var table = $('#sedes-table').DataTable({
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
            "url":"/php/abm-sedes.php", //# TODO armar url
            "type": "POST",
            "data": {
              'action': 'list'
            },
        },

        "columns": [
            { "data": "id_sede"},
            { "data": "nombre"},
            { "data": "direccion"},
            { "data": "id_pais"},
            {
                //"targets": -1,
                "data": null,
                'render': function (data, type, row) {
                    return "<button id='"+row.id+"' class='btn btn-primary btn-block btn-cancel btn-danger glyphicon glyphicon-trash '></button>" ;
                }
            },
            {
                //"targets": -1,
                "data": null,
                'render': function (data, type, row) {
                    return "<button id='"+row.id+"' class='btn btn-primary btn-block btn-view glyphicon glyphicon-pencil' data-toggle='modal' data-target='#sedeModal'></button>" ;
                }
            }

        ],
    });

    $('#sedes-table tbody').on( 'click', 'button.btn-view', function () {
        var data = table.row( $(this).parents('tr') ).data();

        //alert('DEberia cargar el form con los datos');
        var datos = {
            'action' : "show",
            'id_sede' : data.id_sede
        };

        $.ajax({
            url: '/php/abm-sedes.php',//# TODO armar url
            type: 'POST',
            data: datos,
            dataSrc: 'data',
            dataType: 'json',
            success: function(data) {

                var sede = data.data[0];

                // Muestro en el recuadro los resultados para debug
                //var jsonResult = JSON.stringify(sede);
                //$("#results").val(unescape(jsonResult));

                // Seteo los campos del formulario
                $('#id_sede').val(sede.id_sede);
                $('#nombre').val(sede.nombre);
                $('#direccion').val(sede.direccion);
                $('#id_pais').val(sede.id_pais);



            }
        })
    } )

    // Evento eliminar asociado a cada ROW de la tabla
    $('#sedes-table tbody').on( 'click', 'button.btn-cancel', function () {
        var data = table.row( $(this).parents('tr') ).data();

        var datos = {
            'action' : "delete",
            'id_sede' : data.id_sede
        };

        $.ajax({
            url: '/php/abm-sedes.php',//# TODO armar url
            type: 'POST',
            data: datos,
            //dataType: 'json',
            success: function(data) {
                alert(" Eliminado sede ");
                //var jsonResult = JSON.stringify(data);
                //$("#results").val(unescape(jsonResult));
                $('#sedes-table').DataTable().ajax.reload();
            },
            error: function(data) {
                alert(" ERROR Eliminando sede ");
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
        $('#sedes-table').DataTable().ajax.reload();
        $('#sedeModal').modal('toggle');

    });

    $("#newButton").click(function(event) {
        event.preventDefault();
        var form = $('#ajaxForm');
        form.get(0).reset();

    });

    fillPaises('id_pais');

});


function fillPaises(idSelect)
{
    $('#'+idSelect).empty()
    $.ajax({
        type: "POST",
        url: "/php/abm-paises.php",
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
                //console.log(i +' ->' + d)
                $('#'+idSelect).append('<option value="' + d.id_pais + '">' + d.nombre_corto + ' - '  + d.nombre + '</option>');
            });
        }
    });

}