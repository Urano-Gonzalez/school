$(document).ready(function() {

  // Toast para notificaciones
  //toastr.warning('My name is Inigo Montoya. You killed my father, prepare to die!');

  // Waitme
  //$('body').waitMe({effect : 'orbit'});
  console.log('////////// Bienvenido a Bee Framework Versión ' + Bee.bee_version + ' //////////');
  console.log('//////////////////// www.joystick.com.mx ////////////////////');
  console.log(Bee);

  /**
   * Prueba de peticiones ajax al backend en versión 1.1.3
   */
  function test_ajax() {
    var body = $('body'),
    hook     = 'bee_hook',
    action   = 'post',
    csrf     = Bee.csrf;

    if ($('#test_ajax').length == 0) return;

    $.ajax({
      url: 'ajax/test',
      type: 'post',
      dataType: 'json',
      data : { hook , action , csrf },
      beforeSend: function() {
        body.waitMe();
      }
    }).done(function(res) {
      toastr.success(res.msg);
      console.log(res);
    }).fail(function(err) {
      toastr.error('Prueba AJAX fallida.', '¡Upss!');
    }).always(function() {
      body.waitMe('hide');
    })
  }
  
  /**
   * Alerta para confirmar una acción establecida en un link o ruta específica
   */
  $('body').on('click', '.confirmar', function(e) {
    e.preventDefault();

    let url = $(this).attr('href'),
    ok      = confirm('¿Estás seguro?');

    // Redirección a la URL del enlace
    if (ok) {
      window.location = url;
      return true;
    }
    
    console.log('Acción cancelada.');
    return true;
  });

  /**
   * Inicializa summernote el editor de texto avanzado para textareas
   */
  function init_summernote() {
    if ($('.summernote').length == 0) return;

    $('.summernote').summernote({
      placeholder: 'Escribe en este campo...',
      tabsize: 2,
      height: 300
    });
  }

  /**
   * Inicializa tooltips en todo el sitio
   */
  function init_tooltips() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    });
  }
  
  // Inicialización de elementos
  init_summernote();
  init_tooltips();
  test_ajax();
  $('#dataTable').DataTable(
    {
      language: {
        search:         "Buscar&nbsp;:",
        lengthMenu:     "Mostrar _MENU_ registros",
        info:           "Mostrando _START_ a _END_ de _TOTAL_ registros.",
        infoEmpty:      "Mostrando 0 registros.",
        infoFiltered:   "(Filtrando de _MAX_ registros en total)",
        infoPostFix:    "",
        zeroRecords:    "No hay registros encontrados.",
        emptyTable:     "No hay información.",
        paginate: {
          first:      "Primera",
          previous:   "Anterior",
          next:       "Siguiente",
          last:       "Última"
        }
      },
      paging: false,
      aaSorting: []
    }
  );

  ////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////
  ///////// NO REQUERIDOS, SOLO PARA EL PROYECTO DEMO DE GASTOS E INGRESOS
  ////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////
  
  // Agregar un movimiento
  $('.bee_add_movement').on('submit', bee_add_movement);
  function bee_add_movement(event) {
    event.preventDefault();

    var form    = $('.bee_add_movement'),
    hook        = 'bee_hook',
    action      = 'add',
    data        = new FormData(form.get(0)),
    type        = $('#type').val(),
    description = $('#description').val(),
    amount      = $('#amount').val();
    data.append('hook', hook);
    data.append('action', action);

    // Validar que este seleccionada una opción type
    if(type === 'none') {
      toastr.error('Selecciona un tipo de movimiento válido', '¡Upss!');
      return;
    }

    // Validar description
    if(description === '' || description.length < 5) {
      toastr.error('Ingresa una descripción válida', '¡Upss!');
      return;
    }

    // Validar amount
    if(amount === '' || amount <= 0) {
      toastr.error('Ingresa un monto válido', '¡Upss!');
      return;
    }

    // AJAX
    $.ajax({
      url: 'ajax/bee_add_movement',
      type: 'post',
      dataType: 'json',
      contentType: false,
      processData: false,
      cache: false,
      data : data,
      beforeSend: function() {
        form.waitMe();
      }
    }).done(function(res) {
      if(res.status === 201) {
        toastr.success(res.msg, '¡Bien!');
        form.trigger('reset');
        bee_get_movements();
      } else {
        toastr.error(res.msg, '¡Upss!');
      }
    }).fail(function(err) {
      toastr.error('Hubo un error en la petición', '¡Upss!');
    }).always(function() {
      form.waitMe('hide');
    })
  }

  // Cargar movimientos
  bee_get_movements();
  function bee_get_movements() {
    var wrapper = $('.bee_wrapper_movements'),
    hook        = 'bee_hook',
    action      = 'load';

    if (wrapper.length === 0) {
      return;
    }

    $.ajax({
      url: 'ajax/bee_get_movements',
      type: 'POST',
      dataType: 'json',
      cache: false,
      data: {
        hook, action
      },
      beforeSend: function() {
        wrapper.waitMe();
      }
    }).done(function(res) {
      if(res.status === 200) {
        wrapper.html(res.data);
      } else {
        toastr.error(res.msg, '¡Upss!');
        wrapper.html('');
      }
    }).fail(function(err) {
      toastr.error('Hubo un error en la petición', '¡Upss!');
      wrapper.html('');
    }).always(function() {
      wrapper.waitMe('hide');
    })
  }

  // Actualizar un movimiento
  $('body').on('dblclick', '.bee_movement', bee_update_movement);
  function bee_update_movement(event) {
    var li              = $(this),
    id                  = li.data('id'),
    hook                = 'bee_hook',
    action              = 'get',
    add_form            = $('.bee_add_movement'),
    wrapper_update_form = $('.bee_wrapper_update_form');

    // AJAX
    $.ajax({
      url: 'ajax/bee_update_movement',
      type: 'POST',
      dataType: 'json',
      cache: false,
      data: {
        hook, action, id
      },
      beforeSend: function() {
        wrapper_update_form.waitMe();
      }
    }).done(function(res) {
      if(res.status === 200) {
        wrapper_update_form.html(res.data);
        add_form.hide();
      } else {
        toastr.error(res.msg, '¡Upss!');
      }
    }).fail(function(err) {
      toastr.error('Hubo un error en la petición', '¡Upss!');
    }).always(function() {
      wrapper_update_form.waitMe('hide');
    })
  }

  $('body').on('submit', '.bee_save_movement', bee_save_movement);
  function bee_save_movement(event) {
    event.preventDefault();

    var form    = $('.bee_save_movement'),
    hook        = 'bee_hook',
    action      = 'update',
    data        = new FormData(form.get(0)),
    type        = $('select[name="type"]', form).val(),
    description = $('input[name="description"]', form).val(),
    amount      = $('input[name="amount"]', form).val(),
    add_form            = $('.bee_add_movement');
    data.append('hook', hook);
    data.append('action', action);

    // Validar que este seleccionada una opción type
    if(type === 'none') {
      toastr.error('Selecciona un tipo de movimiento válido', '¡Upss!');
      return;
    }

    // Validar description
    if(description === '' || description.length < 5) {
      toastr.error('Ingresa una descripción válida', '¡Upss!');
      return;
    }

    // Validar amount
    if(amount === '' || amount <= 0) {
      toastr.error('Ingresa un monto válido', '¡Upss!');
      return;
    }

    // AJAX
    $.ajax({
      url: 'ajax/bee_save_movement',
      type: 'post',
      dataType: 'json',
      contentType: false,
      processData: false,
      cache: false,
      data : data,
      beforeSend: function() {
        form.waitMe();
      }
    }).done(function(res) {
      if(res.status === 200) {
        toastr.success(res.msg, '¡Bien!');
        form.trigger('reset');
        form.remove();
        add_form.show();
        bee_get_movements();
      } else {
        toastr.error(res.msg, '¡Upss!');
      }
    }).fail(function(err) {
      toastr.error('Hubo un error en la petición', '¡Upss!');
    }).always(function() {
      form.waitMe('hide');
    })
  }

  // Borrar un movimiento
  $('body').on('click', '.bee_delete_movement', bee_delete_movement);
  function bee_delete_movement(event) {
    var boton   = $(this),
    id          = boton.data('id'),
    hook        = 'bee_hook',
    action      = 'delete',
    wrapper     = $('.bee_wrapper_movements');

    if(!confirm('¿Estás seguro?')) return false;

    $.ajax({
      url: 'ajax/bee_delete_movement',
      type: 'POST',
      dataType: 'json',
      cache: false,
      data: {
        hook, action, id
      },
      beforeSend: function() {
        wrapper.waitMe();
      }
    }).done(function(res) {
      if(res.status === 200) {
        toastr.success(res.msg, 'Bien!');
        bee_get_movements();
      } else {
        toastr.error(res.msg, '¡Upss!');
      }
    }).fail(function(err) {
      toastr.error('Hubo un error en la petición', '¡Upss!');
    }).always(function() {
      wrapper.waitMe('hide');
    })
  }

  // Guardar o actualizar opciones
  $('.bee_save_options').on('submit', bee_save_options);
  function bee_save_options(event) {
    event.preventDefault();

    var form = $('.bee_save_options'),
    data     = new FormData(form.get(0)),
    hook     = 'bee_hook',
    action   = 'add';
    data.append('hook', hook);
    data.append('action', action);

    // AJAX
    $.ajax({
      url: 'ajax/bee_save_options',
      type: 'post',
      dataType: 'json',
      contentType: false,
      processData: false,
      cache: false,
      data : data,
      beforeSend: function() {
        form.waitMe();
      }
    }).done(function(res) {
      if(res.status === 200 || res.status === 201) {
        toastr.success(res.msg, '¡Bien!');
        bee_get_movements();
      } else {
        toastr.error(res.msg, '¡Upss!');
      }
    }).fail(function(err) {
      toastr.error('Hubo un error en la petición', '¡Upss!');
    }).always(function() {
      form.waitMe('hide');
    })
  }

  /////////////////////////////////////////////////////////
  //// PROYECTO SISTEMA ESCOLAR
  /////////////////////////////////////////////////////////

  // Función para cargar el listado de materias disponibles
  function get_materias_disponibles_profesor() {

    var form    = $('#profesor_asignar_materia_form'),
    select      = $('select', form),
    id_profesor = $('input[name="id"]', form).val(),
    wrapper     = $('#profesor_materias'),
    opciones    = '',
    action      = 'get',
    hook        = 'bee_hook';

    if (form.length == 0) return;

    // Limpiar las opciones al cargar
    select.html('');

    // AJAX
    $.ajax({
      url: 'ajax/get_materias_disponibles_profesor',
      type: 'get',
      dataType: 'json',
      data : { 
        '_t': Bee.csrf,
        id_profesor,
        action,
        hook
      },
      beforeSend: function() {
        wrapper.waitMe();
      }
    }).done(function(res) {
      if(res.status === 200) {
        if (res.data.length === 0) {
          select.html('<option disabled selected>No hay opciones disponibles.</option>')
          $('button', form).attr('disabled', true);
          return;
        }
        
        $.each(res.data, function(i, m) {
          opciones += '<option value="'+m.id+'">'+m.nombre+'</option>';
        });

        select.html(opciones);
        $('button', form).attr('disabled', false);

      } else {
        select.html('<option disabled selected>No hay opciones disponibles.</option>')
        $('button', form).attr('disabled', true);
        toastr.error(res.msg, '¡Upss!');
      }
    }).fail(function(err) {
      toastr.error('Hubo un error en la petición.', '¡Upss!');
    }).always(function() {
      wrapper.waitMe('hide');
    })
  }
  get_materias_disponibles_profesor();


  /** Alumnos por grupo */
 
 

  $("#id_materia_profe").change(function(){

    var id_grupo = $('#id_materia_profe').val();

    var wrapper = $('.wrapper_alumnos'),
  
    action      = 'get',
    hook        = 'bee_hook';

    

    // AJAX
    $.ajax({
      url: 'ajax/traerAlumnosPorGrupo',
      type: 'get',
      dataType: 'json',
      data : { 
        '_t': Bee.csrf,
        id_grupo,
        action,
        hook
      },
      beforeSend: function() {
       
      }
    }).done(function(res) {
      console.log("Esta es la respuesta del controller")
      console.log(res)
      wrapper.html(res.data);
    }).fail(function(err) {
      toastr.error('Hubo un error en la petición.', '¡Upss!');
    }).always(function() {
    
    })
    console.log(id_grupo)
});
  /** Fin alumnos por grupo*/

  // Función para cargar las materias del profesor
  function get_materias_profesor() {

    var wrapper = $('.wrapper_materias_profesor'),
    id_profesor = wrapper.data('id'),
    action      = 'get',
    hook        = 'bee_hook';

    if (wrapper.length == 0) return;

    // AJAX
    $.ajax({
      url: 'ajax/get_materias_profesor',
      type: 'get',
      dataType: 'json',
      data : { 
        '_t': Bee.csrf,
        id_profesor,
        action,
        hook
      },
      beforeSend: function() {
        wrapper.waitMe();
      }
    }).done(function(res) {
      if(res.status === 200) {
        wrapper.html(res.data);
      } else {
        wrapper.html(res.msg);
        toastr.error(res.msg, '¡Upss!');
      }
    }).fail(function(err) {
      toastr.error('Hubo un error en la petición.', '¡Upss!');
    }).always(function() {
      wrapper.waitMe('hide');
    })
  }
  get_materias_profesor();

  // Agregar nueva materia al profesor
  $('#profesor_asignar_materia_form').on('submit', add_materia_profesor);
  function add_materia_profesor(e) {
    e.preventDefault();

    var form    = $('#profesor_asignar_materia_form'),
    select      = $('select', form),
    id_materia  = select.val(),
    id_profesor = $('input[name="id"]', form).val(),
    csrf        = $('input[name="csrf"]', form).val(),
    action      = 'post',
    hook        = 'bee_hook';

    if (id_materia === undefined || id_materia === '') {
      toastr.error('Selecciona una materia válida.');
      return;
    }

    // AJAX
    $.ajax({
      url: 'ajax/add_materia_profesor',
      type: 'post',
      dataType: 'json',
      data : { 
        csrf,
        id_materia,
        id_profesor,
        action,
        hook
      },
      beforeSend: function() {
        form.waitMe();
      }
    }).done(function(res) {
      if(res.status === 201) {
        toastr.success(res.msg);
        get_materias_disponibles_profesor();
        get_materias_profesor();

      } else {
        toastr.error(res.msg, '¡Upss!');
      }
    }).fail(function(err) {
      toastr.error('Hubo un error en la petición.', '¡Upss!');
    }).always(function() {
      form.waitMe('hide');
    })
  }

  // Quitar materia de profesor
  $('body').on('click', '.quitar_materia_profesor', quitar_materia_profesor);
  function quitar_materia_profesor(e) {
    e.preventDefault();

    var btn     = $(this),
    wrapper     = $('.wrapper_materias_profesor'),
    csrf        = Bee.csrf,
    id_materia  = btn.data('id'),
    id_profesor = wrapper.data('id'),
    li          = btn.closest('li'),
    action      = 'delete',
    hook        = 'bee_hook';

    if(!confirm('¿Estás seguro?')) return false;

    $.ajax({
      url: 'ajax/quitar_materia_profesor',
      type: 'post',
      dataType: 'json',
      cache: false,
      data: {
        csrf,
        id_materia,
        id_profesor,
        action,
        hook
      },
      beforeSend: function() {
        li.waitMe();
      }
    }).done(function(res) {
      if(res.status === 200) {
        toastr.success(res.msg, 'Bien!');
        li.fadeOut();
        get_materias_disponibles_profesor();
        get_materias_profesor();
      } else {
        toastr.error(res.msg, '¡Upss!');
      }
    }).fail(function(err) {
      toastr.error('Hubo un error en la petición', '¡Upss!');
    }).always(function() {
      li.waitMe('hide');
    })
  }

  // Cargar materias disponibles para grupo
  function get_materias_disponibles_grupo() {

    var form    = $('#grupo_asignar_materia_form'),
    select      = $('select', form),
    id_grupo    = $('input[name="id_grupo"]', form).val(),
    wrapper     = $('.wrapper_materias_grupo'),
    opciones    = '',
    _t          = Bee.csrf,
    action      = 'get',
    hook        = 'bee_hook';

    if (form.length == 0) return;

    // Limpiar las opciones al cargar
    select.html('');

    // AJAX
    $.ajax({
      url: 'ajax/get_materias_disponibles_grupo',
      type: 'get',
      dataType: 'json',
      data : { 
        _t,
        id_grupo,
        action,
        hook
      },
      beforeSend: function() {
        wrapper.waitMe();
      }
    }).done(function(res) {
      if(res.status === 200) {
        if (res.data.length === 0) {
          select.html('<option disabled selected>No hay opciones disponibles.</option>')
          $('button', form).attr('disabled', true);
          return;
        }
        
        $.each(res.data, function(i, m) {
          opciones += '<option value="'+m.id+'">'+m.materia+' impartida por '+m.profesor+'</option>';
        });

        select.html(opciones);
        $('button', form).attr('disabled', false);

      } else {
        select.html('<option disabled selected>No hay opciones disponibles.</option>')
        $('button', form).attr('disabled', true);
        toastr.error(res.msg, '¡Upss!');
      }
    }).fail(function(err) {
      toastr.error('Hubo un error en la petición.', '¡Upss!');
    }).always(function() {
      wrapper.waitMe('hide');
    })
  }
  get_materias_disponibles_grupo();

  // Función para cargar las materias de un grupo
  function get_materias_grupo() {

    var wrapper = $('.wrapper_materias_grupo'),
    id_grupo    = wrapper.data('id'),
    _t          = Bee.csrf,
    action      = 'get',
    hook        = 'bee_hook';

    if (wrapper.length == 0) return;

    // AJAX
    $.ajax({
      url: 'ajax/get_materias_grupo',
      type: 'get',
      dataType: 'json',
      data : { 
        _t,
        id_grupo,
        action,
        hook
      },
      beforeSend: function() {
        wrapper.waitMe();
      }
    }).done(function(res) {
      if(res.status === 200) {
        wrapper.html(res.data);
      } else {
        wrapper.html(res.msg);
        toastr.error(res.msg, '¡Upss!');
      }
    }).fail(function(err) {
      toastr.error('Hubo un error en la petición.', '¡Upss!');
    }).always(function() {
      wrapper.waitMe('hide');
    })
  }
  get_materias_grupo();

  // Agregar nueva materia al grupo
  $('#grupo_asignar_materia_form').on('submit', add_materia_grupo);
  function add_materia_grupo(e) {
    e.preventDefault();

    var form    = $('#grupo_asignar_materia_form'),
    select      = $('select', form),
    id_mp       = select.val(),
    id_grupo    = $('input[name="id_grupo"]', form).val(),
    csrf        = $('input[name="csrf"]', form).val(),
    action      = 'post',
    hook        = 'bee_hook';

    if (id_mp === undefined || id_mp === '') {
      toastr.error('Selecciona una materia válida.');
      return;
    }

    // AJAX
    $.ajax({
      url: 'ajax/add_materia_grupo',
      type: 'post',
      dataType: 'json',
      data : { 
        csrf,
        id_mp,
        id_grupo,
        action,
        hook
      },
      beforeSend: function() {
        form.waitMe();
      }
    }).done(function(res) {
      if(res.status === 201) {
        toastr.success(res.msg);
        get_materias_disponibles_grupo();
        get_materias_grupo();

      } else {
        toastr.error(res.msg, '¡Upss!');
      }
    }).fail(function(err) {
      toastr.error('Hubo un error en la petición.', '¡Upss!');
    }).always(function() {
      form.waitMe('hide');
    })
  }

  // Quitar materia de grupo
  $('body').on('click', '.quitar_materia_grupo', quitar_materia_grupo);
  function quitar_materia_grupo(e) {
    e.preventDefault();

    var btn     = $(this),
    wrapper     = $('.wrapper_materias_grupo'),
    csrf        = Bee.csrf,
    id_mp       = btn.data('id'),
    id_grupo    = wrapper.data('id'),
    li          = btn.closest('li'),
    action      = 'delete',
    hook        = 'bee_hook';

    if(!confirm('¿Estás seguro?')) return false;

    $.ajax({
      url: 'ajax/quitar_materia_grupo',
      type: 'post',
      dataType: 'json',
      cache: false,
      data: {
        csrf,
        id_mp,
        id_grupo,
        action,
        hook
      },
      beforeSend: function() {
        li.waitMe();
      }
    }).done(function(res) {
      if(res.status === 200) {
        toastr.success(res.msg, 'Bien!');
        li.fadeOut();
        get_materias_disponibles_grupo();
        get_materias_grupo();
      } else {
        toastr.error(res.msg, '¡Upss!');
      }
    }).fail(function(err) {
      toastr.error('Hubo un error en la petición', '¡Upss!');
    }).always(function() {
      li.waitMe('hide');
    })
  }

  // Función para cargar los alumnos de un grupo
  function get_alumnos_grupo() {

    var wrapper = $('.wrapper_alumnos_grupo'),
    id_grupo    = wrapper.data('id'),
    _t          = Bee.csrf,
    action      = 'get',
    hook        = 'bee_hook';

    if (wrapper.length == 0) return;

    // AJAX
    $.ajax({
      url: 'ajax/get_alumnos_grupo',
      type: 'get',
      dataType: 'json',
      data : { 
        _t,
        id_grupo,
        action,
        hook
      },
      beforeSend: function() {
        wrapper.waitMe();
      }
    }).done(function(res) {
      if(res.status === 200) {
        wrapper.html(res.data);
      } else {
        wrapper.html(res.msg);
        toastr.error(res.msg, '¡Upss!');
      }
    }).fail(function(err) {
      toastr.error('Hubo un error en la petición.', '¡Upss!');
    }).always(function() {
      wrapper.waitMe('hide');
    })
  }
  get_alumnos_grupo();

  // Quitar alumno de grupo
  $('body').on('click', '.quitar_alumno_grupo', quitar_alumno_grupo);
  function quitar_alumno_grupo(e) {
    e.preventDefault();

    var btn     = $(this),
    wrapper     = $('.wrapper_alumnos_grupo'),
    csrf        = Bee.csrf,
    id_alumno   = btn.data('id'),
    id_grupo    = wrapper.data('id'),
    li          = btn.closest('li'),
    action      = 'delete',
    hook        = 'bee_hook';

    if(!confirm('¿Estás seguro?')) return false;

    $.ajax({
      url: 'ajax/quitar_alumno_grupo',
      type: 'post',
      dataType: 'json',
      cache: false,
      data: {
        csrf,
        id_alumno,
        id_grupo,
        action,
        hook
      },
      beforeSend: function() {
        li.waitMe();
      }
    }).done(function(res) {
      if(res.status === 200) {
        toastr.success(res.msg, 'Bien!');
        li.fadeOut();
        get_alumnos_grupo();

      } else {
        toastr.error(res.msg, '¡Upss!');
      }
    }).fail(function(err) {
      toastr.error('Hubo un error en la petición', '¡Upss!');
    }).always(function() {
      li.waitMe('hide');
    })
  }

  // Suspender alumno
  $('body').on('click', '.suspender_alumno', suspender_alumno);
  function suspender_alumno(e) {
    e.preventDefault();

    var btn     = $(this),
    csrf        = Bee.csrf,
    view        = btn.data('view'),
    id_alumno   = btn.data('id'),
    action      = 'put',
    hook        = 'bee_hook';

    if(!confirm('¿Estás seguro?')) return false;

    $.ajax({
      url: 'ajax/suspender_alumno',
      type: 'post',
      dataType: 'json',
      cache: false,
      data: {
        csrf,
        id_alumno,
        action,
        hook
      },
      beforeSend: function() {
        $('body').waitMe();
      }
    }).done(function(res) {
      if(res.status === 200) {
        toastr.success(res.msg, 'Bien!');

        if (view === 'alumnos') {
          window.location.reload();
          return false;
        }

        get_alumnos_grupo();
        
      } else {
        toastr.error(res.msg, '¡Upss!');
      }
    }).fail(function(err) {
      toastr.error('Hubo un error en la petición', '¡Upss!');
    }).always(function() {
      $('body').waitMe('hide');
    })
  }

  // Retirar suspensión del alumno
  $('body').on('click', '.remover_suspension_alumno', remover_suspension_alumno);
  function remover_suspension_alumno(e) {
    e.preventDefault();

    var btn     = $(this),
    csrf        = Bee.csrf,
    view        = btn.data('view'),
    id_alumno   = btn.data('id'),
    action      = 'put',
    hook        = 'bee_hook';

    if(!confirm('¿Estás seguro?')) return false;

    $.ajax({
      url: 'ajax/remover_suspension_alumno',
      type: 'post',
      dataType: 'json',
      cache: false,
      data: {
        csrf,
        id_alumno,
        action,
        hook
      },
      beforeSend: function() {
        $('body').waitMe();
      }
    }).done(function(res) {
      if(res.status === 200) {
        toastr.success(res.msg, 'Bien!');

        if (view === 'alumnos') {
          window.location.reload();
          return false;
        }
        
        get_alumnos_grupo();
        
      } else {
        toastr.error(res.msg, '¡Upss!');
      }
    }).fail(function(err) {
      toastr.error('Hubo un error en la petición', '¡Upss!');
    }).always(function() {
      $('body').waitMe('hide');
    })
  }

  // Inicializar la configuración de las gráficas
  Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
  Chart.defaults.global.defaultFontColor = '#858796';

  // Función que usa el theme para formatear números
  function number_format(number, decimals, dec_point, thousands_sep) {
    // *     example: number_format(1234.56, 2, ',', ' ');
    // *     return: '1 234,56'
    number = (number + '').replace(',', '').replace(' ', '');
    var n = !isFinite(+number) ? 0 : +number,
      prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
      sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
      dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
      s = '',
      toFixedFix = function(n, prec) {
        var k = Math.pow(10, prec);
        return '' + Math.round(n * k) / k;
      };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
      s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
      s[1] = s[1] || '';
      s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
  }

  // Cargar dashboard de administrador
  function init_dashboard() {
    var chart1 = $('#resumen_ingresos_chart'),
    chart2     = $('#resumen_comunidad_chart'),
    chart3     = $('#resumen_enseñanza_chart');

    if (chart1.length !== 0) draw_resumen_ingresos_chart(chart1);
    if (chart2.length !== 0) draw_resumen_comunidad_chart(chart2);
    if (chart3.length !== 0) draw_resumen_enseñanza_chart(chart3);
  }
  init_dashboard();

  // Dibujar gráfica de resumen de ingresos
  function draw_resumen_ingresos_chart(element) {
    var wrapper = element.parent('div'),
    _t          = Bee.csrf,
    action      = 'get',
    hook        = 'bee_hook';

    // AJAX
    $.ajax({
      url: 'ajax/get_resumen_ingresos',
      type: 'get',
      dataType: 'json',
      data : { _t, action, hook },
      beforeSend: function() {
        wrapper.waitMe();
      }
    }).done(function(res) {
      if(res.status === 200) {
        var myLineChart = new Chart(element, {
          type: 'line',
          data: {
            labels: res.data.labels,
            datasets: [{
              label: "Ingresos",
              lineTension: 0.3,
              backgroundColor: "rgba(78, 115, 223, 0.05)",
              borderColor: "rgba(78, 115, 223, 1)",
              pointRadius: 3,
              pointBackgroundColor: "rgba(78, 115, 223, 1)",
              pointBorderColor: "rgba(78, 115, 223, 1)",
              pointHoverRadius: 3,
              pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
              pointHoverBorderColor: "rgba(78, 115, 223, 1)",
              pointHitRadius: 10,
              pointBorderWidth: 2,
              data: res.data.data,
            }],
          },
          options: {
            maintainAspectRatio: false,
            layout: {
              padding: {
                left: 0,
                right: 0,
                top: 0,
                bottom: 0
              }
            },
            scales: {
              xAxes: [{
                time: {
                  unit: 'date'
                },
                gridLines: {
                  display: false,
                  drawBorder: false
                },
                ticks: {
                  maxTicksLimit: 20
                }
              }],
              yAxes: [{
                ticks: {
                  maxTicksLimit: 8,
                  padding: 10,
                  // Include a dollar sign in the ticks
                  callback: function(value, index, values) {
                    return '$' + number_format(value);
                  }
                },
                gridLines: {
                  color: "rgb(234, 236, 244)",
                  zeroLineColor: "rgb(234, 236, 244)",
                  drawBorder: false,
                  borderDash: [2],
                  zeroLineBorderDash: [2]
                }
              }],
            },
            legend: {
              display: false
            },
            tooltips: {
              backgroundColor: "rgb(255,255,255)",
              bodyFontColor: "#858796",
              titleMarginBottom: 10,
              titleFontColor: '#6e707e',
              titleFontSize: 14,
              borderColor: '#dddfeb',
              borderWidth: 1,
              xPadding: 15,
              yPadding: 15,
              displayColors: false,
              intersect: false,
              mode: 'index',
              caretPadding: 10,
              callbacks: {
                label: function(tooltipItem, chart) {
                  var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                  return datasetLabel + ': $' + number_format(tooltipItem.yLabel);
                }
              }
            }
          }
        });
      } else {
        wrapper.html(res.msg);
      }
    }).fail(function(err) {
      wrapper.html('Hubo un error al cargar la información.')
    }).always(function() {
      wrapper.waitMe('hide');
    });
  }

  // Dibujar gráfica de resumen de comunidad
  function draw_resumen_comunidad_chart(element) {
    var wrapper = element.parent('div'),
    _t          = Bee.csrf,
    action      = 'get',
    hook        = 'bee_hook';

    // AJAX
    $.ajax({
      url: 'ajax/get_resumen_comunidad',
      type: 'get',
      dataType: 'json',
      data : { _t, action, hook },
      beforeSend: function() {
        wrapper.waitMe();
      }
    }).done(function(res) {
      if(res.status === 200) {
        var myPieChart = new Chart(element, {
          type: 'doughnut',
          data: {
            labels: res.data.labels,
            datasets: [{
              data: res.data.data,
              backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc'],
              hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
              hoverBorderColor: "rgba(234, 236, 244, 1)",
            }],
          },
          options: {
            maintainAspectRatio: false,
            tooltips: {
              backgroundColor: "rgb(255,255,255)",
              bodyFontColor: "#858796",
              borderColor: '#dddfeb',
              borderWidth: 1,
              xPadding: 15,
              yPadding: 15,
              displayColors: false,
              caretPadding: 10,
            },
            legend: {
              display: true
            },
            cutoutPercentage: 50,
          },
        });
      } else {
        wrapper.html(res.msg);
      }
    }).fail(function(err) {
      wrapper.html('Hubo un error al cargar la información.')
    }).always(function() {
      wrapper.waitMe('hide');
    });
  }

  // Dibujar gráfica de resumen de lecciones
  function draw_resumen_enseñanza_chart(element) {
    var wrapper = element.parent('div'),
    _t          = Bee.csrf,
    action      = 'get',
    hook        = 'bee_hook';

    // AJAX
    $.ajax({
      url: 'ajax/get_resumen_ensenanza',
      type: 'get',
      dataType: 'json',
      data : { _t, action, hook },
      beforeSend: function() {
        wrapper.waitMe();
      }
    }).done(function(res) {
      if(res.status === 200) {
        var myLineChart = new Chart(element, {
          type: 'bar',
          data: {
            labels: res.data.labels,
            datasets: [{
              label: "Lecciones",
              lineTension: 0.3,
              backgroundColor: "rgba(78, 115, 223, 0.5)",
              borderColor: "rgba(78, 115, 223, 1)",
              pointRadius: 3,
              pointBackgroundColor: "rgba(78, 115, 223, 1)",
              pointBorderColor: "rgba(78, 115, 223, 1)",
              pointHoverRadius: 3,
              pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
              pointHoverBorderColor: "rgba(78, 115, 223, 1)",
              pointHitRadius: 10,
              pointBorderWidth: 2,
              data: res.data.data,
            }],
          },
          options: {
            maintainAspectRatio: false,
            layout: {
              padding: {
                left: 0,
                right: 0,
                top: 0,
                bottom: 0
              }
            },
            scales: {
              xAxes: [{
                time: {
                  unit: 'date'
                },
                gridLines: {
                  display: false,
                  drawBorder: false
                },
                ticks: {
                  maxTicksLimit: 20
                }
              }],
              yAxes: [{
                ticks: {
                  maxTicksLimit: 5,
                  padding: 10
                },
                gridLines: {
                  color: "rgb(234, 236, 244)",
                  zeroLineColor: "rgb(234, 236, 244)",
                  drawBorder: false,
                  borderDash: [2],
                  zeroLineBorderDash: [2]
                }
              }],
            },
            legend: {
              display: false
            },
            tooltips: {
              backgroundColor: "rgb(255,255,255)",
              bodyFontColor: "#858796",
              titleMarginBottom: 10,
              titleFontColor: '#6e707e',
              titleFontSize: 14,
              borderColor: '#dddfeb',
              borderWidth: 1,
              xPadding: 15,
              yPadding: 15,
              displayColors: false,
              intersect: false,
              mode: 'index',
              caretPadding: 10,
              callbacks: {
                label: function(tooltipItem, chart) {
                  var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                  return datasetLabel + ': ' + tooltipItem.yLabel;
                }
              }
            }
          }
        });
      } else {
        wrapper.html(res.msg);
      }
    }).fail(function(err) {
      wrapper.html('Hubo un error al cargar la información.')
    }).always(function() {
      wrapper.waitMe('hide');
    });
  }

  // Recargar tabla de resumen de ingresos
  $('.recargar_resumen_ingresos_chart').on('click', recargar_resumen_ingresos_chart);
  function recargar_resumen_ingresos_chart(e) {
    e.preventDefault();

    var chart = $('#resumen_ingresos_chart');

    if (chart.length === 0) return;

    draw_resumen_ingresos_chart(chart);
  }

  // Recargar tabla de resumen de enseñanza o lecciones
  $('.recargar_resumen_enseñanza_chart').on('click', recargar_resumen_enseñanza_chart);
  function recargar_resumen_enseñanza_chart(e) {
    e.preventDefault();

    var chart = $('#resumen_enseñanza_chart');

    if (chart.length === 0) return;

    draw_resumen_enseñanza_chart(chart);
  }

  // Reiniciar el sistema
  $('#reiniciar_sistema_form').on('submit', reiniciar_sistema);
  function reiniciar_sistema(e) {
    e.preventDefault();

    var form    = $(this),
    button      = $('button', form),
    data        = new FormData(form.get(0));

    if(!confirm('¿Estás seguro?')) return false;

    $.ajax({
      url: 'ajax/reiniciar_sistema',
      type: 'post',
      dataType: 'json',
      processData: false,
      contentType: false,
      cache: false,
      data: data,
      beforeSend: function() {
        button.waitMe();
      }
    }).done(function(res) {
      if(res.status === 200) {
        toastr.success(res.msg, '¡Bien!');
      } else {
        toastr.error(res.msg, '¡Upss!');
      }
    }).fail(function(err) {
      toastr.error('Hubo un error en la petición', '¡Upss!');
    }).always(function() {
      button.waitMe('hide');
    })
  }
});


