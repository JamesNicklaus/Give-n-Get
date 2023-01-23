<?php
    // Guest Sign in page

    require('landing.php');
        
    $msg = NULL;

    if (isset($_POST['submit'])) {
      $guestName = trim($_POST['guestName']);
      $guestEmail = trim($_POST['guestEmail']);
      $guestPhone = trim($_POST['guestPhone']);


      if(($guestName != NULL) AND ($guestEmail != NULL)) {
        
        if($guestPhone != NULL) {
          $_SESSION['phone'] = $guestPhone;
        }
          
        $_SESSION['name'] = $guestName;
        $_SESSION['email'] = $guestEmail;
        $_SESSION['userid'] = "temp";
        $_SESSION['role'] = "guest";
        $logon = TRUE;

        ?>
            <script type="text/javascript">
            window.location = "GnG.php?p=signinsuccess";
            </script>      
            <?php
        //header("Location: GnG.php?p=signinsuccess");
      }
      else {
        $msg = "Please include a Name and Email Address.";
      }
  }

    

?>

<div class="container">
    <div class="text-center col-sm-4 offset-sm-4 mt-3">
      <h3>Sign in as a Guest</h3>
    </div>
    <form role="form" method="post" action="GnG.php?p=guestsignin">
      <div class="form-group row mt-4 row-bottom-margin">
        <label for="inputName" class="offset-sm-3 col-sm-1 col-form-label">Name</label>
        <div class="col-sm-4">
          <input type="guestName" class="form-control" id="inputName" name="guestName" placeholder="Name">
        </div>
      </div>
      <div class="form-group row row-bottom-margin">
        <label for="inputEmail" class="offset-sm-3 col-sm-1 col-form-label">Email</label>
        <div class="col-sm-4">
          <input type="guestEmail" class="form-control" id="inputEmail" name="guestEmail" placeholder="Email">
        </div>
      </div>
        <div class="form-group row row-bottom-margin ">
        <label for="inputPhone" class="offset-sm-3 col-sm-1 col-form-label">Phone #</label>
        <div class="col-sm-4">
          <input type="guestPhone" class="form-control" id="inputPhone" name="guestPhone" placeholder="XXX-XXX-XXXX">
        </div>
        <div class="col-form-label">
          <p class="text-muted">(Optional)</p>
        </div>
      </div>
      <div class="col-sm-4 offset-sm-4">
          <?php echo "<b>$msg</b>" ?>
      </div>
      <div class="form-group row mt-4">
        <div class="offset-sm-4 col-sm-4">
          <input type="submit" value="Sign in as guest" name="submit" value="submit" class="btn btn-primary"/>
        </div>
      </div>
      <div class="form-group row mt-1">
        <div class="offset-sm-4 col-sm-4">
          <a href="GnG.php?p=signin">...Or sign in with an account?</a>
        </div>
      </div>
    </form>
  </div>
