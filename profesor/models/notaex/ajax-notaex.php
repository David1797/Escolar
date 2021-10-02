<?php

require_once '../../../includes/conexion.php';

if(!empty($_POST)) {
    if(trim($_POST['note']) == '') {
        $respuestas = array('status' => false, 'msg' => 'Todos los campos son necesarios');
    } else {
        $idexentregada = $_POST['idexentregada'];
        $note = $_POST['note'];
        
                $sqlInsert = "INSERT INTO notasex (ex_entregada_id,valor_nota) VALUES (?,?)";
                $queryInsert = $pdo->prepare($sqlInsert);
                $request = $queryInsert->execute(array($idexentregada,$note));
        if($request > 0) {
                $respuestas = array('status' => true,'msg' => 'Evaluacion creada correctamente');
               }  
    }
        echo json_encode($respuestas,JSON_UNESCAPED_UNICODE);
}