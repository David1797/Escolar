$('#tabletipo').DataTable();
var tabletipo;

document.addEventListener('DOMContentLoaded',function(){
    tabletipo = $('#tabletipo').DataTable({
        "aProcessing": true,
        "aServerSide": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax": {
            "url": "./models/tipo/table_tipo.php",
            "dataSrc":""
        },
        "columns": [
            {"data":"acciones"},
            {"data":"tipo_asistencia_id"},
            {"data":"alumno_asistencia"},
            {"data":"estado"}
        ],
        "responsive": true,
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [[0,"asc"]]
    });

    var formTipo = document.querySelector('#formTipo');
    formTipo.onsubmit = function(e) {
        e.preventDefault();

        var idtipo = document.querySelector('#idtipo').value;
        var nombre = document.querySelector('#nombre').value;
        var estado = document.querySelector('#listEstado').value;

        if(nombre == '') {
            swal('Atencion','Todos los campos son necesarios','error');
            return false;
        }

        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var url = './models/tipo/ajax-tipo.php';
        var form = new FormData(formTipo);
        request.open('POST',url,true);
        request.send(form);
        request.onreadystatechange = function() {
            if(request.readyState == 4 && request.status == 200) {
                var data = JSON.parse(request.responseText);
                if(data.status) {
                    $('#modalTipo').modal('hide');
                    formTipo.reset();
                    swal('Tipo',data.msg,'success');
                    tabletipo.ajax.reload();
                } else {
                    swal('Atencion',data.msg,'error');
                }
            }
        }
    }
})

function openModalTipo() {
    document.querySelector('#idtipo').value = "";
    document.querySelector('#tituloModal').innerHTML = 'Nuevo Tipo';
    document.querySelector('#action').innerHTML = 'Guardar';
    document.querySelector('#formTipo').reset();
    $('#modalTipo').modal('show');
}

function editarTipo(id) {
    var idtipo = id;

    document.querySelector('#tituloModal').innerHTML = 'Actualizar Tipo de Asistencia';
    document.querySelector('#action').innerHTML = 'Actualizar';

    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var url = './models/tipo/edit-tipo.php?idtipo='+idtipo;
        request.open('GET',url,true);
        request.send();
        request.onreadystatechange = function() {
            if(request.readyState == 4 && request.status == 200) {
                var data = JSON.parse(request.responseText);
                if(data.status) {
                    document.querySelector('#idtipo').value = data.data.tipo_asistencia_id;
                    document.querySelector('#nombre').value = data.data.alumno_asistencia;
                    document.querySelector('#listEstado').value = data.data.estado;

                    $('#modalTipo').modal('show');
                } else {
                    swal('Atencion',data.msg,'error');
                }
            }
        }
}

function eliminarTipo(id) {
    var idtipo = id;

    swal({
        title: "Eliminar Tipo de Asistencia",
        text: "Realmente desea eliminar el tipo de asistencia?",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, eliminar",
        cancelButtonText: "No, cancelar",
        closeOnConfirm: false,
        closeOnCancel: true
    },function(confirm){
        if(confirm) {
            var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            var url = './models/tipo/delet-tipo.php';
            request.open('POST',url,true);
            var strData = "idtipo="+idtipo;
            request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function() {
                if(request.readyState == 4 && request.status == 200) {
                    var data = JSON.parse(request.responseText);
                    if(data.status) {
                        swal('Eliminar',data.msg,'success');
                        tabletipo.ajax.reload();
                    } else {
                        swal('Atencion',data.msg,'error');
                    }
                }
            }
        }
    })
}