<?php
    include_once('../../../../config/all.php');

    if( !ChkLogin() ) {
        echo json_encode(array(
            "status"=>"no",
            "message"=>"Session การเข้าสู่ระบบหมดอายุ กรุณาเข้าสู่ระบบใหม่อีกครั้ง"
        ));
        exit();
    }

    $service_id = $_POST["service_id"] ?? "";
    $field = array(
        "service_name"=>$_POST["service_name"] ?? "",
        "service_desc"=>$_POST["service_desc"] ?? "",
        "add_by"=>$_SESSION["tnkj_staff"]["username"],
        "add_when"=>date("Y-m-d H:i:s"),
        "edit_by"=>$_SESSION["tnkj_staff"]["username"],
        "edit_when"=>date("Y-m-d H:i:s")
    );

    $sql = "SELECT * FROM service WHERE service_name='".$DB->Escape($field['service_name'])."' AND service_id!='".$DB->Escape($service_id)."' ";
    $obj = $DB->QueryObj($sql);
    if( count($obj) > 0 ) {
        echo json_encode(array(
            "status"=>"no",
            "message"=>'ไม่สามารถแก้ไขได้ เนื่องจากคุณระบุ "การบริการ" ซ้ำกับที่มีอยู่'
        ));
        exit();
    }
    
    if( $DB->QueryUpdate("service", $field, "service_id='".$service_id."'") ) {
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
    