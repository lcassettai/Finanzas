<?php  require 'headlayout.view.php';?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">

  <div class="container">
    <h1 class='text-center gfont'>Historial</h1>
    <div class="row">
      <div class="col-sm-8 col-sm-offset-2 ">
        <!--FILTRO-->
        <a href="#filtro" class="btn btn-primary" style='margin:10px 0px;' data-toggle="collapse"><span class='glyphicon glyphicon-filter'></span> Filtrar Busqueda</a>
        <div id="filtro" class="collapse panel panel-filtro-historial">
          <form class="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
            <div class="form-group">
              <label for="desde">Desde :</label>
              <div class="input-group">
                <span class="input-group-addon" id="basic-addon1"><span class='glyphicon glyphicon-calendar'></span></span>
                <input id='datedesde' type="text" class="form-control" placeholder="DD/MM/AAAA" name='fechadesde' aria-describedby="basic-addon1">
              </div>
            </div>
            <div class="form-group">
              <label for="hhasta">Hasta :</label>
              <div class="input-group">
                <span class="input-group-addon" id="basic-addon1"><span class='glyphicon glyphicon-calendar'></span></span>
                <input  id="datehasta" type="text" class="form-control" placeholder="DD/MM/AAAA" name='fechahasta' aria-describedby="basic-addon1">
              </div>
            </div>
            <div class="form-group clearfix">
              <input type="submit" name="submit" value="Filtrar" class='btn btn-success pull-right'>
            </div>
          </form>
        </div>

        <?php if ($errores != ''): ?>
          <div class="alert alert-danger fade in">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Error!</strong><ul> <?php echo $errores; ?></ul>
          </div>
        <?php endif; ?>

        <div class="panel panel-historial table-responsive">
          <table class='table table-striped table-hover'>
            <thead>
              <tr>
                <th>Nro</th>
                <th>Monto</th>
                <th>Fecha</th>
                <th>Categoria</th>
                <th>Comentario</th>
                <th>Administrar</th>
              </tr>
            </thead>
            <tbody>
              <?php if ($resultados == true): ?>
                <?php foreach ($resultados as $movimiento): ?>
                  <?php if ($movimiento['tipo'] == 'ingreso'  ): ?>
                    <tr class='success'>
                  <?php else:?>
                    <tr class='danger'>
                  <?php endif; ?>
                    <td><?php echo $movimiento['cod_ingreso'];  ?></td>
                    <td><?php echo '$'.$movimiento['monto'];  ?></td>
                    <td><?php echo fecha($movimiento['fecha']);  ?></td>
                    <td><?php echo $movimiento['tipo_ingreso'];  ?></td>
                    <?php if (strlen($movimiento['comentario']) >= 30): ?>
                      <td><?php echo substr($movimiento['comentario'], 0, 30).'...';  ?></td>
                    <?php else: ?>
                      <?php if (strlen($movimiento['comentario']) == 0): ?>
                          <td>-</td>
                      <?php else: ?>
                        <td><?php echo $movimiento['comentario'];  ?></td>
                      <?php endif; ?>
                    <?php endif; ?>
                    <td>
                      <a href="#" style='color:#333'><span class='glyphicon glyphicon-eye-open' title='Ver' data-toggle="modal" data-target="#modalVer<?php echo $movimiento['cod_ingreso'];  ?>"></span></a>
                      <a href="singleEdit.php?codigo=<?php echo $movimiento['cod_ingreso'].'&tipo='.$movimiento['tipo'];?>s" style='color:#4caf50; margin:0px 5px'><span class='glyphicon glyphicon-pencil' title='Editar' ></span></a>
                      <a href="#" style='color:#f44336'><span class='glyphicon glyphicon-trash' title='Eliminar' data-toggle="modal" data-target="#modalEliminar<?php echo $movimiento['cod_ingreso'];  ?>"></span></a>
                    </td>
                  </tr>
                  <!-- Modal para editar un elemento  -->
                  <div id="modalEditar<?php echo $movimiento['cod_ingreso'];  ?>" class="modal fade" role="dialog" class='modalEliminar'>
                    <div class="modal-dialog">
                      <!-- Modal content-->
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title text-center"><strong>Editar</strong></h4>
                        </div>
                        <div class="modal-body">
                          <p>Esta seguro que desea eliminar el movimiento Nro <strong><?php echo $movimiento['cod_ingreso'];  ?></strong>? El monto es de <?php echo '$'.$movimiento['monto']?></p>
                        </div>
                        <div class="modal-footer">
                          <form action="eliminar.php" method="post">
                              <?php if ($movimiento['tipo'] == 'ingreso'  ): ?>
                                <input type="hidden" name='tipo' value="ingresos">
                              <?php else: ?>
                                <input type="hidden" name='tipo' value="gastos">
                              <?php endif; ?>
                            <input type="hidden" name='codigo' value="<?php echo $movimiento['cod_ingreso'];  ?>">
                            <input type='submit' id='submit' class='btn btn-danger' value='Eliminar'>
                          </form>
                          <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        </div>
                      </div>
                    </div>
                  </div>

