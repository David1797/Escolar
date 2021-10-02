document.addEventListener('DOMContentLoaded',function(){
    var formExamen= document.querySelector('#formExamen');
    formExamen.onsubmit = function(e) {
        e.preventDefault();

        var idexamen = document.querySelector('#idexamen').value;
        var idcontenido = document.querySelector('#idcontenido').value;
        var tema = document.querySelector('#tema').value;
        var descripcion = document.querySelector('#descripcion').value;
        var fecha = document.querySelector('#fecha').value;
        var valor = document.querySelector('#valor').value;
        
        if(tema == '' || descripcion == ''|| fecha == ''|| valor == '') {
            swal('Atencion','Todos los campos son necesarios','error');
            return false;
        }

        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var url = './models/examen/ajax-examen.php';
        var form = new FormData(formExamen);
        request.open('POST',url,true);
        request.send(form);
        request.onreadystatechange = function() {
            if(request.readyState == 4 && request.status == 200) {
                var data = JSON.parse(request.responseText);
                    swal({
                        title:"Crear/Actualizar Examen",
                        type: "success",
                        confirmButtonText: "Aceptar",
                        closeOnConfirm: true
                    },function(confirm){
                        if(confirm){
                            if(data.status){
                                $('#modalExamen').modal('hide');
                                location.reload();
                                formExamen.reset();
                            } else {
                                swal('Atencion',data.msg,'error');
                            }
                        }
                    })
            }
        }
    }
})

function openModalExamen() {
    document.querySelector('#idexamen').value = "";
    document.querySelector('#tituloModal').innerHTML = 'Nuevo Examen';
    document.querySelector('#action').innerHTML = 'Guardar';
    document.querySelector('#formExamen').reset();
    $('#modalExamen').modal('show');
}

function editarExamen(id) {
    var idexamen = id;

    document.querySelector('#tituloModal').innerHTML = 'Actualizar Examen';
    document.querySelector('#action').innerHTML = 'Actualizar';

    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var url = './models/examen/edit-examen.php?idexamen='+idexamen;
        request.open('GET',url,true);
        request.send();
        request.onreadystatechange = function() {
            if(request.readyState == 4 && request.status == 200) {
                var data = JSON.parse(request.responseText);
                if(data.status) {
                    document.querySelector('#idexamen').value = data.data.examen_id;
                    document.querySelector('#tema').value = data.data.tema;
                    document.querySelector('#descripcion').value = data.data.descripcion;
                    document.querySelector('#fecha').value = data.data.fecha;
                    document.querySelector('#valor').value = data.data.porcentaje;

                    $('#modalExamen').modal('show');
                } else {
                    swal('Atencion',data.msg,'error');
                }
            }
        }
}

function eliminarExamen(id) {
    var idexamen = id;
    swal({
        title: "Eliminar Examen",
        text: "Realmente desea eliminar el examen?",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, eliminar",
        cancelButtonText: "No, cancelar",
        closeOnConfirm: false,
        closeOnCancel: true
    },function(confirm){
        if(confirm) {
            var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            var url = './models/examen/delet-examen.php';
            request.open('POST',url,true);
            var strData = "idexamen="+idexamen;
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
