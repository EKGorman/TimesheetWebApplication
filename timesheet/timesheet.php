<?php
  include '../config.php';
  include '../redirect.php';
  session_start();

  if($_SESSION['loggedIn'] != true)
  {
    redirect("../login/login.php");
  }

  $employee_id = $_SESSION['EmployeeID'];

  $startWeek = date('Y-m-d', strtotime('-7 days', strtotime('next Sunday', strtotime(date('Y-m-d')))));

  if(isset($_POST["save"]))
  {
    $sql = "DELETE FROM time WHERE EmployeeID = $employee_id and Submitted = 0";
    $conn -> query($sql);

    $stmt = $conn -> prepare("INSERT INTO time (Date, SunHours, MonHours, TuesHours, WedHours, ThursHours, FriHours, SatHours, ProjectID, EmployeeID) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt -> bind_param(
      'sdddddddii',
      $date,
      $contents0,
      $contents1,
      $contents2,
      $contents3,
      $contents4,
      $contents5,
      $contents6,
      $project,
      $employee_id
    );

    $rowNum = count($_POST["project"]);
    $date = $startWeek;
    for($row = 0; $row < $rowNum; $row++)
    {
      $project = $_POST["project"][$row];

      for($col = $row * 7; $col < $row * 7 + 7; $col++)
      {
        if($col % 7 == 0)
        {
          $contents0 = $_POST["contents"][$col];
        }
        elseif($col % 7 == 1)
        {
          $contents1 = $_POST["contents"][$col];
        }
        elseif($col % 7 == 2)
        {
          $contents2 = $_POST["contents"][$col];
        }
        elseif($col % 7 == 3)
        {
          $contents3 = $_POST["contents"][$col];
        }
        elseif($col % 7 == 4)
        {
          $contents4 = $_POST["contents"][$col];
        }
        elseif($col % 7 == 5)
        {
          $contents5 = $_POST["contents"][$col];
        }
        else
        {
          $contents6 = $_POST["contents"][$col];
          $stmt->execute();
        }
      }
    }
  }
  if(isset($_POST['submit']))
  {
    $conn -> query("UPDATE time SET Submitted = 1 WHERE EmployeeID = $employee_id and Submitted = 0");
  }
?>


