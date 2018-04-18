<?php
  include '../config.php';
  include '../generateID.php';

  if(isset($_POST["submit"]))
  {
    $stmt = $conn -> prepare("INSERT INTO employee (EmployeeID, FName, LName, PhoneNum, Email, StreetAddress, AddressLine2, City, State, ZipCode, PayScale, AccessLevel, CompanyID, Password)
      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $employee_id = generateID("EmployeeID", "employee", 10000000, 99999999);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $phone = $_POST["phone_1"].$_POST["phone_2"].$_POST["phone_3"];

    $stmt -> bind_param(
			'isssssssssdiis',
      $employee_id,
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
      $password
    );

    $stmt -> execute();
  }
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<title>Add Employee</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

		<link rel="stylesheet" type="text/css" href="css/view.css" media="all">
		<script type="text/javascript" src="js/view.js"></script>
		<script type="text/javascript" src="js/calendar.js"></script>
	</head>

	<body id="main_body">

		<img id="top" src="images/top.png" alt="">
		<div id="form_container">

			<h1><a></a></h1>

			<form id="addEmployee" class="appnitro"  method="post" action="" target="">

				<div class="form_description">
					<h2>Add Employee</h2>
				</div>

				<ul>

					<li ><!--used to break-->
						<label class="description">Name*</label>
						<span>
							<input name="firstName" class="element text" maxlength="255" size="8" required>
							<label>First</label>
						</span>

						<span>
							<input name="lastName"class="element text" maxlength="255" size="14">
							<label>Last</label>
						</span><p class="guidelines" id="guide_1"><small>requried</small></p>
					</li>

					<li><!--used to break-->
						<label class="description" >Phone*</label>
						<span>
							<input name="phone_1" class="element text" size="3" maxlength="3" type="text"> -
							<label>(###)</label>
						</span>

						<span>
							<input name="phone_2" class="element text" size="3" maxlength="3"  type="text"> -
							<label>###</label>
						</span>

						<span>
							<input name="phone_3"class="element text" size="4" maxlength="4"  type="text">
							<label>####</label>
						</span><p class="guidelines" id="guide_1"><small>requried</small></p>
					</li>

					<li ><!--used to break-->
						<label class="description" >Email*</label>
						<div>
							<input name="email" class="element text medium" type="text" maxlength="255">
						</div> <p class="guidelines" id="guide_1"><small>requried</small></p>
					</li>

					<li><!--used to break-->
						<div>
							<label class="description">Address*</label>
						</div><p class="guidelines" id="guide_1"><small>requried</small></p>

						<div>
							<input name="streetAddress" class="element text large" value="" type="text">
							<label>Street Address</label>
						</div>

						<div>
							<input name="streetAddress2" class="element text large" value="" type="text">
							<label>Address Line 2</label>
						</div>

						<div class="left">
							<input name="city" class="element text medium" value="" type="text">
							<label>City</label>
						</div>

						<div class="right">
							<input name="state" class="element text medium" value="" type="text">
							<label>State</label>
						</div>

						<div>
							<input name="zip" class="element text medium" maxlength="15" value="" type="text">
							<label>Zip Code</label>
						</div>
					</li>

					<li class="section_break"><!-- section break -->
						<p></p>
					</li>

          <li>
            <label class="description">Pay Scale</label>
            <div>
              <input name="payScale" class="element text medium" type="text" maxlength="255">
            </div>
          </li>

          <li>
            <label class="description">Access Level*</label>
            <div>
              <select class="element select medium" name="accessLevel">
                <option value="" selected="selected"></option>
                <option value="1" >Super Admin</option>
                <option value="2" >Admin</option>
                <option value="3" >User</option>
              </select>
            </div> <p class="guidelines" id="guide_1"><small>requried</small></p>
          </li>

          <li>
            <label class="description">Company</label>
            <div>
              <input name="company" class="element text medium" type="text" maxlength="255">
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
