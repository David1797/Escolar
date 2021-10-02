document.addEventListener('DOMContentLoaded',function(){
    var formNotas= document.querySelector('#formNotas');
    formNotas.onsubmit = function(e) {
        e.preventDefault();

        var idexentregada = document.querySelector('#idexentregada').value;
        var note = document.querySelector('#note').value;
        
        if(note.trim() == '' ) {
            swal('Atencion','Todos los campos son necesarios','error');
            return false;
        }

        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var url = './models/notaex/ajax-notaex.php';
        var form = new FormData(formNotas);
        request.open('POST',url,true);
        request.send(form);
        request.onreadystatechange = function() {
            if(request.readyState == 4 && request.status == 200) {
                var data = JSON.parse(request.responseText);
                if(data.status){    
                swal({
                        title:"Crear/Actualizar Nota",
                        type: "success",
                        confirmButtonText: "Aceptar",
                        closeOnConfirm: true
                    },function(confirm){
                        if(confirm){
                            $('#modalNotas').modal('hide');
                            location.reload();
                            formNota.reset();
                        }
                    })
                } else {
                    swal('Atencion',data.msg,'error');
                }
                   
            }
        }
    }
});

function ModalNotas() {
    $('#modalNotas').modal('show');
}
