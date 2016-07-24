<!DOCTYPE html>
<html>
  <head>
    <title></title>
    <link rel="stylesheet" href="./queryStyle.css">
  </head>
  <body>
    <div class="table_title">
    <h1>Query3</h1>
    </div>
    <div class="query_desc">
      <p>The 10 author with most number of colabrators</p>
    </div>
    
    <?php
      $dbconnect = pg_connect("dbname=nimayz user=nimayz password=123456") or alert_error('fail to connect:'.pg_last_error());
      //$query = "select a1.author, count(*) from article_write as a1, article_write as a2 where a1.dblp_key = a2.dblp_key AND a1.author <> a2.author Group by a1.author Order by count(*) desc limit 10";

      $query = "SELECT a.author, sum(an.author_num -1  ) as collabrators from article_write as a, article_author_number as an where an.dblp_key=a.dblp_key Group by a.author order by collabrators DESC limit 10";
      
      $query_res = pg_query($query)or alert_error('query failed:'.pg_last_error());
      echo  "<table class=\"table-fill\">
          <thead>
            <tr>
            <th class=\"text-left\">Author</th>
            <th class=\"text-left\">Number of collabrators</th>
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

      echo "  </tbody>
         </table>";
      function alert_error($error){
        echo "<script type=\"text/javascript\">alert('.$error.');</script>";
        die($error);
      }
    ?>
</body>
</html>
