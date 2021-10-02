<?php
if(!empty($_GET['curso']) || empty($_GET['contenido'])) {
    $curso = $_GET['curso'];
    $contenido = $_GET['contenido'];
}else{
    header("Location: profesor/");
}
    require_once 'includes/header.php';
    require_once '../includes/conexion.php';
    require_once 'includes/modals/modal-examen.php';

    $idProfesor = $_SESSION['profesor_id'];

    $sql = "SELECT *,date_format(fecha, '%d/%m/%Y %H:%i') as fecha FROM examen WHERE contenido_id = $contenido";
    $query = $pdo->prepare($sql);
    $query->execute();
    $row = $query->rowCount();
?>

<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> Asignar Examen </h1>
          <button class="btn btn-success" type="button" onclick="openModalExamen()">Nuevo Examen</button>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="#">Asignar Examen</a></li>
        </ul>
      </div>
      <div class="row">
        <?php if($row > 0 ){
          while($data = $query->fetch()){
        ?>
        <div class="col-md-12">
          <div class="tile">
                  <div class="tile-title-w-btn">
                    <h3 class="title"><?= $data['tema']; ?></h3>
                       <p><button class="btn btn-info icon-btn" onclick="editarExamen(<?=$data['examen_id']; ?>)"><i class="fa fa-edit"></i>Editar Examen</button>
                            <button class="btn btn-danger icon-btn" onclick="eliminarExamen(<?=$data['examen_id']; ?>)"><i class="fa fa-delet"></i>Eliminar Examen</button> <a class="btn btn-warning icon-btn" 
                            href="entregasex.php?curso=<?= $curso; ?>&contenido=<?= $data['contenido_id']; ?>&exa=<?= $data['examen_id']; ?>"><i class="fa fa-edit"></i>Ver Entregas</a></p>
                        </div>
                        <div class="title-body">
                              <b><?= $data['descripcion']; ?> </b><br><br>
                              <b>Fecha: <kbd class="bg-info"> <?= $data['fecha']; ?> </kbd></b><br><br>
                              <b>Valor:<?= $data['porcentaje']; ?> </b>
                        </div>
          </div>
        </div>
        <?php } } ?>
      </div>

      <div class="row">
          <a href="contenido.php?curso=<?= $curso ?>" class="btn btn-info"><< Volver Atras</a>
      </div>
    </main>

<?php
    require_once 'includes/footer.php';
?>