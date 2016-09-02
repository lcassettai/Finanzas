<?php require 'headlayout.view.php';?>
<div class="container">
  <h1 class='text-center gfont'>Configuracion</h1>

  <div class="panel panel-config config-info-modificar col-md-6 col-md-offset-3">
    <!-- Informacion del usuario a mostrar -->
    <div class="info-usuario-visible" id='ver-datos'>
    <h4 class='titulo-config'>Informacion de usuario</h4>
      <p>
        <strong>Usuario</strong> : <?php echo $resultado['usuario'];?>
      <br>
        <strong>Correo electronico</strong> : <?php echo $resultado['email'];?>
      <br>
        <strong>Password</strong> : **********
      <br>
      <br>
        <button type="button" id='modificar' class='btn btn-success'>Modificar</button>
      </p>
    </div>

      <!-- Formulario para modificar informacion -->
    <div class="info-usuario-invisible" id='modificar-datos'>
      <h4 class='titulo-config'>Modificar informacion</h4>
      <form class="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" autocomplete="off">
        <div class="form-group">
          <label for="user">Usuario :</label>
          <input type="text" id='user' class='form-control' name="user" value='<?php echo $resultado['usuario'];?>'>
        </div>
        <div class="form-group">
          <label for="email">Email :</label>
          <input type="email" id='email' class='form-control' name="email" value='<?php echo $resultado['email'];?>'>
        </div>
        <div class="form-group">
          <label for="passnueva">Nueva Contraseña :</label>
          <input type="password" id='passnueva' class='form-control' name="passnueva">
        </div>
        <div class="form-group">
          <label for="passactual">Contraseña Actual :</label>
          <input type="password" id='passactual' class='form-control' name="passactual">
        </div>
        <div class="form-group clearfix">
          <button type="button" class='btn btn-primary' id='cancelar-modif'> Cancelar</button>
          <input type="submit" id='submit' class='btn btn-success pull-right' name="submit" value='Guardar'>
        </div>
      </form>
    </div>
    <!-- Si obtenemos errores se listanar debajo del formulario -->
    <?php if($errores != ''):?>
    <div class="alert alert-danger alert-dismissable" style='margin-top:2%;'>
      <button type="button" class='close' data-dismiss='alert'>&times;</button>
      <strong>Corregir los siguiente errores :</strong>
      <ul>
        <?php echo $errores;?>
      </ul>
    </div>
    <?php endif;?>
      <div class="clearfix visible-xs-block"></div>
  </div>

</div>



<?php require 'bottomlayout.view.php' ;?>
<script type="text/javascript">
  $('#modificar').click(function(){
    $('#ver-datos').removeClass('info-usuario-visible');
    $('#ver-datos').addClass('info-usuario-invisible');

    $('#modificar-datos').removeClass('info-usuario-invisible');
    $('#modificar-datos').addClass('info-usuario-visible');
  });

  $('#cancelar-modif').click(function(){
    $('#modificar-datos').removeClass('info-usuario-visible');
    $('#modificar-datos').addClass('info-usuario-invisible');

    $('#ver-datos').removeClass('info-usuario-invisible');
    $('#ver-datos').addClass('info-usuario-visible');
  });


</script>
