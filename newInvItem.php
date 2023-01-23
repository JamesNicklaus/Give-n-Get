<?php

    require('landing.php');
        
    if (isset($_POST['submit'])) {

        require('serverconnect.php');

        $name = $_POST['name'];
        $type = $_POST['type'];
        $quantity = $_POST['quantity'];
        $priority = $_POST['priority'];

        if ($quantity < 0) {
            $msg = "Are you sure you entered the correct value?";
        }
        else {
        }

        $query = "SELECT ein_number FROM employee WHERE employee_id ='$userid'";
        $result = mysqli_query($mysqli, $query);
        $row = mysqli_fetch_array($result, MYSQLI_NUM);
        $info = $row[0];
        $fb = preg_replace("/-/", "", $info, 1);
        $table = "" . $fb . "_inv";

        $insert = "INSERT INTO $table (name, type, quantity, priority, display) VALUES ('$name', '$type', $quantity, '$priority', DEFAULT);";
        //$insert2 = "INSERT INTO `147849153_inv` (name, type, quantity, priority, display) VALUES ('Apples', 'Fruit', 7, 'Medium', DEFAULT);";

        if ($mysqli->query($insert) === TRUE) {
            $msg = "New item successfully added!";


        }
        else {

            $msg = "ERROR" . $mysqli->error;
        }




    }

?>

<div class="container">
    <div class="text-center col-sm-4 offset-sm-4 mt-3">
        <h3>Add new item</h3>
    </div>

    <form role="form" method="post" action="GnG.php?p=newInvItem">
        <div class="form-group row mt-4 row-bottom-margin">
            <label for="inputName" class="offset-sm-3 col-sm-1 col-form-label">Name</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="inputName" name="name" placeholder="Name">
            </div>
        </div>

        <div class="form-group row row-bottom-margin">
            <label for="inputType" class="offset-sm-3 col-sm-1 col-form-label">Type</label>
            <div class="col-sm-4 mt-2">
                <select id ="inputType" name="type">
                    <option value="Drink">Drink</option>
                    <option value="Carb">Carb</option>
                    <option value="Fruit/Vegetable">Fruit/Vegetable</option>
                    <option value="Dairy">Dairy</option>
                    <option value="Protein">Protein</option>
                    <option value="Sugar">Sugar</option>
                    <option value="Personal Care">Personal Care</option>
                    <option value="Other" selected>Other</option>
                </select>
            </div>
        </div>

        <div class="form-group row row-bottom-margin">
            <label for="inputQuantity" class="offset-sm-3 col-sm-1 col-form-label">Quantity</label>
            <div class="col-sm-4">
                <input type="number" class="form-control" id="inputQuantity" name="quantity" placeholder="Quantity">
            </div>
        </div>

        <div class="form-group row row-bottom-margin">
            <label for="inputPriority" class="offset-sm-3 col-sm-1 col-form-label">Priority</label>
            <div class="col-sm-4 mt-2">
                <select id='inputPriority' name='priority'>
                <option value='High'>High</option>
                <option value='Medium'>Medium</option>
                <option value='Low'>Low</option>
                <option value='None' selected>None</option>
                </select>
            </div>
        </div>

        <div class='col-sm-4 offset-sm-4'>
            <b><?php echo $msg ?></b>
        </div>

        <div class="form-group row mt-4">
            <div class="offset-sm-4 col-sm-4">
                <input type="submit" value="Add New Item" name="submit" value="submit" class="btn btn-primary"/>
            </div>
        </div>

    </form>

</div>