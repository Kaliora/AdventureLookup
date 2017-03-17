<?php
    header("Cache-Control: no-cache, must-revalidate");
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

    // if session is not set this will redirect to login page
	if( $userRow['UserPrivilege'] != "Moderator" ) {
		header("Location: index.php");
		exit;
	}

    // check for session timeout
    if ($_SESSION['timeout'] + 120 * 60 < time()) {
        //session_unset();
        //session_destroy();
        //header("Location: logout.php");
		//exit;
        $timeout = true;
        $timeoutMsg = "You have been logged out due to inactivity.";
    } else if ($userRow['isLogged'] == 0) {
        $timeout = true;
        $timeoutMsg = "Please login to continue.";
    } else {
        $_SESSION['timeout'] = time();
    }

    // check if a moderator wants to publish/edit/delete a record
    if ( isset($_POST['publish'])) {
    //publish in database
        $publishsql="UPDATE adventures SET ApprovedBy = '".$_SESSION['user']."' WHERE ID = ".$_POST['ID'];
        if (mysqli_query($conn,$publishsql)) {
            $errType = "success";
            $publishmsg = "Hooray! Database entry #".$_POST['ID']." published.";
        } else {
            $errType = "danger";
            $publishmsg = "Failed trying to publish database entry.";
        }
    }
        
    if( isset($_POST['editrecord'])) {
        $_SESSION['RecordID'] = $_POST['ID'];
        header("Location: editrecord.php");
    } else if(isset($_POST['confirm'])) {
        //remove row
        $removesql="DELETE FROM adventures WHERE ID = ".$_POST['ID'];
    if (mysqli_query($conn,$removesql)) {
            $removemsg = "Database entry #".$_POST['ID']." removed.";
    } else {
            $removemsg = "Failed trying to remove database entry.";
    }
    }

    if (isset($_POST['unpublish'])) {
    //un-publish in database
        $unpublishsql="UPDATE adventures SET ApprovedBy = 0 WHERE ID = ".$_POST['ID'];
        if (mysqli_query($conn,$unpublishsql)) {
            $errType = "success";
            $unpublishmsg = "Database entry #".$_POST['ID']." un-published.";
        } else {
            $errType = "danger";
            $unpublishmsg = "Failed trying to un-publish database entry.";
        }
    }

    $unapprovedresults = mysqli_query($conn,"SELECT * FROM adventures WHERE ApprovedBy = '0'");
    $numpending = mysqli_num_rows($unapprovedresults);
    $approvedresults = mysqli_query($conn,"SELECT * FROM adventures WHERE ApprovedBy != '0'");
    $numapproved = mysqli_num_rows($approvedresults);

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
        <?php
            if ($timeout) {
                $_SESSION['timeoutFlag'] = true;
                ?>
                <meta http-equiv="refresh" content="2; url=logout.php">
                <?php
            }
        ?>
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
            <div class="logout">
                <form method="post" action="logout.php" autocomplete="off">
                <span class="glyphicon glyphicon-user"></span>&nbsp;Hi <?php echo $userRow['userName']; ?>&nbsp;<br/>
                <?php
                    if ($userRow['UserPrivilege'] == "Moderator") { 
                ?>
                <a href="modpanel.php" class="myButton-red">Mod</a>
                <?php
                    }
                ?>
                <button type="submit" name="logout" class="myButton-orange">Logout</button>
                </form>
            </div>
        </div>
    </div>
</div>
    <!-- leftbar begin -->
