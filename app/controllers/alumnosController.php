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

    $data =
    [
      'title'  => sprintf('Alumno #%s', $alumno['numero']),
      'slug'   => 'alumnos',
      'button' => ['url' => 'alumnos', 'text' => '<i class="fas fa-table"></i> Alumnos'],
      'grupos' => grupoModel::all(),
      'a'      => $alumno,
      'id_alumno' => $id
    ];

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

    //** Guardar data */

    echo $id;
    echo '<br>';
    echo $otroMotivo;
    echo '<br>';
 
    
   
    
   
   
   
    die;
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