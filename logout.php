<?php
require_once('./includes/connectlocal.inc');
session_start();

// if the user is logged in 
if (!isset($_SESSION['login'])) {
	//exit and redirect back to home page
	ob_end_clean();
	header("Location: index.php");
	exit();
} else {
	// else destroy session, session array, and redirect
	$_SESSION = array();
	session_destroy();
	ob_end_clean();

	//to print logout message on redirect
	header("Location: index.php?s=loggedout");
}
