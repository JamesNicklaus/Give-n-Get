<?php

require('landing.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['completed'])) {

    include('serverconnect.php');
    $donoNumber = $_GET['num'];

    $updateQuery = "UPDATE donations SET `status` = 'Complete' WHERE donationId = '$donoNumber';";

    if ($mysqli->query($updateQuery) === TRUE) {
        $msg = "<p>Donation status successfullly updated!</p>";
    }
    
} 

if (isset($_POST['cancelled'])) {

    include('serverconnect.php');
    $donoNumber = $_GET['num'];

    $updateQuery = "UPDATE donations SET status = 'Cancelled' WHERE donationId = '$donoNumber';";

    if ($mysqli->query($updateQuery) === TRUE) {
        $msg = "<p>Donation successfullly cancelled</p>";
    }
}


if(isset($_GET['num'])) {

    $donoNumber = $_GET['num'];
    $donoTable = "dono_" . $donoNumber . "";

    include('serverconnect.php');

    $donoQuery = "SELECT * FROM donations WHERE donationId = '$donoNumber';";
    $donoQueryResults = mysqli_query($mysqli, $donoQuery);
    $donoInfo = mysqli_fetch_array($donoQueryResults);

    $newDate = date("m-d-Y", strtotime($donoInfo[4]));
    $newTime = date("g:i A", strtotime($donoInfo[5]));

    if ($role == "manager" || $role == "employee") {
        $getInfo = "SELECT ein_number FROM employee WHERE employee_id = '$userid';";
        $infoResults = mysqli_query($mysqli, $getInfo);
        $info = mysqli_fetch_array($infoResults);
    }
   

    if($donoInfo[2] == $userid || $donoInfo[1] == $info[0]) {
        $donoDetail = "SELECT * FROM `$donoTable`;";
        $donoDetailResults = mysqli_query($mysqli, $donoDetail);

        $tableStart = "<table class='table table-striped table-bordered table-hover table-sm mt-4 mx-auto '>
                        <tr>
                        <th>Item Name</th>
                        <th>Item Type</th>
                        <th>Quantity</th>
                        </tr>";
        

        while($donoItems = mysqli_fetch_array($donoDetailResults)) {
            $tableBody = $tableBody . "<tr>
                                        <td style='text-align:center'>$donoItems[0]</td>
                                        <td style='text-align:center'>$donoItems[1]</td>
                                        <td style='text-align:center'>$donoItems[2]</td>
                                        </tr>";
        }


        $foodbankDetail = "SELECT * FROM food_banks WHERE ein_number = '$donoInfo[1]';";
        $foodbankResults = mysqli_query($mysqli, $foodbankDetail);
        $foodbankInfo = mysqli_fetch_array($foodbankResults);

        if ($donoInfo[3] == "Pending") {
            $tense = "is";
        }
        else {
            $tense = "was";
        }
    
        $header = "<div class='container'>
                        <div class='align-items-center justify-content-center d-flex mt-4'>
                            <h3>Donation number $donoNumber</h3>
                        </div>";

        $body = "<div class='align-items-center justify-content-center d-flex mt-4 h-100'>
                    <p align='center'>The following donation $tense scheduled for dropoff at $foodbankInfo[1] on $newDate.<br>
                       The scheduled time for dropoff $tense $newTime. The donation status is currently <b>$donoInfo[3]</b>. </p>
                 </div>";

        $buttons = "<form role='form' method='post' action='GnG.php?p=detailDono&num=".$donoNumber."'>
        <div class='d-flex justify-content-between mt-3' style='width:80%; margin-left:auto; margin-right:auto;'>
                        <input type='submit' class='btn btn-success' value='Mark donation as completed' name='completed'>
                        <input type='submit' class='btn btn-danger' value='Cancel Donation' name='cancelled'>
                    </div>
                    </form>";

    
        $table = $tableStart . $tableBody;
        
        echo $header;
        echo $body;
        if ($role == "manager" || $role == "employee") {
            echo $buttons;
        }
        echo $table;
    }
    else {
        $header = " <div class='container'>
                        <div class='align-items-center justify-content-center d-flex mt-4'>
                            <h3>You do not have access to this page</h3>
                        </div>
                    </div>";


            echo $header;
    }



}

?>

<div class='align-items-center justify-content-center d-flex mt-4 h-100'>
    <?php echo $msg ?>
</div>

