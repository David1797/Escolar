<?php

require_once '../../../includes/conexion.php';

if(!empty($_POST)) {
    if(empty($_POST['tema']) || empty($_POST['descripcion'])) {
        $respuesta = array('status' => false, 'msg' => 'Todos los campos son necesarios');
    } else {
        $idexamen = $_POST['idexamen'];
        $idcontenido = $_POST['idcontenido'];
        $tema = $_POST['tema'];
        $descripcion = $_POST['descripcion'];
        $fecha = $_POST['fecha'];
        $valor = $_POST['valor'];

            if($idexamen == 0) {
                $sqlInsert = "INSERT INTO examen (tema,descripcion,fecha,porcentaje,contenido_id) VALUES (?,?,?,?,?)";
                $queryInsert = $pdo->prepare($sqlInsert);
                $request = $queryInsert->execute(array($tema,$descripcion,$fecha,$valor,$idcontenido));
                $accion = 1;
           } else {
                $sqlUpdate = "UPDATE examen SET tema = ?, descripcion = ?, fecha = ?, porcentaje = ?, contenido_id = ? WHERE examen_id = ?";
                $queryUpdate = $pdo->prepare($sqlUpdate);
                $request = $queryUpdate->execute(array($tema,$descripcion,$fecha,$valor,$idcontenido,$idexamen));
                $accion = 2;    
    }
        if($request > 0) {
            if($accion == 1) {
                $respuesta = array('status' => true,'msg' => 'Examen creada correctamente');
            }else {
                    $respuesta = array('status' => true,'msg' => 'Examen actualizado correctamente'); 
                }
            }  
    }
        echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
}