<?php

require_once '../../../includes/conexion.php';

if($_POST) {
    $idasistencia = $_POST['idasistencia'];

    $sql = "UPDATE asistencias SET estado = 0 WHERE asistencia_id = ?";
    $query = $pdo->prepare($sql);
    $result = $query->execute(array($idasistencia));
    
    if($result) {
        $respuesta = array('status' => true,'msg' => 'Alumno eliminado correctamente');
    } else {
        $respuesta = array('status' => false,'msg' => 'Error al eliminar');
    }
    echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
}