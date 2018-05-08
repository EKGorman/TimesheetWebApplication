<?php
	session_start();
	include '../../config.php';
	include '../../redirect.php';

	$company_id = $_SESSION['updateCompany'];

	$stmt = $conn -> prepare("SELECT CName, StreetAddress, AddressLine2, City, State, ZipCode, PhoneNum FROM company WHERE CompanyID = ?");
	$stmt -> bind_param('i', $company_id);
	$stmt -> execute();
	$stmt -> bind_result($companyName, $streetAddress, $streetAddress2, $city, $state, $zip, $phoneNum);
	$stmt -> fetch();

	$phone_1 = substr($phoneNum, 0, 3);
	$phone_2 = substr($phoneNum, 3, 3);
	$phone_3 = substr($phoneNum, 6, 4);

	$stmt -> close();
	$conn -> next_result();

	if(isset($_POST["submit"]))
  {
		$stmt = $conn -> prepare("UPDATE company SET CName = ?, StreetAddress = ?, AddressLine2 = ?, City = ?, State = ?, ZipCode = ?, PhoneNum = ? WHERE CompanyID = ?");

		$phone = $_POST["phone_1"].$_POST["phone_2"].$_POST["phone_3"];

    $stmt -> bind_param(
			'ssssssii',
			$_POST["companyName"],
      $_POST["streetAddress"],
      $_POST["streetAddress2"],
      $_POST["city"],
      $_POST["state"],
      $_POST["zip"],
      $phone,
			$company_id);

    if($stmt -> execute() === TRUE)
		{
			redirect("updateCompany.php");
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
		<title>Update Company</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

		<link rel="stylesheet" type="text/css" href="../css/view.css" media="all">
	</head>

	<body>

		<img id="top" src="../images/top.png" alt=""><!--background shadow-->
		<div id="form_container">

			<h1><a></a></h1>

			<form class="appnitro"  method="post" action="">

				<div class="form_description">
					<h2>Update Company</h2>
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
							<input name="companyName" class="text medium" type="text" maxlength="255" value="<?php echo $companyName; ?>" required>
						</div> <p class="guidelines"><small>requried</small></p>
					</li>

					<li>
						<div>
							<label class="description">Address</label>
						</div><p class="guidelines"><small>requried</small></p>

						<div>
							<input name="streetAddress" class="text large" type="text" value="<?php echo $streetAddress; ?>" required>
							<label>Street Address*</label>
						</div>

						<div>
							<input name="streetAddress2" class="text large" type="text" value="<?php echo $streetAddress2; ?>">
							<label>Address Line 2</label>
						</div>

						<div class="left">
							<input name="city" class="text medium" type="text" value="<?php echo $city; ?>" required>
							<label>City*</label>
						</div>

						<div class="right">
							<select name="state" class="select medium" required>
                <option value="" selected="selected"></option>
              	<option <?php if($state == "AL") echo 'selected'; ?> value="AL">Alabama</option>
              	<option <?php if($state == "AK") echo 'selected'; ?> value="AK">Alaska</option>
              	<option <?php if($state == "AZ") echo 'selected'; ?> value="AZ">Arizona</option>
              	<option <?php if($state == "AR") echo 'selected'; ?> value="AR">Arkansas</option>
              	<option <?php if($state == "CA") echo 'selected'; ?> value="CA">California</option>
              	<option <?php if($state == "CO") echo 'selected'; ?> value="CO">Colorado</option>
              	<option <?php if($state == "CT") echo 'selected'; ?> value="CT">Connecticut</option>
              	<option <?php if($state == "DE") echo 'selected'; ?> value="DE">Delaware</option>
              	<option <?php if($state == "DC") echo 'selected'; ?> value="DC">District Of Columbia</option>
              	<option <?php if($state == "FL") echo 'selected'; ?> value="FL">Florida</option>
              	<option <?php if($state == "GA") echo 'selected'; ?> value="GA">Georgia</option>
              	<option <?php if($state == "HI") echo 'selected'; ?> value="HI">Hawaii</option>
              	<option <?php if($state == "ID") echo 'selected'; ?> value="ID">Idaho</option>
              	<option <?php if($state == "IL") echo 'selected'; ?> value="IL">Illinois</option>
              	<option <?php if($state == "IN") echo 'selected'; ?> value="IN">Indiana</option>
              	<option <?php if($state == "IA") echo 'selected'; ?> value="IA">Iowa</option>
              	<option <?php if($state == "KS") echo 'selected'; ?> value="KS">Kansas</option>
              	<option <?php if($state == "KY") echo 'selected'; ?> value="KY">Kentucky</option>
              	<option <?php if($state == "LA") echo 'selected'; ?> value="LA">Louisiana</option>
              	<option <?php if($state == "ME") echo 'selected'; ?> value="ME">Maine</option>
              	<option <?php if($state == "MD") echo 'selected'; ?> value="MD">Maryland</option>
              	<option <?php if($state == "MA") echo 'selected'; ?> value="MA">Massachusetts</option>
              	<option <?php if($state == "MI") echo 'selected'; ?> value="MI">Michigan</option>
              	<option <?php if($state == "MN") echo 'selected'; ?> value="MN">Minnesota</option>
              	<option <?php if($state == "MS") echo 'selected'; ?> value="MS">Mississippi</option>
              	<option <?php if($state == "MO") echo 'selected'; ?> value="MO">Missouri</option>
              	<option <?php if($state == "MT") echo 'selected'; ?> value="MT">Montana</option>
              	<option <?php if($state == "NE") echo 'selected'; ?> value="NE">Nebraska</option>
              	<option <?php if($state == "NV") echo 'selected'; ?> value="NV">Nevada</option>
              	<option <?php if($state == "NH") echo 'selected'; ?> value="NH">New Hampshire</option>
              	<option <?php if($state == "NJ") echo 'selected'; ?> value="NJ">New Jersey</option>
              	<option <?php if($state == "NM") echo 'selected'; ?> value="NM">New Mexico</option>
              	<option <?php if($state == "NY") echo 'selected'; ?> value="NY">New York</option>
              	<option <?php if($state == "NC") echo 'selected'; ?> value="NC">North Carolina</option>
              	<option <?php if($state == "ND") echo 'selected'; ?> value="ND">North Dakota</option>
              	<option <?php if($state == "OH") echo 'selected'; ?> value="OH">Ohio</option>
              	<option <?php if($state == "OK") echo 'selected'; ?> value="OK">Oklahoma</option>
              	<option <?php if($state == "OR") echo 'selected'; ?> value="OR">Oregon</option>
              	<option <?php if($state == "PA") echo 'selected'; ?> value="PA">Pennsylvania</option>
              	<option <?php if($state == "RI") echo 'selected'; ?> value="RI">Rhode Island</option>
              	<option <?php if($state == "SC") echo 'selected'; ?> value="SC">South Carolina</option>
              	<option <?php if($state == "SD") echo 'selected'; ?> value="SD">South Dakota</option>
              	<option <?php if($state == "TN") echo 'selected'; ?> value="TN">Tennessee</option>
              	<option <?php if($state == "TX") echo 'selected'; ?> value="TX">Texas</option>
              	<option <?php if($state == "UT") echo 'selected'; ?> value="UT">Utah</option>
              	<option <?php if($state == "VT") echo 'selected'; ?> value="VT">Vermont</option>
              	<option <?php if($state == "VA") echo 'selected'; ?> value="VA">Virginia</option>
              	<option <?php if($state == "WA") echo 'selected'; ?> value="WA">Washington</option>
              	<option <?php if($state == "WV") echo 'selected'; ?> value="WV">West Virginia</option>
              	<option <?php if($state == "WI") echo 'selected'; ?> value="WI">Wisconsin</option>
              	<option <?php if($state == "WY") echo 'selected'; ?> value="WY">Wyoming</option>
              </select>
							<label>State*</label>
						</div>

						<div>
							<input name="zip" class="text medium" maxlength="15" type="text" value="<?php echo $zip; ?>">
							<label>Zip Code*</label>
						</div>
					</li>

					<li><!--used to break-->
						<label class="description">Phone*</label>
						<span>
							<input name="phone_1" class="text" size="3" maxlength="3" type="text" value="<?php echo $phone_1; ?>" required> -
							<label>(###)</label>
						</span>

						<span>
							<input name="phone_2" class="text" size="3" maxlength="3"  type="text" value="<?php echo $phone_2; ?>" required> -
							<label>###</label>
						</span>

						<span>
							<input name="phone_3"class="text" size="4" maxlength="4"  type="text" value="<?php echo $phone_3; ?>" required>
							<label>####</label>
						</span><p class="guidelines" id="guide_1"><small>requried</small></p>
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
