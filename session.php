<?php
// Begins or resumes session

  session_start();
  
  if (isset($_SESSION['userid'])) {
    $logon = 	TRUE;
	$name = 	$_SESSION['name'];
	$userid = 	$_SESSION['userid'];
	$role = 	$_SESSION['role'];
	$guestEmail = $_SESSION['email'];
	}
	
	else {
	  $logon = FALSE;
	  $name = $userid = $role = NULL;
	  }
?>