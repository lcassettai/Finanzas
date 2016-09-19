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

  if(isset($_GET['tipo'])){
    $tipo = $_GET['tipo'];
    $codigo = $_GET['codigo'];
  }

  if($_SERVER['REQUEST_METHOD'] == 'GET'){
    if(isset($_GET['codigo']) && isset($_GET['tipo'])){
      $codigo = $_GET['codigo'];
      $tipo = $_GET['tipo'];
    }else{
      header('Location:error.php');
    }
  }

  #Dependiendo si es un ingreso o gasto vamos a obtener los valores para
  #Rellenar el combobox
  $tipo_ingresos = obtener_tipo_ingresos_gastos($conexion,$tipo);

  $usuario = $_SESSION['id'];

  $tipoAux = substr ($tipo, 0, strlen($tipo) - 1);

  $resultados = $conexion->query("SELECT cod_$tipoAux,monto,comentario,id_tipo_$tipoAux,fecha FROM $tipo WHERE id_usuario = $usuario AND cod_$tipoAux = $codigo LIMIT 1");
  foreach($resultados as $fila){
    $montoAnterior =  $fila['monto'];
    $catAnterior = $fila["id_tipo_$tipoAux"];
    $comentarioAnterior = $fila['comentario'];
    $fecha = $fila['fecha'];
  }

  if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(!empty($_POST['monto'])){
      $monto =  limpiarInput($_POST['monto']);
      $monto = round($monto,2);
      if(!is_numeric($monto)){
          $errores .= '<li>El monto debe ser numerico</li>';
      }
      if($monto > 999999){
          $errores .= '<li>El monto no puede ser mayor a $999.999</li>';
      }
      if($monto < 0){
          $errores .= '<li>El monto no puede ser negativo</li>';
      }
    }else{
      $errores = '<li>Debe ingresar un monto</li>';
    }

    if(!empty($_POST['comentario'])){
      $comentario = $_POST['comentario'];
      $comentario = limpiarInput($comentario);
      if(strlen($comentario) > 130){
        $errores .= '<li>El comentario no puede ser mayor a 130 caracteres</li>';
      }
    }else{
      $comentario  = '';
    }

    if(!empty($_POST['fecha'])){
      $fecha = $_POST['fecha'];
      if(validarFecha($fecha)){
        $myDateTime = DateTime::createFromFormat('d/m/Y', $fecha);
        $fechaFormat = $myDateTime->format('Y-m-d');
      }else{
        $errores = '<li>La fecha introducida es incorrecta</li>';
      }

    }else{
      $errores = '<li>Debe ingresar una fecha</li>';
    }

    if(!empty($_POST['categoria'])){
        $categoria = $_POST['categoria'];
        if (!is_numeric($categoria)) {
          $errores = '<li>La categoria no es correcta</li>';
        }
    }else{
      $errores = '<li>Debe seleccionar una categoria</li>';
    }

    if($errores == ''){
      if ($tipo == 'ingresos') {
        $consulta = $conexion->prepare(
        'UPDATE ingresos
         SET monto = :monto, id_tipo_ingreso = :categoria,comentario = :comentario, fecha = :fecha
         WHERE id_usuario = :usuario AND cod_ingreso = :codigo'
        );
      }else{
        $consulta = $conexion->prepare(
        'UPDATE gastos
         SET monto = :monto, id_tipo_gasto = :categoria,comentario = :comentario,fecha = :fecha
         WHERE id_usuario = :usuario AND cod_gasto = :codigo'
        );
      }

     $consulta->execute(array(
       ':monto' => $monto,
       ':categoria' => $categoria,
       ':comentario' => $comentario,
       ':usuario' => $usuario,
       ':codigo' => $codigo,
       ':fecha' => $fechaFormat
     ));

     $enviado = true;

    }
  }




  require 'views/singleEdit.view.php';
?>
