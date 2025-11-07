<?php
    include_once('../../../../config/all.php');

    if( !ChkLogin() ) {
        echo json_encode(array(
            "status"=>"no",
            "message"=>"Session การเข้าสู่ระบบหมดอายุ กรุณาเข้าสู่ระบบใหม่อีกครั้ง"
        ));
        exit();
    }

    $service_booking_id = trim( $_POST["service_booking_id"] ?? "" );

    // if( $DB->QueryHaving("plan", "plan_name", $field['plan_name']) ) {
    //     echo json_encode(array(
    //         "status"=>false,
    //         "message"=>"ไม่สามารถเพิ่มได้ เนื่องจากคุณระบุชื่อซ้ำกับที่มีอยู่ !!!"
    //     ));
    //     exit();
    // }
    $rs = $DB->QueryUpdate("service_booking", [
        "status"=>"5",
        "edit_by"=>$_SESSION["tnkj_staff"]["username"],
        "edit_when"=>date("Y-m-d H:i:s")
    ], "service_booking_id='".$DB->Escape($service_booking_id)."' ");
    if( $rs ) {
        echo json_encode(array(
            "status"=>"ok",
            "message"=>"ลบข้อมูลเสร็จเรียบร้อย"
        ));
    } else {
        echo json_encode(array(
            "status"=>"no",
            "message"=>"ไม่สามารถติดต่อฐานข้อมูลได้ !!!"
        ));
    }
    