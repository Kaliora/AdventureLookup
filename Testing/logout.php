<?php
	session_start();
    require_once 'dbconnect.php';
	
    /*     session_destroy(); */

    if (isset($_SERVER['HTTP_COOKIE'])) {
        $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
        foreach($cookies as $cookie) {
            $parts = explode('=', $cookie);
            $name = trim($parts[0]);
            setcookie($name, '', time()-1000);
            setcookie($name, '', time()-1000, '/');
        }
    }

	if (isset($_POST['logout']) || isset($_SESSION['timeoutFlag'])) {
        $res=mysqli_query($conn,"SELECT * FROM users WHERE userId=".$_SESSION['user']);
	    $userRow=mysqli_fetch_array($res);
        $res2=mysqli_query($conn,"UPDATE users SET isLogged = 0 WHERE userId='$userRow[userId]'");
		unset($_SESSION['user']);
		session_unset();
		session_destroy();
		header("Location: index.php");
		exit;
	}

    if (!isset($_SESSION['user'])) {
		header("Location: index.php");
	} else if(isset($_SESSION['user'])!="") {
		header("Location: home.php");
	}

?>