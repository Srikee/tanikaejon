<?php
    include_once('../../../../config/all.php');

    if( !ChkLogin() ) {
        echo json_encode(array(
            "status"=>"no",
            "message"=>"Session การเข้าสู่ระบบหมดอายุ กรุณาเข้าสู่ระบบใหม่อีกครั้ง"
        ));
        exit();
    }

    $service_booking_id = $_POST["service_booking_id"] ?? "";

    // if( $DB->QueryHaving("plan", "plan_name", $field['plan_name']) ) {
    //     echo json_encode(array(
    //         "status"=>false,
    //         "message"=>"ไม่สามารถเพิ่มได้ เนื่องจากคุณระบุชื่อซ้ำกับที่มีอยู่ !!!"
    //     ));
    //     exit();
    // }

    if( $DB->QueryDelete("service_booking", "service_booking_id='".$DB->Escape($service_booking_id)."' ") ) {

        $DB->QueryDelete("service_booking_review", "service_booking_id='".$DB->Escape($service_booking_id)."' ");
        $DB->QueryDelete("service_booking_timeline", "service_booking_id='".$DB->Escape($service_booking_id)."' ");

        $dir = "files/service_booking/".$service_booking_id."/";
        $options = array(
            "dir"   => $SERVER_ROOT."../".$dir
        );
        Func::RemoveDir($options);

        $dir = "files/service_booking_review/".$service_booking_id."/";
        $options = array(
            "dir"   => $SERVER_ROOT."../".$dir
        );
        Func::RemoveDir($options);

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
    