<?php
    header("Cache-Control: no-cache, must-revalidate");
	ob_start();
	session_start();
	require_once 'dbconnect.php';
	
	// it will never let you open index(login) page if session is set
	if ( isset($_SESSION['user'])!="" ) {
		header("Location: home.php");
		exit;
	}
	
	$error = false;
	
	if( isset($_POST['btn-login']) ) {	
		
		// prevent sql injections/ clear user invalid inputs
		$email = trim($_POST['email']);
		$email = strip_tags($email);
		$email = htmlspecialchars($email);
		
		$pass = trim($_POST['pass']);
		$pass = strip_tags($pass);
		$pass = htmlspecialchars($pass);
		// prevent sql injections / clear user invalid inputs
		
		if(empty($email)){
			$error = true;
			$emailError = "Please enter your email address.";
		} else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
			$error = true;
			$emailError = "Please enter valid email address.";
		}
		
		if(empty($pass)){
			$error = true;
			$passError = "Please enter your password.";
		}
		
		// if there's no error, continue to login
		if (!$error) {
			// set initial value of session timeout
            $_SESSION['timeout'] = time();
            
			$password = hash('sha256', $pass); // password hashing using SHA256
		
			$res=mysqli_query($conn,"SELECT userId, userName, userPass FROM users WHERE userEmail='$email'");
			$row=mysqli_fetch_array($res);
			$count = mysqli_num_rows($res); // if uname/pass correct it returns must be 1 row
			
			if( $count == 1 && $row['userPass']==$password ) {
				$_SESSION['user'] = $row['userId'];
				header("Location: home.php");
                $res=mysqli_query($conn,"UPDATE users SET isLogged = 1 WHERE userId='$row[userId]'");
			} else {
				$errMSG = "Incorrect Credentials, Try again...";
			}
				
		}
		
	}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Adventure Lookup</title>
        <link href="assets/css/style.css" rel="stylesheet" />
        <link href="assets/css/bootstrap.css" rel="stylesheet" />
        <link href="assets/css/font-awesome.css" rel="stylesheet" />
        <link href="lity-2.2.2/dist/lity.css" rel="stylesheet">
        <script src="lity-2.2.2/vendor/jquery.js"></script>
        <script src="lity-2.2.2/dist/lity.js"></script>
</head>
<body>
    
<div class="topnav">
    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <div class="logo">
                <a href="index.php">
                    <img src="assets/img/MC-AL.jpeg" height="70" width="70" />
                </a>
            </div>
        </div>
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-5">
            <div class="title">
                <a href="index.php">
                    <img class="title-img" src="assets/img/AL.png" height="70" width="400" />
                </a>
            </div>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-5">
            <div class="col-lg-2mod col-md-2 col-sm-2 col-xs-5">
                <p><a href="login.php">Login</a></p>
                <p><a href="register.php">Register</a></p>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12"></div>
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
        <div class="main">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
        	<div class="form-group">
            	<h2 class="">Sign In.</h2>
            </div>
            
            <?php
			if ( isset($errMSG) ) {
				
				?>
				<div class="form-group">
            	<div class="alert alert-danger">
				<span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                </div>
            	</div>
                <?php
			}
			?>
            
            <div class="form-group">
            	<div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
            	<input type="email" name="email" class="form-control" placeholder="Email" value="<?php echo $email; ?>" maxlength="40" />
                </div>
                <span class="text-danger"><?php echo $emailError; ?></span>
            </div>
            
            <div class="form-group">
            	<div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
            	<input type="password" name="pass" class="form-control" placeholder="Password" maxlength="15" />
                </div>
                <span class="text-danger"><?php echo $passError; ?></span>
            </div>
            
            
            <div class="form-group">
            	<button type="submit" class="btn btn-block btn-primary" name="btn-login">Sign In</button>
            </div>
            
            <div class="form-group">
            	<hr />
            </div>
        </form>
            <p><a href="register.php">Register Here</a></p>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12"></div>
</div>
<div class="footer">
    <p>Copyright © <?php echo date("Y"); ?> AdventureLookup.com | Site Created by @Magfersile</p>
</div>    
    
</body>

</html>
<?php ob_end_flush(); ?>