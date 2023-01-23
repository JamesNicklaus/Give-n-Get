<?php
    // Search pages

    require('landing.php');

    require('serverconnect.php');

    if (isset($_POST['submit'])) {

        require('serverconnect.php');

        $query = "SELECT ein_number FROM employee WHERE employee_id ='$userid'";
        $result = mysqli_query($mysqli, $query);
        $row = mysqli_fetch_array($result, MYSQLI_NUM);
        $info = $row[0];
        $fb = preg_replace("/-/", "", $info, 1);
        $table = "" . $fb . "_inv";


        foreach($_POST['table'] as $rowId => $table2) {

            $rowId = (int) $rowId;
            $quantity = mysqli_real_escape_string($mysqli, $table2['quantity']);
            $priority = mysqli_real_escape_string($mysqli, $table2['priority']);

            if(isset($table2['display'])) {
                $display = 1;
            }
            else {
                $display = 0;
            }

            $update = "UPDATE $table SET `quantity` = '$quantity', `priority` = '$priority', `display` = '$display' WHERE itemNumber = '$rowId'";

            if ($mysqli->query($update) === FALSE) {
                $msg = "Error: " . mysqli_error($mysqli);
                
            }
        }


    }

    if ($role == "manager" || $role == "employee") {
        require('serverconnect.php');

        $query = "SELECT ein_number FROM employee WHERE employee_id ='$userid'";
        $result = mysqli_query($mysqli, $query);
        $row = mysqli_fetch_array($result, MYSQLI_NUM);
        $info = $row[0];
        $fb = preg_replace("/-/", "", $info, 1);
        $table = "" . $fb . "_inv";

    }

    $query = "SELECT * FROM `$table`";
    $result = mysqli_query($mysqli, $query);

    echo "<form role='form' method='post' action='GnG.php?p=myFoodBank' style='text-align:center'>
        <table class='table table-striped table-bordered table-hover table-sm mt-5 mx-auto ' id='sortTable' style='width:70%'>
        <thead>
        <tr>
        <th scope='col text-center'>Item #</th>
        <th scope='col text-center'>Name</th>
        <th scope='col text-center'>Type</th>
        <th scope='col text-center'>Quantity</th>
        <th scope='col text-center'>Priority</th>
        <th scope='col text-center'>Show</th>
        </tr>
        </thead>";

    while ($data = mysqli_fetch_array($result)) {
        $rowId = $data['itemNumber'];

        if ($data['display'] == 1) {
            $checked = "checked='checked'";
            $c = 1;
        }
        else {
            $checked = NULL;
            $c = 0;
        }

        $selectedH = NULL;
        $selectedM = NULL;
        $selectedL = NULL;
        $selectedN = NULL;

        if ($data['priority'] == "High") {
            $selectedH = "selected";
            $s = 3;
        }
        else if ($data['priority'] == "Medium") {
            $selectedM = "selected";
            $s = 2;
        }
        else if ($data['priority'] == "Low") {
            $selectedL = "selected";
            $s = 1;
        }
        else {
            $selectedN = "selected"; 
            $s = 0;
        }

        echo "<tr>
        <td>".$data['itemNumber']."</td>
        <td>".$data['name']."</td>
        <td>".$data['type']."</td>
        <td><input type='number' id='quantity' name='table[$rowId][quantity]' size='3' value=" . $data['quantity'] . " class='fbnumwidth'><p style='display:none'>".$data['quantity']."</p></td>
        <td><select id='prio' name='table[$rowId][priority]'>
        <option value='High' $selectedH>High</option>
        <option value='Medium' $selectedM>Medium</option>
        <option value='Low' $selectedL>Low</option>
        <option value='None' $selectedN>None</option>
        <p style='display:none'>$s</p></select></td>
        <td><input type='checkbox' value='display' name='table[$rowId][display]' $checked><p style='display:none'>$c</p></td>
        
        </tr>";


    }

    echo "</table>
    
        <div class='col-sm-4 offset-sm-4'>
            <b>$msg $msg2</b>
        </div>";

        if ($role == "manager") {
           echo "<div class='mt-3'>
            <a href='GnG.php?p=newInvItem'>Click here to add a new item to your inventory!</a>
        </div>";
        }
        
    echo    "<div class='mt-4 mb-5'>
            <input type='submit' value='Update Information' name='submit' value='submit' class='btn btn-primary'/>
        </div>
    </form>";

?>

<script>
$('#sortTable').DataTable({
    pageLength: 25,
    lengthMenu: [10, 25, 50, 75],
    dom: "<'row'<'col-lg-4 col-md-4 offset-sm-2 col-xs-6'f><'col-lg-2 col-md-2 offset-sm-2 col-xs-12'l>>" +
           "<'row'<'col-sm-12'tr>>" +
           "<'row'<'col-xs-6 offset-sm-2 col-sm-2'i><'col-sm-4 offset-sm-1 col-md-5'p>>"
    
});
</script>