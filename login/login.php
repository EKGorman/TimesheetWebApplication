<?php
	include '../config.php';
	include '../redirect.php';

	$err = "";

	if(isset($_POST["submit"]))
	{
		if(isset($_POST["username"]) && isset($_POST["pass"]))
		{
			$username = $_POST["username"];
			$pass = $_POST["pass"];

			$stmt = $conn -> prepare("SELECT EmployeeID, Password, AccessLevel
																FROM employee
																WHERE EmployeeID = ?");
			$stmt -> bind_param("s", $username);
			$stmt -> execute();
			$stmt -> bind_result($employee_id, $password, $accessLevel);
			$stmt -> store_result();

			if($stmt -> num_rows == 1)
			{
				if($stmt -> fetch())
				{
					if(password_verify($pass, $password))
					{
						session_start();
						$_SESSION['loggedIn'] = true;
						$_SESSION['EmployeeID'] = $username;
						$_SESSION['AccessLevel'] = $accessLevel;
						if($accessLevel == 1)
						{
							redirect("../home/superPanel.php");
						}
						elseif($accessLevel == 2)
						{
							redirect("../home/adminPanel.php");
						}
						else
						{
							redirect("../home/userPanel.php");
						}
					}
					else
					{
						$err = "Username or password is invalid.";
					}
				}
			}
			else
			{
				$err = "Username or password is invalid.";
			}
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login V14</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->

<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>

	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-l-85 p-r-85 p-t-55 p-b-55 <?php echo (!empty($err)) ? 'has-error' : ''; ?>">
				<form class="login100-form validate-form flex-sb flex-w" method="post">
					<span class="login100-form-title p-b-32">
						WFD Login
					</span>

					<!--<span class="txt1 p-b-11">
						<?php echo $err; ?>
					</span>-->

					<span class="txt1 p-b-11">
						Username
					</span>
					<div class="wrap-input100 validate-input m-b-36" data-validate = "Username is required">
						<input class="input100" type="text" name="username" >
						<span class="focus-input100"></span>
					</div>

					<span class="txt1 p-b-11">
						Password
					</span>
					<div class="wrap-input100 validate-input m-b-12" data-validate = "Password is required">
						<span class="btn-show-pass">
							<i class="fa fa-eye"></i>
						</span>
						<input class="input100" type="password" name="pass" >
						<span class="focus-input100"></span>
					</div>

					<div class="flex-sb-m w-full p-b-48">
						<div class="contact100-form-checkbox">
							<input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
							<label class="label-checkbox100" for="ckb1">
								Remember me
							</label>
						</div>

						<div>
							<a href="#" class="txt3">
								Forgot Password?
							</a>
						</div>
					</div>

					<span class="txt1 p-b-11">
						<?php echo $err; ?>
					</span>

					<div class="container-login100-form-btn">
						<button class="login100-form-btn" type="submit" name="submit">
							Login
						</button>
					</div>

				</form>
			</div>
		</div>
	</div>


	<div id="dropDownSelect1"></div>

<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->

<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->

<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>
