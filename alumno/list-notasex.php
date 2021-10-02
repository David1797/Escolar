<?php
if(!empty($_GET['curso']) || !empty($_GET['profesor'])) {
    $curso = $_GET['curso'];
    $alumno = $_GET['profesor'];
}else{
    header("Location: alumno/");
}
    require_once 'includes/header.php';
    require_once '../includes/conexion.php';
    require_once '../includes/funcionesex.php';


    $idAlumno = $_SESSION['alumno_id'];

    $sqle = "SELECT * FROM notasex as n INNER JOIN ex_entregadas as ex_e ON n.ex_entregada_id = ex_e.ex_entregada_id INNER JOIN alumnos as al ON ex_e.alumno_id = 
    al.alumno_id INNER JOIN examen as ex ON ex_e.examen_id = ex.examen_id INNER JOIN contenidos as c ON ex.contenido_id = c.contenido_id INNER JOIN 
    profesor_materia as pm ON c.pm_id = pm.pm_id WHERE al.alumno_id = $alumno AND pm.pm_id = $curso";
    $querye = $pdo->prepare($sqle);
    $querye->execute(array($alumno,$curso));
    $rowe = $querye->rowCount();
?>
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> Notas Cargadas</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="#">Notas Cargadas</a></li>
        </ul>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
                <div class="title-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>EXAMEN</th>
                                    <th>NOTA</th>
                                </tr>
                            </thead>
                            <tbody>
                                    <?php if($rowe > 0){
                                        while($data = $querye->fetch()){
                                        ?>
                                        <tr>
                                            <td><?= $data['tema'] ?></td>
                                            <td><?= $data['valor_nota'] ?></td>
                                        </tr>
                            <?php } }?> 
                            </tbody>
                        
                        </table>
                        
                    </div>
                
                </div>
          </div>
        </div>
       
      </div>

      <div class="row">
        <div class="col-lg-12">
            <div class="bs-component">
                <ul class="list-group">
                    <li class="list-group-item"><span class="tag tag-default tag-pill float-xs-right"><strong>PROMEDIO: <?= formato(promedio($alumno)); ?></strong></span></li>
                </ul>
            </div>    
        </div>
      </div>

      <div class="row mt-3">
          <a href="notasex.php?curso=<?= $curso; ?>" class="btn btn-info"><< Volver Atras</a>
      </div>
    </main>

<?php
    require_once 'includes/footer.php';
?>