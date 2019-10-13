

$(document).ready(function() {
    //alert("TEST");

    var table = $('#datatable').DataTable({
        "autoWidth": false,
        "order": [[ 0, "desc" ]],
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url":"http://royal-academy.local:81/php/abm-admins.php", //# TODO armar url
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
                    return "<button id='"+row.id+"' class='btn btn-primary btn-lg btn-block btn-cancel'>Cancelar!</button>" ;
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

        alert('DEberia cargar el form con los datos');
        var datos = { 'action' : "show",
                'id_staff' : data.id_staff
        };

        $.ajax({
            url: 'http://royal-academy.local:81/php/abm-admins.php',//# TODO armar url
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
                $('#id_staff').val(staff.id_staff);
                $('#firstname').val(staff.nombre);
                $('#lastname').val(staff.apellido);
                $('#tipo_doc').val(staff.tipo_doc);
                $('#documento').val(staff.documento);
                $('#email').val(staff.email);
                $('#password').val(staff.clave);

                //$('#datatable').DataTable().ajax.reload();
            }
        })
        //document.location.href = "reserva_open.html";
    } )

    $('#datatable tbody').on( 'click', 'button.btn-cancel', function () {
        var data = table.row( $(this).parents('tr') ).data();
        alert("Eliminando administrador ");

        var datos = new Object();
        datos.accion = "delete";
        datos.id_staff = data.codigo ;
        $.ajax({
            url: 'http://127.0.0.1:5000/ ---- ',//# TODO armar url
            type: 'PUT',
            data: JSON.stringify(datos),
            headers: {
                //'x-auth-token': localStorage.accessToken,
                //"Authorization": "Token "+localStorage.auth_token,
                "Content-Type": "application/json"
            },
            dataType: 'json',
            success: function(data) {
                alert(JSON.stringify(data));
                $('#datatable').DataTable().ajax.reload();
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
                $("#loginResults").val(unescape(jsonResult));

            },
            error: function(data) {
                var jsonResult = JSON.stringify(data);
                localStorage.removeItem('auth_token');
                $("#loginResults").val("ERROR "+ data.responseJSON.message);
            }

        });
    }

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

});

