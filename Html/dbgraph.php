<!DOCTYPE html>
<html>
 
<head>
  <meta charset="utf-8">
  <title>Internet Statistics</title>
 
  <script src="https://cdn.zingchart.com/zingchart.min.js"></script>
  <style>
    html,
    body {
      height: 100%;
      width: 100%;
    }
 
    #myChart {
      height: 100%;
      width: 100%;
      min-height: 150px;
    }
 
    .zc-ref {
      display: none;
    }
  </style>
</head>

  <body>
  <div id='myChart'></div>
    <script>

      <?php
        
        //Open database
        include 'inc/dbconnection.php';
        $conn = openDB();
        
        /* 
          The query to use. 
        */
        $query = "SELECT * FROM internet WHERE datetime >= DATE(NOW()) + INTERVAL - 30 DAY 
        AND datetime < NOW() + INTERVAL 0 DAY ORDER BY datetime ASC;";

        /* ---------------- */

        $date = []; // Array to hold our date values
        $ping = []; // Array to hold our series values
        $download = []; // Array to hold our series values
        $upload = []; // Array to hold our series values

        /* Run the query */
        if ($result = mysqli_query($conn, $query)) {

          /* Fetch the result row as a numeric array */
          while($row = mysqli_fetch_array($result)) {

            /* Push the values from each row into the $date and $series arrays */
            array_push($date, $row[0]);
            array_push($ping, $row[1]);
            array_push($download, $row[2]);
            array_push($upload, $row[3]);
          }

          /* Convert each date value to a Unix timestamp, multiply by 1000 for milliseconds */
          foreach ($date as &$value){
            $value = strtotime( $value ) * 1000;
          }
        }
      ?>
     
      /* Join the values in each array to create JavaScript arrays */
      var dateValues = [<?php echo join( ',',  $date ) ?>];
      var pingValues = [<?php echo join( ',', $ping ) ?>];
      var downloadValues = [<?php echo join( ',', $download ) ?>];
      var uploadValues = [<?php echo join( ',', $upload ) ?>];
      
      <?php

        // Close database
        mysqli_free_result($result);  
        CloseDB($conn);
      
      ?>
    </script>



<script>
/* Zing chart section - Chart optimizations go here */
    var myConfig = {
      "type": "mixed",
      
      "title": {
        "text": "Internet",
        "font-size": "24px",
        "adjust-layout": true
      },
      
      "plotarea": {
        "margin": "dynamic 45 60 dynamic",
      },
      
      "legend": {
        "layout": "float",
        "background-color": "none",
        "border-width": 0,
        "shadow": 0,
        "align": "center",
        "adjust-layout": true,
        "toggle-action": "remove",
        "item": {
          "padding": 7,
          "marginRight": 17,
          "cursor": "hand"
        }
      },
      
      "scale-x": {
        "values": dateValues,
        "shadow": 0,
   
        "transform": {
          "type": "date",
          "all": "%D, %d %M %Y<br />%H:%i",
          "guide": {
            "visible": false
          },
          "item": {
            "visible": false
          }
        },
        "label": {
          "visible": false
        },
        "minor-ticks": 0
      },
      "scale-y": {
        "line-color": "#f6f7f8",
        "shadow": 0,
        "guide": {
          "line-style": "dashed"
        },
        "label": {
          "text": "Internet Speed",
        },
        "minor-ticks": 0,
        "thousands-separator": "."
      },
      "crosshair-x": {
        "line-color": "#efefef",
        "plot-label": {
          "border-radius": "5px",
          "border-width": "1px",
          "border-color": "#f6f7f8",
          "padding": "10px",
          "font-weight": "bold"
        },
        "scale-label": {
          "font-color": "#000",
          "background-color": "#f6f7f8",
          "border-radius": "5px"
        }
      },
      "tooltip": {
        "visible": false
      },
      "plot": {
        "highlight": true,
        "shadow": 0,
        "line-width": "2px",
        "marker": {
          "type": "circle",
          "size": 3
        },
        "highlight-state": {
          "line-width": 3
        },
        "animation": {
          "effect": 0,
          "sequence": 0,
          "speed": 0,
        }
      },
      "series": [{
          "type": "line",
          "values": pingValues,
          "text": "Ping",
          "line-color": "#007790",
          "legend-item": {
            "background-color": "#007790",
            "borderRadius": 5,
            "font-color": "white"
          },
          "legend-marker": {
            "visible": false
          },
          "marker": {
            "background-color": "#007790",
            "border-width": 1,
            "shadow": 0,
            "border-color": "#69dbf1"
          },
          "highlight-marker": {
            "size": 6,
            "background-color": "#007790",
          },
          
        },
        {
          "type":"line",
          "values": downloadValues,
          "text": "Download",
          "line-color": "#009872",
          "legend-item": {
            "background-color": "#009872",
            "borderRadius": 5,
            "font-color": "white"
          },
          "legend-marker": {
            "visible": false
          },
          "marker": {
            "background-color": "#009872",
            "border-width": 1,
            "shadow": 0,
            "border-color": "#69f2d0"
          },
          "highlight-marker": {
            "size": 6,
            "background-color": "#009872",
          },
          scales: "scale-x,scale-y"
        },
        {
          "type":"line",
          "values": uploadValues,
          "text": "Upload",
          "line-color": "#da534d",
          "legend-item": {
            "background-color": "#da534d",
            "borderRadius": 5,
            "font-color": "white"
          },
          "legend-marker": {
            "visible": false
          },
          "marker": {
            "background-color": "#da534d",
            "border-width": 1,
            "shadow": 0,
            "border-color": "#faa39f"
          },
          "highlight-marker": {
            "size": 6,
            "background-color": "#da534d",
          },
          scales: "scale-x,scale-y"
        }
      ]
    };
 
    zingchart.render({
      id: 'myChart',
      data: myConfig,
      height: '100%',
      width: '100%'
    });
  </script>
  
  </body>
</html>