/** Funciones para las vistas */
/** Vistas nav */
function accionAsistencia(status){
  console.log(status)
  if(status == true){
    $("#capturar-asistencia").show();
    $("#consultar-asistencia").hide();
    primerGrupo();
  }else{
    $("#capturar-asistencia").hide();
    $("#consultar-asistencia").show();
    $("#tabla").hide();
  }
}
/** Fin vistas */

/** Guardar reporte */
function guardarReporte(){
 
 //Crear array de chesks
  let array_check = [];
 
  let lista = document.querySelector('#lista-items').getElementsByTagName('li');
  [].forEach.call(lista, element => {
   
    id_buscar= "name-"+element.id;
    let nombre_usuario = document.getElementById(id_buscar);

    checkbox_buscar = "check_asistencia-"+element.id;
    let checkbox_asistencia = document.getElementById(checkbox_buscar);
    

    if (checkbox_asistencia.checked == true){
      array_check.push({"id":element.id, "name":nombre_usuario.value, "status":1})
    }else{
      array_check.push({"id":element.id, "name":nombre_usuario.value, "status":0})
    }
  });
  

  // traer id_de grupo
  var select = document.getElementById('id_materia_profe');
 

  /**Array completo para mandar*/
   dataCheck = {
    "id_grupo": select.value,
    "json_check": array_check

  }
  csrf = Bee.csrf;
  console.log(csrf)

  $.ajaxSetup({ 
    headers: { 'X-CSRF-TOKEN': csrf } }); 
  // Ajax

  // Ajax con get


  
    action      = 'get',
    hook        = 'bee_hook';
    // AJAX
    $.ajax({
      url: 'ajax/insertarCheck',
      type: 'get',
      dataType: 'json',
      data : { 
        '_t': Bee.csrf,
        dataCheck,
        action,
        hook
      },
      beforeSend: function() {
       
      }
    }).done(function(res) {
      console.log("Esta es la respuesta del controller")
      console.log(res.data)
     
      if(res.status === 200){
        toastr.success('Reporte ingresado', 'Done');
      }
      if(res.status === 203){
        toastr.success('Reporte actualizado', 'Done');
      }
     
      if(res.status === 201){
        toastr.error('Reporte capturado.', '¡Upss!');
      }
    }).fail(function(err) {
      toastr.error('Hubo un error en la petición88.', '¡Upss!');
    }).always(function() {
    
    })
   
  console.log("Array a mandar")
  
  
 
 
}
/** Fin Guardar reporte */

