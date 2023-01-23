<?php

require('landing.php');


if (isset($_POST['submit'])) {

  $newPass = $_POST['password'];
  $email=$_GET['key'];
  $pass=$_GET['reset'];
  $query = NULL;

  $check1 = "SELECT workEmail, password FROM employee WHERE md5(workEmail) = '$email' AND md5(password)='$pass'";
  $check2 = "SELECT email, password FROM donors WHERE md5(email) = '$email' AND md5(password)='$pass'";

  require('serverconnect.php');

  $checkResult1=mysqli_query($mysqli, $check1);
  $checkResult2=mysqli_query($mysqli, $check2);




  if ((strlen($newPass) > 3)  && (mysqli_num_rows($checkResult1)== 1)) {
    $query = "UPDATE employee SET password = '$newPass' WHERE md5(workEmail) = '$email'";
  }
  else if ((strlen($newPass) > 3)  && (mysqli_num_rows($checkResult2)== 1)) {
    $query = "UPDATE donors SET password = '$newPass' WHERE md5(email) = '$email'";
  }
  else {
    $msg = "Password is too short";
  }

  if ($query AND $mysqli->query($query) === TRUE) {
    $msg = "Successfully reset password!";
  }
}
?>

<div class="container">
        <div class="text-center col-sm-4 offset-sm-4 mt-3">
          <h3>Reset your Password</h3>
        </div>
        <div class="text-center col-sm-4 offset-sm-4 mt-3">
          <p>Please enter your new password below!</p>
        </div>
        <form role="form" method="post" >
          <div class="form-group row mt-4 row-bottom-margin">
            <label for="inputPass" class="offset-sm-3 col-sm-1 col-form-label">New Password</label>
            <div class="col-sm-4">
              <input type="password" class="form-control" id="inputPass" name="password" placeholder="Password">
            </div>
          </div>
          <div class="col-sm-4 offset-sm-4">
            <?php echo "<b>$msg</b>" ?>
          </div>
          <div class="form-group row mt-3">
            <div class="offset-sm-4 col-sm-4">
              <input type="submit" value="Submit" name="submit" value="submit" class="btn btn-primary"/>
            </div>
          </div>
        </form>
    </div>
