<?php
    include_once('../../../../config/all.php');

    if( !ChkLogin() ) {
        echo json_encode(array(
            "status"=>"no",
            "message"=>"Session การเข้าสู่ระบบหมดอายุ กรุณาเข้าสู่ระบบใหม่อีกครั้ง"
        ));
        exit();
    }

    $staff_id = trim($_POST["staff_id"] ?? "");
    $password1 = trim($_POST["password1"] ?? "");
    $password2 = trim($_POST["password2"] ?? "");
    $password3 = trim($_POST["password3"] ?? "");
    

    if($staff_id=="" || $password1=="" || $password2=="" || $password3=="") {
        echo json_encode(array(
            "status"=>"no",
            "message"=>"กรุณาระบุข้อมูลให้ครบถ้วน"
        ));
        exit();
    }

    if( $password2 != $password3 ) {
        echo json_encode(array(
            "status"=>"no",
            "message"=>"ยืนยันรหัสผ่านไม่ถูกต้อง"
        ));
        exit();
    }

    $sql = "SELECT * FROM staff WHERE staff_id='".$DB->Escape($staff_id)."' ";
    $staff = $DB->QueryFirst($sql);
    if( $staff==null ) {
        echo json_encode(array(
            "status"=>"no",
            "message"=>'ไม่พบข้อมูล'
        ));
        exit();
    }
    if( $staff["password"]!=$password1 ) {
        echo json_encode(array(
            "status"=>"no",
            "message"=>'รหัสผ่านเดิมไม่ถูกต้อง'
        ));
        exit();
    }
    
    $field = array(
        "password"=>$password3,
        "edit_by"=>$_SESSION["tnkj_staff"]["username"],
        "edit_when"=>date("Y-m-d H:i:s")
    );
    if( $DB->QueryUpdate("staff", $field, "staff_id='".$DB->Escape($staff_id)."'") ) {
        echo json_encode(array(
            "status"=>"ok",
            "message"=>"แก้ไขข้อมูลเสร็จเรียบร้อย"
        ));
    } else {
        echo json_encode(array(
            "status"=>"no",
            "message"=>"ไม่สามารถติดต่อฐานข้อมูลได้ !!!"
        ));
    }
    