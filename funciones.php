<?php
  function conectar($bd_conexion){
    try {
      $conexion = new PDO('mysql:host=127.0.0.1;dbname='.$bd_conexion['bd'],$bd_conexion['usuario'],$bd_conexion['pass']);
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

  function obtener_monto_actual($conexion,$id){
    $sql = 'SELECT SUM(monto) as monto FROM ingresos WHERE id_usuario = :id' ;
    $consulta = $conexion->prepare($sql);
    $consulta->execute(array(
      ':id'  => $id
    ));
    $resultado = $consulta->fetch();
    $montoActual = 0;

    if($resultado == true){
      $montoActual = $resultado['monto'];
      if(empty($montoActual)){
        $montoActual = 0;
      }
    }

    $sql = 'SELECT SUM(monto) as monto FROM gastos WHERE id_usuario = :id' ;
    $consulta = $conexion->prepare($sql);
    $consulta->execute(array(
      ':id'  => $id
    ));
    $resultado = $consulta->fetch();

    if($resultado == true){
      $montoActual -= $resultado['monto'];
    }

    return $montoActual;
  }

  function obtener_tipo_ingresos_gastos($conexion,$ingreso_gasto){
    $consulta = $conexion->prepare('SELECT * FROM tipo_'.$ingreso_gasto);
    $consulta->execute();
    $resultado = $consulta->fetchAll();
    return $resultado;
  }

  function fecha($fecha){
    $timestamp = strtotime($fecha); //Convierte una cadena de texto en tiempo

    $dia = date('d',$timestamp);
    $mes = date('m',$timestamp);
    $year = date('Y',$timestamp);

    $fecha = "$dia/" . $mes . "/$year";

    return $fecha;
  }

  function fecha_con_nombres($fecha){
    $timestamp = strtotime($fecha); //Convierte una cadena de texto en tiempo
    $meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];

    $dia = date('d',$timestamp);
    $mes = date('m',$timestamp)-1;
    $year = date('Y',$timestamp);


    $fecha = "$dia de " . $meses["$mes"] . " del $year";

    return $fecha;
  }

  function hora($fecha){
    $timestamp = strtotime($fecha); //Convierte una cadena de texto en tiempo

    $hora = date('G',$timestamp);
    $minutos = date('i',$timestamp);

    $horario = "$hora:$minutos Hs";

    return $horario;
  }

  function validarFecha($fecha){
    $fec = explode("/",$fecha);
    if(isset($fec[0]) && isset($fec[1]) && isset($fec[2])){
      if(is_numeric($fec[0]) && is_numeric($fec[1]) && is_numeric($fec[2])){
        return checkdate($fec[1],$fec[0],$fec[2]);  #Mes Dia Ano
      }else{
        return false;
      }
    }else{
      return false;
    }
  }


?>
