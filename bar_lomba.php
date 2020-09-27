<?php
        include 'connection.php';
        $sehat = mysqli_query($con,"SELECT COUNT(NIM) as Sehat ,Zona_Tinggal FROM kesehatan WHERE Kondisi = 'Sehat' GROUP BY Zona_Tinggal");
        $sakit = mysqli_query($con,"SELECT COUNT(NIM) as Sakit ,Zona_Tinggal FROM kesehatan WHERE Kondisi = 'Sakit' GROUP BY Zona_Tinggal");
        while($row = mysqli_fetch_array($sehat)){
            $kondisi_sehat[] = $row['Sehat'];
            $zona[] = $row['Zona_Tinggal'];
        }  
        while($row = mysqli_fetch_array($sakit)){
            $kondisi_sakit[] = $row['Sakit'];
            $zona[] = $row['Zona_Tinggal'];
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
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Klasifikasi Daerah', 'Sehat', 'Sakit'],
          ['Hijau', <?php echo $kondisi_sehat[0]?>,  <?php echo $kondisi_sakit[0]?> ],
          ['Hitam', <?php echo $kondisi_sehat[1]?>, <?php echo $kondisi_sakit[1]?>],
          ['Merah', <?php echo $kondisi_sehat[2]?>, <?php echo $kondisi_sakit[2]?>],
          ['Orange', <?php echo $kondisi_sehat[3]?>, <?php echo $kondisi_sakit[3]?>]
        ]);

        var options = {
          chart: {
            title: 'Kondisi Kesehatan Mahasiswa Berdasarkan Zona Tinggal',            
          }
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>
</head>
<body>
    
    <div id="columnchart_material" style="width: 100%; height: 100%;"></div>

</body>
</html>
