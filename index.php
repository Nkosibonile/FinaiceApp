<html>
  <head>
    <title>Financial Statement App</title>
    <link rel="stylesheet" type="text/css" href="style.css">
  </head>
  <body>
    <h1>Financial Statement App</h1>
    <form action="submit.php" method="post" enctype="multipart/form-data">
      <label for="firstname">First Name:</label>
      <input type="text" id="firstname" name="firstname">
      <br><br>
      <label for="lastname">Last Name:</label>
      <input type="text" id="lastname" name="lastname">
      <br><br>
      <label for="dob">Date of Birth:</label>
      <input type="date" id="dob" name="dob">
      <br><br>
      <label for="financial_statement">Financial Statement (Excel file):</label>
      <input type="file" id="financial_statement" name="financial_statement">
      <br><br>
      <input type="submit" value="Submit">
    </form>
  

<div id="chart_div" style="width: 900px; height: 500px;">
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
  google.charts.load('current', {'packages':['corechart']});
  google.charts.setOnLoadCallback(drawChart);

  function drawChart() {
    var data = google.visualization.arrayToDataTable([
      ['Month', 'Income', 'Expenditure'],
      <?php
        for ($i = 0; $i < count($data); $i++) {
          echo "['" . $data[$i][0] . "', " . $data[$i][1] . ", " . $data[$i][2] . "],";
        }
      ?>
    ]);

    var options = {
      title: 'Monthly Income and Expenditure',
      hAxis: {title: 'Month'},
      vAxis: {title: 'Amount'}
    };

    var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
    chart.draw(data, options);
  }
</script></div>

  </body>
</html>
