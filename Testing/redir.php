<?php
	ob_start();
	session_start();
	require_once 'dbconnect.php';
	
	// if session is not set this will redirect to login page
	if( !isset($_SESSION['user']) ) {
		header("Location: index.php");
		exit;
	}
	// select loggedin users detail
	$res=mysqli_query($conn,"SELECT * FROM users WHERE userId=".$_SESSION['user']);
	$userRow=mysqli_fetch_array($res);

    // if user privilege is not set to mod this will redirect to index page
	if( $userRow['UserPrivilege'] != "Moderator" ) {
		header("Location: index.php");
		exit;
	}

    header("Location: editrecord.php");
?>