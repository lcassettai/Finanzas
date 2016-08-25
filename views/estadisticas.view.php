<?php require 'headlayout.view.php';?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
  google.charts.load('current', {'packages':['corechart']});
  google.charts.setOnLoadCallback(drawChart);
  function drawChart() {

    var data = google.visualization.arrayToDataTable([
      ['Task', 'Hours per Day'],
      ['Work',     11],
      ['Eat',      2],
      ['Commute',  2],
      ['Watch TV', 2],
      ['Sleep',    7]
    ]);

    var options = {
      title: 'My Daily Activities'
    };

    var chart = new google.visualization.PieChart(document.getElementById('piechart'));

    chart.draw(data, options);
  }

</script>
<div class="container">
  <h1 class='text-center'>Estadisticas</h1>
<div class="panel panel-estadisticas">
  <div id="piechart" ></div>
</div>
</div>


<?php require 'bottomlayout.view.php';?>
<script type="text/javascript">
$(window).resize(function(){
    drawChart();
  });
</script>