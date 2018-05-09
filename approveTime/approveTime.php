<?php
	include '../config.php';
	include '../redirect.php';
	session_start();

	if($_SESSION['AccessLevel'] == 3 || $_SESSION['loggedIn'] != true)
  {
    redirect("../login/login.php");
  }

	$username = $_SESSION['EmployeeID'];

	if(isset($_POST['approve']))
	{
		$row = $_POST['approve'];
		$aDate = $_POST["date"][$row];
		$aEmployeeID = $_POST["employeeID"][$row];

		$sql = "UPDATE time SET Approved = 1 WHERE Date = '$aDate' AND EmployeeID = $aEmployeeID";
		mysqli_query($conn, $sql);
	}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<title>Approve Timecards</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

		<link rel="stylesheet" type="text/css" href="css/view.css" media="all">
		<script type="text/javascript" src="js/script.js"></script>
	</head>

	<body id="main_body">

		<img id="top" src="images/top.png" alt=""><!--background shadow-->
		<main id="form_container" style="width: 700px;">

			<h1><a></a></h1>

			<form id="form_Project" class="appnitro"  method="post" action="">

				<div class="form_description">
					<h2>Approve Timecard</h2>
				</div>

				<table id="keywords" cellspacing="0px" cellpadding="10px">
    <thead>
      <tr>
      	<th onclick="sort_table(people, 0, asc1); asc1 *= -1; asc2 = 1;">Week Start Date:<img src="css/arrow.png" alt="arrow" height="15px" width="15px"></th>
        <th onclick="sort_table(people, 1, asc2); asc2 *= -1; asc1 = 1;">Employee ID<img src="css/arrow.png" alt="arrow" height="15px" width="15px"></th>
        <th>Employee Name</th>
        <th>Total Time/Week</th>
        <th>Projects/Week</th>
        <th>Approve Time</th>

      </tr>
    </thead>
    <tbody id="people">
			<?php
				$sql = "SELECT Date, t.EmployeeID, FName, LName, SunHours, MonHours, TuesHours, WedHours, ThursHours, FriHours, SatHours, t.ProjectID
				FROM Time t RIGHT JOIN Project p ON t.ProjectID=p.ProjectID
				LEFT JOIN Employee e ON t.EmployeeID=e.EmployeeID
				WHERE ManagerID = $username AND Submitted = 1 AND Approved = 0";
				$results = mysqli_query($conn, $sql);

				$row = mysqli_fetch_array($results);
				$date = $row['Date'];
				$employeeID = $row['EmployeeID'];
				$employeeName = $row['FName'] . " " . $row['LName'];
				$hoursWorked = "";
				$projectHours = $row['SunHours'] + $row['MonHours'] + $row['TuesHours'] + $row['WedHours'] + $row['ThursHours'] + $row['FriHours'] + $row['SatHours'];
				$projectID = $row['ProjectID'];

				$test = True;
				$count = 1;
				$rowNum = 0;

				while ($row = mysqli_fetch_array($results))
				{
					if($count == 1)
					{
						echo "<tr>";
						echo "<td><input type='hidden' name=\"date[]\" value=" . $date . ">" . $date . "</td>";
						echo "<td><input type='hidden' name=\"employeeID[]\" value=" . $employeeID . ">" . $employeeID . "</td>";
						echo "<td>" . $employeeName . "</td>";
					}
					$count++;

					if($date == $row['Date'] && $row['EmployeeID'] == $employeeID && $row['ProjectID'] == $projectID)
					{
						$projectHours += $row['SunHours'] + $row['MonHours'] + $row['TuesHours'] + $row['WedHours'] + $row['ThursHours'] + $row['FriHours'] + $row['SatHours'];
					}
					elseif($date == $row['Date'] && $row['EmployeeID'] == $employeeID)
					{
						$hoursWorked = $hoursWorked . $projectHours . "<br>";
						$projectID = $projectID . "<br>" . $row['ProjectID'];
						$projectHours = $row['SunHours'] + $row['MonHours'] + $row['TuesHours'] + $row['WedHours'] + $row['ThursHours'] + $row['FriHours'] + $row['SatHours'];
					}
					else
					{
						$hoursWorked = $hoursWorked . $projectHours;
						echo "<td>" . $hoursWorked . "</td>";
						echo "<td>" . $projectID . "</td>";
						echo "<td><button name='approve' value=" . $rowNum . ">Approve</button></td>";
						echo "</tr>";

						$rowNum++;

						$date = $row['Date'];
						$employeeID = $row['EmployeeID'];
						$employeeName = $row['FName'] . " " . $row['LName'];
						$hoursWorked = "";
						$projectHours = $row['SunHours'] + $row['MonHours'] + $row['TuesHours'] + $row['WedHours'] + $row['ThursHours'] + $row['FriHours'] + $row['SatHours'];
						$projectID = $row['ProjectID'];

						echo "<tr>";
						echo "<td>" . $date . "</td>";
						echo "<td>" . $employeeID . "</td>";
						echo "<td>" . $employeeName . "</td>";
					}

					if(mysqli_num_rows($results) == $count)
					{
						$hoursWorked = $hoursWorked . $projectHours;
						echo "<td>" . $hoursWorked . "</td>";
						echo "<td>" . $projectID . "</td>";
						echo "<td><button name='approve' value=" . $rowNum . ">Approve</button></td>";
						echo "</tr>";
					}
				}
			?>
    </tbody>
  </table>

			</form>

		</main>

		<img id="bottom" src="images/bottom.png" alt="">
	</body>
</html>
