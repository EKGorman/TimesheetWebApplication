<?php
  include '../config.php';
?>

<!DOCTYPE html>
<html lang="en-US">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Analytics</title>

    <script type="text/javascript" src="js/script.js"></script>
    <link rel="stylesheet" type="text/css" media="all" href="css/styles.css">
  </head>

  <body>
    <main id="wrapper">
      <div id="div1">
        <h1>Project Analytics</h1>

        <button>Project Analytics</button>
        <button onclick="myFunction()">Employee Analytics</button>
        <button onclick="myFunction3()">Company Analytics</button>

        <table id="keywords" cellspacing="0" cellpadding="0">
          <thead>
            <tr>
              <th onclick="sort_table(people, 0, asc1); asc1 *= -1; asc2 = 1; asc3 = 1; asc4 = 1;">Project ID<img src="css/arrow.png" alt="arrow" height="15px" width="15px"></th>
              <th>Project Name</th>
              <th onclick="sort_table(people, 2, asc2); asc2 *= -1; asc3 = 1; asc4 = 1; asc1 = 1;">Manager ID<img src="css/arrow.png" alt="arrow" height="15px" width="15px"></th>
              <th onclick="sort_table(people, 3, asc3); asc3 *= -1; asc4 = 1; asc1 = 1; asc2 = 1;">Company ID<img src="css/arrow.png" alt="arrow" height="15px" width="15px"></th>
              <th>Project Cost</th>
              <th onclick="sort_table(people, 5, asc4); asc4 *= -1; asc1 = 1; asc2 = 1; asc3 = 1;">Project Activity<img src="css/arrow.png" alt="arrow" height="15px" width="15px"></th>
            </tr>
          </thead>

          <tbody id="people">
            <?php
              $sql = "SELECT p.ProjectID, SunHours, MonHours, TuesHours, WedHours, ThursHours, FriHours, SatHours, PayScale, ProjectName, ManagerID, p.CompanyID, ActiveProject
                      FROM Time t
                      RIGHT JOIN Project p ON t.ProjectID=p.ProjectID
                      LEFT JOIN Employee e ON t.EmployeeID=e.EmployeeID";
              $results = mysqli_query($conn, $sql);

              $row = mysqli_fetch_array($results);
              $projectID = $row['ProjectID'];
              $projectName = $row['ProjectName'];
              $managerID = $row['ManagerID'];
              $companyID = $row['CompanyID'];
              $projectCost = ($row['SunHours'] + $row['MonHours'] + $row['TuesHours'] + $row['WedHours'] + $row['ThursHours'] + $row['FriHours'] + $row['SatHours']) * $row['PayScale'];
              $activeProject = $row['ActiveProject'];

              $test = True;
              $count = 1;

              while ($row = mysqli_fetch_array($results))
              {
                $count++;

                if($row['ProjectID'] != $projectID)
                {
                  $test = FALSE;
                }
                if($test == FALSE)
                {
                  echo "<tr>";
                  echo "<td>" . $projectID . "</td>";
                  echo "<td>" . $projectName . "</td>";
                  echo "<td>" . $managerID . "</td>";
                  echo "<td>" . $companyID . "</td>";
                  echo "<td>$" . $projectCost . "</td>";
                  if ($activeProject == 1)
                  {
                    echo "<td>Inactive</td>";
                  }
                  else {
                    echo "<td>Active</td>";
                  }
                  echo "</tr>";

                  $projectCost = 0;
                }

                $projectID = $row['ProjectID'];
                $projectName = $row['ProjectName'];
                $managerID = $row['ManagerID'];
                $companyID = $row['CompanyID'];
                $projectCost += ($row['SunHours'] + $row['MonHours'] + $row['TuesHours'] + $row['WedHours'] + $row['ThursHours'] + $row['FriHours'] + $row['SatHours']) * $row['PayScale'];
                $activeProject = $row['ActiveProject'];

                if(mysqli_num_rows($results) == $count)
                {
                  echo "<tr>";
                  echo "<td>" . $projectID . "</td>";
                  echo "<td>" . $projectName . "</td>";
                  echo "<td>" . $managerID . "</td>";
                  echo "<td>" . $companyID . "</td>";
                  echo "<td>$" . $projectCost . "</td>";
                  if ($activeProject == 1)
                  {
                    echo "<td>Inactive</td>";
                  }
                  else {
                    echo "<td>Active</td>";
                  }
                  echo "</tr>";
                }
              }
            ?>
          </tbody>
        </table>
      </div>

      <!--***************************************************************************************************-->

      <!-- EMPLOYEE ANALYTICS***********************************************-->

      <div id="div2" style="display: none;">
        <h1>Employee Analytics</h1>

        <button onclick="myFunction2()">Project Analytics</button>
        <button>Employee Analytics</button>
        <button onclick="myFunction3()">Company Analytics</button>

        <table id="keywords" cellspacing="0" cellpadding="0">
          <thead>
            <tr>
              <th onclick="sort_table(people1, 0, asc5); asc5 *= -1; asc6 = 1; asc7 = 1;">Employee ID<img src="css/arrow.png" alt="arrow" height="15px" width="15px"></th>
              <th onclick="sort_table(people1, 1, asc6); asc6 *= -1; asc7 = 1; asc5 = 1;">Employee Name<img src="css/arrow.png" alt="arrow" height="15px" width="15px"></th>
              <th>Projects</th>
              <th>Time per Project</th>
              <th>Salary</th>
              <th onclick="sort_table(people1, 5, asc7); asc7 *= -1; asc5 = 1; asc6 = 1;">User Level<img src="css/arrow.png" alt="arrow" height="15px" width="15px"></th>
            </tr>
          </thead>

          <tbody id="people1">
            <?php
              $sql = "SELECT e.EmployeeID, FName, LName, ProjectID, SunHours, MonHours, TuesHours, WedHours, ThursHours, FriHours, SatHours, PayScale, AccessLevel
                      FROM Employee e
                      LEFT JOIN Time t ON t.EmployeeID=e.EmployeeID";
              $results = mysqli_query($conn, $sql);

              $row = mysqli_fetch_array($results);
              $employeeID = $row['EmployeeID'];
              $employeeName = $row['FName'] . " " . $row['LName'];
              $projectID = $row['ProjectID'];
              $hoursWorked = "";
              $projectHours = $row['SunHours'] + $row['MonHours'] + $row['TuesHours'] + $row['WedHours'] + $row['ThursHours'] + $row['FriHours'] + $row['SatHours'];
              $payScale = $row['PayScale'];
              $accessLevel = $row['AccessLevel'];
              $count = 1;

              while ($row = mysqli_fetch_array($results))
              {
                if($count == 1)
                {
                  echo "<td>" . $employeeID . "</td>";
                  echo "<td>" . $employeeName . "</td>";
                }
                $count++;

                if($row['EmployeeID'] == $employeeID && $row['ProjectID'] == $projectID)
                {
                  $projectHours += $row['SunHours'] + $row['MonHours'] + $row['TuesHours'] + $row['WedHours'] + $row['ThursHours'] + $row['FriHours'] + $row['SatHours'];
                }
                elseif($row['EmployeeID'] == $employeeID)
                {
                  $hoursWorked = $hoursWorked . $projectHours . "<br>";
                  $projectID = $projectID . "<br>" . $row['ProjectID'];
                  $projectHours = $row['SunHours'] + $row['MonHours'] + $row['TuesHours'] + $row['WedHours'] + $row['ThursHours'] + $row['FriHours'] + $row['SatHours'];
                }
                else
                {
                  $hoursWorked = $hoursWorked . $projectHours;
                  echo "<td>" . $projectID . "</td>";
                  echo "<td>" . $hoursWorked . "</td>";
                  echo "<td>$" . $payScale . "</td>";
                  if($accessLevel == 1)
                  {
                    echo "<td>Super Admin</td>";
                  }
                  elseif($accessLevel == 2)
                  {
                    echo "<td>Admin</td>";
                  }
                  else
                  {
                    echo "<td>User</td>";
                  }
                  echo "</tr>";

                  $employeeID = $row['EmployeeID'];
                  $employeeName = $row['FName'] . " " . $row['LName'];
                  $projectID = $row['ProjectID'];
                  $hoursWorked = "";
                  $projectHours = $row['SunHours'] + $row['MonHours'] + $row['TuesHours'] + $row['WedHours'] + $row['ThursHours'] + $row['FriHours'] + $row['SatHours'];
                  $payScale = $row['PayScale'];
                  $accessLevel = $row['AccessLevel'];

                  echo "<tr>";
                  echo "<td>" . $employeeID . "</td>";
                  echo "<td>" . $employeeName . "</td>";
                }

                if(mysqli_num_rows($results) == $count)
                {
                  $hoursWorked = $hoursWorked . $projectHours . "<br>";
                  echo "<td>" . $projectID . "</td>";
                  echo "<td>" . $hoursWorked . "</td>";
                  echo "<td>$" . $payScale . "</td>";
                  if($accessLevel == 1)
                  {
                    echo "<td>Super Admin</td>";
                  }
                  elseif($accessLevel == 2)
                  {
                    echo "<td>Admin</td>";
                  }
                  else
                  {
                    echo "<td>User</td>";
                  }
                  echo "</tr>";
                }
              }
            ?>
          </tbody>
        </table>
      </div>

      <!-- COMPANY ANALYTICS***********************************************-->

      <div id="div3" style="display: none;">
        <h1>Company Analytics</h1>

        <button onclick="myFunction2()">Project Analytics</button>
        <button onclick="myFunction()">Employee Analytics</button>
        <button>Company Analytics</button>

        <table id="keywords" cellspacing="0" cellpadding="0">
          <thead>
            <tr>
              <th onclick="sort_table(people2, 0, asc8); asc8 *= -1; ">Company ID<img src="css/arrow.png" alt="arrow" height="15px" width="15px"></th>
              <th>Company Name</th>
              <th>Company Projects</th>
              <th>Company Address</th>
              <th>Phone Number</th>
              <th> </th>
            </tr>
          </thead>

          <tbody id="people2">
            <?php
              $sql = "SELECT c.CompanyID, CName, ProjectID, StreetAddress, AddressLine2, City, State, ZipCode, PhoneNum
                      FROM Company c
                      LEFT JOIN Project j ON c.CompanyID = j.CompanyID";
              $results = mysqli_query($conn, $sql);

              $row = mysqli_fetch_array($results);
              $companyID = $row['CompanyID'];
              $companyName = $row['CName'];
              $projectID = $row['ProjectID'];
              $streetAddress = $row['StreetAddress'];
              $addressLine2 = $row['AddressLine2'];
              $city = $row['City'];
              $state = $row['State'];
              $zipCode = $row['ZipCode'];
              $phoneNum = $row['PhoneNum'];
              $count = 1;

              while ($row = mysqli_fetch_array($results))
              {
                if($count == 1)
                {
                  echo "<td>" . $companyID . "</td>";
                  echo "<td>" . $companyName . "</td>";
                }
                $count++;

                if($row['CompanyID'] == $companyID)
                {
                  $projectID = $projectID . "<br>" . $row['ProjectID'];
                }
                else
                {
                  $address = $streetAddress . "<br>";
                  if($addressLine2 != "")
                  {
                    $address = $address . $addressLine2  . "<br>";
                  }
                  $address = $address . $city . ", " . $state . " " . $zipCode;

                  $phone_1 = substr($phoneNum, 0, 3);
                	$phone_2 = substr($phoneNum, 3, 3);
                	$phone_3 = substr($phoneNum, 6, 4);

                  echo "<td>" . $projectID . "</td>";
                  echo "<td>" . $address . "</td>";
                  echo "<td>(" . $phone_1 . ") " . $phone_2 . "-" . $phone_3 . "</td>";
                  echo "</tr>";

                  $companyID = $row['CompanyID'];
                  $companyName = $row['CName'];
                  $projectID = $row['ProjectID'];
                  $streetAddress = $row['StreetAddress'];
                  $addressLine2 = $row['AddressLine2'];
                  $city = $row['City'];
                  $state = $row['State'];
                  $zipCode = $row['ZipCode'];
                  $phoneNum = $row['PhoneNum'];

                  echo "<tr>";
                  echo "<td>" . $companyID . "</td>";
                  echo "<td>" . $companyName . "</td>";
                }

                if(mysqli_num_rows($results) == $count)
                {
                  $address = $streetAddress . "<br>";
                  if($addressLine2 != "")
                  {
                    $address = $address . $addressLine2  . "<br>";
                  }
                  $address = $address . $city . ", " . $state . " " . $zipCode;

                  $phone_1 = substr($phoneNum, 0, 3);
                	$phone_2 = substr($phoneNum, 3, 3);
                	$phone_3 = substr($phoneNum, 6, 4);

                  echo "<td>" . $projectID . "</td>";
                  echo "<td>" . $address . "</td>";
                  echo "<td>(" . $phone_1 . ") " . $phone_2 . "-" . $phone_3 . "</td>";
                  echo "</tr>";
                }
              }
            ?>
          </tbody>
        </table>
      </div>
    </main>
  </body>
</html>
