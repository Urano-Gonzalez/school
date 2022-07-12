<?php
/**
 * Controlador para las asistencias
 */
class asistenciaController extends Controller{
    private $id = null;
    private $rol =null;

    function __construct(){
         // Validación de sesión de usuario, descomentar si requerida
    /*
    if (!Auth::validate()) {
      Flasher::new('Debes iniciar sesión primero.', 'danger');
      Redirect::to('login');
    }
    */

    $this->id  = get_user('id');
    $this->rol = get_user_role();
    /*
    if (!is_admin($this->rol)) {
      Flasher::new(get_notificaciones(), 'danger');
      Redirect::back();
    }
    */
    }
    function index(){
        $materias = materiaModel::materias_profesor($this->id);
        json_encode($materias, true);
       
        //Verificar si es admin
        
        
        
        if($this->rol == "root"){
          $data = 
          [
          'title' => 'Asistencia de alumnos',
          'slug'  => 'asistencia',
          'id_prof' => $this->id,
          'materias' => $materias,
          'grupos' => profesorModel::all_grupos(),
          'nombre' => get_user('nombre_completo'),
          ];
        }else{
          $data = 
          [
          'title' => 'Asistencia de alumnos',
          'slug'  => 'asistencia',
          'id_prof' => $this->id,
          'materias' => $materias,
          'grupos' => profesorModel::grupos_asignados($this->id),
          ];
        }
        
        
        
        // Descomentar vista si requerida
        View::render('index', $data);
    }
}
?>