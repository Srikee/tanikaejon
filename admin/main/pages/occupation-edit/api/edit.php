<?php
    include_once('../../../../config/all.php');

    if( !ChkLogin() ) {
        echo json_encode(array(
            "status"=>"no",
            "message"=>"Session การเข้าสู่ระบบหมดอายุ กรุณาเข้าสู่ระบบใหม่อีกครั้ง"
        ));
        exit();
    }

    $occupation_id = $_POST["occupation_id"] ?? "";
    $field = array(
        "occupation_name"=>$_POST["occupation_name"] ?? "",
        "add_by"=>$_SESSION["tnkj_staff"]["username"],
        "add_when"=>date("Y-m-d H:i:s"),
        "edit_by"=>$_SESSION["tnkj_staff"]["username"],
        "edit_when"=>date("Y-m-d H:i:s")
    );

    $sql = "SELECT * FROM occupation WHERE occupation_name='".$DB->Escape($field['occupation_name'])."' AND occupation_id!='".$DB->Escape($occupation_id)."' ";
    $obj = $DB->QueryObj($sql);
    if( count($obj) > 0 ) {
        echo json_encode(array(
            "status"=>"no",
            "message"=>'ไม่สามารถแก้ไขได้ เนื่องจากคุณระบุ "อาชีพ" ซ้ำกับที่มีอยู่'
        ));
        exit();
    }
    
    if( $DB->QueryUpdate("occupation", $field, "occupation_id='".$occupation_id."'") ) {
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
    