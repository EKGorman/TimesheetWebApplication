<?php
  include '../config.php';
  include '../redirect.php';
  session_start();

  if($_SESSION['AccessLevel'] != 3 || $_SESSION['loggedIn'] != true)
  {
    redirect("../login/login.php");
  }
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width; initial-scale=1.0">
  <link rel="shortcut icon" href="/favicon.ico">
  <link rel="apple-touch-icon" href="/apple-touch-icon.png">

  <link  rel="stylesheet" href="css/userStyle.css"/>

  <title>WFD TimeSheet App</title>
</head>

<body>

	<div class="container">
 		<div class="major" id="big">
 			<p id="bigP">Timesheet</p>
    		<a href="../timesheet/timesheet.php" class="link"></a>
   		</div>

    	<div class="major" id="tall">
    		<p id="tallP">Reset Password</p>
   	 		<a href="../resetPassword/resetPassword.php" class="link"></a>
    	</div>
    </div>
</body>
</html>
