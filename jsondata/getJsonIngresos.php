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

$consulta = $conexion->prepare('SELECT month(fecha) as "mes",sum(monto) as "monto" FROM ingresos WHERE id_usuario = :id  group by month(fecha);');
$consulta->execute(array(
  ':id' => $id
));

$resultado = $consulta->fetchAll();


$json = '{
  "cols": [
        {"id":"","label":"Mes","pattern":"","type":"string"},
        {"id":"","label":"Monto","pattern":"","type":"number"}
      ],
  "rows": [';

  foreach ($resultado as $movimiento){
    $json .= '{"c":[{"v":"'.number_to_month($movimiento['mes']).'","f":null},{"v":'.$movimiento['monto'].',"f":null}]},';
  }

$json .= ']}';


echo $json;

?>
