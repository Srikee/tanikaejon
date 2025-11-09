<?php
    include_once('../../../../config/all.php');

    if( !ChkLogin() ) {
        echo json_encode(array(
            "status"=>"no",
            "message"=>"Session การเข้าสู่ระบบหมดอายุ กรุณาเข้าสู่ระบบใหม่อีกครั้ง"
        ));
        exit();
    }

    $provider_id = trim($_POST["provider_id"] ?? "");
    $field = array(
        "provider_name"=>trim($_POST["provider_name"] ?? ""),
        "provider_sname"=>trim($_POST["provider_sname"] ?? ""),
        "card_id"=>trim($_POST["card_id"] ?? ""),
        "phone"=>trim($_POST["phone"] ?? ""),
        "address"=>trim($_POST["address"] ?? ""),
        "province_id"=>trim($_POST["province_id"] ?? ""),
        "amphur_id"=>trim($_POST["amphur_id"] ?? ""),
        "tambol_id"=>trim($_POST["tambol_id"] ?? ""),
        "zipcode"=>trim($_POST["zipcode"] ?? ""),
        "occupation_id"=>trim($_POST["occupation_id"] ?? ""),
        "status"=>trim($_POST["status"] ?? ""),
        "edit_by"=>$_SESSION["tnkj_staff"]["username"],
        "edit_when"=>date("Y-m-d H:i:s")
    );

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

    $sql = "SELECT * FROM provider WHERE card_id='".$DB->Escape($field['card_id'])."' AND provider_id!='".$DB->Escape($provider_id)."' ";
    $obj = $DB->QueryObj($sql);
    if( count($obj) > 0 ) {
        echo json_encode(array(
            "status"=>"no",
            "message"=>'ไม่สามารถแก้ไขได้ เนื่องจากคุณระบุ "เลขบัตรประชาชน" ซ้ำกับที่มีอยู่'
        ));
        exit();
    }
    
    if( $DB->QueryUpdate("provider", $field, "provider_id='".$DB->Escape($provider_id)."'") ) {
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
    