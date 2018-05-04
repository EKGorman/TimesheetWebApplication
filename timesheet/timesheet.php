<?php
  include '../config.php';

  $employee_id = 74666395;

  if(isset($_POST["submit"]))
  {
    $stmt = $conn -> prepare("INSERT INTO time (Date, HoursWorked, ProjectID, EmployeeID) VALUES(?, ?, ?, ?)");
    $stmt -> bind_param(
      'sdii',
      $date,
      $contents,
      $project,
      $employee_id
    );

    $date = date('Y-m-d', strtotime('-7 days', strtotime('next Sunday', strtotime($_POST["date"]))));
    echo $date;

    $rowNum = count($_POST["project"]);
    for($row = 0; $row < $rowNum; $row++)
    {
      $project = $_POST["project"][$row];

      for($col = $row * 7; $col < $row * 7 + 7; $col++)
      {
        $contents = $_POST["contents"][$col];

        if($contents != 0 && $contents != "")
        {
          $stmt->execute();
        }
      }
    }
  }
?>


<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <title>timesheetApp</title>

    <link rel='stylesheet prefetch' href='http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css'>
    <link rel='stylesheet prefetch' href='http://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css'>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <style>
      h1
      {
        color: dimgrey;
        font-family: sans-serif;
        font-weight: normal;
        white-space: nowrap;
        padding: 0.5em 1rem;border-bottom: 1px solid gainsboro;
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

    <SCRIPT language="javascript">

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

      /*function deleteRow(tableID)
      {
        try
        {
          var table = document.getElementById(tableID);
          var rowCount = table.rows.length;

          for(var i=0; i<rowCount; i++)
          {
            var row = table.rows[i];
            var chkbox = row.cells[0].childNodes[0];
            if(null != chkbox && true == chkbox.checked)
            {
              if(rowCount <= 1)
              {
                alert("Cannot delete all the rows.");
                break;
              }
              table.deleteRow(i);
              rowCount--;
              i--;
            }
          }
        }
        catch(e)
        {
          alert(e);
        }
      }*/
    </SCRIPT>
  </head>

  <body>
    <div class="container">
      <h1>TimeSheet</h1>
      <br>
      <br>
      <div id="table" class="table-editable">
        <form method="post">
          <p>Week Start Date: <input type="date" name="date"> </p>
          <table id="dataTable" class="table table-fixed">
            <thead>
              <tr>
                <th><b>Project ID</b></th>
                <th><b>Sunday</b></th>
                <th><b>Monday</b></th>
                <th><b>Tuesday</b></th>
                <th><b>Wednesday</b></th>
                <th><b>Thursday</b></th>
                <th><b>Friday</b></th>
                <th><b>Saturday</b></th>
                <th><span class="table-add glyphicon glyphicon-plus" name="add" onclick="addRow('dataTable')"></span></th>
              </tr>
            </thead>

            <tr>
              <td>Project ID:<input type="number" name="project[]" placeholder="Example: 001" required></td>

              <td>Hours Worked:<input type="number" step="any" min="0" name="contents[]"></td>
              <td>Hours Worked:<input type="number" step="any" min="0" name="contents[]"></td>
              <td>Hours Worked:<input type="number" step="any" min="0" name="contents[]"></td>
              <td>Hours Worked:<input type="number" step="any" min="0" name="contents[]"></td>
              <td>Hours Worked:<input type="number" step="any" min="0" name="contents[]"></td>
              <td>Hours Worked:<input type="number" step="any" min="0" name="contents[]"></td>
              <td>Hours Worked:<input type="number" step="any" min="0" name="contents[]"></td>
              <!--<td><span class="table-remove glyphicon glyphicon-remove"></span></td>-->
            </tr>
          </table>
          <button id="export-btn" class="btn btn-primary" type="submit" name="submit" style="float: right;">Submit Timesheet</button>
          <button id="export-btn" class="btn btn-primary" type="submit" name="save" style="float: left;">Save Timesheet</button>
        </form>
      </div>
    </div>

    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    <script src='http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js'></script>
    <script src='https://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js'></script>
    <script src='http://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.6.0/underscore.js'></script>
    <script  src="js/index.js"></script>
  </body>
</html>