/** Consultar reporte */
function consultarReporte(){
  $elemento = document.getElementById('cuerpo-tabla');
  $elemento.innerHTML = "";
  $elemento_boton = document.getElementById('contenedor-boton');
  $elemento_boton.innerHTML = "";
  
 
  var select = document.getElementById('id_grupo_profe');
  let id_grupo = select.value;

  let fecha = document.getElementById("fecha_consulta").value;

  console.log("consultar reporte")
  console.log(id_grupo)
  console.log(fecha)
  // Peticion Ajax
  csrf = Bee.csrf;
  console.log(csrf)
  dataCheck = {
    "id_grupo": id_grupo,
    "fecha": fecha
  }
  $.ajaxSetup({ 
    headers: { 'X-CSRF-TOKEN': csrf } }); 
  // Ajax

  
    action      = 'get',
    hook        = 'bee_hook';
    // AJAX
    $.ajax({
      url: 'ajax/traerCheck',
      type: 'get',
      dataType: 'json',
      data : { 
        '_t': Bee.csrf,
        dataCheck,
        action,
        hook
      },
      beforeSend: function() {
       
      }
    }).done(function(res) {
      console.log("Esta es la respuesta del controller")
      //console.log(res.data)
  
      $("#tabla").show();
    //console.log(DatosJson);
   
    var jsonReporte = JSON.parse(res.data)

    
    


    for (x of jsonReporte){
      console.log(x.name)
    if(x.status == 1){
      $("#tabla").append('<tr>' + '<td  style="dislay: none;">' + x.name + '</td>' + '<td  style="dislay: none;">' + x.status +' <i class="fas fa-check-square"></i>'+ '</td>');
    }else{
      $("#tabla").append('<tr>' + '<td  style="dislay: none;">' + x.name + '</td>' + '<td  style="dislay: none;">' + x.status +' <i class="fa fa-times" aria-hidden="true"></i>'+ '</td>');
    }
    
        
    }
    $('#contenedor-boton').append(' <button class="btn btn-success" id="boton-descargar" onClick="exportTableToExcel();" type="button">Descargar reporte</button>');


      toastr.success('Todo salio bien', 'Done');
    }).fail(function(err) {
      toastr.error('No se encontro reporte en la fecha seleccionada.', '¡Upss!');
      $("#tabla").hide();
      $("#boton-descargar").hide();
    }).always(function() {
    
    })
}

