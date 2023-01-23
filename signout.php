<?php

require('landing.php');
$tempname = 'User'; 

if ($logon) {
	$tempname = $name; 
	session_unset();
	$logon = FALSE;
}
 

?>

<div class ="container">
    <div class="text-center col-sm-4 offset-sm-4 mt-3">
        <h2>Logout Successful!</h2>
    </div>
    <div class="text-center col-sm-4 offset-sm-4 mt-3">
        <p>Thank you for all of your contributions <?php echo $name ?>!</p>
    </div>
</div>