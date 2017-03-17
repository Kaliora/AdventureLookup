
<?php
    header("Cache-Control: no-cache, must-revalidate");
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
    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12"></div>
    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
        <div class="main">
            <div class="alert alert-success" role="alert">
                <p><strong>Current version: Alpha Release is here!</strong></p>
                <p>The database is ready to be populated.  There shouldn't be many issues, but if you do happen to find any, please send me a tweet @Magfersile or <a href="feedback.php" target="_blank">use this form</a></p>
            </div>
            <h4>Changelog:</h4>
            <div class="alert alert-info" role="alert">
                <p>- Adventure Database Design has been Completed</p>
                <p>- Usernames Now Support Numbers as well as Letters</p>
                <p>- Sessions Timeout After 120 Minutes of Inactivity</p>
                <p>- A Few Security Improvements</p>
                <p>- Length of Dropdown Lists has been Shortedned to Improve Readability</p>
                <p>- Support for Pathfinder has been Added</p>
                <p>- Minor Typo Corrections and Small Fixes</p>
                <p>- Better Registration Form Validation</p>
                <p>- A Few Mobile Optimizations</p>
            </div>
            <h4>Still To Do:</h4>
            <div class="alert alert-warning" role="alert">
                <p><strong>Quite Alot! Here is What is Coming Next</strong></p>
                <p>- Better Formatting for Each Record and Support for Cover Images</p>
                <p>- Keyword / Tagging System</p>
                <p>- Upvoting System</p>
                <p>- User Email Verification</p>
                <p>- Collapsable Search Menu</p>
                <p>- Further Optimizations for Mobile</p>
                <p>- More Intuitive Form Validation</p>
                <p>- Layout Improvement and Better Graphics</p>
            </div>
            <p><a href="index.php"><h4>Enter The Site</h4></a></p>
        </div>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12"></div>
</div>
<div class="footer">
    <p>Copyright © <?php echo date("Y"); ?> AdventureLookup.com | Site Created by @Magfersile</p>
</div>    
    
</body>

</html>
<?php ob_end_flush(); ?>