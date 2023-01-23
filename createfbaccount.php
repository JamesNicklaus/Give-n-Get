<?php

function getGeoCode($address)
{
        include ('config.php');
        // geocoding api url
        $url = "https://maps.google.com/maps/api/geocode/json?address=$address&key=$apiKey";
        // send api request
        $geocode = file_get_contents($url);
        $json = json_decode($geocode);
        $data['lat'] = $json->results[0]->geometry->location->lat;
        $data['lng'] = $json->results[0]->geometry->location->lng;
        return $data;
}
?>

<?php

    require('landing.php');
    
    $msg1      = NULL;
    $msg2      = NULL;

    if (isset($_POST['submit'])) {

      $inputName = ucfirst(trim($_POST['name']));
      $inputEmail = trim($_POST['email']);
      $pword = trim($_POST['password']);
      $inputPhone = trim($_POST['phone']);

      $inputEin = (trim($_POST['EIN']));
      $inputFBName = (trim($_POST['fbname']));
      $inputAddress = (trim($_POST['address']));
      $inputCity = (trim($_POST['city']));
      $inputState = (trim($_POST['state']));
      $inputZip = (trim($_POST['zipcode']));
      $inputFBPhone = (trim($_POST['fbphone']));
      $inputUrl = (trim($_POST['url']));

      $fullAddress =  $inputAddress . ', ' . $inputCity . ', ' . $inputState . ', USA';
      $fullAddress = str_replace(' ', '+', $fullAddress);
      $coords = getGeoCode($fullAddress);
      $long = $coords['lng'];
      $lat = $coords ['lat'];

      if ($msg1 == NULL) {
        

        if ($inputName == NULL OR $inputEmail == NULL OR $pword == NULL OR $inputPhone == NULL) {
          $msg1 = "Please fill out all personal information fields";
        }
        else if ($inputEin == NULL OR $inputFBName == NULL OR $inputAddress == NULL OR $inputCity == NULL OR $inputState == NULL OR $inputZip == NULL OR $inputFBPhone == NULL) {
          $msg2 = "Please fill out all food bank information fields";
        }
        else if (strlen($inputPhone) < 10) {
          $msg = $msg2 = "Please ensure that you input a 10 digit phone number for both fields";
        }
        else if (strlen($inputEin) != 10) {
          $msg2 = "Please ensure that you input your EIN correctly, it should be 9 digits";
        }
        else {
          require('serverconnect.php');
          $check1 = "SELECT workEmail FROM employee WHERE workEmail = '$inputEmail'";
          $check2 = "SELECT ein_number FROM food_banks WHERE ein_number = '$inputEin'";
          $check3 = "SELECT email FROM donors WHERE email = '$inputEmail'";
          $checkResult1 = mysqli_query($mysqli, $check1);
          $checkResult2 = mysqli_query($mysqli, $check2);
          $checkResult3 = mysqli_query($mysqli, $check3);

          if ((mysqli_num_rows($checkResult1) == 0) AND (mysqli_num_rows($checkResult2) == 0) AND mysqli_num_rows($checkResult3) == 0) {

            $query1 = "INSERT INTO employee (name, workEmail, password, phoneNumber, manager, ein_number) VALUES ('$inputName', '$inputEmail', '$pword', '$inputPhone', 1, '$inputEin')";

            if ($mysqli->query($query1) === TRUE) {

              $query2 = "SELECT employee_id FROM employee WHERE workEmail = '$inputEmail'";
              $getId = mysqli_query($mysqli, $query2);
              $newId = mysqli_fetch_array($getId);

              $query3 = "INSERT INTO food_banks (ein_number, name, address, city, state, zipcode, phoneNumber, url, longitude, latitude, employee_id) VALUES ('$inputEin', '$inputFBName', '$inputAddress', '$inputCity', '$inputState', '$inputZip', '$inputFBPhone', '$inputUrl', '$long', '$lat', '$newId[0]')";

              if ($mysqli->query($query3) === TRUE) {
                $logon = 	TRUE;
                $_SESSION['email'] = $inputEmail; 
                $_SESSION['name'] = $inputName;
                $_SESSION['userid'] = $newId[0];
                $_SESSION['role'] = "manager";


                $fb = preg_replace("/-/", "", $inputEin, 1);
                $table = "" . $fb . "_inv";

                $query4 = "CREATE TABLE `$table` 
                (`itemNumber` int NOT NULL auto_increment,
                `name` varchar(25) NOT NULL,
                `type` ENUM('Drink', 'Carb', 'Fruit/Vegetable', 'Dairy', 'Protein', 'Sugar', 'Personal Care', 'Other') NOT NULL,
                `quantity` int NOT NULL,
                `priority` ENUM('Low', 'Medium', 'High') DEFAULT 'Medium',
                `display` tinyint(1) DEFAULT 1,
                primary key (`itemNumber`) 
                ) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;";

                if ($mysqli->query($query4) === TRUE) {

                  $query5 = "INSERT INTO `$table` (`itemNumber`,`name`,`type`,`quantity`) VALUES
                  ( '10001', 'Baked Beans', 'Protein', 27),
                  ( '10002', 'Beefaroni', 'Protein', 26),
                  ( '10003', 'Black Beans', 'Protein', 41),
                  ( '10004', 'Brownie Mix', 'Sugar', 15),
                  ( '10005', 'Cake Mix', 'Sugar', 23),
                  ( '10006', 'Canned Beef Stew', 'Protein', 2),
                  ( '10007', 'Canned Chicken', 'Protein', 41),
                  ( '10008', 'Canned Chilli', 'Protein', 7),
                  ( '10009', 'Carrots', 'Fruit/Vegetable', 1),
                  ( '10010', 'Cereal', 'Carb', 22),
                  ( '10011', 'Chickpeas', 'Carb', 48),
                  ( '10012', 'Chicken Helper', 'Protein', 28),
                  ( '10013', 'Coffee', 'Drink', 49),
                  ( '10014', 'Condensed Milk', 'Dairy', 2),
                  ( '10015', 'Conditioner', 'Personal Care', 43),
                  ( '10016', 'Cookies', 'Sugar', 23),
                  ( '10017', 'Corn', 'Fruit/Vegetable', 26),
                  ( '10018', 'Crackers', 'Carb', 9),
                  ( '10019', 'Canned Cranberries', 'Fruit/Vegetable', 32),
                  ( '10020', 'Deodrant', 'Personal Care', 6),
                  ( '10021', 'Evaporated Milk', 'Dairy', 42),
                  ( '10022', 'Gravy', 'Other', 28),
                  ( '10023', 'Hamburger Helper', 'Protein', 40),
                  ( '10024', 'Hot Chocolate', 'Drink', 46),
                  ( '10025', 'Icing', 'Sugar', 10),
                  ( '10026', 'Jam', 'Sugar', 49),
                  ( '10027', 'Jello', 'Sugar', 4),
                  ( '10028', 'Juice', 'Drink', 48),
                  ( '10029', 'Ketchup', 'Other', 38),
                  ( '10030', 'Laundry Detergent', 'Personal Care', 17),
                  ( '10031', 'Lentils', 'Carb', 31),
                  ( '10032', 'Macaroni & Cheese', 'Carb', 1),
                  ( '10033', 'Mayonnaise', 'Other', 1),
                  ( '10034', 'Canned Mixed Fruit', 'Fruit/Vegetable', 13),
                  ( '10035', 'Mixed Vegtables', 'Fruit/Vegetable', 36),
                  ( '10036', 'Mustard', 'Other', 35),
                  ( '10037', 'Napkins', 'Personal Care', 28),
                  ( '10038', 'Oatmeal', 'Carb', 5),
                  ( '10039', 'Canned Oranges', 'Fruit/Vegetable', 44),
                  ( '10040', 'Pancake Mix', 'Sugar', 8),
                  ( '10041', 'Pancake Syrup', 'Sugar', 3),
                  ( '10042', 'Paper Towels', 'Personal Care', 7),
                  ( '10043', 'Pasta Roni', 'Carb', 15),
                  ( '10044', 'Canned Peaches', 'Fruit/Vegetable', 42),
                  ( '10045', 'Peanut Butter', 'Protein', 37),
                  ( '10046', 'Canned Pears', 'Fruit/Vegetable', 32),
                  ( '10047', 'Peas', 'Fruit/Vegetable', 42),
                  ( '10048', 'Canned Pineapple', 'Fruit/Vegetable', 4),
                  ( '10049', 'Potatoes', 'Fruit/Vegetable', 22),
                  ( '10050', 'Powdered Milk', 'Dairy', 25),
                  ( '10051', 'Pudding', 'Sugar', 43),
                  ( '10052', 'Red Beans', 'Protein', 43),
                  ( '10053', 'Rice', 'Carb', 37),
                  ( '10054', 'Rice-A-Roni', 'Carb', 27),
                  ( '10055', 'Salad Dressing', 'Other', 36),
                  ( '10056', 'Salmon', 'Protein', 19),
                  ( '10057', 'Salt', 'Other', 24),
                  ( '10058', 'Shampoo', 'Personal Care', 6),
                  ( '10059', 'Soap', 'Personal Care', 7),
                  ( '10060', 'Spaghettios', 'Carb', 42),
                  ( '10061', 'Spinach', 'Fruit/Vegetable', 20),
                  ( '10062', 'Sugar', 'Sugar', 0),
                  ( '10063', 'Tea', 'Drink', 3),
                  ( '10064', 'Tissues', 'Personal Care', 49),
                  ( '10065', 'Toilet Paper', 'Personal Care', 25),
                  ( '10066', 'Pasta', 'Carb', 15),
                  ( '10067', 'Tomato Sauce', 'Other', 33),
                  ( '10068', 'Tomatoes', 'Fruit/Vegetable', 48),
                  ( '10069', 'Toothpaste', 'Personal Care', 40),
                  ( '10070', 'Tuna', 'Protein', 36),
                  ( '10071', 'White Beans', 'Protein', 48),
                  ( '10072', 'Yams', 'Fruit/Vegetable', 35);";


                  if ($mysqli->query($query5) === TRUE) {

                    ?>
                    <script type="text/javascript">
                    window.location = "GnG.php?p=accountmade";
                    </script>      
                    <?php

                  }
                  else {
                    $msg2 = "Food Bank inventory not initialized correctly, please contact customer support." . $mysqli->error;
                  }

                }
                else {
                  $msg2 = "Error: " . $mysqli->error;
                }


                //header("Location: GnG.php?p=accountmade");
              }
              else {
                $msg2 = "Error creating food bank: " . $mysqli->error;
              }
           }
           else {
              $msg1 = "Error creating user: " . $mysqli->error;
           }
        }
        else {
          $msg2 = "Account already exists with these credentials";
        }
      }
    }
  }

  ?>

