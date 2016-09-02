<?php
session_start();
require 'admin/config.php';
require 'funciones.php';

verificarSesion();

$errores = '';
$enviado = false;

$conexion = conectar($bd_conexion);

if($conexion == false){
  header('Location:error.php');
}

$id = $_SESSION['id'];

#Obtengo los datos del usuario que inicio sesion
$consulta = $conexion->prepare('SELECT usuario,email,pass FROM usuarios WHERE id_usuario = :id');
$consulta->execute(array(
  ':id' => $id
));

$resultado = $consulta->fetch();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
  #Verifico que ingrese la password
  if (!empty($_POST['passactual'])) {
  #Verifico que la password ingresada sea igual a la antigua
  $passactual = hash('sha512',$_POST['passactual']);
  if($passactual == $resultado['pass']){
    #El usuario no puede estar vacio
    if(!empty($_POST['user'])){
      $usuario = $_POST['user'];

      #si ingreso un usuario distinto al existente verificamos que no exista
      if($usuario != $resultado['usuario']){
        #Verificamos que no exista el usuario
        $statement = $conexion->prepare('SELECT * FROM usuarios WHERE usuario = :usuario LIMIT 1');
        $statement->execute(array(':usuario' => $usuario));
        $resultado = $statement->fetch();

         if($resultado != false){
           $errores .= "<li>El nombre de usuario ya existe</li>";
         }
      }

    }else{
      $errores .= "<li>El campo usuario no puede estar vacio</li>";
    }

    #El email no puede estar vacio
    if(!empty($_POST['email'])){
      $email = $_POST['email'];
    }else{
      $errores .= "<li>El campo email no puede estar vacio</li>";
    }

    #Si no ingresa password nueva, se mantiene la antigua
    if(!empty($_POST['passnueva'])){
      $passactual = hash('sha512',$_POST['passnueva']);
    }
  }else{
    $errores = '<li>Contraseña incorrecta</li>';
  }
}else{
  $errores = '<li>Ingrese su contraseña</li>';
}


  #Si no hay errores limpiamos los campos y actualizamos el registro
  if($errores == ''){
    $usuario = limpiarInput($usuario);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);

    $actualizar = $conexion->prepare('UPDATE usuarios SET usuario = :usuario, email = :email, pass = :pass WHERE id_usuario = :id');
    $actualizar->execute(array(
      ':usuario' => $usuario,
      ':email' => $email,
      ':pass' => $passactual,
      ':id' => $id
    ));
    header("location:configuracion.php");
  }
}


require 'views/configuracion.view.php';

?>
