<?php
  include '../config.php';
  session_start();

  if(isset($_POST["submit"]))
  {
    $stmt = $conn -> prepare("UPDATE employee SET password = ? WHERE employeeID = ?");
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $stmt -> bind_param('si', $password, $_SESSION['EmployeeID']);
    $stmt -> execute();
  }
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

  <head>
    <title>Password Reset</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <link rel="stylesheet" type="text/css" href="css/view.css" media="all">
    <script type="text/javascript" src="js/view.js"></script>
  </head>

  <body id="main_body" >
    <img id="top" src="Images/top.png" alt="">
    <div id="form_container">

      <h1><a></a></h1>

      <form id="form_passwordReset" class="appnitro"  method="post" action="">

        <div class="form_description">
          <h2>Password Reset</h2>
        </div>

        <div class="container">
          <form action="/action_page.php">
            <label for="usrname">Username:</label>
            <input type="text" id="usrname" name="usrname" required >
            <br>

            <label for="psw">Password:</label>
            <input type="password" id="psw" name="password" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
            <br>

            <input type="submit" name="submit" value="Submit">

          </form>
        </div>

        <div id="message">
          <h3>Password must contain the following:</h3>
          <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
          <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
          <p id="number" class="invalid">A <b>number</b></p>
          <p id="length" class="invalid">Minimum <b>8 characters</b></p>
        </div>

        <script>
        var myInput = document.getElementById("psw");
        var letter = document.getElementById("letter");
        var capital = document.getElementById("capital");
        var number = document.getElementById("number");
        var length = document.getElementById("length");

        // When the user clicks on the password field, show the message box
        myInput.onfocus = function()
        {
          document.getElementById("message").style.display = "block";
        }

        // When the user clicks outside of the password field, hide the message box
        myInput.onblur = function()
        {
          document.getElementById("message").style.display = "none";
        }

        // When the user starts to type something inside the password field
        myInput.onkeyup = function()
        {
          // Validate lowercase letters
          var lowerCaseLetters = /[a-z]/g;
          if(myInput.value.match(lowerCaseLetters))
          {
            letter.classList.remove("invalid");
            letter.classList.add("valid");
          }
          else
          {
            letter.classList.remove("valid");
            letter.classList.add("invalid");
          }

          // Validate capital letters
          var upperCaseLetters = /[A-Z]/g;
          if(myInput.value.match(upperCaseLetters))
          {
            capital.classList.remove("invalid");
            capital.classList.add("valid");
          }
          else
          {
            capital.classList.remove("valid");
            capital.classList.add("invalid");
          }

          // Validate numbers
          var numbers = /[0-9]/g;
          if(myInput.value.match(numbers))
          {
            number.classList.remove("invalid");
            number.classList.add("valid");
          }
          else
          {
            number.classList.remove("valid");
            number.classList.add("invalid");
          }

          // Validate length
          if(myInput.value.length >= 8)
          {
            length.classList.remove("invalid");
            length.classList.add("valid");
          }
          else
          {
            length.classList.remove("valid");
            length.classList.add("invalid");
          }
        }
        </script>

      </form>
    </div>

    <img id="bottom" src="Images/bottom.png" alt="">

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="js/bootstrap.min.js" ></script>
  </body>
</html>
