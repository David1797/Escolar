<?php
require_once '../../../includes/conexion.php';
if(!empty(['curso'])) {
    $curso = ['curso'];
}else{
    header("Location: profesor/");
}
$idProfesor = ['profesor_id'];

$sql = "SELECT * FROM alumno_profesor as ap INNER JOIN profesor_materia as pm ON ap.pm_id = pm.pm_id INNER JOIN alumnos as a ON ap.alumno_id = a.alumno_id WHERE ap.pm_id=209 AND ap.pm_id!=208";
$query = $pdo->prepare($sql);
$query->execute();
$data = $query->fetchAll(PDO::FETCH_CLASS);

echo json_encode($data,JSON_UNESCAPED_UNICODE);