<div class="row">
    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12"></div>
    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
        <div class="main">
            <div class="col-lg-12">
                <br/>
                <div class="alert alert-success">
                    <p>Please take a look at the <a href="guidelines.php" target="_blank">Guidelines</a> for clarification on the normalization rules.</p>
                </div>
                <?php
                    if (!isset($_POST['public'])) {
                        ?>
                            <div class="alert alert-info">
                                <p>Displaying <?php echo $numpending; ?> records that are pending approval.</p>
                            </div>
                        <?php
                    } else {
                        ?>
                            <div class="alert alert-info">
                                <p>Displaying <?php echo $numapproved; ?> records that are publicly visible.</p>
                            </div>
                        <?php
                    }
                
                    if (isset($removemsg)) {
                        ?>
                            <div class="alert alert-danger">
                                <p><?php echo $removemsg; ?></p>
                            </div>
                        <?php
                    } else if (isset($publishmsg)) {
                        ?>
                            <div class="alert alert-<?php echo $errType; ?>">
                                <p><?php echo $publishmsg; ?></p>
                            </div>
                        <?php
                    } else if (isset($unpublishmsg)) {
                            ?>
                                <div class="alert alert-<?php echo $errType; ?>">
                                    <p><?php echo $unpublishmsg; ?></p>
                                </div>
                            <?php
                                }
                ?>
                
            </div>
            <?php
                if (!isset($_POST['public'])) {
                    ?>
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
                            <button type="submit" name="pending" class="myButton">Pending</button>
                            <button type="submit" name="public" class="myButton-inactive">Public</button>
                        </form>
            <?php
                        while($row = mysqli_fetch_array($unapprovedresults))
                        { 
                    ?>
                    
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="content-record">
                                <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
                                        <span>#<?php echo $row[ID]; ?></span>
                                        <input type="hidden" name="ID" value="<?php echo $row[ID]; ?>"/>
                                        <button type="submit" name="publish" class="myButton-green">Publish</button>
                                        <button type="submit" name="editrecord" class="myButton-orange">Edit</button>
                                        <button type="submit" name="deleterecord" class="myButton-red">Delete</button>
                                        <?php
                                            if (isset($_POST['deleterecord']) && $row['ID'] == $_POST['ID']) {
                                        ?>
                                        <button type="submit" name="confirm" class="myButton-red">Confirm</button>
                                        <?php
                                            }
                                        ?>
                                </form>
                                <a href="#inline<?php echo $row[ID]; ?>" data-lity>
                                    <h4><?php echo $row[AdventureName]; ?></h4>
                                </a>
                                <p>
                                    <strong>Edition:</strong><small> <?php echo $row[Edition]; ?></small>
                                    <strong>Players:</strong><small> <?php echo $row[NumberOfCharacters]; ?></small>
                                    <strong>Setting:</strong><small> <?php echo $row[CampaignSetting]; ?></small>
                                    <strong>Levels:</strong><small> <?php echo $row[MinLevel] . "-" . $row[MaxLevel]?></small>
                                    <strong>Environment:</strong><small> <?php echo $row[Environment]; ?></small>
                                    <strong>Climate:</strong><small> <?php echo $row[Climate]; ?></small>
                                </p>
                                <p><?php echo substr($row[Summary], 0, 300); ?>...</p>
                                <div id="inline<?php echo $row[ID]; ?>" style="background:#fff" class="lity-hide">
                                    <h4><?php echo $row[AdventureName]; ?></h4>
                                    <p>
                                    <strong>Edition:</strong><small> <?php echo $row[Edition]; ?></small>
                                    <strong>Players:</strong><small> <?php echo $row[NumberOfCharacters]; ?></small>
                                    <strong>Setting:</strong><small> <?php echo $row[CampaignSetting]; ?></small>
                                    <strong>Levels:</strong><small> <?php echo $row[MinLevel] . "-" . $row[MaxLevel]?></small>
                                    <strong>Environment:</strong><small> <?php echo $row[Environment]; ?></small>
                                    <strong>Climate:</strong><small> <?php echo $row[Climate]; ?></small>
                                    <strong>Date Published:</strong><small> <?php echo $row[PublishDates]; ?></small>
                                    <strong>Publisher:</strong><small> <?php echo $row[Publisher]; ?></small>
                                    <strong>Authors:</strong><small> <?php echo $row[Authors]; ?></small>
                                    <strong>Number of Pages:</strong><small> <?php echo $row[NumberOfPages]; ?></small>
                                    <strong>Linked Modules:</strong><small> <?php echo $row[LinkedModules]; ?></small>
                                    <strong>TSR Product Code:</strong><small> <?php echo $row[TSRProductCode]; ?></small>
                                    <strong>ISBN:</strong><small> <?php echo $row[ISBN]; ?></small>
                                    <strong>Pregen Characters:</strong><small> <?php echo $row[PregenCharacters]; ?></small>
                                    <strong>Handouts:</strong><small> <?php echo $row[Handouts]; ?></small>
                                    <strong>Maps:</strong><small> <?php echo $row[Maps]; ?></small>
                                    <strong>Format:</strong><small> <?php echo $row[Format]; ?></small>
                                    </p>
                                    <p>
                                    <strong>Reference Links:</strong><small> <?php linkify($row[ReferenceLinks]); ?></small>
                                    </p>
                                    <p>
                                    <strong>Link to PDF:</strong><small> <?php linkify($row[LinkToPDF]); ?></small>
                                    </p>
                                    <p>
                                    <strong>Keywords:</strong><small> <?php echo $row[Keywords]; ?></small>
                                    </p>
                                    <p>
                                    <strong>Villains:</strong><small> <?php echo $row[Villains]; ?></small>
                                    </p>
                                    <p>
                                    <strong>Items:</strong><small> <?php echo $row[Items]; ?></small>
                                    </p>
                                    <p><?php echo $row[Summary]; ?></p>
                                </div>
                                
                            </div>
                        </div> 
                    
                    <!-- /. ROW  --> 
                    <?php
                        }
                    ?>
                    <?php
                } else {
                    ?>
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
                            <button type="submit" name="pending" class="myButton-inactive">Pending</button>
                            <button type="submit" name="public" class="myButton">Public</button>
                        </form>
                    <?php
                        while($row = mysqli_fetch_array($approvedresults))
                        { 
                    ?>
                    
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="content-record">
                                <?php
                                if ($userRow['UserPrivilege'] == "Moderator") {
                                ?>
                                    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
                                        <span>#<?php echo $row[ID]; ?></span>
                                        <input type="hidden" name="ID" value="<?php echo $row[ID]; ?>"/>
                                        <button type="submit" name="unpublish" class="myButton-orange">Un-Publish</button>
                                    </form>
                                <?php
                                }
                                ?>
                                <a href="#inline<?php echo $row[ID]; ?>" data-lity>
                                    <h4><?php echo $row[AdventureName]; ?></h4>
                                </a>
                                <p>
                                    <strong>Edition:</strong><small> <?php echo $row[Edition]; ?></small>
                                    <strong>Players:</strong><small> <?php echo $row[NumberOfCharacters]; ?></small>
                                    <strong>Setting:</strong><small> <?php echo $row[CampaignSetting]; ?></small>
                                    <strong>Levels:</strong><small> <?php echo $row[MinLevel] . "-" . $row[MaxLevel]?></small>
                                    <strong>Environment:</strong><small> <?php echo $row[Environment]; ?></small>
                                </p>
                                <p><?php echo substr($row[Summary], 0, 300); ?>...</p>
                                <div id="inline<?php echo $row[ID]; ?>" style="background:#fff" class="lity-hide">
                                    <h4><?php echo $row[AdventureName]; ?></h4>
                                    <p>
                                    <strong>Edition:</strong><small> <?php echo $row[Edition]; ?></small>
                                    <strong>Players:</strong><small> <?php echo $row[NumberOfCharacters]; ?></small>
                                    <strong>Setting:</strong><small> <?php echo $row[CampaignSetting]; ?></small>
                                    <strong>Levels:</strong><small> <?php echo $row[MinLevel] . "-" . $row[MaxLevel]?></small>
                                    <strong>Environment:</strong><small> <?php echo $row[Environment]; ?></small>
                                    <strong>Date Published:</strong><small> <?php echo $row[PublishDates]; ?></small>
                                    <strong>Publisher:</strong><small> <?php echo $row[Publisher]; ?></small>
                                    <strong>Authors:</strong><small> <?php echo $row[Authors]; ?></small>
                                    <strong>Number of Pages:</strong><small> <?php echo $row[NumberOfPages]; ?></small>
                                    <strong>Linked Modules:</strong><small> <?php echo $row[LinkedModules]; ?></small>
                                    <strong>TSR Product Code:</strong><small> <?php echo $row[TSRProductCode]; ?></small>
                                    <strong>ISBN:</strong><small> <?php echo $row[ISBN]; ?></small>
                                    <strong>Pregen Characters:</strong><small> <?php echo $row[PregenCharacters]; ?></small>
                                    <strong>Handouts:</strong><small> <?php echo $row[Handouts]; ?></small>
                                    <strong>Maps:</strong><small> <?php echo $row[Maps]; ?></small>
                                    <strong>Format:</strong><small> <?php echo $row[Format]; ?></small>
                                    </p>
                                    <p>
                                    <strong>Reference Links:</strong><small> <?php echo $row[ReferenceLinks]; ?></small>
                                    </p>
                                    <p>
                                    <strong>Link to PDF:</strong><small> <?php echo $row[LinkToPDF]; ?></small>
                                    </p>
                                    <p>
                                    <strong>Keywords:</strong><small> <?php echo $row[Keywords]; ?></small>
                                    </p>
                                    <p>
                                    <strong>Villains:</strong><small> <?php echo $row[Villains]; ?></small>
                                    </p>
                                    <p>
                                    <strong>Items:</strong><small> <?php echo $row[Items]; ?></small>
                                    </p>
                                    <p><?php echo $row[Summary]; ?></p>
                                </div>
                                
                            </div>
                        </div> 
                    
                    <!-- /. ROW  --> 
                    <?php
                        }
                    ?>
                    <?php
                }
            ?>
            
        </div>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12"></div>
</div>
<div class="footer">
    <p>Copyright © <?php echo date("Y"); ?> AdventureLookup.com | Site Created by @Magfersile</p>
</div>    
<?php
    if ($timeout) {
        ?>
            <div class="lity lity-opened lity-inline" role="dialog" aria-label="Dialog Window (Press escape to close)" tabindex="-1" aria-hidden="false">
                <div class="lity-wrap" data-lity-close="" role="document">
                    <div class="lity-container">
                        <div class="lity-content">
                            <div id="inline1" style="background: rgb(255, 255, 255); max-height: 967px;" class="">
                                <div class="alert alert-danger">
                                    <i class="fa fa-refresh fa-spin" style="font-size:24px"></i>
                                    <?php echo $timeoutMsg; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
    }
?>
</body>

</html>
<?php ob_end_flush(); ?>