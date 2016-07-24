<!DOCTYPE html>
<html>
<head>
  <link rel="icon" href="..\images\book.ico" />
  <link rel="stylesheet" type="text/css" href="adhocStyle.css">
  <link rel="stylesheet" type="text/css" href="adhocquery.css">
  <title>Publications | Ad-Hoc</title>
   <script>
    var currDD;
    var QShowing = false;
    var RShowing = false;

    function myFunction() {
        if (RShowing == false)
        {
          RShowing = true;
        }
        else
        {
          RShowing = false;
        }
        if (currDD == "Q" && QShowing)
        {
          document.getElementById("myDropdown2").classList.toggle("show");
          QShowing = false;
        }
        document.getElementById("myDropdown").classList.toggle("show");
        currDD = "R";
    }

    function myFunction2(){
        if (QShowing == false)
        {
          QShowing = true;
        }
        else
        {
          QShowing = false;
        }
        if (currDD == "R" && RShowing)
        {
          document.getElementById("myDropdown").classList.toggle("show");
          RShowing = false;
        }
        document.getElementById("myDropdown2").classList.toggle("show");
        currDD = "Q";
    }

    window.onclick = function(e) {
      if (currDD == "R")
      {
          if (!e.target.matches('.dropbtn')) {

            var dropdowns = document.getElementsByClassName("dropdown-content");
            for (var d = 0; d < dropdowns.length; d++) {
              var openDropdown = dropdowns[d];
              if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
              }
            }
            RShowing = false;
          }
      }
      else if (currDD == "Q")
      {
          if (!e.target.matches('.dropbtn2')) {

            var dropdowns = document.getElementsByClassName("dropdown-content2");
            for (var d = 0; d < dropdowns.length; d++) {
              var openDropdown = dropdowns[d];
              if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
              }
            }
            QShowing = false;
          }
      }

    }
  </script>
</head>

<body>
  <ul class="menubar" id="menubar">
    <li><a href="../login/search.php">Search</a></li>
    <li><a href="../adhocquery/adhocquery.php">Ad-hoc Query</a></li>
    <li class="dropdown2"><a href="javascript:void(0)" class="dropbtn2" onclick="myFunction2()">Queries</a>
            <div class="dropdown-content2" id="myDropdown2">
              <a href="../queries/queries.html?http://cs4604.cs.vt.edu/~nimayz/Database%20Website/queries/Query1.php">Query1</a>
              <a href="../queries/queries.html?http://cs4604.cs.vt.edu/~nimayz/Database%20Website/queries/Query2.php">Query2</a>
              <a href="../queries/queries.html?http://cs4604.cs.vt.edu/~nimayz/Database%20Website/queries/Query3.php">Query3</a>
              <!--<a href="../queries/queries.html?http://cs4604.cs.vt.edu/~nimayz/Database%20Website/queries/Query4.php">Query4</a> -->
              <!--<a href="../queries/queries.html?http://cs4604.cs.vt.edu/~nimayz/Database%20Website/queries/Query5.php">Query5</a> -->
            </div>
    </li>
    <li class=dropdown><a href="javascript:void(0)" class="dropbtn" onclick="myFunction()">Relations</a>
            <div class="dropdown-content" id="myDropdown">
              <a href="../relations/relations.html?http://cs4604.cs.vt.edu/~nimayz/Database%20Website/relations/Book.php">Books</a>
              <a href="../relations/relations.html?http://cs4604.cs.vt.edu/~nimayz/Database%20Website/relations/Author.php">Book's Author</a>
              <a href="../relations/relations.html?http://cs4604.cs.vt.edu/~nimayz/Database%20Website/relations/Article.php">Articles</a>
              <a href="../relations/relations.html?http://cs4604.cs.vt.edu/~nimayz/Database%20Website/relations/Thesis.php">Thesis</a>
              <a href="../relations/relations.html?http://cs4604.cs.vt.edu/~nimayz/Database%20Website/relations/Topics.php">Topics</a>
            </div>
    </li>
    <li><a href="../index.html">Home</a></li>
  </ul>

 
  <form id="queryBox" class="queryBox" METHOD=POST action="adhocquery.php">
              <br><strong>Enter Query:</strong><br><br>
              <button class="clear">Clear</button>
              <input type=text size=150 maxlength=1000 name="query" id="query" class="query">
              <button class="submit">Request</button>
              <br><br>       
 </form>

<div class="table" id="table">
  <?php 
  pg_connect("dbname=nimayz user=nimayz password=123456") or die('Failed to Connect:'.pg_last_error());
  if(!empty($_POST['query'])){
  $pg_res = pg_query($_POST['query']) or die('Failed on query:'.pg_last_error());

  echo "<div class=\"table_title\">
    <h1>".$_POST['query']."</h1></div>";
  echo "<table class=\"table-fill\"><thead><tr>";
  for($i=0; $i < pg_num_fields($pg_res);$i++)
  {
      $head = pg_field_name($pg_res, $i);
      echo "<th class=\"text-left\">$head</th>";
  }
  echo "</tr></thead>";
  echo "<tbody>";
  while($row=pg_fetch_row($pg_res)){
      echo "<tr>";
        for($i = 0; $i < sizeof($row); $i++){
          echo "<td class=\"text-left\">".$row[$i]."</td>";
    }
        echo "</tr>\n";
  }
      pg_free_result($query_res) or alert_error("Couldn't free result".pg_last_error());
      pg_close($dbconnect) or alert_error("Failed close connection");
  echo "</tbody></table>";
  }
  ?>
</div>
</body>

</html>
