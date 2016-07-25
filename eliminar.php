<?php
  session_start();
  require 'admin/config.php';
  require 'funciones.php';
  verificarSesion();

  $conexion = conectar($bd_conexion);

  if($conexion == false){
    header('Location:error.php');
  }

  if(($_SERVER['REQUEST_METHOD'] == 'POST')){
    $codigo = $_POST['codigo'];
    $tipo = $_POST['tipo'];
  }

  if ($tipo == 'ingresos') {
      $consulta = $conexion->prepare('DELETE FROM ingresos WHERE cod_ingreso = :codigo');
  }else{
      $consulta = $conexion->prepare('DELETE FROM gastos WHERE cod_gasto = :codigo');
  }

  $consulta->execute(array(
    ':codigo' => $codigo
  ));

  header('Location:historial.php');

?>
