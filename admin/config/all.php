<?php
    session_start();

    date_default_timezone_set("Asia/Bangkok");
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    if( $_SERVER["HTTP_HOST"]=="tanikaejon.com" ) {
        $MODE = "production";
        $host = "localhost";
        $user = "tanikaej_db";
        $pass = "48HzZWCJnpLSfgBRdJbk";
        $dbname = "tanikaej_db";
        $CLIENT_ROOT = "/admin/";
        $SERVER_ROOT = "/home/tanikaej/domains/tanikaejon.com/private_html/admin/";
    } else {
        $MODE = "developer";
        $host = "localhost";
        $user = "root";
        $pass = "";
        $dbname = "db_kaejon";
        $CLIENT_ROOT = "/tanikaejon/admin/";
        // $SERVER_ROOT = "D:/Server/tanikaejon/admin/";
        $SERVER_ROOT = "C:/Users/MSI_PC/Dropbox/Server/tanikaejon/admin/";
    }

    include_once($SERVER_ROOT."../config/class.database.php");
    include_once($SERVER_ROOT."../config/class.kscryption.php");
    include_once($SERVER_ROOT."../config/func.php");
    include_once($SERVER_ROOT."../config/variant.php");

    $VERSION = "1.0.8";

    $DB = new Database($host, $user, $pass, $dbname);

    $SHOW = 100;
    $PAGE_SHOW = 7;
    
    function ChkLogin() {
        if( 
            @$_SESSION['tnkj_staff']['staff_id']!="" 
            || @$_SESSION['tnkj_staff']['username']!="" 
        ) return true;
        return false;
    }