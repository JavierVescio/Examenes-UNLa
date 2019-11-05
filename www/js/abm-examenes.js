$(document).ready(function () {
    //alert("TEST");

    // Lleno select de CURSOS
    fillCursos('id_curso');

    // Armo la DATATABLE de los examenes : peticion ajax, mapeando JSON recibido y columnas
    var table = $('#examenes-table').DataTable({
        "autoWidth": false,
        "order": [[0, "desc"]],
        "processing": true,
        "ajax": {
            "url": "/php/abm-examenes.php", //# TODO armar url
            "type": "POST",
            //"dataSrc": "data",
            "data": {
                'action': 'list'
            },
        },

        "columns": [
            {"data": "id_examen"},
            {"data": "id_curso"},
            {"data": "id_usuario_creador"},
            {"data": "fecha_creacion"},
            {"data": "cantidad_preguntas"},
            {"data": "nota_aprobacion"},
            {
                //"targets": -1,
                "data": null,
                'render': function (data, type, row) {
                    return "<button id='" + row.id + "' class='btn btn-primary btn-lg btn-block btn-cancel'>Eliminar!</button>";
                }
            },
            {
                //"targets": -1,
                "data": null,
                'render': function (data, type, row) {
                    return "<button id='" + row.id + "' class='btn btn-primary btn-lg btn-block btn-view'>Ver!</button>";
                }
            }
        ],
    });



    function ajaxCallRequest(f_method, f_url, f_data) {
        var f_contentType = 'application/x-www-form-urlencoded; charset=UTF-8';
        $.ajax({
            url: f_url,
            type: f_method,
            contentType: f_contentType,
            dataType: 'json',
            data: f_data,
            success: function (data) {
                var jsonResult = JSON.stringify(data);
                $("#results").val(unescape(jsonResult));

            },
            error: function (data) {
                var jsonResult = JSON.stringify(data);
                console.log(jsonResult)
                $("#results").val("ERROR " + jsonResult);
            }

        });
    }

    // Evento del boton de GRABAR del formulario
    $("#saveButton").click(function (event) {
        event.preventDefault();
        var form = $('#ajaxForm');
        var method = form.attr('method');
        var url = form.attr('action');
        var jsonData = $(form).serializeObject();
        console.log(jsonData);
        ajaxCallRequest(method, url, jsonData);
        $('#examenes-table').DataTable().ajax.reload();
        $('#examenModal').modal('toggle');
    });

    $("#newButton").click(function (event) {
        event.preventDefault();
        var form = $('#ajaxForm');
        form.get(0).reset();
    });
});


function fillCursos(idSelect)
{
    $('#' + idSelect).empty()
    $.ajax({
        type: "POST",
        url: "/php/abm-cursos.php",
        headers: {
            //'x-auth-token': localStorage.accessToken,
            //"Content-Type": "application/json"
        },
        dataType: 'json',
        data: {'action': 'list'},
        success: function (data) {
            data = data.data;
            console.log(data);
            $.each(data, function (i, d) {
                $('#' + idSelect).append('<option value="' + d.id_curso + '">' + d.nombre + '</option>');
            });
        }
    });

}


