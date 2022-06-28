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
<div class="row">
  <div class="col-xl-12 col-md-6 col-12">
    <!--Card completar data-->
    <div class="card shadow mb-4">
      <a href="#alumno_data_completa" class="d-block card-header py-3" data-toggle="collapse"
              role="button" aria-expanded="true" aria-controls="alumno_data_completa">
              <h6 class="m-0 font-weight-bold text-primary">REGISTRO DE LA PERSONA BENEFICIARIA DEL INEA | <?php echo $d->title; ?></h6>
      </a> 
        <!--Contenido de card-->
      <div class="collapse show" id="alumno_data_completa">
          <div class="card-body">
            <form id="registro-inea" method="post">
              <?php echo insert_inputs(); ?>
              <input type="hidden" id="idBeneficiario" name="id" id="idBeneficiario" value="<?php echo $d->a->id; ?>" required>

              <div class="form-group coordinacion-zona">
                <label for="coordinacion-zona">Coordinación de Zona: </label>
                <input type="text" class="form-control col-4 " id="numero-zona" name="numero-zona" placeholder="Número de zona" require value="01">
                <br>
                <input type="text" class="form-control col-4" id="nombre-zona" name="nombre-zona" placeholder="Nombre de zona" require value="Zona 01">
              </div>
              <div class="form-group fecha-registro">
                  <label for="fecha-registro">FECHA DE REGISTRO</label>
                  <input type="date" class="form-control col-4" id="fecha-registro" name="fecha-registro" placeholder="Fecha de registro" required>
              </div>
              <div class="form-group text-lg-left">
                <label for="incorporacion"><input type="radio"  name="check-option" id="incorporacion" value="incorporacion"><b> Incorporación</b></label>
                <label for="reincorporacion"><input type="radio"  name="check-option" id="reincorporacion" value="reincorporacion"><b> Reincorporación</b></label>
                <label for="registro-sasa"><input type="radio"  name="check-option" id="registro-sasa" value="registro-sasa"><b> Registro en SASA</b></label>
                <label for="registro-siga"><input type="radio"  name="check-option" id="registro-siga" value="registro-siga"><b> Registro en SIGA</b></label>
              </div>
              <!--Div de datos generales-->
              <div class="datos-generales">
                  <div class="form-group">
                    <label for="datos-generales"><b>Datos generales:</b></label>
                  </div>
                  <div class="form-group apellidos">
                    <label for="apellidos">Apellidos:</label>
                    <input type="text" class="form-control" name="primer-apellido" id="primer-apellido" placeholder="Primer Apellido" require value="Martinez">
                    <br>
                    <input type="text" class="form-control" name="segundo-apellido" id="segundo-apellido" placeholder="Segundo Apellido" require value="Mendoza">
                  </div>
                  <div class="form-group nombre">
                    <label for="nombres">Nombre(s):</label>
                    <input type="text" class="form-control" name="nombres" id="nombres" placeholder="Nombre(s)" require value="erick santiago">
                  </div>
                  <div class="fecha-rfe">
                    <div class="form-group">
                      <label for="fecha-nacimiento">Fecha de Nacimiento:</label>
                      <input type="date" class="form-control" name="fecha-nacimiento" id="fecha-nacimiento" require>
                    </div>
                    <div class="form-group">
                      <label for="rfe">RFE:</label>
                      <input type="text" class="form-control" name="rfe" id="rfe" placeholder="RFE" require value="RGSREEAF">
                    </div>
                  </div>
                  
                  <hr>
                  <div class="nacionalidad">
                    <div class="form-group">
                      <label for="nacionalidad">Nacionalidad:</label>
                      <input type="text" class="form-control" name="nacionalidad" id="nacionalidad" placeholder="Nacionalidad" require value="Mexicano">
                    </div>
                    <div class="form-group">
                      <label for="entidad-nacimiento">Entidad de nacimiento:</label>
                      <input type="text" class="form-control" name="entidad-nacimiento" id="entidad-nacimiento" placeholder="Entidad de nacimiento" require value="coacalco">
                    </div>
                    <div class="form-group">
                      <label for="sexo">Sexo:</label>
                      <label for="radio-sex-hombre"><input type="radio"  name="check-sexo" id="radio-sex-hombre" value="Hombre"> Hombre</label>
                      <label for="radio-sex-mujer"><input type="radio"  name="check-sexo" id="radio-sex-mujer" value="Mujer"> Mujer</label>
                    </div>
                  </div>
                
              </div>
              <!--./ Fin Div de datos generales-->
              <!--Estado civil-->
              <div class="estado-civil">
                
                  <label for="estado-civil"><b>Estado civil:</b></label>
                  <label for="soltero"><input type="radio"  name="check-estado-civil" id="soltero" value="Soltero"> Soltero</label>
                  <label for="casado"><input type="radio"  name="check-estado-civil" id="casado" value="Casado"> Casado</label>
                  <label for="union-libre"><input type="radio"  name="check-estado-civil" id="union-libre" value="Casado"> Unión libre</label>
                  <label for="separado"><input type="radio"  name="check-estado-civil" id="separado" value="Casado"> Separado</label>
                  <label for="divorciado"><input type="radio"  name="check-estado-civil" id="divorciado" value="Casado"> Divorciado</label>
                  <label for="viudo"><input type="radio"  name="check-estado-civil" id="viudo" value="Casado"> Viudo</label>
                  <label for="n-hijos">Numero de hijos:<input type="number" class="form-control " name="n-hijos" id="n-hijos" placeholder="Numero de hijos" min="0"></label>
                  
                
              </div>
              <!--./Estado civil-->
              <!--lenguas-->
              <div class=" lenguas borde acomodar-horizontal">
                <label for="hablas-espanol">Habla español? <input type="radio" name="hablas-espanol" id="hablas-espanol"></label>
                <label for="habla-dialecto-o-lengua">Habla algun dialecto o lengua indigena ? <input type="radio" name="habla-dialecto-o-lengua" id="habla-dialecto-o-lengua" value="habla-lengua-indigena"></label>
                <br>
    
                <input type="text" class="form-control col-2" name="cual" id="cual-lengua" placeholder="Cual?" >
                <br>
                <label for="idioma-adicional">Otro idioma adicional al español ? <input type="radio" name="idioma-adicional" id="idioma-adicional" value="habla-otro-idioma"></label>
                <br>
              
                <input type="text" class="form-control col-2" name="cual-adicional" id="cual-adicional" placeholder="Cual?">
              </div>
              <!--./ fin lenguas-->
          
              <!--Cultura-->
              <div class="borde cultura acomodar-horizontal">
                <label for="se-considera-indigena">De acuerdo a su cultura, usted se considera indigena? <input type="radio" name="se-considera-indigena" id="se-considera-indigena" value="Se considera indigena"></label>
                <label for="se-considera-afro">Usted se considera afromexicano(a) negro(a) o afrodescendiente? <input type="radio" name="se-considera-afro" id="se-considera-afro" value="Se considera afrodescendiente"></label>
              </div>
              <!-- ./cultura-->
              <!--Domicilio-->
              <div class="domicilio borde">
                <div>
                  <label for="domicilio"><b>Domicilio:</b></label>
                  <div class="form-group acomodar-horizontal">
                    <label for="vialidad">Vialidad:</label>
                    <div class="acomodar-vertical col-4">
                      <input type="text" class="form-control" name="tipo-vialidad" id="tipo-vialidad" placeholder="Tipo" require value="privada">
                      
                    </div>
                    
                    <input type="text"  class="form-control" name="nombre-vialidad" id="nombre-vialidad" placeholder="Nombre vialidad" require value="Oyamel">
                    <input type="text"  class="form-control col-2" name="num-exterior" id="num-exterior" placeholder="Núm. Exterior" require value="127">
                    <input type="text"  class="form-control col-2" name="num-interior" id="num-interior" placeholder="Núm. Interior" require value="127">
                </div>
                <span>(Tipo: andador, avenida, boulevard, callejón, calle, cerrada, privada, corredor, prolongación, carretera, camino, terraceria, etc)</span>
                </div>
                <hr>
                <div>
                  <div class="form-group acomodar-horizontal">
                    <label for="asentamiento-humano">Asentamiento humano:</label>
                    
                    <input type="text" class="form-control col-4" name="tipo-asentamiento" id="tipo-asentamiento" placeholder="Tipo" require value="colonia">
                    <input type="text" class="form-control col-4" name="nombre-asentamiento" id="nombre-asentamiento" placeholder="Nombre" require value="hacienda2">
                    
                  </div>
                  <span>(Tipo: colonia, conjunto habitacional, ejido, ex hacienda, fraccinamiento, manzana. H., pueblo, rancho, zona militar, etc)</span>
                </div>
                <hr>
                <div class="form-group acomodar-horizontal">
                  <label for="entre-que-vialidad">Entre que vialidad: </label>
                  <input type="text" class="form-control col-4" name="tipo-entre-vialidad-1" id="tipo-entre-vialidad-1" placeholder="Tipo" require value="privada">
                  <input type="text" class="form-control col-4" name="nombre-entre-vialidad-1" id="nombre-entre-vialidad-1" placeholder="Nombre" require value="diamante">
                </div>
                <div class="form-group acomodar-horizontal">
                  <label for="entre-que-vialidad-2">Y <br> que vialidad:</label>
                  <input type="text" class="form-control" name="tipo-entre-vialidad-2" id="tipo-entre-vialidad-2" placeholder="Tipo" require value="privada">
                  <input type="text" class="form-control" name="nombre-entre-vialidad-2" id="nombre-entre-vialidad-2" placeholder="Nombre" require value="crisolita">
                  <input type="text" class="form-control" name="c-p" id="c-p" placeholder="C.P" require value="51225">
                </div>
                <hr>
                <div class="localidad acomodar-horizontal">
                  <div class="form-group">
                    <label for="localidad">Localidad:</label>
                    <input type="text" class="form-control" name="localidad" id="localidad" placeholder="Localidad" require value="hacienda">
                  </div>
                  <div class="form-group">
                    <label for="municipio">Municipio:</label>
                    <input type="text" class="form-control" name="municipio" id="municipio" placeholder="Municipio" require value="Tultepec">
                  </div>
                  <div class="form-group">
                    <label for="entidad-federativa">Entidad federativa:</label>
                    <input type="text" class="form-control" name="entidad-federativa" id="entidad-federativa" placeholder="Entidad federativa" require value="EDO.MEX">
                  </div>
                </div>
                <!--Telefonos-->
                <div class="telefonos acomodar-horizontal">
                  <div class="form-group">
                    <label for="telefono-fijo">Telefono fijo:</label>
                    <input type="tel" class="form-control" name="telefono-fijo" id="telefono-fijo" placeholder="Numero (10 digitos)" require value="5533043275">
                  </div>
                  <div class="form-group">
                    <label for="telefono-celular">Telefono celular:</label>
                    <input type="tel" class="form-control" name="telefono-celular" id="telefono-celular" placeholder="Numero (10 digitos)" require value="5533043275">
                  </div>
                </div>
                <!--./Telefonos-->
                <div class="form-group acomodar-horizontal ajustar-elementos">
                  <label for="equipo-computo">Tiene equipo de computo <input type="radio" name="equipo-computo" id="equipo-computo"></label>
                  <br>
                  <label for="correo-personal">Correo electronico personal:</label>
                  <input type="email" class="form-control col-4" name="correo-personal" id="correo-personal" require value="santiago_mendozaisc@outlook.com">
                </div>
                <div class="form-group acomodar-horizontal ajustar-elementos">
                  <label for="acceso-internet">Tiene acceso a internet <input type="radio" name="acceso-internet" id="acceso-internet"></label>
                  <br>
                  <label for="correo-inea">Correo electronico INEA:</label>
                  <input type="email" class="form-control col-4" name="correo-inea" id="correo-inea" require value="santiago@inea.com">
                </div>
                
              </div>
              <!--./Fin domicilio-->

              <!--Dificultades-->
              <div class="form-group dificultades borde">
                <label for="dificultades"><b>En su vida daria, usted tiene dificultad para:</b></label>
                
                <br>
                <div class="acomodar-horizontal radios-dificultades">
                  <label for="caminar-subir-bajar" class="col-4">Caminar, subir o bajar <input type="radio" name="caminar-subir-bajar" id="caminar-subir-bajar" value="caminar-subir-bajar"></label>
                  <label for="oir" class="col-4">Oir, aun usando aparato auditivo <input type="radio" name="oir" id="oir" value="oir"></label>

                  <label for="ver" class="col-4">Ver, aun usando lentes <input type="radio" name="ver" id="ver" value="ver"></label>

                  <label for="banarse-vestirse-comer" class="col-4">Bañarse, vestirse o comer <input type="radio" name="banarse-vestirse-comer" id="banarse-vestirse-comer" value="banarse-vestirse-comer"></label>

                  <label for="hablar-comunicarse" class="col-4">Hablar o comunicarse (por ejemplo: entender o ser entendidos por otros) <input type="radio" name="hablar-comunicarse" id="hablar-comunicarse" value="hablar-comunicarse"></label>

                  <label for="recordar-concentrarse" class="col-4">Recordar o concentrarse <input type="radio" name="recordar-concentrarse" id="recordar-concentrarse" value="recordar-concentrarse"></label>

                  <label for="condicion-mental" class="col-4">Tiene algun problema o condicion mental? (Autismo, sindrome de Down, esquizofrenia, etc) <input type="radio" name="condicion-mental" id="condicion-mental" value="condicion mental"></label>
                </div>
                <span>Nota: Se puede seleccionar mas de una opcion.</span>
                
              </div>
              <!--./Fin dificultades-->
              <!--Trabajo-->
              <div class="trabajo borde">
                <div class="form-group acomodar-horizontal trabajo-estilos">
                  <label for="trabajo-activo"><b>Tiene trabajo activo?</b></label>
                  <label for="jubilado-pensionado"><input type="radio" name="trabajo-activo" id="jubilado-pensionado" value="jubilado-pensionado"> Jubilado/Pensionado</label>

                  <label for="desempleado"><input type="radio" name="trabajo-activo" id="desempleado" value="desempleado"> Desempleado</label>

                  <label for="estudiante"><input type="radio" name="trabajo-activo" id="estudiante" value="estudiante"> Estudiante</label>

                  <input type="text" class="form-control col-4" name="otro-empleo" id="otro-empleo" placeholder="Otro">

                </div>
                <div class="form-group tipos-ocupacion acomodar-horizontal">
                  <label for="tipos-ocupacion"><b>Tipos de ocupación:</b></label>

                  <label for="trabajador-agropecuario"><input type="radio" name="trabajador-agropecuario" id="trabajador-agropecuario"> Trabajador agropecuario</label>

                  <label for="inspector-supervisor"><input type="radio" name="inspector-supervisor" id="inspector-supervisor"> Inspector o supervisor</label>

                  <label for="artesano"><input type="radio" name="artesano" id="artesano"> Artesano</label>

                  <label for="obrero"><input type="radio" name="obrero" id="obrero"> Obrero</label>

                  <label for="ayudante"><input type="radio" name="ayudante" id="ayudante"> Ayudante o similar</label>

                  <label for="empleado-gobierno"><input type="radio" name="empleado-gobierno" id="empleado-gobierno"> Empleado de gobierno</label>

                  <label for="operador"><input type="radio" name="operador" id="operador"> Operador de transporte o maquinaria en movimiento</label>

                  <label for="comerciante-vendedor"><input type="radio" name="comerciante-vendedor" id="comerciante-vendedor"> Comerciante o vendedor</label>

                  <label for="trabajador-hogar"><input type="radio" name="trabajar-hogar" id="trabajador-hogar"> Trabajador/a del hogar</label>

                  <label for="proteccion-vigilancia"><input type="radio" name="proteccion-vigilancia" id="proteccion-vigilancia"> Protección o vigilancia</label>

                  <label for="quehaceres-hogar"><input type="radio" name="quehaceres-hogar" id="quehaceres-hogar"> Quehaceres del hogar</label>

                  <label for="trabajador-ambulante"><input type="radio" name="trabajador-ambulante" id="trabajador-ambulante"> Trabajador ambulante</label>
                  
                  <label for="deportista"><input type="radio" name="deportista" id="deportista"> Deportista</label>
                </div>
              </div>
              <!--./Trabajo-->

              <!--Nivel al que ingresa-->
              <div class="nivel-ingresa borde">
                <div class="form-group">
                  <label for="nivel-al-que-ingresa"><b> Nivel al que ingresa:</b></label>
                  <label for="alfabetizacion"><input type="radio" name="nivel-ingreso" id="alfabetizacion" value="alfabetizacion"> Alfabetización</label>
                  
                  <label for="primaria"><input type="radio" name="nivel-ingreso" id="primaria" value="primaria"> Primaria</label>

                  <label for="primaria-10-14"><input type="radio" name="nivel-ingreso" id="primaria-10-14" value="primaria-10-14"> Primaria 10-14</label>

                  <label for="secundaria"><input type="radio" name="nivel-ingreso" id="secundaria" value="secundaria"> Secundaria</label>

                </div>
                <div class="form-group">
                  <label for="antecedentes-escolares"><b> Antecedentes escolares:</b></label>
                  <div class="form-group">
                    <label for="sin-estudios"><input type="radio" name="sin-estudios" id="sin-estudios" value="sin estudios"> Sin estudios</label>

                    <label for="primaria-antecedente"><input type="radio" name="primaria-antecedente" id="primaria-antecedente" value="primaria-antecedente"> Primaria</label>

                    <input type="text" name="primaria-grado" id="inputprimaria-grado"  value=""  pattern="" title="" placeholder="Grado">
                    <label for="secundaria-antecedente">
                    <input type="radio" name="secundaria-antecedente" id="secundaria-antecedente" value="secundaria"> Secundaria</label>

                    <input type="text" name="grado-secundaria" class="" id="grado-secundaria" placeholder="Grado">

                  </div>
                  <div class="form-group">
                    <label for="hispanohablante"><input type="radio" name="hispanohablante" id="hispanohablante" value="hispanohablante"> Hispanohablante</label>

                    <label for="hablante-lengua-indigena"><input type="radio" name="hablante-lengua-indigena" id="hablante-lengua-indigena"> Hablante de lengua indigena</label>

                    <label for="etnia-lengua">Etnia/Lengua</label>
                    <input type="text" name="etnia-lengua" id="etnia-lengua" placeholder="Etnia/Lengua">

                  </div>
                  <div class="form-group">
                    <label for="ejercicio-diagnostico"><input type="radio" name="check-ejercicios" id="ejercicio-diagnostico" value="ejercicio diagnostico"> Ejercicio diagnostico (alfabetización)</label>

                    <label for="examen-diagnostico"><input type="radio" name="check-ejercicios" id="examen-diagnostico" value="examen diagnostico"> Examen diagnostico</label>

                    <label for="reconocimiento-saberes"><input type="radio" name="check-ejercicios" id="reconocimiento-saberes" value="reconocimiento de saberes"> Reconocimiento de saberes</label>

                    <label for="atencion-educativa"><input type="radio" name="check-ejercicios" id="atencion-educativa" value="atencion educativa"> Atencion educativa</label>
                  </div>
                </div>
              </div>
              <!--./Fin Nivel al que ingresa-->

              <!--Motivacion a estudiar-->
              <div class="motivacion borde">
                <div class="form-group">
                  <label for="motivacion"><b>Que le motiva a estudiar?</b></label>
                  <label for="obtener-certificado-primaria-secundaria"><input type="radio" name="motivo-estudiar" id="obtener-certificado-primaria-secundaria" value="obtener certificado primaria"> Obtener el certificado de Primaria/Secundaria</label>

                  <label for="continuar-media-superior"><input type="radio" name="motivo-estudiar" id="continuar-media-superior" value="continuar media superior"> Continuar la educacion Media Superior</label>

                  <label for="obtener-empleo"><input type="radio" name="motivo-estudiar" id="obtener-empleo" value="obtener empleo"> Obtener un empleo</label>

                  <label for="condiciones-laborales"><input type="radio" name="motivo-estudiar" id="condiciones-laborales" value="mejorar empleo"> Mejorar mis condiciones laborales</label>

                  <label for="ayudar-con-tarea"><input type="radio" name="motivo-estudiar" id="ayudar-con-tarea" value="ayudar-tareas"> Ayudar a mis hijos/nietos con las tareas</label>

                  <label for="superacion-personal"><input type="radio" name="motivo-estudiar" id="superacion-personal" value="superacion-personal"> Superacion personal</label>

                  <br>
                  <label for="otro"><input type="radio" name="otroMotivo" id="otro" value="otro-motivo"> Otro</label>

                  <input type="text" class="form-control col-4" name="otro-motivo-cual" id="otro-motivo">
                </div>
              </div>
              <!--./ Fin Motivacion a estudiar-->

              <!--Como se entero--->
              <div class="como-se-entero borde">
                <div class="form-group">
                  <label for="como-se-entero"><b>Como se entero de nuestro servicio?</b></label>
                  <label for="difucion-inea"><input type="radio" name="como-se-entero" id="difucion-inea" value="difucion-inea"> Difucion del INEA</label>

                  <label for="invitacion-personal"><input type="radio" name="como-se-entero" id="invitacion-personal" value="invitacion-personal"> Invitacion personal</label>

                  <label for="como-se-entero-otro">Otro<input type="text" class="form-control" name="como-se-entero-otro" id="como-se-entero-otro"></label>
                </div>
                <div class="form-group acomodar-horizontal">
                  <label for="subproyecto"><b>Subproyecto:</b></label>
                  <input type="text" class="form-control" name="subproyecto" id="subproyecto" require>
                  <label for="dependencia"><b>Dependencia:</b></label>
                  <input type="text" class="form-control" name="dependencia" id="dependencia" require>
                </div>
              </div>
              <!--./ Fin Como se entero--->
              
              <!--Documentacion de la persona-->
              <div class="documentacion borde">
                <div class="form-group">
                  <label for="documentacion-persona"><b>Documentación de la persona beneficiaria:</b></label>
                  <br>
                  <label for="fotografia"><input type="radio" name="fotografia" id="fotografia"> Fotografia</label>

                  <label for="ficha-cereso"><input type="radio" name="ficha-cereso" id="ficha-cereso"> Ficha signaletica (CERESO)</label>

                  <label for="documento-legal-equivalente"><input type="radio" name="documento-legal-equivalente" id="documento-legal-equivalente"> Documento legal equivalente (extranjeros)</label>

                </div>
                <div class="form-group">
                  <label for="documentos-probatorios"><b>Documentos Probatorios / Constancias de capacitación</b></label>
                  <br>
                  <label for="certificado-primaria"><input type="radio" name="certificado-primaria" id="certificado-primaria" value="certificado-primaria"> Certificado de primaria</label>

                 

                  <label for="boletas-de-primaria"><input type="radio" name="boletas-de-primaria" id="boletas-de-primaria"> Boletas de primaria</label>

                  <input type="text" class="form-control col-4" name="grado-boleta-secundaria" id="grado-boleta-secundaria" placeholder="Grado">

                  <label for="boletas-de-secundaria"><input type="radio" name="boletas-de-secundaria" id="boletas-de-secundaria"> Boletas de secundaria</label>
                  <input type="text" class="form-control col-4" name="grado-boleta-secundaria" id="grado-boleta-secundaria" placeholder="Grado">
                  <br>
                  <label for="informe-calificaciones-inea"><input type="radio" name="informe-calificaciones-inea" id="informe-calificaciones-inea"> Informe de calificaciones INEA</label>
                  <label for="contanciaa-capacitacion">Constancias de Capacitacion</label>
                  <div class="horas-capacitacion">
                    <div class="form-group">
                      <label for="numero-constancias">Numero:</label>
                      <input type="text" class="form-control" name="numero-constancias" id="numero-constancias" value="5">
                    </div>
                  
                    <div class="form-group">
                      <label for="horas-capacitacion">Horas:</label>
                      <input type="text" class="form-control" name="horas-capacitacion" id="horas-capacitacion" value="25">
                    </div>
                 
                  </div>
                 
                  
                </div>


              </div>
              <!--./ FIn Documentacion de la persona-->
              
              <!--Cotejo de documentos-->
              <div class="cotejo-documentos borde">
                <div class="form-group">
                  <label for="cotejo-documentos"><b>Cotejo de Documentos impresos por la persona beneficiaria</b></label>
                </div>
                <div class="form-group">
                  <label for="nombre-completo">Nombre completo de quien cotejo los documentos</label>
                  <input type="text"  class="form-control" name="nombre-completo-cotejo" id="nombre-completo-cotejo" require value="Ivan Ovalle">
                </div>
                <div class="cotejo acomodar-horizontal">
                  <div class="form-group">
                    <label for="fecha-cotejo">Fecha de cotejo de documentos</label>
                    <input type="date" class="form-control" name="fecha-cotejo" id="fecha-cotejo" require>
                  </div>
                  <div class="form-group">
                    <label for="firma-cotejo">Firma de quien cotejo los documentos</label>
                    <input type="text" class="form-control" name="firma-cotejo" id="firma-cotejo" require>
                  </div>
                  
                </div>
                <div class="form-group">
                    <span><b>Nota: Solo se debe registrar en el SItema Informatico de Control Escolar, a la persona beneficiaria cuyos documentos impresos o digitales hayan sido cotejados</b></span>
                  </div>
              </div>
              <!--./Fin Cotejo de documentos-->

              <!--Informacion unidad operativa-->
              <div class="informacion-unidad-operativa  borde">
                <div class="form-group">
                  <label for="informacion-unidad-operativa"><b>Información de la Unidad Operativa</b></label>
                </div>
                <div class="unidad-operativa-circulo">
                  <div class="form-group acomodar-horizontal">
                    <label for="unidad-operativa"><b>Unidad operativa</b></label>
                    <input type="text" class="form-control" name="unidad-operativa" id="unidad-operativa" require value="0203udn">
                  </div>
                  <div class="form-group acomodar-horizontal">
                    <label for="circulo-estudio"><b>Circulo de estudio</b></label>
                    <input type="text" class="form-control" name="circulo-estudio" id="circulo-estudio" require value="primer circulo">
                  </div>
                </div>
                
              </div>
              <!--./Fin Informacion unidad operativa-->
              
              <!--Declaracion-->
              <div class="declaracion borde">
                <div class="form-group">
                  <label for="declaracion-nota"><b>Declaración de NO haber obtenido certificado de estudios del nivel que pretende estudiar en el INEA</b></label>
                  <p>Con fundamento en el Artículo 3 de la Constitución Política de los Estados Unidos Mexicanos, y el Artículo 247, fracción I del Código Penal Federal, bajo protesta de decir
                  verdad, manifiesto que no recibo ninguno de los apoyos señalados en las Reglas de Operación, así como no haber obtenido certificado/certificación de estudios de nivel
                  primaria y/o secundaria, según sea el caso, en alguna institución de educación. </p>
                  <p>De ser persona beneficiaria de algún apoyo del Programa Educación para Adultos (INEA) autorizo se me dé de baja del mismo.</p>
                </div>
                <div class="form-group declaracion-firmas">
                  <div class="form-group firmas">
                    <textarea name="" id="" cols="30" rows="3"></textarea><b>Nombre completo de la persona beneficiaria del INEA</b>
                  </div>
                  
                  <span>ATENTAMENTE</span>
                  <div class="form-group firmas">
                    <textarea name="" id="" cols="30" rows="3"></textarea><b>Firma de la persona beneficiaria del INEA o huella del dedo indice</b>
                  </div>
                  
                </div>
              </div>
              <!--./Declaracion-->

              <!--ultima parte-->
              <div class="parte-final borde">
                <div class="form-group fecha-p-final">
                  <label for="fecha-llenado-registro">FECHA DE LLENADO DEL REGISTRO</label>
                  <input type="date" class="form-control col-4" name="fecha-llenado-registro" id="fecha-llenado-registro">
                </div>
                <div class="form-group">
                  <p>Autorizo el uso de la información registrada en este documento, con la finalidad de generar y respaldar datos relevantes para la toma de decisiones en los procesos de
                  planificación, control escolar, evaluación educativa o de investigación</p>
                  <p>“Manifiesto bajo protesta de decir verdad que la información y los datos aquí asentados son verdaderos, que durante mi estancia en los Estados Unidos de América curse
                  (primaria y/o secundaria o equivalente), o bien que cursé en la República Mexicana algún grado de educación primaria o secundaria, sin embargo no cuento con
                  documentación alguna que lo acredite, reconozco que en caso de faltar a la verdad, estaré incurriendo en el delito de falsedad de declaración ante una autoridad pública
                  distinta de la judicial, y podría ser acreedor(a) a una pena de cuatro a ocho años de prisión y de cien a trescientos días multa (art. 247, fracción I del Código Penal Federal), y
                  demás sanciones aplicables.” </p>
                </div>
                <div class="form-group columnas-firmas">
                  <div>
                    <div class="form-group firmas">
                      <textarea name="" id="" cols="30" rows="3"></textarea>
                      <b>Nombre completo de la persona beneficiaria del INEA</b>
                    </div>
                    <div class="form-group firmas">
                      <textarea name="" id="" cols="30" rows="3"></textarea>
                      <b>Nombre completo y firma del padre o tutor En caso de inscripción al MEVyT 10-14</b>
                    </div>
                    <div class="form-group firmas">
                      <textarea name="" id="" cols="30" rows="3"></textarea>
                      <b>Nombre completo y firma de la figura que incorpora</b>
                    </div>
                    <div class="form-group firmas">
                    <textarea name="" id="" cols="30" rows="3"></textarea>
                      <b>Nombre completo y firma del Coordinador de Zona</b>
                    </div>
                  
                    
                  </div>
                  <div>
                    <div class="form-group firmas">
                      <textarea name="" id="" cols="30" rows="3"></textarea>
                      <b>Firma de la persona beneficiaria del INEA o huella del dedo índice</b>

                    </div>
                    <div class="form-group firmas">
                      <textarea name="" id="" cols="30" rows="3"></textarea>
                    <b>Nombre completo y firma del Responsable de Acreditación de la
                      Coordinación de Zona</b>
                    </div>
                    <div class="form-group firmas">
                      <textarea name="" id="" cols="30" rows="3"></textarea>
                      <b>Nombre completo y firma de la persona que capturó</b>
                    </div>
                  
                 
                  </div>
                
                </div>
                <div class="form-group" style="text-align: center;">
                  <p>Aviso de Privacidad: Los datos personales recabados serán protegidos, incorporados y tratados, según corresponda, en los sistemas institucionales del INEA que han sido
                  debidamente inscrito en el Listado de Sistemas de Datos Personales ante el Instituto Nacional de Transparencia, Acceso a la Información y Protección de Datos Personales
                  (INAI). Los datos recabados en este registro consideran lo establecido en los artículos 16, 17, 18 y 21 de la Ley General de Protección de Datos Personales en Posesión de sujetos
                  obligados.</p>
                  <p><b>Este programa es público, ajeno a cualquier partido político. Queda prohibido el uso para fines distintos a los establecidos en el programa.
                  </b></p>
                  <p><b>Si te condicionaron o pidieron algo a cambio para realizar este trámite DENÚNCIALO al 800-0060-300 o en la Coordinación de Zona, Plaza comunitaria
                  u oficina del INEA más cercana.</b></p>
                  <p ><b>Todos los servicios que proporciona el INEA son gratuitos.</b></p>
                </div>
                <div class="form-group  cupones">
                  <div class="borde-punteado cupon">
                    <span><b>Comprobante de entrega de correo electrónico a la persona beneficiaria</b></span>
                    
                    <div class="form-group">
                      <label for="nombre-beneficiario-inea">Nombre de la persona beneficiaria del INEA:</label>
                      <input type="text" class="form-control" name="nombre-beneficiario" id="nombre-beneficiario" require value="Erick Santiago">
                    </div>
                    <div class="form-group">
                      <label for="cuenta-correo">Cuenta de correo:</label>
                      <input type="text" class="form-control" name="cuenta-correo" id="cuenta-correo" require value="santiago_mendoza.com">
                    </div>
                    <div class="form-group">
                      <label for="pass">Contraseña:</label>
                      <input type="password" class="form-control" name="pass" id="pass" require value="TeHyCa420">
                    </div>
                    <div class="form-group">
                      <label for="acceso-internet"><b>Tiene acceso a Internet</b></label>
                      <label for="si">SI <input type="radio" name="accesi-inter" id="si"></label>
                      <label for="no">NO <input type="radio" name="accesi-inter" id="no"></label>
                    </div>
                    
                    
                    <p><b>Es responsabilidad total del usuario del correo, el mal uso que se pueda dar al mismo.</b></p>
                    <p><b>La asignación y uso de este correo se relaciona con el proceso educativo de la persona beneficiaria</b></p>
                    <p style="text-align: end;"><b>PERSONA BENEFICIARIA DEL INEA</b></p>
                  </div>
                  <div class="borde-punteado cupon">
                    <span><b>Comprobante de entrega de correo electrónico a la persona beneficiar</b></span>
                    <div class="form-group">
                      <label for="nombre-beneficiario-inea">Nombre de la persona beneficiaria del INEA:</label>
                      <input type="text" class="form-control" name="nombre-beneficiario" id="nombre-beneficiario" require value="Santiago mendoza">
                    </div>
                    <div class="form-group">
                      <label for="cuenta-correo">Cuenta de correo:</label>
                      <input type="text" class="form-control" name="cuenta-correo" id="cuenta-correo" require value="pedro@pedro.com">
                    </div>
                    <div class="form-group">
                      <label for="fecha">Fecha de entrega:</label>
                      <input type="date" class="form-control" name="fecha" id="fecha" require>
                    </div>
                    <div class="form-group">
                    <label for="acceso-internet"><b>Tiene acceso a Internet</b></label>
                      <label for="si">SI <input type="radio" name="accesi-inter" id="si"></label>
                      <label for="no">NO <input type="radio" name="accesi-inter" id="no"></label>
                    </div>
                    <div class="form-group">
                      <label for="firma"><b>Firma de la persona beneficiaria del INEA</b>:</label>
                      <!--firma-->
                      <!--<input type="textarea" class="form-control" name="firma" id="firma">-->
                      <textarea name="textarea" class="form-control" rows="5" cols="20">Firma</textarea>
                    </div>
                      
                      
                      
                      
                      <p style="text-align: end;"><b>IEEA-UO</b></p>
                  </div>
                </div>
              </div>
              <!--./ultima parte-->
              <br>
              <button class="btn btn-success" type="button" onClick="guardarRegistroINEA();" <?php echo empty($d->grupos) ? 'disabled' : null; ?>>Guardar cambios</button>
              <button class="btn btn-info" onClick="descargarRegistroINEA()">Descargar</button>
            </form>
          </div>
      </div>
      <div id="elementH">
        
      </div>
        <!--./Fin Contenido de card-->
    </div>
      <!--Fin card completar-->
  </div>
</div>

<!-- ./ fin card-->

<?php require_once INCLUDES.'inc_footer.php'; ?>