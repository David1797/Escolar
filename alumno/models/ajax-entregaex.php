<?php

require_once '../../includes/conexion.php';

if(!empty($_POST)) {
    if(trim($_POST['respuesta']) =='' ) {
        $respuesta = array('status' => false, 'msg' => 'Todos los campos son necesarios');
    } else {
        $idexamen = $_POST['idexamen'];
        $idalumno = $_POST['idalumno'];
        $respuesta = $_POST['respuesta'];
        } if ($respuesta) {
                $sqlInsert = 'INSERT INTO ex_entregadas (examen_id, alumno_id, respuesta) VALUES (?,?,?)';
                $queryInsert = $pdo->prepare($sqlInsert);
                $request = $queryInsert->execute(array($idexamen,$idalumno,$respuesta));
                
            if($request > 0) {
                    $respuesta = array('status' => true,'msg' => 'Examen enviada correctamente');
                }  
            }
        }
        echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
