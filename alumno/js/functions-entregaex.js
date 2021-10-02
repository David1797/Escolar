document.addEventListener('DOMContentLoaded',function(){
    var formEntregaex= document.querySelector('#formEntregaex');
    formEntregaex.onsubmit = function(e) {
        e.preventDefault();

        var respuesta = document.querySelector('#respuesta').value;
        
        if(respuesta.trim() == '' ) {
            swal('Atencion','Todos los campos son necesarios','error');
            return false;
        }

        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var url = './models/ajax-entregaex.php';
        var form = new FormData(formEntregaex);
        request.open('POST',url,true);
        request.send(form);
        request.onreadystatechange = function() {
            if(request.readyState == 4 && request.status == 200) {
                var data = JSON.parse(request.responseText);
                if(data.status){    
                swal({
                        title:"Crear Entrega",
                        text: data.msg,
                        type: "success",
                        confirmButtonText: "Aceptar",
                        closeOnConfirm: true
                    },function(confirm){
                        if(confirm){
                            location.reload();
                            formEntregaex.reset();
                        }
                    })
                } else {
                    swal('Atencion',data.msg,'error');
                }                 
            }
        }
    }
});
