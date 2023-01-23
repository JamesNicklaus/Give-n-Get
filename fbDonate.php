<?php

require ('landing.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$timeSelect = "<select class='time' name='time' id='time'></select>";

if(isset($_POST['submit'])) {

    if ($role == "personal" || $role == "business" || $role == "guest") {

        $error = FALSE;

        require('serverconnect.php');

        $fbName = htmlspecialchars($_GET['fb']);

        $getEinQuery = "SELECT ein_number FROM food_banks WHERE name = '$fbName';";
        $resultEin = mysqli_query($mysqli, $getEinQuery);
        $ein = mysqli_fetch_array($resultEin);

        $date = $_POST['date'];
        $time = $_POST['time'];

        $newDate = date("Y-m-d", strtotime($date));
        $emailDate = date("m-d-Y", strtotime($date));
        $newTime = date("H:i:s", strtotime($time));

        $update = "INSERT INTO donations (foodbankId, userId, status, donoDate, donoTime) VALUES ('$ein[0]', '$userid', DEFAULT, '$newDate', '$newTime');";

        if ($mysqli->query($update) === FALSE) {
            $msg = "Error: " . mysqli_error($mysqli);
            
        }

        else {

            $getDonoNum = "SELECT donationId FROM donations WHERE userId = '$userid' ORDER BY donationId desc LIMIT 0,1;";
            $donoNumResult = mysqli_query($mysqli, $getDonoNum);
            $donoNum = mysqli_fetch_array($donoNumResult);

            $tableName = "dono_" . $donoNum[0] . "";

            $tableDrop = "DROP TABLE IF EXISTS `$tableName`";
            $mysqli->query($tableDrop);


            $createDono = "CREATE TABLE IF NOT EXISTS `$tableName` (
                `name` varchar(25) NOT NULL,
                `type` ENUM('Drink', 'Carb', 'Fruit/Vegetable', 'Dairy', 'Protein', 'Sugar', 'Personal Care', 'Other') NOT NULL,
                `quantity` int NOT NULL,
                PRIMARY KEY (`name`)
                );";

            $mysqli->query($createDono);

            $fbName = htmlspecialchars($_GET['fb']);
            $getEinQuery = "SELECT ein_number FROM food_banks WHERE name = '$fbName';";
            $resultEin = mysqli_query($mysqli, $getEinQuery);
            $ein = mysqli_fetch_array($resultEin);

            $ein2 = preg_replace("/-/", "", $ein[0], 1);
            $table2 = "" . $ein2 . "_inv";

            foreach($_POST['table'] as $rowId => $table) {

                $rowId = (int) $rowId;

                if(isset($table['display'])) {

                    
                    $quantity = mysqli_real_escape_string($mysqli, $table['quantity']);
                    $getItemInfo = "SELECT itemNumber, name, type FROM `$table2` WHERE itemNumber = '$rowId';";

                    $itemInfo = mysqli_query($mysqli, $getItemInfo);
                    $info = mysqli_fetch_array($itemInfo);


                    $updateTable = "INSERT INTO `$tableName` (name, type, quantity) VALUES ('$info[1]', '$info[2]', '$quantity');";

                    $mysqli->query($updateTable);

                    $tableRows = $tableRows . "<tr>
                                            <td style='text-align:center'>$info[1]</td>
                                            <td style='text-align:center'>$info[2]</td>
                                            <td style='text-align:center'>$quantity</td>
                                            </tr>";
                    
                }
            }

            $emailTable = "<table border='1' style='border-collapse:collapse; width:50%;'>
            <tr>
            <th><b>Item Name</b></th>
            <th><b>Item Type</b></th>
            <th><b>Quantity</b></th>
            </tr>" . $tableRows . "</table>";

            $getEmail = "SELECT email FROM donors WHERE donor_id = '$userid';";
            $getEmailResult = mysqli_query($mysqli, $getEmail);
            
            if (mysqli_num_rows($getEmailResult) > 0) {
                
                $email = mysqli_fetch_array($getEmailResult);
                $email0 = $email[0];
            }
            else {
                $email0 = $guestEmail;
            }
            

            require 'vendor/autoload.php';
            include ('config.php');

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
            $mail->AddAddress($email0, 'test_name');
            $mail->Subject  =  'Donation Confirmation';
            $mail->IsHTML(true);
            $mail->Body    = '<p>Hello ' . $name . ',<br>  This is your email confirming your donation to ' . $fbName . '. Your drop off is scheduled for ' . $time . ' on ' . $emailDate . ', please try to be on time.<br> Below are the items you selected to donate.<br></p>
            ' . $emailTable . '';
            //$mail->Body    = '<html><body><a href=<$link>Click to reset password!</a></body></html>';

            if($mail->Send()) {
                ?>
                <script type="text/javascript">
                window.location = "GnG.php?p=donationSuccess";
                </script>      
                <?php
            }
            else {
            $msg = "Mail Error - >".$mail->ErrorInfo;
            }     



                    
                            

            $msg = "Your donation has been successfully scheduled!  " . mysqli_error($mysqli);
        }


    }
    else {
        $message = "You must be signed in as a donor or continue as a guest to make a donation.";
        echo "<script type='text/javascript'>alert('$message');</script>";
    }
}

