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
    $changepass = trim( $_POST["changepass"] ?? "" );
    $password1 = trim( $_POST["password1"] ?? "" );
    $password2 = trim( $_POST["password2"] ?? "" );
    
    $field = array(
        "staff_name"=>trim($_POST["staff_name"] ?? ""),
        "staff_sname"=>trim($_POST["staff_sname"] ?? ""),
        "username"=>trim($_POST["username"] ?? ""),
        "status"=>trim($_POST["status"] ?? ""),
        "edit_by"=>$_SESSION["tnkj_staff"]["username"],
        "edit_when"=>date("Y-m-d H:i:s")
    );

    if( $changepass=="Y" ) {
        if( $password1 == "" ) {
            echo json_encode(array(
                "status"=>"no",
                "message"=>"รหัสผ่านว่างเปล่า"
            ));
            exit();
        }
        if( $password1 != $password2 ) {
            echo json_encode(array(
                "status"=>"no",
                "message"=>"ยืนยันรหัสผ่านไม่ถูกต้อง"
            ));
            exit();
        }
        $field["password"] = $password2;
    }

    $skips = [];
    foreach($field as $k=>$f) {
        if( in_array($k, $skips) ) continue;
        $field[$k] = trim($f);
        if($field[$k]=="") {
            echo json_encode(array(
                "status"=>"no",
                "message"=>"กรุณาระบุข้อมูลให้ครบถ้วน -> ".$k." ว่าง"
            ));
            exit();
        }
    }

    $sql = "SELECT * FROM staff WHERE username='".$DB->Escape($field['username'])."' AND staff_id!='".$DB->Escape($staff_id)."' ";
    $obj = $DB->QueryObj($sql);
    if( count($obj) > 0 ) {
        echo json_encode(array(
            "status"=>"no",
            "message"=>'ไม่สามารถแก้ไขได้ เนื่องจากคุณระบุ "ชื่อผู้ใช้งาน" ซ้ำกับที่มีอยู่'
        ));
        exit();
    }
    
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
    