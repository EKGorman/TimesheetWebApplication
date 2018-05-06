<?php
  include '../config.php';

  $employee_id = 74666395;

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

    <link rel='stylesheet prefetch' href='http://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css'>
    <link rel="stylesheet" href="css/style.css">

    <style>
      h1
      {
        color: dimgrey;
        font-family: sans-serif;
        font-weight: normal;
        white-space: nowrap;
        padding: 0.5em 1rem;
        border-bottom: 1px solid gainsboro;
      }
      .other
      {
        background-color: #FFF8DC;
      }
      #other
      {
        background-color: #FFF8DC;
      }
    </style>

    <script type="text/javascript">

      function addRow(tableID)
      {
        var table = document.getElementById(tableID);

        var rowCount = table.rows.length;
        var row = table.insertRow(rowCount);

        var colCount = table.rows[1].cells.length;

        for(var i=0; i<colCount; i++)
        {
          var newcell	= row.insertCell(i);

          newcell.innerHTML = table.rows[1].cells[i].innerHTML;
          //alert(newcell.childNodes);
          newcell.childNodes[1].value = "";
        }
      }

      function deleteRow(aRow)
      {
        var tbl = document.getElementById('dataTable')
        var lastRow = tbl.rows.length;
        if(lastRow > 2)
        {
          tbl.deleteRow(aRow.parentElement.parentElement.rowIndex);
        }
      }
    </script>
  </head>

  <body>
    <div class="container">
      <h1>TimeSheet</h1>
      <br>
      <br>
      <div id="table" class="table-editable">
        <form method="post">
          <table id="dataTable" class="table table-fixed">
            <thead>
              <tr>
                <th>Date</th>
                <th>Project ID</th>
                <th>Sunday</th>
                <th>Monday</th>
                <th>Tuesday</th>
                <th>Wednesday</th>
                <th>Thursday</th>
                <th>Friday</th>
                <th>Saturday</th>
                <th><span class="table-add glyphicon glyphicon-plus" name="add" onclick="addRow('dataTable')"></span></th>
              </tr>
            </thead>

            <?php
              $sql = "SELECT Date, SunHours, MonHours, TuesHours, WedHours, ThursHours, FriHours, SatHours, ProjectID FROM time WHERE EmployeeID = $employee_id and Submitted = 0";
              $results = mysqli_query($conn, $sql);

              while ($row = mysqli_fetch_array($results))
              {

                echo "<tr>";
                echo "<td>Date:<input type=\"date\" name=\"date[]\" value='". $row['Date'] . "' required></td>";
                echo "<td>Project ID:<input type=\"number\" name=\"project[]\" placeholder=\"Example: 001\" value='" . $row['ProjectID'] . "' required></td>";
                echo "<td>Hours Worked:<input type=\"number\" step=\"any\" min=\"0\" class=\"hours\" name=\"contents[]\" value='" . $row['SunHours'] . "'></td>";
                echo "<td>Hours Worked:<input type=\"number\" step=\"any\" min=\"0\" class=\"hours\" name=\"contents[]\" value='" . $row['MonHours'] . "'></td>";
                echo "<td>Hours Worked:<input type=\"number\" step=\"any\" min=\"0\" class=\"hours\" name=\"contents[]\" value='" . $row['TuesHours'] . "'></td>";
                echo "<td>Hours Worked:<input type=\"number\" step=\"any\" min=\"0\" class=\"hours\" name=\"contents[]\" value='" . $row['WedHours'] . "'></td>";
                echo "<td>Hours Worked:<input type=\"number\" step=\"any\" min=\"0\" class=\"hours\" name=\"contents[]\" value='" . $row['ThursHours'] . "'></td>";
                echo "<td>Hours Worked:<input type=\"number\" step=\"any\" min=\"0\" class=\"hours\" name=\"contents[]\" value='" . $row['FriHours'] . "'></td>";
                echo "<td>Hours Worked:<input type=\"number\" step=\"any\" min=\"0\" class=\"hours\" name=\"contents[]\" value='" . $row['SatHours'] . "'></td>";
                echo "<td><input type=\"button\" value=\"Delete Row\" name=\"delete[]\" onClick=\"deleteRow(this)\"></span></td>";
                echo "</tr>";
              }
            ?>

            <tr>
              <td>Date:<input type="date" name="date[]" value="<?php echo $startWeek ?>" required></td>
              <td>Project ID:<input type="number" name="project[]" placeholder="Example: 001" required></td>
              <td>Hours Worked:<input type="number" step="any" min="0" class="hours" name="contents[]"></td>
              <td>Hours Worked:<input type="number" step="any" min="0" class="hours" name="contents[]"></td>
              <td>Hours Worked:<input type="number" step="any" min="0" class="hours" name="contents[]"></td>
              <td>Hours Worked:<input type="number" step="any" min="0" class="hours" name="contents[]"></td>
              <td>Hours Worked:<input type="number" step="any" min="0" class="hours" name="contents[]"></td>
              <td>Hours Worked:<input type="number" step="any" min="0" class="hours" name="contents[]"></td>
              <td>Hours Worked:<input type="number" step="any" min="0" class="hours" name="contents[]"></td>
              <td><input type="button" value="Delete Row" name="delete[]" onClick="deleteRow(this)"></span></td>
            </tr>
          </table>
          <button id="export-btn" class="btn btn-primary" type="submit" name="submit" style="float: right;">Submit Timesheet</button>
          <button id="export-btn" class="btn btn-primary" type="submit" name="save" style="float: left;">Save Timesheet</button>
        </form>
      </div>
    </div>
  </body>
</html>
