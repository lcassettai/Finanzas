<?php
session_start();
require '../admin/config.php';
require '../funciones.php';

verificarSesion();

$conexion = conectar($bd_conexion);

if($conexion == false){
  echo 'Error al intentar conectar a la base de datos';
  header('Location:error.php');
}

$id = $_SESSION['id'];

$consulta = $conexion->prepare('SELECT sum(monto) AS monto,tipo_gasto as tipo,month(fecha) as mes,year(fecha) as ano
FROM gastos g INNER JOIN tipo_gastos tg ON g.id_tipo_gasto = tg.id_tipo_gasto
WHERE id_usuario = :id AND month(fecha) = month(curdate()) AND year(curdate()) = year(fecha)
GROUP BY tipo_gasto,month(fecha),year(fecha)
');
$consulta->execute(array(
  ':id' => $id
));

$resultado = $consulta->fetchAll();


$json = '{
  "cols": [
        {"id":"","label":"Tipo de gasto","pattern":"","type":"string"},
        {"id":"","label":"Monto","pattern":"","type":"number"}
      ],
  "rows": [';

  foreach ($resultado as $movimiento){
    $json .= '{"c":[{"v":"'.$movimiento['tipo'].'","f":null},{"v":'.$movimiento['monto'].',"f":null}]},';
  }

$json .= ']}';


echo $json;

?>
