<?php

    require('landing.php');
        

    if(isset($_GET['fb'])) {

        $fbname = htmlspecialchars($_GET['fb']);

        require('serverconnect.php');

        $getEin = "SELECT ein_number FROM food_banks WHERE name = '$fbname';";
        $result = mysqli_query($mysqli, $getEin);
        $ein = mysqli_fetch_array($result);

        $ein2 = preg_replace("/-/", "", $ein[0], 1);
        $table = "" . $ein2 . "_inv";


        $query = "SELECT name, type, quantity, priority FROM `$table` WHERE display = 1;";
        $result = mysqli_query($mysqli, $query);

        $part1 = "<table class='table table-striped table-bordered table-hover table-sm mt-5 mx-auto ' id='sortTable' style='width:50%'>
        <thead>
        <tr>
        <th scope='col text-center'>Name</th>
        <th scope='col text-center'>Type</th>
        <th scope='col text-center'>Quantity</th>
        <th scope='col text-center'>Priority</th>
        </tr>
        </thead>";

        while ($data = mysqli_fetch_array($result)) {

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

            $part2 = $part2 . "<tr>
            <td>".$data['name']."</td>
            <td>".$data['type']."</td>
            <td>".$data['quantity']."</td>
            <td class='$color'>".$data['priority']."</td>        
            </tr>";

        }

        $part3 = "</table>
    
        <div class='col-sm-4 offset-sm-4'>
            <b>$msg $msg2</b>
        </div>";



        $getInfo = "SELECT * FROM food_banks WHERE name = '$fbname';";
        $info = mysqli_query($mysqli, $getInfo);
        $row = mysqli_fetch_array($info);

        $rightPart1 = "<div>
                        <p><b>Location:</b> $row[2]<br>$row[3], $row[4] $row[5]</p>
                        </div>";

        $rightPart2 = "<div>
                        <p><b>Contact Number:</b> $row[6]</p>
                        </div>";

        $rightPart3 = "<div>
                        <p><b>Foodbank URL: </b><a href='$row[7]'>$row[7]</a></p>
                        </div>";


        $link = "<a class='btn btn-lg btn-primary' href='GnG.php?p=fbDonate&fb=$fbname' role='button'>Donate Here!</a>";


    }
?>


<div class='row no-gutters'>
    <div class='col text-center mt-4 no-gutters'>
        <h1><?php echo $fbname ?></h1>
    </div>
</div>

<div class='row no-gutters mt-5'>

    <div class='col no-gutters'>
        <div class='leftside d-flex justify-content-center mb-4'>
            <h3>Current Inventory</h3>
        </div>
        <div class="mb-5">
            <?php echo $part1 . $part2 . $part3 ?>
        </div>
        

    </div>


    <div class='col no-gutters mt-5'>

        <div class='rightside d-flex justify-content-center'>
            <?php echo $rightPart1 ?>    
        </div>
        <div class='rightside d-flex justify-content-center'>
            <?php echo $rightPart2 ?>    
        </div>
        <div class='rightside d-flex justify-content-center'>
            <?php echo $rightPart3 ?>    
        </div>
        <div class='rightside d-flex justify-content-center mt-4'>
            <?php echo $link ?>
        </div>
    </div>
    

</div>

<script>
$('#sortTable').DataTable({
    pageLength: 10,
    lengthMenu: [10, 25, 50, 75],
    dom: "<'row'<'col-lg-4 col-md-4 offset-sm-2 col-xs-6'f><'col-lg-2 col-md-2 offset-sm-2 col-xs-12'l>>" +
           "<'row'<'col-sm-12'tr>>" +
           "<'row'<'col-xs-6 offset-sm-2 col-sm-2'i><'col-sm-4 offset-sm-1 col-md-5'p>>"
    
});
</script>