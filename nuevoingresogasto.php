<?php
  session_start();
  require 'admin/config.php';
  require 'funciones.php';
  $errores = '';
  $enviado = false;

  verificarSesion();

  $conexion = conectar($bd_conexion);

  if($conexion == false){
    header('location:error.php');
  }

  /*Definimos nuevo_tipo para saber si es un ingreso o gasto*/
  if(isset($_GET['tipo'])){
    $nuevo_tipo = $_GET['tipo'];
    #Si no es ni un ingreso ni un gasto, lanzamos un error
    if($nuevo_tipo != 'ingresos' && $nuevo_tipo != 'gastos'){
      header('Location:error.php');
    }
  }else{
    header('Location:error.php');
  }

  #Dependiendo si es un ingreso o gasto vamos a obtener los valores para
  #Rellenar el combobox
  $tipo_ingresos = obtener_tipo_ingresos_gastos($conexion,$nuevo_tipo);


  if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(!empty($_POST['monto'])){
      $monto =  $_POST['monto'];
      if(!is_numeric($monto)){
          $errores = 'El monto debe ser numerico';
      }
    }else{
      $errores = 'Debe ingresar un monto';
    }

    if(!empty($_POST['comentario'])){
      $comentario = $_POST['comentario'];
      $comentario = limpiarInput($comentario);
    }else{
      $comentario  = '';
    }


    $categoria = $_POST['categoria'];
    $usuario = $_SESSION['id'];

    if($errores == ''){
      #Si no hay errores insertamos el nuevo ingreso o gasto
      if ($_POST['nuevo_tipo'] == 'ingresos') {
         $consulta = $conexion->prepare('INSERT INTO ingresos(monto,comentario,id_tipo_ingreso,id_usuario) VALUES (:monto,:comentario,:categoria,:usuario)');
      }else{
         $consulta = $conexion->prepare('INSERT INTO gastos(monto,comentario,id_tipo_gasto,id_usuario) VALUES (:monto,:comentario,:categoria,:usuario)');
      }

     $consulta->execute(array(
       ':monto' => $monto,
       ':comentario' => $comentario,
       ':categoria' => $categoria,
       ':usuario' => $usuario
     ));
     $enviado = true;
    }
  }

  require 'views/nuevoingresogasto.view.php';
?>
