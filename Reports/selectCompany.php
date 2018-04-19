<?php
  session_start();
  include '../config.php';
  include '../redirect.php';

  if(isset($_POST['submit']))
  {
    $_SESSION['updateCompany'] = $_POST['tempID'];
    redirect("../updateCompany/updateCompany.php");
  }
?>


<!DOCTYPE HTML>
<html>
  <head>
    <meta charset="utf-8">
    <title>Reports</title>

    <link rel="stylesheet" type="text/css" href="report.css" media="all">
  </head>

  <body>

    <h1>Company Reports</h1>
    <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for Company Name...">

    <table id="myTable">
      <tr class="header">
        <th style="width:40%;">Company ID</th>
        <th style="width:60%;">Company Name</th>
        <th style="width:40%;"></th>
      </tr>

      <?php
        $sql = "SELECT CompanyID, CName FROM company";
        $results = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_array($results))
        {
          echo "<tr>";
          echo "<td>" . $row['CompanyID'] . "</td>";
          echo "<td>" . $row['CName'] . "</td>";
          echo "<td><form method='POST'><input type='hidden' name='tempID' value='" . $row['CompanyID'] . "' /><input type='submit' name='submit' value='Update' /></form></td>";
          echo "</tr>";
        }
      ?>
    </table>

    <script>
    function myFunction() {
      var input, filter, table, tr, td, i;
      input = document.getElementById("myInput");
      filter = input.value.toUpperCase();
      table = document.getElementById("myTable");
      tr = table.getElementsByTagName("tr");
      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[1];
        if (td)
        {
          if (td.innerHTML.toUpperCase().indexOf(filter) > -1)
          {
            tr[i].style.display = "";
          }
          else
          {
            tr[i].style.display = "none";
          }
        }
      }
    }
    </script>
  </body>
</html>
