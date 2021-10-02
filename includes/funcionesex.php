<?php

$baseDir = str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
$baseUrl = 'http://' . $_SERVER['HTTP_HOST'] . $baseDir;
define('BASE_URL', $baseUrl);

function promedio($alumnos) {
    global $pdo;
    $promedio = 0;

    $sqlCantNotas = "SELECT COUNT(valor_nota) as numero FROM notasex as n INNER JOIN ex_entregadas as ex ON n.ex_entregada_id = ex.ex_entregada_id WHERE ex.alumno_id = $alumnos";
    $queryCantNotas = $pdo->prepare($sqlCantNotas);
    $queryCantNotas->execute();

    if($row = $queryCantNotas->fetch()){
        $cantNotas = $row['numero'];
    }

    $sqlNotas = "SELECT * FROM notasex as n INNER JOIN ex_entregadas as ex ON n.ex_entregada_id = ex.ex_entregada_id WHERE ex.alumno_id = $alumnos";
    $queryNotas = $pdo->prepare($sqlNotas);
    $queryNotas->execute(array($alumnos));
    $count = $queryNotas->rowCount();

    while ($row = $queryNotas->fetch()){
        $promedio = $promedio + $row['valor_nota'];
    }

    if($count > 0){
        return $promedio;
    }else{
        $promedio = 0;
    }
}

function formato($cantidad){
    $cantidad = number_format($cantidad,2,',','.');
    return $cantidad;
}
