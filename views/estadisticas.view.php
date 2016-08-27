<?php require 'headlayout.view.php';?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript">
    function drawChart() {
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

        var datosIngresos = new google.visualization.DataTable(jsonIngresos);
        var datosGastos = new google.visualization.DataTable(jsonGastos);
        var datosTipoGastos = new google.visualization.DataTable(jsonTipoGastos);

      // Instantiate and draw our chart, passing in some options.
      var chart_ingresos = new google.visualization.LineChart(document.getElementById('chart_ingresos'));
      var chart_gastos = new google.visualization.LineChart(document.getElementById('chart_gastos'));
      var chart_tipo_gasto = new google.visualization.PieChart(document.getElementById('chart_tipo_gasto'));

      chart_ingresos.draw(datosIngresos,opcionesIngresos);
      chart_gastos.draw(datosGastos,opcionesGastos);
      chart_tipo_gasto.draw(datosTipoGastos,opcionesTipoGastos);
    }

</script>
<div class="modal-loading"></div>
<div class="container">
  <h1 class='text-center'>Estadisticas</h1>
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
    var loading = $('.modal-loading');
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    $(loading).css('display','none');

    $(window).resize(function(){
        drawChart();
      });
  });


</script>
