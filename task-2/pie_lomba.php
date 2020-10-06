<?php
          include 'connection.php';
          $lomba = mysqli_query($con,"SELECT COUNT(NIM) as jml, nama_lomba as lomba FROM keaktifan GROUP BY nama_lomba");        
          while($row = mysqli_fetch_array($lomba)){
              $juml[] = $row['jml'];
              $nama_lomba[] = $row['lomba'];
          }             
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chartjs, PHP dan MySQL Demo Grafik Batang</title>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          <?php for($i = 0; $i < count($juml)-2; $i++) { ?>
         ["<?php echo $nama_lomba[$i] ?>", <?php echo $juml[$i] ?>],
         <?php }?>
         ["<?php echo $nama_lomba[$i] ?>", <?php echo $juml[$i] ?>]
        ]);

        var options = {
          title: 'Persebaran mahasiswa mengikuti lomba',          
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
    <div id="donutchart" style="width: 100%; height: 400px;"></div>
  </body>
</html>
