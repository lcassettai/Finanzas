<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/home.css">
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-sm-4 col-sm-offset-4 login panel panel-default">
          <h1 class='text-center gfont'>Nuevo Usuario</h1>
          <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><span class='glyphicon glyphicon-user'></span></span>
                <input type="text" name="usuario" id='usuario' class='form-control' placeholder="Usuario" value='<?php if(!$enviado && isset($usuario)){echo $usuario;}; ?>'>
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><span class='glyphicon glyphicon-envelope'></span></span></span>
                <input type="email" name="email" id='email' class='form-control' placeholder="Email" value='<?php if(!$enviado && isset($email)){echo $email;}; ?>'>
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><span class='glyphicon glyphicon-lock'></span></span>
                  <input type="password" name="pass" id='pass' class='form-control' placeholder="Contraseña">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><span class='glyphicon glyphicon-lock'></span></span>
                  <input type="password" name="pass2" id='pass2' class='form-control' placeholder="Repetir contraseña">
              </div>
            </div>
            <div class="checkbox">
              <label>
                <input type="checkbox" id='mostrar' value="">  Mostrar contraseñas
              </label>
            </div>
            <?php if ($errores != ''): ?>
              <div class="alert alert-danger alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Corregir los siguiente errores :</strong> <?php echo $errores; ?>
            </div>
            <?php endif; ?>
            <div class="form-group pull-right">
              <input type="submit" name="submit" value="Entrar" class='btn btn-danger'>
            </div>
            <div class="clearfix visible-xs-block"></div>
          </form>

        </div>
      </div>
      <div class="row">
        <div class="col-sm-12 text-center">
          <h4>¡Ya tengo una cuenta! <a href="login.php">Iniciar Sesion</a></h4>
        </div>
      </div>
    </div>


    <!-- modal oara avisar que se creo el usuario  -->
    <div class="modal fade" id="modal-aviso" role="dialog">
      <div class="modal-dialog">
     <!-- Modal content-->
     <div class="modal-content">
       <div class="modal-body  text-center modal-aviso-body">
         <div class="circulo-icono">
             <span class='glyphicon glyphicon-ok'></span>
             </div>
             <h3><strong>Excelentes Noticias!</strong></h3>
             <br />
             <h4>Se creo tu usuario correctamente!</h4>
             <br />
             <a type="button" href='login.php' class="btn btn-success modal-aviso">Continuar</a>
           </div>
         </div>
         </div>
       </div>

    <script src="javascript/jquery.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript">
      $('document').ready(function(){
        $('#mostrar').change(function(){
          if($('#pass').attr('type') == 'password'){
            $('#pass').attr('type','text');
            $('#pass2').attr('type','text');
        }else{
          $('#pass').attr('type','password');
          $('#pass2').attr('type','password');
        }
        });

        <?php if($enviado == true):?>
          $("#modal-aviso").modal();
        <?php endif ?>
      });
    </script>
    </body>
    </html>

  </body>
</html>
