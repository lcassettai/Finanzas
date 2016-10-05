<?php require 'headlayout.view.php'; ?>
<!-- Modal que mostrara gif de carga -->
<div class="modal-loading"></div>
<div class="container">
  <div class="row">
    <div class="col-sm-5 col-sm-offset-4">
        <!--Dependiendo de si es ingreso o gasto cambiamos el titulo-->
        <?php if ($nuevo_tipo == 'ingresos'): ?>
          <div class="panel panel-ingreso">
          <h1 class='text-center gfont'>Nuevo Ingreso</h1>
        <?php else: ?>
          <div class="panel panel-gasto">
          <h1 class='text-center gfont'>Nuevo Gasto</h1>
        <?php endif; ?>

        <!-- Formulario -->
        <form class='form' action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']).'?tipo='.$nuevo_tipo; ?>" method="post">
          <input type="hidden" value="<?php echo $nuevo_tipo;?>" name='nuevo_tipo'>
          <div class="form-group">
            <label for="monto">Ingrese un monto:</label>
            <input type="text" name="monto" placeholder="monto" class='form-control' id='monto' >
          </div>
          <div class="form-group">
            <label for="opciones">Categoria:</label>
              <!--Si obtiene datos para cargar los combos los carga sino muestra error-->
              <?php if ($tipo_ingresos == true ): ?>
                <select class='form-control'name="categoria" id="opciones">
                    <!--Llena el combo con los datos de ingresos o gastos-->
                    <?php foreach ($tipo_ingresos as $tipo): ?>
                      <option value='<?php echo $tipo[0]; ?>'><?php echo $tipo[1];?></option>
                    <?php endforeach; ?>
                </select>
            <?php else:?>
              <select class='form-control' disabled name="categoria" id="opciones">
                <option class='disabled'>Error al conectar a la Base de Datos</option>
              </select>
            <?php endif; ?>
          </div>
          <div class="form-group clearfix">
            <label for="comentario">Comentario :</label>
            <textarea name="comentario" class='form-control' placeholder="Comentario" id='comentario' rows="6" pattern="[a-zA-Z0-9]"></textarea>
            <p class='pull-right text-success' id='contador'></p>
          </div>

          <!-- En caso de tener errores los muestra -->
          <?php if ($errores != ''): ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Error! </strong><?php echo $errores; ?>
          </div>
          <?php endif; ?>
          <div class="form-group clearfix">
              <a href="home.php" class='btn btn-primary'>Cancelar</a>
            <?php if ($nuevo_tipo == 'ingresos'): ?>
                <input type="submit" name="submit" value="Guardar" class='btn btn-success pull-right'>
            <?php else: ?>
                <input type="submit" name="submit" value="Guardar" class='btn btn-danger pull-right' >
            <?php endif; ?>
          </div>
        </form>
      </div>
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
         <h4>Se agrego correctamente!</h4>
         <br />
         <a type="button" href='home.php' class="btn btn-success modal-aviso">Continuar</a>
       </div>
     </div>
     </div>
</div>

<?php require 'bottomlayout.view.php'; ?>
<script type="text/javascript">

//Funcion para limitar caracteres
(function($) {
	$.fn.extend( {
		limiter: function(limit, elem) {
			$(this).on("keyup focus", function() {
				setCount(this, elem);
			});
			function setCount(src, elem) {
				var chars = src.value.length;
				if (chars > limit) {
					src.value = src.value.substr(0, limit);
					chars = limit;
				}
				elem.html(chars + "/130");
			}
			setCount($(this)[0], elem);
		}
	});
})(jQuery);

  $('document').ready(function(){
    //Si todos los campos son correctos mostrar modal avisando al usuario
    <?php if($enviado == true):?>
      //Ocultamos el gif de carga
      $(loading).css('display','none');
      $("#modal-aviso").modal();
    <?php endif ?>
    var loading = $('.modal-loading');
    $(loading).css('display','none');

    //Al hacer click en submit mostrar el gif de carga
    $("input[name='submit']").click(function(){
      $(loading).css('display','block');
    });

    //Muestra un contador para que no supere las 130 palabra
    var contador = $("#contador");
    $("#comentario").limiter(130, contador);

  });
</script>
