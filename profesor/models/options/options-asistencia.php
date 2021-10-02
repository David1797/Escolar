<?php

require_once '../../../includes/conexion.php';

$sql = "SELECT asistencia_id,alumno_id,nombre_alumno,tipo_asistencia,fecha FROM asistencias WHERE estado = 1";
$query = $pdo->prepare($sql);
$query->execute();
$data = $query->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($data,JSON_UNESCAPED_UNICODE);