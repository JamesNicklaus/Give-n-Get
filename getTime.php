<?php


//echo json_encode($_POST);
$getName = $name['name'];
//echo json_encode($data);

$date = json_encode($_POST['date']);
$name = json_encode($_POST['fbName']);

$date2 = explode('"', $date);
$name2 = chop(str_replace('"', '', $name));

require('serverconnect.php');

$getFBid = "SELECT ein_number FROM food_banks WHERE name = '$name2';";

$result = mysqli_query($mysqli, $getFBid);
$ein = mysqli_fetch_array($result);

$query = "SELECT TIME_FORMAT(donoTime, '%h:%i %p') FROM donations WHERE foodbankId = '$ein[0]' AND donoDate = '$date2[7]';";
$result2 = mysqli_query($mysqli, $query);
$allTimes = array();
while ($times = mysqli_fetch_array($result2)) {
    array_push($allTimes, $times[0]);
}

$masterTimes = array("08:00 AM", "08:10 AM", "08:20 AM", "08:30 AM", "08:40 AM", "08:50 AM",
                     "09:00 AM", "09:10 AM", "09:20 AM", "09:30 AM", "09:40 AM", "09:50 AM",
                     "10:00 AM", "10:10 AM", "10:20 AM", "10:30 AM", "10:40 AM", "10:50 AM",
                     "11:00 AM", "11:10 AM", "11:20 AM", "11:30 AM", "11:40 AM", "11:50 AM",
                     "12:00 PM", "12:10 PM", "12:20 PM", "12:30 PM", "12:40 PM", "12:50 PM",
                     "01:00 PM", "01:10 PM", "01:20 PM", "01:30 PM", "01:40 PM", "01:50 PM",
                     "02:00 PM", "02:10 PM", "02:20 PM", "02:30 PM", "02:40 PM", "02:50 PM",
                     "03:00 PM", "03:10 PM", "03:20 PM", "03:30 PM", "03:40 PM", "03:50 PM",
                     "04:00 PM", "04:10 PM", "04:20 PM", "04:30 PM", "04:40 PM", "04:50 PM",
                     "05:00 PM", "05:10 PM", "05:20 PM", "05:30 PM", "05:40 PM", "05:50 PM",);


$masterTimes = array_diff($masterTimes, $allTimes);
$masterTimes = array_values($masterTimes);



echo json_encode($masterTimes);






?>