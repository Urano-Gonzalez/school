<?php if (!empty($d)): ?>

  <ul class="list-group">
    <?php foreach ($d as $a): ?>
      <li class="list-group-item">
        <div class="btn-group float-right">
            <input type="checkbox" name="" id="">          
        </div>
        <a href="<?php echo sprintf('alumnos/ver/%s', $a->id); ?>" target="_blank"><b><?php echo $a->nombre_completo; ?></b></a>
        <?php if ($a->status === 'suspendido'): ?>
          <br>
          <span class="badge badge-pill badge-warning text-dark d-inline-block">Suspendido</span>
        <?php endif; ?>
      </li>
    <?php endforeach; ?>
  </ul>
<?php else: ?>
  <div class="text-center py-5">
    <img src="<?php echo get_image('undraw_taken.png'); ?>" alt="No hay registros." class="img-fluid" style="width: 200px;">
    <p class="text-muted">No hay alumnos inscritos a este grupo.</p>
  </div>
<?php endif; ?>