<!-- MODALES-->
                  <!-- Modal para eliminar un elemento  -->
                  <div id="modalEliminar<?php echo $movimiento['cod_ingreso'];  ?>" class="modal fade" role="dialog" class='modalEliminar'>
                    <div class="modal-dialog">
                      <!-- Modal content-->
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title text-center"><strong>Eliminar</strong></h4>
                        </div>
                        <div class="modal-body">
                          <p>Esta seguro que desea eliminar el movimiento Nro <strong><?php echo $movimiento['cod_ingreso'];  ?></strong>? El monto es de <?php echo '$'.$movimiento['monto']?></p>
                        </div>
                        <div class="modal-footer">
                          <form action="eliminar.php" method="post">
                              <?php if ($movimiento['tipo'] == 'ingreso'  ): ?>
                                <input type="hidden" name='tipo' value="ingresos">
                              <?php else: ?>
                                <input type="hidden" name='tipo' value="gastos">
                              <?php endif; ?>
                            <input type="hidden" name='codigo' value="<?php echo $movimiento['cod_ingreso'];  ?>">
                            <input type='submit' id='submit' class='btn btn-danger' value='Eliminar'>
                          </form>
                          <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Modal para ver en detalle un elemento  -->
                  <div id="modalVer<?php echo $movimiento['cod_ingreso'];  ?>" class="modal modelVer fade" role="dialog" class='modalVer'>
                    <div class="modal-dialog">
                      <!-- Modal content-->
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title text-center"><strong>Movimiento Nro <?php echo $movimiento['cod_ingreso'];  ?></strong></h4>
                        </div>
                        <div class="modal-body">
                          <p>
                            <strong>Tipo de movimiento: </strong> <span><?php echo $movimiento['tipo'];?></span>
                          </p>
                          <p>
                            <strong>Monto : </strong><span><?php echo '$'.$movimiento['monto']; ?></span>
                          </p>
                          <p>
                            <strong>Fecha : </strong><span><?php echo fecha_con_nombres($movimiento['fecha']); ?></span>
                          </p>
                          <p>
                            <strong>Hora : </strong><span><?php echo hora($movimiento['fecha']); ?></span>
                          </p>
                          <p>
                            <strong>Categoria : </strong><span><?php echo $movimiento['tipo_ingreso']; ?></span>
                          </p>
                          <p>
                            <strong>Comentario : </strong><span style='word-wrap: break-word;'><?php echo $movimiento['comentario']; ?></span>
                          </p>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        </div>
                      </div>
                    </div>
                  </div>

                <?php endforeach;?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>


      </div>
    </div>
  </div>



<!--PAGINACION -->
  <?php if ($resultados == true): ?>
    <div class="container">
        <div class="text-center">
          <ul class="pagination">
            <?php if ($pagina == 1): ?>
           <li class="disabled"><a href="#">&laquo;</a></li>
            <?php else: ?>
            <li><a href="?pagina=<?php echo $pagina - 1; ?>">&laquo;</a></li>
            <?php endif; ?>
            <?php
              for ($i=1; $i <= $numeroPaginas ; $i++) {
                if($pagina == $i){
                  echo "<li class='active'><a href='?pagina=$i'>$i</a></li>";
                }else{
                  echo "<li><a href='?pagina=$i'>$i</a></li>";
                }
              }
            ?>
            <?php if ($pagina == $numeroPaginas): ?>
              <li class="disabled"><a href="#">&raquo;</a></li>
            <?php else: ?>
              <li><a href="?pagina=<?php echo $pagina + 1; ?>">&raquo;</a></li>
            <?php endif; ?>
          </ul>
      </div>
    </div>
  <?php endif; ?>



<?php  require 'bottomlayout.view.php';?>

<script type="text/javascript">
  $( function() {
    $( "#datedesde" ).datepicker();
    $( "#datehasta" ).datepicker();
  });
</script>

<script src="javascript/jqueryUI.js"></script>
