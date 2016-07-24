<!DOCTYPE html>
<html>
  <head>
    <title></title>
    <link rel="stylesheet" href="./queryStyle.css">
  </head>
  <body>
    <div class="table_title">
    <h1>Query2</h1>
    </div>
    <div class="query_desc">
      <p>The Publication that were published in a conference first and then in a journal.</p>
    </div>
    
    <?php
      $dbconnect = pg_connect("dbname=nimayz user=nimayz password=123456") or alert_error('fail to connect:'.pg_last_error());
      $query = " SELECT p.title FROM publication as p, inproceedings as i WHERE i.dblp_key=p.dblp_key AND p.title IN (SELECT p.title FROM publication as p, article AS a where a.dblp_key=p.dblp_key)";
      
      $query_res = pg_query($query)or alert_error('query failed:'.pg_last_error());
      $num_res = pg_num_rows($query_res) or die('Coudnl\'t get the number:'.pg_last_error());
      echo  "<p> Number of Result from Query is <big>$num_res</big></p>
         <table class=\"table-fill\">
          <thead>
            <tr>
            <th class=\"text-left\">Title</th>
           </tr>
        </thead>
      <tbody>";
      while ($row = pg_fetch_row($query_res)){
        echo "<tr>";
        for($i = 0; $i < sizeof($row); $i++){
          echo "<td class=\"text-left\">".$row[$i]."</td>";
        }
        echo "</tr>\n";
      }
      pg_free_result($query_res) or alert_error("Couldn't free result".pg_last_error());
      pg_close($dbconnect) or alert_error("Failed close connection");

      echo "  </tbody>   </table>";
      function alert_error($error){
        echo "<script type=\"text/javascript\">alert('.$error.');</script>";
        die($error);
      }
    ?>
</body>
</html>
