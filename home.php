<?php
  session_start();
  require 'admin/config.php';
  require 'funciones.php';
  verificarSesion();

  $conexion = conectar($bd_conexion);

  if($conexion == false){
    header('Location:error.php');
  }

  $montoActual = obtener_monto_actual($conexion,$_SESSION['id']);

  require 'views/home.view.php';
?>
