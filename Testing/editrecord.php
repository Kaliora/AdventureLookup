<?php
    header("Cache-Control: no-cache, must-revalidate");
	ob_start();
	session_start();
	require_once 'dbconnect.php';
	
	// if session is not set this will redirect to login page
	if( !isset($_SESSION['user']) ) {
		header("Location: login.php");
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

    $recordsql=mysqli_query($conn,"SELECT * FROM adventures WHERE ID=".$_SESSION['RecordID']);
	$record=mysqli_fetch_array($recordsql);

    
    if (isset($_POST['submitrecord'])) {
        $AdventureName = $_POST['AdventureName'];
        $Summary = $_POST['Summary'];
        $Edition = $_POST['Edition'];
        $CampaignSetting = $_POST['CampaignSetting'];
        $NumberOfCharacters = $_POST['NumberOfCharacters'];
        $MinLevel = $_POST['MinLevel'];
        $MaxLevel = $_POST['MaxLevel'];
        $Environment1 = $_POST['Environment1'];
        $Environment2 = $_POST['Environment2'];
        $Environment3 = $_POST['Environment3'];
        $Environment4 = $_POST['Environment4'];
        $Environment5 = $_POST['Environment5'];
        $Environment6 = $_POST['Environment6'];
        $Environment7 = $_POST['Environment7'];
        $Environment8 = $_POST['Environment8'];
        $Climate1 = $_POST['Climate1'];
        $Climate2 = $_POST['Climate2'];
        $Climate3 = $_POST['Climate3'];
        $Publisher = $_POST['Publisher'];
        $PublishDates = $_POST['PublishDates'];
        $Authors = $_POST['Authors'];
        $LinkToPDF = $_POST['LinkToPDF'];
        $ReferenceLinks = $_POST['ReferenceLinks'];
        $LinkedModules = $_POST['LinkedModules'];
        $PregenCharacters = $_POST['PregenCharacters'];
        $Handouts = $_POST['Handouts'];
        $Maps = $_POST['Maps'];
        $NumberOfPages = $_POST['NumberOfPages'];
        $NotesToModerator = $_POST['NotesToModerator'];
        $TSRProductCode = $_POST['TSRProductCode'];
        $Format = $_POST['Format'];
        $ISBN = $_POST['ISBN'];
        $Villains = $_POST['Villains'];
        $Items = $_POST['Items'];
        $Keywords = $_POST['Keywords'];
        
        sanitize($AdventureName);
        sanitize($Summary);
        sanitize($NumberOfCharacters);
        sanitize($MinLevel);
        sanitize($MaxLevel);
        sanitize($Publisher);
        sanitize($PublishDates);
        sanitize($Authors);
        sanitize($NumberOfPages);
        sanitize($TSRProductCode);
        sanitize($Format);
        sanitize($ISBN);
        sanitize($LinkToPDF);
        sanitize(ReferenceLinks);
        sanitize($LinkedModules);
        sanitize($ISBN);
        sanitize($ISBN);
        sanitize($ISBN);
        sanitize($NotesToModerator);
        
        if (isset($Environment1)) {
            $Environment .= $Environment1;
        }
        if (isset($Environment2)) {
            $Environment .= ", " . $Environment2;
        }
        if (isset($Environment3)) {
            $Environment .= ", " . $Environment3;
        }
        if (isset($Environment4)) {
            $Environment .= ", " . $Environment4;
        }
        if (isset($Environment5)) {
            $Environment .= ", " . $Environment5;
        }
        if (isset($Environment6)) {
            $Environment .= ", " . $Environment6;
        }
        if (isset($Environment7)) {
            $Environment .= ", " . $Environment7;
        }
        if (isset($Environment8)) {
            $Environment .= ", " . $Environment8;
        }
        if (isset($Climate1)) {
            $Climate .= $Climate1;
        }
        if (isset($Climate2)) {
            $Climate .= ", " . $Climate2;
        }
        if (isset($Climate3)) {
            $Climate .= ", " . $Climate3;
        }
        
        $Environment = rtrim(ltrim($Environment, ','), ',');
        $Climate = rtrim(ltrim($Climate, ','), ',');
	    
        $sql="UPDATE adventures SET `AdventureName` = '".$AdventureName."', `Summary` = '".$Summary."', `PublishDates` = '".$PublishDates."', `Authors` = '".$Authors."', `Edition` = '".$Edition."', `CampaignSetting` = '".$CampaignSetting."', `Publisher` = '".$Publisher."', `LinkToPDF` = '".$LinkToPDF."', `NumberOfPages` = '".$NumberOfPages."', `LinkedModules` = '".$LinkedModules."', `TSRProductCode` = '".$TSRProductCode."', `MinLevel` = '".$MinLevel."', `MaxLevel` = '".$MaxLevel."', `NumberOfCharacters` = '".$NumberOfCharacters."', `PregenCharacters` = '".$PregenCharacters."', `Handouts` = '".$Handouts."', `Environment` = '".$Environment."', `Format` = '".$Format."', `Maps` = '".$Maps."', `Villains` = '".$Villains."', `Items` = '".$Items."', `ReferenceLinks` = '".$ReferenceLinks."', `Keywords` = '".$Keywords."', `ISBN` = '".$ISBN."', `Climate` = '".$Climate."', `NotesToModerator` = '".$NotesToModerator."' WHERE ID = '".$_SESSION[RecordID]."'";
        
        //$exec = mysqli_query($conn,$sql);
        //unset($_SESSION['RecordID']);
        //echo $sql;
        //if ($error = mysqli_error()) die('Error, insert query failed with:' . $error);
        if (mysqli_query($conn,$sql)) {
            $errType = "success";
            $MSG = "Database entry successfully edited.";
        } else {
            $errType = "danger";
            $MSG = "Database entry could not be edited. Please try again later or contact the site admin if the problem persists.";
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
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12"></div>
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
        <div class="main">
            <div class="alert alert-success" style="width: 350px;">
                    <p>Please take a look at the <a href="guidelines.php" target="_blank">Guidelines</a> for clarification on the normalization rules.</p>
            </div>
            <?php
                if (isset($MSG)) {
                    ?>
                    <div class="alert alert-<?php echo $errType; ?>" style="width: 350px;">
                        <p><?php echo $MSG; ?></p>
                    </div>
            <?php
                }
                
            ?>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
                <h5>Adventure Name</h5>
                <small>
                    <textarea name="AdventureName" rows="5" cols="50" maxlength="200"><?php echo $record['AdventureName']; ?></textarea>
                </small>
                <h5>Adventure Summary</h5>
                <small>
                    <textarea name="Summary" rows="5" cols="50" maxlength="32000"><?php echo $record['Summary']; ?></textarea>
                </small>
                <h5>Edition</h5>
                <select style="width: 300px;" class="form-control" name="Edition">
                <option value="<?php echo $record['Edition']; ?>" selected><?php echo $record['Edition']; ?></option>
                <option value="">---</option>
                <option value="D&D">D&D</option>
                <option value="AD&D">AD&D</option>
                <option value="AD&D 2E">AD&D 2E</option>
                <option value="AD&D 2E Revised">AD&D 2E Revised</option>
                <option value="D&D 3E">D&D 3E</option>
                <option value="D&D 3.5E">D&D 3.5E</option>
                <option value="Pathfinder">Pathfinder</option>
                <option value="D&D 4E">D&D 4E</option>
                <option value="D&D Essentials">D&D Essentials</option>
                <option value="D&D 5E">D&D 5E</option>
                </select>
                <hr class="blue">
                <h5>Campaign Setting</h5>
                <select style="width: 300px;" class="form-control" name="CampaignSetting">
                    <option value="<?php echo $record['CampaignSetting']; ?>" selected><?php echo $record['CampaignSetting']; ?></option>
                    <option value="none">---</option>
                    <option value="Alfeimur">Alfeimur</option>
                    <option value="Al-Qadim">Al-Qadim</option>
                    <option value="Birthright">Birthright</option>
                    <option value="Blackmoor">Blackmoor</option>
                    <option value="Council of Wyrms">Council of Wyrms</option>
                    <option value="Dark Sun">Dark Sun</option>
                    <option value="Dragonlance">Dragonlance</option>
                    <option value="Eberron<">Eberron</option>
                    <option value="Forgotten Realms">Forgotten Realms</option>
                    <option value="Greyhawk">Greyhawk</option>
                    <option value="Hollow World">Hollow World</option>
                    <option value="Kara-Tur">Kara-Tur</option>
                    <option value="Kingdoms of Kalamar">Kingdoms of Kalamar</option>
                    <option value="Lankhmar – City of Adventure">Lankhmar – City of Adventure</option>
                    <option value="Mystara">Mystara</option>
                    <option value="Planescape">Planescape</option>
                    <option value="Ravenloft">Ravenloft</option>
                    <option value="Spelljammer">Spelljammer</option>
                    <option value="Thunder Rift">Thunder Rift</option>
                </select>
                <hr class="blue">
                <h5>Number of Players</h5>
                <small>
                    <p>Min <input class="menutext" type="text" name="NumberOfCharacters"/ value="<?php echo $record['NumberOfCharacters']; ?>"></p>
                    <hr class="blue">
                    <h5>Player Level</h5>
                    <p>Min <input class="menutext" type="text" name="MinLevel" value="<?php echo $record['MinLevel']; ?>"/>
                    | 
                    Max <input class="menutext" type="text" name="MaxLevel" value="<?php echo $record['MaxLevel']; ?>"/></p>
                </small>
                <hr class="blue">
                <h5>Environment</h5>
                    <small>
                        <p><input type="checkbox" name="Environment1" value="Aquatic" <?php echo chk($record['Environment'],'Aquatic'); ?>/> Aquatic</p>
                        <p><input type="checkbox" name="Environment2" value="Desert" <?php echo chk($record['Environment'],'Desert'); ?>/> Desert</p>
                        <p><input type="checkbox" name="Environment3" value="Forest" <?php echo chk($record['Environment'],'Forest'); ?>/> Forest</p>
                        <p><input type="checkbox" name="Environment4" value="Hill" <?php echo chk($record['Environment'],'Hill'); ?>/> Hill</p>
                        <p><input type="checkbox" name="Environment5" value="Marsh" <?php echo chk($record['Environment'],'Marsh'); ?>/> Marsh</p>
                        <p><input type="checkbox" name="Environment6" value="Mountain" <?php echo chk($record['Environment'],'Mountain'); ?>/> Mountain</p>
                        <p><input type="checkbox" name="Environment7" value="Plain" <?php echo chk($record['Environment'],'Plain'); ?>/> Plain</p>
                        <p><input type="checkbox" name="Environment8" value="Underground" <?php echo chk($record['Environment'],'Underground'); ?>/> Underground</p>
                    </small>
                <hr class="blue">
                <h5>Climate</h5>
                    <small>
                        <p><input type="checkbox" name="Climate1" value="Cold" <?php echo chk($record['Climate'],'Cold'); ?>/> Cold</p>
                        <p><input type="checkbox" name="Climate2" value="Temperate" <?php echo chk($record['Climate'],'Temperate'); ?>/> Temperate</p>
                        <p><input type="checkbox" name="Climate3" value="Warm" <?php echo chk($record['Climate'],'Warm'); ?>/> Warm</p>
                    </small>
                <hr class="blue">
                <h5>Publishing Details</h5>
                    <small>
                        <p>Publisher:</p>
                        <textarea name="Publisher" rows="5" cols="50" maxlength="200"><?php echo $record['Publisher']; ?></textarea>
                        <p>Publish Dates:</p>
                        <textarea name="PublishDates" rows="5" cols="50" maxlength="200"><?php echo $record['PublishDates']; ?></textarea>
                        <p>Authors:</p>
                        <textarea name="Authors" rows="5" cols="50" maxlength="200"><?php echo $record['Authors']; ?></textarea>
                        <p>Number of Pages:<input class="menutext" type="text" name="NumberOfPages" value="<?php echo $record['NumberOfPages']; ?>"/></p>
                        <p>TSR Product Code:<input class="menutext" type="text" name="TSRProductCode" value="<?php echo $record['TSRProductCode']; ?>"/></p>
                        <p>Format:<input class="menutext" type="text" name="Format" value="<?php echo $record['Format']; ?>"/></p>
                        <p>ISBN:<input class="menutext" type="text" name="ISBN" value="<?php echo $record['ISBN']; ?>"/></p>
                    </small>
                <hr class="blue">
                <h5>External Links</h5>
                    <small>
                        <p>Link to PDF:</p>
                        <textarea name="LinkToPDF" rows="5" cols="50" maxlength="200"><?php echo $record['LinkToPDF']; ?></textarea>
                        <p>Reference Links:</p>
                        <textarea name="ReferenceLinks" rows="5" cols="50" maxlength="200"><?php echo $record['ReferenceLinks']; ?></textarea>
                    </small>
                <hr class="blue">
                <h5>Other Details</h5>
                    <small>
                        <p>Linked Modules:</p>
                        <textarea name="LinkedModules" rows="5" cols="50" maxlength="32000"><?php echo $record['LinkedModules']; ?></textarea>
                        <p><input type="checkbox" name="PregenCharacters" value="yes" <?php echo chk($record['PregenCharacters'],'yes'); ?>/> Pregenerated Characters</p>
                        <p><input type="checkbox" name="Handouts" value="yes" <?php echo chk($record['Handouts'],'yes'); ?>/> Handouts</p>
                        <p><input type="checkbox" name="Maps" value="yes" <?php echo chk($record['Maps'],'yes'); ?>/> Maps</p>
                    </small>
                <hr class="blue">
                <h5>Keyword Data</h5>
                    <small>
                        <p>Villain(s):</p>
                        <textarea name="Villains" rows="5" cols="50" maxlength="32000"><?php echo $record['Villains']; ?></textarea>
                        <p>Item(s):</p>
                        <textarea name="Items" rows="5" cols="50" maxlength="32000"><?php echo $record['Items']; ?></textarea>
                        <p>Keyword(s):</p>
                        <textarea name="Keywords" rows="5" cols="50" maxlength="32000"><?php echo $record['Keywords']; ?></textarea>
                    </small>
                <h5>Notes</h5>
                <textarea name="NotesToModerator" rows="5" cols="50" maxlength="32000"><?php echo $record['NotesToModerator']; ?></textarea>
                <br />
                <button type="submit" name="submitrecord" class="btn btn-primary">Submit Changes</button>
            </form>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12"></div>
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
<?php 

if (isset($MSG)){
    header("Location: redir.php");
}

ob_end_flush(); ?>