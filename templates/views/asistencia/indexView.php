<?php require_once INCLUDES.'inc_header.php'; ?>
<div class="card shadow mb-4">
    <div class="card-header py-3">
	  <h6 class="m-0 font-weight-bold text-primary"><?php echo $d->title; ?></h6>
    </div>

    <div class="card-body">
        <button class="btn btn-info" onClick="accionAsistencia(true);" type="button">Capturar Asistencia</button>
        <button class="btn btn-info" onClick="accionAsistencia(false);" type="button">Consultar reporte de asistencia</button>
    </div>

    <!--Vista capturar asistencia-->
    <div class="card-body " id="capturar-asistencia" style="display:none;" >
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
        <div class="boton-guardar-reporte">
            <button class="btn btn-success" onClick="guardarReporte();" type="button">Guardar asistencia</button>
        </div>
    </div>
    <!--Fin vista asistencia-->

    <!--Vista consultar reporte asitencia-->
    <div class="card-body" id="consultar-asistencia" style="display:none;">
        Consultar Reporte Asistencia
        <?php if (!empty($d->id_prof)): ?>
            <div class="form-group">
                <label for="id_grupo">Selecciona tu grupo:</label>
                <select name="id_grupo" id="id_materia_profe" class="form-control">
                    <?php foreach ($d->grupos->rows as $g): ?>
                    
                      <?php echo sprintf('<option value="%s">%s</option>', $g->id, $g->nombre); ?>
                    <?php endforeach; ?>
                  </select>
            </div>
            <div class="form-group">
                <input type="date" class="form-control">
            </div>
            <div class="form-group boton-consultar-reporte">
                <button class="btn btn-success" onClick="consultarReporte();" type="button">Consultar reporte de asistencia</button>
            </div>
        <?php else: ?>
            <div class="form-group">
                <label for="id_grupo">Selecciona tu grupo:</label>
                <div class="alert alert-danger">No hay grupos.</div>
            </div>
        <?php endif; ?>
    </div>
    <!--Fin vista consultar reporte asistencia-->
</div>
<?php require_once INCLUDES.'inc_footer.php'; ?>