<?php
    header("Cache-Control: no-cache, must-revalidate");
	ob_start();
	session_start();
	require_once 'dbconnect.php';
	
	if (isset($_POST['feedback'])) {
        $Functionality = sanitize($_POST['Functionality']);
        $Usability = sanitize($_POST['Usability']);
        $Feedback = sanitize($_POST['Feedback']);
        $OtherFeatures = sanitize($_POST['OtherFeatures']);
        $OS = sanitize($_POST['OS']);
        $Browser = sanitize($_POST['Browser']);
        $Mobile = sanitize($_POST['Mobile']);
        
        $sql="INSERT INTO feedback (`Functionality`, `Usability`, `Feedback`, `OtherFeatures`, `OS`, `Browser`, `Mobile`) VALUES ('".$Functionality."','".$Usability."','".$Feedback."','".$OtherFeatures."','".$OS."','".$Browser."','".$Mobile."')";
        if ($exec = mysqli_query($conn,$sql)) {
            $msg = "Thank you for for your feedback!";
        } else {
            $ermsg = "Something went wrong or the database is currently down.  Please try again later or contact the site administrator.";
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
            
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12"></div>
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
        <div class="main">
            <?php
                if (isset($msg)) {
                    ?>
                    <div class="alert alert-success" style="width: 350px;">
                        <p><?php echo $msg; ?></p>
                    </div>
                    <?php
                }
                if (isset($ermsg)) {
                    ?>
                    <div class="alert alert-danger" style="width: 350px;">
                        <p><?php echo $ermsg; ?></p>
                    </div>
                    <?php
                }
            ?>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
                <p>Please enter any feedback that pertains to <strong>functionality</strong> only.  i.e. Things that don't work correctly or any error messages you received.</p>
                <textarea name="Functionality" rows="5" cols="50" maxlength="32000"></textarea>
                <hr>
                <p>Please enter any feedback that pertains to <strong>usability</strong> only.  i.e. Layout issues, overlapping objects, color issues, text issues, navigation issues, general look and feel.</p>
                <textarea name="Usability" rows="5" cols="50" maxlength="32000"></textarea>
                <p>Any other feedback you would like to leave.  i.e. Your opinion on any other topic not related to functionality or usability, personal notes and or messages you would like to leave for the developer.</p>
                <textarea name="Feedback" rows="5" cols="50" maxlength="32000"></textarea>
                <p>Feature Requests  i.e. Is the site missing something that would improve it in some way you would like to see added?</p>
                <textarea name="OtherFeatures" rows="5" cols="50" maxlength="32000"></textarea>
                <p>What operation system are you using?</p>
                <textarea name="OS" rows="5" cols="50" maxlength="32000"></textarea>
                <p>What internet browser are you using?</p>
                <textarea name="Browser" rows="5" cols="50" maxlength="32000"></textarea>
                <p>What mobile device are you using? (if applicable)</p>
                <textarea name="Mobile" rows="5" cols="50" maxlength="32000"></textarea>
                <button type="submit" name="feedback" class="btn btn-primary">Send Feedback</button>
            </form>
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