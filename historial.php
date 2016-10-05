<?php
  session_start();
  require 'admin/config.php';
  require 'funciones.php';
  $errores = '';
  $filtrar = false;

  verificarSesion();

  $conexion = conectar($bd_conexion);

  if($conexion == false){
    header('Location:error.php');
  }

  $id_usuario = $_SESSION['id'];

  if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(!empty($_POST['fechadesde'])){
      $fecha_desde = $_POST['fechadesde'];
      if(validarFecha($fecha_desde)){
        $myDateTime = DateTime::createFromFormat('d/m/Y',$fecha_desde);
        $fechaFormatDesde = $myDateTime->format('Y-m-d');
      }else{
        $errores .= '<li>La fecha "Desde" introducida es incorrecta</li>';
      }
    }

    if(!empty($_POST['fechahasta'])){
      $fecha_hasta = $_POST['fechahasta'];
      if(validarFecha($fecha_hasta)){
        $myDateTime = DateTime::createFromFormat('d/m/Y',$fecha_hasta);
        $fechaFormatHasta = $myDateTime->format('Y-m-d');
      }else{
        $errores .= '<li>La fecha "Hasta" introducida es incorrecta</li>';
      }
    }

    $filtrar  = true;
  }

  $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
  $postPorPagina = 15;
  $inicio = ($pagina > 1) ? ($pagina * $postPorPagina - $postPorPagina) : 0;

  #$saldo = obtener_monto_actual($conexion,$id_usuario);

  if($errores == '' && $filtrar == true){
    $consulta = $conexion->prepare("SELECT SQL_CALC_FOUND_ROWS cod_ingreso,monto,fecha,tipo_ingreso,comentario,ti.id_tipo_ingreso,'ingreso' as tipo
                                    FROM ingresos i,tipo_ingresos ti
                                    WHERE i.id_tipo_ingreso = ti.id_tipo_ingreso AND id_usuario = :id_usuario AND fecha BETWEEN :fechaFormatDesde AND :fechaFormatHasta
                                    UNION
                                    SELECT cod_gasto,monto,fecha,tipo_gasto,comentario,tg.id_tipo_gasto,'gasto' as tipo
                                    FROM gastos g,tipo_gastos tg
                                    WHERE g.id_tipo_gasto = tg.id_tipo_gasto AND id_usuario = :id_usuario AND fecha BETWEEN :fechaFormatDesde  AND :fechaFormatHasta
                                    ORDER BY fecha DESC
                                    LIMIT $inicio,$postPorPagina"
                                    );
    $consulta->execute(array(
    ':id_usuario' => $id_usuario,
    ':fechaFormatDesde' => $fechaFormatDesde,
    ':fechaFormatHasta' => $fechaFormatHasta
    ));
  }else{
    $consulta = $conexion->prepare("SELECT SQL_CALC_FOUND_ROWS cod_ingreso,monto,fecha,tipo_ingreso,comentario,ti.id_tipo_ingreso,'ingreso' as tipo
                                    FROM ingresos i,tipo_ingresos ti
                                    WHERE i.id_tipo_ingreso = ti.id_tipo_ingreso AND id_usuario = :id_usuario
                                    UNION
                                    SELECT cod_gasto,monto,fecha,tipo_gasto,comentario,tg.id_tipo_gasto,'gasto' as tipo
                                    FROM gastos g,tipo_gastos tg
                                    WHERE g.id_tipo_gasto = tg.id_tipo_gasto AND id_usuario = :id_usuario
                                    ORDER BY fecha DESC
                                    LIMIT $inicio,$postPorPagina"
                                    );

    $consulta->execute(array(
    ':id_usuario' => $id_usuario
    ));
  }



  $resultados = $consulta->fetchAll();

  //Obtener la cantidad de paginas
  $totalArticulos = $conexion->query('SELECT FOUND_ROWS() as total ');
  $totalArticulos = $totalArticulos->fetch()['total'];

  $numeroPaginas= ceil($totalArticulos / $postPorPagina);

  $consulta_tipo_gastos = $conexion->prepare("SELECT * FROM tipo_gastos ORDER BY 2");
  $consulta_tipo_gastos->execute();

  $tipo_gasto = $consulta_tipo_gastos->fetchAll();


  require 'views/historial.view.php';
?>
