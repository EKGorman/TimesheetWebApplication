<?php
  session_start();
  include '../../config.php';
  include '../../redirect.php';

	$project_id = $_SESSION['updateProject'];

	$stmt = $conn -> prepare("SELECT ProjectName, CompanyID, ManagerID, ActiveProject FROM project WHERE ProjectID = ?");
	$stmt -> bind_param('i', $project_id);
	$stmt -> execute();
	$stmt -> bind_result($projectName, $companyID, $managerID, $activeProject);
	$stmt -> fetch();

	$stmt -> close();
	$conn -> next_result();

	if(isset($_POST["submit"]))
  {
    $stmt = $conn -> prepare("UPDATE project SET ProjectName = ?, CompanyID = ?, ManagerID = ?, ActiveProject = ? WHERE ProjectID = ?");

    $stmt -> bind_param(
			'siiii',
      $_POST["projectName"],
			$_POST["companyID"],
      $_POST["managerID"],
      $_POST["projectActivity"],
			$project_id
		);

    if($stmt -> execute() === TRUE)
		{
			redirect("updateProject.php");
		}
		else
		{
			echo "Error updating record: " . $conn->error;
		}
  }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Update Project</title>

		<link rel="stylesheet" type="text/css" href="../css/view.css" media="all">
	</head>

	<body>

		<img id="top" src="../images/top.png" alt="">
		<div id="form_container">

			<h1><a></a></h1>

			<form class="appnitro"  method="post" action="">

				<div class="form_description">
					<h2>Update Project</h2>
				</div>

				<ul>

          <li>
						<label class="description">Project ID </label>
						<div>
							<input name="projectID" id="id" class="element text medium" type="text" maxlength="255" value="<?php echo $project_id; ?>" readonly>
						</div>
					</li>

          <li>
						<label class="description">Project Name*</label>
						<div>
							<input name="projectName" class="text medium" type="text" maxlength="255" value="<?php echo $projectName; ?>" required>
						</div> <p class="guidelines"><small>requried</small></p>
					</li>

          <li>
            <label class="description">Company ID*</label>
            <div>
							<select name="company" class="select medium" required>
                <option value="" selected="selected"></option>
                <?php
                  $sql = "SELECT CompanyID FROM company";
                  $results = mysqli_query($conn, $sql);

                  while ($row = mysqli_fetch_array($results))
                  {
										if($companyID == $row['CompanyID'])
										{
											echo "<option selected value='" . $row['CompanyID'] . "'>" . $row['CompanyID'] . "</option>";
										}
                    else
										{
											echo "<option value='" . $row['CompanyID'] . "'>" . $row['CompanyID'] . "</option>";
										}
                  }
                ?>
              </select>
            </div> <p class="guidelines"><small>requried</small></p>
          </li>

					<li>
						<label class="description">Manager ID*</label>
						<div>
							<input name="managerID" class="text medium" type="text" maxlength="255" value="<?php echo $managerID; ?>" required>
						</div> <p class="guidelines"><small>requried</small></p>
					</li>

					<li>
						<label class="description">Project Activity*</label>
						<div>
							<select class="select medium" name="projectActivity" required>
								<option value="" selected="selected"></option>
								<option <?php if($activeProject == 0) echo 'selected'; ?> value="0" >Active</option>
								<option <?php if($activeProject == 1) echo 'selected'; ?> value="1" >Inactive</option>
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
