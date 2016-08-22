<?php
 session_start();
 require 'admin/config.php';
 require 'funciones.php';
 $errores = '';

 if(isset($_SESSION['usuario']) && isset($_SESSION['id'])){
   header('Location:home.php');
 }

 if($_SERVER['REQUEST_METHOD'] == 'POST'){
   $conexion = conectar($bd_conexion);
   if($conexion == false){
     //Esto es solo para ver la conexion
     echo 'Error al intentar conectar a la base de datos';
     header('Location:error.php');
   }

   $usuario  = limpiarInput($_POST['usuario']);
   $pass  = limpiarInput($_POST['pass']);
   $pass = hash('sha512',$pass);

   $consulta = $conexion->prepare('SELECT * FROM usuarios WHERE usuario = :usuario LIMIT 1');
   $consulta->execute(array(
     ':usuario' => $usuario
   ));

   $resultado = $consulta->fetch();

   if($resultado == true){
     if ($resultado['pass'] == $pass) {
       $_SESSION['id'] = $resultado['id_usuario'];
       $_SESSION['usuario'] = $usuario;
       header('Location:home.php');
     }else{
        $errores = 'El usuario o contraseña es incorrecto';
     }
   }else{
     $errores = 'Al parecer no estas registrado! <a href="registrate.php"> Registrate</a>';
   }

 }

 require 'views/login.view.php';
?>
