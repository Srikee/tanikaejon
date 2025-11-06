<?php
    session_start();

    date_default_timezone_set("Asia/Bangkok");
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    include_once("class.database.php");
    include_once("class.kscryption.php");
    include_once("func.php");

    
    $VERSION = "1.0.23";

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
    //สถานะ 1: รอดำเนินการ, 2: กำลังดำเนินการ, 3: เสร็จสิ้น, 4: ยกเลิก
    $StatusServiceBooking = [
        "1"=>'<span class="text-warning"><i class="fas fa-alarm-clock me-1"></i> รอดำเนินการ</span>',
        "2"=>'<span class="text-info"><i class="fas fa-clock me-1"></i> กำลังดำเนินการ</span>',
        "3"=>'<span class="text-success"><i class="fas fa-circle-check me-1"></i> เสร็จสิ้น</span>',
        "4"=>'<span class="text-danger"><i class="fas fa-times me-1"></i> ยกเลิก</span>'
    ];