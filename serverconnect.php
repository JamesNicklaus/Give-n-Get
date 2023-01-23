<?php


	include ('config.php');

	$mysql_host			= $dbHostName;
	$mysql_userid		= $dbUserId;
	$mysql_password		= $dbUserPassword;
	$mysql_database		= 'foodBank_db';
	
	$mysqli = mysqli_connect($mysql_host, $mysql_userid, $mysql_password, $mysql_database);
	if (!$mysqli) {
		die('Error, could not connect');
	}
?>