<?php
//Configuracion globales por defecto.
require_once "config/globals.php";
//Controlador basico.
require_once "core/BasicController.php";
// Funciones para el controlador frontal.
require_once 'core/FrontControllerAdm.php';
$adminController = new FrontControllerAdministrator();

//Cargamos nuestros controladores y las acciones.
//Se crea un array donde se guardaran los datos de los metodos
//para pasarselo a las vistas.
$dataToView["data"] = array();

if (isset($_GET['controller'])) {
  $Controller = $adminController->loadController($_GET['controller']);
  $dataToView["data"] = $adminController->launchAction($Controller);
} else {
  $Controller = $adminController->loadController(DEFAULT_CONTROLLER);
  $dataToView["data"] = $adminController->launchAction($Controller);
}

//Cargamos las vistas.
if ($Controller->view != 'app') {

  require_once "view/inc_header.php";
}
require_once "view/" . $Controller->view . ".php";
require_once "view/inc_footer.php";
