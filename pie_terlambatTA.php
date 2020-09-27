<?php
        include 'connection.php';
        $ta = mysqli_query($con,"SELECT COUNT(terlambat_lulus.NIM) as jumlah,mahasiswa.Fakultas FROM terlambat_lulus INNER JOIN mahasiswa ON mahasiswa.NIM = terlambat_lulus.NIM WHERE terlambat_lulus.Semester > 10 GROUP BY mahasiswa.Fakultas");        
        while($row = mysqli_fetch_array($ta)){
            $jml_ta[] = $row['jumlah'];            
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
          ['Fakultas Ekonomi Dan Bisnis',<?php echo $jml_ta[0] ?>],
          ['Fakultas Ilmu Terapan',      <?php echo $jml_ta[1] ?>],
          ['Fakultas Industri Kreatif',  <?php echo $jml_ta[2] ?>],
          ['Fakultas Rekayasa Industri', <?php echo $jml_ta[3] ?>],
          ['Fakultas Teknik Elektro',    <?php echo $jml_ta[4] ?>]
        ]);

        var options = {
          title: 'Terlambat TA',
          pieHole: 0.4,
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
