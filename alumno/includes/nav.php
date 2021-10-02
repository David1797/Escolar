 <?php
require_once '../includes/conexion.php';
$idAlumno = $_SESSION['alumno_id'];

$sql = "SELECT * FROM alumno_profesor as ap INNER JOIN alumnos as al ON ap.alumno_id = al.alumno_id INNER JOIN profesor_materia as pm ON ap.pm_id= pm.pm_id 
INNER JOIN grados as g ON pm.grado_id = g.grado_id INNER JOIN aulas as a ON pm.aula_id = a.aula_id INNER JOIN profesor as p ON pm.profesor_id = p.profesor_id
INNER JOIN materias as m ON pm.materia_id = m.materia_id WHERE al.alumno_id = $idAlumno";
$query = $pdo->prepare($sql);
$query->execute();
$row = $query->rowCount();

$sqln = "SELECT * FROM alumno_profesor as ap INNER JOIN alumnos as al ON ap.alumno_id = al.alumno_id INNER JOIN profesor_materia as pm ON ap.pm_id= pm.pm_id 
INNER JOIN grados as g ON pm.grado_id = g.grado_id INNER JOIN aulas as a ON pm.aula_id = a.aula_id INNER JOIN profesor as p ON pm.profesor_id = p.profesor_id
INNER JOIN materias as m ON pm.materia_id = m.materia_id WHERE al.alumno_id = $idAlumno";
$queryn = $pdo->prepare($sqln);
$queryn->execute();
$rown = $queryn->rowCount();

$sqle = "SELECT * FROM alumno_profesor as ap INNER JOIN alumnos as al ON ap.alumno_id = al.alumno_id INNER JOIN profesor_materia as pm ON ap.pm_id= pm.pm_id 
INNER JOIN grados as g ON pm.grado_id = g.grado_id INNER JOIN aulas as a ON pm.aula_id = a.aula_id INNER JOIN profesor as p ON pm.profesor_id = p.profesor_id
INNER JOIN materias as m ON pm.materia_id = m.materia_id WHERE al.alumno_id = $idAlumno";
$querye = $pdo->prepare($sqle);
$querye->execute();
$rowe = $querye->rowCount();


$sqlm = "SELECT * FROM alumno_profesor as ap INNER JOIN alumnos as al ON ap.alumno_id = al.alumno_id INNER JOIN profesor_materia as pm ON ap.pm_id= pm.pm_id 
INNER JOIN grados as g ON pm.grado_id = g.grado_id INNER JOIN aulas as a ON pm.aula_id = a.aula_id INNER JOIN profesor as p ON pm.profesor_id = p.profesor_id
INNER JOIN materias as m ON pm.materia_id = m.materia_id WHERE al.alumno_id = $idAlumno";
$querym = $pdo->prepare($sqlm);
$querym->execute();
$rowm = $querym->rowCount();



?>
 <!-- Sidebar menu-->
 <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
      <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="images/user.png" alt="User Image">
        <div>
          <p class="app-sidebar__user-name"><?= $_SESSION['nombre']; ?></p>
          <p class="app-sidebar__user-designation">Alumno</p>
        </div>
      </div>
      <ul class="app-menu"><!--Icons del menu-->
      <li><a class="app-menu__item" href="../index.php"><i class="app-menu__icon fas fa-home"></i><span class="app-menu__label">Inicio</span></a>
          </li>
        <li class="treeview">
          <a class="app-menu__item" href="#" data-toggle="treeview" >
            <i class="app-menu_icon fa fa-th-large"></i>
            <span class="app-menu_label">MIS CURSOS</span>
            <i class="treeview-indicator fa fa-angle-right"></i>
          </a>
        <ul class="treeview-menu">
          <?php if($row > 0 ){
                while($data = $query->fetch()){
          ?>
            <li><a class="treeview-item" href="contenido.php?curso=<?=$data['pm_id'] ?>"><i class="icon fa fa-circle-o"></i><?=$data
            ['nombre_materia']; ?> - <?= $data['nombre_grado']; ?> - <?=$data['nombre_aula']; ?></a></li>    
          <?php } } ?>
        </ul>
        </li>
        <li class="treeview">
          <a class="app-menu__item" href="#" data-toggle="treeview" >
            <i class="app-menu_icon fa fa-tasks"></i>
            <span class="app-menu_label">CALIFICACIÓN TAREAS</span>
            <i class="treeview-indicator fa fa-angle-right"></i>
          </a>
        <ul class="treeview-menu">
          <?php if($rown > 0 ){
                while($datan = $queryn->fetch()){
          ?>
            <li><a class="treeview-item" href="notas.php?curso=<?=$datan['pm_id'] ?>"><i class="icon fa fa-circle-o"></i><?=$datan
            ['nombre_materia']; ?> - <?= $datan['nombre_grado']; ?> - <?=$datan['nombre_aula']; ?></a></li>    
          <?php } } ?>
        </ul>
        </li>

        <li class="treeview">
          <a class="app-menu__item" href="#" data-toggle="treeview" >
            <i class="app-menu_icon fa fa-tasks"></i>
            <span class="app-menu_label">CALIFICACIÓN EXAMEN</span>
            <i class="treeview-indicator fa fa-angle-right"></i>
          </a>
        <ul class="treeview-menu">
          <?php if($rowe > 0 ){
                while($datae = $querye->fetch()){
          ?>
            <li><a class="treeview-item" href="notasex.php?curso=<?=$datae['pm_id'] ?>"><i class="icon fa fa-circle-o"></i><?= $datae['nombre_materia']; ?> - <?= $datae['nombre_grado']; ?> - <?= $datae['nombre_aula']; ?></a></li>    
          <?php } } ?>
        </ul>
        </li>

        <li class="treeview">
          <a class="app-menu__item" href="#" data-toggle="treeview" >
            <i class="app-menu_icon fa fa-check"></i>
            <span class="app-menu_label">ASISTENCIA</span>
            <i class="treeview-indicator fa fa-angle-right"></i>
          </a>
          <ul class="treeview-menu">
          <?php if($rowm > 0 ){
                while($datam = $querym->fetch()){
          ?>
          <li><a class="treeview-item" href="asistencias.php?curso=<?=$datam['pm_id'] ?>"><i class="icon fa fa-circle-o"></i><?= $datam['nombre_materia']; ?> - <?= $datam['nombre_grado']; ?> - <?= $datam['nombre_aula']; ?></a></li>
          <?php } } ?>
        </ul>
        </li>



          <li><a class="app-menu__item" href="../logout.php"><i class="app-menu__icon fas fa-sign-out-alt"></i><span class="app-menu__label">Salir</span></a>
          </li>
      </ul>
    </aside>