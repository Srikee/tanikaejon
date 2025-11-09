<?php
    include_once('../../../../config/all.php');

    if( !ChkLogin() ) {
        echo json_encode(array(
            "status"=>"no",
            "message"=>"Session การเข้าสู่ระบบหมดอายุ กรุณาเข้าสู่ระบบใหม่อีกครั้ง"
        ));
        exit();
    }

    $field = array(
        "service_name"=>$_POST["service_name"] ?? "",
        "service_desc"=>$_POST["service_desc"] ?? "",
        "status"=>$_POST["status"] ?? "",
        "add_by"=>$_SESSION["tnkj_staff"]["username"],
        "add_when"=>date("Y-m-d H:i:s"),
        "edit_by"=>$_SESSION["tnkj_staff"]["username"],
        "edit_when"=>date("Y-m-d H:i:s")
    );

    $sql = "SELECT * FROM service WHERE service_name='".$DB->Escape($field['service_name'])."' ";
    $obj = $DB->QueryObj($sql);
    if( count($obj) > 0 ) {
        echo json_encode(array(
            "status"=>"no",
            "message"=>'ไม่สามารถเพิ่มได้ เนื่องจากคุณระบุ "การบริการ" ซ้ำกับที่มีอยู่'
        ));
        exit();
    }
    
    $field["service_id"] = $DB->QueryMaxId("service", "service_id");
    if( $DB->QueryInsert("service", $field) ) {
        echo json_encode(array(
            "status"=>"ok",
            "message"=>"เพิ่มข้อมูลเสร็จเรียบร้อย"
        ));
    } else {
        echo json_encode(array(
            "status"=>"no",
            "message"=>"ไม่สามารถติดต่อฐานข้อมูลได้ !!!"
        ));
    }
    