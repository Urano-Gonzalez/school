<?php

/**
 * Plantilla general de controladores
 * Versión 1.0.2
 *
 * Controlador de alumnos
 */
class alumnosController extends Controller {
  private $id  = null;
  private $rol = null;

  function __construct()
  {
    // Validación de sesión de usuario, descomentar si requerida
    if (!Auth::validate()) {
      Flasher::new('Debes iniciar sesión primero.', 'danger');
      Redirect::to('login');
    }

    $this->id  = get_user('id');
    $this->rol = get_user_role();
  }
  
  function index()
  {
    if (!is_admin($this->rol)) {
      Flasher::new(get_notificaciones(), 'danger');
      Redirect::back();
    }

    $data = 
    [
      'title'   => 'Todos los Alumnos',
      'slug'    => 'alumnos',
      'button'  => ['url' => 'alumnos/agregar', 'text' => '<i class="fas fa-plus"></i> Agregar alumno'],
      'alumnos' => alumnoModel::all_paginated()
    ];
    
    // Descomentar vista si requerida
    View::render('index', $data);
  }

  function ver($id)
  {
    if (!is_admin($this->rol)) {
      Flasher::new(get_notificaciones(), 'danger');
      Redirect::back();
    }
    
    if (!$alumno = alumnoModel::by_id($id)) {
      Flasher::new('No existe el alumno en la base de datos.', 'danger');
      Redirect::back();
    }

    //** Registro INEA  */
    $sqlRegistroINEA= "SELECT * FROM registro_beneficiario WHERE id_alumno='$id'";
    $registroAlumno = Model::query($sqlRegistroINEA, [], ['transaction' => false]);
    

    if($registroAlumno == false){
      $data =
      [
        'title'  => sprintf('Alumno #%s', $alumno['numero']),
        'slug'   => 'alumnos',
        'button' => ['url' => 'alumnos', 'text' => '<i class="fas fa-table"></i> Alumnos'],
        'grupos' => grupoModel::all(),
        'a'      => $alumno,
        'id_alumno' => $id,
        'numero_zona' =>"",
        'nombre_zona' =>"",
        'fecha-registro' =>"",
        'incorporacion' =>"",
        'primer_apellido' =>"",
        'segundo_apellido' =>"",
        'nombres_inea' =>"",
        'fecha_nacimiento' =>"",
        'rfe' =>"",
        'nacionalidad' =>"",
        'entidad_nacimiento' =>"",
        'sexo' =>"",
        'estado_civil' =>"",
        'numero_hijos' =>"",
        'habla_espa' =>"",
        'habla_lengua' =>"",
        'cual_lengua' =>"",
        'otro_idioma' =>"",
        'cual_idioma' =>"",
        'se_considera_indigena' =>"",
        'se_considera_afro' =>"",
        'tipo_vialidad' =>"",
        'nombre_vialidad' =>"",
        'numero_exterior' =>"",
        'numero_interior' =>"",
        'tipo_asentamiento' =>"",
        'nombre_asentamiento' =>"",
        'tipo_entre_vialidad_1' =>"",
        'nombre_entre_vialidad_1' =>"",
        'tipo_entre_vialidad_2' =>"",
        'nombre_entre_vialidad_2' =>"",
        'cp' =>"",
        'localidad' =>"",
        'municipio' =>"",
        'entidad_federativa' =>"",
        'telefono_fijo' =>"",
        'telefono_celular' =>"",
        'equipo_computo' =>"",
        'correo_personal' =>"",
        'acceso_internet' =>"",
        'correo_inea' =>"",
        'caminar_subir_bajar' =>"",
        'oir' =>"",
        'ver' =>"",
        'banarse_vestirse_comer' =>"",
        'hablar_comunicar' =>"",
        'recordar_concentrarse' =>"",
        'condicion_mental' =>"",
        'trabajo_activo' =>"",
        'otro_empleo' =>"",
        'ocupacion' =>"",
        'nivel_ingreso' =>"",
        'sin_estudios' =>"",
        'primaria' =>"",
        'grado_primaria' =>"",
        'secundaria' =>"",
        'grado_secundaria' =>"",
        'ejercicio_ingreso' =>"",
        'motivo_estudiar' =>"",
        'otro_motivo' =>"",
        'como_se_entero' =>"",
        'como_se_entero_otro' =>"",
        'subproyecto' =>"",
        'dependencia' =>"",
        'fotografia' =>"",
        'ficha_cereso' =>"",
        'documento_equivalente' =>"",
        'certificado_primaria' =>"",
        'boleta_primaria' =>"",
        'grado_boleta_primaria' =>"",
        'boleta_secundaria' =>"",
        'grado_boleta_secundaria' =>"",
        'informe_calificaciones' =>"",
        'numero_constancias' =>"",
        'horas_capacitacion' =>"",
        'nombre_quien_cotejo' =>"",
        'fecha_cotejo' =>"",
        'unidad_operativa' =>"",
        'circulo_estudio' =>""
      ];
    }else{
      $data =
      [
        'title'  => sprintf('Alumno #%s', $alumno['numero']),
        'slug'   => 'alumnos',
        'button' => ['url' => 'alumnos', 'text' => '<i class="fas fa-table"></i> Alumnos'],
        'grupos' => grupoModel::all(),
        'a'      => $alumno,
        'id_alumno' => $id,
        'numero_zona' =>$registroAlumno[0]['numero_zona'],
        'nombre_zona' =>$registroAlumno[0]['nombre_zona'],
        'fecha_registro' =>$registroAlumno[0]['fecha_registro'],
        'incorporacion' =>$registroAlumno[0]['incorporacion'],
        'primer_apellido' =>$registroAlumno[0]['primer_apellido'],
        'segundo_apellido' =>$registroAlumno[0]['segundo_apellido'],
        'nombres_inea' =>$registroAlumno[0]['nombres'],
        'fecha_nacimiento' =>$registroAlumno[0]['fecha_nacimiento'],
        'rfe' =>$registroAlumno[0]['rfe'],
        'nacionalidad' =>$registroAlumno[0]['nacionalidad'],
        'entidad_nacimiento' =>$registroAlumno[0]['entidad_nacimiento'],
        'sexo' =>$registroAlumno[0]['sexo'],
        'estado_civil' =>$registroAlumno[0]['estado_civil'],
        'numero_hijos' =>$registroAlumno[0]['numero_hijos'],
        'habla_espa' =>$registroAlumno[0]['habla_espa'],
        'habla_lengua' =>$registroAlumno[0]['habla_lengua'],
        'cual_lengua' =>$registroAlumno[0]['cual_lengua'],
        'otro_idioma' =>$registroAlumno[0]['otro_idioma'],
        'cual_idioma' =>$registroAlumno[0]['cual_idioma'],
        'se_considera_indigena' =>$registroAlumno[0]['se_considera_indigena'],
        'se_considera_afro' =>$registroAlumno[0]['se_considera_afro'],
        'tipo_vialidad' =>$registroAlumno[0]['tipo_vialidad'],
        'nombre_vialidad' =>$registroAlumno[0]['nombre_vialidad'],
        'numero_exterior' =>$registroAlumno[0]['numero_exterior'],
        'numero_interior' =>$registroAlumno[0]['numero_interior'],
        'tipo_asentamiento' =>$registroAlumno[0]['tipo_asentamiento'],
        'nombre_asentamiento' =>$registroAlumno[0]['nombre_asentamiento'],
        'tipo_entre_vialidad_1' =>$registroAlumno[0]['tipo_entre_vialidad_1'],
        'nombre_entre_vialidad_1' =>$registroAlumno[0]['nombre_entre_vialidad_1'],
        'tipo_entre_vialidad_2' =>$registroAlumno[0]['tipo_entre_vialidad_2'],
        'nombre_entre_vialidad_2' =>$registroAlumno[0]['nombre_entre_vialidad_2'],
        'cp' =>$registroAlumno[0]['cp'],
        'localidad' =>$registroAlumno[0]['localidad'],
        'municipio' =>$registroAlumno[0]['municipio'],
        'entidad_federativa' =>$registroAlumno[0]['entidad_federativa'],
        'telefono_fijo' =>$registroAlumno[0]['telefono_fijo'],
        'telefono_celular' =>$registroAlumno[0]['telefono_celular'],
        'equipo_computo' =>$registroAlumno[0]['equipo_computo'],
        'correo_personal' =>$registroAlumno[0]['correo_personal'],
        'acceso_internet' =>$registroAlumno[0]['acceso_internet'],
        'correo_inea' =>$registroAlumno[0]['correo_inea'],
        'caminar_subir_bajar' =>$registroAlumno[0]['caminar_subir_bajar'],
        'oir' =>$registroAlumno[0]['oir'],
        'ver' =>$registroAlumno[0]['ver'],
        'banarse_vestirse_comer' =>$registroAlumno[0]['banarse_vestirse_comer'],
        'hablar_comunicar' =>$registroAlumno[0]['hablar_comunicar'],
        'recordar_concentrarse' =>$registroAlumno[0]['recordar_concentrarse'],
        'condicion_mental' =>$registroAlumno[0]['condicion_mental'],
        'trabajo_activo' =>$registroAlumno[0]['trabajo_activo'],
        'otro_empleo' =>$registroAlumno[0]['otro_empleo'],
        'ocupacion' =>$registroAlumno[0]['ocupacion'],
        'nivel_ingreso' =>$registroAlumno[0]['nivel_ingreso'],
        'sin_estudios' =>$registroAlumno[0]['sin_estudios'],
        'primaria' =>$registroAlumno[0]['primaria'],
        'grado_primaria' =>$registroAlumno[0]['grado_primaria'],
        'secundaria' =>$registroAlumno[0]['secundaria'],
        'grado_secundaria' =>$registroAlumno[0]['grado_secundaria'],
        'ejercicio_ingreso' =>$registroAlumno[0]['ejercicio_ingreso'],
        'motivo_estudiar' =>$registroAlumno[0]['motivo_estudiar'],
        'otro_motivo' =>$registroAlumno[0]['otro_motivo'],
        'como_se_entero' =>$registroAlumno[0]['como_se_entero'],
        'como_se_entero_otro' =>$registroAlumno[0]['como_se_entero_otro'],
        'subproyecto' =>$registroAlumno[0]['subproyecto'],
        'dependencia' =>$registroAlumno[0]['dependencia'],
        'fotografia' =>$registroAlumno[0]['fotografia'],
        'ficha_cereso' =>$registroAlumno[0]['ficha_cereso'],
        'documento_equivalente' =>$registroAlumno[0]['documento_equivalente'],
        'certificado_primaria' =>$registroAlumno[0]['certificado_primaria'],
        'boleta_primaria' =>$registroAlumno[0]['boleta_primaria'],
        'grado_boleta_primaria' =>$registroAlumno[0]['grado_boleta_primaria'],
        'boleta_secundaria' =>$registroAlumno[0]['boleta_secundaria'],
        'grado_boleta_secundaria' =>$registroAlumno[0]['grado_boleta_secundaria'],
        'informe_calificaciones' =>$registroAlumno[0]['informe_calificaciones'],
        'numero_constancias' =>$registroAlumno[0]['numero_constancias'],
        'horas_capacitacion' =>$registroAlumno[0]['horas_capacitacion'],
        'nombre_quien_cotejo' =>$registroAlumno[0]['nombre_quien_cotejo'],
        'fecha_cotejo' =>$registroAlumno[0]['fecha_cotejo'],
        'unidad_operativa' =>$registroAlumno[0]['unidad_operativa'],
        'circulo_estudio' =>$registroAlumno[0]['circulo_estudio']
  
      ];
    }

    

    View::render('ver', $data);
  }

