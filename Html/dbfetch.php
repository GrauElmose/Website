<!DOCTYPE html>
<html lang="en">
<head>

  <!-- Basic Page Needs
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta charset="utf-8">
  <title>GrauElmose Development Site</title>
  <meta name="description" content="Site used for development purposes">
  <meta name="author" content="Christian G. Elmose">

  <!-- Mobile Specific Metas
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- FONT
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link href="//fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css">

  <!-- CSS
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link rel="stylesheet" href="css/normalize.css">
  <!--<link rel="stylesheet" href="css/skeleton.css">-->
  <link rel="stylesheet" href="css/codepen.css">

  <!-- Favicon
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link rel="icon" type="image/png" href="images/favicon.png">

</head>
<body>

<!-- Main GrauElmose customized portion -->
<header>

<div class="row">
  <div class="twelve columns">
    <h1> - Results- </h1>
  </div>
</div>

  <div class="container">
  <div class="row">
    <div class="one-third column">
      <nav>
      
      <?php

            //Get number of days
            $days = $_GET['days'];

            //Open database
            include 'inc/dbconnection.php';
            $conn = openDB();

            // Select and display results
            $query = "SELECT * FROM internet WHERE datetime >= DATE(NOW()) + INTERVAL - $days DAY 
                      AND datetime < NOW() + INTERVAL 0 DAY ORDER BY datetime DESC;";
  
            if ($result = mysqli_query($conn, $query)) {
    
              echo "<table>";
              echo "<tr><th>DateTime</th>"; echo "<th>Ping</th>"; echo "<th>Download</th>"; echo "<th>Upload</th></tr>";

              // Show results
              while($row = mysqli_fetch_array($result)) {
              echo "<tr><td>{$row[0]}</td>"; echo "<td>{$row[1]}</td>"; echo "<td>{$row[2]}</td>"; echo "<td>{$row[3]}</td></tr>"; 
              }
    
            echo "</table>";    
    
           }
    
          // Close database
          mysqli_free_result($result);  
          CloseDB($conn);
      ?>

      </nav>
    </div>
  </div>
  <br>
  <a href="index.php">Back</a>
</div>
</header>


 
  

<!-- End Document
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
</body>
</html>
