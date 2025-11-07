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
        "status"=>"2",
        "edit_by"=>$_SESSION["tnkj_staff"]["username"],
        "edit_when"=>date("Y-m-d H:i:s")
    ], "service_booking_id='".$DB->Escape($service_booking_id)."' ");
    if( $rs ) {

        // Insert Timeline
        $DB->QueryInsert("service_booking_timeline", [
            "service_booking_timeline_id"=>$DB->QueryMaxid("service_booking_timeline", "service_booking_timeline_id"),
            "service_booking_id"=>$service_booking_id,
            "timeline_desc"=>'รับเรื่องการขอใช้บริการแล้ว',
            "add_by"=>$_SESSION["tnkj_staff"]["username"],
            "add_when"=>date("Y-m-d H:i:s"),
        ]);


        echo json_encode(array(
            "status"=>"ok",
            "message"=>"รับเรื่องเรียบร้อย"
        ));
    } else {
        echo json_encode(array(
            "status"=>"no",
            "message"=>"ไม่สามารถติดต่อฐานข้อมูลได้ !!!"
        ));
    }
    