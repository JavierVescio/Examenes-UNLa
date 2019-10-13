

$(document).ready(function() {
    //alert("TEST");

    // Armo la DATATABLE de los administradores : peticion ajax, mapeando JSON recibido y columnas
    var table = $('#datatable').DataTable({
        "autoWidth": false,
        "order": [[ 0, "desc" ]],
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url":"/php/abm-admins.php", //# TODO armar url
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
            { "data": "id_staff"},
            { "data": "apellido"},
            { "data": "nombre"},
            { "data": "tipo_doc"},
            { "data": "documento"},
            { "data": "tipo_perfil"},
            { "data": "email"},
            {
                //"targets": -1,
                "data": null,
                //"defaultContent": "<button id='cancel' class='btn btn-primary btn-lg btn-block btn-cancel'>Cancelar!</button>"
                'render': function (data, type, row) {
                    return "<button id='"+row.id+"' class='btn btn-primary btn-lg btn-block btn-cancel'>Eliminar!</button>" ;
                }
            },
            {
                //"targets": -1,
                "data": null,
                //"defaultContent": "<button id='"+row.id+"' class='btn btn-primary btn-lg btn-block btn-view'>Ver!</button>",
                'render': function (data, type, row) {
                    return "<button id='"+row.id+"' class='btn btn-primary btn-lg btn-block btn-view'>Ver!</button>" ;
                }
            }

        ],
    });

    $('#datatable tbody').on( 'click', 'button.btn-view', function () {
        var data = table.row( $(this).parents('tr') ).data();

        //alert('DEberia cargar el form con los datos');
        var datos = {
            'action' : "show",
            'id_staff' : data.id_staff
        };

        $.ajax({
            url: '/php/abm-admins.php',//# TODO armar url
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

                var staff = data.data[0];

                // Muestro en el recuadro los resultados para debug
                var jsonResult = JSON.stringify(staff);
                $("#results").val(unescape(jsonResult));

                // Seteo los campos del formulario
                $('#id_staff').val(staff.id_staff);
                $('#nombre').val(staff.nombre);
                $('#apellido').val(staff.apellido);
                $('#tipo_doc').val(staff.tipo_doc);
                $('#documento').val(staff.documento);
                $('#email').val(staff.email);
                $('#clave_acceso').val(staff.clave_acceso);
                $('#tipo_perfil').val(staff.tipo_perfil);
                $('#id_sede').val(staff.id_sede);

                $('#staffFormContainer').toggle();
                $('#staffFormContainer').show();
                //$('#formContainer').modal('toggle');
                //$('#formContainer').modal('show');
                //$('#datatable').DataTable().ajax.reload();
            }
        })
        //document.location.href = "reserva_open.html";
    } )

    // Evento eliminar asociado a cada ROW de la tabla
    $('#datatable tbody').on( 'click', 'button.btn-cancel', function () {
        var data = table.row( $(this).parents('tr') ).data();

        var datos = { 'action' : "delete",
            'id_staff' : data.id_staff
        };

        $.ajax({
            url: '/php/abm-admins.php',//# TODO armar url
            type: 'POST',
            data: datos,
            headers: {
                //'x-auth-token': localStorage.accessToken,
                //"Authorization": "Token "+localStorage.auth_token,
                //"Content-Type": "application/json"
            },
            //dataType: 'json',
            success: function(data) {
                alert(" Eliminado administrador ");
                var jsonResult = JSON.stringify(data);
                $("#results").val(unescape(jsonResult));
                $('#datatable').DataTable().ajax.reload();
            },
            error: function(data) {
                alert(" ERROR Eliminando administrador ");
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
                localStorage.removeItem('auth_token');
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
        $('#datatable').DataTable().ajax.reload();
    });

    fillSedes('id_sede');
    fillPaises('id_pais');

});


function fillSedes(idSelect)
{
    $('#'+idSelect).empty()
    $.ajax({
        type: "POST",
        url: "/php/abm-sedes.php",
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
                $('#'+idSelect).append('<option value="' + d.id_sede + '">' + d.nombre + '</option>');
            });
        }
    });

}

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