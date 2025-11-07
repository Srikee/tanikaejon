<?php
    session_start();

    date_default_timezone_set("Asia/Bangkok");
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    include_once("class.database.php");
    include_once("class.kscryption.php");
    include_once("func.php");
    include_once("variant.php");

    
    $VERSION = "1.0.29";

    if( $_SERVER["HTTP_HOST"]=="tanikaejon.com" ) {
        $MODE = "production";
        $host = "localhost";
        $user = "tanikaej_db";
        $pass = "48HzZWCJnpLSfgBRdJbk";
        $dbname = "tanikaej_db";
        $DB = new Database($host, $user, $pass, $dbname);
    } else {
        $MODE = "developer";
        $host = "localhost";
        $user = "root";
        $pass = "";
        $dbname = "db_kaejon";
        $DB = new Database($host, $user, $pass, $dbname);
    }