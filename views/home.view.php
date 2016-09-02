<?php require 'views/headlayout.view.php'; ?>
<div class="container">
  <div class="alert alert-info alert-dismissable" style='margin-top:2%;'>
    <button type="button" class='close' data-dismiss='alert'>&times;</button>
    <strong>Info!</strong>Esta es una version beta y puede que surjan algunos errores, si queres ayudar a mejorar la pagina podes enviar un correo a <strong>luciano.cassettai@gmail.com</strong> contando que hiciste antes de ocurriera el error. Muchas gracias!
  </div>
  <div class="jumbotron text-center jumbo-home ">
    <h1 >Bienvenido <strong><?php echo $_SESSION['usuario'];?></strong></h1>
    <h2>Tu saldo actual es de <span class='saldo'> $<?php echo $montoActual ;?></span></h2>
    <br>
    <a href='nuevoingresogasto.php?tipo=ingresos' class='btn btn-success'>Nuevo Ingreso</a>
    <a href='nuevoingresogasto.php?tipo=gastos' class='btn btn-danger'>Nuevo Gasto</a>
  </div>
</div>
<?php require 'views/bottomlayout.view.php'; ?>
