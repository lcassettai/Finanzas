<?php require 'headlayout.view.php'; ?>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<div class="modal-loading"></div>
<div class="container">
  <div class="row">
    <div class="col-sm-5 col-sm-offset-4">
        <!--Dependiendo de si es ingreso o gasto cambiamos el titulo-->
        <?php if ($tipo == 'ingresos'): ?>
          <div class="panel panel-ingreso">
          <h1 class='text-center gfont'>Editar Ingreso</h1>
        <?php else: ?>
          <div class="panel panel-gasto">
          <h1 class='text-center gfont'>Editar Gasto</h1>
        <?php endif; ?>
        <form class='form' action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']).'?tipo='.$tipo.'&codigo='.$codigo; ?>" method="post">
          <input type="hidden" name='codigo' value='<?php echo $codigo;?>'>
          <div class="form-group">
            <label for="monto">Ingrese un monto:</label>
            <input type="text" name="monto" placeholder="monto" class='form-control' id='monto' value='<?php echo $montoAnterior; ?>' >
          </div>
          <div class="form-group">
            <label for="fecha">Ingrese una fecha:</label>
            <input type="text" id="datepicker" name='fecha' class='form-control' value='<?php echo fecha($fecha)  ;?>'>
          </div>
          <div class="form-group">
            <label for="opciones">Categoria:</label>
              <!--Si obtiene datos para cargar los combos los carga sino muestra error-->
              <?php if ($tipo_ingresos == true ): ?>
                <select class='form-control'name="categoria" id="opciones">
                    <!--Llena el combo con los datos de ingresos o gastos-->
                    <?php foreach ($tipo_ingresos as $tipo): ?>
                      <?php if ($tipo[0] == $catAnterior): ?>
                        <option value='<?php echo $tipo[0]; ?>' selected><?php echo $tipo[1];?></option>
                      <?php else: ?>
                        <option value='<?php echo $tipo[0]; ?>'><?php echo $tipo[1];?></option>
                      <?php endif; ?>

                    <?php endforeach; ?>
                </select>
            <?php else:?>
              <select class='form-control' disabled name="categoria" id="opciones">
                <option class='disabled'>Error al conectar a la Base de Datos</option>
              </select>
            <?php endif; ?>
          </div>
          <div class="form-group">
            <label for="comentario">Comentario :</label>
            <textarea name="comentario" class='form-control' placeholder="Comentario" id='comentario' rows="6"><?php echo $comentarioAnterior; ?></textarea>
          </div>
          <?php if ($errores != ''): ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Error! </strong><?php echo $errores; ?>
          </div>
          <?php endif; ?>
          <div class="form-group clearfix">
              <a href="historial.php" class='btn btn-primary'>Cancelar</a>
            <?php if ($tipoAux == 'ingreso'): ?>
                <input type="submit" name="submit" value="Guardar" class='btn btn-success pull-right'>
            <?php else: ?>
                <input type="submit" name="submit" value="Guardar" class='btn btn-danger pull-right'>
            <?php endif; ?>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- modal oara avisar que se creo el usuario  -->
<div class="modal fade" id="modal-aviso" role="dialog" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog">
 <!-- Modal content-->
 <div class="modal-content">
   <div class="modal-body  text-center modal-aviso-body">
     <div class="circulo-icono">
         <span class='glyphicon glyphicon-ok'></span>
         </div>
         <h3><strong>Excelentes Noticias!</strong></h3>
         <br />
         <h4>Se edito correctamente!</h4>
         <br />
         <a type="button" href='historial.php' class="btn btn-success modal-aviso">Continuar</a>
       </div>
     </div>
     </div>
</div>

<?php require 'bottomlayout.view.php'; ?>

<script type="text/javascript">
  var loading = $('.modal-loading');
  $('document').ready(function(){
    //Si todos los campos son correctos mostrar modal avisando al usuario
    <?php if($enviado == true):?>
      //Ocultamos el gif de carga
      $(loading).css('display','none');
      $("#modal-aviso").modal();
    <?php endif ?>

    $( function() {
      $( "#datepicker" ).datepicker();
    });
    $(loading).css('display','none');

    //Al hacer click en submit mostrar el gif de carga
    $("input[name='submit']").click(function(){
      $(loading).css('display','block');
    });
  });
</script>
<script src="javascript/jqueryUI.js"></script>
