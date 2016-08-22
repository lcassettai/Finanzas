<?php
  session_start();
  require 'admin/config.php';
  require 'funciones.php';

  verificarSesion();

  $conexion = conectar($bd_conexion);

  if($conexion == false){
    header('Location:error.php');
  }

  $id_usuario = $_SESSION['id'];


  $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
  $postPorPagina = 15;
  $inicio = ($pagina > 1) ? ($pagina * $postPorPagina - $postPorPagina) : 0;

  $saldo = obtener_monto_actual($conexion,$id_usuario);

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

  $resultados = $consulta->fetchAll();

  //Obtener la cantidad de paginas
  $totalArticulos = $conexion->query('SELECT FOUND_ROWS() as total ');
  $totalArticulos = $totalArticulos->fetch()['total'];

  $numeroPaginas= ceil($totalArticulos / $postPorPagina);

  require 'views/historial.view.php';
?>
