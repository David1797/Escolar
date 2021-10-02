<?php

require '../../../includes/conexion.php';

if(!empty($_GET)) {
    $idasistencia = $_GET['id'];

    $sql = "SELECT * FROM asistencias WHERE asistencia_id = ?";
    $query = $pdo->prepare($sql);
    $query->execute(array($idasistencia));
    $result = $query->fetch(PDO::FETCH_ASSOC);

    if(empty($result)) {
        $respuesta = array('status' => false,'msg' => 'datos no encontrados');
    } else {
        $respuesta = array('status' => true,'data' => $result);
    }
    echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
}