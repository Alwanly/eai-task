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
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawStuff);

      function drawStuff() {
        var data = new google.visualization.arrayToDataTable([  
          ['Nama Lomba', 'Percentage'],        
         <?php for($i = 0; $i < count($juml)-2; $i++) { ?>
         ["<?php echo $nama_lomba[$i] ?>", <?php echo $juml[$i] ?>],
         <?php }?>
         ["<?php echo $nama_lomba[$i] ?>", <?php echo $juml[$i] ?>]
        ]);

        var options = {
          width: 800,
          legend: { position: 'none' },
          chart: {
            title: 'Persebaran Lomba'
            },        
          bar: { groupWidth: "90%" }
        };

        var chart = new google.charts.Bar(document.getElementById('top_x_div'));
        // Convert the Classic options to Material options.
        chart.draw(data, google.charts.Bar.convertOptions(options));
      };
    </script>
</head>
<body>
    
    <div id="top_x_div" style="width: 100%; height: 400px;"></div>

</body>
</html>