/** Fin consultar reporte */
function descargarReporte(){
  console.log('Descargar Reporte')
}

function exportTableToExcel (filename = ''){
  var downloadLink;
  var dataType = 'application/vnd.ms-excel';
  var tableSelect = document.getElementById('tabla');
  var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
  var date = new Date();
  // Specify file name
  filename = filename?filename+'.xls':'reporte'+date.toDateString()+'.xls';
  
  // Create download link element
  downloadLink = document.createElement("a");
  
  document.body.appendChild(downloadLink);
  
  if(navigator.msSaveOrOpenBlob){
      var blob = new Blob(['ufeff', tableHTML], {
          type: dataType
      });
      navigator.msSaveOrOpenBlob( blob, filename);
  }else{
      // Create a link to the file
      downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
  
      // Setting the file name
      downloadLink.download = filename;
      
      //triggering the function
      downloadLink.click();
  }
}

function primerGrupo(){
  var id_grupo = $('#id_materia_profe').val();

  var wrapper = $('.wrapper_alumnos'),

  action      = 'get',
  hook        = 'bee_hook';
  // AJAX
  $.ajax({
    url: 'ajax/traerAlumnosPorGrupo',
    type: 'get',
    dataType: 'json',
    data : { 
      '_t': Bee.csrf,
      id_grupo,
      action,
      hook
    },
    beforeSend: function() {
     
    }
  }).done(function(res) {
    console.log("Esta es la respuesta del controller")
    console.log(res)
    wrapper.html(res.data);
  }).fail(function(err) {
    toastr.error('Hubo un error en la petición88.', '¡Upss!');
  }).always(function() {
  
  })
  console.log(id_grupo)
}

