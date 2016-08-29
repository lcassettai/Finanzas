<?php
  session_start();
  require 'admin/config.php';
  require 'funciones.php';
  //Verificamos si inicio sesion
  verificarSesion();

  //Intentamos conectarnos a la BD
  $conexion = conectar($bd_conexion);

  //Si la conexion falla enviamos a la pagina de error
  if($conexion == false){
    header('Location:error.php');
  }

  //Recibimos el codigo del movimiento que queremos eliminar y el tipo (ingreso o gasto)
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
