<?php
	include '../config.php';
	include '../generateID.php';

	$company_id = generateID("CompanyID", "Company", 1000, 9999);

	if(isset($_POST["submit"]))
	{
		$stmt = $conn -> prepare("INSERT INTO company (CompanyID, CName, StreetAddress, AddressLine2, City, State, ZipCode, PhoneNum)
			VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

		$phone = $_POST["phone_1"].$_POST["phone_2"].$_POST["phone_3"];

		$stmt -> bind_param(
			'issssssi',
			$company_id,
			$_POST["companyName"],
			$_POST["streetAddress"],
			$_POST["streetAddress2"],
			$_POST["city"],
			$_POST["state"],
			$_POST["zip"],
			$phone
		);

		$stmt -> execute();
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<title>Add Company</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

		<link rel="stylesheet" type="text/css" href="css/view.css" media="all">
		<script type="text/javascript" src="js/view.js"></script>
	</head>

	<body id="main_body" >

		<img id="top" src="images/top.png" alt=""><!--background shadow-->
		<div id="form_container">

			<h1><a></a></h1>

			<form id="form_Project" class="appnitro"  method="post" action="">

				<div class="form_description">
					<h2>Add Company</h2>
				</div>

				<ul >

					<li><!-- section break -->
						<label class="description">Company ID</label>
						<div>
							<input name="companyID" class="element text medium" type="text" maxlength="255" value="<?php echo $company_id; ?>" readonly>
						</div> <p class="guidelines" id="guide_1"><small>requried</small></p>
					</li>

					<li>
						<label class="description">Company Name*</label>
						<div>
							<input name="companyName" class="element text medium" type="text" maxlength="255" required>
						</div> <p class="guidelines" id="guide_1"><small>requried</small></p>
					</li>

					<li><!--used to break-->
						<div>
							<label class="description">Address*</label>
						</div><p class="guidelines" id="guide_1"><small>requried</small></p>

						<div>
							<input name="streetAddress" class="element text large" type="text">
							<label>Street Address</label>
						</div>

						<div>
							<input name="streetAddress2" class="element text large" type="text">
							<label>Address Line 2</label>
						</div>

						<div class="left">
							<input name="city" class="element text medium" type="text">
							<label>City</label>
						</div>

						<div class="right">
							<input name="state" class="element text medium" type="text">
							<label>State</label>
						</div>

						<div>
							<input name="zip" class="element text medium" maxlength="15" type="text">
							<label>Zip Code</label>
						</div>
					</li>

					<li><!--used to break-->
						<label class="description" >Phone*</label>
						<span>
							<input name="phone_1" class="element text" size="3" maxlength="3" type="text">
							<label>(###)</label>
						</span>

						<span>
							<input name="phone_2" class="element text" size="3" maxlength="3"  type="text">
							<label>###</label>
						</span>

						<span>
							<input name="phone_3"class="element text" size="4" maxlength="4"  type="text">
							<label>####</label>
						</span><p class="guidelines" id="guide_1"><small>requried</small></p>
					</li>

					<li class="buttons">
						<input type="hidden" name="form_id" value="2683" />
						<input id="saveForm" class="button_text" type="submit" name="submit" value="Submit" />
					</li>

				</ul>

			</form>

		</div>

		<img id="bottom" src="images/bottom.png" alt="">
	</body>
</html>
