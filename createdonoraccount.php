<?php

    require('landing.php');
    
    $msg      = NULL;

    if (isset($_POST['submit'])) {

      $inputName = ucfirst(trim($_POST['name']));
      $inputEmail = trim($_POST['email']);
      $pword = trim($_POST['password']);
      $inputPhone = trim($_POST['phone']);
      $inputZip = trim($_POST['zip']);
      $type = ($_POST['accountType']);

      if ($type == "personal") {
        $inputType = 0;
      }
      else {
        $inputType = 1;
      }

      if ($msg == NULL) {
        

        if ($inputName == NULL OR $inputEmail == NULL OR $pword == NULL OR $inputPhone == NULL OR $inputZip == NULL) {
          $msg = "Please fill out all fields";
        }
        else if (strlen($inputPhone) < 10) {
          $msg = "Please ensure that you input a 10 digit phone number";
        }
        else if (strlen($inputZip) != 5) {
          $msg = "Please ensure that you input a 5 digit zip code";
        }
        else {
          require('serverconnect.php');
          $check1 = "SELECT email FROM donors WHERE email = '$inputEmail'";
          $check2 = "SELECT workEmail FROM employee WHERE workEmail = '$inputEmail'";
          $result1 = mysqli_query($mysqli, $check1);
          $result2 = mysqli_query($mysqli, $check2);
          

          $query = "INSERT INTO donors (name, email, password, phoneNumber, zipCode, type) VALUES ('$inputName', '$inputEmail', '$pword', '$inputPhone', '$inputZip', '$inputType')";

          if ((mysqli_num_rows($result1) == 0) AND (mysqli_num_rows($result2) == 0)) {
            if ($mysqli->query($query) === TRUE) {
              $logon = 	TRUE;
              $_SESSION['email'] = $inputEmail;
              $_SESSION['name'] = $inputName;
              if ($inputType == 1) {
                $_SESSION['role'] = "business";
              }
              else {
                $_SESSION['role'] = "personal";
              }
              //$_SESSION['role'] = $inputType;
              $_SESSION['userid'] = '0';
              
              

              ?>
            <script type="text/javascript">
            window.location = "GnG.php?p=accountmade";
            </script>      
            <?php
              //header("Location: GnG.php?p=accountmade");
            }
            else {
              $msg = "Error: " . $mysqli->error;
            }
          }
          else {
            $msg = "An account with this email already exists.";
          }
          
          
        }



      }
    }
  ?>

<div class="container">
    <div class="text-center col-sm-4 offset-sm-4 mt-3">
      <h3>Create Donor Account</h3>
    </div>
    <form role="form" method="post" action="GnG.php?p=createdonoraccount">
    <div class="form-group row mt-4 row-bottom-margin">
        <label for="inputName" class="offset-sm-3 col-sm-1 col-form-label">Name</label>
        <div class="col-sm-4">
          <input type="text" class="form-control" id="inputName" name="name" placeholder="Full Name">
          
        </div>
      </div>
      <div class="form-group row mt-2 row-bottom-margin">
        <label for="inputEmail" class="offset-sm-3 col-sm-1 col-form-label">Email</label>
        <div class="col-sm-4">
          <input type="email" class="form-control" id="inputEmail" name="email" placeholder="Email">
          
        </div>
      </div>
      <div class="form-group row mt-2 row-bottom-margin">
        <label for="inputPassword" class="offset-sm-3 col-sm-1 col-form-label">Password</label>
        <div class="col-sm-4">
          <input type="password" class="form-control" id="inputPassword" name="password" placeholder="Password">
          
        </div>
      </div>
      <div class="form-group row mt-2 row-bottom-margin">
        <label for="inputPhone" class="offset-sm-3 col-sm-1 col-form-label align-top">Phone #</label>
        <div class="col-sm-4">
          <input type="tel" class="form-control" id="inputPhone" name="phone" placeholder="Phone #">
          
        </div>
      </div>
      <div class="form-group row mt-2 row-bottom-margin">
        <label for="inputZip" class="offset-sm-3 col-sm-1 col-form-label align-top">Zipcode</label>
        <div class="col-sm-4">
            <input type="text" class="form-control" id="inputZip" name="zip" placeholder="Zipcode">
            <?php echo "<b>$msg</b>" ?>
        </div>
      </div>
      <div class="row">
          <div class="offset-sm-4 col-sm-4">
              <p>Is this a personal or business account?</p>
          </div>
      </div>
      <div class="row">
          <div class="offset-sm-4 col-sm-4">
            <input type="radio" id="personal" name="accountType" value="personal" checked="checked">
            <label for="personal">Personal</label>
          </div>
      </div>
      <div class="row">
          <div class="offset-sm-4 col-sm-4">
            <input type="radio" id="business" name="accountType" value="business">
            <label for="business">Business</label>
          </div>
      </div>
      <div class="form-group row mt-4">
        <div class="offset-sm-4 col-sm-4">
          <input type="submit" value="Create Account" name="submit" value="submit" class="btn btn-primary"/>
        </div>
      </div>
      <div class="form-group row mt-1">
        <div class="offset-sm-4 col-sm-4">
          <a href="GnG.php?p=guestsignin">...Or continue as a guest?</a>
        </div>
      </div>
    </form>
  </div>

  