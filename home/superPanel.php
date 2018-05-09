<?php
  include '../config.php';
  include '../redirect.php';
  session_start();

  if($_SESSION['AccessLevel'] != 1 || $_SESSION['loggedIn'] != true)
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

  <link  rel="stylesheet" href="css/superStyle.css"/>

  <title>WFD TimeSheet App</title>

</head>

<body>

	<div class="container">
 		<div class="major" id="big">
    		<p id="bigP">Timesheet</p>
    		<a href="../timesheet/timesheet.php" class="link"></a>
   		</div>

      <div class="major" id="rightTop">
    		<p id="tallP">Approve Time</p>
   	 		<a href="../approveTime/approveTime.php" class="link"></a>
    	</div>

    	<div class="major" id="rightBottom">
    		<p id="tallP">Reset Password</p>
   	 		<a href="../resetPassword/resetPassword.php" class="link"></a>
    	</div>

   		<div class="major" id="left">
    		<p id="leftP">Add Employee</p>
    		<a href="../add-update/add/addEmployee.php" class="link"></a>
    	</div>

    	<div class="major" id="right">
    		<p id="rightP">Update Employee</p>
    		<a href="../select/selectEmployee.php" class="link"></a>
    	</div>

    	<div class="major" id="aleft">
    		<p id="aleftP">Add Project</p>
    		<a href="../add-update/add/addProject.php" class="link"></a>
    	</div>

    	<div class="major" id="aright">
    		<p id="arightP">Update Project</p>
    		<a href="../select/selectProject.php" class="link"></a>
    	</div>

    	<div class="major" id="bleft">
    		<p id="bleftP">Add Company</p>
    		<a href="../add-update/add/addCompany.php" class="link"></a>
    	</div>

    	<div class="major" id="bright">
    		<p id="brightP">Update Company</p>
    		<a href="../select/selectCompany.php" class="link"></a>
    	</div>
    </div>
</body>
</html>
