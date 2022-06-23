<?php require_once INCLUDES.'inc_header.php'; ?>

<div class="row">
  <div class="col-xl-6 col-md-6 col-12">
    <!-- Collapsable Card Example -->
    <div class="card shadow mb-4">
      <!-- Card Header - Accordion -->
      <a href="#alumno_data" class="d-block card-header py-3" data-toggle="collapse"
          role="button" aria-expanded="true" aria-controls="alumno_data">
          <h6 class="m-0 font-weight-bold text-primary"><?php echo $d->title; ?></h6>
      </a>
      <!-- Card Content - Collapse -->
      <div class="collapse show" id="alumno_data">
          <div class="card-body">
            <form action="alumnos/post_editar" method="post">
              <?php echo insert_inputs(); ?>
              <input type="hidden" name="id" value="<?php echo $d->a->id; ?>" required>
              
              <div class="form-group">
                <label for="nombres">Nombre(s)</label>
                <input type="text" class="form-control" id="nombres" name="nombres" value="<?php echo $d->a->nombres; ?>" required>
              </div>

              <div class="form-group">
                <label for="apellidos">Apellido(s)</label>
                <input type="text" class="form-control" id="apellidos" name="apellidos" value="<?php echo $d->a->apellidos; ?>" required>
              </div>

              <div class="form-group">
                <label for="email">Correo electrónico</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $d->a->email; ?>" required>
              </div>

              <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo $d->a->telefono; ?>">
              </div>

              <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password">
              </div>

              <div class="form-group">
                <label for="conf_password">Confirmar contraseña</label>
                <input type="password" class="form-control" id="conf_password" name="conf_password">
              </div>

              <hr>

              <?php if (!empty($d->grupos)): ?>
                <div class="form-group">
                  <label for="id_grupo">Grupo</label>
                  <select name="id_grupo" id="id_grupo" class="form-control">
                    <?php foreach ($d->grupos as $g): ?>
                      <?php echo sprintf('<option value="%s" %s>%s</option>', $g->id, $g->id == $d->a->id_grupo ? 'selected' : null, $g->nombre); ?>
                    <?php endforeach; ?>
                  </select>
                </div>
              <?php else: ?>
                <div class="form-group">
                  <label for="id_grupo">Grupo</label>
                  <div class="alert alert-danger">No hay grupos registrados.</div>
                </div>
              <?php endif; ?>

              <button class="btn btn-success" type="submit" <?php echo empty($d->grupos) ? 'disabled' : null; ?>>Guardar cambios</button>
            </form>
          </div>
      </div>
    </div>
    <!--/ fin de primera card-->
  </div>
  
