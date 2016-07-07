<?php
session_start();
require 'admin/config.php';
require 'funciones.php';

if (isset($_SESSION['usuario'])) {
  header('Location:home.php');
}

$errores = '';
$enviado = false;

if($_SERVER['REQUEST_METHOD'] == 'POST'){
  if(!empty($_POST['usuario'])){
    $usuario = $_POST['usuario'];
  }else{
    $errores .= "<li>Ingrese un nombre de usuario</li>";
  }

  if(!empty($_POST['email'])){
    $email = $_POST['email'];
  }else{
    $errores .= "<li>Ingrese un email</li>";
  }

  if(!empty($_POST['pass']) || !empty($_POST['pass2'])){
    $pass = $_POST['pass'];
    $pass2 = $_POST['pass2'];
    if($pass != $pass2){
      $errores .= "<li>Las contraseñas no coinciden</li>";
    }
  }else{
    $errores .= "<li>Ingrese una contraseña</li>";
  }

  //Si no hay ningun error continuamos
  if($errores == ''){
     $conexion = conectar($bd_conexion);

     $usuario = limpiarInput($usuario);
     $email = filter_var($email, FILTER_VALIDATE_EMAIL);
     $pass = hash('sha512',$pass);

     $statement = $conexion->prepare('SELECT * FROM usuarios WHERE usuario = :usuario LIMIT 1');
     $statement->execute(array(':usuario' => $usuario));
     $resultado = $statement->fetch();

      if($resultado != false){
        $errores .= "<li>El nombre de usuario ya existe</li>";
      }else{
        //Si no se encontro ningun error se procede a insertar los datos
        $consulta = $conexion->prepare('INSERT INTO usuarios (id_usuario,usuario,pass,email,activo) VALUES (null,:usuario,:pass,:email,0)');
        $consulta = $consulta->execute(array(
          ':usuario' => $usuario,
          ':pass' => $pass,
          ':email' => $email
        ));

         $enviado = true;
         header('Location:login.php');
      }
  }
}

 require 'registrate.view.php';;
?>