/**Descargar registro INEA */
function descargarRegistroINEA(){
  console.log("Descargar reporte")
  //$('#reporteINEA').css('transform','scale(2)');
  var xxHEIGHT = $('#reporteINEA').height();
  var xxWIDTH = $('#reporteINEA').width();
  var carta_width = '842';
  var carta_heigth = '5450';
  var HTML_Width = xxWIDTH;
  var HTML_Height = xxHEIGHT;
  var top_left_margin = 0;
  var PDF_Width = HTML_Width;
  var PDF_Height = PDF_Width;
  var canvas_image_width = HTML_Width;
  var canvas_image_height = HTML_Height;
  var totalPDFPages = 1;
  let timerInterval
      Swal.fire({
        title: 'Descargando registro',
        html: '',
        timer: 2000,
        timerProgressBar: true,
        didOpen: () => {
          Swal.showLoading()
          const b = Swal.getHtmlContainer().querySelector('b')
          timerInterval = setInterval(() => {
            b.textContent = Swal.getTimerLeft()
          }, 100)
        },
        willClose: () => {
          clearInterval(timerInterval)
        }
      }).then((result) => {
        /* Read more about handling dismissals below */
        if (result.dismiss === Swal.DismissReason.timer) {
          console.log('I was closed by the timer')
        }
      })
  html2canvas($("#reporteINEA")[0], {
            
  }).then(function (canvas) {
      var imgData = canvas.toDataURL("image/png", 1.0);
      var pdf = new jsPDF('l', 'pt', [carta_width, carta_heigth]);
      //pdf.addPage(carta_width, HTML_Height);
      pdf.addImage(imgData, 'PNG', top_left_margin, top_left_margin, carta_width, HTML_Height);
      
      
      
      pdf.save("registroINEA.pdf");
     
  });
  $('#reporteINEA').css('transform','scale(1)');

}
// Registro INEA
function guardarRegistroINEA(){
  console.log("Guardar registro INEA")
  console.log($('#registro-inea').serialize());
  let idBeneficiario = document.getElementById('idBeneficiario').value;
  let numeroZona = document.getElementById('numero-zona').value;
  let nombreZona = document.getElementById('nombre-zona').value;
  let fecha_registro = document.getElementById('fecha-registro').value;
  let incorporacion = document.querySelector('input[name="check-option"]:checked');
  if(incorporacion == null){
    toastr.error('Debe marcar alguna opción', '¡Upss!');
    let divCheckIngreso = document.getElementById('check-ingreso');
    divCheckIngreso.focus();
  }
  
  console.log(incorporacion)
  debugger
  // Datos generales
  let primerApellido = document.getElementById('primer-apellido').value;
  let segundoApellido = document.getElementById('segundo-apellido').value;
  let nombres = document.getElementById('nombres').value;
  let fechaNacimientoBeneficiario = document.getElementById('fecha-nacimiento').value;
  let rfe = document.getElementById('rfe').value;
  let nacionalidad = document.getElementById('nacionalidad').value;
  let entidadNacimiento = document.getElementById('entidad-nacimiento').value;
  let sexo = document.querySelector('input[name="check-sexo"]:checked').value;
  let estadoCivil = document.querySelector('input[name="check-estado-civil"]:checked').value;
  let numeroHijos = document.getElementById('n-hijos').value;
  let hablaLenguaIndigena = document.querySelector('input[name="habla-dialecto-o-lengua"]:checked').value;
  let cualLengua = document.getElementById('cual-lengua').value;
  let hablaOtroIdioma = document.querySelector('input[name="idioma-adicional"]:checked').value;
  let cualAdicional = document.getElementById('cual-adicional').value;
  let seConsideraIndigena = document.querySelector('input[name="se-considera-indigena"]:checked').value;
  let seConsideraAfro = document.querySelector('input[name="se-considera-afro"]:checked').value;
  // fin datos generales

  // Domicilio
  let tipoVialidad = document.getElementById('tipo-vialidad').value;
  let nombreVialidad = document.getElementById('nombre-vialidad').value;
  let numExterior = document.getElementById('num-exterior').value;
  let numInterior = document.getElementById('num-interior').value;
  let tipoAsentamiento  = document.getElementById('tipo-asentamiento').value;
  let nombreAsentamiento  = document.getElementById('nombre-asentamiento').value;
  let tipoEntreVialidadUNO  = document.getElementById('tipo-entre-vialidad-1').value;
  let nombreEntreVialidadUNO  = document.getElementById('nombre-entre-vialidad-1').value;
  let tipoEntreVialidadDOS  = document.getElementById('tipo-entre-vialidad-2').value;
  let nombreEntreVialidadDOS  = document.getElementById('nombre-entre-vialidad-2').value;
  let cp  = document.getElementById('c-p').value;
  let lsocalidad  = document.getElementById('localidad').value;
  let municipio  = document.getElementById('municipio').value;
  let entidadFederativa  = document.getElementById('entidad-federativa').value;
  let telefonoFijo  = document.getElementById('telefono-fijo').value;
  let telefonoCelular  = document.getElementById('telefono-celular').value;
  let equipoComputo = document.querySelector('input[name="equipo-computo"]:checked').value;
  let accesoInternet = document.querySelector('input[name="acceso-internet"]:checked').value;
  let correoPersonal = document.getElementById('correo-personal').value;
  let correoINEA = document.getElementById('correo-inea').value;
  // Dificultades
  let caminarSubirBajar = document.querySelector('input[name="caminar-subir-bajar"]:checked').value;
  let oir = document.querySelector('input[name="oir"]:checked').value;
  let ver = document.querySelector('input[name="ver"]:checked').value;
  let banarseVestirseComer = document.querySelector('input[name="banarse-vestirse-comer"]:checked').value;
  let hablarComunicarse = document.querySelector('input[name="hablar-comunicarse"]:checked').value;
  let recordarConcentrarse = document.querySelector('input[name="recordar-concentrarse"]:checked').value;
  let condicionMental = document.querySelector('input[name="condicion-mental"]:checked').value;
  // Trabajo 
  let trabajoActivo = document.querySelector('input[name="trabajo-activo"]:checked').value;
  let otroEmpleo = document.getElementById('otro-empleo').value;
  let trabajadorAgropecuario = document.querySelector('input[name="trabajador-agropecuario"]:checked').value;
  let inspectorSupervisor = document.querySelector('input[name="inspector-supervisor"]:checked').value;
  let artesano = document.querySelector('input[name="artesano"]:checked').value;
  let obrero = document.querySelector('input[name="obrero"]:checked').value;
  let ayudante = document.querySelector('input[name="ayudante"]:checked').value;
  let empleadoGobierno = document.querySelector('input[name="empleado-gobierno"]:checked').value;
  let operador  = document.querySelector('input[name="operador"]:checked').value;
  let comercianteVendedor  = document.querySelector('input[name="comerciante-vendedor"]:checked').value;
  let trabajadorHogar  = document.querySelector('input[name="trabajar-hogar"]:checked').value;
  let proteccionVigilancia  = document.querySelector('input[name="proteccion-vigilancia"]:checked').value;
  let quehaceresHogar  = document.querySelector('input[name="quehaceres-hogar"]:checked').value;
  let trabajadorAmbulante  = document.querySelector('input[name="trabajador-ambulante"]:checked').value;
  let deportista  = document.querySelector('input[name="deportista"]:checked').value;
  // nivel al que ingresa
  let nivelIngreso  = document.querySelector('input[name="nivel-ingreso"]:checked').value;
  // antecedentes escolares
  let sinEstudios  = document.querySelector('input[name="sin-estudios"]:checked').value;
  let primariaAntecedente  = document.querySelector('input[name="primaria-antecedente"]:checked').value;
  let primariaGrado = document.getElementById('primaria-grado').value;
  let secundariaAntecedente  = document.querySelector('input[name="secundaria-antecedente"]:checked').value;
  let secundariaGrado = document.getElementById('grado-secundaria').value;
  let hispanohablante = document.querySelector('input[name="hispanohablante"]:checked').value;
  let hablanteLenguaIndigena = document.querySelector('input[name="hablante-lengua-indigena"]:checked').value;
  let etniaLengua = document.getElementById('etnia-lengua').value;
  let checkEjercicios = document.querySelector('input[name="check-ejercicios"]:checked').value;
  // Motivo de estudiar
  let motivoEstudiar = document.querySelector('input[name="motivo-estudiar"]:checked').value;
  let otroMotivo = document.querySelector('input[name="otroMotivo"]:checked').value;
  let otroMotivoCual = document.getElementById('otro-motivo-cual').value;
  // Como se entero
  let comoSeEntero = document.querySelector('input[name="como-se-entero"]:checked').value;
  let otroComoSeEntero = document.getElementById('como-se-entero-otro').value;
  let subproyecto = document.getElementById('subproyecto').value;
  let dependencia = document.getElementById('dependencia').value;
  // documentacion personal
  let fotografia = document.querySelector('input[name="fotografia"]:checked').value;
  let fichaCereso = document.querySelector('input[name="ficha-cereso"]:checked').value;
  let documentoEquivalente = document.querySelector('input[name="documento-legal-equivalente"]:checked').value;
  // Documentos probatorios
  let certificadoPrimaria = document.querySelector('input[name="certificado-primaria"]:checked').value;
  let informeINEA = document.querySelector('input[name="informe-calificaciones-inea"]:checked').value;
  let numeroConstancias = document.getElementById('numero-constancias').value;
  let horasCapacitacion = document.getElementById('horas-capacitacion').value;
  // Datos de quien cotejo
  let nombreDeQuienCotejo = document.getElementById('nombre-completo-cotejo').value;
  let fechaCotejo = document.getElementById('fecha-cotejo').value;
  // informacion unidad operativa
  let unidadOperativa = document.getElementById('unidad-operativa').value;
  let circuloEstudio = document.getElementById('circulo-estudio').value;
  
  console.log('id: '+idBeneficiario);
}