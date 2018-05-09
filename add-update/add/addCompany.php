<?php
	include '../../config.php';
	include '../../redirect.php';
	include '../../generateID.php';
	session_start();

	if($_SESSION['AccessLevel'] != 1 || $_SESSION['loggedIn'] != true)
  {
    redirect("../login/login.php");
  }

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

		<link rel="stylesheet" type="text/css" href="../css/view.css" media="all">
	</head>

	<body>

		<img id="top" src="../images/top.png">
		<div id="form_container">

			<h1><a></a></h1>

			<form class="appnitro"  method="post">

				<div class="form_description">
					<h2>Add Company</h2>
				</div>

				<ul >

					<li>
						<label class="description">Company ID</label>
						<div>
							<input name="companyID" id="id" class="text medium" type="text" maxlength="255" value="<?php echo $company_id; ?>" readonly>
						</div>
					</li>

					<li>
						<label class="description">Company Name*</label>
						<div>
							<input name="companyName" class="text medium" type="text" maxlength="255" required>
						</div> <p class="guidelines"><small>requried</small></p>
					</li>

					<li><!--used to break-->
						<div>
							<label class="description">Address</label>
						</div> <p class="guidelines"><small>requried</small></p>

						<div>
							<input name="streetAddress" class="text large" type="text" required>
							<label>Street Address*</label>
						</div>

						<div>
							<input name="streetAddress2" class="text large" type="text">
							<label>Address Line 2</label>
						</div>

						<div class="left">
							<input name="city" class="text medium" type="text" required>
							<label>City*</label>
						</div>

						<div class="right">
							<select name="state" class="select medium" required>
                <option value="" selected="selected"></option>
              	<option value="AL">Alabama</option>
              	<option value="AK">Alaska</option>
              	<option value="AZ">Arizona</option>
              	<option value="AR">Arkansas</option>
              	<option value="CA">California</option>
              	<option value="CO">Colorado</option>
              	<option value="CT">Connecticut</option>
              	<option value="DE">Delaware</option>
              	<option value="DC">District Of Columbia</option>
              	<option value="FL">Florida</option>
              	<option value="GA">Georgia</option>
              	<option value="HI">Hawaii</option>
              	<option value="ID">Idaho</option>
              	<option value="IL">Illinois</option>
              	<option value="IN">Indiana</option>
              	<option value="IA">Iowa</option>
              	<option value="KS">Kansas</option>
              	<option value="KY">Kentucky</option>
              	<option value="LA">Louisiana</option>
              	<option value="ME">Maine</option>
              	<option value="MD">Maryland</option>
              	<option value="MA">Massachusetts</option>
              	<option value="MI">Michigan</option>
              	<option value="MN">Minnesota</option>
              	<option value="MS">Mississippi</option>
              	<option value="MO">Missouri</option>
              	<option value="MT">Montana</option>
              	<option value="NE">Nebraska</option>
              	<option value="NV">Nevada</option>
              	<option value="NH">New Hampshire</option>
              	<option value="NJ">New Jersey</option>
              	<option value="NM">New Mexico</option>
              	<option value="NY">New York</option>
              	<option value="NC">North Carolina</option>
              	<option value="ND">North Dakota</option>
              	<option value="OH">Ohio</option>
              	<option value="OK">Oklahoma</option>
              	<option value="OR">Oregon</option>
              	<option value="PA">Pennsylvania</option>
              	<option value="RI">Rhode Island</option>
              	<option value="SC">South Carolina</option>
              	<option value="SD">South Dakota</option>
              	<option value="TN">Tennessee</option>
              	<option value="TX">Texas</option>
              	<option value="UT">Utah</option>
              	<option value="VT">Vermont</option>
              	<option value="VA">Virginia</option>
              	<option value="WA">Washington</option>
              	<option value="WV">West Virginia</option>
              	<option value="WI">Wisconsin</option>
              	<option value="WY">Wyoming</option>
              </select>
							<label>State*</label>
						</div>

						<div>
							<input name="zip" class="text medium" maxlength="15" type="text" required>
							<label>Zip Code*</label>
						</div>
					</li>

					<li><!--used to break-->
						<label class="description" >Phone*</label>
						<span>
							<input name="phone_1" class="text" size="3" maxlength="3" type="text" required> -
							<label>(###)</label>
						</span>

						<span>
							<input name="phone_2" class="text" size="3" maxlength="3"  type="text" required> -
							<label>###</label>
						</span>

						<span>
							<input name="phone_3"class="text" size="4" maxlength="4"  type="text" required>
							<label>####</label>
						</span><p class="guidelines"><small>requried</small></p>
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
