<?php require 'views/headlayout.view.php'; ?>
<div class="container">
  <!-- INFORMAR NUEVAS NOTICIAS
  <div class="alert alert-info alert-dismissable" style='margin-top:2%;'>
    <button type="button" class='close' data-dismiss='alert'>&times;</button>
    <strong>Nueva Actualizacion!</strong> ahora vas a poder cambiar tu informacion de usuario.
  </div>

-->
  <div class="jumbotron text-center jumbo-home ">
    <h1 >Bienvenido <strong><?php echo $_SESSION['usuario'];?></strong></h1>
    <h2>Tu saldo actual es de <span class='saldo'> $<?php echo $montoActual ;?></span></h2>
    <br>
    <a href='nuevoingresogasto.php?tipo=ingresos' class='btn btn-success'>Nuevo Ingreso</a>
    <a href='nuevoingresogasto.php?tipo=gastos' class='btn btn-danger'>Nuevo Gasto</a>
  </div>
</div>
<?php require 'views/bottomlayout.view.php'; ?>
