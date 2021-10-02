<?php

require_once '../../../includes/conexion.php';

if($_POST) {
    $idexamen = $_POST['idexamen'];
 
        $sql_update = "DELETE FROM examen WHERE examen_id = ?";
        $query_update = $pdo->prepare($sql_update);
        $result = $query_update->execute(array($idexamen));
        if($result) {     
            $arrResponse = array('status' => true,'msg' => 'Examen eliminado correctamente');
        }else {
                $arrResponse = array('status' => false,'msg' => 'Error al eliminar'); 
            }

    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
   }
 