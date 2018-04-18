<?php
	session_start();
	include '../config.php';
	include '../redirect.php';

	$employee_id = $_SESSION['updateEmployee'];

	$stmt = $conn -> prepare("SELECT FName, LName, PhoneNum, Email, StreetAddress, AddressLine2, City, State, ZipCode, PayScale, AccessLevel, CompanyID FROM employee WHERE EmployeeID = ?");
	$stmt -> bind_param('i', $employee_id);
	$stmt -> execute();
	$stmt -> bind_result($firstName, $lastName, $phoneNum, $email, $streetAddress, $streetAddress2, $city, $state, $zip, $payScale, $accessLevel, $company);
	$stmt -> fetch();

	$phone_1 = substr($phoneNum, 0, 3);
	$phone_2 = substr($phoneNum, 3, 3);
	$phone_3 = substr($phoneNum, 6, 4);

	$stmt -> close();
	$conn -> next_result();

	if(isset($_POST["submit"]))
  {
		$stmt = $conn -> prepare("UPDATE employee SET FName = ?, LName = ?, PhoneNum = ?, Email = ?, StreetAddress = ?, AddressLine2 = ?, City = ?, State = ?, ZipCode = ?, PayScale = ?, AccessLevel = ?, CompanyID = ? WHERE employeeID = ?");

		$phone = $_POST["phone_1"].$_POST["phone_2"].$_POST["phone_3"];

    $stmt -> bind_param(
			'sssssssssdiii',
			$_POST["firstName"],
			$_POST["lastName"],
			$phone,
			$_POST["email"],
      $_POST["streetAddress"],
      $_POST["streetAddress2"],
      $_POST["city"],
      $_POST["state"],
      $_POST["zip"],
      $_POST["payScale"],
      $_POST["accessLevel"],
      $_POST["company"],
			$employee_id);

    if($stmt -> execute() === TRUE)
		{
			redirect("updateEmployee.php");
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
		<title>Update Employee</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

		<link rel="stylesheet" type="text/css" href="css/view.css" media="all">
		<script type="text/javascript" src="js/view.js"></script>
		<script type="text/javascript" src="js/calendar.js"></script>
	</head>

	<body id="main_body">

		<img id="top" src="images/top.png" alt="">
		<div id="form_container">

			<h1><a></a></h1>

			<form class="appnitro"  method="post" action="" target="">

				<div class="form_description">
					<h2>Update Employee</h2>
				</div>

				<ul>

					<li ><!--used to break-->
						<label class="description">Name*</label>
						<span>
							<input name="firstName" class="element text" maxlength="255" size="8" value="<?php echo $firstName; ?>" required>
							<label>First</label>
						</span>

						<span>
							<input name="lastName"class="element text" maxlength="255" size="14" value="<?php echo $lastName; ?>">
							<label>Last</label>
						</span><p class="guidelines" id="guide_1"><small>requried</small></p>
					</li>

					<li><!--used to break-->
						<label class="description" >Phone*</label>
						<span>
							<input name="phone_1" class="element text" size="3" maxlength="3" type="text" value="<?php echo $phone_1; ?>"> -
							<label>(###)</label>
						</span>

						<span>
							<input name="phone_2" class="element text" size="3" maxlength="3"  type="text" value="<?php echo $phone_2; ?>"> -
							<label>###</label>
						</span>

						<span>
							<input name="phone_3"class="element text" size="4" maxlength="4"  type="text" value="<?php echo $phone_3; ?>">
							<label>####</label>
						</span><p class="guidelines" id="guide_1"><small>requried</small></p>
					</li>

					<li ><!--used to break-->
						<label class="description" >Email*</label>
						<div>
							<input name="email" class="element text medium" type="text" maxlength="255" value="<?php echo $email; ?>">
						</div> <p class="guidelines" id="guide_1"><small>requried</small></p>
					</li>

					<li><!--used to break-->
						<span>
							<label class="description">Address*</label>
						</span><p class="guidelines" id="guide_1"><small>requried</small></p>

						<div>
							<input name="streetAddress" class="element text large" type="text" value="<?php echo $streetAddress; ?>">
							<label>Street Address</label>
						</div>

						<div>
							<input name="streetAddress2" class="element text large" type="text" value="<?php echo $streetAddress2; ?>">
							<label>Address Line 2</label>
						</div>

						<div class="left">
							<input name="city" class="element text medium" type="text" value="<?php echo $city; ?>">
							<label>City</label>
						</div>

						<div class="right">
							<input name="state" class="element text medium" type="text" value="<?php echo $state; ?>">
							<label>State</label>
						</div>

						<div>
							<input name="zip" class="element text medium" maxlength="15" type="text" value="<?php echo $zip; ?>">
							<label>Zip Code</label>
						</div>
					</li>

					<li class="section_break"><!-- section break -->
						<p></p>
					</li>

          <li>
            <label class="description">Pay Scale</label>
            <div>
              <input name="payScale" class="element text medium" type="text" maxlength="255" value="<?php echo $payScale; ?>">
            </div>
          </li>

          <li>
            <label class="description">Access Level*</label>
            <div>
              <select class="element select medium" name="accessLevel">
                <option value="" selected="selected"></option>
                <option <?php if($accessLevel == 1) echo 'selected'; ?> value="1" >Super Admin</option>
                <option <?php if($accessLevel == 2) echo 'selected'; ?> value="2" >Admin</option>
                <option <?php if($accessLevel == 3) echo 'selected'; ?> value="3" >User</option>
              </select>
            </div> <p class="guidelines" id="guide_1"><small>requried</small></p>
          </li>

          <li>
            <label class="description">Company</label>
            <div>
              <input name="company" class="element text medium" type="text" maxlength="255" value="<?php echo $company; ?>">
            </div>
          </li>

          <li>
            <label class="description">Password*</label>
            <div>
              <input name="password" class="element text medium" type="text" maxlength="255">
            </div> <p class="guidelines" id="guide_1"><small>requried</small></p>
          </li>

					<li class="buttons">
						<input type="hidden" name="form_id" value="2683" />
						<input id="saveForm" class="button_text" type="submit" name="submit" value="Submit" />
					</li>

				</ul>

			</form>

			<div id="footer"></div>

		</div>
		<img id="bottom" src="images/bottom.png" alt="">
	</body>
</html>
