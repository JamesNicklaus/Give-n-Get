<?php
// Base file for Term Project
// James Nicklaus
  
// Begin Session
include('session.php');
  

$landing = TRUE;
  
// Determine what page is being accessed
if (isset($_GET['p']))	$p = $_GET['p'];	else $p = 'home'; 
$page = "$p.php";
if (!file_exists($page))	$page = 'home.php';  

// Output page requested
include('header.php'); 
include('nav.php');
include($page);	
include('footer.php');	
?>