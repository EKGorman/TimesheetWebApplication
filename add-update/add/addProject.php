<?php
  include '../../config.php';
  include '../../generateID.php';

	$project_id = generateID("ProjectID", "project", 1000, 9999);

	if(isset($_POST["submit"]))
  {
    $stmt = $conn -> prepare("INSERT INTO project (ProjectID, ProjectName, CompanyID, ManagerID, ActiveProject)
      VALUES (?, ?, ?, ?, ?)");

    $stmt -> bind_param(
			'isiii',
      $project_id,
      $_POST["projectName"],
			$_POST["companyID"],
      $_POST["managerID"],
      $_POST["projectActivity"]
		);

    $stmt -> execute();
  }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Add Project</title>

		<link rel="stylesheet" type="text/css" href="../css/view.css" media="all">
	</head>

	<body>

		<img id="top" src="../images/top.png" alt=""><!--background shadow-->
		<div id="form_container">

			<h1><a></a></h1>

			<form class="appnitro"  method="post" action="">

				<div class="form_description">
					<h2>Add Project</h2>
				</div>

				<ul>

          <li>
						<label class="description">Project ID</label>
						<div>
							<input name="projectID" id="id" class="text medium" type="text" maxlength="255" value="<?php echo $project_id; ?>" readonly>
						</div>
					</li>

          <li>
						<label class="description">Project Name*</label>
						<div>
							<input name="projectName" class="text medium" type="text" maxlength="255" required>
						</div> <p class="guidelines"><small>requried</small></p>
					</li>

					<li>
						<label class="description">Company ID*</label>
						<div>
							<select name="companyID" class="select medium" required>
                <option value="" selected="selected"></option>
                <?php
                  $sql = "SELECT CompanyID FROM company";
                  $results = mysqli_query($conn, $sql);
                  $count = 1;

                  while ($row = mysqli_fetch_array($results))
                  {
                    echo "<option value='" . $row['CompanyID'] . "'>" . $row['CompanyID'] . "</option>";
                  }
                ?>
              </select>
						</div> <p class="guidelines"><small>requried</small></p>
					</li>

					<li>
						<label class="description">Manager ID*</label>
						<div>
							<select name="managerID" class="select medium" required>
                <option value="" selected="selected"></option>
                <?php
                  $sql = "SELECT EmployeeID, FName, LName FROM Employee WHERE AccessLevel = 1 OR AccessLevel = 2";
                  $results = mysqli_query($conn, $sql);
                  $count = 1;

                  while ($row = mysqli_fetch_array($results))
                  {
                    echo "<option value='" . $row['EmployeeID'] . "'>" . $row['FName'] . " " . $row['LName'] . "</option>";
                  }
                ?>
              </select>
						</div> <p class="guidelines"><small>requried</small></p>
					</li>

					<li>
						<label class="description">Project Activity*</label>
						<div>
							<select class="element select medium" name="projectActivity" required>
								<option value="" selected="selected"></option>
								<option value="0" >Active</option>
								<option value="1" >Inactive</option>
							</select>
						</div> <p class="guidelines"><small>requried</small></p>
					</li>

					<li class="buttons">
						<input class="button_text" type="submit" name="submit" value="Submit" />
					</li>

				</ul>

			</form>

		</div>
		<img id="bottom" src="../images/bottom.png" alt="">
	</body>
</html>