</div>
<!-- Card Form completo-->
<div class="col-xl-12 col-md-6 col-12">
    <!--Card completar data-->
    <div class="card shadow mb-4">
      <a href="#alumno_data_completa" class="d-block card-header py-3" data-toggle="collapse"
            role="button" aria-expanded="true" aria-controls="alumno_data_completa">
            <h6 class="m-0 font-weight-bold text-primary">REGISTRO DE LA PERSONA BENEFICIARIA DEL INEA</h6>
      </a> 
      <!--Contenido de card-->
      <div class="collapse show" id="alumno_data_completa">
         <div class="card-body">
          <form action="alumnos/post_completar" method="post">
            <?php echo insert_inputs(); ?>
            <input type="hidden" name="id" value="<?php echo $d->a->id; ?>" required>

            <div class="form-group">
              <label for="coordinacion-zona">Coordinación de zona</label>
              <input type="text" class="form-control" id="numero-zona" name="numero-zona" placeholder="Número de zona">
              <br>
              <input type="text" class="form-control" id="nombre-zona" name="nombre-zona" placeholder="Nombre de zona">
            </div>
            <div class="form-group">
                <label for="fecha-registro">FECHA DEL REGISTRO</label>
                <input type="date" class="form-control" id="fecha-registro" name="fecha-registro" placeholder="Fecha de registro">
            </div>
            <div class="form-group text-lg-left">
              <label for="incorporacion"><input type="radio"  name="check-option" id="incorporacion"> Incorporación</label>
              <label for="reincorporacion"><input type="radio"  name="check-option" id="reincorporacion"> Reincorporación</label>
              <label for="registro-sasa"><input type="radio"  name="check-option" id="registro-sasa"> Registro en SASA</label>
              <label for="registro-siga"><input type="radio"  name="check-option" id="registro-siga"> Registro en SIGA</label>
            </div>
            <!--Div de datos generales-->
            <div class="datos-generales">
                <div class="form-group">
                  <label for="datos-generales"><b>Datos generales:</b></label>
                </div>
                <div class="form-group">
                  <label for="apellidos">Apellidos:</label>
                  <input type="text" class="form-control" name="primer-apellido" id="primer-apellido" placeholder="Primer Apellido">
                  <br>
                  <input type="text" class="form-control" name="segundo-apellido" id="segundo-apellido" placeholder="Segundo Apellido">
                </div>
                <div class="form-group">
                  <label for="nombres">Nombre(s):</label>
                  <input type="text" class="form-control" name="nombres" id="nombres" placeholder="Nombre(s)">
                </div>
                <div class="form-group">
                  <label for="fecha-nacimiento">Fecha de Nacimiento:</label>
                  <input type="date" class="form-control" name="fecha-nacimiento" id="fecha-nacimiento">
                </div>
                <div class="form-group">
                  <label for="rfe">RFE:</label>
                  <input type="text" class="form-control" name="rfe" id="rfe" placeholder="RFE">
                </div>
                <hr>
                <div class="form-group">
                  <label for="nacionalidad">Nacionalidad:</label>
                  <input type="text" class="form-control" name="nacionalidad" id="nacionalidad" placeholder="Nacionalidad">
                </div>
                <div class="form-group">
                  <label for="entidad-nacimiento">Entidad de nacimiento:</label>
                  <input type="text" class="form-control" name="entidad-nacimiento" id="entidad-nacimiento" placeholder="Entidad de nacimiento">
                </div>
                <div class="form-group">
                  <label for="sexo">Sexo:</label>
                  <label for="hombre"><input type="radio"  name="check-sexo" id="radio-sex-hombre"> Hombre</label>
                  <label for="mujer"><input type="radio"  name="check-sexo" id="radio-sex-mujer"> Mujer</label>
                </div>
            </div>
            <!--./ Fin Div de datos generales-->
            <!--Estado civil-->
            <div class="estado-civil">
              <div class="form-group">
                <label for="estado-civil"><b>Estado civil:</b></label>
                <label for="soltero"><input type="radio"  name="check-estado-civil" id="soltero"> Soltero</label>
                <label for="soltero"><input type="radio"  name="check-estado-civil" id="soltero"> Casado</label>
                <label for="soltero"><input type="radio"  name="check-estado-civil" id="soltero"> Unión libre</label>
                <label for="soltero"><input type="radio"  name="check-estado-civil" id="soltero"> Separado</label>
                <label for="soltero"><input type="radio"  name="check-estado-civil" id="soltero"> Divorciado</label>
                <label for="soltero"><input type="radio"  name="check-estado-civil" id="soltero"> Viudo</label>
                <label for="n-hijos">Numero de hijos:</label>
                <input type="number" class="form-control" name="n-hijos" id="n-hijos" placeholder="Numero de hijos">
              </div>
            </div>
            <!--./Estado civil-->
            <!--lenguas-->
            <div class="form-group">
              <label for="hablas-espanol">Habla español? <input type="radio" name="hablas-espanol" id="hablas-espanol"></label>
              <label for="habla-dialecto-o-lengua">Habla algun dialecto o lengua indigena ? <input type="radio" name="habla-dialecto-o-lengua" id="habla-dialecto-o-lengua"></label>
              <br>
              <label for="cual">Cual?</label>
              <input type="text" class="form-control" name="cual" id="cual" >
              <br>
              <label for="habla-dialecto-o-lengua">Otro idioma adicional al español ? <input type="radio" name="idioma-adicional" id="idioma-adicional"></label>
              <br>
              <label for="cual-adicional">Cual?</label>
              <input type="text" class="form-control" name="cual-adicional" id="cual-adicional" >
            </div>
            <!--./ fin lenguas-->
            <hr>
            <!--Cultura-->
            <div class="form-group">
              <label for="se-considera-indigena">De acuerdo a su cultura, usted se considera indigena? <input type="radio" name="se-considera-indigenra" id="se-considera-indigena"></label>
              <label for="se-considera-afro">Usted se considera afromexicano(a) negro(a) o afrodescendiente? <input type="radio" name="se-considera-afro" id="se-considera-afro"></label>
            </div>
            <!-- ./cultura-->
            <!--Domicilio-->
            <div class="domicilio">
              <label for="domicilio"><b>Domicilio:</b></label>
              <div class="form-group">
                <label for="vialidad">Vialidad:</label>
                <span>(Tipo: andador, avenida, boulevard, callejón, calle, cerrada, privada, corredor, prolongación, carretera, camino, terraceria, etc)</span>
                <input type="text" class="form-control" name="tipo-vialidad" id="tipo-vialidad" placeholder="Tipo">
                <br>
                <input type="text"  class="form-control" name="nombre-vialidad" id="nombre-vialidad" placeholder="Nombre vialidad">
              </div>

              <div class="form-group">
                <label for="asentamiento-humano">Asentamiento humano:</label>
                <span>(Tipo: colonia, conjunto habitacional, ejido, ex hacienda, fraccinamiento, manzana. H., pueblo, rancho, zona militar, etc)</span>
                <input type="text" class="form-control" name="tipo-asentamiento" id="tipo-asentamiento" placeholder="Asentamiento humano">
                <input type="text" class="form-control" name="nombre-asentamiento" id="nombre-asentamiento">
              </div>
            </div>
            <!--./Fin domicilio-->
          </form>
         </div>
      </div>
      <!--./Fin Contenido de card-->
    </div>
    <!--Fin card completar-->
  </div>
  <!-- ./ fin card-->

<?php require_once INCLUDES.'inc_footer.php'; ?>