<div class="container">
    <div class="text-center col-sm-4 offset-sm-4 mt-3">
      <h3>Create Food Bank Account</h3>
    </div>
    <div class="text-center col-sm-4 offset-sm-4 mt-5">
      <h4>Enter Personal Information</h4>
    </div>
    <form role="form" method="post" action="GnG.php?p=createfbaccount">
    <div class="col-sm-6"></div>
    <div class="form-group row mt-4 row-bottom-margin">
        <label for="inputName" class="offset-sm-3 col-sm-1 col-form-label">Name</label>
        <div class="col-sm-4">
          <input type="name" class="form-control" id="inputName" name="name" placeholder="Full Name">
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
          <input type="tel" class="form-control" id="inputPhone" name="phone" placeholder="XXX-XXX-XXXX">
        </div>
      </div>
      <div class="text-center col-sm-4 offset-sm-4 mt-5">
      <h4>Enter Food Bank Information</h4>
    </div>
    <div class="form-group row mt-4 row-bottom-margin">
        <label for="inputEin" class="offset-sm-3 col-sm-1 col-form-label">EIN #</label>
        <div class="col-sm-4">
          <input type="text" class="form-control" id="inputEin" name="EIN" placeholder="XX-XXXXXXX">
        </div>
    </div>
    <div class="form-group row mt-2 row-bottom-margin">
        <label for="inputFBName" class="offset-sm-3 col-sm-1 col-form-label">Name</label>
        <div class="col-sm-4">
          <input type="text" class="form-control" id="inputFBName" name="fbname" placeholder="Food Bank Name">
        </div>
    </div>
    <div class="form-group row mt-2 row-bottom-margin">
        <label for="inputAddress" class="offset-sm-3 col-sm-1 col-form-label">Address</label>
        <div class="col-sm-4">
          <input type="text" class="form-control" id="inputAddress" name="address" placeholder="123 Address Road">
        </div>
    </div>
    <div class="form-group row mt-2 row-bottom-margin">
        <label for="inputCity" class="offset-sm-3 col-sm-1 col-form-label">City</label>
        <div class="col-sm-4">
          <input type="text" class="form-control" id="inputCity" name="city" placeholder="Albany">
        </div>
    </div>
    <div class="form-group row mt-2 row-bottom-margin">
        <label for="inputState" class="offset-sm-3 col-sm-1 col-form-label">State</label>
        <div class="col-sm-4">
          <input type="text" class="form-control" id="inputState" name="state" placeholder="NY">
        </div>
    </div>
    <div class="form-group row mt-2 row-bottom-margin">
        <label for="inputZip" class="offset-sm-3 col-sm-1 col-form-label">Zipcode</label>
        <div class="col-sm-4">
          <input type="text" class="form-control" id="inputZip" name="zipcode" placeholder="15515">
        </div>
    </div>
    <div class="form-group row mt-2 row-bottom-margin">
        <label for="inputFBPhone" class="offset-sm-3 col-sm-1 col-form-label">Phone #</label>
        <div class="col-sm-4">
          <input type="tel" class="form-control" id="inputFBPhone" name="fbphone" placeholder="XXX-XXX-XXXX">
        </div>
    </div>
    <div class="form-group row mt-2 row-bottom-margin">
        <label for="inputUrl" class="offset-sm-3 col-sm-1 col-form-label">Website</label>
        <div class="col-sm-4">
          <input type="text" class="form-control" id="inputUrl" name="url" placeholder="http://google.com">
        </div>
    </div>
    <div class="col-sm-4 offset-sm-4">
        <?php echo "<b>$msg2</b>" ?>
    </div>
      <div class="form-group row mt-4 mb-5">
        <div class="offset-sm-4 col-sm-4">
          <input type="submit" value="Create Account" name="submit" value="submit" class="btn btn-primary"/>
        </div>
      </div>
    </form>
  </div>

  