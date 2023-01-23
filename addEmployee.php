<?php
    // Search pages

    require('landing.php');
        
    if (isset($_POST['submit'])) {

        $inputName = $_POST['name'];
        $inputEmail = $_POST['email'];
        $inputPassword = $_POST['password'];
        $inputPhone = $_POST['phone'];

        require('serverconnect.php');

        $getInfo = "SELECT ein_number FROM employee WHERE employee_id = '$userid';";
        $info = mysqli_query($mysqli, $getInfo);
        $row = mysqli_fetch_array($info);

        $create = "INSERT INTO employee (name, workEmail, password, phoneNumber, manager, ein_number) VALUES ('$inputName', '$inputEmail', '$inputPassword', '$inputPhone', 0, '$row[0]');";

        if($mysqli->query($create) === TRUE) {
            $msg = "Employee successfully added!";
        }
        else {
            $msg = "Error adding employee!" . $mysqli->error;
        }
    }
    

?>

<div class="container">
    <div class="text-center col-sm-4 offset-sm-4 mt-3">
      <h3>Add a new Employee</h3>
    </div>
    <form role="form" method="post" action="GnG.php?p=addEmployee">
      <div class="form-group row mt-4 row-bottom-margin">
        <label for="inputName" class="offset-sm-3 col-sm-1 col-form-label">Name</label>
        <div class="col-sm-4">
          <input type="text" class="form-control" id="inputName" name="name" placeholder="Name">
        </div>
      </div>
      <div class="form-group row row-bottom-margin">
        <label for="inputEmail" class="offset-sm-3 col-sm-1 col-form-label">Email</label>
        <div class="col-sm-4">
          <input type="text" class="form-control" id="inputEmail" name="email" placeholder="Email">
        </div>
      </div>
      <div class="form-group row row-bottom-margin">
        <label for="inputEmail" class="offset-sm-3 col-sm-1 col-form-label">Password</label>
        <div class="col-sm-4">
          <input type="password" class="form-control" id="inputPass" name="password" placeholder="Password">
        </div>
      </div>
        <div class="form-group row row-bottom-margin ">
        <label for="inputPhone" class="offset-sm-3 col-sm-1 col-form-label">Phone #</label>
        <div class="col-sm-4">
          <input type="tel" class="form-control" id="inputPhone" name="phone" placeholder="XXX-XXX-XXXX">
        </div>
      </div>
      <div class="col-sm-4 offset-sm-4">
          <?php echo "<b>$msg</b>" ?>
      </div>
      <div class="form-group row mt-4">
        <div class="offset-sm-4 col-sm-4">
          <input type="submit" value="Add Employee" name="submit" value="submit" class="btn btn-primary"/>
        </div>
      </div>
    </form>
  </div>