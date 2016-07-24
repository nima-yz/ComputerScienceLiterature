<!DOCTYPE html>
<html>
  <head>
    <title></title>
    <link rel="stylesheet" href="./book.css">
  </head>
  <body>
    <div class="table_title">
    <h1>Topics</h1>
    </div>
    <table class="table-fill">
    <thead>
    <tr>
      <th class="text-left">Title</th>
      <th class="text-left">URL</th>
      <th class="text-left">Year</th>
      <th class="text-left">Author</th>
    </tr>
    </thead>
    <tbody>
    <?php
      $dbconnect = pg_connect("dbname=nimayz user=nimayz password=123456") or alert_error('fail to connect:'.pg_last_error());
      $query = "SELECT p.title, p.url, p.year, wr.author FROM www as w, www_write as wr, publication as p WHERE w.dblp_key=wr.dblp_key AND p.dblp_key=w.dblp_key ORDER BY p.title, wr.rank";
      
      //$query = "SELECT p.title, p.url, p.year FROM publication as p ORDER BY p.title";

      $query_res = pg_query($query)or alert_error('query failed:'.pg_last_error());
      while ($row = pg_fetch_row($query_res)){
        echo "<tr>";
        for($i = 0; $i < sizeof($row); $i++){
          if($i==1)
          {
            echo "<td class=\"text-left\"><a href=\"".$row[$i]."\">".$row[$i]."</td>";
          }
          else{
          echo "<td class=\"text-left\">".$row[$i]."</td>";
          }
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