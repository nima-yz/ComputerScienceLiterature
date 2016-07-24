<!DOCTYPE html>
<html>
  <head>
    <title></title>
    <link rel="stylesheet" href="./queryStyle.css">
  </head>
  <body>
    <div class="table_title">
    <h1>Query1</h1>
    </div>
    <div class="query_desc">
      <p>10 latest publications by author <big>'Philip S. Yu</big></p>
    </div>
    <table class="table-fill">
    <thead>
    <tr>
      <th class="text-left">Title</th>
      <th class="text-left">Year</th>
    </tr>
    </thead>
    <tbody>
    <?php
      $dbconnect = pg_connect("dbname=nimayz user=nimayz password=123456") or alert_error('fail to connect:'.pg_last_error());
      $query = "select p.title, p.year from publication as p, 
       ( Select * FROM inproceedings_write as a where a.author='Philip S. Yu'
        UNION ALL
         Select * FROM incollection_write as i where i.author='Philip S. Yu' 
        UNION ALL
         Select * FROM edited_by as i where i.editor='Philip S. Yu'
         UNION ALL
         Select * FROM authorbook_write as i where i.author='Philip S. Yu')
         x where x.dblp_key= p.dblp_key ORDER BY p.year desc LIMIT 10";
      
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
