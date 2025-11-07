<?php
    include_once('../../../../config/all.php');

    if( !ChkLogin() ) {
        echo json_encode(array(
            "status"=>"no",
            "message"=>"Session การเข้าสู่ระบบหมดอายุ กรุณาเข้าสู่ระบบใหม่อีกครั้ง"
        ));
        exit();
    }

    $service_booking_id = trim($_POST["service_booking_id"] ?? "");

    if( $service_booking_id=="" ) {
        echo json_encode(array(
            "status"=>"no",
            "message"=>"กรุณากรอกข้อมูลให้ครบถ้วน"
        ));
        exit();
    }

    $sql = "
        SELECT
            sb.*,
            c.customer_name,
            c.customer_sname
        FROM service_booking sb
            LEFT JOIN customer c ON c.customer_id=sb.customer_id
        WHERE sb.service_booking_id='".$DB->Escape($service_booking_id)."'
    ";
    $data = $DB->QueryFirst($sql);
    if($data==null) {
        echo json_encode(array(
            "status"=>"no",
            "message"=>"No Data"
        ));
        exit();
    }
    $service_booking_id = $data["service_booking_id"];

    $rs = $DB->QueryUpdate("service_booking", [
        "status"=>"3",
        "edit_by"=>$_SESSION["tnkj_staff"]["username"],
        "edit_when"=>date("Y-m-d H:i:s")
    ], " service_booking_id='".$service_booking_id."' ");
    if( $rs ) {

        // Insert Timeline
        $service_booking_timeline_id = $DB->QueryMaxid("service_booking_timeline", "service_booking_timeline_id");
        $rs = $DB->QueryInsert("service_booking_timeline", [
            "service_booking_timeline_id"=>$service_booking_timeline_id,
            "service_booking_id"=>$service_booking_id,
            "timeline_desc"=>"ดำเนินการเสร็จเรียบร้อยแล้ว",
            "add_by"=>$_SESSION["tnkj_staff"]["username"],
            "add_when"=>date("Y-m-d H:i:s"),
        ]);
        echo json_encode(array(
            "status"=>"ok",
            "message"=>'บันทึกดำเนินการเสร็จแล้ว'
        ));
    } else {
        echo json_encode(array(
            "status"=>"no",
            "message"=>"ไม่สามารถติดต่อฐานข้อมูลได้ !!!"
        ));
    }