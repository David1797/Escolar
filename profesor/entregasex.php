<?php
if(!empty($_GET['curso']) || empty($_GET['contenido']) || empty($_GET['exa'])) {
    $curso = $_GET['curso'];
    $contenido = $_GET['contenido'];
    $examen = $_GET['exa'];
} else{
    header("Location: profesor/");
}
    require_once 'includes/header.php';
    require_once '../includes/conexion.php';
    
    $idProfesor = $_SESSION['profesor_id'];

    $sql = "SELECT *,date_format(fecha, '%d/%m/%Y %H:%i') as fecha FROM examen WHERE contenido_id = $contenido AND examen_id = $examen";
    $query = $pdo->prepare($sql);
    $query->execute(); 
    $row = $query->rowCount();

    $sqla = "SELECT * FROM ex_entregadas as ex INNER JOIN alumnos as a ON ex.alumno_id = a.alumno_id INNER JOIN examen as exa ON ex.examen_id = exa.
    examen_id INNER JOIN contenidos as c ON exa.contenido_id = c.contenido_id WHERE ex.examen_id = ?";
    $querya = $pdo->prepare($sqla);
    $querya->execute(array($examen));
    $rowa = $querya->rowCount();

?>

<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> Examenes Entregados </h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="#">Examenes Entregados</a></li>
        </ul>
      </div>

      <div class="row">
        <?php if($row > 0 ){
          while($data = $query->fetch()) {
        ?>
        <div class="col-md-12">
          <div class="tile">
                  <div class="tile-title-w-btn">
                    <h3 class="title"><?= $data['tema']; ?></h3>

                  </div>
                        <div class="tile-body">
                              <b><?= $data['descripcion']; ?> </b><br><br>
                              <b>Fecha: <kbd class="bg-info"><?= $data['fecha']; ?></kbd> </b><br><br>
                              <b>Valor:<?= $data['porcentaje']; ?> </b>
                        </div>
          </div>
        </div>
        <?php } } ?>
      </div>


      <div class="row mt-2 bg-secondary text-white p-2">
        <h3>Examenes Entregados</h3>
          
      </div>

      <div class="row mt-3">
        <?php if($rowa > 0 ){
          while($data2 = $querya->fetch()) {
              $valor = '';
              $cargar2 = '';
              $alumno = $data2['alumno_id'];
              $ex_entregada = $data2['ex_entregada_id'];

              $sqln = "SELECT * FROM notasex WHERE ex_entregada_id = $ex_entregada";
              $queryn = $pdo->prepare($sqln);
              $queryn->execute();
              $datan = $queryn->rowCount();
              if($datan > 0) {
                  $valor = '<kbd class="bg-success">Calificado</kbd>';
                  $cargar2 = '';
              } else{
                require_once 'includes/modals/modal-notaex.php';
                $valor = '<kbd class="bg-danger">Sin Calificar</kbd>';
                $cargar2 = '<button class="btn btn-warning" onclick="ModalNotas()"> Cargar Notas</button>';
              }

        ?>

      <div class="col-md-12">
          <div class="tile">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                        <th>Alumno</th>
                        <th>Respuesta</th>
                        <th>Estatus</th>
                        <th>Cargar Nota</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <td><?= $data2['nombre_alumno'] ?></td>
                        <td><?= $data2['respuesta'] ?></td>

                        <td><?= $valor ?></td>
                        <td><?= $cargar2 ?></td>
                        </tr>
                    </tbody>
                </table>

              </div>
        </div>
        <?php } } ?>
      </div>
    

      <div class="row">
          <a href="examen.php?curso=<?= $curso ?>&contenido=<?= $contenido; ?>" class="btn btn-info"><< Volver Atras</a>
      </div>
    </main>

<?php
    require_once 'includes/footer.php';
?>