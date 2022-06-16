<?php require_once INCLUDES.'inc_header.php'; ?>
<div class="card shadow mb-4">
    <div class="card-header py-3">
	  <h6 class="m-0 font-weight-bold text-primary"><?php echo $d->title; ?></h6>
    </div>
    <div class="card-body "  >
        <?php if (!empty($d->id_prof)): ?>
            <div class="form-group">
                <label for="id_grupo">Selecciona tu materia:</label>
                <select name="id_grupo" id="id_materia_profe" class="form-control">
                    <?php foreach ($d->materias as $g): ?>
                    
                      <?php echo sprintf('<option value="%s">%s</option>', $g->id, $g->nombre); ?>
                    <?php endforeach; ?>
                  </select>
            </div>
        <?php else: ?>
            <div class="form-group">
                <label for="id_grupo">Selecciona tu materia:</label>
                <div class="alert alert-danger">No hay materias registradas.</div>
            </div>
        <?php endif; ?>
        <?php echo $d->id_prof?>
        <?php var_dump( $d->materias);?>
        <div class="asistencia-div" data-id="<?php echo $d->id_prof ?>"><!-- agregar con ajax la lista de materias --></div>
       
    </div>
</div>
<?php require_once INCLUDES.'inc_footer.php'; ?>