if(isset($_GET['fb'])) {

    $fbName = htmlspecialchars($_GET['fb']);

    require('serverconnect.php');

    $getEinQuery = "SELECT ein_number FROM food_banks WHERE name = '$fbName';";
    $resultEin = mysqli_query($mysqli, $getEinQuery);
    $ein = mysqli_fetch_array($resultEin);

    $ein2 = preg_replace("/-/", "", $ein[0], 1);
    $table = "" . $ein2 . "_inv";

    $query = "SELECT itemNumber, name, type, quantity, priority FROM `$table` WHERE display = 1;";
    $result = mysqli_query($mysqli, $query);

    $part1 = "<form role='form' method='post' action='GnG.php?p=fbDonate&fb=$fbName' style='text-align:center'>
    <table class='table table-striped table-bordered table-hover table-sm mt-5 mx-auto ' id='sortTable' style='width:60%'>
    <thead>
    <tr>
    <th scope='col text-center' style='vertical-align:middle'>Name</th>
    <th scope='col text-center' style='vertical-align:middle'>Type</th>
    <th scope='col text-center' style='vertical-align:middle'>Donation Amount</th>
    <th scope='col text-center' style='vertical-align:middle'>Priority</th>
    <th scope='col text-center' style='vertical-align:middle'>Add Item</th>
    </tr>
    </thead>";

    while ($data = mysqli_fetch_array($result)) {
        $rowId = $data['itemNumber'];

        if ($data['priority'] == "High") {
            $color = "text-danger";
        }
        else if ($data['priority'] == "Medium") {
            $color = "text-warning";
        }
        else if ($data['priority'] == "Low") {
            $color = "text-success";
        }
        else {
            $color = "text-info";
        }

        $part2 = $part2 . "
        <tr id='currentItem'>
        <td style='display:none';><input type='hidden' name='table[$rowId][itemNumber]' value=". $data['itemNumber'] ."</td>
        <td >".$data['name']."</td>
        <td >".$data['type']."</td>
        <td ><input type='number' id='quantity' name='table[$rowId][quantity]' size='3' min='0' value='0' class='fbnumwidth2'></td>
        <td class='$color ignore'>".$data['priority']."</td>  
        <td><input type='checkbox' class='addItem' id='addItem' name='table[$rowId][display]' value='Donate' ></td>      
        </tr>";

    }


    $part3 = "</table>
    
    <div class='col-sm-4 offset-sm-4'>
        <b>$msg $msg2</b>
    </div>";
    
}

?>


<div class='row no-gutters mt-5'>

    <div class='col no-gutters'>
        <div class='leftside d-flex justify-content-center mb-4'>
            <h5>Select the items and quantities you intend to donate.</h5>
        </div>  
        <div class='mb-4'>
            <?php echo $part1 . $part2 . $part3  ?>
        </div>       

    </div>

    <div class='col no-gutters'>
        <div class='rightside d-flex justify-content-center mb-4'>
            <h5>Please choose a date and time to drop off your donation.</h5>
        </div> 
        <div class='rightside d-flex justify-content-center mb-4'>
            <div class="date">
                <label for='date'>Date: </label>
                <input type='date' id='date' name='date'>
            </div>
        </div>
        <div class='rightside d-flex justify-content-center mb-4'>
            <div class='time'>
                <label for='timeLabel' id='timeLabel' name='timeLabel'>Time: </label>
                <?php echo $timeSelect ?>
            </div>
            
        </div>
        <div class='rightside d-flex justify-content-center mb-4'>
            <div class='submit'>
                <input type='submit' name='submit' class='btn btn-primary' value='Confirm Donation'>
            </div>
            </form>
        </div>
        <div class='rightside d-flex justify-content-center mb-4'>
        <?php if($error == TRUE) { echo $msg; } 
                else { echo $msg; }
          ?>
        </div>
        <div class='rightside d-flex justify-content-center mb-5'>
            <div class='mb-1 mt-1'>
                <h4 style='display:none'>SPACER</h4>
            </div>
        </div> 
        

        <!--
        <div class='rightside d-flex justify-content-center mb-5'>
            <div>
                <h5>Items you intend to donate will be added to the list below.</h5>
            </div>
        </div>
        <div class='rightside d-flex justify-content-center mb-5'>
            <div>
                <table class='table table-striped table-bordered table-hover table-sm mt-3 mx-auto ' id='addTable' style='width:100%'>
                <thead>
                    <tr>
                    <th scope='col text-center' style='vertical-align:middle'>Name</th>
                    <th scope='col text-center' style='vertical-align:middle'>Type</th>
                    <th scope='col text-center' style='vertical-align:middle'>Donation Amount</th>
                    <th scope='col text-center' style='vertical-align:middle'>Remove Item</th>
                    </tr>
                </thead>
                <tbody id='tbody'>

                </tbody>
                </table>
            </div>
        </div>
