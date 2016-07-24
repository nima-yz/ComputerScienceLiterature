<!DOCTYPE html>
<html>
  <head>
    <title></title>
    <link rel="stylesheet" href="./book.css">
  </head>
  <body>
    <div class="table_title">
    <h1>Book</h1>
    </div>
    <table class="table-fill">
    <thead>
    <tr>
      <th class="text-left">Title</th>
      <th class="text-left">ISBN</th>
      <th class="text-left">Publisher</th>
      <th class="text-left">Year</th>
    </tr>
    </thead>
    <tbody>
    <?php
      $dbconnect = pg_connect("dbname=nimayz user=nimayz password=123456") or die('fail to connect:'.pg_last_error());
      $query = "SELECT p.title,book.isbn, book.publisher, p.year FROM book , publication as p Where p.dblp_key=book.dblp_key ORDER BY p.title LIMIT 200";
      
      $query_res = pg_query($query)or die('query failed:'.pg_last_error());
      while ($row = pg_fetch_row($query_res)){
        echo "<tr>";
        for($i = 0; $i < sizeof($row); $i++){
          echo "<td class=\"text-left\">".$row[$i]."</td>";
        }
        echo "</tr>\n";
      }
      pg_free_result($query_res) or die("Couldn't free result".pg_last_error());
      pg_close($dbconnect) or die("Failed close connection");
    ?>
    </tbody>  
  </table>
</body>
</html>