<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <title>timesheetApp</title>

    <link rel="stylesheet" href="css/view.css">

    <script type="text/javascript">

      function addRow(tableID)
      {
        var table = document.getElementById(tableID);

        var rowCount = table.rows.length;
        var row = table.insertRow(rowCount);

        var dateCell = row.insertCell(0);
        dateCell.innerHTML = "Date:<input class=\"dateValue\" type=\"date\" name=\"date[]\" required>";

        var projectCell = row.insertCell(1);
        projectCell.innerHTML = "Project ID:<br><input class=\"projectValue\" class=\"number\" type=\"number\" name=\"project[]\" placeholder=\"Example: 001\" required>";

        var timeCell1 = row.insertCell(2);
        timeCell1.innerHTML = "Hours Worked:<br><input class=\"timeValue\" type=\"number\" step=\"any\" min=\"0\" class=\"hours\" name=\"contents[]\">";

        var timeCell2 = row.insertCell(3);
        timeCell2.innerHTML = "Hours Worked:<br><input class=\"timeValue\" type=\"number\" step=\"any\" min=\"0\" class=\"hours\" name=\"contents[]\">";

        var timeCell3 = row.insertCell(4);
        timeCell3.innerHTML = "Hours Worked:<br><input class=\"timeValue\" type=\"number\" step=\"any\" min=\"0\" class=\"hours\" name=\"contents[]\">";

        var timeCell4 = row.insertCell(5);
        timeCell4.innerHTML = "Hours Worked:<br><input class=\"timeValue\" type=\"number\" step=\"any\" min=\"0\" class=\"hours\" name=\"contents[]\">";

        var timeCell5 = row.insertCell(6);
        timeCell5.innerHTML = "Hours Worked:<br><input class=\"timeValue\" type=\"number\" step=\"any\" min=\"0\" class=\"hours\" name=\"contents[]\">";

        var timeCell6 = row.insertCell(7);
        timeCell6.innerHTML = "Hours Worked:<br><input class=\"timeValue\" type=\"number\" step=\"any\" min=\"0\" class=\"hours\" name=\"contents[]\">";

        var timeCell7 = row.insertCell(8);
        timeCell7.innerHTML = "Hours Worked:<br><input class=\"timeValue\" type=\"number\" step=\"any\" min=\"0\" class=\"hours\" name=\"contents[]\">";

        var deleteCell = row.insertCell(9);
        deleteCell.innerHTML = "<button name=\"delete\" onClick=\"deleteRow(this)\">Delete Row</button>";
      }

      function deleteRow(aRow)
      {
        var tbl = document.getElementById('dataTable')
        var lastRow = tbl.rows.length;
        if(lastRow > 2)
        {
          tbl.deleteRow(aRow.parentElement.parentElement.rowIndex);
        }
        else {
          alert("Cannot remove all");
        }
      }
    </script>
  </head>

  <body>

    <img id="top" src="images/top.png" alt="">
    <div id="form_container">

      <h1><a></a></h1>

      <form class="appnitro" method="post" action="">

        <div class="form_description">
          <h2>TimeSheet</h2>
        </div>

        <div>
          <table id="dataTable" cellpadding="10px" cellspacing="0">
            <thead>
              <tr>
                <th id="date">Date</th>
                <th id="project">Project ID</th>
                <th class="time">Sunday</th>
                <th class="time">Monday</th>
                <th class="time">Tuesday</th>
                <th class="time">Wednesday</th>
                <th class="time">Thursday</th>
                <th class="time">Friday</th>
                <th class="time">Saturday</th>
                <th><button name="add" onclick="addRow('dataTable')">Add Row</button></th>
              </tr>
            </thead>

            <?php
              $sql = "SELECT Date, SunHours, MonHours, TuesHours, WedHours, ThursHours, FriHours, SatHours, ProjectID FROM time WHERE EmployeeID = $employee_id and Submitted = 0";
              $results = mysqli_query($conn, $sql);

              if($results == null)
              {
                echo "<tr>";
                echo "<td>Date:<br><input class=\"dateValue\" type=\"date\" name=\"date[]\" required></td>";
                echo "<td>Project ID:<br><input class=\"projectValue\" class=\"number\" type=\"number\" name=\"project[]\" placeholder=\"Example: 001\" required></td>";
                echo "<td>Hours Worked:<br><input class=\"timeValue\" type=\"number\" step=\"any\" min=\"0\" class=\"hours\" name=\"contents[]\"></td>";
                echo "<td>Hours Worked:<br><input class=\"timeValue\" type=\"number\" step=\"any\" min=\"0\" class=\"hours\" name=\"contents[]\"></td>";
                echo "<td>Hours Worked:<br><input class=\"timeValue\" type=\"number\" step=\"any\" min=\"0\" class=\"hours\" name=\"contents[]\"></td>";
                echo "<td>Hours Worked:<br><input class=\"timeValue\" type=\"number\" step=\"any\" min=\"0\" class=\"hours\" name=\"contents[]\"></td>";
                echo "<td>Hours Worked:<br><input class=\"timeValue\" type=\"number\" step=\"any\" min=\"0\" class=\"hours\" name=\"contents[]\"></td>";
                echo "<td>Hours Worked:<br><input class=\"timeValue\" type=\"number\" step=\"any\" min=\"0\" class=\"hours\" name=\"contents[]\"></td>";
                echo "<td>Hours Worked:<br><input class=\"timeValue\" type=\"number\" step=\"any\" min=\"0\" class=\"hours\" name=\"contents[]\"></td>";
                echo "<td><button name=\"delete\" onClick=\"deleteRow(this)\">Delete Row</button></td>";
                echo "</tr>";
              }
              else
              {
                while ($row = mysqli_fetch_array($results))
                {
                  echo "<tr>";
                  echo "<td>Date:<br><input class=\"dateValue\" type=\"date\" name=\"date[]\" value='". $row['Date'] . "' required></td>";
                  echo "<td>Project ID:<br><input class=\"projectValue\" type=\"number\" name=\"project[]\" placeholder=\"Example: 001\" value='" . $row['ProjectID'] . "' required></td>";
                  echo "<td>Hours Worked:<br><input class=\"timeValue\" type=\"number\" step=\"any\" min=\"0\" class=\"hours\" name=\"contents[]\" value='" . $row['SunHours'] . "'></td>";
                  echo "<td>Hours Worked:<br><input class=\"timeValue\" type=\"number\" step=\"any\" min=\"0\" class=\"hours\" name=\"contents[]\" value='" . $row['MonHours'] . "'></td>";
                  echo "<td>Hours Worked:<br><input class=\"timeValue\" type=\"number\" step=\"any\" min=\"0\" class=\"hours\" name=\"contents[]\" value='" . $row['TuesHours'] . "'></td>";
                  echo "<td>Hours Worked:<br><input class=\"timeValue\" type=\"number\" step=\"any\" min=\"0\" class=\"hours\" name=\"contents[]\" value='" . $row['WedHours'] . "'></td>";
                  echo "<td>Hours Worked:<br><input class=\"timeValue\" type=\"number\" step=\"any\" min=\"0\" class=\"hours\" name=\"contents[]\" value='" . $row['ThursHours'] . "'></td>";
                  echo "<td>Hours Worked:<br><input class=\"timeValue\" type=\"number\" step=\"any\" min=\"0\" class=\"hours\" name=\"contents[]\" value='" . $row['FriHours'] . "'></td>";
                  echo "<td>Hours Worked:<br><input class=\"timeValue\"   type=\"number\" step=\"any\" min=\"0\" class=\"hours\" name=\"contents[]\" value='" . $row['SatHours'] . "'></td>";
                  echo "<td><button name=\"delete\" onClick=\"deleteRow(this)\">Delete Row</button></td>";
                  echo "</tr>";
                }
              }
            ?>
          </table>

          <li class="buttons">
            <button type="submit" name="save">Save Timesheet</button>
            <button id="submit" type="submit" name="submit">Submit Timesheet</button>
          </li>

        </div>

      </form>

    </div>
    <img id="bottom" src="images/bottom.png" alt="">

  </body>

</html>
