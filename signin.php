<?php

    require('landing.php');
    
    $errEmail = NULL;
    $errPass  = NULL;
    $msg      = NULL;

    if (isset($_POST['submit'])) {

      $email = trim($_POST['email']);
      $pword = trim($_POST['password']);

      if ($msg == NULL) {
        require('serverconnect.php');
        $query = "SELECT donor_id, name, email, password, type FROM donors WHERE email='$email'";
        $query2 = "SELECT employee_id, name, workEmail, password, manager FROM employee WHERE workEmail ='$email'";
                  
        $result = mysqli_query($mysqli, $query);
        $result2 = mysqli_query($mysqli, $query2);

        if (!$result AND !$result2) { $msg = "Error Accessing Account"; }

        if (mysqli_num_rows($result) > 0 ) {
          $row = mysqli_fetch_array($result);

          if ($pword == $row[3])  {
            $_SESSION['name'] = $row[1];
            if ($row[4] == 1) {
              $_SESSION['role'] = "business";
            }
            else {
              $_SESSION['role'] = "personal";
            }
            $_SESSION['userid'] = $row[0];
            $logon = TRUE;

            ?>
            <script type="text/javascript">
            window.location = "GnG.php?p=signinsuccess";
            </script>      
            <?php

            // OLD METHOD OF REDIRECT, KEEP FOR NOW
            //$msg = "Logon Successful!";
            //flush();
            //header("Location:GnG.php?p=signinsuccess");
            //exit;

          }
          else { $msg = "Invalid Password! Please try again."; }
        }

        else if (mysqli_num_rows($result2) > 0) {
          $row = mysqli_fetch_array($result2);

          if ($pword == $row[3])  {
            $_SESSION['email'] = $row[2];
            $_SESSION['name'] = $row[1];
            if ($row[4] == 1) {
              $_SESSION['role'] = "manager";
            }
            else {
              $_SESSION['role'] = "employee";
            }
            $_SESSION['userid'] = $row[0];
            $logon = TRUE;

            ?>
            <script type="text/javascript">
            window.location = "GnG.php?p=signinsuccess";
            </script>      
            <?php

            //$msg = "Logon Successful!";
            //header("Location: GnG.php?p=signinsuccess");
            //exit;
          }
          else { $msg = "Invalid Password! Please try again."; }
        }

        else { $msg = "Invalid Email"; }
        

      }

    }
  ?>

  <div class="container">
    <div class="text-center col-sm-4 offset-sm-4 mt-3">
      <h3>Sign in</h3>
    </div>
    <form role="form" method="post" action="GnG.php?p=signin">
      <div class="form-group row mt-4 row-bottom-margin">
        <label for="inputEmail" class="offset-sm-3 col-sm-1 col-form-label">Email</label>
        <div class="col-sm-4">
          <input type="email" class="form-control" id="inputEmail" name="email" placeholder="Email">
          <?php if(isset($errEmail)) { echo $errEmail; } ?>
        </div>
      </div>
      <div class="form-group row row-bottom-margin">
        <label for="inputPassword" class="offset-sm-3 col-sm-1 col-form-label">Password</label>
        <div class="col-sm-4">
          <input type="password" class="form-control" id="inputPassword" name="password" placeholder="Password">
          <?php if(isset($errPass)) { echo $errPass; } 
                else { echo $msg; }
          ?>
        </div>
      </div>
      <div class="row">
          <div class="offset-sm-4 col-sm-2 mt-2">
              <a href="GnG.php?p=passrecovery">Forgot Password?</a>
          </div>
      </div>
      <div class="form-group row mt-4">
        <div class="offset-sm-4 col-sm-4">
          <input type="submit" value="Sign in" name="submit" value="submit" class="btn btn-primary"/>
        </div>
      </div>
      <div class="form-group row mt-1">
        <div class="offset-sm-4 col-sm-4">
          <a href="GnG.php?p=guestsignin">...Or continue as a guest?</a>
        </div>
      </div>
    </form>
  </div>