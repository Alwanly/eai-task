<?php
        include 'connection.php';
        $fab = mysqli_query($con,"SELECT COUNT(masalah_registrasi.NIM) as jumlah,masalah_registrasi.Alasan_Tunggakan, mahasiswa.Fakultas FROM masalah_registrasi INNER JOIN mahasiswa ON masalah_registrasi.NIM = mahasiswa.NIM WHERE mahasiswa.Fakultas= 'Fakultas Ekonomi Dan Bisnis' GROUP BY masalah_registrasi.Alasan_Tunggakan");
        $fri = mysqli_query($con,"SELECT COUNT(masalah_registrasi.NIM) as jumlah,masalah_registrasi.Alasan_Tunggakan, mahasiswa.Fakultas FROM masalah_registrasi INNER JOIN mahasiswa ON masalah_registrasi.NIM = mahasiswa.NIM WHERE mahasiswa.Fakultas= 'Fakultas Rekayasa Industri' GROUP BY masalah_registrasi.Alasan_Tunggakan");       
        $fif = mysqli_query($con,"SELECT COUNT(masalah_registrasi.NIM) as jumlah,masalah_registrasi.Alasan_Tunggakan, mahasiswa.Fakultas FROM masalah_registrasi INNER JOIN mahasiswa ON masalah_registrasi.NIM = mahasiswa.NIM WHERE mahasiswa.Fakultas= 'Fakultas Teknik Informatika' GROUP BY masalah_registrasi.Alasan_Tunggakan");
        $fit = mysqli_query($con,"SELECT COUNT(masalah_registrasi.NIM) as jumlah,masalah_registrasi.Alasan_Tunggakan, mahasiswa.Fakultas FROM masalah_registrasi INNER JOIN mahasiswa ON masalah_registrasi.NIM = mahasiswa.NIM WHERE mahasiswa.Fakultas= 'Fakultas Ilmu Terapan' GROUP BY masalah_registrasi.Alasan_Tunggakan");
        while($row = mysqli_fetch_array($fab)){
            $jumlah_feb[] = $row['jumlah'];            
        }             
        while($row = mysqli_fetch_array($fri)){
          $jumlah_fri[] = $row['jumlah'];            
        }
        while($row = mysqli_fetch_array($fif)){
          $jumlah_fif[] = $row['jumlah'];            
        }   
        while($row = mysqli_fetch_array($fit)){
          $jumlah_fit[] = $row['jumlah'];            
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
          ['Klasifikasi Per-Fakultas', 'Covid-19', 'Orang Tua Meninggal','PHK','Telat Registrasi'],
          ['Fakultas Ekonomi Dan Bisnis', 0,  <?php echo $jumlah_feb[0]?>, <?php echo $jumlah_feb[1]?>,0],        
          ['Fakultas Rekayasa Industri', <?php echo $jumlah_fri[0] ?>, <?php echo $jumlah_fri[1] ?>,<?php echo $jumlah_fri[2] ?>,<?php echo $jumlah_fri[3] ?> ],
          ['Fakultas Teknik Informatika', <?php echo $jumlah_fri[0] ?>, 0,<?php echo $jumlah_fri[1] ?>,<?php echo $jumlah_fri[3] ?> ],
          ['Fakultas Ilmu Terapan', 0, 0,<?php echo $jumlah_fri[0] ?>,0 ],
          ['Fakultas Teknik Elektro', 0, 0,0,0 ],
          ['Fakultas Industri Kreatif', 0, 0,0,0 ]   
        ]);

        var options = {
          chart: {
            title: 'Masalah Registrasi'
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
