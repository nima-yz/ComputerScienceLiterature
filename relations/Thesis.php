<!DOCTYPE html>
<html>
  <head>
    <title></title>
    <link rel="stylesheet" href="./book.css">
  </head>
  <body>
    <div class="table_title">
    <h1>Thesis</h1>
    </div>
    <table class="table-fill">
    <thead>
    <tr>
      <th class="text-left">Author</th>
      <th class="text-left">Publisher</th>
      <th class="text-left">Year</th>
    </tr>
    </thead>
    <tbody>
    <?php
      $dbconnect = pg_connect("dbname=nimayz user=nimayz password=123456") or alert_error('fail to connect:'.pg_last_error());
      $query = "SELECT t.author, t.publisher, t.year FROM phdthesis as t UNION ALL SELECT t.author, t.publisher, t.year FROM mastersthesis as t";
      
      $query_res = pg_query($query)or alert_error('query failed:'.pg_last_error());
      while ($row = pg_fetch_row($query_res)){
        echo "<tr>";
        for($i = 0; $i < sizeof($row); $i++){
          echo "<td class=\"text-left\">".$row[$i]."</td>";
        }
        echo "</tr>\n";
      }
      pg_free_result($query_res) or alert_error("Couldn't free result".pg_last_error());
      pg_close($dbconnect) or alert_error("Failed close connection");

      function alert_error($error){
        echo "<script type=\"text/javascript\">alert('.$error.');</script>";
        die($error);
      }
    ?>
    </tbody>  
  </table>
</body>
</html>
