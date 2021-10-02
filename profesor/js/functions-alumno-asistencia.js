$('#tableasistencia').DataTable();
var tableasistencia;

document.addEventListener('DOMContentLoaded',function(){
    var formAsistencia = document.querySelector('#formAsistencia');
    formAsistencia.onsubmit = function(e) {
        e.preventDefault();

        var idasistencia = document.querySelector('#idasistencia').value;
        var alumno = document.querySelector('#listAlumno').value ;
        var tipo_asistencia = document.querySelector('#listTipo').value;
        var fecha = document.querySelector('#fecha').value;
        var estado = document.querySelector('#listEstado').value;

        if(alumno == '' || tipo_asistencia == ''  || fecha == '' || estado == '') {
            swal('Atencion','Todos los campos son necesarios','error');
            return false;
        }

        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var url = './models/alumnos_asistencia/ajax-alumno-asistencia.php';
        var form = new FormData(formAsistencia);
        request.open('POST',url,true);
        request.send(form);
        request.onreadystatechange = function() {
            if(request.readyState == 4 && request.status == 200) {
                var data = JSON.parse(request.responseText);
                if(data.status) {
                    $('#modalAsistencia').modal('hide');
                    formAsistencia.reset();
                    swal('Asistencia',data.msg,'success');
                    tableasistencia.ajax.reload();
                } else {
                    swal('Atencion',data.msg,'error');
                }
            }
        }
    }
})

function openModalAlumnoAsistencia() {
    document.querySelector('#idasistencia').value = "";
    document.querySelector('#tituloModal').innerHTML = 'Nuevo Alumno Asistencia';
    document.querySelector('#action').innerHTML = 'Guardar';
    document.querySelector('#formAsistencia').reset();
    $('#modalAsistencia').modal('show');
}

window.addEventListener('load',function(){
    showAlumno();
    showTipo();

},false);


function showAlumno() {
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var url = './models/options/options-alumno.php';
    request.open('GET',url,true);
    request.send();
    request.onreadystatechange = function() {
        if(request.readyState == 4 && request.status == 200) {
            var data = JSON.parse(request.responseText);
            data.forEach(function(valor){
                data += '<option value="'+valor.alumno_id+'">'+valor.nombre_alumno+'='+valor.pm_id+'</option>';
                
                
            });
            document.querySelector('#listAlumno').innerHTML = data;
            document.querySelector('#idcurso').innerHTML = data;

        }
    }
}


function showTipo() {
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var url = './models/options/options-tipo.php';
    request.open('GET',url,true);
    request.send();
    request.onreadystatechange = function() {
        if(request.readyState == 4 && request.status == 200) {
            var data = JSON.parse(request.responseText);
            data.forEach(function(valor){
                data += '<option value="'+valor.tipo_asistencia_id+'">'+valor.alumno_asistencia+'</option>';
            });
            document.querySelector('#listTipo').innerHTML = data;
        }
    }
}
function editarAsistencia(id) {
    var idasistencia = id;

    document.querySelector('#tituloModal').innerHTML = 'Actualizar Asistencia';
    document.querySelector('#action').innerHTML = 'Actualizar';

    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var url = './models/alumnos_asistencia/edit-alumno_asistencia.php?id='+idasistencia;
    request.open('GET',url,true);
    request.send();
    request.onreadystatechange = function() {
            if(request.readyState == 4 && request.status == 200) {
                var data = JSON.parse(request.responseText);
                if(data.status) {
                    document.querySelector('#idasistencia').value = data.data.asistencia_id;
                    document.querySelector('#listAlumno').value = data.data.alumno;
                    document.querySelector('#listTipo').value = data.data.tipo_asistencia;
                    document.querySelector('#fecha').value = data.data.fecha;
                    document.querySelector('#listEstado').value = data.data.estado;

                    $('#modalAsistencia').modal('show');
                } else {
                    swal('Atencion',data.msg,'error');
                }
            }
        }
}

function eliminarAsistencia(id) {
    var idasistencia = id;
    swal({
        title: "Eliminar Asistencia",
        text: "Realmente desea eliminar la asistencia?",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, eliminar",
        cancelButtonText: "No, cancelar",
        closeOnConfirm: false,
        closeOnCancel: true
    },function(confirm){
        if(confirm) {
            var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            var url = './models/alumnos_asistencia/delet-alumno-asistencia.php';
            request.open('POST',url,true);
            var strData = "idasistencia="+idasistencia;
            request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function() {
                if(request.readyState == 4 && request.status == 200) {
                    var data = JSON.parse(request.responseText);
                    if(data.status) {
                        swal('Eliminar',data.msg,'success');
                        location.reload();
                    } else {
                        swal('Atencion',data.msg,'error');
                    }
                }
            }
        }
    })
}