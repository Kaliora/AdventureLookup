<?php

	// this will avoid mysqli_connect() deprecation error.
	error_reporting( ~E_DEPRECATED & ~E_NOTICE );
	
	define('DBHOST', 'localhost');
	define('DBUSER', 'root');
	define('DBPASS', '');
	define('DBNAME', 'adventurelookup');
	
	$conn = mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
	$dbcon = mysqli_select_db($conn,DBNAME);
	
	if ( !$conn ) {
		die("Connection failed : " . mysqli_error());
	}
	
	if ( !$dbcon ) {
		die("Database Connection failed : " . mysqli_error());
	}

    function cleanInput($input) {

        $search = array(
            '@<script[^>]*?>.*?</script>@si',   // Strip out javascript
            '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
            '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
            '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments
        );

        $output = preg_replace($search, '', $input);
        return $output;
    }

    function sanitize($input) {
        if (is_array($input)) {
            foreach($input as $var=>$val) {
                $output[$var] = sanitize($val);
            }
        }
        else {
            if (get_magic_quotes_gpc()) {
                $input = stripslashes($input);
            }
            $conn = mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
            $input  = cleanInput($input);
            $output = mysqli_real_escape_string($conn,$input);
        }
        return $output;
    }

    function linkify($linkdata) {
        $linkified = explode("|",$linkdata);
        foreach ($linkified as $link) {
            $link = "<a href=$link target='_blank'>".$link."</a>";
            echo $link." | ";
        }
        //return $linkified;
    }

    function chk($var1, $var2) {
        if (strrpos($var1, $var2) !== false) {
            return "checked";
        }
    }

?>