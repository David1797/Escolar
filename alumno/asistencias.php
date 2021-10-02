<?php
if(!empty($_GET['curso'])) {
    $curso = $_GET['curso'];
}else{
    header("Location: profesor/");
}
    require_once 'includes/header.php';
    require_once '../includes/conexion.php';
    require_once '../includes/funciones.php';

    $alumno = $_SESSION['profesor_id'];

    $sql = "SELECT * FROM asistencias as c INNER JOIN alumnos as a ON c.alumno_id = a.alumno_id INNER JOIN tipo_asistencia as p ON c.tipo_asistencia_id = p.tipo_asistencia_id INNER JOIN profesor_materia as pm ON c.pm_id = pm.pm_id WHERE  pm.pm_id =$curso ";
    $query = $pdo->prepare($sql);
    $query->execute();
    $row = $query->rowCount();
?>

<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> Lista de Asistencias</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="#">Lista de Asistencia </a></li>
        </ul>
      </div>
      
      <div class="row">
        <?php if($row > 0 ){
          while($data = $query->fetch()){
        ?>

<div class="col-md-12">
          <div class="tile">
                  <div class="tile-title-w-btn">
                  
                    <h3 class="title"><?= $data['nombre_alumno']; ?></h3>
                        </div>
                        <div class="title-body">
                              <b>Tipo: <kbd class="bg-info"> <?= $data['alumno_asistencia']; ?> </kbd></b><br><br>
                       
                              <b>Fecha: <kbd class="bg-dark"> <?= $data['fecha']; ?> </kbd></b><br><br>
                              
                        </div>
                        
          </div>
        </div>
        <?php } } ?>
      </div>

      <div class="row">
          <a href="index.php" class="btn btn-info"><< Volver Atras</a>
      </div>
    </main>

<?php
    require_once 'includes/footer.php';
?>      