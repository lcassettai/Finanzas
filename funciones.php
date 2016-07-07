<?php
  function conectar($bd_conexion){
    try {
      $conexion = new PDO('mysql:host=localhost;dbname='.$bd_conexion['bd'],$bd_conexion['usuario'],$bd_conexion['pass']);
      return $conexion;
    } catch (Exception $e) {
      return false;
    }
  }

  function limpiarInput($entrada){
    $entrada = trim($entrada);
    $entrada = htmlspecialchars($entrada);
    $entrada = stripslashes($entrada);

    return $entrada;
  }

  function verificarSesion(){   

    if(!isset($_SESSION['usuario'])){
      header('Location:'.RUTA.'/login.php');
    }
  }
?>
