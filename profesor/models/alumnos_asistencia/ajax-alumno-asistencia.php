<?php

require_once '../../../includes/conexion.php';

if(!empty($_POST)) {
   

    if(empty($_POST['listAlumno']) || empty($_POST['listTipo'])) {
        $respuesta = array('status' => false,'msg' => 'Todos los campos son necesarios');
    } else {
        $idasistencia = $_POST['idasistencia'];
        $alumno = $_POST['listAlumno'];        
        $tipo_asistencia = $_POST['listTipo'];
        $fecha = $_POST['fecha'];
        $estado = $_POST['listEstado'];
        $idcurso = $_POST['idcurso'];


        $sql = 'SELECT * FROM asistencias WHERE pm_id=? AND fecha = ? AND tipo_asistencia_id = ? AND alumno_id = ? AND asistencia_id = ? AND estado != 0';
        $query = $pdo->prepare($sql);
        $query->execute(array($idcurso,$fecha,$tipo_asistencia,$alumno,$idasistencia));
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if($result > 0) {
            $respuesta = array('status' => false,'msg' => 'La asistencia ya existe');
        } else {
            if($idasistencia == 0) {
                $sqlInsert = 'INSERT INTO asistencias (fecha,tipo_asistencia_id,alumno_id,estado,pm_id) VALUES (?,?,?,?,?)';
                $queryInsert = $pdo->prepare($sqlInsert);
                $request = $queryInsert->execute(array($fecha,$tipo_asistencia,$alumno,$estado,$idcurso));
                $accion = 1;
            } else {
                    $sqlUpdate = 'UPDATE asistencias SET pm_id = ?,fecha = ?, tipo_asistencia_id = ?, alumno_id = ?, estado = ? WHERE asistencia_id = ?';
                    $queryUpdate = $pdo->prepare($sqlUpdate);
                    $request = $queryUpdate->execute(array($idcurso,$fecha,$tipo_asistencia,$alumno,$estado,$idasistencia));
                    $accion = 2;
            }  

            if($request > 0) {
                if($accion == 1) {
                    $respuesta = array('status' => true,'msg' => 'Asistencia creada correctamente');
                } else {
                    $respuesta = array('status' => true,'msg' => 'Asistencia actualizada correctamente');
                }
            }
        }
    }
    echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
}