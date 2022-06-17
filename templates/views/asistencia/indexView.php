<?php require_once INCLUDES.'inc_header.php'; ?>
<div class="card shadow mb-4">
    <div class="card-header py-3">
	  <h6 class="m-0 font-weight-bold text-primary"><?php echo $d->title; ?></h6>
    </div>

    <div class="card-body">
        <button class="btn btn-success" onClick="capturarAsistencia();" type="button">Capturar Asistencia</button>
        <button class="btn btn-success" onClick="consultarAsistencia();" type="button">Consultar reporte de asistencia</button>
    </div>

    <!--Vista capturar asistencia-->
    <div class="card-body " id="capturar-asistencia" style="display:none;" >
        <span>Vista Capturar asistencia</span>
        <?php if (!empty($d->id_prof)): ?>
            <div class="form-group">
                <label for="id_grupo">Selecciona tu grupo:</label>
                <select name="id_grupo" id="id_materia_profe" class="form-control">
                    <?php foreach ($d->grupos->rows as $g): ?>
                    
                      <?php echo sprintf('<option value="%s">%s</option>', $g->id, $g->nombre); ?>
                    <?php endforeach; ?>
                  </select>
            </div>
        <?php else: ?>
            <div class="form-group">
                <label for="id_grupo">Selecciona tu grupo:</label>
                <div class="alert alert-danger">No hay grupos.</div>
            </div>
        <?php endif; ?>
        <!--
        <?php //echo $d->id_prof?>
        <?php var_dump( $d->alumnos);?>
        <?php //echo "<br/>" ?>
        <?php //var_dump( $d->grupos);?>
        -->
        <div class="asistencia-div" data-id="<?php echo $d->id_prof ?>"><!-- agregar con ajax la lista de materias --></div>
        <div class="wrapper_alumnos" ><!--  agregar con ajax la lista de materias --></div>
        <br>
        <div>
        <a class="btn btn-success btn-sm" href="lecciones/agregar?hook=aprende&amp;action=doing-task&amp;id_materia=5"><i class="fas fa-plus"></i> Guardar </a>
        </div>
    </div>
    <!--Fin vista asistencia-->

    <!--Vista consultar reporte asitencia-->
    <div class="card-body" id="consultar-asistencia" style="display:none;">
        Consultar Reporte Asistencia
    </div>
    <!--Fin vista consultar reporte asistencia-->
</div>
<?php require_once INCLUDES.'inc_footer.php'; ?>