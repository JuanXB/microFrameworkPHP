<?php
//Esta clase contiene metodo que ayudan al Front Controller 
// a manejar los controladores y las acciones.
class FrontControllerAdministrator
{

  //Carga la clase del controlador que se pasa como argumento.
  public function loadController($controller)
  {
    //Crear nombre del fichero controlador.
    $controller = ucwords($controller) . 'Controller';
    //Ruta del controlador.
    $strFileController = 'Controller/' . $controller . '.php';

    if (!is_file($strFileController)) {
      $strFileController = 'Controller/' . ucwords(DEFAULT_CONTROLLER) . 'Controller';
    }

    //Se llama al archivo del controlador.
    require_once $strFileController;
    $objController = new $controller();

    return $objController;
  }


  //Carga el metodo del controlador que se pasa
  // por la variable $action.
  private function loadAction($objController, $action)
  {
    $controllerMethod = $action;
    return $objController->$controllerMethod();
  }


  //Lanza la peticion para cargar el metodo del controlador,
  //si el metodo no existe carga el definido en globals.php
  //Ademas se crea un array donde se guardaran los datos 
  //que retornan las acciones del controlador.
  public function launchAction($objController)
  {
    //Se crea un array donde se guardaran los datos de los metodos
    //para pasarselo a las vista.
    $dataToView["data"] = array();
    if (isset($_GET['action']) && method_exists($objController,  $_GET['action'])) {

      $dataToView["data"] = $this->loadAction($objController,  $_GET['action']);
      return $dataToView["data"];
    } else {

      $dataToView["data"] =  $this->loadAction($objController, DEFAULT_ACTION);
      return $dataToView["data"];
    }
  }

  //Crea la url que redrije a la vista.
  public function viewRequired($vista)
  {
    require_once 'view/' . $vista . '.php';
  }
}