-->
     

    </div>

</div>


<script>

    $(document).ready(function () {

        let name = <?php echo json_encode(htmlspecialchars($_GET['fb'])); ?>;
        var $form = $(document.getElementById('date'));
        var $input = $form.find("value");
        var serializedData = $form.serializeArray();

        //removeOptions(document.getElementById('time'));
        

        $.ajax({
            url: "getTime.php",
            type: "post",
            data: { "date" : serializedData, "fbName" : name},
            success: function (response) {
                console.log("I'm working!");
                let obj = JSON.parse(response);
                for(let i = 0; i < obj.length; i++) {
                    console.log(obj[i]);
                    $('#time').append($('<option>', {
                        value: obj[i],
                        text: obj[i]
                }));
                }



            }
        });
    });

</script>

<script>  
    src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"
</script>

<script>


var rowIndex = 0;

$('#addItem').on('click', function () {

    var $row = $(document.getElementById('currentItem'));


    $('#tbody').append(`<tr id="R${++rowIndex}">
    <td class="row-index text-center">
        <p>Name</p>
    </td>
    <td class="text-center">
        <p>Type</p>
    </td>
    <td class="text-center">
        <p>Quantity</p>
    </td>
    <td class="text-center">
    <button class="btn btn-danger remove"
        type="button">Remove</button>
    </td>
    </tr>`);
});




$('#tbody').on('click', '.remove', function () {

// Getting all the rows next to the 
// row containing the clicked button
var child = $(this).closest('tr').nextAll();

// Iterating across all the rows 
// obtained to change the index
child.each(function () {
        
    // Getting <tr> id.
    var id = $(this).attr('id');

    // Getting the <p> inside the .row-index class.
    var idx = $(this).children('.row-index').children('p');

    // Gets the row number from <tr> id.
    var dig = parseInt(id.substring(1));

    // Modifying row index.
    idx.html(`Row ${dig - 1}`);

    // Modifying row id.
    $(this).attr('id', `R${dig - 1}`);
});

// Removing the current row.
$(this).closest('tr').remove();

// Decreasing the total number of rows by 1.
rowIndex--;
});


</script>

<script>
    $("#date").change(function(event) {

        event.preventDefault();
        let name = <?php echo json_encode(htmlspecialchars($_GET['fb'])); ?>;
        var $form = $(this);
        var $input = $form.find("value");
        var serializedData = $form.serializeArray();

        removeOptions(document.getElementById('time'));
        

        $.ajax({
            url: "getTime.php",
            type: "post",
            data: { "date" : serializedData, "fbName" : name},
            success: function (response) {
                console.log("I'm working!");
                let obj = JSON.parse(response);
                for(let i = 0; i < obj.length; i++) {
                    console.log(obj[i]);
                    $('#time').append($('<option>', {
                        value: obj[i],
                        text: obj[i]
                }));
                }



            }
        });






    })

 
function removeOptions(selectElement) {
    var i, L = selectElement.options.length - 1;
    for (i = L; i >= 0; i--) {
        selectElement.remove(i);
    }
}


</script>

<script>
$('#sortTable').DataTable({
    pageLength: 100,
    lengthMenu: [100],
    dom: "<'row'<'col-lg-4 col-md-4 offset-sm-2 col-xs-6'f><'col-lg-2 col-md-2 offset-sm-2 col-xs-12'l>>" +
           "<'row'<'col-sm-12'tr>>" +
           "<'row'<'col-xs-6 offset-sm-2 col-sm-2'i><'col-sm-4 offset-sm-1 col-md-5'p>>"
    
});
</script>


<script>



    date.min = new Date().toLocaleDateString('en-ca');

    let today = new Date();
    today = today.toISOString().split('T')[0];
    document.getElementById('date').setAttribute('value', today);

    let todayMax = new Date();
    todayMax.setMonth(todayMax.getMonth() + 1);
    todayMax = todayMax.toISOString().split('T')[0];

    document.getElementById('date').setAttribute('max', todayMax);
</script>


