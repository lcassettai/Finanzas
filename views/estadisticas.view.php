<?php require 'headlayout.view.php';?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript">
function drawChart() {
  var loading = $('.modal-loading');

  //Solicitud del json con los datos de la BD
  var jsonIngresos = $.ajax({
      url: "jsondata/getJsonIngresos.php",
      dataType: "json",
      async: false
      }).responseText;

  var jsonGastos = $.ajax({
      url: "jsondata/getJsonGastos.php",
      dataType: "json",
      async: false
      }).responseText;

  var jsonTipoGastos = $.ajax({
      url: "jsondata/getJsonTipoGastos.php",
      dataType: "json",
      async: false
      }).responseText;

  //Opciones de estilo para cada grafico
  var opcionesIngresos = {
      title: 'Ingresos del año en curso',
      series: {
        0: { color: '#6f9654' }
      }
    };

  var opcionesGastos = {
      title: 'Gastos del año en curso',
      series: {
        0: { color: '#c9302c' }
      }
    };

  var opcionesTipoGastos = {
      title: 'Gastos del mes en curso',
      is3D: true
    };

  /*Apartir de los datos obtenidos de la BD y con el JSON que regreso la
  Solicitud AJAX creamos un DataTable,esto es lo que va a interpretar
  la api google para dibujar el grafico */
  var datosIngresos = new google.visualization.DataTable(jsonIngresos);
  var datosGastos = new google.visualization.DataTable(jsonGastos);
  var datosTipoGastos = new google.visualization.DataTable(jsonTipoGastos);

  // Instanciamos y dibujamos los graficos
  var chart_ingresos = new google.visualization.AreaChart(document.getElementById('chart_ingresos'));
  var chart_gastos = new google.visualization.AreaChart(document.getElementById('chart_gastos'));
  var chart_tipo_gasto = new google.visualization.PieChart(document.getElementById('chart_tipo_gasto'));

  chart_ingresos.draw(datosIngresos,opcionesIngresos);
  chart_gastos.draw(datosGastos,opcionesGastos);
  chart_tipo_gasto.draw(datosTipoGastos,opcionesTipoGastos);

  //Ocultar modal que muestra el gif "Cargando"
  $(loading).css('display','none');
}
</script>
<!-- Modal para mostrar gif de 'Cargando' -->
<div class="modal-loading"></div>

<!-- Contenido principal -->
<div class="container">
  <h1 class='text-center gfont'>Estadisticas</h1>

  <!-- Charts para mostrar los datos -->
  <div class="panel panel-estadisticas">
    <div id="chart_ingresos" ></div>
  </div>
  <div class="panel panel-estadisticas">
    <div id="chart_gastos" ></div>
  </div>
  <div class="panel panel-estadisticas">
    <div id="chart_tipo_gasto" ></div>
  </div>
</div>

<?php require 'bottomlayout.view.php';?>

<script type="text/javascript">
$('document').ready(function(){
    /*Al terminar de cargar la pagina cargar los paquetes de google
    y dibujar los graficos*/
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    //Cuando se redimensiona la ventana se vuelve a dibujar el grafico
    //Asi se adapta a distintos tamanos el chart
    $(window).resize(function(){
        drawChart();
      });
  });
</script>
