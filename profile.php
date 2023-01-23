<?php
function getGeoCode($address)
{
        // geocoding api url
        include ('config.php');
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
    // Profile

    require('landing.php');

    if (isset($_POST['submit'])) {

        if ($role == 'personal' || $role == 'business') {
            require ('serverconnect.php');

            $inputName = $_POST['name'];
            $inputEmail = $_POST['email'];
            $inputPhone = $_POST['phone'];
            $inputZip = $_POST['zip'];




            $putInfo = "UPDATE donors SET name = '$inputName',
                                          email = '$inputEmail',
                                          phoneNumber = '$inputPhone',
                                          zipCode = '$inputZip'
                                          WHERE donor_id = '$userid';";



            if ($mysqli->query($putInfo) === TRUE) {
                $msg = "Account info successfully updated.";
            }
        }
        else if ($role == "manager") {
            require ('serverconnect.php');

            $inputName = $_POST['name'];
            $inputEmail = $_POST['email'];
            $inputPhone = $_POST['phone'];

            $inputEIN = $_POST['ein'];
            $inputFBName = $_POST['fbname'];
            $inputAddress = $_POST['address'];
            $inputCity = $_POST['city'];
            $inputState = $_POST['state'];
            $inputZip = $_POST['zipcode'];
            $inputFBPhone = $_POST['fbphone'];
            $inputUrl = $_POST['url'];

            $fullAddress =  $inputAddress . ', ' . $inputCity . ', ' . $inputState . ', USA';
            $fullAddress = str_replace(' ', '+', $fullAddress);
            $coords = getGeoCode($fullAddress);
            $long = $coords['lng'];
            $lat = $coords ['lat'];

            $putInfo = "UPDATE employee SET name = '$inputName',
                                            workEmail = '$inputEmail',
                                            phoneNumber = '$inputPhone'
                                            WHERE employee_id = '$userid';";

            $putInfo2 = "UPDATE food_banks SET ein_number = '$inputEIN',
                                               name = '$inputFBName',
                                               address = '$inputAddress',
                                               city = '$inputCity',
                                               state = '$inputState',
                                               zipcode = '$inputZip',
                                               phoneNumber = '$inputFBPhone',
                                               url = '$inputUrl',
                                               longitude = '$long',
                                               latitude = '$lat'
                                               WHERE employee_id = '$userid';";

            if ($mysqli->query($putInfo) === TRUE AND $mysqli->query($putInfo2) === TRUE) {
                $msg = "Account info successfully updated.";
            }

        }
        else if ($role == "employee") {
            require ('serverconnect.php');

            $inputName = $_POST['name'];
            $inputEmail = $_POST['email'];
            $inputPhone = $_POST['phone'];

            $putInfo = "UPDATE employee SET name = '$inputName',
                                            workEmail = '$inputEmail',
                                            phoneNumber = '$inputPhone'
                                            WHERE employee_id = '$userid';";

            if ($mysqli->query($putInfo) === TRUE) {
                $msg = "Account info successfully updated.";
            }

        }

    }

    if ($role == 'personal' || $role == 'business') {

        require ('serverconnect.php');

        $getInfo = "SELECT name, email, phoneNumber, zipCode FROM donors WHERE donor_id = '$userid'";

        $result = mysqli_query($mysqli, $getInfo);
        $row = NULL;

        if (mysqli_num_rows($result) > 0 ) {
            $row = mysqli_fetch_array($result);
        }

        $update = "<form role='form' method='post' action='GnG.php?p=profile'>
      <div class='form-group row mt-4 row-bottom-margin leftside'>
        <label for='inputName' class='offset-sm-3 col-sm-1 col-form-label'>Name</label>
        <div class='col-sm-4'>
          <input type='text' class='form-control' id='inputName' style='width:400px' name='name' value='$row[0]'>
        </div>
      </div>
      <div class='form-group row row-bottom-margin leftside'>
        <label for='inputEmail' class='offset-sm-3 col-sm-1 col-form-label'>Email</label>
        <div class='col-sm-4'>
          <input type='text' class='form-control' id='inputEmail' style='width:400px' name='email' value='$row[1]'>
        </div>
      </div>
        <div class='form-group row row-bottom-margin leftside '>
        <label for='inputPhone' class='offset-sm-3 col-sm-1 col-form-label'>Phone</label>
        <div class='col-sm-4'>
          <input type='text' class='form-control' id='inputPhone' style='width:400px' name='phone' value='$row[2]'>
        </div>
      </div>
      <div class='form-group row row-bottom-margin leftside '>
        <label for='inputZip' class='offset-sm-3 col-sm-1 col-form-label'>Zipcode</label>
        <div class='col-sm-4'>
          <input type='text' class='form-control' id='inputZip' style='width:400px' name='zip' value='$row[3]'>
        </div>
      </div>
      <div class='col-sm-4 offset-sm-4 leftside'>
        <p><b>$msg</b></p>
      </div>
      <div class='form-group row mt-4 leftside'>
        <div class='offset-sm-4 col-sm-4'>
          <input type='submit' value='Update Info' name='submit' value='submit' class='btn btn-primary'/>
        </div>
      </div>
      <div class='form-group row mt-1'>
        <div class='offset-sm-4 col-sm-4'>
          <a href='GnG.php?p=passrecovery'>Click here to reset your password</a>
        </div>
      </div>
    </form>";
    }

    if ($role == "manager") {

        require ('serverconnect.php');

        $getInfo1 = "SELECT name, workEmail, phoneNumber FROM employee WHERE employee_id = '$userid'";
        $getInfo2 = "SELECT ein_number, name, address, city, state, zipcode, phoneNumber, url, image FROM food_banks WHERE employee_id = '$userid'";

        $result1 = mysqli_query($mysqli, $getInfo1);
        $result2 = mysqli_query($mysqli, $getInfo2);
        $rowPersonal = NULL;
        $rowFoodbank = NULL;

        if (mysqli_num_rows($result1) > 0 ) {

            $rowPersonal = mysqli_fetch_array($result1);
            $rowFoodbank = mysqli_fetch_array($result2);
        }

        $update = "<form role='form' method='post' enctype='multipart/form-data' action='GnG.php?p=profile'>
      <div class='form-group row mt-4 row-bottom-margin leftside'>
        <label for='inputName' class='offset-sm-3 col-sm-1 col-form-label'>Name</label>
        <div class='col-sm-4'>
          <input type='text' class='form-control' id='inputName' style='width:400px' name='name' value='$rowPersonal[0]'>
        </div>
      </div>
      <div class='form-group row row-bottom-margin leftside'>
        <label for='inputEmail' class='offset-sm-3 col-sm-1 col-form-label'>Email</label>
        <div class='col-sm-4'>
          <input type='text' class='form-control' id='inputEmail' style='width:400px' name='email' value='$rowPersonal[1]'>
        </div>
      </div>
        <div class='form-group row row-bottom-margin leftside '>
        <label for='inputPhone' class='offset-sm-3 col-sm-1 col-form-label'>Phone</label>
        <div class='col-sm-4'>
          <input type='tel' class='form-control' id='inputPhone' style='width:400px' name='phone' value='$rowPersonal[2]'>
        </div>
      </div>
      <div class='col text-center mt-5 no-gutters'>
        <h3>Update Food Bank Information</h3>
      </div>
        <div class='form-group row row-bottom-margin leftside mt-4'>
            <label for='inputEin' class='offset-sm-3 col-sm-1 col-form-label'>EIN</label>
            <div class='col-sm-4'>
            <input type='text' class='form-control' id='inputEin' style='width:400px' name='ein' value='$rowFoodbank[0]'>
            </div>
        </div>
        <div class='form-group row row-bottom-margin leftside '>
            <label for='inputFBName' class='offset-sm-3 col-sm-1 col-form-label'>Name</label>
            <div class='col-sm-4'>
            <input type='text' class='form-control' id='inputFBName' style='width:400px' name='fbname' value='$rowFoodbank[1]'>
            </div>
        </div>
        <div class='form-group row row-bottom-margin leftside '>
            <label for='inputAddress' class='offset-sm-3 col-sm-1 col-form-label'>Address</label>
            <div class='col-sm-4'>
            <input type='text' class='form-control' id='inputAddress' style='width:400px' name='address' value='$rowFoodbank[2]'>
            </div>
        </div>
        <div class='form-group row row-bottom-margin leftside '>
            <label for='inputCity' class='offset-sm-3 col-sm-1 col-form-label'>City</label>
            <div class='col-sm-4'>
            <input type='text' class='form-control' id='inputCity' style='width:400px' name='city' value='$rowFoodbank[3]'>
            </div>
        </div>
            <div class='form-group row row-bottom-margin leftside '>
            <label for='inputState' class='offset-sm-3 col-sm-1 col-form-label'>State</label>
            <div class='col-sm-4'>
            <input type='text' class='form-control' id='inputState' style='width:400px' name='state' value='$rowFoodbank[4]'>
            </div>
        </div>
        <div class='form-group row row-bottom-margin leftside '>
            <label for='inputZip' class='offset-sm-3 col-sm-1 col-form-label'>Zipcode</label>
            <div class='col-sm-4'>
            <input type='text' class='form-control' id='inputZip' style='width:400px' name='zipcode' value='$rowFoodbank[5]'>
            </div>
        </div>
        <div class='form-group row row-bottom-margin leftside '>
            <label for='inputFBPhone' class='offset-sm-3 col-sm-1 col-form-label'>Phone</label>
            <div class='col-sm-4'>
            <input type='tel' class='form-control' id='inputFBPhone' style='width:400px' name='fbphone' value='$rowFoodbank[6]'>
            </div>
        </div>
        <div class='form-group row row-bottom-margin leftside '>
            <label for='inputUrl' class='offset-sm-3 col-sm-1 col-form-label'>Website URL</label>
            <div class='col-sm-4 mt-3'>
            <input type='text' class='form-control' id='inputUrl' style='width:400px' name='url' value='$rowFoodbank[7]'>
            </div>
        </div>
        <div class='col-sm-4 offset-sm-4 leftside'>
            <p><b>$msg</b></p>
        </div>
      <div class='form-group row mt-4 leftside'>
        <div class='offset-sm-4 col-sm-4'>
          <input type='submit' value='Update Info' name='submit' value='submit' class='btn btn-primary'/>
        </div>
      </div>
      <div class='form-group row mt-1 mb-5'>
        <div class='offset-sm-4 col-sm-4'>
          <a href='GnG.php?p=passrecovery'>Click here to reset your password</a>
        </div>
      </div>
    </form>";
    }

    if ($role == "employee") {
        require ('serverconnect.php');

        $getInfo = "SELECT name, workEmail, phoneNumber FROM employee WHERE employee_id = '$userid'";

        $result = mysqli_query($mysqli, $getInfo);
        $row = NULL;


        if (mysqli_num_rows($result) > 0 ) {
            $row = mysqli_fetch_array($result);

        }

        $update = "<form role='form' method='post' action='GnG.php?p=profile'>
      <div class='form-group row mt-4 row-bottom-margin leftside'>
        <label for='inputName' class='offset-sm-3 col-sm-1 col-form-label'>Name</label>
        <div class='col-sm-4'>
          <input type='text' class='form-control' id='inputName' style='width:400px' name='name' value='$row[0]'>
        </div>
      </div>
      <div class='form-group row row-bottom-margin leftside'>
        <label for='inputEmail' class='offset-sm-3 col-sm-1 col-form-label'>Email</label>
        <div class='col-sm-4'>
          <input type='text' class='form-control' id='inputEmail' style='width:400px' name='email' value='$row[1]'>
        </div>
      </div>
        <div class='form-group row row-bottom-margin leftside '>
        <label for='inputPhone' class='offset-sm-3 col-sm-1 col-form-label'>Phone</label>
        <div class='col-sm-4'>
          <input type='tel' class='form-control' id='inputPhone' style='width:400px' name='phone' value='$row[2]'>
        </div>
      </div>
      <div class='col-sm-4 offset-sm-4 leftside'>
        <p><b>$msg</b></p>
      </div>
      <div class='form-group row mt-4 leftside'>
        <div class='offset-sm-4 col-sm-4'>
          <input type='submit' value='Update Info' name='submit' value='submit' class='btn btn-primary'/>
        </div>
      </div>
      <div class='form-group row mt-1 mb-5'>
        <div class='offset-sm-4 col-sm-4'>
          <a href='GnG.php?p=passrecovery'>Click here to reset your password</a>
        </div>
      </div>
    </form>";
    }
        
    if ($role == 'personal' || $role == 'business') {

      require ('serverconnect.php');

      $user = $_SESSION['userid'];

      $getDono = "SELECT donationId, status, DATE_FORMAT(donoDate, '%c-%d-%y') as date, TIME_FORMAT(donoTime, '%h:%i %p') as time FROM donations WHERE userId = '$user'";
      $donoResult = mysqli_query($mysqli, $getDono);

      while($donos = mysqli_fetch_array($donoResult)) {
        $body = $body . "
        <tr>
        <td>".$donos['donationId']."</td>
        <td>".$donos['status']."</td>
        <td>".$donos['date']."</td>
        <td>".$donos['time']."</td>       
        </tr>";
      }

      $pdf = "<a href='reportGeneration.php?userid=".$userid."' target='_blank'>Generate report for this years donations!</a>";
    }
    else if ($role == 'manager' or $role == 'employee') {

      require ('serverconnect.php');

      $user = $_SESSION['userid'];

      $getEin = "SELECT ein_number FROM employee WHERE employee_id = '$user';";
      
      $ein = mysqli_query($mysqli, $getEin);
      $ein2 = mysqli_fetch_array($ein);



      $getDono = "SELECT donationId, status, DATE_FORMAT(donoDate, '%c-%d-%y') as date, TIME_FORMAT(donoTime, '%h:%i %p') as time FROM donations WHERE foodbankId = '$ein2[0]';";
      $donoResult = mysqli_query($mysqli, $getDono);

      while($donos = mysqli_fetch_array($donoResult)) {
        $body = $body . "
        <tr>
        <td>".$donos['donationId']."</td>
        <td>".$donos['status']."</td>
        <td>".$donos['date']."</td>
        <td>".$donos['time']."</td>       
        </tr>";
      }
    }

?>
<div class='row no-gutters'>
    <div class='col text-center mt-4 no-gutters'>
        <h1>Account Information</h1>
    </div>
</div>

<div class='row no-gutters'>

    <div class='col no-gutters'>
        <div class='leftside d-flex justify-content-center'>
            <h3>Update Account Information</h3>
        </div>
        <?php echo $update ?>

    </div>


    <div class='col no-gutters'>
        <div class='rightside d-flex justify-content-center'>
          <h3>Most Recent Donations</h3>  
        </div>
        <div class='rightside d-flex justify-content-center'>
            <p>Click on a donation to see a more detailed view</p>
        </div>
        <table class="table table-striped table-bordered table-hover table-sm mt-3 mx-auto" style="width:80%" id="donations">
        <thead>
            <tr>
            <th scope="col text-center">Donation ID</th>
            <th scope="col text-center">Status</th>
            <th scope="col text-center">Donation Date</th>
            <th scope="col text-center">Date Time</th>
            </tr>
        </thead>
        <tbody>
            <?php echo $body; ?>
        </tbody>
        </table>
        <div class='rightside d-flex justify-content-center mt-5'>
            <?php echo $pdf ?>
        </div>
    </div>
    

</div>

<script>
  window.onload = addRowHandlers();

  function addRowHandlers() {
  var table = document.getElementById("donations");
  var rows = table.getElementsByTagName("tr");
  for (i = 0; i < rows.length; i++) {
    var currentRow = table.rows[i];
    var createClickHandler = function(row) {
      return function() {
        var cell = row.getElementsByTagName("td")[0];
        var id = cell.innerHTML;
        window.location = "GnG.php?p=detailDono&num=" + id;
      };
    };
    currentRow.onclick = createClickHandler(currentRow);
  }
}
</script>