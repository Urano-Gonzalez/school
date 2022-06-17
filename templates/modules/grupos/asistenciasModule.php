<?php if (!empty($d)): ?>

  <form id="guardar-asistencia-form" method="post" onsubmit="event.preventDefault();">

    <input type="hidden" name="campo" id="campo" value="Primer campo del form">
    <ul class="list-group" id="lista-items">
      <?php foreach ($d as $a): ?>
        <input type="hidden" name="id_user" value="<?php echo $a->id; ?>">

        <input type="hidden" id="name-<?php echo $a->id; ?>" name="nombre_usuario"  value="<?php echo $a->nombre_completo; ?>">
       


        <!--Nombre del alumno-->
        <li class="list-group-item" id="<?php echo $a->id; ?>" value="<?php echo $a->nombre_completo; ?>">
        <!--Fin nombre alumno-->

        <!--Checkbox asistencia-->
        <div class="btn-group float-right">
            <input type="checkbox" name="check_asistencia" id="check_asistencia-<?php echo $a->id; ?>" value="">          
        </div>
        <!-- Checkbox aistencia-->
          <a href="<?php echo sprintf('alumnos/ver/%s', $a->id); ?>" target="_blank" value="<?php echo $a->nombre_completo; ?>"><b><?php echo $a->nombre_completo; ?></b></a>
          <?php if ($a->status === 'suspendido'): ?>
            <br>
            <span class="badge badge-pill badge-warning text-dark d-inline-block">Suspendido</span>
          <?php endif; ?>
        </li>
      <?php endforeach; ?>
    </ul>
  </form>


  
  


<?php else: ?>
  <div class="text-center py-5">
    <img src="<?php echo get_image('undraw_taken.png'); ?>" alt="No hay registros." class="img-fluid" style="width: 200px;">
    <p class="text-muted">No hay alumnos inscritos a este grupo.</p>
  </div>
<?php endif; ?>