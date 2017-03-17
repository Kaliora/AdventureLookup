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
			
			$password = hash('sha256', $pass); // password hashing using SHA256
		
			$res=mysqli_query("SELECT * FROM users WHERE userEmail='$email'");
			$row=mysqli_fetch_array($res);
			$count = mysqli_num_rows($res); // if username/pass correct its return must be 1 row
			
			if( $count == 1 && $row['userPass']==$password ) {
				$_SESSION['user'] = $row['userId'];
				header("Location: home.php");
			} else {
				$errMSG = "Incorrect Credentials, Try again...";
			}
				
		}
		
	}
    $result = mysqli_query($conn,"SELECT * FROM adventures WHERE ApprovedBy != '0'");
    $numrecords = mysqli_num_rows($result);
    $totalrecords = mysqli_num_rows($result);

    if( isset($_POST['FilterButton']) ) {
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
        /*
        echo $Edition."<br/>";
        echo $CampaignSetting."<br/>";
        echo $NumberOfCharacters."<br/>";
        echo $MinLevel."<br/>";
        echo $MaxLevel."<br/>";
        echo $Environment."<br/>";
        echo $Climate."<br/>";
        echo $Publisher."<br/>";
        echo $PublishDates."<br/>";
        echo $Authors."<br/>";
        echo $LinkedModules."<br/>";
        echo $PregenCharacters."<br/>";
        echo $Handouts."<br/>";
        echo $Maps."<br/>";
        echo $Villains."<br/>";
        echo $Items."<br/>";
        echo $Keywords."<br/>";
        */
        
        $sql = "SELECT * FROM adventures";
            // Edition
        if ($Edition != "" && $sql == "SELECT * FROM adventures") {
            $sql .= " WHERE Edition = '".$Edition."' ";
        } else if ($Edition != "") {
            $sql .= " AND Edition = '".$Edition."' ";
        }
            // CampaignSetting
        if ($CampaignSetting != "" && $sql == "SELECT * FROM adventures") {
            $sql .= " WHERE CampaignSetting = '".$CampaignSetting."' ";
        } else if ($CampaignSetting != "") {
            $sql .= " AND CampaignSetting = '".$CampaignSetting."' ";
        }
            // NumberOfCharacters
        if ($NumberOfCharacters != "" && $sql == "SELECT * FROM adventures") {
            $sql .= " WHERE NumberOfCharacters = '".$NumberOfCharacters."' ";
        } else if ($NumberOfCharacters != "") {
            $sql .= " AND NumberOfCharacters = '".$NumberOfCharacters."' ";
        }
            // MinLevel
        if ($MinLevel != "" && $sql == "SELECT * FROM adventures") {
            $sql .= " WHERE MinLevel = '".$MinLevel."' ";
        } else if ($MinLevel != "") {
            $sql .= " AND MinLevel = '".$MinLevel."' ";
        }
            // MaxLevel
        if ($MaxLevel != "" && $sql == "SELECT * FROM adventures") {
            $sql .= " WHERE MaxLevel = '".$MaxLevel."' ";
        } else if ($MaxLevel != "") {
            $sql .= " AND MaxLevel = '".$MaxLevel."' ";
        }
            // Environment
        if ($Environment != "" && $sql == "SELECT * FROM adventures") {
            $sql .= " WHERE Environment = '".$Environment."' ";
        } else if ($Environment != "") {
            $sql .= " AND Environment = '".$Environment."' ";
        }
            // Climate
        if ($Climate != "" && $sql == "SELECT * FROM adventures") {
            $sql .= " WHERE Climate = '".$Climate."' ";
        } else if ($Climate != "") {
            $sql .= " AND Climate = '".$Climate."' ";
        }
            // Publisher
        if ($Publisher != "" && $sql == "SELECT * FROM adventures") {
            $sql .= " WHERE Publisher = '".$Publisher."' ";
        } else if ($Publisher != "") {
            $sql .= " AND Publisher = '".$Publisher."' ";
        }
            // PublishDates
        if ($PublishDates != "" && $sql == "SELECT * FROM adventures") {
            $sql .= " WHERE PublishDates = '".$PublishDates."' ";
        } else if ($PublishDates != "") {
            $sql .= " AND PublishDates = '".$PublishDates."' ";
        }
            // Authors
        if ($Authors != "" && $sql == "SELECT * FROM adventures") {
            $sql .= " WHERE Authors = '".$Authors."' ";
        } else if ($Authors != "") {
            $sql .= " AND Authors = '".$Authors."' ";
        }
            // LinkedModules
        if ($LinkedModules != "" && $sql == "SELECT * FROM adventures") {
            $sql .= " WHERE LinkedModules = '".$LinkedModules."' ";
        } else if ($LinkedModules != "") {
            $sql .= " AND LinkedModules = '".$LinkedModules."' ";
        }
            // PregenCharacters
        if ($PregenCharacters != "" && $sql == "SELECT * FROM adventures") {
            $sql .= " WHERE PregenCharacters = '".$PregenCharacters."' ";
        } else if ($PregenCharacters != "") {
            $sql .= " AND PregenCharacters = '".$PregenCharacters."' ";
        }
            // Handouts
        if ($Handouts != "" && $sql == "SELECT * FROM adventures") {
            $sql .= " WHERE Handouts = '".$Handouts."' ";
        } else if ($Handouts != "") {
            $sql .= " AND Handouts = '".$Handouts."' ";
        }
            // Maps
        if ($Maps != "" && $sql == "SELECT * FROM adventures") {
            $sql .= " WHERE Maps = '".$Maps."' ";
        } else if ($Maps != "") {
            $sql .= " AND Maps = '".$Maps."' ";
        }
            // Villains
        if ($Villains != "" && $sql == "SELECT * FROM adventures") {
            $sql .= " WHERE Villains = '".$Villains."' ";
        } else if ($Villains != "") {
            $sql .= " AND Villains = '".$Villains."' ";
        }
            // Items
        if ($Items != "" && $sql == "SELECT * FROM adventures") {
            $sql .= " WHERE Items = '".$Items."' ";
        } else if ($Items != "") {
            $sql .= " AND Items = '".$Items."' ";
        }
            // Keywords
        if ($Keywords != "" && $sql == "SELECT * FROM adventures") {
            $sql .= " WHERE Keywords = '".$Keywords."' ";
        } else if ($Keywords != "") {
            $sql .= " AND Keywords = '".$Keywords."' ";
        }
            //Approved records only
        if ($sql == "SELECT * FROM adventures") {
            $sql .= " WHERE ApprovedBy != '0'";
        } else {
            $sql .= " AND ApprovedBy != '0'";
        }
        
        //echo $sql;
        $result = mysqli_query($conn,$sql);
        $numrecords = mysqli_num_rows($result);
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
        <script src="assets/javascript/js.js"></script>
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
            <p><a href="login.php">Login</a></p>
            <p><a href="register.php">Register</a></p>
        </div>
    </div>
</div>
    <!-- leftbar begin -->
<div class="row">
    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
        <!-- <a href="#" onclick="togglevis()">Show/Hide Criteria</a> -->
        <div class="leftbar" id="search">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
                <h5>Keyword Search</h5>
                    <p>Villain(s): &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input class="search" type="text" name="Villains"/></p><br/>
                    <p>Item(s): &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input class="search" type="text" name="Items"/></p><br/>
                    <p>Keyword(s): <input class="search" type="text" name="Keywords"/></p>
                <hr>
                <h5>Edition</h5>
                <select class="form-control" name="Edition">
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
                <hr>
                <h5>Campaign Setting</h5>
                <select class="form-control" name="CampaignSetting">
                    <option value="">---</option>
                    <option value="Alfeimur">Alfeimur</option>
                    <option value="Al-Qadim">Al-Qadim</option>
                    <option value="Birthright">Birthright</option>
                    <option value="Blackmoor">Blackmoor</option>
                    <option value="Council of Wyrms">Council of Wyrms</option>
                    <option value="Dark Sun">Dark Sun</option>
                    <option value="Dragonlance">Dragonlance</option>
                    <option value="Eberron">Eberron</option>
                    <option value="Forgotten Realms">Forgotten Realms</option>
                    <option value="Greyhawk">Greyhawk</option>
                    <option value="Hollow World">Hollow World</option>
                    <option value="Kara-Tur">Kara-Tur</option>
                    <option value="Kingdoms of Kalamar">Kingdoms of Kalamar</option>
                    <option value="Lankhmar – City of Adventure">Lankhmar</option>
                    <option value="Mystara">Mystara</option>
                    <option value="Planescape">Planescape</option>
                    <option value="Ravenloft">Ravenloft</option>
                    <option value="Spelljammer">Spelljammer</option>
                    <option value="Thunder Rift">Thunder Rift</option>
                </select>
                <hr>
                <h5>Number of Players</h5>
                <p><input class="menutext" type="text" name="NumberOfCharacters"/></p>
                <hr>
                <h5>Player Level</h5>
                <p>Min <input class="menutext" type="text" name="MinLevel"/>
                 | 
                Max <input class="menutext" type="text" name="MaxLevel"/></p>
                <hr>
                <h5>Environment</h5>
                    <small>
                    <p><input type="checkbox" name="Environment1" value="Aquatic"/> Aquatic</p>
                    <p><input type="checkbox" name="Environment2" value="Desert"/> Desert</p>
                    <p><input type="checkbox" name="Environment3" value="Forest"/> Forest</p>
                    <p><input type="checkbox" name="Environment4" value="Hill"/> Hill</p>
                    <p><input type="checkbox" name="Environment5" value="Marsh"/> Marsh</p>
                    <p><input type="checkbox" name="Environment6" value="Mountain"/> Mountain</p>
                    <p><input type="checkbox" name="Environment7" value="Plain"/> Plain</p>
                    <p><input type="checkbox" name="Environment8" value="Underground"/> Underground</p>
                    </small>
                <hr>
                <h5>Climate</h5>
                    <small><p><input type="checkbox" name="Climate1" value="Cold" /> Cold</p>
                    <p><input type="checkbox" name="Climate2" value="Temperate" /> Temperate</p>
                    <p><input type="checkbox" name="Climate3" value="Warm" /> Warm</p></small>
                <hr>
                <h5>Publishing Details</h5>
                    <p><small>Publisher: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input class="menutext" type="text" name="Publisher"/></small></p>
                    <p><small>Publish Date(s): <input class="menutext" type="text" name="PublishDates"/></small></p>
                    <p><small>Author(s): &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input class="menutext" type="text" name="Authors"/></small></p>
                <hr>    
                <h5>Other Details</h5>
                <p><small><input type="checkbox" name="LinkedModules" value="yes"/> Linked Modules</small></p>
                    <p><small><input type="checkbox" name="PregenCharacters" value="yes"/> Pregenerated Characters</small></p>
                    <p><small><input type="checkbox" name="Handouts" value="yes"/> Handouts</small></p>
                    <p><small><input type="checkbox" name="Maps" value="yes"/> Maps</small></p>
                <hr>
                <button type="submit" class="btn btn-primary" name="FilterButton">Apply Filters</button>
            </form>
        </div>
    </div>
    <div id="borderleft"></div>
    <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
        <div class="main">
            <div class="col-lg-12 ">
                <br/>
                <div class="alert alert-success">
                    <p>This site is still under development and <strong>we need your help!</strong></p>
                    <p><a href="contribute.php">Want to add an adventure to the database?</a></p>
                    <p><a href="feedback.php" target="_blank">Feel like sending some feedback?</a></p>
                </div>
                <div class="alert alert-info">
                    <p>Displaying <?php echo $numrecords; ?> of <?php echo $totalrecords; ?> total records.</p>
                </div>
            </div>
            <?php
                        while($row = mysqli_fetch_array($result))
                        { 
                    ?>
                    
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="content-record">
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
        </div>
    </div>
</div>
<div class="footer">
    <p>Copyright © <?php echo date("Y"); ?> AdventureLookup.com | Site Created by @Magfersile</p>
</div>    
    
</body>

</html>
<?php ob_end_flush(); ?>