  function agregar()
  {
    if (!is_admin($this->rol)) {
      Flasher::new(get_notificaciones(), 'danger');
      Redirect::back();
    }

    $data = 
    [
      'title'   => 'Agregar alumno',
      'slug'    => 'alumnos',
      'button'  => ['url' => 'alumnos', 'text' => '<i class="fas fa-table"></i> Alumnos'],
      'grupos'  => grupoModel::all()
    ];

    View::render('agregar', $data);
  }

  function post_agregar()
  {
    try {
      if (!check_posted_data(['csrf','nombres','apellidos','email','telefono','password','conf_password','id_grupo'], $_POST) || !Csrf::validate($_POST['csrf'])) {
        throw new Exception(get_notificaciones());
      }

      // Validar rol
      if (!is_admin($this->rol)) {
        throw new Exception(get_notificaciones(1));
      }

      $nombres       = clean($_POST["nombres"]);
      $apellidos     = clean($_POST["apellidos"]);
      $email         = clean($_POST["email"]);
      $telefono      = clean($_POST["telefono"]);
      $password      = clean($_POST["password"]);
      $conf_password = clean($_POST["conf_password"]);
      $id_grupo      = clean($_POST["id_grupo"]);

      // Validar que el correo sea válido
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception('Ingresa un correo electrónico válido.');
      }

      // Validar el nombre del usuario
      if (strlen($nombres) < 5) {
        throw new Exception('Ingresa un nombre válido.');
      }

      // Validar el apellido del usuario
      if (strlen($apellidos) < 5) {
        throw new Exception('Ingresa un apellido válido.');
      }

      // Validar el password del usuario
      if (strlen($password) < 5) {
        throw new Exception('Ingresa una contraseña mayor a 5 caracteres.');
      }

      // Validar ambas contraseñas
      if ($password !== $conf_password) {
        throw new Exception('Las contraseñas no son iguales.');
      }

      // Exista el id_grupo
      if ($id_grupo === '' || !grupoModel::by_id($id_grupo)) {
        throw new Exception('Selecciona un grupo válido.');
      }

      $data   =
      [
        'numero'          => rand(111111, 999999),
        'nombres'         => $nombres,
        'apellidos'       => $apellidos,
        'nombre_completo' => sprintf('%s %s', $nombres, $apellidos),
        'email'           => $email,
        'telefono'        => $telefono,
        'password'        => password_hash($password.AUTH_SALT, PASSWORD_BCRYPT),
        'hash'            => generate_token(),
        'rol'             => 'alumno',
        'status'          => 'pendiente',
        'creado'          => now()
      ];

      $data2 =
      [
        'id_alumno' => null,
        'id_grupo'  => $id_grupo
      ];

      // Insertar a la base de datos
      if (!$id = alumnoModel::add(alumnoModel::$t1, $data)) {
        throw new Exception(get_notificaciones(2));
      }

      $data2['id_alumno'] = $id;

      // Insertar a la base de datos
      if (!$id_ga = grupoModel::add(grupoModel::$t3, $data2)) {
        throw new Exception(get_notificaciones(2));
      }

      // Email de confirmación de correo
      mail_confirmar_cuenta($id);

      $alumno = alumnoModel::by_id($id);
      $grupo  = grupoModel::by_id($id_grupo);

      Flasher::new(sprintf('Alumno <b>%s</b> agregado con éxito e inscrito al grupo <b>%s</b>.', $alumno['nombre_completo'], $grupo['nombre']), 'success');
      Redirect::back();

    } catch (PDOException $e) {
      Flasher::new($e->getMessage(), 'danger');
      Redirect::back();
    } catch (Exception $e) {
      Flasher::new($e->getMessage(), 'danger');
      Redirect::back();
    }
  }

  function post_editar()
  {
    try {
      if (!check_posted_data(['csrf','id','nombres','apellidos','email','telefono','password','conf_password','id_grupo'], $_POST) || !Csrf::validate($_POST['csrf'])) {
        throw new Exception(get_notificaciones());
      }

      // Validar rol
      if (!is_admin($this->rol)) {
        throw new Exception(get_notificaciones(1));
      }

      // Validar existencia del alumno
      $id = clean($_POST["id"]);
      if (!$alumno = alumnoModel::by_id($id)) {
        throw new Exception('No existe el alumno en la base de datos.');
      }

      $db_email      = $alumno['email'];
      $db_pw         = $alumno['password'];
      $db_status     = $alumno['status'];
      $db_id_g       = $alumno['id_grupo'];

      $nombres       = clean($_POST["nombres"]);
      $apellidos     = clean($_POST["apellidos"]);
      $email         = clean($_POST["email"]);
      $telefono      = clean($_POST["telefono"]);
      $password      = clean($_POST["password"]);
      $conf_password = clean($_POST["conf_password"]);
      $id_grupo      = clean($_POST["id_grupo"]);
      $changed_email = $db_email === $email ? false : true;
      $changed_pw    = false;
      $changed_g     = $db_id_g === $id_grupo ? false : true;

      // Validar existencia del correo electrónico
      $sql = 'SELECT * FROM usuarios WHERE email = :email AND id != :id LIMIT 1';
      if (usuarioModel::query($sql, ['email' => $email, 'id' => $id])) {
        throw new Exception('El correo electrónico ya existe en la base de datos.');
      }

      // Validar que el correo sea válido
      if ($changed_email && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception('Ingresa un correo electrónico válido.');
      }

      // Validar el nombre del usuario
      if (strlen($nombres) < 5) {
        throw new Exception('Ingresa un nombre válido.');
      }

      // Validar el apellido del usuario
      if (strlen($apellidos) < 5) {
        throw new Exception('Ingresa un apellido válido.');
      }

      // Validar el password del usuario
      $pw_ok = password_verify($db_pw, $password.AUTH_SALT);
      if (!empty($password) && $pw_ok === false && strlen($password) < 5) {
        throw new Exception('Ingresa una contraseña mayor a 5 caracteres.');
      }

      // Validar ambas contraseñas
      if (!empty($password) && $pw_ok === false && $password !== $conf_password) {
        throw new Exception('Las contraseñas no son iguales.');
      }

      // Exista el id_grupo
      if ($id_grupo === '' || !grupoModel::by_id($id_grupo)) {
        throw new Exception('Selecciona un grupo válido.');
      }

      $data   =
      [
        'nombres'         => $nombres,
        'apellidos'       => $apellidos,
        'nombre_completo' => sprintf('%s %s', $nombres, $apellidos),
        'email'           => $email,
        'telefono'        => $telefono,
        'status'          => $changed_email ? 'pendiente' : $db_status
      ];

      // Actualización de contraseña
      if (!empty($password) && $pw_ok === false) {
        $data['password'] = password_hash($password.AUTH_SALT, PASSWORD_BCRYPT);
        $changed_pw       = true;
      }

      // Actualizar base de datos
      if (!alumnoModel::update(alumnoModel::$t1, ['id' => $id], $data)) {
        throw new Exception(get_notificaciones(2));
      }

      // Actualizar base de datos
      if ($changed_g) {
        if (!grupoModel::update(grupoModel::$t3, ['id_alumno' => $id], ['id_grupo' => $id_grupo])) {
          throw new Exception(get_notificaciones(2));
        }
      }

      $alumno = alumnoModel::by_id($id);
      $grupo  = grupoModel::by_id($id_grupo);
      
      Flasher::new(sprintf('Alumno <b>%s</b> actualizado con éxito.', $alumno['nombre_completo']), 'success');

      if ($changed_email) {
        mail_confirmar_cuenta($id);
        Flasher::new('El correo electrónico del alumno ha sido actualizado, debe ser confirmado.');
      }

      if ($changed_pw) {
        Flasher::new('La contraseña del alumno ha sido actualizada.');
      }

      if ($changed_g) {
        Flasher::new(sprintf('El grupo del alumno ha sido actualizado a <b>%s</b> con éxito.', $grupo['nombre']));
      }

      Redirect::back();

    } catch (PDOException $e) {
      Flasher::new($e->getMessage(), 'danger');
      Redirect::back();
    } catch (Exception $e) {
      Flasher::new($e->getMessage(), 'danger');
      Redirect::back();
    }
  }

  /** Registro INEA */

  function registroINEA()
  {
    $post = clean($_POST);
    $id = clean($_POST["id"]);
    $numero_zona = clean($_POST["numero-zona"]);
    $nombre_zona = clean($_POST["nombre-zona"]);
    $fecha_registro = clean($_POST["fecha-registro"]);
    $incorporacion = clean($_POST["check-option"]);
    // Datos generales
    $primerApellido = clean($_POST["primer-apellido"]);
    $segundoApellido = clean($_POST["segundo-apellido"]);
    $nombres = clean($_POST["nombres"]);
    $fechaNacimiento = clean($_POST["fecha-nacimiento"]);
    $rfe = clean($_POST["rfe"]);
    $nacionalidad = clean($_POST["nacionalidad"]);
    $entidadNacimiento = clean($_POST["entidad-nacimiento"]);
    $sexo = clean($_POST["check-sexo"]);
    // estado civil
    $estadoCivil = clean($_POST["check-estado-civil"]);
    $numeroHijos = clean($_POST["n-hijos"]);
    $hablaEspa = clean($_POST["hablas-espanol"]);
    $hablaLengua = clean($_POST["habla-dialecto-o-lengua"]);
    $cualLengua = clean($_POST["cual-lengua"]);
    $otroIdioma = clean($_POST["idioma-adicional"]);
    $cualIdioma = clean($_POST["cual-adicional"]);
    // cultura
    $seConsideraIndigena = clean($_POST["se-considera-indigena"]);
    $seConsideraAfro = clean($_POST["se-considera-afro"]);
    // Domicilio
    $tipoVialidad = clean($_POST["tipo-vialidad"]);
    $nombreVialidad = clean($_POST["nombre-vialidad"]);
    $numExterior = clean($_POST["num-exterior"]);
    $numInterior = clean($_POST["num-interior"]);
    // asentamiento humano
    $tipoAsentamiento = clean($_POST["tipo-asentamiento"]);
    $nombreAsentamiento = clean($_POST["nombre-asentamiento"]);
    // entre vialidades 1
    $tipoEntreVialidad1 = clean($_POST["tipo-entre-vialidad-1"]);
    $nombreEntreVialidad1 = clean($_POST["nombre-entre-vialidad-1"]);
    // entre vialidad 2
    $tipoEntreVialidad2 = clean($_POST["tipo-entre-vialidad-2"]);
    $nombreEntreVialidad2 = clean($_POST["nombre-entre-vialidad-2"]);
    $cp = clean($_POST["c-p"]);
    // localidad
    $localidad = clean($_POST["localidad"]);
    $municipio = clean($_POST["municipio"]);
    $entidadFederativa = clean($_POST["entidad-federativa"]);
    //telefonos
    $telefonoFijo = clean($_POST["telefono-fijo"]);
    $telefonoCelular = clean($_POST["telefono-celular"]);
    // equipo computo
    $equipoComputo = clean($_POST["equipo-computo"]);
    //correo personal
    $correoPersonal = clean($_POST["correo-personal"]);
    //acceso internet
    $accesoInternet = clean($_POST["acceso-internet"]);
    // correo INEA
    $correoINEA = clean($_POST["correo-inea"]);
    // Dificultades
    $caminarSubirBajar = clean($_POST["caminar-subir-bajar"]);
    $oir = clean($_POST["oir"]);
    $ver = clean($_POST["ver"]);
    $banarseVestirseComer = clean($_POST["banarse-vestirse-comer"]);
    $hablarComunicarse = clean($_POST["hablar-comunicarse"]);
    $recordarConcentrarse = clean($_POST["recordar-concentrarse"]);
    $condicionMental = clean($_POST["condicion-mental"]);
    // trabajo
    $trabajoActivo = clean($_POST["trabajo-activo"]);
    $otroEmpleo = clean($_POST["otro-empleo"]);
    // ocupacion
    $ocupacion = clean($_POST["ocupacion"]);
    // Nivel al que ingresa
    $nivelIngreso = clean($_POST["nivel-ingreso"]);
    // antecedentes escolares
    $sinEstudios = clean($_POST["sin-estudios"]);
    $primaria = clean($_POST["primaria-antecedente"]);
    $gradoPrimaria = clean($_POST["primaria-grado"]);
    $secundaria = clean($_POST["secundaria-antecedente"]);
    $gradoSecundaria = clean($_POST["grado-secundaria"]);
    //prueba
    $ejercicioIngreso = clean($_POST["check-ejercicios"]);
    // motivo para estudiar
    $motivoEstudiar = clean($_POST["motivo-estudiar"]);
    $otroMotivo = clean($_POST["otro-motivo-cual"]);
    // Como se entero
    $comoSeEntero = clean($_POST["como-se-entero"]);
    $comoSeEnteroOtro = clean($_POST["como-se-entero-otro"]);
    $subProyecto = clean($_POST["subproyecto"]);
    $dependencia = clean($_POST["dependencia"]);
    // Documentacion personal
    $fotografia = clean($_POST["fotografia"]);
    $fichaCereso = clean($_POST["ficha-cereso"]);
    $documentoEquivalente = clean($_POST["documento-legal-equivalente"]);
    // documentos probatorios
    $certificadoPrimaria = clean($_POST["certificado-primaria"]);
    $boletaPrimaria = clean($_POST["boletas-de-primaria"]);
    $gradoBoletaPrimaria = clean($_POST["grado-boleta-primaria"]);
    $boletaSecundaria = clean($_POST["boletas-de-secundaria"]);
    $gradoBoletaSecundaria = clean($_POST["grado-boleta-secundaria"]);
    $informeCalificaciones = clean($_POST["informe-calificaciones-inea"]);
    $numeroConstancias = clean($_POST["numero-constancias"]);
    $horasCapacitacion= clean($_POST["horas-capacitacion"]);
    // Documentos de cotejo
    $nombreQuienCotejo = clean($_POST["nombre-completo-cotejo"]);
    $fechaCotejo = clean($_POST["fecha-cotejo"]);
    //informacion unidad operativa
    $unidadOperativa = clean($_POST["unidad-operativa"]);
    $circuloEstudio = clean($_POST["circulo-estudio"]);

    /** Verificar si existe el reporte */
    $verificarSiExiste = "SELECT EXISTS (SELECT * FROM registro_beneficiario WHERE id_alumno='$id')";
    $statusReporte = Model::query($verificarSiExiste, [], ['transaction' => false]);
    $statusFinalINEA = $statusReporte[0]["EXISTS (SELECT * FROM registro_beneficiario WHERE id_alumno='$id')"];

    if($statusFinalINEA == 0){
      //** Guardar data */
      $sql = "INSERT INTO registro_beneficiario(id_alumno,numero_zona,nombre_zona,fecha_registro,incorporacion,primer_apellido,segundo_apellido,nombres,fecha_nacimiento,rfe,nacionalidad,entidad_nacimiento,sexo,estado_civil,numero_hijos,habla_espa,habla_lengua,cual_lengua,otro_idioma,cual_idioma,se_considera_indigena,se_considera_afro,tipo_vialidad,nombre_vialidad,numero_exterior,numero_interior,tipo_asentamiento,nombre_asentamiento,tipo_entre_vialidad_1,nombre_entre_vialidad_1,tipo_entre_vialidad_2,nombre_entre_vialidad_2,cp,localidad,municipio,entidad_federativa,telefono_fijo,telefono_celular,equipo_computo,correo_personal,acceso_internet,correo_inea,caminar_subir_bajar,oir,ver,banarse_vestirse_comer,hablar_comunicar,recordar_concentrarse,condicion_mental,trabajo_activo,otro_empleo,ocupacion,nivel_ingreso,sin_estudios,primaria,grado_primaria,secundaria,grado_secundaria,ejercicio_ingreso,motivo_estudiar,otro_motivo,como_se_entero,como_se_entero_otro,subproyecto,dependencia,fotografia,ficha_cereso,documento_equivalente,certificado_primaria,boleta_primaria,grado_boleta_primaria,boleta_secundaria,grado_boleta_secundaria,informe_calificaciones,numero_constancias,horas_capacitacion,nombre_quien_cotejo,fecha_cotejo,unidad_operativa,circulo_estudio)
      VALUES('$id','$numero_zona','$nombre_zona','$fecha_registro','$incorporacion','$primerApellido','$segundoApellido','$nombres','$fechaNacimiento','$rfe','$nacionalidad','$entidadNacimiento','$sexo','$estadoCivil','$numeroHijos','$hablaEspa','$hablaLengua','$cualLengua','$otroIdioma','$cualIdioma','$seConsideraIndigena','$seConsideraAfro','$tipoVialidad','$nombreVialidad','$numExterior','$numInterior','$tipoAsentamiento','$nombreAsentamiento','$tipoEntreVialidad1','$nombreEntreVialidad1','$tipoEntreVialidad2','$nombreEntreVialidad2','$cp','$localidad','$municipio','$entidadFederativa','$telefonoFijo','$telefonoCelular','$equipoComputo','$correoPersonal','$accesoInternet','$correoINEA','$caminarSubirBajar','$oir','$ver','$banarseVestirseComer','$hablarComunicarse','$recordarConcentrarse','$condicionMental','$trabajoActivo','$otroEmpleo','$ocupacion','$nivelIngreso','$sinEstudios','$primaria','$gradoPrimaria','$secundaria','$gradoSecundaria','$ejercicioIngreso','$motivoEstudiar','$otroMotivo','$comoSeEntero','$comoSeEnteroOtro','$subProyecto','$dependencia','$fotografia','$fichaCereso','$documentoEquivalente','$certificadoPrimaria','$boletaPrimaria','$gradoBoletaPrimaria','$boletaSecundaria','$gradoBoletaSecundaria','$informeCalificaciones','$numeroConstancias','$horasCapacitacion','$nombreQuienCotejo','$fechaCotejo','$unidadOperativa','$circuloEstudio')";
      Model::query($sql, [], ['transaction' => false]);
      Flasher::new('Registro guardado exitosamente.');
    }else{
      $actualizarINEA = "UPDATE registro_beneficiario 
      SET 
      numero_zona='$numero_zona',
      nombre_zona='$nombre_zona',
      fecha_registro='$fecha_registro',
      incorporacion='$incorporacion',
      primer_apellido='$primerApellido',
      segundo_apellido='$segundoApellido',
      nombres='$nombres',
      fecha_nacimiento='$fechaNacimiento',
      rfe='$rfe',
      nacionalidad='$nacionalidad',
      entidad_nacimiento='$entidadNacimiento',
      sexo='$sexo',
      estado_civil='$estadoCivil',
      numero_hijos='$numeroHijos',
      habla_espa='$hablaEspa',
      habla_lengua='$hablaLengua',
      cual_lengua='$cualLengua',
      otro_idioma='$otroIdioma',
      cual_idioma='$cualIdioma',
      se_considera_indigena='$seConsideraIndigena',
      se_considera_afro='$seConsideraAfro',
      tipo_vialidad='$tipoVialidad',
      nombre_vialidad='$nombreVialidad',
      numero_exterior='$numExterior',
      numero_interior='$numInterior',
      tipo_asentamiento='$tipoAsentamiento',
      nombre_asentamiento='$nombreAsentamiento',
      tipo_entre_vialidad_1='$tipoEntreVialidad1',
      nombre_entre_vialidad_1='$nombreEntreVialidad1',
      tipo_entre_vialidad_2='$tipoEntreVialidad2',
      nombre_entre_vialidad_2='$nombreEntreVialidad2',
      cp='$cp',
      localidad='$localidad',
      municipio='$municipio',
      entidad_federativa='$entidadFederativa',
      telefono_fijo='$telefonoFijo',
      telefono_celular='$telefonoCelular',
      equipo_computo='$equipoComputo',
      correo_personal='$correoPersonal',
      acceso_internet='$accesoInternet',
      correo_inea='$correoINEA',
      caminar_subir_bajar='$caminarSubirBajar',
      oir='$oir',
      ver='$ver',
      banarse_vestirse_comer='$banarseVestirseComer',
      hablar_comunicar='$hablarComunicarse',
      recordar_concentrarse='$recordarConcentrarse',
      condicion_mental='$condicionMental',
      trabajo_activo='$trabajoActivo',
      otro_empleo='$otroEmpleo',
      ocupacion='$ocupacion',
      nivel_ingreso='$nivelIngreso',
      sin_estudios='$sinEstudios',
      primaria='$primaria',
      grado_primaria='$gradoPrimaria',
      secundaria='$secundaria',
      grado_secundaria='$gradoSecundaria',
      ejercicio_ingreso='$ejercicioIngreso',
      motivo_estudiar='$motivoEstudiar',
      otro_motivo='$otroMotivo',
      como_se_entero='$comoSeEntero',
      como_se_entero_otro='$comoSeEnteroOtro',
      subproyecto='$subProyecto',
      dependencia='$dependencia',
      fotografia='$fotografia',
      ficha_cereso='$fichaCereso',
      documento_equivalente='$documentoEquivalente',
      certificado_primaria='$certificadoPrimaria',
      boleta_primaria='$boletaPrimaria',
      grado_boleta_primaria='$gradoBoletaPrimaria',
      boleta_secundaria='$boletaSecundaria',
      grado_boleta_secundaria='$gradoBoletaSecundaria',
      informe_calificaciones='$informeCalificaciones',
      numero_constancias='$numeroConstancias',
      horas_capacitacion='$horasCapacitacion',
      nombre_quien_cotejo='$nombreQuienCotejo',
      fecha_cotejo='$fechaCotejo',
      unidad_operativa='$unidadOperativa',
      circulo_estudio='$circuloEstudio' 
      WHERE id_alumno='$id'";
      Model::query($actualizarINEA, [], ['transaction' => false]);
      Flasher::new('Registro actualizado exitosamente.');

    }
    
    Redirect::back();
  }
  /** Registro INEA */
  function borrar($id)
  {
    try {
      if (!check_get_data(['_t'], $_GET) || !Csrf::validate($_GET['_t'])) {
        throw new Exception(get_notificaciones());
      }

      // Validar rol
      if (!is_admin($this->rol)) {
        throw new Exception(get_notificaciones(1));
      }

      // Exista el alumno
      if (!$alumno = alumnoModel::by_id($id)) {
        throw new Exception('No existe el alumno en la base de datos.');
      }

      // Borramos el registro y sus conexiones
      if (alumnoModel::eliminar($alumno['id']) === false) {
        throw new Exception(get_notificaciones(4));
      }

      Flasher::new(sprintf('Alumno <b>%s</b> borrado con éxito.', $alumno['nombre_completo']), 'success');
      Redirect::to('alumnos');

    } catch (PDOException $e) {
      Flasher::new($e->getMessage(), 'danger');
      Redirect::back();
    } catch (Exception $e) {
      Flasher::new($e->getMessage(), 'danger');
      Redirect::back();
    }
  }
}