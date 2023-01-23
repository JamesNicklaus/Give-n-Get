<?php
    // Home page

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require('landing.php');

    $msg = NULL;

    if(isset($_POST['submit']) && $_POST['email']) {

        $inputEmail = trim($_POST['email']);

        require('serverconnect.php');

        $check1 = "SELECT workEmail, password FROM employee WHERE workEmail = '$inputEmail'";
        $check2 = "SELECT email, password FROM donors WHERE email = '$inputEmail'";

        $checkResult1 = mysqli_query($mysqli, $check1);
        $checkResult2 = mysqli_query($mysqli, $check2);

        if ((mysqli_num_rows($checkResult1) == 1) OR (mysqli_num_rows($checkResult2) == 1)) {

            if (mysqli_num_rows($checkResult1) == 0) {

                while ($row = mysqli_fetch_array($checkResult2)) {
                    $email = md5($row['email']);
                    $pass = md5($row['password']);
                }
            }
            else {

                while ($row = mysqli_fetch_array($checkResult1)) {
                    $email = md5($row['workEmail']);
                    $pass = md5($row['password']);
                }
            }

            include ('config.php');

            $link = "http://givenget.online/GnG.php?p=resetPass&key=" . "$email" . "&reset=" . "$pass";

            require 'vendor/autoload.php';

            $mail = new PHPMailer(true);
            $mail->CharSet = "utf-8";
            $mail->IsSMTP();
            $mail->SMTPAuth = true;
            $mail->Username = "giveandget2022@gmail.com";
            $mail->Password = $emailPassword;
            $mail->SMTPSecure = "ssl";
            $mail->Host = "smtp.gmail.com";
            $mail->setFrom('giveandget2022@gmail.com');
            $mail->Port = "465";
            $mail->From="giveandget2022@gmail.com";
            $mail->FromName="Give n' Get";
            $mail->AddAddress($inputEmail, 'test_name');
            $mail->Subject  =  'Reset Password';
            $mail->IsHTML(true);
            $mail->Body    = '<a href=' . $link . '>Click here to reset your password!</a>';
            //$mail->Body    = '<html><body><a href=<$link>Click to reset password!</a></body></html>';

            if($mail->Send()) {
              $msg = "Check your email and click on the the link to reset your password!";
            }
            else {
              $msg = "Mail Error - >".$mail->ErrorInfo;
            }

            

        }
        else {
            $msg = "Email not found";
        }

        
    }
        

?>

<div class="container">
    <div class="text-center col-sm-4 offset-sm-4 mt-3">
      <h3>Password Recovery</h3>
    </div>
    <div class="text-center col-sm-4 offset-sm-4 mt-3">
      <p>Please enter your email below, and we'll send you a link to reset your password!</p>
    </div>
    <form role="form" method="post" action="GnG.php?p=passrecovery">
      <div class="form-group row mt-4 row-bottom-margin">
        <label for="inputName" class="offset-sm-3 col-sm-1 col-form-label">Email</label>
        <div class="col-sm-4">
          <input type="email" class="form-control" id="inputEmail" name="email" placeholder="Email">
        </div>
      </div>
      <div class="col-sm-4 offset-sm-4">
          <?php echo "<b>$msg</b>" ?>
      </div>
      <div class="form-group row mt-5">
        <div class="offset-sm-4 col-sm-4">
          <input type="submit" value="Send Email" name="submit" value="submit" class="btn btn-primary"/>
        </div>
      </div>
    </form>
</div>