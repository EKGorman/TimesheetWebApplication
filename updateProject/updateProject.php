<?php
  include '../config.php';

	$project_id = 3458;

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
			echo "Recorded Successfully";
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

		<link rel="stylesheet" type="text/css" href="css/view.css" media="all">
		<script type="text/javascript" src="view.js"></script>
	</head>

	<body id="main_body" >

		<img id="top" src="top.png" alt=""><!--background shadow-->
		<div id="form_container">

			<h1><a></a></h1>

			<form id="form_2683" class="appnitro"  method="post" action="">

				<div class="form_description">
					<h2>Update Project</h2>
				</div>

				<ul>

					<li><!-- section break -->
						<label class="description">Project Name </label>
						<div>
							<input name="projectName" class="element text medium" type="text" maxlength="255" value="<?php echo $projectName; ?>">
						</div>
					</li>

					<li>
						<label class="description">Project ID </label>
						<div>
							<input name="projectID" class="element text medium" type="text" maxlength="255" value="<?php echo $project_id; ?>" readonly>
						</div> <p class="guidelines" id="guide_1"><small>requried</small></p>
					</li>

					<li>
						<label class="description">Company ID </label>
						<div>
							<input name="companyID" class="element text medium" type="text" maxlength="255" value="<?php echo $companyID; ?>">
						</div>
					</li>

					<li>
						<label class="description">Manager ID </label>
						<div>
							<input name="managerID" class="element text medium" type="text" maxlength="255" value="<?php echo $managerID; ?>" required>
						</div> <p class="guidelines" id="guide_1"><small>requried</small></p>
					</li>

					<li>
						<label class="description">Project Activity </label>
						<div>
							<select class="element select medium" name="projectActivity" required>
								<option value="" selected="selected"></option>
								<option <?php if($activeProject == 0) echo 'selected'; ?> value="0" >Active</option>
								<option <?php if($activeProject == 1) echo 'selected'; ?> value="1" >Inactive</option>
							</select>
						</div> <p class="guidelines" id="guide_1"><small>requried</small></p>
					</li>

					<li class="buttons">
						<input type="hidden" name="form_id" value="2683" />
						<input id="saveForm" class="button_text" type="submit" name="submit" value="Submit" />
					</li>

				</ul>

			</form>

		</div>
		<img id="bottom" src="bottom.png" alt="">
	</body>
</html>
